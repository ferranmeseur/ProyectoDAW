<!DOCTYPE html>
<html>
    <head>
        <title>RANKING</title>
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
        <div style="height: 50px"></div>
        <div id="Search" class="height_40">
            <form class="form-wrapper cf" action="Busqueda.php" method="GET">
                <input type="text" name="busqueda" placeholder="Busca músicos o locales" required>
                <button class="button-form" type="submit" value="submit" name="submit">GO!</button>
            </form>
        </div>
        <div class="center">
            <?php
            require_once 'bbdd.php';
            echo '<form method="GET" action="Ranking.php">';
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

            if (isset($_GET['submit'])) {
                $genero = $_GET['genero'];
                $ciudad = $_GET['ciudad'];
                if ($ciudad != null || $genero != null) {
                    $result = RankingMusicos($genero, $ciudad);
                    if ($result == null) {
                        echo "<div class='padding20 center cursiva'>No se ha encontrado ninguna coincidencia</div>";
                    } else {
                        ArtistasAlza($genero, $ciudad);
                    }
                } else {
                    ArtistasAlza(null, null);
                }
            } else {
                ArtistasAlza(null, null);
            }
            ?>
        </div>
        <div id="footer" style="vertical-align: bottom"></div>
    </body>
</html>
