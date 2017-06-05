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
                $("#header").load("Header.php");
                $("#footer").load("Footer.html");
            });
        </script> 
        <link href="Estilos/Estilos.css" rel="stylesheet" type="text/css"/>
        <link href="Estilos/RegistrationForm.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div id="header"></div>
        </br><div id="result" class="center content">

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
                            if (isset($_POST['imagen'])) {
                                $imagen = $_POST["imagen"];
                            }
                            $web = $_POST["web"];
                            if (isset($_POST["nombreartistico"])) {
                                $nombreartistico = $_POST["nombreartistico"];
                            }
                            if (isset($_POST["genero"])) {
                                $genero = $_POST["genero"];
                            } else {
                                $genero = "NULL";
                            }
                            if (isset($_POST['descripcion'])) {
                                $descripcion = $_POST['descripcion'];
                            } else {
                                $descripcion = "NULL";
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
                            $resultado = Registro($tipo, $nombre, $apellido, $mail, $pas, $nombrelocal, $ciudad, $ubicacion, $telefono, $aforo, $imagen, $web, $nombreartistico, $genero, $componentes, $pregunta, $respuesta, $descripcion);
                            $result = fileUpload($mail);
                            if ($result != 1) {
                                showAlert($result);
                            }
                            if ($resultado == "true") {
                                echo'<h1><span class="color_rojo_general">Usuario </span>dado de alta <span class="color_rojo_general">Correctamente</span></h1>';
                                if ($tipo == "Musico") {
                                    TraceEvent("REGISTRO", $nombreartistico, true, "NUEVO MUSICO", "NULL");
                                }
                                if ($tipo == "Local") {
                                    TraceEvent("REGISTRO", $nombrelocal, true, "NUEVO LOCAL", "NULL");
                                }
                                if ($tipo == "Fan") {
                                    TraceEvent("REGISTRO", $mail, true, "NUEVO FAN", "NULL");
                                }
                                header("refresh:2;url=HomePage.php");
                            } else {
                                showAlert($resultado);
                            }
                        } else {
                            switch ($_SESSION['tipo']) {
                                case "Local":
                                    echo ' 
                                        <h1> <span class="color_rojo_general">Registrate </span>en Music and Seek</h1>
        <form action = "" method = "POST" enctype="multipart/form-data" id="msform">
                    <div id="Nombre" class="padding5 text_align_left">
                    <label style="color:red;">* </label>Nombre local :<input type = "text" name = "nombrelocal" maxlength="20" minlength="5" required>
                    </div>
                    <div id="Ciudad" class="padding text_align_left"> Ciudad:';
                                    $ciudades = ListaCiudades();
                                    echo'<label style="color:red;">* </label><select name = "ciudad" required>';
                                    while ($fila2 = mysqli_fetch_array($ciudades)) {
                                        extract($fila2);
                                        echo"<option value=$ID_CIUDAD>$NOMBRE</option>";
                                    }echo'</select></div>
                    <div id="Ubicacion" class="text_align_left">
                    <label style="color:red;">* </label>Ubicación :<input type = "text" name = "ubicacion" maxlength="50" minlength="3" required>
                    </div>
                    <div id="Telefono" class="padding5 text_align_left">
                    <label style="color:red;">* </label>Telefono :<input type = "number" name = "telefono" maxlength="11" minlength="9" required>
                    </div>
                    <div id="Aforo" class="padding5 text_align_left">
                    <label style="color:red;">* </label>Aforo :<input type = "number" name = "aforo" maxlength="5" minlength="1" required>
                    </div>
                    <div id="Imagen" class="padding5 text_align_left">
                    Imagen :<input type="file" name="fileToUpload" >
                    </div>
                    <div id="Web" class="padding5 text_align_left">
                    Web :<input type = "text" name = "web" maxlength="20" minlength="5" >
                    </div>
                   <div id="Descripcion" class="padding5 text_align_left">
                    Descripción :<textarea name="descripcion" maxlength="255" rows="5" cols="50"></textarea>
                    </div>
                </div>
                </br>
                <h3 class="color_rojo_general">* Campos obligatorios</h3>
            </div></br></br>
            <input style="width:400px" type="submit" class="submit action-button" name = "enviar" value = "Siguiente">             
            </div>
        </form>';
                                    break;
                                case "Fan":
                                    echo ' 
                                        <h1> <span class="color_rojo_general">Registrate </span>en Music and Seek</h1>
                    <form action = "" method = "POST" enctype="multipart/form-data" id="msform">
                   <div id="Ciudad" class="padding text_align_left">  <label style="color:red;">* </label>Ciudad:';
                                    $ciudades = ListaCiudades();
                                    echo'<select name = "ciudad" required>';
                                    while ($fila2 = mysqli_fetch_array($ciudades)) {
                                        extract($fila2);
                                        echo"<option value=$ID_CIUDAD>$NOMBRE</option>";
                                    }echo' </select></div>
                    <div id="Ubicacion" class="text_align_left">
                    Ubicación :<input type = "text" name = "ubicacion" maxlength="50" minlength="3">
                    </div>
                    <div id="Telefono" class="padding5 text_align_left">
                    Telefono :<input type = "number" name = "telefono" maxlength="11" minlength="9">
                    </div>
                    <div id="Imagen" class="padding5 text_align_left">
                    Imagen :<input type="file" name="fileToUpload">
                    </div>
                    <div id="Web" class="padding5 text_align_left">
                    Web :<input type = "text" name = "web" maxlength="20" minlength="5" >
                    </div>
                    <div id="Descripcion" class="padding5 text_align_left">
                    Descripción :<textarea name="descripcion" maxlength="255" rows="5" cols="50"></textarea>
                    </div>
                </div>
                 </br>
                <h3 class="color_rojo_general">* Campos obligatorios</h3>
            </div></br>
            <input style="width:400px" type="submit" class="submit action-button" name = "enviar" value = "Siguiente">             
            </div>
        </form>';
                                    break;
                                case "Musico":
                                    echo ' 
                                        <h1> <span class="color_rojo_general">Registrate </span>en Music and Seek</h1>
        <form action = "" method = "POST" enctype="multipart/form-data" id="msform">
                    <div id="Nombre" class="padding5 text_align_left">
                    <label style="color:red;">* </label>Nombre artistico :<input type = "text" name = "nombreartistico" maxlength="20" minlength="5" required>
                    </div>
                    <div id="Genero" class="padding text_align_left"> <label style="color:red;">* </label>Genero:';
                                    $generos = ListaGeneros();
                                    echo'<select name="genero" required>';
                                    while ($fila2 = mysqli_fetch_array($generos)) {
                                        extract($fila2);
                                        echo"<option value=$ID_GENERO>$NOMBRE</option>";
                                    }
                                    echo'</select></div>';
                                    echo'
                           <div id = "Ciudad" class = "padding text_align_left"> <label style="color:red;">* </label>Ciudad:';
                                    $ciudades = ListaCiudades();
                                    echo'<select name = "ciudad" required>';
                                    while ($fila2 = mysqli_fetch_array($ciudades)) {
                                        extract($fila2);
                                        echo"<option value=$ID_CIUDAD>$NOMBRE</option>";
                                    }echo' </select></div>
                            <div id = "Ubicacion" class = "text_align_left">
                            Ubicación :<input type = "text" name = "ubicacion" maxlength = "50" minlength = "3">
                            </div>
                            <div id = "Telefono" class = "padding5 text_align_left">
                            <label style="color:red;">* </label>Telefono :<input type = "number" name = "telefono" maxlength = "11" minlength = "9" required>
                            </div>
                            <div id = "Componentes" class = "padding5 text_align_left">
                            <label style="color:red;">* </label>Componentes :<input type = "number" name = "componentes" maxlength = "5" minlength = "1" required>
                            </div>
                            <div id = "Imagen" class = "padding5 text_align_left">
                            Imagen :<input type="file" name="fileToUpload" maxlength = "50" minlength = "5">
                            </div>
                            <div id = "Web" class = "padding5 text_align_left">
                            Web :<input type = "text" name = "web" maxlength = "20" minlength = "5" >
                            </div>
                            <div id="Descripcion" class="padding5 text_align_left">
                    Descripción :<textarea name="descripcion" maxlength="255" rows="5" cols="50"></textarea>
                    </div>
                            </div>
                             </br>
                <h3 class="color_rojo_general">* Campos obligatorios</h3>
                            </div></br>
                            <input style="width:400px" type="submit" class="submit action-button" name = "enviar" value = "Siguiente">
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