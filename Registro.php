<!DOCTYPE html>
<html>
    <head>
        <title>Registro</title>
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
        <div class="center"></br>
            Introduce los siguientes datos para darte de alta en Music and Seek:</br></br>
            <div id="Registro" class="inline">
                <div id="Labels" class="inline text_align_left ">
                    <?php
                    require_once 'bbdd.php';

                    function check() {
                        $tipo = $_POST["tipo"];
                        $nombre = $_POST["nombre"];
                        $apellido = $_POST["apellido"];
                        $pas1 = $_POST["pas1"];
                        $pas2 = $_POST["pas2"];
                        $mail1 = $_POST["mail1"];
                        $mail2 = $_POST["mail2"];
                        if (!checkPassword($pas1, $pas2)) {
                            showAlert("Las contraseñas deben coincidir");
                        } elseif (!checkPassword($mail1, $mail2)) {
                            showAlert("Los Emails deben coincidir");
                        } elseif (!existMail($mail1)) {
                            showAlert("El mail ya esta registrado");
                        } else {
                            $_POST["valoresok"] = "submit";
                        }
                    }

                    if (isset($_POST["enviar"])) {
                        check();
                    }

                    if (isset($_POST["valoresok"])) {
                        $tipo = $_POST["tipo"];
                        $nombre = $_POST["nombre"];
                        $apellido = $_POST["apellido"];
                        $pas1 = $_POST["pas1"];
                        $pas2 = $_POST["pas2"];
                        $mail1 = $_POST["mail1"];
                        $mail2 = $_POST["mail2"];
                        $pregunta = $_POST["pregunta"];
                        $respuesta = $_POST["respuesta"];
                        session_start();
                        $_SESSION['tipo'] = $tipo;
                        $_SESSION['mail'] = $mail1;
                        $_SESSION['nombre'] = $nombre;
                        $_SESSION['apellido'] = $apellido;
                        $_SESSION['pas'] = $pas1;
                        $_SESSION['pregunta'] = $pregunta;
                        $_SESSION['respuesta'] = $respuesta;
                        header("Location:RegistroExtra.php");
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
                    <label style="color:red;">* </label>Nombre :<input type = "text" name = "nombre" maxlength="20" minlength="3" required>
                    </div>
                    <div id="Apellido" class="padding5 align_right">
                    Apellido :<input type = "text" name = "apellido" maxlength="20" minlength="3">
                    </div>
                    <div id="Mail" class="padding5 align_right">
                    <label style="color:red;">* </label>Email :<input type = "text" name = "mail1" maxlength="50" minlength="5" required>
                    </div>
                    <div id="Mail2" class="padding5 align_right">
                    <label style="color:red;">* </label> Confirma Email :<input type = "text" name = "mail2" maxlength="50" minlength="5" required>
                    </div>
                    <div id="Pass" class="padding5 align_right">
                    <label style="color:red;">* </label>Contraseña :<input type = "password" name = "pas1" maxlength="10" minlength="5" required>
                    </div>
                    <div id="Pass2" class="padding align_right">
                    <label style="color:red;">* </label>Confirma la contraseña : <input type = "password" name = "pas2" maxlength="10" minlength="5" required>
                    </div>
                    <div id="Mail" class="padding5 align_right">
                    <label style="color:red;">* </label>Pregunta de Seguridad: <input type = "text" name = "pregunta" maxlength="40" minlength="5" required>
                    </div>
                    <div id="Mail" class="padding5 align_right">
                    <label style="color:red;">* </label>Respuesta de Seguridad : <input type = "text" name = "respuesta" maxlength="20" minlength="5" required>
                    </div>
                </div>
                </br>
                </br><div style="color:red;font-size:10px;">* Campos obligatorios</div>
                            <input type = "submit" name = "enviar" value="Siguiente" class="register-button">

            </div></br></br>
            </div>
        </form>';
                    }
                    ?>
                </div>
            </div>
        </div>
        <div id="footer"></div>
    </body>
</html>