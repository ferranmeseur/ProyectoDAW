<!DOCTYPE html>
<html>
    <head>
        <title>RANKING</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script>
            $(function () {
                $("#header").load("Header.html");
                $("#footer").load("Footer.html");
            });
        </script> 
        <link href="Estilos/Estilos.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div id="header"></div>
        <div id="header"></div>  
        <!--BARRA BUSQUEDA-->
        <div id="Search" class="height_40 padding20">
            <form class="form-wrapper cf" action="Busqueda.php" method="GET">
                <input type="text" name="busqueda" placeholder="Busca músicos o locales" required>
                <button class="button-form" type="submit" value="submit" name="submit">GO!</button>
            </form>
        </div>
        <div id="contenedor" class="center">
            <h2>ARTISTAS EN ALZA</h2>
            <i>Artistas con más votos de los fans</i>
            <?php
            require_once 'bbdd.php';
            $result = RankingMusicos();
            $i = 1;
            echo'<table>';
            while ($row = $result->fetch_assoc()) {
                echo '<div id="musicoRanking'.$i.'">';
                echo '<div class="div_peque_ranking"></div>';
                echo '<div class="div_ranking">';
                echo '<img class="img_div_ranking inline" src="Imagenes/image.jpeg">';
                echo '<dvi class="nombre_artista inline vertical_top padding5"><h3 class="color_rojo_general">'.$row['NOMBRE'].'</h3></dvi>';
                echo '</div>';
                echo '<img class="img_ranking_numero" src="Imagenes/ranking'.$i.'.png">';
                echo '</div>';
                $i++;
                if ($i == 6) {
                    break;
                }
            }
            echo'</table>';
            ?>
        </div>
        
                

        <div class="margin_top_200px" id="footer"></div>
    </body>
</html>
