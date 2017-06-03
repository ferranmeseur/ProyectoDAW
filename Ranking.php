<!DOCTYPE html>
<html>
    <head>
        <title>RANKING</title>
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
        <link href="Estilos/StarRating.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div id="header"></div>   
        <div id="content center">
            <div class="inline center"  style="display:inline;">
                <?php
                require_once 'bbdd.php';
                ArtistasAlza(null, null, '');
                ?>
            </div>
            <div class="inline center" style="display:inline;">
                <?php
                require_once 'bbdd.php';
                echo'<h1><span class="color_rojo_general">Locales</span> en Alza</h1>';
                LocalesAlza(null, '');
                ?>
            </div>
        </div>
        <div id="footer" style="vertical-align: bottom"></div>
    </body>
</html>
