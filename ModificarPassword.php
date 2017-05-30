<!DOCTYPE html>
<?php
session_start();
require_once 'bbdd.php';
if (isset($_SESSION['tipo']) && isset($_SESSION['email'])) {
    
} else {
    echo "Acceso denegado";
    header("refresh:2; url=Login.php");
    return 0;
}
?>
<html>
    <head>
        <title>Modificar Contraseña</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="JS/jquery-3.2.1.js" type="text/javascript"></script>
        <script>
            $(document).ready(function () {
                $("#header").load("Header.html");
                $("#footer").load("Footer.html");
            });

        </script> 
        <link href="Estilos/Estilos.css" rel="stylesheet" type="text/css"/>
        <link href="Estilos/RegistrationForm.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div id="header"></div>
        <div class="center">
            <div id="Search" class="height_40 padding20">
                <form class="form-wrapper cf" action="Busqueda.php" method="GET">
                    <input type="text" name="busqueda" placeholder="Busca músicos y locales" required>
                    <button class="button-form" type="submit" value="submit" name="submit">GO!</button>
                </form>
            </div>
        </div>
        <div>
            <?php
            require_once 'bbdd.php';

            function check() {
                $userEmail = $_SESSION['email'];
                $oldpassword = $_POST['oldpassword'];
                $newpassword1 = $_POST['newpassword1'];
                $newpassword1 = $_POST['newpassword1'];
                $newpassword2 = $_POST['newpassword2'];

                if (!checkPassword($newpassword1, $newpassword2)) {
                    showAlert('La nueva contraseña no coincide');
                } elseif (checkPassword($oldpassword, $newpassword1)) {
                    showAlert('Las contraseñas actual y nueva no pueden coincidir');
                } else {
                    $resultado = login($userEmail, $oldpassword);
                    if ($resultado != false) {
                        ModificarPassword($userEmail, $newpassword1);
                    }
                    $_POST['valoresok'] = true;
                }
            }

            if (isset($_POST['modificar'])) {
                check();
            }
            if (isset($_POST['valoresok'])) {
              echo '<h4 class="center"><i>Contraseña modificada con éxito.<br> Redirigiendo al perfil.</i><h4>';
              header("refresh:2;url='Perfil.php'");
            } else {
                echo'<div class="center">
            <form id="msform" method="POST" action="">
                <input type="text" name="oldpassword" placeholder="Contraseña actual" required/>
                <input type="text" name="newpassword1" placeholder="Nueva contraseña" required/>
                <input type="text" name="newpassword2" placeholder="Repetir nueva contraseña" required/>
                <input type="submit" style="margin:auto auto auto auto"  class="submit action-button" name="modificar" value="MODIFICAR" required>
            </form>
        </div>';
            }
            ?>
        </div>
        <div class="margin_top_200px" id="footer"></div>


    </body>

</html>

