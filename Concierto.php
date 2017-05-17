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

        <div class=" center">
            <?php
            require_once 'bbdd.php';
            require_once'BusquedaConciertos.php';
            if (isset($_POST['submit'])) {
                BusquedaConciertos();

                $ciudad = $_POST['ciudad'];
                $genero = $_POST['genero'];
                $grupo = $_POST['grupo'];
                $local = $_POST['id_local'];
                $result = ListaConciertos($genero, $ciudad, $grupo, $local);
                echo "<tr>
                            <td>NOMBRE GRUPO</td>
                            <td>NOMBRE LOCAL</td>
                            <td>FECHA</td>
                            <td>HORA</td>
                            </tr>";

                while ($row = $result->fetch_assoc()) {
                    $nuevaFecha = date("d-m-Y", strtotime($row["FECHA"]));
                    $nuevaHora = date("H:i", strtotime($row["FECHA"]));
                    $nombre_artistico = str_replace(" ", "+", $row['NOMBRE_ARTISTICO']);
                    $nombre_local = str_replace(" ", "+", $row['NOMBRE_LOCAL']);
                    echo "<tr>";
                    echo "<td><a class='fontblack' href=InfoGrupo.php?nombre=" . $nombre_artistico . ">" . $row["NOMBRE_ARTISTICO"] . "</a></td><td><a class='fontblack' href=InfoLocal.php?nombre=" . $nombre_local . ">" . $row["NOMBRE_LOCAL"] . "</a></td><td>" . $nuevaFecha . "</td><td>" . $nuevaHora . "</td></br>";
                    echo "</tr>";
                }
            } else {
                BusquedaConciertos();
            }
            ?>
        </div>
        <div id="footer" style="position:fixed;bottom:0; width:100%"></div>
    </body>
</html>



