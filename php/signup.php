
<?php

    include "conexion_be.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
   /*  //Encriptamiento de contraseña
    $password = hash('sha512', $password); */
    // Consulta SQL para insertar el usuario en la base de datos
    $query = "INSERT INTO users (nombre, email, password) VALUES ('$username', '$email', '$password')";



    //Verificamos el correo para que no se repita
    $consulta_correo = "SELECT * FROM users WHERE email = '$email'";
    $verificar_correo = $db->query($consulta_correo);
    if ($verificar_correo->rowCount()>0) {
        echo "
            <script>
                alert('Este correo ya esta registrado, intenta con otro diferente');
                window.location = '../components/singup.html';
            </script>
        ";
        exit();
    }

    //Verificamos el correo para que no se repita
    $consulta_usuario = "SELECT * FROM users WHERE nombre = '$username'";
    $verificar_usuario = $db->query($consulta_usuario);
    if ($verificar_usuario->rowCount()>0) {
        echo "
            <script>
                alert('Este usuraio ya esta registrado, intenta con otro diferente');
                window.location = '../components/singup.html';
            </script>
        ";
        exit();
    }

    $ejecutar = $db->query($query);

    if($ejecutar){
        echo "
            <script>
                alert('Usuario almacenado exitosamente');
                window.location = '../components/login.html';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Intentalo de nuevo');
                window.location = '../components/singup.html';
            </script>
        ";
    }
}
?>
