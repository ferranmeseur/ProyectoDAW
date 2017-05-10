<!DOCTYPE html>
<html>
    <head>
        <title>Registro</title>
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
        <div class="center"></br>
            Introduce los siguientes datos para darte de alta en Music and Seek:</br></br>
            <div id="Registro" class="inline">
                <div id="Labels" class="inline text_align_left ">
                    <?php
                    require_once 'bbdd.php';
                    if (isset($_POST["enviar"])) {
                        $tipo = $_POST["tipo"];
                        $nombre = $_POST["nombre"];
                        $apellido = $_POST["apellido"];
                        $pas1 = $_POST["pas1"];
                        $pas2 = $_POST["pas2"];
                        $mail1 = $_POST["mail1"];
                        $mail2 = $_POST["mail2"];
                        if (!checkPassword($pas1, $pas2)) {
                            showAlert("Las contraseñas deben coincidir");
                        }
                        if (!checkPassword($mail1, $mail2)) {
                            showAlert("Los Emails deben coincidir");
                        }
                        if (!existMail($mail1)) {
                            showAlert("El mail ya esta registrado");
                        }
                        if (!existUser($nombre)) {
                            showAlert("El nombre ya esta registrado");
                        }
                        if (checkPassword($mail1, $mail2) && existUser($nombre) && checkPassword($pas1, $pas2) && existMail($mail1)) {
                            Registro($tipo, $nombre, $apellido, $mail1, $pas1);
                        }
                    } else {
                        echo ' 
        <form action = "" method = "POST">
         <div id="Rol" class="center">
                        Tipo de usuario : 
                        <select name="tipo">
                            <option value="Musico">Musico</option>
                            <option value="Local">Local</option>
                            <option value="Fan">Fan</option>
                        </select>
                    </div>
                    <div id="Nombre" class="align_right">
                    Nombre :<input type = "text" name = "nombre" maxlength="20" minlength="3" required>
                    </div>
                    <div id="Apellido" class="padding5 align_right">
                    Apellido :<input type = "text" name = "apellido" maxlength="20" minlength="3">
                    </div>
                    <div id="Mail" class="padding5 align_right">
                    Email :<input type = "text" name = "mail1" maxlength="50" minlength="5" required>
                    </div>
                    <div id="Mail2" class="padding5 align_right">
                    Confirma Email :<input type = "text" name = "mail2" maxlength="50" minlength="5" required>
                    </div>
                    <div id="Pass" class="padding5 align_right">
                    Contraseña :<input type = "password" name = "pas1" maxlength="10" minlength="5" required>
                    </div>
                    <div id="Pass2" class="padding align_right">
                    Confirma la contraseña : <input type = "password" name = "pas2" maxlength="10" minlength="5" required>
                    </div>
                </div>
            </div></br></br>
            <input type = "submit" name = "enviar" value = "Siguiente">             
            </div>
        </form>';
                    }
                    ?>
                </div>
                <div id="footer"></div>
                </body>
                </html>