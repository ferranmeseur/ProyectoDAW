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

        <!--BARRA BUSQUEDA-->
        <div id="Search" class="height_40 padding20">
            <form class="form-wrapper cf" action="Busqueda.php" method="GET">
                <input type="text" name="busqueda" placeholder="Busca músicos, locales o conciertos" required>
                <button type="submit" value="submit" name="submit">GO!</button>
            </form>
        </div>
        <!--  ---------------- -->
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
            } else {
                if (isset($locales)) {
                    echo '<div id="div_lista">
                    <h2 id="h2_lista">Locales</h2>
                    <ul id="ul_lista">';
                    while ($row = $locales->fetch_assoc()) {
                        echo "<li id=li_lista'><a id='a_lista' class='fontblack' href=InfoLocal.php?nombre=" . $row['NOMBRE_LOCAL'] . "&b=true>" . $row['NOMBRE_LOCAL'] . "</a></li>";
                    }
                    echo "</ul></div>";
                }
                if (isset($artistas)) {
                    echo '<div id="div_lista_img">
                    <ul id="ul_lista_img">
                    <h2 id="h4_lista_img">Artistas</h2>';
                    while ($row = $artistas->fetch_assoc()) {
                        echo "<li class='padding20' id=li_lista_img'><a class='fontblack' href=InfoGrupo.php?nombre=" . $row['NOMBRE_ARTISTICO'] . "&b=true><img id='img_lista_img' src='Imagenes/image.jpeg'><h4 id='h4_lista_img'>".$row['NOMBRE_ARTISTICO']."</h4><p id='p_lista_img'>DESCRIPCION</p></a></li>";
                    }
                    echo "</ul></div>";
                }
                if (isset($conciertoLocal)) {
                    echo "<div id='div_lista'>";
                    echo '<h2 id="h2_lista">Conciertos en ' . $busqueda . '</h2>';
                    echo'<ul id="ul_lista">';

                    while ($row = $conciertoLocal->fetch_assoc()) {
                        echo "<li id='li_lista'><a div='a_lista' class='fontblack' href=InfoGrupo.php?nombre=" . $row['NOMBRE_ARTISTICO'] . "&b=true>" . $row['NOMBRE_ARTISTICO'] . " " . $row['FECHA'] . "</a></li>";
                        echo "</ul></div>";
                    }
                }
                if (isset($conciertoArtista)) {
                    echo "<div id='div_lista'>";
                    echo '<h2 id="h2_lista">Conciertos de ' . $busqueda . '</h2>';
                    echo '<ul id="ul_lista">';
                    while ($row = $conciertoArtista->fetch_assoc()) {
                        list($año, $mes, $dia, $hora, $minuto) = split('[-:]', $row['FECHA']);
                        $nombre_local = str_replace(" ", "+", $row['NOMBRE_LOCAL']);
                        echo "<li id='li_lista'><a id='a_lista' class='fontblack' href=InfoLocal.php?nombre=" . $nombre_local . "&b=true>" . $row['NOMBRE_LOCAL'] . " el día $dia de $mes de $año a las $hora:$minuto</a></li>";
                        echo "</ul></div>";
                    }
                }
            }
        } else {
            //AÑADIR BUSCADOR AQUI
            $result = TrendingBusqueda("grupo");
            echo '<div id="div_lista">';
            echo '<h2 id="h2>Grupos más buscados: </h3>';
            while ($row = $result->fetch_assoc()) {
                $nombre = str_replace(" ", "+", $row['NOMBRE']);
                echo "<li id='li_lista'><a id='a_lista' href=InfoGrupo.php?nombre=" . $nombre . ">" . $row['NOMBRE'] . "</a></li>";
            }
            echo "</ul></div>";
        }
        ?>
        <div id="footer"></div>
    </body>
</html>