<?php
    require '../../includes/app.php';
    use App\Vendedor;
    estadoAutenticado();

    // Arreglo con mensajes de errores
    $errores = Vendedor::getErrores();
    $vendedor = new Vendedor;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' ){
        //Creando una nueva instancia
        $vendedor = new Vendedor($_POST['vendedor']);
        
        //Validacion de campos no vacios
        $errores = $vendedor->validar();

        //Si no hay errores
        if(empty($errores)){
            $vendedor->guardar();
        }
    }

    incluirTemplate('header');
?>


    <main class="contenedor seccion">
        <h1>Registrar Vendedor(a)</h1>

        <a href="/admin" class="boton boton-verde">Volver</a>

        <?php foreach ($errores AS $error) : ?>
            <div class="alerta error" >
                <?php echo $error ?>    
            </div>
        <?php endforeach; ?>

        <form class="formulario" method="POST">
            
            <?php include '../../includes/templates/formulario_vendedores.php'; ?>
            <input type="submit" value="Registrar Vendedor" class="boton boton-verde">

        </form>

    </main>

<?php
    incluirTemplate('footer');
?>