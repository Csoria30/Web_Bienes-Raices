<?php
    require '../../includes/app.php';
    
    use App\Propiedad;
    use Intervention\Image\ImageManagerStatic as Image;
    
    estadoAutenticado(); 

    $db = conectarDB();
    $propiedad = new Propiedad;

    $query_vendedores = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db, $query_vendedores);

    //Arreglo con errores
    $errores = Propiedad::getErrores();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' ){
        /* 
            ! * Crea una nueva instancia de la clase
        */
        $propiedad = new Propiedad($_POST['propiedad']);
        
        /* 
            ! * Subida de archivos
        */

        /* Generar nombre unico */
        $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";

        // Comprobando si existe la imagen
        if ( $_FILES['propiedad']['tmp_name']['imagen'] ){
            //realiza un resize a la imagen con intervetion
            $imagen = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
            $propiedad->setImagen($nombreImagen);
        }

        /* 
            ! * Validacion de errores
        */
        $errores = $propiedad->validar();
        
        if(empty($errores)){
            // Crear la carpeta para subir imagenes
            if(!is_dir(CARPETA_IMAGENES)){
                mkdir(CARPETA_IMAGENES);
            }

            //Guardar la imagen en el servidor
            $imagen->save(CARPETA_IMAGENES . $nombreImagen);

            // Guarda en la base de datos
            $propiedad->guardar();
            
            
            
            
        }
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
            
            <?php include '../../includes/templates/formulario_propiedades.php'; ?>
            <input type="submit" value="Crear Propiedad" class="boton boton-verde">

        </form>

    </main>

<?php
    incluirTemplate('footer');
?>