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
        <div class="center">Log into Music and Seek
            </br>
            <?php
            require_once 'bbdd.php';
            if (isset($_POST["enviar"])) {
                $pass = $_POST["pass"];
                $email = $_POST["mail"];
                if(login($email, $pass)){
                    $_POST["valoresok"] = "ok";
                }
            }if(isset($_POST["valoresok"])){
                echo "HOLA";
            }
            else {
                echo ' 
        <form action = "" method = "POST">
       <input placeholder="Email" name="mail" required type="email"></br>     
       <input  id="password" placeholder="Password" name="pass" required="" type="password"></br>            
       <button type="submit"  name = "enviar">Log in</button>
       </form>';
            }
            ?>

            <a class="fontblack" href="RecuperarContrasenya.php">Has olvidado tu contraseña?</a>
            <a class="fontblack" href="Registro.php">Nuevo usuario?</a>
        </div>
        <div id="footer"></div>
    </body>
</html>