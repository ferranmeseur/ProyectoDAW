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
        <link href="Estilos/Comments.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div id="header"></div> 
        <div class="center">
            <?php
            session_start();
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
            $imagen = getImageID($resultado['ID_USUARIO']);
            echo'<div class="center content">';
            echo '<h1 class="center">' . $fecha . ' - ' . $local['NOMBRE_LOCAL'] . '</h1>';
            echo'<div class="inline center" style="vertical-align:top">';
            echo'<img src="' . $imagen . '" alt="" style="width:250px"/>';
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
            echo'</div>';
            echo'</div>';

            echo $local['EMAIL'] . ', ' . $local['NUMERO_CONTACTO'] . '</div>';
            if ($comentarios != false) {
                echo '</br></br><div class="container">';
                while ($lista = $comentarios->fetch_assoc()) {
                    $image = getImageID($lista['ID_USUARIO']);
                    echo'<div class="row center">
                    <div class="col-sm-8">
                    <div class="panel panel-white post panel-shadow">
                    <div class="post-heading">
                    <div class="pull-left image">
                        <img src="' . $imagen . '" class="img-circle avatar" alt="user profile image">
                    </div>
                    <div class="pull-left meta">
                    <div class="title h5">
                    <b>' . $lista['NOMBRE'] . ' ' . $lista['APELLIDOS'] . '</b>
                            ha realizado un comentario
                        </div>
                        <h6 class="text-muted time">El ' . getNombreFecha(date("w-d-m-Y", strtotime($lista['FECHA']))) . '</h6>
                    </div>
                </div> 
                <div class="post-description"> 
                   <p> ' . $lista['COMENTARIO'] . '</p>
                    </div>
                </div>
            </div>
        </div>
        </div>';
                }
                echo'</div>';
            }
            echo '</div></div>';

            if (isset($_POST["enviar"])) {
                $check = 1;
                $puntos = $_POST["rating2"];
                echo $puntos;
                $comentario = $_POST["comentario"];
                $user = getInfoUser($_SESSION['email']);
                votarComentarConcierto($user['ID_USUARIO'], $resultado['ID_USUARIO'], $puntos, $comentario);
                if ($check == 0)
                    redirectURL('InfoConcierto.php');
            }
            if (isset($_SESSION['email'])) {
                $user = getInfoUser($_SESSION['email']);
                $check = checkVotar($resultado['ID_USUARIO'], $user['ID_USUARIO']);
            }
            if (isset($_SESSION['pass']) && $user['TIPO_USUARIO'] == "Fan" && $check == 0) {
                echo ' <div  class="center">';
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
       </form></div></div></div></div></div>';
            }
            echo'</div>';
            echo'</div>';
            echo'</div>';
            echo'</div>';
            ?>
            <div id="footer"></div>
    </body>
</html>