<!DOCTYPE html>
<?php
session_start();
require_once 'bbdd.php';
if (isset($_SESSION['tipo']) && isset($_SESSION['email'])) {
    
} else {
    header("Location:Login.php");
}
?>
<html>
    <head>
        <title>CONCIERTOS</title>
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
        <link href="Estilos/RegistrationForm.css" rel="stylesheet" type="text/css"/>
        <link href="Estilos/StarRating.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div id="header"></div>

        <div class="content center">

        <div id="contenedor" class="center">
            <?php
            require_once'BusquedaMusicos.php';
            $miInformacion = getInfoUser($_SESSION['email']);
            $local = $miInformacion['ID_USUARIO'];
            if (isset($_GET['local']) && !isset($_GET['idgrupo'])) {
                echo'<div id="grupos" class="inline" style="padding-right:100px">';
                $ciudad = null;
                $genero = null;
                $letras = getFirstLetterArtistas();
                $_SESSION['local'] = $_GET['local'];
                echo'<h2>SELECCIONA UN GRUPO</h2>';

                while ($row = $letras->fetch_assoc()) {
                    $result = BusquedaTodosArtistas($ciudad, $genero, $row['LETRA']);
                    $letra = strtoupper($row['LETRA']);
                    if ($result == null) {
                        echo '<script language="javascript">$("#' . $letra . '").empty();</script>';
                    } else {
                        echo '<div id="resultado">';
                        echo '<div style="float:left;padding:5px;border-bottom: 1px solid #d83c3c">';
                        echo '<h3 id="' . $letra . '" class="color_rojo_general">' . $letra . '</h3>';
                        echo '</div>';

                        echo '<table cellspacing=0 style="width:100%">';
                        echo '<col width="auto">';
                        echo '<col width="0">';
                        $i = 0;
                        while ($lista = $result->fetch_assoc()) {
                            $nombre_artistico = str_replace(" ", "+", $lista['NOMBRE_ARTISTICO']);
                            $nombreGenero = getNombreGenero($lista['ID_GENERO']);
                            $nombreCiudad = getNombreCiudad($lista['ID_CIUDAD']);
                            $imagen = getImageID($lista['ID_USUARIO']);
                            echo '<tr>';
                            echo '<td class="padding5" style="border-bottom:1px solid gray;text-align:left;vertical-align:top">';
                            echo '<a class="fontblack a_concierto" href=InfoGrupo.php?nombre=' . $nombre_artistico . '>';
                            echo '<div class="inline">';
                            echo '<img id="img_lista_img" class="inline" src="'.$imagen.'">';
                            echo '<b id="h4_lista_img">' . $lista['NOMBRE_ARTISTICO'] . '</b>';
                            $average = votosGrupo($lista['ID_USUARIO']);
                            mostrarEstrellasPuntuacionLocal($average, $i);
                            echo '</div>';
                            echo '</a>';
                            echo '</td>';
                            echo '<td class="padding5" style="border-bottom:1px solid gray;text-align:right;vertical-align:top">';
                            echo '<div class="inline padding5">';
                            echo '<i><b>' . $nombreGenero . ', ' . $nombreCiudad . '</b></i><br><BR>';
                            echo '<a href="CrearConcierto.php?local=' . $_GET['local'] . '&idgrupo=' . $lista['ID_USUARIO'] . '" style = "width:100px" class = "action-button">PROPONER</a>';
                            echo '</div>';
                            echo'</div>';
                            echo '</td>';
                            echo '</tr>';
                            $i++;
                        }
                        echo'</table>';
                        echo'</div>';
                    }
                }
            } elseif (isset($local) && isset($_GET['idgrupo'])) {
                $_SESSION['local'] = $local;
                $_SESSION['idgrupo'] = $_GET['idgrupo'];
                if (isset($_POST['crearConcierto'])) {
                    $fecha = $_POST['fecha'];
                    $hora = $_POST['hora'];
                    $fechaFinal = $fecha . ' ' . $hora;
                    $precio = $_POST['precio'];
                    $totalEntradas = $_POST['totalEntradas'];
                    $result = crearConcierto($_SESSION['idgrupo'], $_SESSION['local'], $fechaFinal, $precio, $totalEntradas, $_SESSION['idgenero'], $_SESSION['idciudad']);
                    if ($result) {
                        echo '<h2>CONCIERTO CREADO CON ÉXITO<h2>';
                        echo '<h5><i>REDIRIGIENDO A TU PERFIL</i></h5>';
                        header("refresh:2;url=Perfil.php");
                    }else{
                    }
                } else {
                    $infoLocal = getInfoUser($_SESSION['email']);
                    $infoGrupo = getNombreLocal($_GET['idgrupo']);
                    $_SESSION['idgenero'] = $infoGrupo['ID_GENERO'];
                    $_SESSION['idciudad'] = $infoLocal['ID_CIUDAD'];
                    $nombreGrupo = $infoGrupo['NOMBRE_ARTISTICO'];
                    $nombreLocal = $infoLocal['NOMBRE_LOCAL'];
                    echo'<h2 style="padding-top:20px">INFORMACIÓN DEL CONCIERTO</h2>';
                    echo '<form action="" method="POST">';
                    echo '<table style="text-align:left">';
                    echo '<col width="200">';
                    echo '<col width="200">';
                    echo '<tr>';
                    echo '<td>MI LOCAL:</td>';
                    echo '<td>' . $nombreLocal . '</td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>GRUPO:</td>';
                    echo '<td>' . $nombreGrupo . '</td>';
                    echo '</tr>';
                    echo '</table>';
                    echo '<table style="text-align:left">';
                    echo '<col width="200">';
                    echo '<col width="200">';
                    echo '<tr>';
                    echo '<td class="inline">FECHA: </td>';
                    $dateNow = date('Y-m-d');
                    echo '<td><input type="date" name="fecha" max="2020-01-01" min="' . $dateNow . '" required/></td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>HORA:</td>';
                    echo '<td><input type="time" required name="hora"></td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>PRECIO ENTRADA:</td>';
                    echo '<td><input style="width:50px"type="number" name="precio" min=1 required> €</td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>ENTRADAS TOTALES:</td>';
                    echo '<td><input style="width:50px" required type="number" name="totalEntradas" min=1 max="' . $infoLocal['AFORO'] . '"><i> (Límite ' . $infoLocal['AFORO'] . ')</i></td>';
                    //echo '<td><i>(El máximo número de entradas lo marca el aforo de la sala)</i></td>';
                    echo '</tr>';
                    echo '</table>';
                    echo '<button style = "width:35%;margin:50px auto auto auto" type = "submit" name = "crearConcierto" class = "action-button">CREAR CONCIERTO</button>';
                    echo '</form>';
                }
            } elseif (isset($_GET['mod'])) {
                $idconcierto = $_GET['idconcierto'];

                if (isset($_POST['modificarConcierto'])) {
                    echo 'hola';
                    $fecha = $_POST['fecha'];
                    $hora = $_POST['hora'];
                    $fechaFinal = $fecha . ' ' . $hora;
                    $precio = $_POST['precio'];
                    $totalEntradas = $_POST['totalEntradas'];
                    $idgrupo = $_GET['idgrupo'];
                    $result = modificarConcierto($idconcierto,$idgrupo, $_SESSION['idlocal'], $fecha, $precio, $totalEntradas);
                    if ($result) {
                        echo '<h2>CONCIERTO MODIICADO CON ÉXITO<h2>';
                        echo '<h5><i>REDIRIGIENDO A TU PERFIL</i></h5>';
                        header("refresh:2;url=Perfil.php");
                    }
                } else {
                    $infoConcierto = infoConcierto($idconcierto);
                    $infoLocal = getInfoUser($_SESSION['email']);
                    $infoGrupo = getNombreGrupo($infoConcierto['ID_GRUPO']);
                    $_SESSION['idgenero'] = $infoGrupo['ID_GENERO'];
                    $_SESSION['idciudad'] = $infoLocal['ID_CIUDAD'];
                    $_SESSION['idlocal'] = $infoLocal['ID_LOCAL'];
                    $nombreGrupo = $infoGrupo['NOMBRE_ARTISTICO'];
                    $nombreLocal = $infoLocal['NOMBRE_LOCAL'];
                    echo'<h2 style="padding-top:20px">INFORMACIÓN DEL CONCIERTO</h2>';
                    echo '<form action="" method="POST">';
                    echo '<table style="text-align:left">';
                    echo '<col width="200">';
                    echo '<col width="200">';
                    echo '<tr>';
                    echo '<td>MI LOCAL:</td>';
                    echo '<td>' . $nombreLocal . '</td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>GRUPO:</td>';
                    echo '<td>' . $nombreGrupo . '</td>';
                    echo '</tr>';
                    echo '</table>';
                    echo '<table style="text-align:left">';
                    echo '<col width="200">';
                    echo '<col width="200">';
                    echo '<tr>';
                    echo '<td class="inline">FECHA: </td>';
                    $dateNow = date('Y-m-d');
                    echo '<td><input type="date" name="fecha" max="2020-01-01" min="' . $dateNow . '" required/></td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>HORA:</td>';
                    echo '<td><input type="time" required name="hora"></td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>PRECIO ENTRADA:</td>';
                    echo '<td><input style="width:50px"type="number" name="precio" min=1 required> €</td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>ENTRADAS TOTALES:</td>';
                    echo '<td><input style="width:50px" required type="number" name="totalEntradas" min=1 max="' . $infoLocal['AFORO'] . '"><i> (Límite ' . $infoLocal['AFORO'] . ')</i></td>';
                    echo '</tr>';
                    echo '</table>';
                    echo '<button style = "width:35%;margin:50px auto auto auto" type = "submit" name = "modificarConcierto" class = "action-button">MODIFICAR CONCIERTO</button>';
                    echo '</form>';
                }
            }
            ?>

        </div>
        </div>
        <div id="footer"></div>
    </body>
</html>



