<!DOCTYPE html>
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
    </head>
    <body>
        <div id="header"></div> 
        <div class="center padding20">Identificate:
            </br></br>
            <?php
            session_start();
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
        <form action = "" method = "POST">
       <input placeholder="Email" name="mail" required type="email"></br>     
       <input  id="password" placeholder="Password" name="pass" required="" type="password"></br>            
       </br><button type="submit"  name = "enviar">Log in</button>
       </form>';
            }
            ?>

            <a class="fontblack" href="RecuperarContrasenya.php">Has olvidado tu contraseña?</a>
            <a class="fontblack" href="Registro.php">Nuevo usuario?</a>
        </div>
        <div id="footer"></div>
    </body>
</html>