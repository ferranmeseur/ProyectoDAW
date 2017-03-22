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
function BusquedaLocal($busqueda) {
    $conexion = conectar();
    $sql = "SELECT * FROM USUARIO WHERE NOMBRE_LOCAL LIKE '%" . $busqueda . "%'";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        echo "<table>";
        echo '<tr><td>Local</td></tr>';
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row['NOMBRE_LOCAL'] . "</td></tr> ";
        }
        echo "</table>";
    }
    desconectar($conexion);
}

function BusquedaArtista($busqueda) {
    $conexion = conectar();
    $sql = "SELECT * FROM USUARIO WHERE NOMBRE_ARTISTICO LIKE '%" . $busqueda . "%'";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        echo "<table>";
        echo '<tr><td>Artistas</td></tr>';
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row['NOMBRE_ARTISTICO'] . "</td></tr> ";
        }
        echo "</table>";
    }
    desconectar($conexion);
}

function BusquedaConciertoPorArtista($busqueda) {
    $conexion = conectar();
    $sql = "SELECT * FROM CONCIERTO INNER JOIN USUARIO ON CONCIERTO.ID_GRUPO = USUARIO.ID_USUARIO WHERE USUARIO.NOMBRE_ARTISTICO LIKE '%" . $busqueda . "%'";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        echo "<table>";
        echo '<tr><td>Concierto - Artistas</td></tr>';
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row['ID_CONCIERTO'] . "</td></tr> ";
        }
        echo "</table>";
    }
    desconectar($conexion);
}

function BusquedaConciertoPorLocal($nombre) {
    $conexion = conectar();
    $sql = "SELECT * FROM CONCIERTO INNER JOIN USUARIO ON CONCIERTO.ID_GRUPO = USUARIO.ID_USUARIO WHERE USUARIO.NOMBRE_LOCAL LIKE '%" . $nombre . "%'";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        echo "<table>";
        echo '<tr><td>Concierto - Local</td></tr>';
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row['ID_CONCIERTO'] . "</td></tr> ";
        }
        echo "</table>";
    }
    desconectar($conexion);
}

/* RANKING */

function RankingMusicos() {
    $conexion = conectar();
    $sql = "SELECT SUM(PUNTOS) AS PUNTOS, ID_VOTADO, NOMBRE FROM VOTAR_COMENTAR INNER JOIN USUARIO ON VOTAR_COMENTAR.ID_VOTADO=USUARIO.ID_USUARIO WHERE USUARIO.TIPO_USUARIO = 'MUSICO' GROUP BY ID_VOTADO ORDER BY PUNTOS ASC";
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
    }
    echo'</table>';
    desconectar($conexion);
}

/* RANKING POR GENERO */

function ListaGeneros() {
    $conexion = conectar();
    $sql = "SELECT NOMBRE FROM GENERO ORDER BY NOMBRE ASC";
    $result = $conexion->query($sql);
    if ($result->num_rows) {
        return $result;
    } else {
        return null;
    }
    desconectar($conexion);
}

function RankingPorGenero($genero) {
    $conexion = conectar();
    $sql = "SELECT USUARIO.NOMBRE_ARTISTICO,SUM(PUNTOS), ID_VOTADO FROM VOTAR_COMENTAR INNER JOIN USUARIO ON VOTAR_COMENTAR.ID_VOTADO = USUARIO.ID_USUARIO WHERE ID_GENERO = (SELECT ID_GENERO FROM GENERO WHERE NOMBRE='" . $genero . "') GROUP BY ID_VOTADO";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        echo "<div>"
        . "NOMBRE ARTISTICO"
        . "</div>";
        while ($row = $result->fetch_assoc()) {
            echo '<div>' . $row["NOMBRE_ARTISTICO"] . '</div>';
        }
    }
}

/* RANKING POR CIUDAD */

function ListaCiudades() {
    $conexion = conectar();
    $sql = "SELECT NOMBRE FROM CIUDAD ORDER BY NOMBRE ASC";
    $result = $conexion->query($sql);
    if ($result->num_rows) {
        return $result;
    } else {
        return null;
    }
    desconectar($conexion);
}

/* RANKING POR CIUDAD = GRUPOS DE ESA CIUDAD O = GRUPOS CON MEJORES NOTAS DE CONCIERTOS EN ESA CIUDAD? */
/* ESTA HECHO POR GRUPOS DE ESA CIUDAD */

function RankingPorCiudad($ciudad) {
    $conexion = conectar();
    $sql = "SELECT USUARIO.NOMBRE_ARTISTICO,SUM(PUNTOS) AS PUNTOS, ID_VOTADO FROM VOTAR_COMENTAR INNER JOIN USUARIO ON VOTAR_COMENTAR.ID_VOTADO = USUARIO.ID_USUARIO WHERE USUARIO.ID_CIUDAD = (SELECT ID_CIUDAD FROM CIUDAD WHERE NOMBRE='" . $ciudad . "') GROUP BY ID_VOTADO";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div>' . $row["NOMBRE_ARTISTICO"] . ' ' . $row["PUNTOS"] . '</div>';
        }
    }
}

