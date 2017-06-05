<!DOCTYPE html>
<html>
    <head>
        <?php
        session_start();
        if (isset($_SESSION['pass'])) {
            echo'           
        <title>Baja Usuario</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script>
            $(function () {
                $("#header").load("Header.php");
                $("#footer").load("Footer.html");
            });
        </script> 
        <link href="../Estilos/Estilos.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div id="header"></div> 
        <div class="content center">
            <h1><span class="color_rojo_general">Usuario </span>dado de <span class="color_rojo_general">Baja </span>Correctamente</h1>
        </div>
        <div id="footer"></div>
    </body>
</html>';
            darBaja($_SESSION['email']);
            header("refresh:0; url=Logout.php");
        } else {
            header("refresh:0; url=HomePage.php");
        }
        ?>
