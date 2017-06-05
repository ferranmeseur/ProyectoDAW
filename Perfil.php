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
        <title>Perfil</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="JS/jquery-3.2.1.js" type="text/javascript"></script>
        <script src="JS/jquery.uploadPreview.js" type="text/javascript"></script>
        <script>
            $(document).ready(function () {
                $("#header").load("Header.php");
                $("#footer").load("Footer.html");
                $.uploadPreview({
                    input_field: "#image-upload", // Default: .image-upload
                    preview_box: "#image-preview", // Default: .image-preview
                    label_field: "#image-label", // Default: .image-label
                    label_default: "Escoge foto", // Default: Choose File
                    label_selected: "Cambiar foto", // Default: Change File
                    no_label: false                 // Default: false
                });
                fanRatingFixed();
            });
            function fanRatingFixed() {
                var puntuacion = $('#puntuacion').html();
                var pointsRoundEntero = Math.floor(puntuacion);
                var pointsRoundDecimal = puntuacion - pointsRoundEntero;
                if (pointsRoundDecimal == 0) {
                    $('#star' + pointsRoundEntero).prop('checked', true);
                } else {
                    $('#star' + pointsRoundEntero + 'half').prop('checked', true);
                }
            }
            var enabled = false;
            function modificarPerfil() {

                if (enabled == true) {
                    $(".in").prop('disabled', true);
                    $('#image-label').prop('hidden', true);
                    $('#aplicarCambiosButton').prop('hidden', true);
                    $('#modificarContraseña').prop('hidden', true);
                    $('#image-upload').prop('disabled', true);
                    $('#guardarimagen').prop('hidden', true);
                    enabled = false;
                } else {
                    enabled = true
                    $('.in').removeAttr('disabled');
                    $('#image-upload').removeAttr('disabled');
                    $('#image-label').removeAttr('hidden');
                    $('#aplicarCambiosButton').removeAttr('hidden');
                    $('#modificarContraseña').removeAttr('hidden');
                    $('#guardarimagen').removeAttr('hidden');
                }
            }
            function roundToHalf(value) {
                var converted = parseFloat(value); // Make sure we have a number 
                var decimal = (converted - parseInt(converted, 10));
                decimal = Math.round(decimal * 10);
                if (decimal == 5) {
                    return (parseInt(converted, 10) + 0.5);
                }
                if ((decimal < 3) || (decimal > 7)) {
                    return Math.round(converted);
                } else {
                    return (parseInt(converted, 10) + 0.5);
                }
            }
        </script> 
        <link href="Estilos/Estilos.css" rel="stylesheet" type="text/css"/>
        <link href="Estilos/RegistrationForm.css" rel="stylesheet" type="text/css"/>
        <link href="Estilos/StarRating.css" rel="stylesheet" type="text/css"/>
        <link href="Estilos/Comments.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div id="header"></div>
        <div class="center content">
        </div>
    </div>
    <div class="center" style="width: 100%; height: 100%">
        <?php
        require_once 'bbdd.php';
        $info = getInfoUser($_SESSION['email']);
        switch ($_SESSION['tipo']) {
            case "Fan":
                informacionFan($info);
                break;
            case "Local":
                informacionLocal($info);
                break;
            case "Musico":
                informacionMusico($info);
                break;
        }

        
        ?>
    </div>
    <div id="footer"></div>


</body>

</html>

