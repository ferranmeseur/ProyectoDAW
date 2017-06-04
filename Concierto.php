<!DOCTYPE html>
<html>
    <head>
        <title>Conciertos</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script>
            $(function () {
                $("#header").load("Header.php");
                $("#footer").load("Footer.html");
            });
        </script> 
        <link href="Estilos/Estilos.css" rel="stylesheet" type="text/css"/>
        <link href="Estilos/StarRating.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div id="header"></div>
        <div class="content center">
            <h1> Busca los próximos <span class="color_rojo_general">Conciertos</span> </h1>
            <div>
                <?php
                require_once 'bbdd.php';
                require_once'BusquedaConciertos.php';
                if (isset($_POST['submit'])) {
                    BusquedaConciertos();
                    $futurosConciertos = $_POST['futurosConciertos'];
                    $ciudad = $_POST['ciudad'];
                    $genero = $_POST['genero'];
                    $grupo = $_POST['grupo'];
                    $local = $_POST['id_local'];
                    $fechas = ListaFechasConciertos($futurosConciertos);
                    echo'<div style="margin-right: 200px; margin-left:200px">';
                    $i = 0;
                    while ($row = $fechas->fetch_assoc()) {
                        $nuevaFecha = date("w-d-m-Y", strtotime($row["FECHA"]));
                        $nuevaHora = date("H:i", strtotime($row["FECHA"]));
                        $fechaFinal = getNombreFecha($nuevaFecha);
                        $estado = 1;
                        $visible = 1;
                        $result = ListaConciertosFan($row['FECHA'], $genero, $ciudad, $grupo, $local, $estado, $visible);

                        if ($result == null) {
                            //echo '<script language="javascript">$("#$fechaFinal").empty();</script>';
                        } else {
                            echo '<div id="resultado">';
                            echo '<h3 id="' . $fechaFinal . '" class="color_rojo_general">' . $fechaFinal . '</h3>';
                            echo '<table cellspacing=0 style="width:100%">';
                            echo '<col width="auto">';
                            echo '<col width="300">';
                            echo '<col width="400">';

                            while ($lista = $result->fetch_assoc()) {
                                $nombre_artistico = str_replace(" ", "+", $lista['NOMBRE_ARTISTICO']);
                                $nombre_local = str_replace(" ", "+", $lista['NOMBRE_LOCAL']);

                                echo '<tr>';
                                echo '<td class="padding5" style="border-bottom:1px solid gray;text-align:left;vertical-align:top">';
                                echo '<a class="fontblack a_concierto" href=InfoConcierto.php?idcon=' . $lista['ID_CONCIERTO'] . '>';
                                echo '<div class="inline">';
                                echo "<img id='img_lista_img' class='inline' src='Imagenes/image.jpeg'>";
                                echo "<b id='h4_lista_img'>" . $lista['NOMBRE_ARTISTICO'] . "</b><br>";
                                echo "<i>" . $lista['GENERO'] . "</i>";
                                echo '</div>';
                                echo '</td>';
                                if ($futurosConciertos == 'false') {
                                    echo '<td align="center" style="border-bottom:1px solid gray">';
                                    $average = votosLocal($lista['ID_USUARIO']);
                                    mostrarEstrellasPuntuacionLocal($average, $i);
                                    echo '</td>';
                                }
                                echo '<td class="padding5" style="border-bottom:1px solid gray;text-align:right;vertical-align:top">';
                                echo "<div class='inline padding5'>";
                                echo "<b>" . $lista['NOMBRE_LOCAL'] . "</b><br>";
                                $nombreCiudad = getNombreCiudad($lista['ID_CIUDAD']);
                                echo "<i>" . $lista['UBICACION'] . "</i>, <i class='color_rojo_general'>".$nombreCiudad."</i>";
                                echo "</div>";
                                echo "</a>";
                                echo '</td>';
                                echo '</tr>';
                                $i++;
                            }
                            echo'</table>';
                            echo'</div>';
                        }
                    }
                    echo'</div>';

                    $error = "<div class='padding20 center cursiva'>No se ha encontrado ningun concierto que coincida con la busqueda.</div>";
                    //echo '<script language="javascript">if(!$.trim($("#resultado").html())){$("#resultado").append("'.$error.'");console.log("hola");}</script>';
                    echo '<script language="javascript">if($("#result").is(":empty")){$("#resultado").append("' . $error . '");console.log("hola");}else{console.log("deu");}</script>';
                } else {
                    BusquedaConciertos();
                }
                ?>
            </div>
        </div>
        <div id="footer"></div>
    </body>
</html>



