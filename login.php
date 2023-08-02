<?php

    require 'includes/app.php';
    $db = conectarDB();

    $errores = [];

    //Autenticar usuario
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $email = mysqli_real_escape_string ( $db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) );
        $password = mysqli_real_escape_string ( $db, $_POST['password'] );

        if (!$email){
            $errores[] = "El email es obligatorio o no es valido";
        }

        if (!$password){
            $errores[] = "El password es obligatorio ";
        }

        if ( empty($errores)){
            //Revisar si el usuario existe
            $query = "SELECT * FROM usuarios WHERE email = '{$email}' ";
            $resultado = mysqli_query($db, $query);

            if($resultado->num_rows){
                //Rivisar si es password es correcto
                $usuario = mysqli_fetch_assoc($resultado);
                $auth = password_verify($password, $usuario['password']);

                if($auth){
                    session_start();

                    //Llenar el arreglo de la sesion
                    $_SESSION['usuario'] = $usuario['email'];
                    $_SESSION['login'] = true;

                    header('location: /admin');

                }else{
                    $errores[] = "El password es incorrecto";    
                }

            }else{
                $errores[] = "El usuario no existe";
            }

        }


    }

    incluirTemplate('header');
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Iniciar Sesion</h1>

        <?php foreach ($errores AS $error) : ?>
            <div class="alerta error" >
                <?php echo $error; ?>    
            </div>
        <?php endforeach; ?>

        <form class="formulario" method="POST">
            <fieldset>
                <legend>Email y Password</legend>

                <label for="email">Email</label>
                <input type="email" placeholder="Ingrese su correo" id="email" name="email" >

                <label for="password">Password</label>
                <input type="password" placeholder="Ingrese su contraseña" id="password" name="password" >

            </fieldset>

            <input type="submit" value="Iniciar Sesion" class="boton boton-verde">
        </form>
    </main>

<?php
    incluirTemplate('footer');
?>