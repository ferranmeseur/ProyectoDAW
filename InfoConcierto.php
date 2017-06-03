<!DOCTYPE html>
<html>
    <head>
        <title>Información Concierto</title>
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
        <link href="Estilos/Estilos.css" rel="stylesheet" type="text/css"/>
        <link href="Estilos/RegistrationForm.css" rel="stylesheet" type="text/css"/>
        <link href="Estilos/StarRating.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div id="header"></div> 
        <div class="center" style="width: 100%; height: 500px">
            <?php
            require_once'bbdd.php';
            if (isset($_GET['b'])) {
                $nombre = $_GET['nombre'];
                TraceEvent("BUSQUEDA", $nombre, "NULL", "CONCIERTO", "NULL");
            }
            $resultado = infoConcierto($_GET['idcon']);
            $puntuacion = votosConcierto($_GET['idcon']);
            $fecha = getNombreFecha(date("w-d-m-Y", strtotime($resultado['FECHA'])));
            $comentarios = comentariosConcierto($_GET['idcon']);
            $local = getNombreLocal(($resultado['ID_LOCAL']));
            echo'<div class="center content">';
            echo '<h1 class="center">' . $fecha . ' - ' . $local['NOMBRE_LOCAL'] . '</h1>';
            echo'<div class="inline center">';
            echo'<img src="Imagenes/image.jpeg" alt=""/>';
            echo'</div>';
            echo '<div class="inline center">';
            echo'<b style="color:#d83c3c">CONCIERTO RATING</b><i id="puntuacion" hidden>' . $puntuacion . '</i><br>';
            echo '<fieldset class="center rating_fixed"style="float:none">
                        <input type="radio" id="star5" name="rating" value="5" /><label class = "full" for="star5" title="Fantástico - 5 stars"></label>
                        <input type="radio" id="star4half" name="rating" value="4 and a half" /><label class="half" for="star4half" title="Bastante bien - 4.5 stars"></label>
                        <input type="radio" id="star4" name="rating" value="4" /><label class = "full" for="star4" title="Bastante bien - 4 stars"></label>
                        <input type="radio" id="star3half" name="rating" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                        <input type="radio" id="star3" name="rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                        <input type="radio" id="star2half" name="rating" value="2 and a half" /><label class="half" for="star2half" title="No muy bueno - 2.5 stars"></label>
                        <input type="radio" id="star2" name="rating" value="2" /><label class = "full" for="star2" title=" - 2 stars"></label>
                        <input type="radio" id="star1half" name="rating" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                        <input type="radio" id="star1" name="rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                        <input type="radio" id="starhalf" name="rating" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
                        </fieldset> ';
            echo '<h1>' . $resultado['NOMBRE_ARTISTICO'] . '</h1>';
            echo'<div class="center">Fecha : ' . $fecha . '</div>';
            echo'<div class="center">Precio de la entrada : ' . $resultado['PRECIO_ENTRADA'] . ' €</div>';
            echo'<div class="center">Grupo : ' . $resultado['NOMBRE'] . '</div>';
            echo'<div class="center">Ciudad : ' . getNombreCiudad($resultado['ID_CIUDAD']) . '</div>';
            echo'<div class="center">Local : ' . $local['NOMBRE_LOCAL'] . '</div>';
            echo '<div class="center"> Calle : ' . $local['UBICACION'] . '</div>';
            echo'<div class="center">Genero : ' . getNombreGenero(($resultado['ID_GENERO'])) . '</div>';
            echo '<div class="center">Contacto : ';
            if ($resultado['WEB'] != null) {
                echo $local['WEB'] . ' , ';
            } 
            echo $local['EMAIL'] . ', ' . $local['NUMERO_CONTACTO'] . '</div>';
            if ($comentarios != false) {
                echo '</br></br><div class="center">Comentarios : <table class="center">';
                while ($lista = $comentarios->fetch_assoc()) {
                    echo'<tr><th>';
                    $fechacomentario = getNombreFecha(date("w-d-m-Y", strtotime($lista['FECHA'])));
                    echo $lista['NOMBRE'] . ' - ' . $fechacomentario . '</th></tr>';
                    echo '<tr><th>' . $lista['COMENTARIO'] . '</th></tr>';
                }
                echo'</table></div>';
                echo '</div></div>';
            }
            ?>
            <div id="footer"></div>
    </body>
</html>