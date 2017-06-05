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
        <div class="margin_top_100px"></div>
        <div class="width_100 center">
            <div id="resultadoArtistas" class="inline width_48 center color_rojo_general" style="vertical-align:top">
                <H2>ARTISTAS</h2>
            </div>
            <div id="resultadoLocales" class="inline width_48 center color_rojo_general" style="vertical-align:top">
                <H2>LOCALES</h2>
            </div>
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
                    $var2 = "<div style='width:100%'><a class='fontblack' href=InfoLocal.php?nombre=" . $nombre_local . "&b=true><div class='inline' style='width:50%'><img id='img_resultado_busqueda' src='" . $imagen . "'><div class='inline'><h4>" . $row['NOMBRE_LOCAL'] . "</h4></div><textarea disabled style='border:0;overflow:hidden;resize: none;height:45px;width:100%'>".$row['DESCRIPCION']."</textarea></a></div></div>";
                        echo'<script language="javascript">$("#resultadoLocales").append("' . $var2 . '");</script>';
                    }
                } else {
                    echo'<script language="javascript">$("#resultadoLocales").empty();$("#resultadoLocales").width(0);</script>';
                }
                if (isset($artistas)) {
                    while ($row = $artistas->fetch_assoc()) {
                        $imagen = getImageID($row['ID_USUARIO']);
                        $nombre_artistico = str_replace(" ", "+", $row['NOMBRE_ARTISTICO']);
                        $var2 = "<div style='width:100%'><a class='fontblack' href=InfoGrupo.php?nombre=" . $nombre_artistico . "&b=true><div class='inline' style='width:50%'><img id='img_resultado_busqueda' src='" . $imagen . "'><div class='inline'><h4>" . $row['NOMBRE_ARTISTICO'] . " </h4></div> - <div class='inline'>  <i class='color_rojo_general'>  ".$row['NOMBRE_GENERO']."</div><textarea disabled style='border:0;overflow:hidden;resize: none;height:45px;width:100%'>".$row['DESCRIPCION']."</textarea></a></div></div>";
                        echo'<script language="javascript">$("#resultadoArtistas").append("' . $var2 . '");</script>';
                    }
                } else {
                    echo'<script language="javascript">$("#resultadoArtistas").empty(); $("#resultadoArtistas").width(0);</script>';
                }

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