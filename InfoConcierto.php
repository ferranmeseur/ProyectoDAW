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
        if(isset($_GET['b'])){
            $nombre = $_GET['nombre'];
            TraceEvent("BUSQUEDA",$nombre,"NULL","CONCIERTO","NULL");
        }
         
        $resultado = infoConcierto($_GET['idcon']);
        $votos = votosConcierto($_GET['idcon']);
        $mediavotos = $votos['suma'] / $votos['count'];
        $fecha = getNombreFecha(date("w-d-m-Y",strtotime($resultado['FECHA'])));
        $ciudad = getNombreCiudad($resultado['ID_CIUDAD']);
        echo '<div class="center">Puntuación '.$mediavotos.' / 5</div>';
        echo'<div class="center">Fecha : '. $fecha .'</div>';
        echo'<div class="center">Precio de la entrada : '.$resultado['PRECIO_ENTRADA'].' €</div>';
        echo'<div class="center">Grupo : '.$resultado['NOMBRE'].'</div>';
        echo'<div class="center">Ciudad : '.$ciudad.'</div>';

        
        
        ?>
        <div id="footer"></div>
    </body>
</html>