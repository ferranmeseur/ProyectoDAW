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
        </br><div id="result" class="center">
            Introduce los siguientes datos para darte de alta en Music and Seek:</div>
        </br></br>
        <div class="center">
            <div class="inline">
                <div id="Labels" class="inline text_align_left ">
                    <?php
                    require_once 'bbdd.php';

                    function check() {
                        switch ($_SESSION['tipo']) {
                            case "Local":
                                if (!existTelefono($_POST["telefono"])) {
                                    showAlert("El telefono ya existe");
                                } elseif (!existNombreLocal($_POST["nombrelocal"])) {
                                    showAlert("Ya existe este local");
                                } else {
                                    $_POST["valoresok"] = "submit";
                                }
                                break;
                            case "Musico":
                                if (!existTelefono($_POST["telefono"])) {
                                    showAlert("El telefono ya existe");
                                } elseif (!existNombreArtistico($_POST["nombreartistico"])) {
                                    showAlert("Ya existe este nombre artistico");
                                } else {
                                    $_POST["valoresok"] = "submit";
                                }
                                break;
                            case "Fan":
                                if (!existTelefono($_POST["telefono"])) {
                                    showAlert("El telefono ya existe");
                                } else {
                                    $_POST["valoresok"] = "submit";
                                }
                                break;
                        }
                    }

                    $tipo = $_SESSION['tipo'];
                    $mail = $_SESSION['mail'];
                    $nombre = $_SESSION['nombre'];
                    $apellido = $_SESSION['apellido'];
                    $pas = $_SESSION['pas'];
                    $pregunta = $_SESSION['pregunta'];
                    $respuesta = $_SESSION['respuesta'];

                    if (isset($_POST["enviar"])) {
                        $ciudad = $_POST["ciudad"];
                        $ubicacion = $_POST["ubicacion"];
                        $telefono = $_POST["telefono"];
                        if (isset($_POST["aforo"])) {
                            $aforo = $_POST["aforo"];
                        }
                        if (isset($_POST["nombrelocal"])) {
                            $nombrelocal = $_POST["nombrelocal"];
                        }
                        $imagen = $_POST["imagen"];
                        $web = $_POST["web"];
                        if (isset($_POST["nombreartistico"])) {
                            $nombreartistico = $_POST["nombreartistico"];
                        }
                        if (isset($_POST["genero"])) {
                            $genero = $_POST["genero"];
                        } else {
                            $genero = "NULL";
                        }
                        if (isset($_POST["componentes"])) {
                            $componentes = $_POST["componentes"];
                        }
                        if (empty($apellido))
                            $apellido = "NULL";
                        if (empty($imagen))
                            $imagen = "NULL";
                        if (empty($web))
                            $web = "NULL";

                        switch ($_SESSION['tipo']) {
                            case "Fan":
                                if (empty($ubicacion))
                                    $ubicacion = "NULL";
                                if (empty($telefono))
                                    $telefono = "NULL";
                                $nombrelocal = "NULL";
                                $aforo = "NULL";
                                $nombreartistico = "NULL";
                                $componentes = "NULL";
                                check();
                                break;
                            case "Local":
                                $nombreartistico = "NULL";
                                $componentes = "NULL";
                                $genero = "NULL";
                                check();
                                break;
                            case "Musico":
                                if (empty($ubicacion))
                                    $ubicacion = "NULL";
                                $nombrelocal = "NULL";
                                $aforo = "NULL";
                                check();
                                break;
                        }
                    }
                    if (isset($_POST["valoresok"])) {
                        $resultado = Registro($tipo, $nombre, $apellido, $mail, $pas, $nombrelocal, $ciudad, $ubicacion, $telefono, $aforo, $imagen, $web, $nombreartistico, $genero, $componentes,$pregunta,$respuesta);
                        if ($resultado == "true") {
                            echo "Usuario registrado correctamente";
                            echo '<script type="text/javascript">$("#result").html("");</script>';
                            echo '</br></br><div>Volviendo al menú principal...</div>';
                            header("refresh:3;url=HomePage.php");
                        } else {
                            showAlert($resultado);
                        }
                    } else {
                        switch ($_SESSION['tipo']) {
                            case "Local":
                                echo ' 
        <form action = "" method = "POST">
                    <div id="Nombre" class="padding5 align_right">
                    <label style="color:red;">* </label>Nombre local :<input type = "text" name = "nombrelocal" maxlength="20" minlength="5" required>
                    </div>
                    <div id="Ciudad" class="padding align_right"> Ciudad:';
                                $ciudades = ListaCiudades();
                                echo'<label style="color:red;">* </label><select name = "ciudad" required>';
                                while ($fila2 = mysqli_fetch_array($ciudades)) {
                                    extract($fila2);
                                    echo"<option value=$ID_CIUDAD>$NOMBRE</option>";
                                }echo'</select></div>
                    <div id="Ubicacion" class="align_right">
                    <label style="color:red;">* </label>Ubicación :<input type = "text" name = "ubicacion" maxlength="50" minlength="3" required>
                    </div>
                    <div id="Telefono" class="padding5 align_right">
                    <label style="color:red;">* </label>Telefono :<input type = "number" name = "telefono" maxlength="11" minlength="9" required>
                    </div>
                    <div id="Aforo" class="padding5 align_right">
                    <label style="color:red;">* </label>Aforo :<input type = "number" name = "aforo" maxlength="5" minlength="1" required>
                    </div>
                    <div id="Imagen" class="padding5 align_right">
                    Imagen :<input type = "text" name = "imagen" maxlength="50" minlength="5">
                    </div>
                    <div id="Web" class="padding5 align_right">
                    Web :<input type = "text" name = "web" maxlength="20" minlength="5" >
                    </div>
                </div>
                </br>
                </br><div style="color:red;font-size:10px;">* Campos obligatorios</div>
            </div></br></br>
            <input type = "submit" name = "enviar" value = "Siguiente">             
            </div>
        </form>';
                                break;
                            case "Fan":
                                echo ' 
                    <form action = "" method = "POST">
                   <div id="Ciudad" class="padding align_right">  <label style="color:red;">* </label>Ciudad:';
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
                 </br>
                </br><div style="color:red;font-size:10px;">* Campos obligatorios</div>
            </div></br></br>
            <input type = "submit" name = "enviar" value = "Siguiente">             
            </div>
        </form>';
                                break;
                            case "Musico":
                                echo ' 
        <form action = "" method = "POST">
                    <div id="Nombre" class="padding5 align_right">
                    <label style="color:red;">* </label>Nombre artistico :<input type = "text" name = "nombreartistico" maxlength="20" minlength="5" required>
                    </div>
                    <div id="Genero" class="padding align_right"> <label style="color:red;">* </label>Genero:';
                                $generos = ListaGeneros();
                                echo'<select name="genero" required>';
                                while ($fila2 = mysqli_fetch_array($generos)) {
                                    extract($fila2);
                                    echo"<option value=$ID_GENERO>$NOMBRE</option>";
                                }
                                echo'</select></div>';
                                echo'
                           <div id = "Ciudad" class = "padding align_right"> <label style="color:red;">* </label>Ciudad:';
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
                            <label style="color:red;">* </label>Telefono :<input type = "number" name = "telefono" maxlength = "11" minlength = "9" required>
                            </div>
                            <div id = "Componentes" class = "padding5 align_right">
                            <label style="color:red;">* </label>Componentes :<input type = "number" name = "componentes" maxlength = "5" minlength = "1" required>
                            </div>
                            <div id = "Imagen" class = "padding5 align_right">
                            Imagen :<input type = "text" name = "imagen" maxlength = "50" minlength = "5">
                            </div>
                            <div id = "Web" class = "padding5 align_right">
                            Web :<input type = "text" name = "web" maxlength = "20" minlength = "5" >
                            </div>
                            </div>
                             </br>
                </br><div style="color:red;font-size:10px;">* Campos obligatorios</div>
                            </div></br></br>
                            <input type = "submit" name = "enviar" value = "Siguiente">
                            </div>
                            </form>';
                                break;
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <div id="footer"></div>
    </body>
</html>