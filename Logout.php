<?php
    session_start();

if (isset($_SESSION['pass']) && isset($_SESSION['email'])) {
    session_destroy();
    header("refresh:0 url=HomePage.php");
}
?>