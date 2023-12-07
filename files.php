<?php
    session_start();
    if(!isset($_SESSION['usuario'])){
        echo '
            <script>
                alert("Por favor debes iniciar sesión");
                window.location = "./php/sing-login.php";
            </script>
        ';
        //header("location: ../php/sing-login.php");
        session_destroy();
        die();
    }

    $user = $_SESSION["usuario"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/styles.css">
    <title>Nube</title>
</head>
<body>
    <div id="header-container"></div>
    <div class="section">
        <h2 class="files_h2">Tus archivos subidos </h2>
    </div>

    <div class="caja">
    <?php

        $directorio = "./uploaps/$user/";
        $archivos = scandir($directorio);
                if (isset($_GET['folder'])) {
                    $archivo = $_GET['folder'] . "/";
                    $directorioActual = $archivo;
                } else {
                    $directorioActual = $directorio;
                }
        
                echo "<div class='rutas'><form method='post'><input type='submit' value='&#129045;'></form><p><strong>Ruta Actual:</strong> $directorioActual</p></div>";
        
                mostrarContenido($directorioActual);

        function mostrarContenido($directorio = "./uploaps/"){
            $archivos = scandir($directorio);

            foreach ($archivos as $archivo) {
                if ($archivo != "." && $archivo != "..") {
                    $rutaCompleta = $directorio . $archivo;
                    $tamano = filesize($rutaCompleta);
                    $fechaModificacion = date("d-m-Y H:i:s", filemtime($rutaCompleta));

                    if(is_dir($rutaCompleta)){ // si son carpetas
                        echo "<ul class='files_lista'>";
                        echo "<li>";
                        echo "<strong>Nombre:</strong> <a href='?folder=$rutaCompleta'><b>$archivo</b></a><br>";
                        echo "<strong>Tamaño:</strong> " . formatBytes($tamano) . "<br>";
                        echo "<strong>Fecha de Modificación:</strong> $fechaModificacion";
                        echo "<form method='post' onsubmit='return confirm(\"¿Estás seguro de que deseas eliminar este archivo?\")'>
                                <input type='hidden' name='deleteFile' value='$rutaCompleta'>
                                <button type='submit' class='delete-btn'><b>Eliminar</b></button>
                            </form>";
                        echo "</li>";
                        echo "</ul>";
                    } else {// si son archivos 
                        echo "<ul class='files_lista'>";
                        echo "<li>";
                        echo "<strong>Nombre:</strong> <a href='$rutaCompleta'><b>$archivo</b></a><br>";
                        echo "<strong>Tamaño:</strong> " . formatBytes($tamano) . "<br>";
                        echo "<strong>Fecha de Modificación:</strong> $fechaModificacion";
                        echo "<form method='post' onsubmit='return confirm(\"¿Estás seguro de que deseas eliminar este archivo?\")'>
                                <input type='hidden' name='deleteFile' value='$rutaCompleta'>
                                <button type='submit' class='delete-btn'><b>Eliminar</b></button>
                            </form>";
                        echo "</li>";
                        echo "</ul>";
                    }
                }
            }
        }

        function formatBytes($bytes, $precision = 2) {
            $units = array("B", "KB", "MB", "GB", "TB");
            $bytes = max($bytes, 0);
            $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
            $pow = min($pow, count($units) - 1);
            $bytes /= (1 << (10 * $pow));
            return round($bytes, $precision) . " " . $units[$pow];
        }
        ?>

    <div class="formularios">

    <form action="" method="post" style="margin-left: 1%;">
        <label for="">Escriba el nombre del archivo:</label>
        <input type="text" name="archivo">
        <label for="">Escriba el contenido del archivo:</label>
        <textarea name="contenido" id="" cols="30" rows="10"></textarea>
        <input type="submit" value="Añadir archivo">
    </form>

    <form action="" method="post">
    <label for="">Escriba el nombre de la capeta:</label>
        <input type="text" name="carpeta">
        <input type="submit" value="Añadir carpeta">
    </form>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if(isset($_POST["archivo"]) && isset($_POST["contenido"])){
                if(empty($_POST["archivo"]) == false){
                    if(empty($_POST["contenido"]) == false){
                        $carpeta = scandir($directorio);
                        foreach ($carpeta as $archivos) {
                            if($archivos == $_POST["archivo"]){
                                $rule = true;
                            } else {
                                $rule = false;
                            }
                        }
                        if ($rule) {
                            echo "<script>confirm(\"¿Este archibo ya esiste quieres reescirvilo?\");</script>";
                        }
                        $res = file_put_contents($directorioActual . $_POST["archivo"], $_POST["contenido"]);
                        
                    } else {
                        $mensaje = "Completa todos los campos para crear el archivo";
                    }
                } else {
                    $mensaje = "Completa todos los campos para crear el archivo";
                }
            } else if (isset($_POST["deleteFile"])) {
                $fileToDelete = $_POST["deleteFile"];
                if (is_file($fileToDelete)) {
                    unlink($fileToDelete);
                    if(isset($_GET['folder'])){
                        $direc = $_GET['folder'];
                        header("Location: ./files.php?folder=$direc");
                    } else {
                        header("Location: ./files.php");
                    }
                } else if (is_dir($fileToDelete)) {
                    rmdir($fileToDelete);
                    if(isset($_GET['folder'])){
                        $direc = $_GET['folder'];
                        header("Location: ./files.php?folder=$direc");
                    } else {
                        header("Location: ./files.php");
                    }
                }
            } else if(isset($_POST["carpeta"])){
                if(empty($_POST["carpeta"]) == false){
                    $ruta = $directorioActual;
                    $nuevaCarpeta = $_POST["carpeta"];
                    $rutaNuevaCarpeta = $ruta . $nuevaCarpeta;
                    $carpeta = scandir($ruta);
                    foreach ($carpeta as $archivos) {
                        if($archivos == $nuevaCarpeta){
                            $rule = true;
                        } else {
                            $rule = false;
                        }
                    }
                    if ($rule) {
                        $mensaje = "Esta carpeta ya existe";
                    } else {
                        mkdir($rutaNuevaCarpeta, 0777);
                        if(isset($_GET['folder'])){
                            $direc = $_GET['folder'];
                            header("Location: ./files.php?folder=$direc");
                        } else {
                            header("Location: ./files.php");
                        }
                    }
                    
                } else {
                    $mensaje = "Completa todos los campos para crear la carpeta";
                }
            }
        }
        
    ?>

    </div>

    <p class="mensaje" style="color: red;"><?php if (isset($mensaje)) {
        echo $mensaje;
    } ?></p>
    
<!-- Añadir botones para ir para atras y poner para poder editar archivos -->

    <script src="./js/header.js"></script>
    <script>
        function deleteFile(filePath) {
            if (confirm("¿Estás seguro de que deseas eliminar este archivo?")) {
                // Realizar la lógica de eliminación aquí, puedes usar AJAX para una experiencia más fluida
                alert("Archivo eliminado: " + filePath);
            }
        }

        function filterTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("filter");
            filter = input.value.toUpperCase();
            table = document.getElementById("fileTable");
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
</body>
</html>