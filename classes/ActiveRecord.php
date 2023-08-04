<?php

namespace App;

class ActiveRecord {

    //Base de datos
    protected static $db;
    protected static $tabla = '';
    protected static $columnasDB = [];

    public $id;

    //Errores
    protected static $errores = [];

    //Definir la conexion a la base de datos
    public static function setDB($database){
        self::$db = $database;
    }

    public function guardar() {
        if(!is_null($this->id)) {
            // actualizar
            $this->actualizar();
        } else {
            // Creando un nuevo registro
            $this->crear();
        }
    }
        
    public function crear(){
        //Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        //Consulta SQL
        $query  = "INSERT INTO " . static::$tabla . " ( ";
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

        $query  = "UPDATE " . static::$tabla . " SET ";
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
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);

        if($resultado){
            $this->borrarImagen();
            header('location: /admin?resultado=3');
        }
    }

    public function atributos(){
        $atributos = [];
        foreach(static::$columnasDB AS $columna){
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }

        return $atributos;
    }

    // Elimina el archivo
    public function borrarImagen() {
        // Comprobar si existe el archivo
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
        if($existeArchivo) {
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
        return static::$errores;
    }

    public function validar(){
        static::$errores = [];
        return static::$errores;
    }

    public static function all(){
        $query = "SELECT * FROM " . static::$tabla;
        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    //Obtiene determinado numero de registros
    public static function get($cantidad){
        $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $cantidad;
        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    public static function find($id){
        $query = "SELECT * FROM " . static::$tabla . " WHERE id={$id}";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    public static function consultarSQL($query){
        // Consultas la base de datos
        $resultado = self::$db->query($query);

        // Iteracion de los resultados
        $array = [];
        while( $registro = $resultado->fetch_assoc() ){
            $array[] = static::crearObjeto($registro);
        }
        
        // Liberar memoria
        $resultado->free();

        // Retornar los resultados
        return $array;
    }

    protected static function crearObjeto($registro){
        $objeto = new static;

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