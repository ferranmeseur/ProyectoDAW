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
        <link href="Estilos/RegistrationForm.css" rel="stylesheet" type="text/css"/>
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
                    <form method="POST" id="msform"></br>
                <b style="font-size:15px;text-transform:uppercase">Pregunta de seguridad:</b></br></br>  ' . $resultado . '</br></br>
                <input type="text" placeholder="Respuesta de seguridad" name="respuesta" required></br></br>
                <input type="submit" value="Enviar" class="submit action-button" name="cambiarpass">
            </form>';
                }
            } else {
                if (isset($_POST['cambiarpass'])) {
                    $nuevopass = comprobarSeguridad($_SESSION['email'], $_POST['respuesta']);
                    if ($nuevopass == "false") {
                        showAlert("Respuesta de seguridad incorrecta");
                        redirectURL("RecuperarContrasenya.php");
                    } else {
                        echo 'Esta es tu nueva contraseña:</br> ' . $nuevopass;
                        echo'</br></br>';
                        echo '<i> Puedes cambiarla en el Area Personal</i>';
                    }
                } else {

                    echo'
            <form method="POST" id="msform">
            <p style="font-size:30px;text-transform:uppercase">Recuperar Contraseña</p>
            </br></br>
                <input type="email" name="email" placeholder="EMAIL" required>
                <input type="submit" name="enviar" class="submit action-button" value="Siguiente" />
            </form>';
                }
            }
            ?>
        </div>
        <div class="margin_top_200px" id="footer"></div>
    </body>
</html>