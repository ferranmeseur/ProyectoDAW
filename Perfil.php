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
                $("#header").load("Header.php");
                $("#footer").load("Footer.html");
                $.uploadPreview({
                    input_field: "#image-upload", // Default: .image-upload
                    preview_box: "#image-preview", // Default: .image-preview
                    label_field: "#image-label", // Default: .image-label
                    label_default: "Escoge foto", // Default: Choose File
                    label_selected: "Cambiar foto", // Default: Change File
                    no_label: false                 // Default: false
                });
                fanRatingFixed();
            });
            function fanRatingFixed() {
                var puntuacion = $('#puntuacion').html();
                var pointsRoundEntero = Math.floor(puntuacion);
                var pointsRoundDecimal = puntuacion - pointsRoundEntero;
                if (pointsRoundDecimal == 0) {
                    $('#star' + pointsRoundEntero).prop('checked', true);
                } else {
                    $('#star' + pointsRoundEntero + 'half').prop('checked', true);
                }
            }
            var enabled = false;
            function modificarPerfil() {

                if (enabled == true) {
                    $(".in").prop('disabled', true);
                    $('#image-label').prop('hidden', true);
                    $('#aplicarCambiosButton').prop('hidden', true);
                    $('#modificarContraseña').prop('hidden', true);
                    $('#image-upload').prop('disabled', true);
                    $('#guardarimagen').prop('hidden', true);
                    enabled = false;
                } else {
                    enabled = true
                    $('.in').removeAttr('disabled');
                    $('#image-upload').removeAttr('disabled');
                    $('#image-label').removeAttr('hidden');
                    $('#aplicarCambiosButton').removeAttr('hidden');
                    $('#modificarContraseña').removeAttr('hidden');
                    $('#guardarimagen').removeAttr('hidden');
                }
            }
            function roundToHalf(value) {
                var converted = parseFloat(value); // Make sure we have a number 
                var decimal = (converted - parseInt(converted, 10));
                decimal = Math.round(decimal * 10);
                if (decimal == 5) {
                    return (parseInt(converted, 10) + 0.5);
                }
                if ((decimal < 3) || (decimal > 7)) {
                    return Math.round(converted);
                } else {
                    return (parseInt(converted, 10) + 0.5);
                }
            }
        </script> 
        <link href="Estilos/Estilos.css" rel="stylesheet" type="text/css"/>
        <link href="Estilos/RegistrationForm.css" rel="stylesheet" type="text/css"/>
        <link href="Estilos/StarRating.css" rel="stylesheet" type="text/css"/>
        <link href="Estilos/Comments.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div id="header"></div>
        <div class="center content">
        </div>
    </div>
    <div class="center" style="width: 100%; height: 100%">
        <?php
        require_once 'bbdd.php';
        $info = getInfoUser($_SESSION['email']);
        switch ($_SESSION['tipo']) {
            case "Fan":
                informacionFan($info);
                break;
            case "Local":
                informacionLocal($info);
                break;
            case "Musico":
                informacionMusico($info);
                break;
        }

        function informacionLocal($info) {
            if (isset($_POST['enviar'])) {
                $nuevaUbicacion = $_POST['ubicacion'];
                $nuevoNumeroContacto = $_POST['numeroContacto'];
                $nuevoNombreLocal = $_POST['nombreLocal'];
                $nuevoAforo = $_POST['aforo'];
                $nuevaWeb = $_POST['web'];
                $nuevadescripcion = $_POST['descripcion'];
                if (modificarDatosLocal($_SESSION['email'], $nuevaUbicacion, $nuevoNumeroContacto, $nuevoNombreLocal, $nuevoAforo, $nuevaWeb, $nuevadescripcion)) {
                    echo '<h1 class=center">Datos <span class="color_rojo_general">Modificados</span> con Éxito</h1>';
                    header("refresh:1; url=Perfil.php");
                } else {
                    echo 'fallo';
                }
            } else {
                if (isset($_POST['guardarImagen']) && isset($_FILES['fileToUpload'])) {
                    if (isset($_FILES["fileToUpload"])) {
                        $result = fileUpload($_SESSION['email']);
                        if ($result != 1) {
                            showAlert($result);
                        } else {
                        }
                    } else {
                        
                    }
                    //$result = modificarImagenEmail($nuevaImagen, $_SESSION['email']);
                } else {
                }
                $descripcion = str_replace("<pre>", "", $info['DESCRIPCION']);
                $urlDefaultImage = getImageEmail($_SESSION['email']);
                echo '<h1>Perfil <span class="color_rojo_general"> Local</span></h1>';
                echo'<div id = "div1" class = "inline center" style = "vertical-align:top;width: 15%; height: 150%">
                        <div style = "width:250px; float:left">
                        <div id = "divConImagen" style = "border:1px solid gray">';

                $urlDefaultImage = getImageEmail($_SESSION['email']);
                echo '<div id="image-preview" style="background-image: url(' . $urlDefaultImage . ');background-size:cover">';
                echo '<label hidden for="image-upload" id="image-label">Escoger foto</label>';
                echo '<form action="" method="POST" id="formimg" enctype="multipart/form-data">';
                echo '<input type="file" name="fileToUpload" id="image-upload"/>';

                echo '</div>';
                echo'</div>';
                echo '</div>';

                echo '<div style="width:70%">';
                echo '<button style = "width:200px;margin:15px auto auto auto" name="guardarImagen" value="guardarImagen" type = "submit" id="guardarimagen" hidden class = "action-button">GUARDAR IMAGEN</button>';

                echo '</form>';
                echo'<button style = "width:200px;margin:15px auto auto auto" onclick = "modificarPerfil(2)" class = "action-button" id = "editarPerfil"><span class = "icon icon-wrench"></span>EDITAR PERFIL</button>
        
        </div>
<a href = "ModificarPassword.php"><button style = "width:100%; margin:15px auto auto auto" id = "modificarContraseña" class = "action-button" hidden>MODIFICAR PASSWORD</button></a>
<a href = "Baja.php"><button style = "width:100%; margin:15px auto auto auto" class = "action-button">DARSE DE BAJA</button></a>

</div>
<div id = "div2" class = "inline" style = "margin-left:50px;vertical-align: top; width: 25%; height: 150%">';
                $puntuacion = votosLocal($info['ID_USUARIO']);
                echo '<div style = "float:left;text-align:left">';
                echo'<b style = "color:#d83c3c">LOCAL RATING</b><i id = "puntuacion" hidden>' . $puntuacion . '</i><br>';
                echo '<fieldset class = "rating_fixed">
<input type = "radio" id = "star5" name = "rating" value = "5" /><label class = "full" for = "star5" title = "Fantástico - 5 stars"></label>
<input type = "radio" id = "star4half" name = "rating" value = "4 and a half" /><label class = "half" for = "star4half" title = "Bastante bien - 4.5 stars"></label>
<input type = "radio" id = "star4" name = "rating" value = "4" /><label class = "full" for = "star4" title = "Bastante bien - 4 stars"></label>
<input type = "radio" id = "star3half" name = "rating" value = "3 and a half" /><label class = "half" for = "star3half" title = "Meh - 3.5 stars"></label>
<input type = "radio" id = "star3" name = "rating" value = "3" /><label class = "full" for = "star3" title = "Meh - 3 stars"></label>
<input type = "radio" id = "star2half" name = "rating" value = "2 and a half" /><label class = "half" for = "star2half" title = "No muy bueno - 2.5 stars"></label>
<input type = "radio" id = "star2" name = "rating" value = "2" /><label class = "full" for = "star2" title = " - 2 stars"></label>
<input type = "radio" id = "star1half" name = "rating" value = "1 and a half" /><label class = "half" for = "star1half" title = "Meh - 1.5 stars"></label>
<input type = "radio" id = "star1" name = "rating" value = "1" /><label class = "full" for = "star1" title = "Sucks big time - 1 star"></label>
<input type = "radio" id = "starhalf" name = "rating" value = "half" /><label class = "half" for = "starhalf" title = "Sucks big time - 0.5 stars"></label>
</fieldset> ';
                echo '</div>';
                echo'<form style = "width:100%" method = "POST" action = "" id = "msformLeft">
<table style = "width:95%">
<col width = "100">
<tr>
<td style = "color:#d83c3c">Email:</td><td><input style = "width:100%" value = "' . $info['EMAIL'] . '" type = "text" disabled></td>
</tr>
<tr>
<td style = "color:#d83c3c">Nombre:</td><td><input style = "width:100%" name = "nombreLocal" value = "' . $info['NOMBRE_LOCAL'] . '" class = "in" type = "text" disabled></td>
</tr>
<tr>
<td style = "color:#d83c3c">Ubicacion:</td><td><input style = "width:100%" name = "ubicacion" value = "' . $info['UBICACION'] . '" class = "in" type = "text" disabled></td>
</tr>
<tr>
<td style = "color:#d83c3c">Aforo:</td><td><input style = "width:100%" name = "aforo" value = "' . $info['AFORO'] . '" class = "in" type = "text" disabled></td>
</tr>
<tr>
<td style = "color:#d83c3c">Web:</td><td><input style = "width:100%" name = "web" value = "' . $info['WEB'] . '" class = "in" type = "text" disabled></td>
</tr>
<tr>
<td style = "color:#d83c3c">Contacto:</td><td><input style = "width:100%" name = "numeroContacto" value = "' . $info['NUMERO_CONTACTO'] . '" class = "in" type = "text" disabled></td>
</tr>
<tr>
<td style = "color:#d83c3c">Descripción:</td><td><textarea class = "in" disabled style = "resize:none;width:100%;max-height:200px; height:auto; overflow-y:hidden" form = "msformLeft" name = "descripcion" >' . $descripcion . '</textarea></td>
</tr>
</table>
<button style = "width:100%;margin:auto auto auto auto" id = "aplicarCambiosButton" hidden type = "submit" name = "enviar" class = "action-button">MODIFICAR DATOS</button>
</form>
</div>
<div class = "inline" style = "width:200px;height:150%"></div>
<div class = "inline" style = ";vertical-align: top; width:30%; height: 150%">
<div id = "div3" style = "border-bottom:2px solid gray">
<a href = "CrearConcierto.php?local=' . $info['ID_USUARIO'] . '" style = "width:100px" class = "action-button">CREAR CONCIERTO</a><br><br>

<h1 class = "fs-title">PRÓXIMOS CONCIERTOS EN MI LOCAL</h1>';
                echo '<div style = "max-height:325px;display:inline-block;overflow-y:auto; overflow-x:hidden" >';
                if ($fechas = ListaFechasConciertosLocal(true, $info['ID_USUARIO'], 1)) {

                    while ($row = $fechas->fetch_assoc()) {
                        $nuevaFecha = date("w-d-m-Y", strtotime($row["FECHA"]));
                        $nuevaHora = date("H:i", strtotime($row["FECHA"]));
                        $fechaFinal = getNombreFecha($nuevaFecha);
                        $estado = 1;
                        $visible = 1;
                        $result = ListaConciertosFan($row['FECHA'], null, null, null, $info['ID_USUARIO'], $estado, $visible);
                        if ($result == null) {
                            echo '<script language = "javascript">$("#$fechaFinal").empty();</script>';
                        } else {
                            echo '<div id="resultado" style="text-align:center">';
                            echo '<table cellspacing=0 style="width:100%;font-size:15px">';
                            echo '<tr><td>';
                            echo '<h3 id="' . $fechaFinal . '" class="color_rojo_general">' . $fechaFinal . '</h3>';
                            echo '</td></tr>';

                            while ($lista = $result->fetch_assoc()) {
                                $nombre_artistico = str_replace(" ", "+", $lista['NOMBRE_ARTISTICO']);
                                echo '<tr>';
                                echo '<td style="text-align:center;vertical-align:top">';
                                echo '<div class="inline">';
                                echo '<a class="fontblack a_concierto" href=InfoConcierto.php?idcon=' . $lista['ID_CONCIERTO'] . '>';
                                echo "<b id='h4_lista_img'>" . $lista['NOMBRE_ARTISTICO'] . "</b>";
                                echo "<i>" . $lista['GENERO'] . "</i>";
                                echo "</a>";
                                echo '<form action="" method="POST">';
                                echo '<input type="text" hidden name="idconcierto" value="' . $lista['ID_CONCIERTO'] . '">';
                                echo '<button type = "submit" name = "cancelarConciertoEstado1" class = "action-button">CANCELAR</button>';
                                echo '</form>';
                                echo '</div>';
                                echo '</td>';
                                echo '</tr>';
                            }
                            echo'</table>';
                            echo'</div>';
                        }
                    }
                    if (isset($_POST['cancelarConciertoEstado1'])) {
                        $idconcierto = $_POST['idconcierto'];
                        cancelarConcierto($idconcierto);
                        redirectURL('Perfil.php');
                    }
                } else {
                    echo 'No hay conciertos<br><br>';
                }
                echo'</div>';
                echo'</div>';
                echo '<div style="padding-top:20px">';
                echo '<h1 class = "fs-title">CONCIERTOS PENDIENTES</h1>';
                echo '<div style = "max-height:325px;display:inline-block;text-align:center;height:325px;overflow-y:auto" >';
                $fechas = ListaFechasConciertosLocal(true, $info['ID_USUARIO'], 0);
                if (!(empty($fechas))) {
                    while ($row = $fechas->fetch_assoc()) {
                        $nuevaFecha = date("w-d-m-Y", strtotime($row["FECHA"]));
                        $nuevaHora = date("H:i", strtotime($row["FECHA"]));
                        $fechaFinal = getNombreFecha($nuevaFecha);
                        $estado = 0;
                        $visible = 1;
                        $result = ListaConciertosFan($row['FECHA'], null, null, null, $info['ID_USUARIO'], $estado, $visible);
                        if ($result == null) {
                            echo '<script language = "javascript">$("#$fechaFinal").empty();</script>';
                        } else {

                            echo '<div id="resultado" style="text-align:center">';
                            echo '<table cellspacing=0 style="width:100%;font-size:15px">';
                            echo '<tr><td>';
                            echo '<h3 id="' . $fechaFinal . '" class="color_rojo_general">' . $fechaFinal . '</h3>';
                            echo '</td></tr>';
                            while ($lista = $result->fetch_assoc()) {
                                $propuestaAceptada = getInfoPropuesta($lista['ID_CONCIERTO']);
                                $nombre_artistico = str_replace(" ", "+", $lista['NOMBRE_ARTISTICO']);
                                echo '<tr>';
                                echo '<td style="vertical-align:top">';
                                echo '<div class="inline">';
                                echo '<a class="fontblack a_concierto" href=InfoConcierto.php?idcon=' . $lista['ID_CONCIERTO'] . '>';
                                echo "<b id='h4_lista_img'>" . $lista['NOMBRE_ARTISTICO'] . "</b>";
                                if ($propuestaAceptada == 'A') {
                                    $estadoPropuesta = " - <i class='color_rojo_general'>ACEPTADO</i>";
                                } elseif ($propuestaAceptada == 'P' || $propuestaAceptada == 'PENDIENTE') {
                                    $estadoPropuesta = " - <i class='color_rojo_general'>PENDIENTE</i>";
                                } else {
                                    $estadoPropuesta = " - <i class='color_rojo_general'>CANCELADO</i>";
                                }
                                echo "<i class='color_rojo_general'> " . $lista['GENERO'] . "</i> <b>" . $nuevaHora . "h </b>" . $estadoPropuesta;
                                echo "</a>";
                                echo '<form action="" method="POST">';
                                echo '<input type="text" hidden name="idconcierto" value="' . $lista['ID_CONCIERTO'] . '">';
                                echo '<input type="text" hidden name="idgrupo" value="' . $lista['ID_GRUPO'] . '">';
                                if ($propuestaAceptada == 'A') {
                                    echo '<button type = "submit" name = "lanzarConcierto" class = "action-button">LANZAR</button>';
                                    echo '<button type = "submit" name = "cancelarConcierto" class = "action-button">CANCELAR</button>';
                                } elseif ($propuestaAceptada == 'C') {
                                    echo '<button type = "submit" name = "cancelarConcierto" class = "action-button">CANCELAR</button>';
                                } else {
                                    echo '<button type = "submit" name = "modificarConcierto" class = "action-button">MODIFICAR</button>';
                                    echo '<button type = "submit" name = "cancelarConcierto" class = "action-button">CANCELAR</button>';
                                }
                                echo '</form>';
                                echo '</div>';
                                echo '</td>';
                                echo '</tr>';
                            }
                            echo'</table>';
                            echo'</div>';
                        }
                    }
                    if (isset($_POST['lanzarConcierto'])) {
                        $idconcierto = $_POST['idconcierto'];
                        lanzarConcierto($idconcierto);
                        redirectURL('Perfil.php');
                    }
                    if (isset($_POST['cancelarConcierto'])) {
                        $idconcierto = $_POST['idconcierto'];
                        cancelarConcierto($idconcierto);
                    }
                    if (isset($_POST['modificarConcierto'])) {
                        $idconcierto = $_POST['idconcierto'];
                        $idgrupo = $_POST['idgrupo'];
                        echo'<script>window.location.replace("CrearConcierto.php?idgrupo=' . $idgrupo . '&idconcierto=' . $idconcierto . '&mod=true");</script>';
                    }
                } else {
                    echo 'No hay conciertos<br><br>';
                }
                echo'</div>';
                echo'</div>';

                echo'</div>';
                echo'<div id = "div4" class = "center" style = "width:60%;margin:auto auto 100px auto">';
                $comentarios = comentariosGrupo($info['ID_USUARIO']);
                if ($comentarios != false) {
                    echo '<div class = "container">';
                    while ($lista = $comentarios->fetch_assoc()) {
                        $imagen = getImageID($lista['ID_USUARIO']);
                        echo '<div class = "row center">';
                        echo '<div class = "col-sm-8">';
                        echo '<div class = "panel panel-white post panel-shadow">';
                        echo '<div class = "post-heading">';
                        echo '<div class = "pull-left image">';
                        echo '<img src = "' . $imagen . '" class = "img-circle avatar" alt = "user profile image">';
                        echo '</div>';
                        echo '<div class = "pull-left meta">';
                        echo '<div class = "title h5">';
                        echo '<b>' . $lista['NOMBRE'] . ' ' . $lista['APELLIDOS'] . '</b>';
                        echo ' ha realizado un comentario';
                        echo '</div>';
                        echo '<h6 class = "text-muted time">El ' . getNombreFecha(date("w-d-m-Y", strtotime($lista['FECHA']))) . '</h6>';
                        echo '</div>';
                        echo '</div>';
                        echo '<div class = "post-description">';
                        echo '<p> ' . $lista['COMENTARIO'] . '</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                    echo'</div>';
                }
                echo'</div>';
            }
        }
        ?>
    </div>
    <div id="footer"></div>


</body>

</html>

