<?php
    session_start();
    if(!isset($_SESSION['usuario'])){
        echo '
            <script>
                alert("Por favor debes iniciar sesión");
            </script>
        ';
        header("Location: ./php/sing-login.php");
        session_destroy();
        die();
    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/styles.css">
    <title>Chat</title>
</head>
<body>

<?php $nombre = $_SESSION['usuario']; ?>

<?php
    
        include "./php/conexion_be.php";
        $query = "SELECT nombre FROM users WHERE nombre <> 'ctardior03'";

        $listaUsuarios = $db->query($query);

        if($listaUsuarios->rowCount() > 0){
            while ($fila = $listaUsuarios->fetch()) {
                $arryDeArray[] = $fila; // Agrega la fila actual al array de resultados
            }

            foreach ($arryDeArray as $filas) {
                $resultado[] = $filas['nombre'];
            }

            /* foreach($resultado as $user){
                echo "$user <br>";
            }*/
            /* filas = $resultado; linea 52 */
                $count = count($resultado);
                
            echo    "
                    <script>
                        const listUsers = document.getElementsByClassName('user-list');
                        let filas = [];
                        
                        for (let i = 0; i < $count; i++) {
                            const user = filas;
                            const userElement = document.createElement('div');
                            userElement.classList.add('user');
                        
                            const userImg = document.createElement('img');
                            userImg.src = 'user1.jpg';    
                            userImg.alt = 'Foto de Usuario';
                            
                            const userTag = document.createElement('span');
                            userTag.classList.add('userTag');
                            userTag.textContent = user;
                        
                            userElement.append(userImg);
                            userElement.append(userTag);
                        
                            /* listUsers[i].append(userElement); */
                        }
                    </script>
                    ";
        };
    
    ?>



<script>
<?php echo "let nombre = '$nombre';" ?>
<?php echo "localStorage.setItem('chat-username', '$nombre');" ?>

// Obtener el elemento que contiene los mensajes del chat
const chatMessages = document.getElementById('chat-messages');

// Función para enviar un mensaje
function sendMessage() {
    // Obtener el mensaje del cuadro de entrada
    const message = document.getElementById('message-input').value;
    
    // Verificar si el mensaje no está vacío
    if (message.trim() !== '') {
        // Obtener el nombre del usuario almacenado en localStorage
        const storedUsername = localStorage.getItem('chat-username') || '';
        
        // Crear un elemento para el nuevo mensaje
        const messageElement = document.createElement('div');
        messageElement.classList.add('message');

        // Crear un elemento para la información del usuario
        const userInfo = document.createElement('div');
        userInfo.classList.add('user-info');

        // Crear un elemento para la imagen de perfil
        const userProfileImage = document.createElement('img');
        userProfileImage.src = 'user1.jpg';
        userProfileImage.alt = 'Foto de Usuario';

        // Crear un elemento para el nombre de usuario
        const username = document.createElement('span');
        username.classList.add('username');
        username.innerHTML = storedUsername;

        // Agregar la imagen de perfil y el nombre de usuario al elemento de información del usuario
        userInfo.append(userProfileImage);
        userInfo.append(username);

        // Crear un elemento para el cuadro de mensaje
        const messageBox = document.createElement('div');
        messageBox.classList.add('message-box');
        messageBox.textContent = message;

        // Agregar la información del usuario y el cuadro de mensaje al mensaje completo
        messageElement.append(userInfo);
        messageElement.append(messageBox);

        // Agregar el mensaje completo al chat
        document.getElementById('chat-messages').append(messageElement);

        // Obtener los mensajes almacenados en localStorage o iniciar un array vacío
        const messages = JSON.parse(localStorage.getItem('chat-messages')) || [];

        // Agregar el nuevo mensaje al array de mensajes
        messages.push({ username: storedUsername, message: message });

        // Actualizar el array de mensajes en localStorage
        localStorage.setItem('chat-messages', JSON.stringify(messages));

        // Limpiar el cuadro de entrada después de enviar el mensaje
        const messageInput = document.getElementById("message-input");
        messageInput.value = '';

        // Desplazar el chat hacia abajo para mostrar el nuevo mensaje
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
}

// Evento que se ejecuta al cargar la página
document.addEventListener("DOMContentLoaded", function() {
    // Obtener el elemento que contiene los mensajes del chat
    const chatMessages = document.querySelector(".chat-messages");

    // Obtener los mensajes almacenados en localStorage o iniciar un array vacío
    const savedMessages = JSON.parse(localStorage.getItem('chat-messages')) || [];

    // Iterar sobre los mensajes almacenados y agregarlos al chat
    savedMessages.forEach(savedMessage => {
        // Crear un elemento para el mensaje guardado
        const messageElement = document.createElement('div');
        messageElement.classList.add('message');

        // Crear un elemento para la información del usuario
        const userInfo = document.createElement('div');
        userInfo.classList.add('user-info');

        // Crear un elemento para la imagen de perfil
        const userProfileImage = document.createElement('img');
        userProfileImage.src = 'user1.jpg';
        userProfileImage.alt = 'Foto de Usuario';

        // Crear un elemento para el nombre de usuario del mensaje guardado
        const username = document.createElement('span');
        username.classList.add('username');
        username.innerHTML = savedMessage.username;

        // Agregar la imagen de perfil y el nombre de usuario al elemento de información del usuario
        userInfo.append(userProfileImage);
        userInfo.append(username);

        // Crear un elemento para el cuadro de mensaje del mensaje guardado
        const messageBox = document.createElement('div');
        messageBox.classList.add('message-box');
        messageBox.textContent = savedMessage.message;

        // Agregar la información del usuario y el cuadro de mensaje al mensaje completo
        messageElement.append(userInfo);
        messageElement.append(messageBox);

        // Agregar el mensaje completo al chat
        document.getElementById('chat-messages').append(messageElement);
    });
});


                
</script>




    <div id="header-container"></div>
    <div class="container">
        <div class="chat">
            <div class="chat-header">
                <h2>Chat Principal</h2>
            </div>
            <div class="chat-messages" id="chat-messages">
                <!-- Ejemplo de mensaje -->
                <!-- <div class="message">
                    <div class="user-info">
                        <img src="user1.jpg" alt="Foto de Usuario">
                        <span class="username">Usuario1</span>
                    </div>
                    <div class="message-box">
                        <p>Hola, ¿cómo están?</p>
                    </div>
                </div> -->
            </div>
            <div class="chat-input">
                <input type="text" id="message-input" placeholder="Escribe tu mensaje...">
                <button id="send-button" onclick="sendMessage()">Enviar</button>
            </div>
        </div>
        <div class="user-list">
            <!-- Aquí se mostrará la lista de usuarios disponibles para chatear en privado -->
        </div>
    </div>
    <script src="./js/header.js"></script>

    
</body>
</html>