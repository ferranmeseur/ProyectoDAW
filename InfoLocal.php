<!DOCTYPE html>
<html>
    <head>
        <?php
        session_start();
        require_once'bbdd.php';
        $redirect = $_GET['nombre'];
        echo '<title>' . $_GET['nombre'] . '</title>';
        ?>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="JS/jquery-3.2.1.js" type="text/javascript"></script>
        <script src="JS/jquery.uploadPreview.js" type="text/javascript"></script>
        <script>
            $(function () {
                $("#header").load("Header.php");
                $("#footer").load("Footer.html");
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
        </script>
        <style>
            .table td{
                text-align: left;
            }
        </style>
        <link href="Estilos/Estilos.css" rel="stylesheet" type="text/css"/>
        <link href="Estilos/RegistrationForm.css" rel="stylesheet" type="text/css"/>
        <link href="Estilos/StarRating.css" rel="stylesheet" type="text/css"/>
        <link href="Estilos/Comments.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div id="header"></div> 
        <?php
        require_once'bbdd.php';
        if (isset($_GET['b'])) {
            $nombre = $_GET['nombre'];
            TraceEvent("BUSQUEDA", $nombre, "NULL", "LOCAL", "NULL");
        }
        $resultado = getInfoLocalName($_GET['nombre']);
        $puntuacion = votosLocal($resultado['ID_USUARIO']);
        $comentarios = comentariosGrupo($resultado['ID_USUARIO']);
        $imagen = getImageID($resultado['ID_USUARIO']);
        echo'<div class="center content">';
        echo'<div class="inline center" style="vertical-align:top">';
        echo'<img src="' . $imagen . '" alt="" style="width:250px"/>';
        echo'</div>';
        echo '<div class="inline" style="width:25%">';
        echo '<h1>' . $resultado['NOMBRE_LOCAL'] . '</h1>';
        echo'<b style="color:#d83c3c">LOCAL RATING</b><i id="puntuacion" hidden>' . $puntuacion . '</i><br>';
        echo '<fieldset class="rating_fixed center" style="float:left;margin:auto auto auto auto;width:70%">
            <input type="radio" id="star5" name="rating" value="5.0" /><label class = "full" for="star5" title="Fantástico - 5 stars"></label>
            <input type="radio" id="star4half" name="rating" value="4.0" /><label class="half" for="star4half" title="Bastante bien - 4.5 stars"></label>
            <input type="radio" id="star4" name="rating" value="4.0" /><label class = "full" for="star4" title="Bastante bien - 4 stars"></label>
            <input type="radio" id="star3half" name="rating" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
            <input type="radio" id="star3" name="rating" value="3.0" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
            <input type="radio" id="star2half" name="rating" value="2.0" /><label class="half" for="star2half" title="No muy bueno - 2.5 stars"></label>
            <input type="radio" id="star2" name="rating" value="2.0" /><label class = "full" for="star2" title=" - 2 stars"></label>
            <input type="radio" id="star1half" name="rating" value="1.0" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
            <input type="radio" id="star1" name="rating" value="1.0" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
            <input type="radio" id="starhalf" name="rating" value="0.5" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
            </fieldset> ';


        echo '<br><br><br><table cellspacing="20" style="text-align:left">';
        echo '<tr><td>UBICACIÓN: </td><td>' . $resultado['UBICACION'] . '</td></tr>';
        echo '<tr><td>CIUDAD : </td><td>' . getNombreCiudad($resultado['ID_CIUDAD']) . '</td></tr>';
        echo '<tr><td>AFORO : </td><td>' . $resultado['AFORO'] . '</td></tr>';
        echo '<tr><td>EMAIL : </td><td>' . $resultado['EMAIL'] . '</td></tr>';
        echo '<tr><td>CONTACTO : </td><td>' . $resultado['NUMERO_CONTACTO'] . '</td></tr>';
        if ($resultado['WEB'] != null) {
            echo'<tr><td>Web : </td><td>' . $resultado['WEB'] . '</td></tr>';
        }
        if ($resultado['DESCRIPCION'] != null) {
            echo '<tr><td style="vertical-align:top">Descripción : </td><td>' . $resultado['DESCRIPCION'] . '</td></tr>';
        }
        echo '</table>';
        echo '<div style="padding-bottom:50px"></div>';
        if ($comentarios != false) {
            echo '</div>';
            echo '<div style="margin:auto auto auto auto;width:500px">';
            echo '<div class="container">';
            while ($lista = $comentarios->fetch_assoc()) {
                $imagen = getImageID($lista['ID_USUARIO']);
                echo '<div class="row center">';
                echo '<div class="col-sm-8">';
                echo '<div class="panel panel-white post panel-shadow">';
                echo '<div class="post-heading">';
                echo '<div class="pull-left image">';
                echo '<img src="' . $imagen . '" class="img-circle avatar" alt="user profile image">';
                echo '</div>';
                echo '<div class="pull-left meta">';
                echo '<div class="title h5">';
                echo '<b>' . $lista['NOMBRE'] . ' ' . $lista['APELLIDOS'] . '</b>';
                echo ' ha realizado un comentario';
                echo '</div>';
                echo '<h6 class="text-muted time">El ' . getNombreFecha(date("w-d-m-Y", strtotime($lista['FECHA']))) . '</h6>';
                echo '</div>';
                echo '</div>';
                echo '<div class="post-description">';
                echo '<p> ' . str_replace("<pre>", "", $lista['COMENTARIO']) . '</p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            echo'</div>';
            echo'</div>';
        }
        echo '</div></div>';

        if (isset($_POST["enviar"]) && $_SESSION['check'] == 0) {
            $_SESSION['check'] = 1;
            $puntos = $_POST["rating2"];
            $comentario = $_POST["comentario"];
            $user = getInfoUser($_SESSION['email']);
            votarComentarNoConcierto($user['ID_USUARIO'], $resultado['ID_USUARIO'], $puntos, $comentario);
        }
        if (isset($_SESSION['email'])) {
            $user = getInfoUser($_SESSION['email']);
            $_SESSION['check'] = checkVotar($resultado['ID_USUARIO'], $user['ID_USUARIO']);
        }
        if (isset($_SESSION['pass']) && $user['TIPO_USUARIO'] == "Fan" && $_SESSION['check'] == 0) {
            echo '<div style="text-align:center">';
            echo'<h2>Deja tu comentario:</h2>';
            echo'<form action = "" method = "POST" id="msform">';
            echo'<div style="width:200px" class="rating">
    <input type="radio" id="estrella5" name="rating2" value="5" /><label class = "full" for="estrella5" title="Awesome - 5 estrellas"></label>
    <input type="radio" id="estrella4medio" name="rating2" value="4.5" /><label class="half" for="estrella4medio" title="Pretty good - 4.5 estrellas"></label>
    <input type="radio" id="estrella4" name="rating2" value="4" /><label class = "full" for="estrella4" title="Pretty good - 4 estrellas"></label>
    <input type="radio" id="estrella3medio" name="rating2" value="3.5" /><label class="half" for="estrella3medio" title="Meh - 3.5 estrellas"></label>
    <input type="radio" id="estrella3" name="rating2" value="3" /><label class = "full" for="estrella3" title="Meh - 3 estrellas"></label>
    <input type="radio" id="estrella2medio" name="rating2" value="2.5" /><label class="half" for="estrella2medio" title="Kinda bad - 2.5 estrellas"></label>
    <input type="radio" id="estrella2" name="rating2" value="2" /><label class = "full" for="estrella2" title="Kinda bad - 2 estrellas"></label>
    <input type="radio" id="estrella1medio" name="rating2" value="1.5" /><label class="half" for="estrella1medio" title="Meh - 1.5 estrellas"></label>
    <input type="radio" id="estrella1" name="rating2" value="1" /><label class = "full" for="estrella1" title="Sucks big time - 1 estrella"></label>
    <input type="radio" id="estrellamedio" name="rating2" value="medio" /><label class="half" for="estrellamedio" title="Sucks big time - 0.5 estrellas"></label>
</div> ';
            echo ' <div  class="center">
                    <textarea name="comentario" maxlength="255" rows="5" cols="50"></textarea>
                    </div>
            <button style="width:400px" type="submit" class="submit action-button"  name = "enviar">Enviar Comentario</button>
       </form></div></div></div></div>';
        }
        ?>
        <div id="footer"></div>
    </body>
</html>