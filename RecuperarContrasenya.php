<!DOCTYPE html>
<html>
    <head>
        <title>Recuperar Contraseña</title>
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
                            <h1> Pregunta de  <span class="color_rojo_general">Seguridad</span></h1>
                </b></br></br>  ' . $resultado . ' ?</br></br>
                <input type="text" placeholder="Respuesta de seguridad" name="respuesta" required></br></br>
                       </br><button style="width:400px" type="submit" class="submit action-button"  name = "cambiarpass">Enviar</button>
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
            <h1> Recupera tu  <span class="color_rojo_general">Contraseña</span></h1>
            </br></br>
                <input type="email" name="email" placeholder="Email" required>
       </br><button style="width:400px" type="submit" class="submit action-button"  name = "enviar">Siguiente</button>
            </form>';
                }
            }
            ?>
        </div>
        <div id="footer"></div>
    </body>
</html>