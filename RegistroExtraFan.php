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
        <link href="Estilos/Estilos.css" rel="stylesheet" type="text/css"/>
        <link href="Estilos/RegistrationForm.css" rel="stylesheet" type="text/css"/>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
        <script>
//    !!!!!        ESTE SCRIPT ES DIFERENTE DEL DE REGISTRO.PHP !!!!!!!
            $(function () {

//jQuery time
                var current_fs, next_fs, previous_fs; //fieldsets
                var left, opacity, scale; //fieldset properties which we will animate
                var animating; //flag to prevent quick multi-click glitches

                $(".next").click(function () {
                    if (animating)
                        return false;
                    animating = true;

                    current_fs = $('#field1');
                    next_fs = $('#field2');
                    console.log(next_fs);
                    console.log(current_fs);
                    //activate next step on progressbar using the index of next_fs
                    $("#progressbar li").eq($("fieldset").index(3)).addClass("active");

                    //show the next fieldset
                    next_fs.show();
                    //hide the current fieldset with style
                    current_fs.animate({opacity: 0}, {
                        console.log('ha entrado');
                                step: function (now, mx) {
                                    //as the opacity of current_fs reduces to 0 - stored in "now"
                                    //1. scale current_fs down to 80%
                                    scale = 1 - (1 - now) * 0.2;
                                    //2. bring next_fs from the right(50%)
                                    left = (now * 50) + "%";
                                    //3. increase opacity of next_fs to 1 as it moves in
                                    opacity = 1 - now;
                                    current_fs.css({
                                        'transform': 'scale(' + scale + ')',
                                        'position': 'absolute'
                                    });
                                    next_fs.css({'left': left, 'opacity': opacity});
                                },
                        duration: 800,
                        complete: function () {
                            current_fs.hide();
                            animating = false;
                        },
                        //this comes from the custom easing plugin
                        easing: 'easeInOutBack'
                    });
                });

                $(".previous").click(function () {
                    if (animating)
                        return false;
                    animating = true;

                    current_fs = $('#field2');
                    previous_fs = $('#field1');

                    //de-activate current step on progressbar
                    $("#progressbar li").eq($("fieldset").index(3)).removeClass("active");

                    //show the previous fieldset
                    previous_fs.show();
                    //hide the current fieldset with style
                    current_fs.animate({opacity: 0}, {
                        step: function (now, mx) {
                            //as the opacity of current_fs reduces to 0 - stored in "now"
                            //1. scale previous_fs from 80% to 100%
                            scale = 0.8 + (1 - now) * 0.2;
                            //2. take current_fs to the right(50%) - from 0%
                            left = ((1 - now) * 50) + "%";
                            //3. increase opacity of previous_fs to 1 as it moves in
                            opacity = 1 - now;
                            current_fs.css({'left': left});
                            previous_fs.css({'transform': 'scale(' + scale + ')', 'opacity': opacity});
                        },
                        duration: 800,
                        complete: function () {
                            current_fs.hide();
                            animating = false;
                        },
                        //this comes from the custom easing plugin
                        easing: 'easeInOutBack'
                    });
                });



            });

        </script>
        <link href="Estilos/Estilos.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div id="header"></div>
        </br><div id="result" class="center">
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
                            if (isset($_FILES["fileToUpload"])) {
                                $result = fileUpload($mail);
                                if ($result != 1) {
                                    showAlert($result);
                                }
                            }
                            if ($resultado == "true") {
                                if ($tipo == "Musico") {
                                    TraceEvent("REGISTRO", $nombreartistico, true, "NUEVO MUSICO", "NULL");
                                }
                                if ($tipo == "Local") {
                                    TraceEvent("REGISTRO", $nombrelocal, true, "NUEVO LOCAL", "NULL");
                                }
                                if ($tipo == "Fan") {
                                    TraceEvent("REGISTRO", $email, true, "NUEVO FAN", "NULL");
                                }

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
                                    echo '<form action = "" method = "POST" id="msform" enctype="multipart/form-data">';
                                    echo '<ul id = "progressbar">';
                                    echo '<li class = "active">Registro</li>';
                                    echo '<li class = "active">Detalles de cuenta</li>';
                                    echo '<li class = "active" id="li_actual">Datos del local</li>';
                                    echo '<li>Datos del local</li>';
                                    echo '</ul>';
                                    echo '<fieldset id="field1">';
                                    echo '<input type = "text" name = "nombrelocal" placeholder="Nombre" maxlength="20" minlength="5" required>';
                                    echo '<div style="display:inline-block">';
                                    echo '<input type = "number" name = "telefono" style="width:59%" placeholder="Teléfono" maxlength="11" minlength="9" required/>';
                                    echo '<span>  </span>';
                                    echo '<input type = "number" name = "aforo" style="width:39%" placeholder="Aforo" maxlength="5" minlength="1" required>';
                                    echo '</div>';
                                    echo '<div id="Ciudad" class="padding align_right">';
                                    $ciudades = ListaCiudades();
                                    echo'<select name = "ciudad" required>';
                                    while ($fila2 = mysqli_fetch_array($ciudades)) {
                                        extract($fila2);
                                        echo"<option value=$ID_CIUDAD>$NOMBRE</option>";
                                    }
                                    echo '</select>';
                                    echo '</div>';
                                    echo '<input type = "text" name = "ubicacion" placeholder="Ubicacion" maxlength="50" minlength="3" required>';
                                    echo '<input type="button" name="siguiente" class="next action-button" value="Siguiente">';
                                    echo '</fieldset>';
                                    echo '<fieldset id="field2">';
                                    echo '<input type = "text" name = "web" placeholder="Web" maxlength="20" minlength="5">';
                                    echo '<input type = "file" name = "fileToUpload"/>';
                                    echo '<textarea name="descripcion" placeholder="Descripción" maxlength="255" rows="5" cols="50"></textarea>';
                                    echo '<input type="button" name="previous" class="previous action-button" value="Anterior" />';
                                    echo '<input type="button" name="enviar" class="submit action-button" value="Siguiente">';
                                    echo '</fieldset>';

                                    echo '</form>';
                                    break;
                                case "Fan":
                                    echo'<form action = "" method = "POST" id="msform">
                    <ul id="progressbar">
                        <li class="active">Registro</li>
                        <li class="active">Detalles de cuenta</li>
                        <li class="active" id="li_actual">Perfil</li>
                        <li>Perfil</li>
                    </ul>
                    <div id="Rol" class="center">
                        
                        <fieldset id="datosTipoUsuario">
                            <div id="Ciudad" class="padding align_right">';
                                    $ciudades = ListaCiudades();
                                    echo'<select name = "ciudad" required>';
                                    while ($fila2 = mysqli_fetch_array($ciudades)) {
                                        extract($fila2);
                                        echo"<option value=$ID_CIUDAD>$NOMBRE</option>";
                                    }echo' </select></div>
                            <input type = "text" name = "ubicacion" placeholder="Ubicación" maxlength="50" minlength="3">
                            <input type = "number" name = "telefono" placeholder="Teléfono" maxlength = "11" minlength = "9" required>
                            <textarea name="descripcion" placeholder="Descripción" maxlength="255" rows="5" cols="50"></textarea>
                            <input type="file" name="fileToUpload">
                            <input type="button" name="enviar" class="next action-button" value="Siguiente" />

                        </fieldset><fieldset>hola</fieldset>';



                                    echo'</form>';
                                    break;
                                case "Musico":
                                    echo ' 
        <form action = "" method = "POST" enctype="multipart/form-data">
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
                            Imagen :<input type="file" name="fileToUpload" maxlength = "50" minlength = "5">
                            </div>
                            <div id = "Web" class = "padding5 align_right">
                            Web :<input type = "text" name = "web" maxlength = "20" minlength = "5" >
                            </div>
                            <div id="Descripcion" class="padding5 align_right">
                    Descripción :<textarea name="descripcion" maxlength="255" rows="5" cols="50"></textarea>
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
    </body>
</html>