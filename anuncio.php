<?php
    require 'includes/app.php';
    use App\Propiedad;

    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id){
        header('location: /');
    }

    $propiedad = Propiedad::find($id);

    incluirTemplate('header');
?>

    <main class="contenedor seccion contenido-centrado">
        <h1><?php echo $propiedad->titulo; ?></h1>
        
        <img loading="lazy" src="/imagenes/<?php echo $propiedad->imagen ?>" alt="Anuncio">

        <div class="resumen-propiedad">
            <p class="precio">$<?php echo $propiedad->precio; ?></p>

            <ul class="iconos-caracteristicas">
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="Icono wc">
                    <p><?php echo $propiedad->wc; ?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="Icono Estacionamiento">
                    <p><?php echo $propiedad->estacionamiento; ?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="Icono Dormitorio">
                    <p><?php echo $propiedad->habitaciones; ?></p>
                </li>
            </ul>

            <p><?php echo $propiedad->descripcion; ?></p>

        </div>
    </main>

<?php
    incluirTemplate('footer');
    mysqli_close($db);
?>

