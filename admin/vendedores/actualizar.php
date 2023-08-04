<?php
    require '../../includes/app.php';
    use App\Vendedor;
    estadoAutenticado();

    // Validar la URL por ID válido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    //Validando que exista un ID
    if(!$id) {
        header('Location: /admin');
    }

    // Obtener los datos del vendedor a editar...
    $vendedor = Vendedor::find($id);

    //Arreglo con errores
    $errores = Vendedor::getErrores();

    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Asignar los atributos
        $args = $_POST['vendedor'];
        $vendedor->sincronizar($args);

        // Validación
        $errores = $vendedor->validar();
       

        if(empty($errores)) {
            $vendedor->guardar();
        }
    }

    incluirTemplate('header');
?>


<main class="contenedor seccion">
        <h1>Actualizar Vendedor(a)</h1>

        <a href="/admin" class="boton boton-verde">Volver</a>

        <?php foreach ($errores AS $error) : ?>
            <div class="alerta error" >
                <?php echo $error ?>    
            </div>
        <?php endforeach; ?>

        <form class="formulario" method="POST">
            
            <?php include '../../includes/templates/formulario_vendedores.php'; ?>
            <input type="submit" value="Actualizar Vendedor" class="boton boton-verde">

        </form>

    </main>

<?php
    incluirTemplate('footer');
?>