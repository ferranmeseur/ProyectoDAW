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
            .panel-shadow {
                box-shadow: rgba(0, 0, 0, 0.3) 7px 7px 7px;
            }
            .panel-white {
                border: 1px solid #dddddd;
            }
            .panel-white  .panel-heading {
                color: #333;
                background-color: #fff;
                border-color: #ddd;
            }
            .panel-white  .panel-footer {
                background-color: #fff;
                border-color: #ddd;
            }

            .post .post-heading {
                height: 30px;
                padding: 20px 15px;
            }
            .post .post-heading .avatar {
                width: 60px;
                height: 60px;
                display: block;
                margin-right: 15px;
            }
            .post .post-heading .meta .title {
                margin-bottom: 0;
            }
            .post .post-heading .meta .title a {
                color: black;
            }
            .post .post-heading .meta .title a:hover {
                color: #aaaaaa;
            }
            .post .post-heading .meta .time {
                margin-top: 8px;
                color: #999;
            }
            .post .post-image .image {
                width: 100%;
                height: auto;
            }
            .post .post-description {
                padding: 15px;
                max-width: 300px;
            }
            .post .post-description p {
                font-size: 14px;
            }
            .post .post-description .stats {
                margin-top: 20px;
            }
            .post .post-description .stats .stat-item {
                display: inline-block;
                margin-right: 15px;
            }
            .post .post-description .stats .stat-item .icon {
                margin-right: 8px;
            }
            .post .post-footer {
                border-top: 1px solid #ddd;
                padding: 15px;
            }
            .post .post-footer .input-group-addon a {
                color: #454545;
            }
            .post .post-footer .comments-list {
                padding: 0;
                margin-top: 20px;
                list-style-type: none;
            }
            .post .post-footer .comments-list .comment {
                display: block;
                width: 100%;
                margin: 20px 0;
            }
            .post .post-footer .comments-list .comment .avatar {
                width: 35px;
                height: 35px;
            }
            .post .post-footer .comments-list .comment .comment-heading {
                display: block;
                width: 100%;
            }
            .post .post-footer .comments-list .comment .comment-heading .user {
                font-size: 14px;
                font-weight: bold;
                display: inline;
                margin-top: 0;
                margin-right: 10px;
            }
            .post .post-footer .comments-list .comment .comment-heading .time {
                font-size: 12px;
                color: #aaa;
                margin-top: 0;
                display: inline;
            }
            .post .post-footer .comments-list .comment .comment-body {
                margin-left: 50px;
            }
            .post .post-footer .comments-list .comment > .comments-list {
                margin-left: 50px;

            }
        </style>
        <link href="Estilos/Estilos.css" rel="stylesheet" type="text/css"/>
        <link href="Estilos/RegistrationForm.css" rel="stylesheet" type="text/css"/>
        <link href="Estilos/StarRating.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div id="header"></div> 
        <?php
        require_once'bbdd.php';
        if (isset($_GET['b'])) {
            $nombre = $_GET['nombre'];
            TraceEvent("BUSQUEDA", $nombre, "NULL", "LOCAL", "NULL");
        }
        echo'<div class="center content">';
        echo'<div class="inline center" style="vertical-align:top">';
        echo'<img src="Imagenes/image.jpeg" alt=""/>';
        echo'</div>';
        echo '<div class="inline">';
        $resultado = getInfoLocalName($_GET['nombre']);
        $puntuacion = votosLocal($resultado['ID_USUARIO']);
        $comentarios = comentariosGrupo($resultado['ID_USUARIO']);
        echo '<h1>' . $resultado['NOMBRE_LOCAL'] . '</h1>';
        echo'<b style="color:#d83c3c">LOCAL RATING</b><i id="puntuacion" hidden>' . $puntuacion . '</i><br>';
        echo '<fieldset class="rating_fixed center" style="float:none;width:70%">
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
        echo '<div class="center">Ubicación : ' . $resultado['UBICACION'] . '</div>';
        echo '<div class="center">Ciudad : ' . getNombreCiudad($resultado['ID_CIUDAD']) . '</div>';
        echo '<div class="center">Aforo : ' . $resultado['AFORO'] . '</div>';
        echo '<div class="center">Email : ' . $resultado['EMAIL'] . '</div>';
        echo '<div class="center">Contacto : ' . $resultado['NUMERO_CONTACTO'] . '</div>';
        if ($resultado['WEB'] != null) {
            echo'<div class="center">Web : >' . $resultado['WEB'] . '</div>';
        } 
        if ($resultado['DESCRIPCION'] != null) {
            echo '<div class="center">Descripción : ' . $resultado['DESCRIPCION'] . '</div>';
        }
        if ($comentarios != false) {
            echo '</br></br><div class="container">';
            while ($lista = $comentarios->fetch_assoc()) {
                echo'<div class="row">
                    <div class="col-sm-8">
                    <div class="panel panel-white post panel-shadow">
                    <div class="post-heading">
                    <div class="pull-left meta">
                    <div class="title h5">
                    <a href="#"><b>' . $lista['NOMBRE'] . ' ' . $lista['APELLIDOS'] . '</b></a>
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
            $comentario = $_POST["comentario"];
            $user = getInfoUser($_SESSION['email']);
            votarComentarNoConcierto($user['ID_USUARIO'], $resultado['ID_USUARIO'], $puntos, $comentario);
            if ($check == 0)
                header("Refresh:0");
        }
        if (isset($_SESSION['email'])) {
            $user = getInfoUser($_SESSION['email']);
            $check = checkVotar($resultado['ID_USUARIO'], $user['ID_USUARIO']);
        }
        if (isset($_SESSION['pass']) && $user['TIPO_USUARIO'] == "Fan" && $check == 0) {
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
       </form></div></div></div>';
        }
        ?>
        <div id="footer"></div>
    </body>
</html>