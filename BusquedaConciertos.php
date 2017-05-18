<?php

require_once 'bbdd.php';

function BusquedaConciertos() {
    echo'<form class="center padding20" action= "Concierto.php" method = "POST" >';
    echo '<span class="inline custom-dropdown border_dropdow">';
    echo '<select name="futurosConciertos">';
    echo '<option selected value="true">Proximos conciertos</option>';
    echo '<option value="false">Conciertos pasados</option>';
    echo '</select></span>';
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
    echo '<span class="inline custom-dropdown border_dropdow">';
    $grupos = ListaGrupos();
    echo'<select name="grupo">
                <option selected value="">Todos los grupos</option>';
    while ($fila2 = mysqli_fetch_array($grupos)) {
        extract($fila2);
        echo"<option value='$ID_USUARIO'>$NOMBRE_ARTISTICO</option>";
    }
    echo'</select></span>';
    echo '<span class="inline custom-dropdown border_dropdow">';
    $locales = ListaLocales();
    echo'<select name="id_local">
                <option selected value="">Todos los locales</option>';
    while ($fila2 = mysqli_fetch_array($locales)) {
        extract($fila2);
        echo"<option value='$ID_USUARIO'>$NOMBRE_LOCAL</option>";
    }
    echo '</select></span>';

    echo '<button class="button-form-solo inline" type="submit" value="submit" name="submit">BUSCAR</button>';
    echo '</form>';
}

?>