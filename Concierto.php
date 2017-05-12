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
    </head>
    <body class="width_100">
        <div id="header"></div>
        <div>&nbsp;</div>
        <div class=" center">
            <div class="center inline">
                <table>
                <?php
                require_once 'bbdd.php';
                if (isset($_POST['submit'])) {

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
                    ?></table>
                <?php
                } else {
                    echo'<form class="center" action= "Concierto.php" method = "POST" >';
                    echo '<div class="inline" style="text-align:left;padding-right:10px;">Ciudad:</br>';
                    $ciudades = ListaCiudades();
                    echo'<select name="ciudad">
                <option selected value="">Todos</option>';
                    while ($fila2 = mysqli_fetch_array($ciudades)) {
                        extract($fila2);
                        echo"<option value='$ID_CIUDAD'>$NOMBRE</option>";
                    }
                    echo'</select></div>';
                    echo '<div class="inline"style="text-align:left;padding-right:10px;">Genero:</br>';
                    $generos = ListaGeneros();
                    echo'<select name="genero">
                <option selected value="">Todos</option>';
                    while ($fila2 = mysqli_fetch_array($generos)) {
                        extract($fila2);
                        echo"<option value='$ID_GENERO'>$NOMBRE</option>";
                    }
                    echo'</select></div>';
                    echo '<div class="inline"style="text-align:left;padding-right:10px;">Grupo:</br>';
                    $grupos = ListaGrupos();
                    echo'<select name="grupo">
                <option selected value="">Todos</option>';
                    while ($fila2 = mysqli_fetch_array($grupos)) {
                        extract($fila2);
                        echo"<option value='$ID_USUARIO'>$NOMBRE_ARTISTICO</option>";
                    }
                    echo'</select></div>';
                    echo '<div class="inline"style="text-align:left;">Locales:</br>';
                    $locales = ListaLocales();
                    echo'<select name="id_local">
                <option selected value="">Todos</option>';
                    while ($fila2 = mysqli_fetch_array($locales)) {
                        extract($fila2);
                        echo"<option value='$ID_USUARIO'>$NOMBRE_LOCAL</option>";
                    }
                    echo'<input class="center cursiva" type="submit" name="submit" value="Buscar...">
                </select></form></div>';
                }
                ?>
            </div>
        </div>
        <div id="footer"></div></body>
</html>