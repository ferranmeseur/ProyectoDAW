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
    <body class="width_100"><div id="header"></div>
        <?php
        require_once 'bbdd.php';
        ListaConciertos();
        ?>
        <div class="inline">
            <div class="center">
                <?php
                require_once 'bbdd.php';
                if (isset($_POST["ciudadsub"])) {
                    echo'<div class="center">
                                <div class="center contenedor_scroll">';
                    $ciudad = $_POST["ciudad"];
                    ListaConciertosCiudad($ciudad);
                    echo'</div></div>';
                }
                echo'<form action = "" method = "POST" >';
                $ciudades = ListaCiudades();
                echo'<select name="ciudad">';
                while ($fila2 = mysqli_fetch_array($ciudades)) {
                    extract($fila2);
                    echo"<option value=$NOMBRE>$NOMBRE</option>";
                }
                echo'</select>';
                ?>
                <input class="center cursiva" type="submit" name="ciudadsub" value="Buscar por ciudad">
                <!--<button id="generogrupos" class="center cursiva" name = "ciudadsub">Escoge una ciudad para visualizar la clasificacion</button>-->
                </form>
            </div>
        </div>
        <div class="inline">
            <div class="center">
                <?php
                require_once 'bbdd.php';
                if (isset($_POST["generosub"])) {
                    echo'<div class="center">
                                <div class="center contenedor_scroll">';
                    $genero = $_POST["genero"];
                    ListaConciertosGenero($genero);
                    echo'</div></div>';
                }
                echo'<form action = "" method = "POST" >';
                $generos = ListaGeneros();
                echo'<select name="genero">';
                while ($fila2 = mysqli_fetch_array($generos)) {
                    extract($fila2);
                    echo"<option value=$NOMBRE>$NOMBRE</option>";
                }
                echo'</select>';
                ?>
                <input class="center cursiva" type="submit" name="generosub" value="Buscar por genero">
                <!--<button id="generogrupos" class="center cursiva" name = "generosub">Escoge un genero para visualizar l</button>-->
                </form>
            </div>
        </div>
        <div class="inline">
            <div class="center">
                <?php
                require_once 'bbdd.php';
                if (isset($_POST["gruposub"])) {
                    echo'<div class="center">
                                <div class="center contenedor_scroll">';
                    $grupo = $_POST["grupo"];
                    ListaConciertosGrupo($grupo);
                    echo'</div></div>';
                }
                echo'<form action = "" method = "POST" >';
                $grupos = ListaGrupos();
                echo'<select name="grupo">';
                while ($fila2 = mysqli_fetch_array($grupos)) {
                    extract($fila2);
                    echo"<option value=$ID_USUARIO>$NOMBRE_ARTISTICO</option>";
                }
                echo'</select>';
                ?>
                <input class="center cursiva" type="submit" name="gruposub" value="Buscar por grupo">
                <!--<button id="gruposconcierto" class="center cursiva" name = "gruposconcierto">Escoge un grupo para visualizar los conciertos</button>-->
                </form>
            </div>
        </div>
        <div class="inline">
            <div class="center">
                <?php
                require_once 'bbdd.php';
                if (isset($_POST["localsub"])) {
                    echo'<div class="center">
                                <div class="center contenedor_scroll">';
                    $id_local = $_POST["id_local"];
                    ListaConciertosLocal($id_local);
                    echo'</div></div>';
                }
                echo'<form action = "" method = "POST" >';
                $locales = ListaLocales();
                echo'<select name="id_local">';
                while ($fila2 = mysqli_fetch_array($locales)) {
                    extract($fila2);
                    echo"<option value=$ID_USUARIO>$NOMBRE_LOCAL</option>";
                }
                echo'</select>';
                ?>
                <input class="center cursiva" type="submit" name="localsub" value="Buscar por local">
                <!--<button id="gruposconcierto" class="center cursiva" name = "gruposconcierto">Escoge un grupo para visualizar los conciertos</button>-->
                </form>
            </div>
        </div>

        <div id="footer"></div></body>
</html>