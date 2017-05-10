<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
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
        <div class="center">Log into Music and Seek
            </br>
            <input  id="password" placeholder="Password" required="" type="password"></br>     
            <input name="email" placeholder="Email" required="" type="email"></br>
            <a class="fontblack" href="Registro.php">Nuevo usuario?</a>
            <a class="fontblack" href="RecuperarContrasenya.php">Has olvidado tu contraseña?</a></br>
            <button type="submit">Log in</button>
        </div>
        <div id="footer"></div>
    </body>
</html>