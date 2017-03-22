<html>
    <head>
        <title>Ranking</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="Estilos/Estilos.css" rel="stylesheet" type="text/css"/>
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script>
            $(function () {
                $("#header").load("Header.html");
                $("#footer").load("Footer.html");
            });
        </script> 
    </head>
    <body>
        <div id="header"></div>   
        <div class="center">
            <div class="center">BUSCADOR</div>
            <div class="center">
                <div class="center">
                    ARTISTAS EN ALZA
                    <div class="center height_25 width_100"></div>
                </div>
                <?php
                require_once 'bbdd.php';
                RankingMusicos();
                ?>
                <div class="inline">
                    <div class="center">
                        <?php
                        require_once 'bbdd.php';
                        if (isset($_POST["generosub"])) {
                            echo'<div class="center">
                                <div class="center contenedor_scroll">';
                            $genero = $_POST["genero"];
                            RankingPorGenero($genero);
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
                        <input class="center cursiva" type="submit" name="generosub" value="Ranking por genero">
                        <!--<button id="generogrupos" class="center cursiva" name = "generosub">Escoge un genero para visualizar la clasificacion</button>-->
                        </form>
                    </div>
                </div>
                <div class="inline">
                    <div class="center">
                        <?php
                        require_once 'bbdd.php';
                        if (isset($_POST["ciudadsub"])) {
                            echo'<div class="center">
                                <div class="center contenedor_scroll">';
                            $ciudad = $_POST["ciudad"];
                            RankingPorCiudad($ciudad);
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
                        <button id="generogrupos" class="center cursiva" name = "ciudadsub">Ranking por ciudad</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="footer"></div>
</body>
</html>
