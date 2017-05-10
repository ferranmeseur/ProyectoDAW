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
        return $result;
    } else {
        return null;
    }
    desconectar($conexion);
}

function BusquedaArtista($busqueda) {
    $conexion = conectar();
    $sql = "SELECT * FROM USUARIO WHERE NOMBRE_ARTISTICO LIKE '%" . $busqueda . "%'";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        return $result;
    } else {
        return null;
    }
    desconectar($conexion);
}

function BusquedaConciertoPorArtista($busqueda) {
    $conexion = conectar();
    $sql = "SELECT *,(SELECT NOMBRE_LOCAL FROM USUARIO WHERE ID_USUARIO=CONCIERTO.ID_LOCAL) AS NOMBRE_LOCAL FROM CONCIERTO INNER JOIN USUARIO ON CONCIERTO.ID_GRUPO = USUARIO.ID_USUARIO WHERE USUARIO.NOMBRE_ARTISTICO LIKE '%$busqueda%'";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        return $result;
    } else {
        return null;
    }
    desconectar($conexion);
}

function BusquedaConciertoPorLocal($busqueda) {
    $conexion = conectar();
    $sql = "SELECT *,(SELECT NOMBRE_ARTISTICO FROM USUARIO WHERE ID_USUARIO=CONCIERTO.ID_GRUPO) AS NOMBRE_ARTISTICO FROM CONCIERTO INNER JOIN USUARIO ON CONCIERTO.ID_LOCAL = USUARIO.ID_USUARIO WHERE USUARIO.NOMBRE_LOCAL LIKE '%$busqueda%'";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        return $result;
    } else {
        return null;
    }
    desconectar($conexion);
}

/* INFORMACIONES */

function InfoGrupo($nombre) {
    $conexion = conectar();
    $sql = "SELECT * FROM CONCIERTO INNER JOIN USUARIO ON CONCIERTO.ID_GRUPO=USUARIO.ID_USUARIO WHERE USUARIO.NOMBRE_ARTISTICO = '$nombre'";
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
    $sql = "SELECT SUM(PUNTOS) AS PUNTOS, ID_VOTADO, NOMBRE FROM VOTAR_COMENTAR INNER JOIN USUARIO ON VOTAR_COMENTAR.ID_VOTADO=USUARIO.ID_USUARIO WHERE USUARIO.TIPO_USUARIO = 'MUSICO' GROUP BY ID_VOTADO ORDER BY PUNTOS ASC";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        return $result;
    } else {
        return 0;
    }
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
    $sql = "SELECT USUARIO.NOMBRE_ARTISTICO,SUM(PUNTOS) AS PUNTOS, ID_VOTADO FROM VOTAR_COMENTAR INNER JOIN USUARIO ON VOTAR_COMENTAR.ID_VOTADO = USUARIO.ID_USUARIO WHERE ID_GENERO = (SELECT ID_GENERO FROM GENERO WHERE NOMBRE='" . $genero . "') GROUP BY ID_VOTADO";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {
            echo '<div>' . $row["NOMBRE_ARTISTICO"] . ' ' . $row["PUNTOS"] . '</div>';
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
    $sql = "SELECT *,(SELECT NOMBRE_LOCAL FROM USUARIO WHERE ID_USUARIO=ID_LOCAL) AS LOCAL_NOMBRE FROM CONCIERTO INNER JOIN USUARIO ON CONCIERTO.ID_GRUPO = USUARIO.ID_USUARIO";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        echo "<table>"
        . "<tr>"
        . "<td>NOMBRE GRUPO</td>"
        . "<td>NOMBRE LOCAL</td>"
        . "<td>FECHA</td>"
        . "<td>HORA</td>"
        . "</tr>";
        while ($row = $result->fetch_assoc()) {
            $nuevaFecha = date("d-m-Y", strtotime($row["FECHA"]));
            $nuevaHora = date("H:i", strtotime($row["FECHA"]));
            echo "<tr>";
            echo "<td>" . $row["NOMBRE"] . "</td><td>" . $row["LOCAL_NOMBRE"] . "</td><td>" . $nuevaFecha . "</td><td>" . $nuevaHora . "</td></br>";
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
    $sql = "SELECT *, (SELECT NOMBRE_ARTISTICO FROM USUARIO WHERE ID_USUARIO = ID_GRUPO) AS GRUPO_NOMBRE FROM CONCIERTO RIGHT JOIN USUARIO ON CONCIERTO.ID_LOCAL = USUARIO.ID_USUARIO WHERE CONCIERTO.ID_CIUDAD = (SELECT ID_CIUDAD FROM CIUDAD WHERE NOMBRE='$ciudad')";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $nuevaFecha = date("d-m-Y", strtotime($row["FECHA"]));
            $nuevaHora = date("H:i", strtotime($row["FECHA"]));
            echo "<div>" . $row["GRUPO_NOMBRE"] . " " . $row["NOMBRE"] . " " . $nuevaFecha . " " . $nuevaHora . "</div>";
        }
    }
    desconectar($conexion);
}

