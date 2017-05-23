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
    <body>
        <div id="header"></div>

        <div>
            <?php
            require_once 'bbdd.php';
            require_once'BusquedaMusicos.php';
            if (isset($_POST['submit'])) {
                BusquedaMusicos();
                $ciudad = $_POST['ciudad'];
                $genero = $_POST['genero'];
                $letras = getFirstLetterArtistas();
                echo'<div style="margin-right: 200px; margin-left:200px">';
                while ($row = $letras->fetch_assoc()) {
                    $result = BusquedaTodosArtistas($ciudad, $genero, $row['LETRA']);
                    $letra = strtoupper($row['LETRA']);
                    if ($result == null) {
                        echo '<script language="javascript">$("#' . $letra . '").empty();</script>';
                    } else {
                        echo '<div id="resultado">';
                        echo '<div style="padding:5px;border-bottom: 1px solid #d83c3c">';
                        echo '<h3 id="' . $letra . '" class="color_rojo_general">' . $letra . '</h3>';
                        echo '</div>';

                        echo '<table cellspacing=0 style="width:100%">';
                        echo '<col width="auto">';
                        echo '<col width="300">';

                        while ($lista = $result->fetch_assoc()) {
                            $nombre_artistico = str_replace(" ", "+", $lista['NOMBRE_ARTISTICO']);
                            $nombreGenero = getNombreGenero($lista['ID_GENERO'])->fetch_assoc();
                            $nombreCiudad = getNombreCiudad($lista['ID_CIUDAD'])->fetch_assoc();
                            echo '<tr>';
                            echo '<td class="padding5" style="border-bottom:1px solid gray;text-align:left;vertical-align:top">';
                            echo '<a class="fontblack a_concierto" href=InfoGrupo.php?nombre=' . $nombre_artistico . '>';
                            echo '<div class="inline">';
                            echo '<img id="img_lista_img" class="inline" src="Imagenes/image.jpeg">';
                            echo '<b id="h4_lista_img">' . $lista['NOMBRE_ARTISTICO'] . '</b><br>';
                            echo '<i>numero de votos</i>';
                            echo '</div>';
                            echo '</a>';
                            echo '</td>';
                            echo '<td class="padding5" style="border-bottom:1px solid gray;text-align:right;vertical-align:top">';
                            echo '<div class="inline padding5">';
                            echo '<i><b>' . $nombreGenero['NOMBRE'] . ', ' . $nombreCiudad['NOMBRE'] . '</b></i>';
                            echo '</div>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        echo'</table>';
                        echo'</div>';
                    }
                }
                echo'</div>';

                $error = "<div class='padding20 center cursiva'>No se ha encontrado ningun grupo que coincida con la busqueda.</div>";
                //echo '<script language="javascript">if(!$.trim($("#resultado").html())){$("#resultado").append("'.$error.'");console.log("hola");}</script>';
                echo '<script language="javascript">if($("#result").is(":empty")){$("#resultado").append("' . $error . '");console.log("hola");}else{console.log("deu");}</script>';
            } else {
                BusquedaMusicos();
            }
            ?>
        </div>
        <div class="margin_top_200px" id="footer"></div>
    </body>

    <div class="margin_left_100px" style="margin-right: 200px">


</html>



