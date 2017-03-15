<!DOCTYPE html>
<html>
    <head>
        <title>Recuperar Contraseña</title>
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
        <div class="center">Introduce tu Email para recuperar la contraseña
            </br>
            <input name="email" placeholder="Email" required="" type="email"></br>
            <button type="submit">Recuperar contraseña</button>
        </div>
        <div id="footer"></div>
    </body>
</html>