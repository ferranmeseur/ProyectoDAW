<!DOCTYPE html>
<html>
    <head>
        <title>Información Grupo</title>
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
        if (isset($_GET['b'])) {
            $nombre = $_GET['nombre'];
            TraceEvent("BUSQUEDA", $nombre, "NULL", "CONCIERTO", "NULL");
        }
        $resultado = infoConcierto($_GET['idcon']);
        $votos = votosConcierto($_GET['idcon']);
        $mediavotos = $votos['suma'] / $votos['count'];
        $fecha = getNombreFecha(date("w-d-m-Y", strtotime($resultado['FECHA'])));
        $comentarios = comentariosConcierto($_GET['idcon']);
        echo '<div class="center">Puntuación ' . $mediavotos . ' / 5</div>';
        echo'<div class="center">Fecha : ' . $fecha . '</div>';
        echo'<div class="center">Precio de la entrada : ' . $resultado['PRECIO_ENTRADA'] . ' €</div>';
        echo'<div class="center">Grupo : ' . $resultado['NOMBRE'] . '</div>';
        echo'<div class="center">Ciudad : ' . getNombreCiudad($resultado['ID_CIUDAD']) . '</div>';
        echo'<div class="center">Local : ' . getNombreLocal(($resultado['ID_LOCAL'])) . '</div>';
        echo'<div class="center">Genero : ' . getNombreGenero(($resultado['ID_GENERO'])) . '</div>';
        echo '<div class="center">Comentarios';
        if ($comentarios  != false) {
            echo '<table class="center">';
            while ($lista = $comentarios->fetch_assoc()) {
                echo'<tr><th>';
                $fechacomentario = getNombreFecha(date("w-d-m-Y", strtotime($lista['FECHA'])));
                echo $lista['NOMBRE'].' - '.$fechacomentario.'</th></tr>';
                
                echo '<tr><th>'.$lista['COMENTARIO'].'</th></tr>';
            }
            echo'</table></div>';
        }
        ?>
        <div id="footer"></div>
    </body>
</html>