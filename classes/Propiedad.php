<?php   
    namespace App;

class Propiedad {

    //Base de datos
    protected static $db;
    protected static $columnasDB = ['id','titulo','precio','imagen','descripcion','habitaciones','wc','estacionamiento','creado','vendedores_id'];

    //Errores
    protected static $errores = [];

    //Atributos
    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion; 
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedores_id;

    //Definir la conexion a la base de datos
    public static function setDB($database){
        self::$db = $database;
    }

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedores_id = $args['vendedores_id'] ?? 1;
    }

    public function guardar(){
        if(!is_null($this->id)) {
            //Actualizando
            $this->actualizar();
        }else{
            //Creando nuevo registro
            $this->crear();
        }
    }
        
    public function crear(){
        //Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        //Consulta SQL
        $query  = "INSERT INTO propiedades ( ";
        $query .= join(', ', array_keys( $atributos ));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values( $atributos ));
        $query .= " ')";

        $resultado = self::$db->query($query);

        // Mensaje de exito - error
        if ($resultado){
            header("Location: /admin?resultado=1");
        }
    }

    public function actualizar(){
        //Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        $valores = [];
        foreach($atributos as $key => $value){
            $valores[] = "{$key}='{$value}'";
        }

        $query  = "UPDATE propiedades SET ";
        $query .= join(', ', $valores );
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";

        $resultado = self::$db->query($query);
        
        if ($resultado){
            //$this->borrarImagen();
            header("Location: /admin?resultado=2");
        }           

    }

    public function eliminar(){
        $query = "DELETE FROM propiedades WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);

        if($resultado){
            $this->borrarImagen();
            header('location: /admin?resultado=3');
        }
    }

    public function atributos(){
        $atributos = [];
        foreach(self::$columnasDB AS $columna){
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }

        return $atributos;
    }

    public function borrarImagen(){
         //Cmoprobar si existe el archivo
         $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);

         if( $existeArchivo ){
             unlink(CARPETA_IMAGENES . $this->imagen);
         }
    }

    public function setImagen($imagen){
        //Elimina la imagen anterior
        if(!is_null($this->id) ){
           $this->borrarImagen();
        }

        //Asignar al atributo de la imagen, el nombre de la imagen
        if($imagen){
            $this->imagen = $imagen;
        }
    }

    public function sanitizarAtributos(){
        $atributos = $this->atributos();
        $sanitizado = [];

        foreach($atributos AS $key => $value){
            $sanitizado[$key] = self::$db->escape_string($value);
        }

        return $sanitizado;
    }

    public static function getErrores(){
        return self::$errores;
    }

    public function validar(){
        if (!$this->titulo){
            self::$errores[] = "Debes añadir un titulo";
        }

        if (!$this->precio){
            self::$errores[] = "El precio es obligatorio";
        }

        if( strlen( $this->descripcion < 50 ) ){
            self::$errores[] = "La descripcion de la propiedad es obligatoria, debe tener al menos 50 caracteres.";
        }

        if (!$this->habitaciones){
            self::$errores[] = "Debe ingresar la cantidad de habitaciones";
        }

        if (!$this->wc){
            self::$errores[] = "Debe ingresar la cantidad de wc";
        }

        if (!$this->estacionamiento){
            self::$errores[] = "Debe ingresar la cantidad de estacionamientos";
        }

        if (!$this->vendedores_id){
            self::$errores[] = "Debe elegir un vendedor";
        }

        if(!$this->imagen){
            self::$errores[] = "La imagen es obligatoria";
        }

        return self::$errores;
    }

    public static function all(){
        $query = "SELECT * FROM propiedades";
        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    public static function find($id){
        $query = "SELECT * FROM propiedades WHERE id={$id}";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    public static function consultarSQL($query){
        // Consultas la base de datos
        $resultado = self::$db->query($query);

        // Iteracion de los resultados
        $array = [];
        while( $registro = $resultado->fetch_assoc() ){
            $array[] = self::crearObjeto($registro);
        }
        
        // Liberar memoria
        $resultado->free();

        // Retornar los resultados
        return $array;
    }

    protected static function crearObjeto($registro){
        $objeto = new self;

        foreach($registro AS $key => $value){
            if ( property_exists( $objeto, $key ) ){
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }

    // Sincronizar el objeto en memoria con los cambios realizados por el usuario
    public function sincronizar( $args = [] ){
        foreach($args AS $key => $value){
            if(property_exists($this, $key) && !is_null($value) ){
                $this->$key = $value;
            }
        }
    }
}