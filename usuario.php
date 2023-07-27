<!-- 
    Importante, este archivo se debe eliminar en produccion.
    Este archivo ingresara un usuario de forma manual a la bd, con un password hasheado.
-->



<?php

    require 'includes/app.php';
    $db = conectarDB();

    $email = "correo@correo.com";
    $password = "123456";

    //Hasheando password
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO usuarios (email, password) VALUES ('{$email}', '{$passwordHash}');";

    mysqli_query($db, $query);


    exit;