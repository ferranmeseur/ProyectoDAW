<link href="Estilos/Estilos.css" rel="stylesheet" type="text/css"/>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>

<script>
    $(window).scroll(function () {
        $("#theFixed").css("top", Math.max(0, 203 - $(this).scrollTop()));
    });


    var titulo = $('#title');
    var range = 500;


    $(window).on('scroll', function () {

        var scrollTop = $(this).scrollTop();
        var offset = titulo.offset().top;
        var height = titulo.outerHeight();
        offset = offset + height / 2;
        var calc = 1 - (scrollTop - offset + range) / range;

        titulo.css({'opacity': calc});

        if (calc > '0.18') {
            titulo.css({'opacity': 1});
        } else if (calc < '0') {
            titulo.css({'opacity': 0});
        }
    });



</script>
<header>
    <div class="center">
        <a href="HomePage.php"><img id="title"  src="Imagenes/TITTLE.png" alt=""/></a>
    </div>      
    <div class="topnav sticky z_index10" style="position:fixed;top:203px;width:100%" id="theFixed">
        <div class="center" style="width:100%">
            <a id='inicio' class="inline fonts" href="HomePage.php">INICIO</a>
            <a id='busqueda' class="inline fonts" href="Busqueda.php">BÚSQUEDA</a>
            <a id='ranking' class="inline fonts" href="Ranking.php">RANKING</a>
            <a id='conciertos' class="inline fonts" href="Concierto.php">CONCIERTOS</a>
            <a id='grupos' class="inline fonts" href="Grupo.php">GRUPOS</a>
            <a id='locales' class="inline fonts" href="Local.php">LOCALES</a>
            <a id='area' class="inline fonts" href="Perfil.php">AREA PERSONAL</a>
            <?php
            session_start();
            if (isset($_SESSION['pass'])) {
                echo '<a id="logout" class = "inline fonts" href = "Logout.php">LOG OUT</a>';
            }
            ?>
        </div>
    </div>

    <div style = "height:50px;background-color: white"></div>

</header>
