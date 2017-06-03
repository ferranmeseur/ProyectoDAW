<!DOCTYPE html>
<html>
    <head>
        <title>Musico</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="Estilos/Estilos.css" rel="stylesheet" type="text/css"/>
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
        <div id="Secciones">
            <div id="Proximos_Conciertos" class="width_48 inline verticaltop">
                <div>
                    <div class="width_40 height_20 inline">Proximos Conciertos</div>
                </div>
                <div id="lista_conciertos" class="center width_50 inline">
                    <div id="Concierto1">
                        <div class="inline">Concierto 1</div>
                        <img class="arrow inline" src="Imagenes/arrow.png" alt=""/>
                    </div>
                    <div id="Concierto2">
                        <div class="inline">Concierto 2</div>
                        <img class="arrow inline" src="Imagenes/arrow.png" alt=""/>
                    </div>
                    <div id="Concierto3">
                        <div class="inline">Concierto 3</div>
                        <img class="arrow inline" src="Imagenes/arrow.png" alt=""/>
                    </div>
                </div>
            </div>
            <div id="Concierto_Info" class="width_48 inline">
                <div>
                    <div class="width_40 inline">Concierto</div>
                </div>
                <div id="Cocierto_text" class="center  "> RE IPSUM LORE IPSURE IPSUM LORE IPSUM LORE IPSUM LORE IPSUM LORE IPSUM LORE IPSUMM LORE IPSUM LORE IPSUM LORE IPSUM LORE IPSUM RE IPSUM LORE IPSUM LORE IPSUM LORE IPSUM LORE IPSUM LORE IPSUM LORE IPSUM LORE IPSUM LORE IPSUM LORE IPSUM LORE IPSUM LORE IPSUM LORE IPSUM LORE IPSUM LORE IPSUM LORE IPSUM LORE IPSUM LORE IPSUM LORE IPSUM LORE IPSUM LORE IPSUM LORE IPSUM LORE IPSUM LORE IPSUM LORE IPSUM LORE IPSUM LORE IPSUM LORE IPSUM LORE IPSUM LORE IPSUM LORE IPSUM LORE IPSUM LORE IPSUM LORE IPSUM LORE IPSUM LORE IPSUM LORE IPSUM LORE IPSUM LORE IPSUM LORE IPSUM LORE IPSUM LORE IPSUM</div> 
            </div>
            <br>
            <div id="Mis_Grupos" class="width_48 inline ">
                <div>
                    <div class="width_40 height_20 inline">Mis Grupos</div>
                </div>
                <div id="lista_grupos" class="center width_50 inline">
                    <div id="Grupo1">
                        <img class="arrow inline" src="Imagenes/image.jpeg" alt=""/>
                        <div class="inline">Grupo 1</div>     
                    </div>
                    <div id="Grupo2">
                        <img class="arrow inline" src="Imagenes/image.jpeg" alt=""/>
                        <div class="inline">Grupo 2</div>
                    </div>
                    <div id="Grupo3">
                        <img class="arrow inline" src="Imagenes/image.jpeg" alt=""/>
                        <div class="inline">Grupo 3</div>
                    </div>
                </div>
            </div>
            <div id="Inbox" class="width_48 inline">
                <div>
                    <div class="width_40 height_20 inline">Inbox</div>
                </div>
                <div id="lista_inbox" class=" center width_50 inline">
                    <div id="Mensaje1" class="height_60">
                        <div>Mensaje 1</div> 
                    </div>
                    <div id="Mensaje2" class="height_60">
                        <div>Mensaje 2</div> 
                    </div>
                    <div id="Mensaje3" class="height_40 ">
                        <div>Mensaje 3</div> 
                    </div>
                </div>
            </div>
        </div>
        <div id="Tocar_Local" class="text_align_left">
            <div class="inline">Tocar en un local</div>
            <div class="inline">Buscador</div>
            <div id="lista_locales" class="width_40">
                <div id="Local1">
                    <p>Local 1</p> 
                </div>
                <div id="Local2">
                    <p>Local 2</p> 
                </div>
                <div id="Local3">
                    <p>Local 3</p> 
                </div>
            </div>
        </div>
        <div id="footer"></div>
    </body>
</html>
