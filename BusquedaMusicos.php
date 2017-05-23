<?php

require_once 'bbdd.php';

function BusquedaMusicos() {
    echo'<form class="center padding20" action= "Grupo.php" method = "POST" >';
    echo '<span class="inline custom-dropdown border_dropdow">';
    $ciudades = ListaCiudades();
    echo'<select name="ciudad">
                    <option selected value="">Todas las ciudades</option>';
    while ($fila2 = mysqli_fetch_array($ciudades)) {
        extract($fila2);
        echo"<option value='$ID_CIUDAD'>$NOMBRE</option>";
    }
    echo'</select></span>';
    echo '<span class="inline custom-dropdown border_dropdow">';
    $generos = ListaGeneros();
    echo'<select name="genero">
                <option selected value="">Todos los generos</option>';
    while ($fila2 = mysqli_fetch_array($generos)) {
        extract($fila2);
        echo"<option value='$ID_GENERO'>$NOMBRE</option>";
    }
    echo'</select></span>';
    
    echo '<button class="button-form-solo inline" type="submit" value="submit" name="submit">BUSCAR</button>';
    echo '</form>';
}

?>