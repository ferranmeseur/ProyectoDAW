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
                <?php
                require_once 'bbdd.php';
                echo'<form class="center" action= "" method = "POST" >';
                echo '<div class="inline" style="text-align:left;padding-right:10px;">Ciudad:</br>';
                $ciudades = ListaCiudades();
                echo'<select name="ciudad">
                <option selected disabled>Todos</option>';
                while ($fila2 = mysqli_fetch_array($ciudades)) {
                    extract($fila2);
                    echo"<option value=$NOMBRE>$NOMBRE</option>";
                }
                echo'</select></div>';
                echo '<div class="inline"style="text-align:left;padding-right:10px;">Genero:</br>';
                $generos = ListaGeneros();
                echo'<select name="genero">
                <option selected disabled>Todos</option>';
                while ($fila2 = mysqli_fetch_array($generos)) {
                    extract($fila2);
                    echo"<option value=$NOMBRE>$NOMBRE</option>";
                }
                echo'</select></div>';
                echo '<div class="inline"style="text-align:left;padding-right:10px;">Grupo:</br>';
                $grupos = ListaGrupos();
                echo'<select name="grupo">
                <option selected disabled>Todos</option>';
                while ($fila2 = mysqli_fetch_array($grupos)) {
                    extract($fila2);
                    echo"<option value=$ID_USUARIO>$NOMBRE_ARTISTICO</option>";
                }
                echo'</select></div>';
                echo '<div class="inline"style="text-align:left;">Locales:</br>';
                $locales = ListaLocales();
                echo'<select name="id_local">
                <option selected disabled>Todos</option>';
                while ($fila2 = mysqli_fetch_array($locales)) {
                    extract($fila2);
                    echo"<option value=$ID_USUARIO>$NOMBRE_LOCAL</option>";
                }
                echo'<input class="center cursiva" type="submit" name="ciudadsub" value="Buscar...">
                </select></div>';
                ?>
            </div>
        </div>
        <div id="footer"></div></body>
</html>