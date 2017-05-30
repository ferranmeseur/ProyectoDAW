<?php
    session_start();

if (isset($_SESSION['tipo']) && isset($_SESSION['email'])) {
    session_destroy();
    echo'Desconectado. Redirigiendo a inicio';
    header("refresh:2; url=HomePage.php");
} else {
    echo "Acceso denegado";
    echo $_SESSION['tipo'];
    //header("refresh:2; url=Login.php");
    return 0;
}
?>