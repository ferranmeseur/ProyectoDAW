<!DOCTYPE html>
<HTML>
    <head>
        <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
        <title>Music and Seek</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script>
            $(function () {
                $("#header").load("HeaderImg.php");
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
                <h1> Bienvenido a <span class="color_rojo_general">Music And Seek!</span> </h1>
                <div id="Search" class="height_40 padding20 ">
                    <form class="form-wrapper cf" action="Busqueda.php" method="GET">
                        <input type="text" name="busqueda" placeholder="Busca músicos y locales" required>
                        <button class="button-form" type="submit" value="submit" name="submit">GO!</button>
                    </form>
                </div>
            </div>
            <div class='margingtop_30px'></div>
            <div  id="noticias"></div>
            <div class='margingtop_30px'></div>
            <div class="center inline ">
                <a href="Ranking.php.php"><div id='img_ranking' class="inline"></div></a>
                <a href="Concierto.php"><div id='img_concierto' class="inline"></div></a>
            </div>
            <div class="center inline ">
                <a href="Grupo.php"><div id='img_grupo' class="inline"></div></a>
                <a href="Local.php"><div id='img_local' class="inline"></div></a>
            </div>
        </div>
    </div>
    <div id="footer"></div>
</body>
</HTML>
