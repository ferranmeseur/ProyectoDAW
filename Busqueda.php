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
                echo "<table>";
                echo '<tr><td>ARTISTAS</td></tr>';
                while ($row = $artistas->fetch_assoc()) {
                    $nombre_artistico = str_replace(" ", "+", $row['NOMBRE_ARTISTICO']);
                    echo "<tr><td><a class='fontblack' href=InfoGrupo.php?nombre=" . $nombre_artistico . ">" . $row['NOMBRE_ARTISTICO'] . "</a></td></tr> ";
                }
                echo "</table>";
            }
            if (isset($conciertoLocal)) {
                echo "<table>";
                echo '<tr><td>CONCIERTOS EN ' . $busqueda . '</td></tr>';
                while ($row = $conciertoLocal->fetch_assoc()) {
                    $nombre_artistico = str_replace(" ", "+", $row['NOMBRE_ARTISTICO']);
                    echo "<tr><td><a class='fontblack' href=InfoGrupo.php?nombre=" . $nombre_artistico . ">" . $row['NOMBRE_ARTISTICO'] . "</a> " . $row['FECHA'] . "</td></tr> ";
                }
                echo "</table>";
            }
            if (isset($conciertoArtista)) {
                echo "<table>";
                echo '<tr><td>CONCIERTOS DE ' . $busqueda . '</td></tr>';
                while ($row = $conciertoArtista->fetch_assoc()) {
                    list($año, $mes, $dia, $hora, $minuto) = split('[-:]', $row['FECHA']);
                    $nombre_local = str_replace(" ", "+", $row['NOMBRE_LOCAL']);
                    echo "<tr><td><a class='fontblack' href=InfoLocal.php?nombre=" . $nombre_local . ">" . $row['NOMBRE_LOCAL'] . "</a> el día $dia de $mes de $año a las $hora:$minuto</td></tr> ";
                }
                echo "</table>";
            }
        } else {
            
        }
        ?>
        <div id="footer"></div>
    </body>
</html>

