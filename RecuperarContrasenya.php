<!DOCTYPE html>
<html>
    <head>
        <title>Recuperar Contraseña</title>
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
        <?php
        session_start();
        require_once'bbdd.php';
        if (isset($_POST['cambiar'])) {
            $username = $_SESSION['user'];
            $sessionpass = $_SESSION['pass'];
            $oldpassword = $_POST['oldpassword'];
            $newpassword1 = $_POST['newpassword1'];
            $newpassword2 = $_POST['newpassword2'];
            ModificarPassword($username, $sessionpass, $oldpassword, $newpassword1, $newpassword2);
        }
        ?>
        <div class="center">
            <form method="POST">
                Introduce tu email: <input type="email" name="email" required><br>
                <input type="submit" value="cambiar" name="cambiar">
            </form>
        </div>
        <div id="footer"></div>
    </body>
</html>