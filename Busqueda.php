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
        <?php
        require_once'bbdd.php';

        if (isset($_GET["submit"])) {
            $busqueda = $_GET["busqueda"];
            $locales = BusquedaLocal($busqueda);
            $artistas = BusquedaArtista($busqueda);
            $conciertoLocal = BusquedaConciertoPorLocal($busqueda);
            $conciertoArtista = BusquedaConciertoPorArtista($busqueda);
            if (!(isset($conciertoArtista)) && !(isset($conciertoLocal)) && !(isset($artistas)) && !(isset($locales))) {
                echo "No se ha encontrado ninguna coincidencia con $busqueda";
            } else {
                if (isset($locales)) {
                    echo "<table>";
                    echo '<tr><td>LOCALES</td></tr>';
                    while ($row = $locales->fetch_assoc()) {
                        $nombre_local = str_replace(" ", "+", $row['NOMBRE_LOCAL']);
                        echo "<tr><td><a class='fontblack' href=InfoLocal.php?nombre=" . $nombre_local . "?b=true>" . $row['NOMBRE_LOCAL'] . "</a></td></tr>";
                    }
                    echo "</table>";
                }
                if (isset($artistas)) {
                    echo '<div>';
                    echo '<h3>Artistas</h3>';
                    while ($row = $artistas->fetch_assoc()) {
                        $nombre_artistico = str_replace(" ", "+", $row['NOMBRE_ARTISTICO']);
                        echo "<a class='fontblack' href=InfoGrupo.php?nombre=" . $nombre_artistico . "?b=true>" . $row['NOMBRE_ARTISTICO'];
                        echo '<figure>
                    <img src = "path-to-the-image" alt = "">
                    </figure>
                    </a>
                    </div> ';
                    }
                }
                if (isset($conciertoLocal)) {
                    echo "<div>";
                    echo '<h5>Conciertos en ' . $busqueda . '</h5>';
                    while ($row = $conciertoLocal->fetch_assoc()) {
                        $nombre_artistico = str_replace(" ", "+", $row['NOMBRE_ARTISTICO']);
                        echo "<a class='fontblack' href=InfoGrupo.php?nombre=" . $nombre_artistico . "?b=true>" . $row['NOMBRE_ARTISTICO'] . "</a> " . $row['FECHA'] . "</td></tr> ";
                        echo '<figure>
                    <img src = "path-to-the-image" alt = "">
                    </figure>
                    </a>
                    </div> ';
                    }
                }
                if (isset($conciertoArtista)) {
                    echo "<div>";
                    echo '<h5>Conciertos de ' . $busqueda . '</h5>';
                    while ($row = $conciertoArtista->fetch_assoc()) {
                        list($año, $mes, $dia, $hora, $minuto) = split('[-:]', $row['FECHA']);
                        $nombre_local = str_replace(" ", "+", $row['NOMBRE_LOCAL']);
                        echo "<tr><td><a class='fontblack' href=InfoLocal.php?nombre=" . $nombre_local . "?b=true>" . $row['NOMBRE_LOCAL'] . "</a> el día $dia de $mes de $año a las $hora:$minuto</td></tr> ";
                        echo '<figure>
                    <img src = "path-to-the-image" alt = "">
                    </figure>
                    </a>
                    </div> ';
                    }
                }
            }
        } else {
            //AÑADIR BUSCADOR AQUI
            $result = TrendingBusqueda("grupo");
            echo '<div>';
            echo '<h3>Grupos más buscados: </h3>';
            while ($row = $result->fetch_assoc()) {
                $nombre = str_replace(" ", "+", $row['NOMBRE']);
                echo "<a href=InfoGrupo.php?nombre=" . $nombre .">" . $row['NOMBRE'] . "</a>";
            }
            echo '</div>';
        }
        ?>
        <div id="footer"></div>
    </body>
</html>