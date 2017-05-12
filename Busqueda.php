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

            if (isset($locales)) {
                echo "<table>";
                echo '<tr><td>LOCALES</td></tr>';
                while ($row = $locales->fetch_assoc()) {
                    $nombre_local = str_replace(" ", "+", $row['NOMBRE_LOCAL']);
                    echo "<tr><td><a class='fontblack' href=InfoLocal.php?nombre=" . $nombre_local . ">" . $row['NOMBRE_LOCAL'] . "</a></td></tr>";
                }
                echo "</table>";
            }
            if (isset($artistas)) {
                echo '<div>';
                echo '<h5>Artistas</h5>';
                while ($row = $artistas->fetch_assoc()) {
                    $nombre_artistico = str_replace(" ", "+", $row['NOMBRE_ARTISTICO']);
                    echo "<a class='fontblack' href=InfoGrupo.php?nombre=" . $nombre_artistico . ">" . $row['NOMBRE_ARTISTICO'];
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
                    echo "<a class='fontblack' href=InfoGrupo.php?nombre=" . $nombre_artistico . ">" . $row['NOMBRE_ARTISTICO'] . "</a> " . $row['FECHA'] . "</td></tr> ";
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
                    echo "<tr><td><a class='fontblack' href=InfoLocal.php?nombre=" . $nombre_local . ">" . $row['NOMBRE_LOCAL'] . "</a> el día $dia de $mes de $año a las $hora:$minuto</td></tr> ";
                    echo '<figure>
                    <img src = "path-to-the-image" alt = "">
                    </figure>
                    </a>
                    </div> ';
                }
            }
        } else {
            
        }
        ?>
        <div id="footer"></div>
    </body>
</html>