/* CONCIERTOS: */

function ListaConciertos() {
    $conexion = conectar();
    $sql = "SELECT * FROM CONCIERTO";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        echo "<table>"
        . "<tr>"
        . "<td>NOMBRE GRUPO</td>"
        . "<td>NOMBRE LOCAL</td>"
        . "<td>FECHA</td>"
        . "</tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["ID_GRUPO"] . "</td><td>" . $row["ID_LOCAL"] . "</td><td>" . $row["FECHA"] . "</td></br>";
            echo "</tr>";
        }
    }
    desconectar($conexion);
}

/*
  CONCIERTOS POR CIUDAD:
  LISTA CIUDADES (HECHO ARRIBA)
  TEN CUIDADO EN EL SELECT QUE BUSCAS POR ID (METE ID EN EL VALUE) */

function ListaConciertosCiudad($ciudad) {
    $conexion = conectar();
    $sql = "SELECT CONCIERTO.ID_GRUPO,CONCIERTO.ID_LOCAL,CONCIERTO.FECHA FROM CONCIERTO RIGHT JOIN USUARIO ON CONCIERTO.ID_LOCAL = USUARIO.ID_USUARIO WHERE CONCIERTO.ID_CIUDAD = (SELECT ID_CIUDAD FROM CIUDAD WHERE NOMBRE='" . $ciudad . "')";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo'<div>' . $row["ID_GRUPO"] . ' ' . $row["ID_LOCAL"] . ' ' . $row["FECHA"] . '</div>';
        }
    }
    desconectar($conexion);
}

/* CONCIERTOS POR GENERO:
  LISTA GENEROS (HECHO ARRIBA)
  TEN CUIDADO EN EL SELECT QUE BUSCAS POR ID (METE ID EN EL VALUE) */

function ListaConciertosGenero($genero) {
    $conexion = conectar();
    $sql = "SELECT * FROM CONCIERTO WHERE ID_GENERO =(SELECT ID_GENERO FROM GENERO WHERE NOMBRE='" . $genero . "')";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo'<div>' . $row["ID_GRUPO"] . ' ' . $row["ID_LOCAL"] . ' ' . $row["FECHA"] . '</div>';
        }
    }
    desconectar($conexion);
}

/* CONCIERTOS POR GRUPO: */

function ListaGrupos() {
    $conexion = conectar();
    $sql = "SELECT NOMBRE_ARTISTICO FROM USUARIO WHERE TIPO_USUARIO = 'MUSICO'";
    $result = $conexion->query($sql);
    if ($result->num_rows) {
        return $result;
    }
    desconectar($conexion);
}

/* TEN CUIDADO EN EL SELECT QUE BUSCAS POR ID (METE ID EN EL VALUE) */

function ListaConciertosGrupo($grupo) {
    $conexion = conectar();
    $sql = "SELECT * FROM CONCIERTO RIGHT JOIN USUARIO ON CONCIERTO.ID_GRUPO = USUARIO.ID_USUARIO WHERE CONCIERTO.ID_GRUPO = (SELECT ID_USUARIO FROM USUARIO WHERE NOMBRE_ARTISTICO='.$grupo.')";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo'<div>' . $row["ID_GRUPO"] . ' ' . $row["ID_LOCAL"] . ' ' . $row["FECHA"] . '</div>';
        }
    }
    desconectar($conexion);
}

/* CONCIERTOS POR LOCAL: */

function ListaLocales() {
    $conexion = conectar();
    $sql = "SELECT NOMBRE_LOCAL, ID_USUARIO FROM USUARIO WHERE TIPO_USUARIO = 'LOCAL'";
    $result = $conexion->query($sql);
    if ($result->num_rows) {
        return $result;
    }
    desconectar($conexion);
}

/* TEN CUIDADO EN EL SELECT QUE BUSCAS POR ID (METE ID EN EL VALUE) */

function ListaConciertosLocal($local) {
    $conexion = conectar();
    $sql = "SELECT * FROM CONCIERTO RIGHT JOIN USUARIO ON CONCIERTO.ID_LOCAL = USUARIO.ID_USUARIO WHERE CONCIERTO.ID_LOCAL = (SELECT ID_USUARIO FROM USUARIO WHERE NOMBRE_LOCAL='.$local.')";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo'<div>' .$row["ID_GRUPO"] . '' . $row["ID_LOCAL"] . '' . $row["FECHA"] . '</div>';
        }
    }
    desconectar($conexion);
}
?>



