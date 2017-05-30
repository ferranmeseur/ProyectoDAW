<!DOCTYPE html>
<?php
session_start();
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

            $(function () {

//jQuery time
                var current_fs, next_fs, previous_fs; //fieldsets
                var left, opacity, scale; //fieldset properties which we will animate
                var animating; //flag to prevent quick multi-click glitches

                $(".next").click(function () {
                    if (animating)
                        return false;
                    animating = true;

                    current_fs = $(this).parent();
                    next_fs = $(this).parent().next();

                    //activate next step on progressbar using the index of next_fs
                    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

                    //show the next fieldset
                    next_fs.show();
                    //hide the current fieldset with style
                    current_fs.animate({opacity: 0}, {
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

                    current_fs = $(this).parent();
                    previous_fs = $(this).parent().prev();

                    //de-activate current step on progressbar
                    $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

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
    </head>
    <body>
        <div id="header"></div>
        <div class="center">
            <div id="Registro" class="center inline">
                <?php
                require_once 'bbdd.php';

                function check() {
                    $tipo = $_POST["tipo"];
                    $nombre = $_POST["nombre"];
                    $apellido = $_POST["apellido"];
                    $pas1 = $_POST["pas1"];
                    $pas2 = $_POST["pas2"];
                    $mail1 = $_POST["mail1"];
                    $mail2 = $_POST["mail2"];
                    if (!checkPassword($pas1, $pas2)) {
                        showAlert("Las contraseñas deben coincidir");
                    } elseif (!checkPassword($mail1, $mail2)) {
                        showAlert("Los Emails deben coincidir");
                    } elseif (!existMail($mail1)) {
                        showAlert("El mail ya esta registrado");
                    } else {
                        $_POST["valoresok"] = "submit";
                    }
                }

                if (isset($_POST["enviar"])) {
                    check();
                }

                if (isset($_POST["valoresok"])) {
                    $tipo = $_POST["tipo"];
                    $nombre = $_POST["nombre"];
                    $apellido = $_POST["apellido"];
                    $pas1 = $_POST["pas1"];
                    $pas2 = $_POST["pas2"];
                    $mail1 = $_POST["mail1"];
                    $mail2 = $_POST["mail2"];
                    $pregunta = $_POST["pregunta"];
                    $respuesta = $_POST["respuesta"];
                    $_SESSION['tipo'] = $tipo;
                    $_SESSION['mail'] = $mail1;
                    $_SESSION['nombre'] = $nombre;
                    $_SESSION['apellido'] = $apellido;
                    $_SESSION['pas'] = $pas1;
                    $_SESSION['pregunta'] = $pregunta;
                    $_SESSION['respuesta'] = $respuesta;
                        echo "<script language='javascript'>$('html').load('RegistroExtraFan.php');</script>";
                } else {
                    echo'<form action = "" method = "POST" id="msform">
                    <ul id="progressbar">
                        <li class="active">Registro</li>
                        <li>Detalles de cuenta</li>
                        <li>Perfil</li>
                    </ul>
                    <div id="Rol" class="center">
                        <fieldset>
                            <div class="register-switch">
                                <input type="radio" name="tipo" value="Fan" id="fan" class="register-switch-input" checked>
                                <label for="fan" class="register-switch-label">Fan</label>
                                <input type="radio" name="tipo" value="Musico" id="musico" class="register-switch-input">
                                <label for="musico" class="register-switch-label">Musico</label>
                                <input type="radio" name="tipo" value="Local" id="local" class="register-switch-input">
                                <label for="local" class="register-switch-label">Local</label>
                            </div>

                            <input type = "text" name = "mail1" placeholder="Email" maxlength="50" minlength="5" required/>
                            <input type = "text" name = "mail2" placeholder="Confirmar email" maxlength="50" minlength="5" required/>
                            <input type = "password" name = "pas1" placeholder="Contraseña" maxlength="10" minlength="5" required/>
                            <input type = "password" name = "pas2" placeholder="Confirma la contraseña" maxlength="10" minlength="5" required/>

                            <input type="button" name="enviar" class="next action-button" value="Siguiente" />
                        </fieldset>
                        
                        <fieldset>
                            <input type = "text" name = "nombre" placeholder="Nombre" maxlength="20" minlength="3" required/>
                            <input type = "text" name = "apellido" placeholder="Apellidos" maxlength="20" minlength="3"/>
                            <input type = "text" name = "pregunta" placeholder="Pregunta de Seguridad" maxlength="40" minlength="5" required>
                            <input type = "text" name = "respuesta" placeholder="Respuesta de Seguridad" maxlength="20" minlength="5" required>
                            <input type="button" name="previous" class="previous action-button" value="Anterior" />
                            <input type="submit" name="enviar" class="submit action-button" value="Siguiente" />

                        </fieldset>';
                        
                    echo'</form>
                    </div>
            </div>';
                }
                ?>
            </div>
        </div>
        <div id="footer"></div>
    </body>
</html>