<!DOCTYPE html>
<html>
    <head>
        <?php
        echo '<title>' . $_GET['nombre'] . '</title>';
        ?>
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
        <div class="center" style="width: 100%; height: 500px">

            <?php
            require_once'bbdd.php';
            if (isset($_GET['b'])) {
                $nombre = $_GET['nombre'];
                TraceEvent("BUSQUEDA", $nombre, "NULL", "MUSICO", "NULL");
            }
                        $resultado = getInfoGrupoName($_GET['nombre']);
            echo '<h1>'.$resultado['NOMBRE_ARTISTICO'].'</h1>';
            echo'<div class="inline">';
            echo'<img src="Imagenes/image.jpeg" alt=""/>';
            echo'</div>';
            echo'<div class="inline">';
            $votos = votosGrupo($resultado['ID_USUARIO']);
            if ($votos['suma'] == 0) {
                echo '<div class="center">Este Grupo aún no ha recibido votos</div>';
            } else {
                $mediavotos = $votos['suma'] / $votos['count'];
                echo '<div class="center">Puntuación ' . $mediavotos . ' / 5</div>';
            }
            echo '<div class="center">Componentes : ' . $resultado['NUMERO_COMPONENTES'] . '</div>';
            echo '<div class="center">Genero : ' . getNombreGenero(($resultado['ID_GENERO'])) . '</div>';
            echo '<div class="center">Ciudad : ' . getNombreCiudad($resultado['ID_CIUDAD']) . '</div>';
            echo '<div class="center">Contacto : ' . $resultado['WEB'] . '</div>';
            echo '<div class="center">Descripción : ' . $resultado['DESCRIPCION'] . '</div>';
            echo '</div>';
            ?>
            <div id="footer"></div>
    </body>
</html>