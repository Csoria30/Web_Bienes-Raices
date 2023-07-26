<?php
    require '../../includes/funciones.php';
    require '../../includes/config/database.php';

    $auth = estadoAutenticado();

    if(!$auth){
        header('location: /');
    }

    $db = conectarDB();

    $query_vendedores = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db, $query_vendedores);

    $errores = [];

    $titulo = "";
    $precio = "";
    $descripcion = "";
    $habitaciones = "";
    $wc = "";
    $estacionamiento = "";
    $vendedor = "";
    $creado = date('Y/m/d');

    if ($_SERVER['REQUEST_METHOD'] === 'POST' ){
        $titulo = mysqli_real_escape_string($db, $_POST['titulo']);
        $precio = mysqli_real_escape_string($db, $_POST['precio']);
        $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
        $habitaciones = mysqli_real_escape_string($db, $_POST['habitaciones']);
        $wc = mysqli_real_escape_string($db, $_POST['wc']);
        $estacionamiento = mysqli_real_escape_string($db, $_POST['estacionamiento']);
        $vendedor = mysqli_real_escape_string($db, $_POST['vendedor']);

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

        if(!$imagen['name'] || $imagen['error']){
            $errores[] = "La imagen es obligatoria";
        }

        $medida = 1000 * 100;

        if($imagen['size'] > $medida){
            $errores[] = "La imagen es muy pasada";
        }

        if(empty($errores)){
            /* Imagen Upload */

            /* Crear Carpeta */
            $carpetaImagenes = '../../imagenes/';

            /* Comprobar si existe */
            if(!is_dir($carpetaImagenes)){
                mkdir($carpetaImagenes);
            }

            /* Generar nombre unico */
            $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";

            /* Subiendo archivo */
            move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen );
            
            /* Query */
            $query = "INSERT INTO propiedades (titulo, precio, imagen, descripcion, habitaciones, wc, estacionamiento, creado, vendedores_id) VALUES ('$titulo', '$precio', '$nombreImagen', '$descripcion', '$habitaciones', '$wc', '$estacionamiento', '$creado', '$vendedor')";

            $resultado = mysqli_query($db, $query);

            if ($resultado){
                header("Location: /admin?resultado=1");
            }
            
            
        }

      
        /* 
        echo "<pre>";
            var_dump($query);
            exit;
        echo "</pre>";
         */

        
    }

    
    incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Crear Propiedad</h1>

        <a href="/admin" class="boton boton-verde">Volver</a>

        <?php foreach ($errores AS $error) : ?>
            <div class="alerta error" >
                <?php echo $error ?>    
            </div>
        <?php endforeach; ?>

        <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">
            <fieldset>
                <legend>Informacion General</legend>

                <label for="titulo">Titulo<label>
                <input type="text" id="titulo" name="titulo" placeholder="Titulo de la propiedad" value="<?php echo $titulo ;?>">

                <label for="precio">Precio<label>
                <input type="number" id="precio" name="precio" placeholder="Precio de la propiedad" value="<?php echo $precio ;?>" >

                <label for="imagen">Imagen<label>
                <input type="file" id="imagen" name="imagen" accept="image/jpeg, image/png">

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

            <input type="submit" value="Crear Propiedad" class="boton boton-verde">
        </form>

    </main>

<?php
    incluirTemplate('footer');
?>