<?php

    include 'conexion_be.php';

    $username = $_POST["username"];
    $password = $_POST["password"];


    // Consulta SQL para buscar al usuario por nombre de usuario
    $consulta_validacion = "SELECT password FROM users WHERE nombre = '$username' AND password = '$password'";
    $validar_login = $db->query($consulta_validacion);

    if ($validar_login->rowCount() > 0 ) {
        session_start();
        $_SESSION['usuario'] = $username;
        $directorio = "../uploaps/";
        $carpeta = scandir($directorio);
        foreach ($carpeta as $archivos) {
            if($archivos !== $username){
                $rule = true;
            } else {
                $rule = false;
            }
        }
        if ($rule) {
                $ruta = "../uploaps/$username";
                mkdir($ruta, 0777);
        }
        header('location: ../index.php');
    } else {
        echo "
        <script>
            alert('Ese usuario no existe');
            window.location = '../components/login.html';
        </script>
        ";
    }

?>
