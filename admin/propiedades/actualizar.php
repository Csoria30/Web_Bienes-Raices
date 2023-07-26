<?php
    require '../../includes/funciones.php';
    $auth = estadoAutenticado();

    if(!$auth){
        header('location: /');
    }

    //Validar ID valido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if ( !$id ){
        header('Location: /admin');
    }

    //Base de datos
    //Importando conexion
    require '../../includes/config/database.php';
    $db = conectarDB();

    //Consulta
    $consultaPropiedades = "SELECT * FROM propiedades WHERE id={$id}";
    $resultado = mysqli_query($db, $consultaPropiedades);
    $propiedad = mysqli_fetch_assoc($resultado);

    $consultaPropiedades = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db, $consultaPropiedades);

    //Arreglo de errores
    $errores = [];

    //Variables globales
    $titulo = $propiedad['titulo'];
    $precio = $propiedad['precio'];
    $descripcion = $propiedad['descripcion'];
    $habitaciones = $propiedad['habitaciones'];
    $wc = $propiedad['wc'];
    $estacionamiento = $propiedad['estacionamiento'];
    $vendedor = $propiedad['vendedores_id'];
    $imagenPropiedad = $propiedad['imagen'];
    

    if ($_SERVER['REQUEST_METHOD'] === 'POST' ){
        $titulo = mysqli_real_escape_string($db, $_POST['titulo']);
        $precio = mysqli_real_escape_string($db, $_POST['precio']);
        $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
        $habitaciones = mysqli_real_escape_string($db, $_POST['habitaciones']);
        $wc = mysqli_real_escape_string($db, $_POST['wc']);
        $estacionamiento = mysqli_real_escape_string($db, $_POST['estacionamiento']);
        $vendedor = mysqli_real_escape_string($db, $_POST['vendedor']);
        $creado = date('Y/m/d');

        $imagen = $_FILES['imagen'];

        if (!$titulo){
            $errores[] = "Debes añadir un titulo";
        }

        if (!$precio){
            $errores[] = "El precio es obligatorio";
        }

        if( strlen( $descripcion < 50 ) ){
            $errores[] = "La descripcion de la propiedad es obligatoria, debe tener al menos 50 caracteres.";
        }

        if (!$habitaciones){
            $errores[] = "Debe ingresar la cantidad de habitaciones";
        }

        if (!$wc){
            $errores[] = "Debe ingresar la cantidad de wc";
        }

        if (!$estacionamiento){
            $errores[] = "Debe ingresar la cantidad de estacionamientos";
        }

        if (!$vendedor){
            $errores[] = "Debe elegir un vendedor";
        }

        $medida = 1000 * 100;

        if($imagen['size'] > $medida){
            $errores[] = "La imagen es muy pasada";
        }

        if(empty($errores)){

            /* Crear Carpeta */
            $carpetaImagenes = '../../imagenes/';
            /* Comprobar si existe */
            if(!is_dir($carpetaImagenes)){
                mkdir($carpetaImagenes);
            }

            //Comprobar si se selecciono una imagen a subir
            $nombreImagen = '';

            /* Imagen Upload */
            if ($imagen['name']){
                //Eliminar imagen previa
                unlink($carpetaImagenes . $propiedad['imagen']);

                /* Generar nombre unico */
                $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";

                /* Subiendo archivo */
                move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen );
            }else{
                $nombreImagen = $propiedad['imagen'];
            }

            
            /* Query */
            $query = "UPDATE propiedades SET titulo = '{$titulo}', precio = '{$precio}', imagen = '{$nombreImagen}', descripcion = '{$descripcion}', habitaciones = {$habitaciones}, wc = {$wc}, estacionamiento = {$estacionamiento}, vendedores_id = {$vendedor} WHERE id = {$id}";

            $resultado = mysqli_query($db, $query);

            if ($resultado){
                header("Location: /admin?resultado=2");
            }           
            
        }
        
    }

    
    incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Actualizar Propiedad</h1>

        <a href="/admin" class="boton boton-verde">Volver</a>

        <?php foreach ($errores AS $error) : ?>
            <div class="alerta error" >
                <?php echo $error ?>    
            </div>
        <?php endforeach; ?>

        <form class="formulario" method="POST" enctype="multipart/form-data">
            <fieldset>
                <legend>Informacion General</legend>

                <label for="titulo">Titulo<label>
                <input type="text" id="titulo" name="titulo" placeholder="Titulo de la propiedad" value="<?php echo $titulo ;?>">

                <label for="precio">Precio<label>
                <input type="number" id="precio" name="precio" placeholder="Precio de la propiedad" value="<?php echo $precio ;?>" >

                <label for="imagen">Imagen<label>
                <input type="file" id="imagen" name="imagen" accept="image/jpeg, image/png">

                <img src="/imagenes/<?php echo $imagenPropiedad ?>" class="imagen-small">

                <label for="descripcion">Descripcion<label>
                <textarea id="descripcion" name="descripcion"><?php echo $descripcion ;?></textarea>
            </fieldset>
            
            <fieldset>
                <legend>Informacion Propiedad</legend>

                <label for="habitaciones">Habitaciones<label>
                <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej: 3" min="1" max="9" value="<?php echo $habitaciones ;?>">

                <label for="wc">Baños<label>
                <input type="number" id="wc" name="wc" placeholder="Ej: 3" min="1" max="9" value="<?php echo $wc ;?>" >

                <label for="estacionamiento">Estacionamiento<label>
                <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej: 3" min="1" max="9" value="<?php echo $estacionamiento ;?>" >
            </fieldset>

            <fieldset>
                <legend>Vendedor</legend>

                <select name="vendedor">
                    <option value="" disabled selected> -- Seleccione un vendedor -- </option>
                    <?php while($row = mysqli_fetch_assoc($resultado) ) : ?>
                        <option <?php echo $vendedor === $row['id'] ? 'selected' : ''; ?> value="<?php echo $row['id'] ?>" ><?php echo $row['nombre'] . " " . $row['apellido'] ?></option>
                    <?php endwhile; ?>
                </select>
            </fieldset>

            <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
        </form>

    </main>

<?php
    incluirTemplate('footer');
?>