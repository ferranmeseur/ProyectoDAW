<!DOCTYPE html>
<?php
            require_once 'bbdd.php';
            if (isset($_POST["submit"])) {
                $busqueda = $_POST["busqueda"];
                BusquedaLocal($busqueda);
                BusquedaArtista($busqueda);
                BusquedaConciertoPorLocal($nombre);
                BusquedaConciertoPorArtista($busqueda);
            }
            ?>
<html>
    <head>
        <title>MusicAndSeek</title>
        <meta charset="UTF-8">
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script>
            $(function () {
                $("#header").load("Header.html");
                $("#footer").load("Footer.html");
            });
        </script> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="Estilos/Estilos.css" rel="stylesheet" type="text/css"/>
    </head>
    <body class="center">
        <div id="header"></div>      
        <div class="center fondocontent" id="Noticias">
            <div id="imagen_noticias" class="center height_40 width_60 inline">
                <img class="img_default" src="Imagenes/image.jpeg" style="" alt=""/>
            </div>
            <div class="center width_60 height_20 inline"></div>
            <div class="center width_60 height_20 inline">NOTICIAS</div>
        </div>
        <div id="Search" class="height_40">
            <form class="form-wrapper cf" method = "POST">
                <input type="text" name="busqueda" placeholder="Busca músicos, locales o conciertos" required>
                <button type="submit" name = "submit">GO!</button>
            </form>
        </div>
        <div id="Secciones">
            <div id="Ranking" class="width_48 inline">
                <div id="imagen_ranking" class="center width_40 height_80 inline">
                    <img class="img_default" src="Imagenes/image.jpeg" alt=""/>
                </div>
                <div>
                    <div class="width_40 height_20 inline">Ranking</div>
                </div>
            </div>
            <div id="Conciertos" class="width_48 inline">
                <div id="imagen_conciertos" class="center width_40 height_80 inline">
                    <img class="img_default" src="Imagenes/image.jpeg" alt=""/>
                </div>
                <div>
                    <div class="width_40 height_20 inline">Conciertos</div>
                </div>
            </div>
            <br>
            <div id="Grupos" class="width_48 inline">
                <div id="imagen_grupos" class="center width_40 height_80 inline">
                    <img class="img_default" src="Imagenes/image.jpeg" alt=""/>
                </div>
                <div>
                    <div class="width_40 height_20 inline">Grupos</div>
                </div>
            </div>
            <div id="Locales" class="width_48 inline">
                <div id="imagen_locales" class="center width_40 height_80 inline">
                    <img class="img_default" src="Imagenes/image.jpeg" alt=""/>
                </div>
                <div>
                    <div class="width_40 height_20 inline">Locales</div>
                </div>
            </div>
        </div>
        <div id="footer"></div>
    </body>
</html>
