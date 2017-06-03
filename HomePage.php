<!DOCTYPE html>
<HTML>
    <head>
        <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
        <title>INICIO</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script>
            $(function () {
                $("#header").load("HeaderImg.html");
                $("#footer").load("Footer.html");
                $("#noticias").load("Noticias.php");
            });
        </script> 
        <link href="Estilos/Estilos.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div id="header"></div>
        <div class="content center">
            <div class="center">
                <div id="Search" class="height_40 padding20">
                    <form class="form-wrapper cf" action="Busqueda.php" method="GET">
                        <input type="text" name="busqueda" placeholder="Busca músicos y locales" required>
                        <button class="button-form" type="submit" value="submit" name="submit">GO!</button>
                    </form>
                </div>
            </div>
            <div  id="noticias"></div>
            <div id="Secciones" class="center inline">
                <div id="Ranking" class=" inline">
                    <div id="imagen_ranking" class="inline">
                        <a href="Grupo.php"><img  class="img_default width_70" src="Imagenes/RANKING.jpg" alt="Ranking" /></a>
                    </div>
                </div>
                <div id="Conciertos" class=" inline">
                    <div id="imagen_conciertos" class="inline">
                        <a href="Concierto.php"><img class="img_default width_70" src="Imagenes/CONCIERTO.jpg"  alt="Conciertos" /></a>
                    </div>
                </div>
            </div>
            <div id="Secciones" class="center inline">
                <div id="Grupos" class="inline">
                    <div id="imagen_grupos" class="inline">
                        <a href="Grupo.php"><img class="img_default width_70" src="Imagenes/GRUPO.jpg"  alt="Grupos" /></a>
                    </div>
                </div>
                <div id="Locales" class=" inline">
                    <div id="imagen_locales" class="inline">
                        <a href="Local.php"><img class="img_default width_70" src="Imagenes/LOCAL.jpg"  alt="Locales" /></a>
                    </div>
                </div>
            </div>
        </div>
        <div id="footer"></div>
    </body>
</HTML>
