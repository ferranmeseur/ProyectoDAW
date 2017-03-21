<?php

function conectar() {
    $conexion = mysqli_connect('localhost', 'root', '', 'musicandseek')
            or die("Error conectando");
    return $conexion;
}

function desconectar($conexion) {
    mysqli_close($conexion);
}

/* HOMEPAGE */

//comprobar que existe un usuario conectado para cambiar 'area personal' o 'registrarse'
function CheckUsuarioConectado($sessionToken) {
    /* SELECT * FROM USUARIO WHERE sessionToken = '$sessionToken'; */
}

//Busca por musicos, locales o conciertos
function BusquedaLocal($nombre) {
    $conexion = conectar();
    $sql = "SELECT * FROM USUARIO WHERE NOMBRE_LOCAL LIKE '%" . $nombre . "%'";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        return $result;
    } else {
        return null;
    }
    desconectar($conexion);
}

function BusquedaArtista($nombre) {
    $conexion = conectar();
    $sql = "SELECT * FROM USUARIO WHERE NOMBRE_ARTISTICO LIKE '%" . $nombre . "%'";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        return $result;
    } else {
        return null;
    }
    desconectar($conexion);
}

function BusquedaConciertoPorArtista($nombre) {
    $conexion = conectar();
    $sql = "SELECT * FROM CONCIERTO INNER JOIN USUARIO ON CONCIERTO.ID_GRUPO = USUARIO.ID_USUARIO WHERE USUARIO.NOMBRE_ARTISTICO LIKE '%" . $nombre . "%'";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        return $result;
    } else {
        return null;
    }
    desconectar($conexion);
}

function BusquedaConciertoPorLocal($nombre) {
    $conexion = conectar();
    $sql = "SELECT * FROM CONCIERTO INNER JOIN USUARIO ON CONCIERTO.ID_GRUPO = USUARIO.ID_USUARIO WHERE USUARIO.NOMBRE_LOCAL LIKE '%" . $nombre . "%'";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        return $result;
    } else {
        return null;
    }
    desconectar($conexion);
}

/* RANKING */

function RankingMusicos() {
    $conexion = conectar();
    $sql = "SELECT SUM(PUNTOS), ID_VOTADO, NOMBRE FROM VOTAR_COMENTAR INNER JOIN USUARIO ON VOTAR_COMENTAR.ID_VOTADO=USUARIO.ID_USUARIO WHERE *******  GROUP BY ID_VOTADO";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        echo "<table>"
        . "<tr>"
        . "<td>NOMBRE</td>"
        . "<td>PUNTOS</td>"
        . "</tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["NOMBRE"] . "</td><td>" . $row["PUNTOS"] . "</td></br>";
            echo "</tr>";
        }
    } else {
        echo "0 results";
    }
    desconectar($conexion);
}

/* RANKING POR GENERO */

function ListaGeneros() {
    $conexion = conectar("basket");
    $sql = "SELECT NOMBRE, ID_GENERO FROM GENERO ORDER BY NOMBRE ASC";
    $result = $conexion->query($sql);
    if ($result->num_rows) {
        return $result;
    } else {
        return null;
    }
    desconectar($conexion);
}

function RankingPorGenero($genero) {
    /* SELECT SUM(PUNTOS), ID_VOTADO FROM VOTAR_COMENTAR INNER JOIN USUARIO ON VOTAR_COMENTAR.ID_VOTADO = USUARIO.ID_USUARIO WHERE id_genero = 'GENERO' GROUP BY ID_VOTADO; */
    
    
}

/* RANKING POR CIUDAD */

function ListaCiudades() {
    /* SELECT NOMBRE, ID_CIUDAD FROM CIUDAD ORDER BY NOMBRE ASC; */
}

function RankingPorciudad($ciudad) {
    /* SELECT SUM(PUNTOS), ID_VOTADO FROM VOTAR_COMENTAR INNER JOIN USUARIO ON VOTAR_COMENTAR.ID_VOTADO = USUARIO.ID_USUARIO WHERE ID_CIUDAD = 'CIUDAD' GROUP BY ID_VOTADO; */
}
/*
CONCIERTOS:
SELECT * FROM CONCIERTOS;
CONCIERTOS POR CIUDAD:
SELECT NOMBRE, ID_CIUDAD FROM CIUDAD ORDER BY NOMBRE ASC;
SELECT * FROM CONCIERTO RIGHT JOIN USUARIO ON CONCIERTO.ID_LOCAL = USUARIO.ID_USUARIO WHERE ID_CIUDAD = 'CIUDAD';
CONCIERTOS POR GENERO:
SELECT NOMBRE, ID_GENERO FROM GENERO ORDER BY NOMBRE ASC;
SELECT * FROM CONCIERTO WHERE ID_GENERO = 'GENERO';
CONCIERTOS POR GRUPO:
SELECT NOMBRE, ID_USUARIO FROM USUARIO WHERE TIPO_USUARIO = 'MUSICO';
SELECT * FROM CONCIERTO RIGHT JOIN USUARIO ON CONCIERTO.ID_GRUPO = USUARIO.ID_USUARIO WHERE ID_USUARIO = 'ID_USUARIO';
CONCIERTOS POR LOCAL:
SELECT NOMBRE, ID_USUARIO FROM USUARIO WHERE TIPO_USUARIO = 'LOCAL';
SELECT * FROM CONCIERTO RIGHT JOIN USUARIO ON CONCIERTO.ID_LOCAL = USUARIO.ID_USUARIO WHERE ID_USUARIO = 'ID_USUARIO';
 
 */
?>



