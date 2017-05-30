<!DOCTYPE html>
<?php
session_start();
require_once 'bbdd.php';
if (isset($_SESSION['tipo']) && isset($_SESSION['email'])) {
    
} else {
    header("Location:Login.php");
}
?>
<html>
    <head>
        <title>Perfil</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="JS/jquery-3.2.1.js" type="text/javascript"></script>
        <script src="JS/jquery.uploadPreview.js" type="text/javascript"></script>
        <script>
            $(document).ready(function () {
                $("#header").load("Header.html");
                $("#footer").load("Footer.html");
                $.uploadPreview({
                    input_field: "#image-upload", // Default: .image-upload
                    preview_box: "#image-preview", // Default: .image-preview
                    label_field: "#image-label", // Default: .image-label
                    label_default: "Choose File", // Default: Choose File
                    label_selected: "Change File", // Default: Change File
                    no_label: false                 // Default: false
                });
            });
            function modificarContraseña() {
                header('location:Login.php');
            }
            var enabled = false;
            function modificarPerfil() {

                if (enabled == true) {
                    $(".in").prop('disabled', true);
                    $('#image-label').prop('hidden', true);
                    $('#aplicarCambiosButton').prop('hidden', true);
                    $('#modificarContraseña').prop('hidden', true);
                    $('#image-upload').prop('disabled', true);
                    enabled = false;
                } else {
                    enabled = true
                    $('.in').removeAttr('disabled');
                    $('#image-upload').removeAttr('disabled');
                    $('#image-label').removeAttr('hidden');
                    $('#aplicarCambiosButton').removeAttr('hidden');
                    $('#modificarContraseña').removeAttr('hidden');
                }


            }
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
        <div class="center" style="width: 100%; height: 500px">
            <?php
            require_once 'bbdd.php';
            $info = getInfoUser($_SESSION['email']);
            switch ($_SESSION['tipo']) {
                case "Fan":
                    echo $_SESSION['tipo'];
                    informacionFan($info);
                    break;
                case "Local":
                    informacionLocal($info);
                    break;
                case "Musico":
                    echo "Que ise";
                    break;
            }

            function informacionFan($info) {
                if (isset($_POST['enviar'])) {
                    $nuevoNombre = $_POST['nombre'];
                    $nuevoApellido = $_POST['apellido'];
                    $nuevaUbicacion = $_POST['ubicacion'];
                    if (modificarDatosFan($_SESSION['email'], $nuevoNombre, $nuevoApellido, $nuevaUbicacion)) {
                        echo '<h2 class="center fs-title">Datos modificados con éxito</h2>';
                        header("refresh:5; url=Perfil.php");
                    } else {
                        echo 'fallo';
                    }
                } else {
                    $imagen = showImage($_SESSION['email']);
                    echo '<h1 class="fs-title">PERFIL FAN</h1>';
                    echo'<div id = "div1" class = "inline" style = "width: 15%; height: 100%">
                        <div style = "width:250px;height:450px; float:left">
                        <div id = "divConImagen" style = "border:1px solid gray">';

                    $urlDefaultImage = 'Imagenes/image.jpeg';
                    echo '<div id="image-preview" style="background-image: url(' . $urlDefaultImage . ');background-size:cover">
  <label hidden for="image-upload" id="image-label">Choose File</label>
  <input type="file" name="image" disabled id="image-upload"/>
</div>';

                    echo'</div>
                        <div>
                        <button style = "width:100%; margin:5px auto auto auto" class = "action-button" hidden id = "cambiarImagen">CAMBIAR IMAGEN</button>
                        </div>
                        </div>
                        </div>
                        <div id = "div2" class = "inline" style = "vertical-align: top; width: 60%; height: 100%">

                        <form method = "POST" action = "" id = "msformLeft">
                        <label class = "inline">Nombre:</label> <input name = "nombre" value = "' . $info['NOMBRE'] . '" class = "in inline" type = "text" disabled>
                        <label>Apellidos:</label> <input name = "apellido" value = "' . $info['APELLIDOS'] . '" class = "in" type = "text" disabled>
                        <label>Ubicacion:</label> <input name = "ubicacion" value = "' . $info['UBICACION'] . '" class = "in" type = "text" disabled>
                        <label>Email:</label> <input value = "' . $info['EMAIL'] . '" type = "text" disabled placeholder = "hola">
                        <button style = "width:400px;margin:auto auto auto auto" id = "aplicarCambiosButton" hidden type = "submit" name = "enviar" class = "action-button">MODIFICAR DATOS</button>
                        </form>
                        </div>
                        <div id = "div3" class = "inline" style = "vertical-align: top; width: 10%; height: 100%">
                        <button style = "width:200px;float:right;vertical-align: top" onclick = "modificarPerfil(1)" class = "action-button" id = "editarPerfil"><span class = "icon icon-wrench"></span>EDITAR PERFIL</button>
                        <a href = "ModificarPassword.php"><button style = "width:200px;float:right" class = "action-button" hidden>MODIFICAR PASSWORD</button></a>

                        </div>';
                }
            }

            function informacionLocal($info) {
                if (isset($_POST['enviar'])) {
                    $nuevaUbicacion = $_POST['ubicacion'];
                    $nuevoNumeroContacto = $_POST['numeroContacto'];
                    $nuevoNombreLocal = $_POST['nombreLocal'];
                    $nuevoAforo = $_POST['aforo'];
                    $nuevaWeb = $_POST['web'];

                    if (modificarDatosLocal($_SESSION['email'], $nuevaUbicacion, $nuevoNumeroContacto, $nuevoNombreLocal, $nuevoAforo, $nuevaWeb)) {
                        echo '<h2 class="center fs-title">Datos modificados con éxito</h2>';
                        header("refresh:5; url=Perfil.php");
                    } else {
                        echo 'fallo';
                    }
                } else {
                    $imagen = showImage($_SESSION['email']);
                    echo '<h1 class="fs-title">PERFIL LOCAL</h1>';
                    echo'<div id = "div1" class = "inline" style = "background-color:blue;width: 15%; height: 100%">
                        <div style = "width:250px;height:450px; float:left">
                        <div id = "divConImagen" style = "border:1px solid gray">';

                    $urlDefaultImage = 'Imagenes/image.jpeg';
                    echo '<div id="image-preview" style="background-image: url(' . $urlDefaultImage . ');background-size:cover">
  <label hidden for="image-upload" id="image-label">Choose File</label>
  <input type="file" name="image" disabled id="image-upload"/>
</div>';

                    echo'</div>
                        <button style = "width:200px;vertical-align: top" onclick = "modificarPerfil(2)" class = "action-button" id = "editarPerfil"><span class = "icon icon-wrench"></span>EDITAR PERFIL</button>
                        <a href = "ModificarPassword.php"><button style = "width:200px;margin:auto auto auto auto" class = "action-button">MODIFICAR PASSWORD</button></a>

                        <div>
                        <button style = "width:100%; margin:5px auto auto auto" class = "action-button" hidden id = "cambiarImagen">CAMBIAR IMAGEN</button>
                        </div>
                        </div>
                        </div>
                        <div id = "div2" class = "inline" style = "background-color:red;vertical-align: top; width: 35%; height: 100%">

                        <form method = "POST" action = "" id = "msformLeft">
                        <label>Email:</label> <input value = "' . $info['EMAIL'] . '" type = "text" disabled><br>
                        <label>Nombre:</label> <input name = "nombreLocal" value = "' . $info['NOMBRE_LOCAL'] . '" class = "in" type = "text" disabled><br>
                        <label>Ubicacion:</label> <input name = "ubicacion" value = "' . $info['UBICACION'] . '" class = "in" type = "text" disabled><br>
                        <label>Aforo:</label> <input name = "aforo" value = "' . $info['AFORO'] . '" class = "in" type = "text" disabled><br>
                        <label>Web:</label> <input name = "web" value = "' . $info['WEB'] . '" class = "in" type = "text" disabled><br>
                        <label>Contacto:</label> <input name = "numeroContacto" value = "' . $info['NUMERO_CONTACTO'] . '" class = "in" type = "text" disabled><br>
                        <button style = "width:400px;margin:auto auto auto auto" id = "aplicarCambiosButton" hidden type = "submit" name = "enviar" class = "action-button">MODIFICAR DATOS</button>
                        </form>
                        </div>
                        <div id = "div3" class = "inline" style = "background-color:yellow;vertical-align: top; width: 35%; height: 100%">
                        
                        </div>
                        <div id="div4" class="center" style="background-color:orange;width:85.6%;height:400px;margin:auto auto auto auto">               
                        </div>
';
                }
            }
            ?>


        </div>


    </body>

</html>

