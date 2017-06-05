<!DOCTYPE html>
<html>
    <head>
        <title>BUSQUEDA</title>
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
    </head>
    <body>
        <div id="header"></div>

        <!--BARRA BUSQUEDA-->
        <div class="center">
            <div id="Search" class="height_40 padding20">
                <form class="form-wrapper cf" action="Busqueda.php" method="GET">
                    <input type="text" name="busqueda" placeholder="Busca músicos y locales" required>
                    <button class="button-form" type="submit" value="submit" name="submit">GO!</button>
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
            </div>
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
                if (isset($locales)) {
                    while ($row = $locales->fetch_assoc()) {
                        $imagen = getImageID($row['ID_USUARIO']);
                        $nombre_local = str_replace(" ", "+", $row['NOMBRE_LOCAL']);
                        $var2 = "<div style='width:300px'><a class='fontblack' href=InfoLocal.php?nombre=" . $nombre_local . "&b=true><div class='inline'><img id='img_resultado_busqueda' src='".$imagen."'><div class='inline'><h4>" . $row['NOMBRE_LOCAL'] . "</h4><i>DESCRIPCION</i></a></div></div></div>";
                        echo'<script language="javascript">$("#resultadoLocales").append("' . $var2 . '");</script>';
                    }
                } else {
                    echo'<script language="javascript">$("#resultadoLocales").empty();$("#resultadoLocales").width(0);</script>';
                }
                if (isset($artistas)) {
                    while ($row = $artistas->fetch_assoc()) {
                                                $imagen = getImageID($row['ID_USUARIO']);
                        $nombre_artistico = str_replace(" ", "+", $row['NOMBRE_ARTISTICO']);
                        $var2 = "<div style='width:300px'><a class='fontblack' href=InfoGrupo.php?nombre=" . $nombre_artistico . "&b=true><div class='inline'><img id='img_resultado_busqueda' src='".$imagen."'><div class='inline'><h4>" . $row['NOMBRE_ARTISTICO'] . "</h4><i>" . $row['NOMBRE_GENERO'] . "</i></a></div></div></div>";
                        echo'<script language="javascript">$("#resultadoArtistas").append("' . $var2 . '");</script>';
                    }
                } else {
                    echo'<script language="javascript">$("#resultadoArtistas").empty(); $("#resultadoArtistas").width(0);</script>';
                }
//                if (isset($conciertoLocal)) {
//                    echo "<div id='div_lista'>";
//                    echo '<h2 id="h2_lista">Conciertos en ' . $busqueda . '</h2>';
//                    echo'<ul id="ul_lista">';
//
//                    while ($row = $conciertoLocal->fetch_assoc()) {
//                        echo "<li id='li_lista'><a div='a_lista' class='fontblack' href=InfoGrupo.php?nombre=" . $row['NOMBRE_ARTISTICO'] . "&b=true>" . $row['NOMBRE_ARTISTICO'] . " " . $row['FECHA'] . "</a></li>";
//                        echo "</ul></div>";
//                    }
//                }else{
//                    echo'<script language="javascript">$("#resultadoConciertoLocal").empty();</script>';
//                }
//                if (isset($conciertoArtista)) {
//                    echo "<div id='div_lista'>";
//                    echo '<h2 id="h2_lista">Conciertos de ' . $busqueda . '</h2>';
//                    echo '<ul id="ul_lista">';
//                    while ($row = $conciertoArtista->fetch_assoc()) {
//                        list($año, $mes, $dia, $hora, $minuto) = split('[-:]', $row['FECHA']);
//                        $nombre_local = str_replace(" ", "+", $row['NOMBRE_LOCAL']);
//                        echo "<li id='li_lista'><a id='a_lista' class='fontblack' href=InfoLocal.php?nombre=" . $nombre_local . "&b=true>" . $row['NOMBRE_LOCAL'] . " el día $dia de $mes de $año a las $hora:$minuto</a></li>";
//                        echo "</ul></div>";
//                    }
//                }else{
//                    echo'<script language="javascript">$("#resultadoConciertoArtista").empty();</script>';
//                }
                TrendingResultados();
            }
        } else {
            echo'<script language="javascript">$("#resultadoArtistas").empty(); $("#resultadoArtistas").width(0);</script>';
            echo'<script language="javascript">$("#resultadoLocales").empty(); $("#resultadoLocales").width(0);</script>';
            TrendingResultados();
        }
        ?>
        <div class="margin_top_200px" id="footer"></div>
    </body>
</html>