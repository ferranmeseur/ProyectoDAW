<!DOCTYPE html>
<?php
session_start();
require_once 'bbdd.php';
if (isset($_SESSION['tipo']) && isset($_SESSION['email'])) {
    echo 'Ya estás en sesión';
    header("refresh:2; url=HomePage.php");
    return 0;
} else {

}
?>
<html>
    <head>
        <title>Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script>
            $(function () {
                $("#header").load("Header.html");
                $("#footer").load("Footer.html");
            });
        </script> 
        <link href="Estilos/Estilos.css" rel="stylesheet" type="text/css"/>
        <link href="Estilos/RegistrationForm.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div id="header"></div> 
        <div class="center padding20">
            <h1 class="fs-title">LOG IN</h1>
            <?php
            require_once 'bbdd.php';
            if (isset($_POST["enviar"])) {
                $pass = $_POST["pass"];
                $email = $_POST["mail"];
                $resultado = login($email, $pass);
                if ($resultado != false) {
                    $_POST["valoresok"] = "ok";
                    $_SESSION['tipo'] = $resultado;
                    $email = strtolower($email);
                    $_SESSION['email'] = $email;
                }
            }if (isset($_POST["valoresok"])) {
                redirectURL("Perfil.php");
            } else {
                echo ' 
        <form action = "" method = "POST" id="msform">
       <input placeholder="Email" name="mail" required type="email"></br>     
       <input  id="password" placeholder="Password" name="pass" required="" type="password"></br>            
       </br><button style="width:400px" type="submit" class="submit action-button"  name = "enviar">LOG IN</button>
       </form>';
            }
            ?>

            <a class="fontblack" href="RecuperarContrasenya.php">Has olvidado tu contraseña?</a>
            <a class="fontblack" href="Registro.php">Nuevo usuario?</a>
        </div>
        <div id="footer"></div>
    </body>
</html>