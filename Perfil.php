<!DOCTYPE html>
<?php
session_start();
require_once 'bbdd.php';
if (isset($_SESSION['tipo']) && isset($_SESSION['email'])) {
    
} else {
    echo "Acceso denegado";
    return 0;
}
?>
<html>
    <head>
        <title>Perfil</title>
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

        <div class="center">
            <div class="inline">
                <div id="Labels" class="inline text_align_left ">
                    <?php
                    require_once 'bbdd.php';
                    $info = getInfoUser($_SESSION['email']);
                    echo '</br><div id="result" class="center">
            Bienvenido :</div></br></br>';
                    switch ($_SESSION['tipo']) {
                        case "Fan":

                            break;
                        case "Local":

                            break;
                        case "Musico":
                            echo "Que ise";
                            break;
                    }
                    ?>
                </div>
            </div>
        </div>
        <div id="footer"></div>
    </body>
</html>