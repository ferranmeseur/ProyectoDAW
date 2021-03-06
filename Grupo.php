<!DOCTYPE html>
<html>
    <head>
        <title>Grupos</title>
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
        <link href="Estilos/RegistrationForm.css" rel="stylesheet" type="text/css"/>
        <link href="Estilos/StarRating.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div id="header"></div>
        <div class="content center">
            <div id="Search">
                <form class="form-wrapper cf" action="Busqueda.php" method="GET">
                    <input type="text" name="busqueda" placeholder="Busca músicos o locales" required>
                    <button class="button-form" type="submit" value="submit" name="submit">GO!</button>
                </form>
            </div>
            <div style="height: 20px"></div>
            <h1> Encuentra los <span class="color_rojo_general">Grupos</span> más trascendentes </h1>
            <div id="busquedaArtistas" style="width:500px;margin:auto auto auto auto;">
                <?php
                include_once'bbdd.php';
                session_start();
                if (isset($_SESSION['tipo'])) {
                    $tipoUsuario = $_SESSION['tipo'];
                }
                echo '<form method="POST" action="Grupo.php">';
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
            <div id="contenedor" class="center">
                <div id="grupos" class="inline" style="padding-right:100px">
                    <?php
                    require_once 'bbdd.php';
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

                    $letras = getFirstLetterArtistas();
                    echo'<div>';
                    echo'  <h1>Lista de <span class="color_rojo_general">Artistas</span></h2>';

                    while ($row = $letras->fetch_assoc()) {
                        $result = BusquedaTodosArtistas($ciudad, $genero, $row['LETRA']);
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
                                $nombre_artistico = str_replace(" ", "+", $lista['NOMBRE_ARTISTICO']);
                                $nombreGenero = getNombreGenero($lista['ID_GENERO']);
                                $nombreCiudad = getNombreCiudad($lista['ID_CIUDAD']);
                                $imagen = getImageID($lista['ID_USUARIO']);
                                echo '<tr>';
                                echo '<td class="padding5" style="border-bottom:1px solid gray;text-align:left;vertical-align:top">';
                                echo '<a class="fontblack a_concierto" href=InfoGrupo.php?nombre=' . $nombre_artistico . '>';
                                echo '<div class="inline">';
                                echo '<img id="img_lista_img" class="inline" src="' . $imagen . '">';
                                echo '<b id="h4_lista_img">' . $lista['NOMBRE_ARTISTICO'] . '</b>';
                                $average = votosGrupo($lista['ID_USUARIO']);
                                mostrarEstrellasPuntuacionLocal($average, $i);
                                echo '</div>';
                                echo '</a>';
                                echo '</td>';
                                echo '<td class="padding5" style="border-bottom:1px solid gray;text-align:right;vertical-align:top">';
                                echo '<div class="inline padding5">';
                                echo '<i><b>' . $nombreGenero . ', ' . $nombreCiudad . '</b></i><br><BR>';
                                if (isset($tipoUsuario)) {
                                    if ($tipoUsuario == 'Local')
                                        echo '<a href="CrearConcierto.php?idgrupo=' . $lista['ID_USUARIO'] . '" style = "width:100px" class = "action-button">PROPONER</a>';
                                }
                                echo '</div>';

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
                        $tituloRanking = '<h1>Todos los<span class="color_rojo_general"> Artistas</span> en Alza</h2>';
                        if (isset($_POST['submit'])) {
                            $genero = $_POST['genero'];
                            $ciudad = $_POST['ciudad'];
                            if ($ciudad != null) {
                                $nombreCiudad = getNombreCiudad($ciudad);
                                $tituloRanking = "Artistas en alza de " . $nombreCiudad;
                            }
                            if ($genero != null) {
                                $nombreGenero = getNombreGenero($genero);
                                $tituloRanking = "Artistas en alza de genero " . $nombreGenero;
                            }
                            if ($ciudad != null && $genero != null)
                                $tituloRanking = "Artistas en alza de " . $nombreCiudad . " con género " . $nombreGenero;
                            if ($ciudad != null || $genero != null) {
                                $result = RankingMusicos($genero, $ciudad);
                                if ($result == null) {
                                    echo "<div class='padding20 center cursiva'>No se ha encontrado ninguna coincidencia</div>";
                                } else {
                                    ArtistasAlza($genero, $ciudad, $tituloRanking);
                                }
                            } else {
                                ArtistasAlza(null, null, $tituloRanking);
                            }
                        } else {
                            ArtistasAlza(null, null, $tituloRanking);
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div id="footer"></div>
    </body>
</html>



