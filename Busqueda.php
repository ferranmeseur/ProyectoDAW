<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
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

        <!--BARRA BUSQUEDA-->
        <div id="Search" class="height_40 padding20">
            <form class="form-wrapper cf" action="Busqueda.php" method="GET">
                <input type="text" name="busqueda" placeholder="Busca músicos, locales o conciertos" required>
                <button type="submit" value="submit" name="submit">GO!</button>
            </form>
        </div>
        <!-- TRENDING SEARCH -->
        <div class="trending_search">
            <div id="trendingSearchGrupos">
                <b><p class="color_rojo_general inline">GRUPOS MAS BUSCADOS</p></b>
            </div>
            <div id="trendingSearchLocales">
                <b><p class="color_rojo_general inline">LOCALES MAS BUSCADOS</p></b>
            </div>
        </ul>
    </div>


    <!-- RESULTADOS DE BUSQUEDA ARTISTAS | LOCALES | CONCIERTOS -->
    <div class="width_100 center">
        <div id="resultadoArtistas" class="inline width_48 center">
            <H2>ARTISTAS</h2>
        </div>
        <div id="resultadoLocales" class="inline width_48 center"><H2>LOCALES</h2>
        </div>
        <div id="resultadoConciertos" class="inline width_50"></div>
    </div>
    <?php
    require_once'bbdd.php';

    if (isset($_GET["submit"])) {
        $busqueda = $_GET["busqueda"];
        $locales = BusquedaLocal($busqueda);
        $artistas = BusquedaArtista($busqueda);
        $conciertoLocal = BusquedaConciertoPorLocal($busqueda);
        $conciertoArtista = BusquedaConciertoPorArtista($busqueda);
        if (!(isset($conciertoArtista)) && !(isset($conciertoLocal)) && !(isset($artistas)) && !(isset($locales))) {
            echo "<div class='padding20 center cursiva'>No se ha encontrado ninguna coincidencia con <u>$busqueda</u></div>";
            echo'<script language="javascript">$("#resultadoArtistas").empty(); $("#resultadoArtistas").width(0);</script>';
            echo'<script language="javascript">$("#resultadoLocales").empty(); $("#resultadoLocales").width(0);</script>';
            TrendingResultados();
        } else {
            
            TrendingResultados();
        }
    } else {
        echo'<script language="javascript">$("#resultadoArtistas").empty(); $("#resultadoArtistas").width(0);</script>';
        echo'<script language="javascript">$("#resultadoLocales").empty(); $("#resultadoLocales").width(0);</script>';
        TrendingResultados();
    }
    ?>
    <div id="footer"></div>
</body>
</html>