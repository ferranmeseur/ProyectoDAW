<!DOCTYPE html>
<html>
    <head>
        <title>CONCIERTOS</title>
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
        <link href="Estilos/StarRating.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div id="header"></div>
        <div style="height: 50px"></div>
        <div id="Search" class="height_40">
            <form class="form-wrapper cf" action="Busqueda.php" method="GET">
                <input type="text" name="busqueda" placeholder="Busca músicos o locales" required>
                <button class="button-form" type="submit" value="submit" name="submit">GO!</button>
            </form>
        </div>
        <div style="height: 20px"></div>
        <div id="busquedaArtistas" style="width:500px;margin:auto auto auto auto;">
            <?php
            include_once'bbdd.php';
            echo '<form method="POST" action="Local.php">';
            echo '<span class="inline custom-dropdown border_dropdow">';
            $generos = ListaGeneros();
            echo'<select name="genero">
                <option selected value="">Todos los generos</option>';
            while ($fila2 = mysqli_fetch_array($generos)) {
                extract($fila2);
                echo"<option value='$ID_GENERO'>$NOMBRE</option>";
            }
            echo'</select></span>';
            echo '<span class="inline custom-dropdown border_dropdow">';
            $ciudades = ListaCiudades();
            echo'<select name="ciudad">
                    <option selected value="">Todas las ciudades</option>';
            while ($fila2 = mysqli_fetch_array($ciudades)) {
                extract($fila2);
                echo"<option value='$ID_CIUDAD'>$NOMBRE</option>";
            }
            echo'</select></span>';
            echo '<button class="button-form-solo inline" type="submit" value="submit" name="submit">BUSCAR</button>';
            echo '</form>';
            ?>
        </div>
        <div id="contenedor" class="center" style="width:100%;height:100%">
            <div id="grupos" class="inline" style="width:30%;padding-right:100px">
                <?php
                require_once 'bbdd.php';
                require_once'BusquedaMusicos.php';
                if (isset($_POST['ciudad'])) {
                    $ciudad = $_POST['ciudad'];
                } else {
                    $ciudad = null;
                }
                if (isset($_POST['genero'])) {
                    $genero = $_POST['genero'];
                } else {
                    $genero = null;
                }

                $letras = getFirstLetterLocales();

                echo'<div style="width:100%">';
                echo'<h2>LISTA DE LOCALES</h2>';

                while ($row = $letras->fetch_assoc()) {
                    $result = BusquedaTodosLocales($ciudad, $row['LETRA']);
                    $letra = strtoupper($row['LETRA']);
                    if ($result == null) {
                        echo '<script language="javascript">$("#' . $letra . '").empty();</script>';
                    } else {

                        echo '<div id="resultado">';
                        echo '<div style="float:left;padding:5px;border-bottom: 1px solid #d83c3c">';
                        echo '<h3 id="' . $letra . '" class="color_rojo_general">' . $letra . '</h3>';
                        echo '</div>';
                        echo '<table cellspacing=0 style="width:100%">';
                        echo '<col width="auto">';
                        echo '<col width="0">';
                        $i = 0;
                        while ($lista = $result->fetch_assoc()) {
                            $nombre_local = str_replace(" ", "+", $lista['NOMBRE_LOCAL']);
                            $nombreCiudad = getNombreCiudad($lista['ID_CIUDAD']);
                            echo '<tr>';
                            echo '<td class="padding5" style="border-bottom:1px solid gray;text-align:left;vertical-align:top">';
                            echo '<a class="fontblack a_concierto" href=InfoLocal.php?nombre=' . $nombre_local . '>';
                            echo '<div class="inline" id="div_img">';
                            echo '<img id="img_lista_img" class="inline" src="Imagenes/image.jpeg">';
                            echo '</div>';
                            echo '<div class="inline" style="vertical-align:top">';
                            echo '<div>';
                            echo '<b id="h4_lista_img">' . $lista['NOMBRE_LOCAL'] . '</b>';
                            echo '</div>';
                            $average = votosGrupo($lista['ID_USUARIO']);
                            mostrarEstrellasPuntuacionLocal($average, $i);
                            echo '</div>';
                            echo '</a>';
                            echo '</td>';
                            echo '<td class="padding5" style="border-bottom:1px solid gray;text-align:right;vertical-align:top">';
                            echo '</td>';
                            echo '</tr>';
                            $i++;
                        }
                        echo'</table>';
                        echo'</div>';
                    }
                }
                echo'</div>';
                ?>
            </div>
            <div id="ranking" class="inline" style="vertical-align: top">

                <div class="center">
                    <?php
                    require_once 'bbdd.php';
                    echo'<h2>LOCALES EN ALZA</h2>';

                    $tituloRanking = "Todos los locales en alza";
                    if (isset($_POST['submit'])) {
                        $genero = $_POST['genero'];
                        $ciudad = $_POST['ciudad'];
                        if ($ciudad != null) {
                            $nombreCiudad = getNombreCiudad($ciudad);
                            $tituloRanking = "Locales en alza de " . $nombreCiudad;
                        }
                        if ($ciudad != null && $genero != null)
                            $tituloRanking = "Locales en alza de " . $nombreCiudad . " con género " . $nombreGenero;
                        if ($ciudad != null || $genero != null) {
                            $result = RankingMusicos($genero, $ciudad);
                            if ($result == null) {
                                echo "<div class='padding20 center cursiva'>No se ha encontrado ninguna coincidencia</div>";
                            } else {
                                LocalesAlza($ciudad, $tituloRanking);
                            }
                        } else {
                            LocalesAlza(null, $tituloRanking);
                        }
                    } else {
                        LocalesAlza(null, $tituloRanking);
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="margin_top_200px" id="footer"></div>
    </body>

    <div class="margin_left_100px" style="margin-right: 200px">


</html>



