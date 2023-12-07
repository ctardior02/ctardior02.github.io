
<?php
    session_start();
    session_destroy();
    header("Location: ./sing-login.php");
    exit();
?>
