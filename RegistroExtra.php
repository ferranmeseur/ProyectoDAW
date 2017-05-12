<!DOCTYPE html>
<?php
session_start();
require_once 'bbdd.php';
if (isset($_SESSION['tipo']) && isset($_SESSION['mail'])) {
    
} else {
    echo "Acceso denegado";
    return 0;
}
?>
<html>
    <head>
        <title>Registro</title>
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
        <div class="center"></br>
            Introduce los siguientes datos para darte de alta en Music and Seek:</br></br>
            <div id="Registro" class="inline">
                <div id="Labels" class="inline text_align_left ">
                    <?php
                    require_once 'bbdd.php';
                    $tipo = $_SESSION['tipo'];
                    $mail = $_SESSION['mail'];
                    $nombre = $_SESSION['nombre'];
                    $apellido = $_SESSION['apellido'];
                    $pas = $_SESSION['pas'];
                    if (isset($_POST["enviar"])) {
                        $nombrelocal = $_POST["nombrelocal"];
                        $ciudad = $_POST["ciudad"];
                        $ubicacion = $_POST["ubicacion"];
                        $telefono = $_POST["telefono"];
                        $aforo = $_POST["aforo"];
                        $imagen = $_POST["imagen"];
                        $web = $_POST["web"];
                        $nombreartistico = $_POST["nombreartistico"];
                        if (isset($_POST["genero"])) {
                            $genero = $_POST["genero"];
                        }else{
                            $genero = null;
                        }
                        $componentes = $_POST["componentes"];
                        if (empty($apellido))
                            $apellido = null;
                        if (empty($imagen))
                            $imagen = null;
                        if (empty($web))
                            $web = null;
                        
                        switch ($_SESSION['tipo']) {
                            case "Fan":
                                if (empty($ubicacion))
                                    $ubicacion = null;
                                if (empty($telefono))
                                    $telefono = null;
                                break;

                            case "Musico":
                                if (empty($ubicacion))
                                    $ubicacion = null;
                                break;
                        }
                        Registro($tipo, $nombre, $apellido, $mail, $pas, $nombrelocal, $ciudad, $ubicacion, $telefono, $aforo, $imagen, $web, $nombreartistico, $genero, $componentes);
                    } else {
                        switch ($_SESSION['tipo']) {
                            case "Local":
                                echo ' 
        <form action = "" method = "POST">
                    <div id="Nombre" class="padding5 align_right">
                    Nombre local :<input type = "text" name = "nombrelocal" maxlength="20" minlength="5" required>
                    </div>
                    <div id="Ciudad" class="padding align_right"> Ciudad:';
                                $ciudades = ListaCiudades();
                                echo'<select name = "ciudad" required>';
                                while ($fila2 = mysqli_fetch_array($ciudades)) {
                                    extract($fila2);
                                    echo"<option value=$ID_CIUDAD>$NOMBRE</option>";
                                }echo'</select></div>
                    <div id="Ubicacion" class="align_right">
                    Ubicación :<input type = "text" name = "ubicacion" maxlength="50" minlength="3" required>
                    </div>
                    <div id="Telefono" class="padding5 align_right">
                    Telefono :<input type = "number" name = "telefono" maxlength="11" minlength="9" required>
                    </div>
                    <div id="Aforo" class="padding5 align_right">
                    Aforo :<input type = "number" name = "aforo" maxlength="5" minlength="1" required>
                    </div>
                    <div id="Imagen" class="padding5 align_right">
                    Imagen :<input type = "text" name = "imagen" maxlength="50" minlength="5">
                    </div>
                    <div id="Web" class="padding5 align_right">
                    Web :<input type = "text" name = "web" maxlength="20" minlength="5" >
                    </div>
                </div>
            </div></br></br>
            <input type = "submit" name = "enviar" value = "Siguiente">             
            </div>
        </form>';
                                break;
                            case "Fan":
                                echo ' 
                    <form action = "" method = "POST">
                    <div id="Ciudad" class="padding align_right"> Ciudad:';
                                $ciudades = ListaCiudades();
                                echo'<select name = "ciudad" required>';
                                while ($fila2 = mysqli_fetch_array($ciudades)) {
                                    extract($fila2);
                                    echo"<option value=$ID_CIUDAD>$NOMBRE</option>";
                                }echo' </select></div>
                    <div id="Ubicacion" class="align_right">
                    Ubicación :<input type = "text" name = "ubicacion" maxlength="50" minlength="3">
                    </div>
                    <div id="Telefono" class="padding5 align_right">
                    Telefono :<input type = "number" name = "telefono" maxlength="11" minlength="9">
                    </div>
                    <div id="Imagen" class="padding5 align_right">
                    Imagen :<input type = "text" name = "imagen" maxlength="50" minlength="5">
                    </div>
                    <div id="Web" class="padding5 align_right">
                    Web :<input type = "text" name = "web" maxlength="20" minlength="5" >
                    </div>
                </div>
            </div></br></br>
            <input type = "submit" name = "enviar" value = "Siguiente">             
            </div>
        </form>';
                                break;
                            case "Musico":
                                echo ' 
        <form action = "" method = "POST">
                    <div id="Nombre" class="padding5 align_right">
                    Nombre artistico :<input type = "text" name = "nombreartistico" maxlength="20" minlength="5" required>
                    </div>
                    <div id="Genero" class="padding align_right"> Genero:';
                                $generos = ListaGeneros();
                                echo'<select name="genero">';
                                while ($fila2 = mysqli_fetch_array($generos)) {
                                    extract($fila2);
                                    echo"<option value=$ID_GENERO>$NOMBRE</option>";
                                }
                                echo'</select></div>';
                                echo'
                            <div id = "Ciudad" class = "padding align_right"> Ciudad:';
                                $ciudades = ListaCiudades();
                                echo'<select name = "ciudad" required>';
                                while ($fila2 = mysqli_fetch_array($ciudades)) {
                                    extract($fila2);
                                    echo"<option value=$ID_CIUDAD>$NOMBRE</option>";
                                }echo' </select></div>
                            <div id = "Ubicacion" class = "align_right">
                            Ubicación :<input type = "text" name = "ubicacion" maxlength = "50" minlength = "3">
                            </div>
                            <div id = "Telefono" class = "padding5 align_right">
                            Telefono :<input type = "number" name = "telefono" maxlength = "11" minlength = "9" required>
                            </div>
                            <div id = "Componentes" class = "padding5 align_right">
                            Componentes :<input type = "number" name = "componentes" maxlength = "5" minlength = "1" required>
                            </div>
                            <div id = "Imagen" class = "padding5 align_right">
                            Imagen :<input type = "text" name = "imagen" maxlength = "50" minlength = "5">
                            </div>
                            <div id = "Web" class = "padding5 align_right">
                            Web :<input type = "text" name = "web" maxlength = "20" minlength = "5" >
                            </div>
                            </div>
                            </div></br></br>
                            <input type = "submit" name = "enviar" value = "Siguiente">
                            </div>
                            </form>';
                                break;
                        }
                    }
                    ?>
                </div>
                <div id="footer"></div>
                </body>
                </html>