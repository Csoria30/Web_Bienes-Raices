<?php

    require '../../includes/app.php';

    use App\Propiedad;
    use App\Vendedor;
    use Intervention\Image\ImageManagerStatic as Image;
    
    estadoAutenticado();

    //Validar ID valido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if ( !$id ){
        header('Location: /admin');
    }

    //Obtener los datos de la propiedad
    $propiedad = Propiedad::find($id);

    //Consulta para obtener todos los vendedores
    $vendedores = Vendedor::all();

    //Arreglo de errores
    $errores = Propiedad::getErrores();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' ){

        $args = $_POST['propiedad'];
        $propiedad->sincronizar($args);

        //Validacion
        $errores = $propiedad->validar();

        /* Generar nombre unico */
        $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";

        //Subida de archivos
        if ( $_FILES['propiedad']['tmp_name']['imagen'] ){
            //realiza un resize a la imagen con intervetion
            $imagen = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
            $propiedad->setImagen($nombreImagen);
        }

        if( empty( $errores ) ){
            //Almacenar la imagen
            if ( $_FILES['propiedad']['tmp_name']['imagen'] ){
                $imagen->save(CARPETA_IMAGENES . $nombreImagen);
            }
                
                $propiedad->guardar();
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

            <?php include '../../includes/templates/formulario_propiedades.php'; ?>
            <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">

        </form>

    </main>

<?php
    incluirTemplate('footer');
?>