/* CONCIERTOS POR GENERO:
  LISTA GENEROS (HECHO ARRIBA)
  TEN CUIDADO EN EL SELECT QUE BUSCAS POR ID (METE ID EN EL VALUE) */

function ListaConciertosGenero($genero) {
    $conexion = conectar();
    $sql = "SELECT *, (SELECT NOMBRE_LOCAL FROM USUARIO WHERE ID_USUARIO=ID_LOCAL) AS LOCAL_NOMBRE FROM CONCIERTO INNER JOIN USUARIO ON CONCIERTO.ID_GRUPO=USUARIO.ID_USUARIO WHERE CONCIERTO.ID_GENERO =(SELECT ID_GENERO FROM GENERO WHERE NOMBRE='$genero');";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $nuevaFecha = date("d-m-Y", strtotime($row["FECHA"]));
            $nuevaHora = date("H:i", strtotime($row["FECHA"]));
            echo "<div>" . $row["NOMBRE"] . " " . $row["LOCAL_NOMBRE"] . " " . $nuevaFecha . " " . $nuevaHora . "</div>";
        }
    }
    desconectar($conexion);
}

/* CONCIERTOS POR GRUPO: */

function ListaGrupos() {
    $conexion = conectar();
    $sql = "SELECT NOMBRE_ARTISTICO, ID_USUARIO FROM USUARIO WHERE TIPO_USUARIO = 'MUSICO'";
    $result = $conexion->query($sql);
    if ($result->num_rows) {
        return $result;
    }
    desconectar($conexion);
}

function ListaConciertosGrupo($grupo) {
    $conexion = conectar();
    $sql = "SELECT *, (SELECT NOMBRE_LOCAL FROM USUARIO WHERE ID_USUARIO=ID_LOCAL) AS LOCAL_NOMBRE FROM CONCIERTO RIGHT JOIN USUARIO ON CONCIERTO.ID_GRUPO = USUARIO.ID_USUARIO WHERE USUARIO.ID_USUARIO=$grupo";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $nuevaFecha = date("d-m-Y", strtotime($row["FECHA"]));
            $nuevaHora = date("H:i", strtotime($row["FECHA"]));
            echo "<div>" . $row["NOMBRE"] . " " . $row["LOCAL_NOMBRE"] . " " . $nuevaFecha . " " . $nuevaHora . "</div>";
        }
    }
    desconectar($conexion);
}

/* CONCIERTOS POR LOCAL: */

function ListaLocales() {
    $conexion = conectar();
    $sql = "SELECT NOMBRE_LOCAL, ID_USUARIO FROM USUARIO WHERE TIPO_USUARIO = 'LOCAL' GROUP BY NOMBRE_LOCAL";
    $result = $conexion->query($sql);
    if ($result->num_rows) {
        return $result;
    }
    desconectar($conexion);
}

/* TEN CUIDADO EN EL SELECT QUE BUSCAS POR ID (METE ID EN EL VALUE) */

function ListaConciertosLocal($local) {
    $conexion = conectar();
    $sql = "SELECT *, (SELECT NOMBRE_ARTISTICO FROM USUARIO WHERE ID_USUARIO=ID_GRUPO) AS ARTISTICO_NOMBRE FROM CONCIERTO RIGHT JOIN USUARIO ON CONCIERTO.ID_LOCAL = USUARIO.ID_USUARIO WHERE CONCIERTO.ID_LOCAL =$local";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $nuevaFecha = date("d-m-Y", strtotime($row["FECHA"]));
            $nuevaHora = date("H:i", strtotime($row["FECHA"]));
            echo "<div>" . $row["ARTISTICO_NOMBRE"] . " " . $row["NOMBRE"] . " " . $nuevaFecha . " " . $nuevaHora . "</div>";
        }
    }
    desconectar($conexion);
}

/* UTILIDADES */

function showAlert($alert) {
    echo '<script language="javascript">alert("' . $alert . '");</script>';
}

function Registro($tipo, $nombre, $apellido, $email, $pswd) {
    $con = conectar();
    $pass = password_hash($pswd, PASSWORD_DEFAULT);
    $insert = "insert into USUARIO (TIPO_USUARIO,NOMBRE,APELLIDOS,EMAIL,PASSWORD) values ('$tipo','$nombre','$apellido','$email','$pass')";
    if (mysqli_query($con, $insert)) {
        header("refresh:2;url=index.php");
    } else {
        echo mysqli_error($con);
    }
    desconectar($con);
}

function checkPassword($pas1, $pas2) {
    if ($pas1 == $pas2)
        return true;
    else
        return false;
}

function checkUser($user) {
    $con = conectar();
    $sql = "select * from USUARIO where NOMBRE='$user'";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        return false;
    } else {
        return true;
    }
    desconectar($con);
}

function checkMail($mail) {
    $con = conectar();
    $sql = "select * from USUARIO where EMAIL='$mail'";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        return false;
    } else {
        return true;
    }
    desconectar($con);
}
