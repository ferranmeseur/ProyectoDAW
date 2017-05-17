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
        <div class="center padding20">
            <?php
            session_start();
            require_once'bbdd.php';
            $resultado = "";
            if (isset($_POST['enviar'])) {
                $email = $_POST['email'];
                $resultado = mostrarSeguridad($email);
                if ($resultado == "false") {
                    showAlert("No se ha encontrado el email");
                    redirectURL("RecuperarContrasenya.php");
                } else {
                    $_SESSION['email'] = $email;
                    echo'
                    <form method="POST"></br>
                Pregunta de seguridad:  ' . $resultado . '</br></br>
                Respuesta de seguridad: <input type="text" name="respuesta" required></br></br>
                <input type="submit" value="Enviar" name="cambiarpass">
            </form>';
                }
            } else {
                if (isset($_POST['cambiarpass'])) {
                    $nuevopass = comprobarSeguridad($_SESSION['email'], $_POST['respuesta']);
                    if ($nuevopass == "false") {
                        showAlert("Respuesta de seguridad incorrecta");
                        redirectURL("RecuperarContrasenya.php");
                    } else {
                        echo 'Esta es tu nueva contraseña : ' . $nuevopass;
                        echo'</br></br>';
                        echo ' Puedes cambiarla en el Area Personal';
                    }
                } else {

                    echo'
            <form method="POST">
            </br></br>
                Introduce tu email: <input type="email" name="email" required>
                <input type="submit" value="Enviar" name="enviar">
            </form>';
                }
            }
            ?>
        </div>
        <div id="footer"></div>
    </body>
</html>