<!DOCTYPE html>
<html>
    <link rel="apple-touch-icon" sizes="57x57" href="Imagenes/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="Imagenes/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="Imagenes/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="Imagenes/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="Imagenes/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="Imagenes/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="Imagenes/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="Imagenes/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="Imagenes/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="Imagenes/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="Imagenes/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="Imagenes/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="Imagenes/favicon-16x16.png">
<link rel="manifest" href="Imagenes/manifest.json">
<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">

    <head>
        <title>MusicAndSeek</title>
        <meta charset="UTF-8">
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script>
            $(function () {
                $("#header").load("HeaderImg.html");
                $("#footer").load("Footer.html");
            });
        </script> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="ImagenesEstilos/Estilos.css" rel="stylesheet" type="text/css"/>
    </head>
    <body class="center">
        <div id="header"></div></br> </br>  
        <div class="center fondocontent" id="Noticias">
            <div id="imagen_noticias" class="center height_40 width_60 inline">
                <img class="img_default" src="Imagenes/image.jpeg" style="" alt=""/>
            </div>
            <div class="center width_60 height_20 inline"></div>
            <div class="center width_60 height_20 inline">NOTICIAS</div>
        </div>
        <div id="Search" class="height_40">
            <form class="form-wrapper cf" action="Busqueda.php" method="GET">
                <input type="text" name="busqueda" placeholder="Busca músicos, locales o conciertos" required>
                <button type="submit" value="submit" name="submit">GO!</button>
            </form>
        </div>
        <?php
            require_once 'bbdd.php';
            
            ?>
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
