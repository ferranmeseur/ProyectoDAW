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
                $("#header").load("Header.php");
                $("#footer").load("Footer.html");
            });
        </script> 
        <link href="Estilos/Estilos.css" rel="stylesheet" type="text/css"/>
        <link href="Estilos/RegistrationForm.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div id="header"></div> 
        <div class="center content">
            <h1>Accede a tu <span class="color_rojo_general">Cuenta</span></h1>
            <?php
            require_once 'bbdd.php';
            if (isset($_POST["enviar"])) {
                $pass = $_POST["pass"];
                $email = $_POST["mail"];
                $resultado = login($email, $pass);
                if ($resultado != false) {
                    $_POST["valoresok"] = "ok";
                    $email = strtolower($email);
                    $_SESSION['email'] = $email;
                    $_SESSION['tipo'] = $resultado;
                    $_SESSION['pass'] = $pass;
                }
            }if (isset($_POST["valoresok"])) {
                redirectURL("Perfil.php");
            } else {
                echo ' 
        <form action = "" method = "POST" id="msform">
       <input placeholder="Email" name="mail" required type="email"></br>     
       <input  id="password" placeholder="Contraseña" name="pass" required="" type="password"></br>            
       </br><button style="width:400px" type="submit" class="submit action-button"  name = "enviar">LOG IN</button>
       </form>';
            }
            ?>

            <a class="fontblack" id="links" href="RecuperarContrasenya.php">Has olvidado tu contraseña?</a>&nbsp;&nbsp;
            <a class="fontblack" id="links"href="Registro.php">Nuevo usuario?</a>
        </div>
        <div id="footer"></div>
    </body>
</html>