<!DOCTYPE html>
<html>
    <head>
        <link href="Estilos/Estilos.css" rel="stylesheet" type="text/css"/>
        <link href="Estilos/RegistrationForm.css" rel="stylesheet" type="text/css"/>
        <?php
        session_start();
        require_once'bbdd.php';
        if (isset($_SESSION['pass']) && !isset($_POST['no']) && !isset($_POST['si'])) {
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

    </head>
    <body>
        <div id="header"></div> 
        <div class="content center">
            <h1>¿ Seguro que quieres dar de <span class="color_rojo_general">Baja  </span>el <span class="color_rojo_general">Usuario ? </span></h1>
            <form  class="center" style="width:1000px" action="" method="POST" id="msform">        
            <div>
                <div class="inline">
                    <button style="width:400px" type="submit" class="submit action-button"  name = "no">No</button>
                </div>
                <div class="inline">
                    <button style="width:400px" type="submit" class="submit action-button"  name = "si">Si</button>
                </div>
            </div>
            </form>
        </div>
        <div id="footer"></div>
    </body>
</html>';
        } elseif (isset($_POST['no'])) {
            header("refresh:0; url=Perfil.php");
        } elseif (isset($_POST['si'])) {
            $result = darBaja($_SESSION['email']);
            echo '   <title>Baja Usuario</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script>
            $(function () {
                $("#header").load("Header.php");
                $("#footer").load("Footer.html");
            });
        </script> 
    </head>
    <body>
        <div id="header"></div> 
        <div class="content center">
            <h1><span class="color_rojo_general">Usuario </span>dado de baja <span class="color_rojo_general">Correctamente</span></h1>
        </div>
        <div id="footer"></div>
    </body>
</html>';
            header("refresh:2; url=Logout.php");
        } else {
            header("refresh:0; url=Login.php");
        }
        ?>
