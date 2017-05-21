<!DOCTYPE html>
<html>
    <link rel="apple-touch-icon" sizes="57x57" href="Imagenes/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="Imagenes/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="Imagenes/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="Imagenes/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="Imagenes/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="Imagenes/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="Imagenes/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="Imagenes/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="Imagenes/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="Imagenes/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="Imagenes/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="Imagenes/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="Imagenes/favicon-16x16.png">
    <link rel="manifest" href="Imagenes/manifest.json">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <head>
        <title>MI LOCAL</title>
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
        <div style="height: 20px"></div>
        <div class="center">
            <div id="Search" class="height_40 padding20">
                <form class="form-wrapper cf" action="Busqueda.php" method="GET">
                    <input type="text" name="busqueda" placeholder="Busca músicos y locales" required>
                    <button class="button-form" type="submit" value="submit" name="submit">GO!</button>
                </form>
            </div>
        </div>
        <div class="center">

            <div class="center">
                <div class="inline vertical_top">
                    <div class="center">PROXIMOS EVENTOS EN MI LOCAL</div>
                    <div class="center">
                        <div class="center">FECHA</div>
                        <div class="center">
                            <div class="inline vertical_middle">
                                <img class="img" src="Imagenes/image.jpeg" alt=""/>
                            </div>
                            <div class="inline vertical_middle">
                                <div class="center">Nombre del grupo</div>
                                <div class="center cursiva">Teloneros</div>
                            </div>
                        </div>
                    </div>
                    <div class="center">
                        <div class="center">FECHA</div>
                        <div class="center">
                            <div class="inline vertical_middle">
                                <img class="img" src="Imagenes/image.jpeg" alt=""/>
                            </div>
                            <div class="inline vertical_middle">
                                <div class="center">Nombre del grupo</div>
                                <div class="center cursiva">Teloneros</div>
                            </div>
                        </div>
                    </div>
                    <div class="center">
                        <div class="center">FECHA</div>
                        <div class="center">
                            <div class="inline vertical_middle">
                                <img class="img" src="Imagenes/image.jpeg" alt=""/>
                            </div>
                            <div class="inline vertical_middle">
                                <div class="center">Nombre del grupo</div>
                                <div class="center cursiva">Teloneros</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="inline vertical_top">
                    <div class="center">CONTRATAR A GRUPOS</div>
                    <div class="center">
                        <div class="center cursiva ">Escoge un genero para visualizar la clasificacion</div>
                        <select class="center">
                            <option value="Rock">Rock</option>
                            <option value="Pop">Pop</option>
                            <option value="Grunge">Grunge</option>
                        </select>
                    </div>
                    <div class="center">
                        <div class="center cursiva">O busca directamente por nombre de grupo</div>
                        <div class="center">BUSCADOR</div>
                        <div class="center">
                            <button>BUSCAR</button>
                        </div>
                    </div>
                    <div class="center">
                        <div class="center contenedor_scroll">
                            <div class="center">GRUPO 1</div>
                            <div class="center">GRUPO 2</div>
                            <div class="center">GRUPO 3</div>
                            <div class="center">GRUPO 4</div>
                            <div class="center">GRUPO 5</div>
                            <div class="center">GRUPO 6</div>
                            <div class="center">GRUPO 7</div>
                            <div class="center">GRUPO 8</div>
                            <div class="center">GRUPO 9</div>
                            <div class="center">GRUPO 10</div>
                            <div class="center">GRUPO 11</div>
                            <div class="center">GRUPO 12</div>
                            <div class="center">GRUPO 13</div>
                        </div>
                        <button>CONTRATAR</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="footer"></div>
    </body>
</html>