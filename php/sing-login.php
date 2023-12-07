<?php
    session_start();

    if(isset($_SESSION['usurio'])){
        echo '
            <script>
                alert("La sesion ya esta iniciada");
                window.location = "../index.php";
            </script>
        ';
        //header("location: ../php/sing-login.php");
        session_destroy();
        die();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Página de Inicio</title>
</head>
<body>
    <h1>Bienvenido a Nuestra Aplicación</h1>
    <p>Por favor, seleccione una opción:</p>
    <div class="caja-btn">
        <a href="../components/login.html"><div class="btn inicio-sesion">Iniciar Sesión</div></a>
        <a href="../components/singup.html"><div class="btn crear-cuenta">Crear una Cuenta</div></a>
    </div>

</body>
</html>