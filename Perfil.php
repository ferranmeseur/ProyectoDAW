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
                    label_default: "Escoge foto", // Default: Choose File
                    label_selected: "Cambiar foto", // Default: Change File
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
                    echo'<div id = "div1" class = "inline center" style = "width: 15%; height: 100%">
                        <h1 class="fs-title">MIS DATOS</h1>
                        <div style = "width:250px; float:left">
                        <div id = "divConImagen" style = "border:1px solid gray">';

                    $urlDefaultImage = 'Imagenes/image.jpeg';
                    echo '<div id="image-preview" style="background-image: url(' . $urlDefaultImage . ');background-size:cover">
                            <label hidden for="image-upload" id="image-label">Escoger foto</label>
                            <input type="file" name="image" disabled id="image-upload"/>
                        </div>';

                    echo'</div>
                        </div>
                        <div>
                        <button style = "width:200px;margin:15px auto auto auto" onclick = "modificarPerfil(2)" class = "action-button" id = "editarPerfil"><span class = "icon icon-wrench"></span>EDITAR PERFIL</button>
                        <a href = "ModificarPassword.php"><button style = "width:100%; margin:15px auto auto auto" id="modificarContraseña" class="action-button" hidden>MODIFICAR PASSWORD</button></a>
                        </div>
                        </div>
                        <div id = "div2" class = "inline" style = "vertical-align: top; width: 25%; height: 100%">
                        <form style="width:100%" method = "POST" action = "" id = "msformLeft">
                        <table style="width:95%;margin-left:10px; ">
                        <col width="100">
                        <tr>
                            <td>Email:</td><td><input style="width:100%" value = "' . $info['EMAIL'] . '" type = "text" disabled></td>
                        </tr>
                        <tr>
                        <td>Nombre:</td><td><input style="width:100%" name = "nombreLocal" value = "' . $info['NOMBRE_LOCAL'] . '" class = "in" type = "text" disabled></td>
                        </tr>
                        <tr>
                        <td>Ubicacion:</td><td><input style="width:100%" name = "ubicacion" value = "' . $info['UBICACION'] . '" class = "in" type = "text" disabled></td>
                        </tr>
                        <tr>
                        <td>Aforo:</td><td><input style="width:100%" name = "aforo" value = "' . $info['AFORO'] . '" class = "in" type = "text" disabled></td>
                        </tr>
                        <tr>
                        <td>Web:</td><td><input style="width:100%" name = "web" value = "' . $info['WEB'] . '" class = "in" type = "text" disabled></td>
                        </tr>
                        <tr>
                        <td>Contacto:</td><td><input style="width:100%" name = "numeroContacto" value = "' . $info['NUMERO_CONTACTO'] . '" class = "in" type = "text" disabled></td>
                        </tr>
                        </table>
                        <button style = "width:100%;margin:auto auto auto auto" id = "aplicarCambiosButton" hidden type = "submit" name = "enviar" class = "action-button">MODIFICAR DATOS</button>
                        </form>
                        </div>
                        



                        <div class = "inline" style = "vertical-align: top; width: 45%; height: 100%">
                        <div id = "div3" style = "border-bottom:2px solid black" >
                        <h1 class="fs-title">PRÓXIMOS CONCIERTOS EN MI LOCAL</h1>';

                    echo '<div style = "height:200px;overflow-y:scroll" >';
                    $fechas = ListaFechasConciertosLocal(true, $info['ID_USUARIO'], 1);
                    while ($row = $fechas->fetch_assoc()) {
                        $nuevaFecha = date("w-d-m-Y", strtotime($row["FECHA"]));
                        $nuevaHora = date("H:i", strtotime($row["FECHA"]));
                        $fechaFinal = getNombreFecha($nuevaFecha);
                        $result = ListaConciertosFan($row['FECHA'], null, null, null, $info['ID_USUARIO'], true);
                        if ($result == null) {
                            echo '<script language = "javascript">$("#$fechaFinal").empty();</script>';
                        } else {

                            echo '<div id="resultado" style="text-align:center">';
                            echo '<table cellspacing=0 style="width:70%;font-size:15px">';
                            echo '<tr><td>';
                            echo '<h3 style="float:right" id="' . $fechaFinal . '" class="color_rojo_general">' . $fechaFinal . '</h3>';
                            echo '</td></tr>';



                            while ($lista = $result->fetch_assoc()) {
                                $nombre_artistico = str_replace(" ", "+", $lista['NOMBRE_ARTISTICO']);
                                echo '<tr>';
                                echo '<td style="text-align:right;vertical-align:top">';
                                echo '<div class="inline">';
                                echo '<a class="fontblack a_concierto" href=InfoConcierto.php?idcon=' . $lista['ID_CONCIERTO'] . '>';
                                echo "<b id='h4_lista_img'>" . $lista['NOMBRE_ARTISTICO'] . "</b>";

                                echo "<i>" . $lista['GENERO'] . "</i>";
                                echo "</a>";

                                echo "<a href='CancelarConcierto.php?idcon=" . $lista['ID_CONCIERTO'] . "' id='cancelarConcierto' class='action-button'>CANCELAR</a>";
                                echo '</div>';
                                echo '</td>';
                                echo '</tr>';
                            }


                            echo'</table>';
                            echo'</div>';
                        }
                    }

                    echo'</div>';
                    echo'</div>';
                    
                    echo '<div id="div4"  style = "border-bottom:2px solid black">';
                    echo '<h1 class = "fs-title">CONCIERTOS PENDIENTES</h1>';
                    echo '<div style = "height:200px;overflow-y:scroll" >';
                    $fechas = ListaFechasConciertosLocal(true, $info['ID_USUARIO'], 0);
                    while ($row = $fechas->fetch_assoc()) {
                        $nuevaFecha = date("w-d-m-Y", strtotime($row["FECHA"]));
                        $nuevaHora = date("H:i", strtotime($row["FECHA"]));
                        $fechaFinal = getNombreFecha($nuevaFecha);
                        $result = ListaConciertosFan($row['FECHA'], null, null, null, $info['ID_USUARIO'], true);
                        if ($result == null) {
                            echo '<script language = "javascript">$("#$fechaFinal").empty();</script>';
                        } else {

                            echo '<div id="resultado" style="text-align:center">';
                            echo '<table cellspacing=0 style="width:70%;font-size:15px">';
                            echo '<tr><td>';
                            echo '<h3 style="float:right" id="' . $fechaFinal . '" class="color_rojo_general">' . $fechaFinal . '</h3>';
                            echo '</td></tr>';



                            while ($lista = $result->fetch_assoc()) {
                                $nombre_artistico = str_replace(" ", "+", $lista['NOMBRE_ARTISTICO']);
                                echo '<tr>';
                                echo '<td style="text-align:right;vertical-align:top">';
                                echo '<div class="inline">';
                                echo '<a class="fontblack a_concierto" href=InfoConcierto.php?idcon=' . $lista['ID_CONCIERTO'] . '>';
                                echo "<b id='h4_lista_img'>" . $lista['NOMBRE_ARTISTICO'] . "</b>";

                                echo "<i>" . $lista['GENERO'] . "</i>";
                                echo "</a>";

                                echo "<a href='CancelarConcierto.php?idcon=" . $lista['ID_CONCIERTO'] . "' id='cancelarConcierto' class='action-button'>CANCELAR</a>";
                                echo '</div>';
                                echo '</td>';
                                echo '</tr>';
                            }


                            echo'</table>';
                            echo'</div>';
                        }
                    }

                    echo'</div>';
                    echo'</div>';
                    
                    echo'</div>
                    <div id = "div5" class = "center" style = "background-color:orange;width:85.6%;height:400px;margin:auto auto auto auto">
                    </div>
                    ';
                }
            }
            ?>


        </div>


    </body>

</html>

