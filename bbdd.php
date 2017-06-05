<?php

$GLOBALS['rutaImagen'] = 'Imagenes/';

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
    $sql = "SELECT *, GENERO.NOMBRE AS NOMBRE_GENERO FROM USUARIO INNER JOIN GENERO ON USUARIO.ID_GENERO = GENERO.ID_GENERO WHERE NOMBRE_LOCAL LIKE '%" . $busqueda . "%'";
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
    $sql = "SELECT *, GENERO.NOMBRE AS NOMBRE_GENERO FROM USUARIO INNER JOIN GENERO ON USUARIO.ID_GENERO = GENERO.ID_GENERO WHERE FECHA_BAJA IS null AND NOMBRE_ARTISTICO LIKE '%" . $busqueda . "%'";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        return $result;
    } else {
        return null;
    }
    desconectar($conexion);
}

function BusquedaTodosArtistas($ciudad, $genero, $letra) {
    $conexion = conectar();
    $sql = "SELECT *,LEFT(NOMBRE_ARTISTICO,1) AS LETRA FROM USUARIO WHERE TIPO_USUARIO = 'Musico' AND FECHA_BAJA is null";
    if ($ciudad != null) {
        $sql .= " AND ID_CIUDAD = $ciudad";
    }
    if ($genero != null) {
        $sql .= " AND ID_GENERO = $genero";
    }
    $sql .= " HAVING LETRA = '$letra'";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        return $result;
    } else {
        return null;
    }
    desconectar($conexion);
}

function BusquedaTodosLocales($ciudad, $letra) {
    $conexion = conectar();
    $sql = "SELECT *,LEFT(NOMBRE_LOCAL,1) AS LETRA FROM USUARIO WHERE TIPO_USUARIO = 'Local' AND FECHA_BAJA is null ";
    if ($ciudad != null) {
        $sql .= " AND ID_CIUDAD = $ciudad";
    }
    $sql .= " HAVING LETRA = '$letra'";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        return $result;
    } else {
        return null;
    }
    desconectar($conexion);
}

function getFirstLetterArtistas() {
    $conexion = conectar();
    $sql = "SELECT LEFT(NOMBRE_ARTISTICO, 1) AS LETRA FROM USUARIO WHERE TIPO_USUARIO = 'MUSICO' AND FECHA_BAJA is null GROUP BY LETRA ORDER BY NOMBRE_ARTISTICO ASC";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        return $result;
    } else {
        return null;
    }
    desconectar($conexion);
}

function getFirstLetterLocales() {
    $conexion = conectar();
    $sql = "SELECT LEFT(NOMBRE_LOCAL, 1) AS LETRA FROM USUARIO WHERE TIPO_USUARIO = 'LOCAL' AND FECHA_BAJA is null GROUP BY LETRA ORDER BY NOMBRE_LOCAL ASC";
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
    $sql = "SELECT *,(SELECT NOMBRE_LOCAL FROM USUARIO WHERE ID_USUARIO=CONCIERTO.ID_LOCAL) AS NOMBRE_LOCAL FROM CONCIERTO INNER JOIN USUARIO ON CONCIERTO.ID_GRUPO = USUARIO.ID_USUARIO WHERE USUARIO.NOMBRE_ARTISTICO LIKE '%$busqueda%' AND CONCIERTO.VISIBLE = 1 AND CONCIERTO.ESTADO=1";
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
    $sql = "SELECT *,(SELECT NOMBRE_ARTISTICO FROM USUARIO WHERE ID_USUARIO=CONCIERTO.ID_GRUPO) AS NOMBRE_ARTISTICO FROM CONCIERTO INNER JOIN USUARIO ON CONCIERTO.ID_LOCAL = USUARIO.ID_USUARIO WHERE USUARIO.NOMBRE_LOCAL LIKE '%$busqueda%' AND CONCIERTO.ESTADO=1";
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

function RankingMusicos($genero, $ciudad) {
    $conexion = conectar();
    $isFirst = 1;
    if (!isset($genero) && !isset($ciudad)) {
        $sql = "SELECT *, SUM(PUNTOS) AS PUNTOS,(SELECT NOMBRE FROM GENERO WHERE ID_GENERO = USUARIO.ID_GENERO) AS NOMBRE_GENERO, (SELECT NOMBRE FROM CIUDAD WHERE ID_CIUDAD = USUARIO.ID_CIUDAD) AS NOMBRE_CIUDAD, USUARIO.ID_GENERO AS GENERO, USUARIO.ID_CIUDAD AS CIUDAD, ID_VOTADO, NOMBRE FROM VOTAR_COMENTAR INNER JOIN USUARIO ON VOTAR_COMENTAR.ID_VOTADO=USUARIO.ID_USUARIO WHERE USUARIO.TIPO_USUARIO = 'MUSICO' AND FECHA_BAJA is null GROUP BY ID_VOTADO ORDER BY PUNTOS DESC";
    } else {
        $sql = "SELECT *, SUM(PUNTOS) AS PUNTOS,(SELECT NOMBRE FROM GENERO WHERE ID_GENERO = USUARIO.ID_GENERO) AS NOMBRE_GENERO, (SELECT NOMBRE FROM CIUDAD WHERE ID_CIUDAD = USUARIO.ID_CIUDAD) AS NOMBRE_CIUDAD, USUARIO.ID_GENERO AS GENERO, USUARIO.ID_CIUDAD AS CIUDAD, ID_VOTADO, NOMBRE FROM VOTAR_COMENTAR INNER JOIN USUARIO ON VOTAR_COMENTAR.ID_VOTADO=USUARIO.ID_USUARIO WHERE USUARIO.TIPO_USUARIO = 'MUSICO' AND FECHA_BAJA is null GROUP BY ID_VOTADO";
        if ($genero != null) {
            $isFirst = 0;
            $sql .= " HAVING GENERO=$genero";
        }
        if ($ciudad != null) {
            if ($isFirst == 1) {
                $sql .= " HAVING CIUDAD=$ciudad";
            } else {
                $sql .= " AND CIUDAD=$ciudad";
            }
        }
        $sql = $sql . " ORDER BY PUNTOS DESC";
    }
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        return $result;
    } else {
        echo mysqli_error($conexion);
    }
    desconectar($conexion);
}

function RankingLocales($ciudad) {
    $conexion = conectar();
    if (!isset($ciudad)) {
        $sql = "SELECT*, (SUM(PUNTOS)/COUNT(*)) AS PUNTOS, (SELECT NOMBRE FROM CIUDAD WHERE ID_CIUDAD = USUARIO.ID_CIUDAD) AS NOMBRE_CIUDAD, USUARIO.ID_CIUDAD AS CIUDAD, ID_VOTADO, NOMBRE, USUARIO.NOMBRE_LOCAL AS NOMBRE_LOCAL FROM VOTAR_COMENTAR INNER JOIN USUARIO ON VOTAR_COMENTAR.ID_VOTADO=USUARIO.ID_USUARIO WHERE USUARIO.TIPO_USUARIO = 'LOCAL' AND FECHA_BAJA is null GROUP BY ID_VOTADO ORDER BY PUNTOS DESC";
    } else {
        $sql = "SELECT*, (SUM(PUNTOS)/COUNT(*)) AS PUNTOS, (SELECT NOMBRE FROM CIUDAD WHERE ID_CIUDAD = USUARIO.ID_CIUDAD) AS NOMBRE_CIUDAD, USUARIO.ID_CIUDAD AS CIUDAD, ID_VOTADO, NOMBRE, USUARIO.NOMBRE_LOCAL AS NOMBRE_LOCAL FROM VOTAR_COMENTAR INNER JOIN USUARIO ON VOTAR_COMENTAR.ID_VOTADO=USUARIO.ID_USUARIO WHERE USUARIO.TIPO_USUARIO = 'LOCAL' AND FECHA_BAJA is null GROUP BY ID_VOTADO";
        if ($ciudad != null) {
            $sql .= " HAVING CIUDAD=$ciudad";
        }
        $sql = $sql . " ORDER BY PUNTOS DESC";
    }
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        return $result;
    } else {
        echo mysqli_error($conexion);
    }
    desconectar($conexion);
}

/* RANKING POR GENERO */

function ListaGeneros() {
    $conexion = conectar();
    $sql = "SELECT * FROM GENERO ORDER BY NOMBRE ASC";
    $result = $conexion->query($sql);
    if ($result->num_rows) {
        return $result;
    } else {
        return null;
    }
    desconectar($conexion);
}

//function RankingPorGenero($genero) {
//    $conexion = conectar();
//    $sql = "SELECT USUARIO.NOMBRE_ARTISTICO,SUM(PUNTOS) AS PUNTOS, ID_VOTADO FROM VOTAR_COMENTAR INNER JOIN USUARIO ON VOTAR_COMENTAR.ID_VOTADO = USUARIO.ID_USUARIO WHERE ID_GENERO = (SELECT ID_GENERO FROM GENERO WHERE NOMBRE='" . $genero . "') GROUP BY ID_VOTADO";
//    $result = $conexion->query($sql);
//    if ($result->num_rows > 0) {
//
//        while ($row = $result->fetch_assoc()) {
//            echo '<div>' . $row["NOMBRE_ARTISTICO"] . ' ' . $row["PUNTOS"] . '</div>';
//        }
//    }
//}

/* RANKING POR CIUDAD */

function ListaCiudades() {
    $conexion = conectar();
    $sql = "SELECT * FROM CIUDAD ORDER BY NOMBRE ASC";
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

//function RankingPorCiudad($ciudad) {
//    $conexion = conectar();
//    $sql = "SELECT USUARIO.NOMBRE_ARTISTICO,SUM(PUNTOS) AS PUNTOS, ID_VOTADO FROM VOTAR_COMENTAR INNER JOIN USUARIO ON VOTAR_COMENTAR.ID_VOTADO = USUARIO.ID_USUARIO WHERE USUARIO.ID_CIUDAD = (SELECT ID_CIUDAD FROM CIUDAD WHERE NOMBRE='" . $ciudad . "') GROUP BY ID_VOTADO";
//    $result = $conexion->query($sql);
//    if ($result->num_rows > 0) {
//        while ($row = $result->fetch_assoc()) {
//            echo '<div>' . $row["NOMBRE_ARTISTICO"] . ' ' . $row["PUNTOS"] . '</div>';
//        }
//    }
//}

/* CONCIERTOS: */

function ListaConciertosFan($fechaConciertos, $genero, $ciudad, $grupo, $local, $estado, $visible) {
    $conexion = conectar();
    if (empty($genero) && empty($ciudad) && empty($grupo) && empty($local)) {
        $sql = "SELECT *,(SELECT UBICACION FROM USUARIO WHERE ID_USUARIO=CONCIERTO.ID_LOCAL) AS UBICACION, (SELECT NOMBRE FROM GENERO WHERE ID_GENERO = CONCIERTO.ID_GENERO) AS GENERO, (SELECT NOMBRE FROM CIUDAD WHERE ID_CIUDAD = CONCIERTO.ID_CIUDAD) AS CIUDAD, (SELECT NOMBRE_LOCAL FROM USUARIO WHERE ID_USUARIO=ID_LOCAL) AS NOMBRE_LOCAL FROM CONCIERTO INNER JOIN USUARIO ON CONCIERTO.ID_GRUPO = USUARIO.ID_USUARIO WHERE CONCIERTO.FECHA='$fechaConciertos' AND CONCIERTO.VISIBLE = $visible AND CONCIERTO.ESTADO = $estado";
    } else {
        $sql = "SELECT *,(SELECT UBICACION FROM USUARIO WHERE ID_USUARIO=CONCIERTO.ID_LOCAL) AS UBICACION, (SELECT NOMBRE FROM GENERO WHERE ID_GENERO = CONCIERTO.ID_GENERO) AS GENERO, (SELECT NOMBRE FROM CIUDAD WHERE ID_CIUDAD = CONCIERTO.ID_CIUDAD) AS CIUDAD, (SELECT NOMBRE_LOCAL FROM USUARIO WHERE ID_USUARIO=ID_LOCAL) AS NOMBRE_LOCAL FROM CONCIERTO INNER JOIN USUARIO ON CONCIERTO.ID_GRUPO = USUARIO.ID_USUARIO WHERE CONCIERTO.FECHA='$fechaConciertos' AND CONCIERTO.VISIBLE = $visible AND CONCIERTO.ESTADO = $estado";
        if (!empty($genero)) {
            $sql = $sql . ' AND CONCIERTO.ID_GENERO = "' . $genero . '"';
        } else if (!empty($ciudad)) {
            $sql = $sql . " AND CONCIERTO.ID_CIUDAD = '" . $ciudad . "'";
        } else if (!empty($grupo)) {
            $sql = $sql . " AND CONCIERTO.ID_GRUPO = '$grupo' ";
        } else if (!empty($local)) {
            $sql = $sql . " AND CONCIERTO.ID_LOCAL = '$local'";
        }
    }
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        return $result;
    } else {
        echo mysqli_error($conexion);
        return null;
    }
    desconectar($conexion);
}

function ListaConciertosMusico($fechaConciertos, $idgrupo, $estado) {
    $conexion = conectar();
    $sql = "SELECT *, (SELECT NOMBRE_ARTISTICO FROM USUARIO WHERE ID_USUARIO = ID_GRUPO) AS NOMBRE_ARTISTICO, (SELECT NOMBRE_LOCAL FROM USUARIO WHERE ID_USUARIO = ID_LOCAL) AS NOMBRE_LOCAL, (SELECT UBICACION FROM USUARIO WHERE ID_USUARIO = ID_LOCAL) AS UBICACION, (SELECT ID_CIUDAD FROM USUARIO WHERE ID_USUARIO = ID_LOCAL) AS CIUDAD FROM CONCIERTO WHERE ID_GRUPO = $idgrupo AND ESTADO = $estado AND VISIBLE = 1 AND FECHA='$fechaConciertos'";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        return $result;
    } else {
        echo mysqli_error($conexion);
        return null;
    }
    desconectar($conexion);
}

function ResponderPropuesta($idconcierto, $respuesta) {
    $conexion = conectar();
    $sql = "SELECT * FROM PROPONER WHERE ID_CONCIERTO = $idconcierto";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        $sql2 = "UPDATE PROPONER SET ESTADO = '$respuesta' WHERE ID_CONCIERTO = $idconcierto";
        if (mysqli_query($conexion, $sql2)) {
            echo 'respuesta = ' . $respuesta;
        } else {
            return false;
            echo mysqli_error($conexion);
        }
    } else {
        return false;
        echo 'error ListaFEchasConciertos';
        echo mysqli_error($conexion);
    }
    desconectar($conexion);
}

function ListaFechasConciertos($futurosConciertos) {
    $conexion = conectar();
    if ($futurosConciertos == 'true') {
        $sql = "SELECT FECHA FROM CONCIERTO WHERE FECHA>=now() AND ESTADO=1 GROUP BY FECHA";
        $result = $conexion->query($sql);
        if ($result->num_rows > 0) {
            return $result;
        } else {
            echo 'error ListaFEchasConciertos';
            echo mysqli_error($conexion);
        }
    } else {
        $sql = "SELECT FECHA FROM CONCIERTO WHERE FECHA<now() AND ESTADO=1 GROUP BY FECHA";
        $result = $conexion->query($sql);
        if ($result->num_rows > 0) {
            return $result;
        } else {
            echo 'error ListaFEchasConciertos';
            echo mysqli_error($conexion);
        }
    }
    desconectar($conexion);
}

function ListaFechasConciertosLocal($futurosConciertos, $idLocal, $estado) {
    $conexion = conectar();
    if ($futurosConciertos == 'true') {
        $sql = "SELECT FECHA FROM CONCIERTO WHERE FECHA>=now() AND ID_LOCAL = $idLocal AND ESTADO=$estado GROUP BY FECHA";
        $result = $conexion->query($sql);
        if ($result->num_rows > 0) {
            return $result;
        } else {
            return null;
        }
    } else {
        $sql = "SELECT FECHA FROM CONCIERTO WHERE FECHA<now() AND ID_LOCAL=$idlocal AND ESTADO=$estado GROUP BY FECHA";
        $result = $conexion->query($sql);
        if ($result->num_rows > 0) {
            return $result;
        } else {
            return null;
        }
    }
    desconectar($conexion);
}

function ListaFechasConciertosGrupo($futurosConciertos, $idgrupo, $estado) {
    $conexion = conectar();
    if ($futurosConciertos == 'true') {
        $sql = "SELECT FECHA FROM CONCIERTO WHERE FECHA>=now() AND ID_GRUPO = $idgrupo AND ESTADO=$estado GROUP BY FECHA";
        $result = $conexion->query($sql);
        if ($result->num_rows > 0) {
            return $result;
        } else {
            return null;
        }
    } else {
        $sql = "SELECT FECHA FROM CONCIERTO WHERE FECHA<now() AND ID_GRUPO = $idgrupo AND ESTADO=$estado GROUP BY FECHA";
        $result = $conexion->query($sql);
        if ($result->num_rows > 0) {
            return $result;
        } else {
            return null;
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
    $sql = "SELECT *, (SELECT NOMBRE_ARTISTICO FROM USUARIO WHERE ID_USUARIO = ID_GRUPO) AS GRUPO_NOMBRE FROM CONCIERTO RIGHT JOIN USUARIO ON CONCIERTO.ID_LOCAL = USUARIO.ID_USUARIO WHERE CONCIERTO.ID_CIUDAD = (SELECT ID_CIUDAD FROM CIUDAD WHERE NOMBRE='$ciudad') AND CONCIERTO.ESTADO=1";
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
    $sql = "SELECT NOMBRE_ARTISTICO, ID_USUARIO FROM USUARIO WHERE TIPO_USUARIO = 'MUSICO' AND FECHA_BAJA is null";
    $result = $conexion->query($sql);
    if ($result->num_rows) {
        return $result;
    }
    desconectar($conexion);
}

//function ListaConciertosGrupo($grupo) {
//    $conexion = conectar();
//    $sql = "SELECT *, (SELECT NOMBRE_LOCAL FROM USUARIO WHERE ID_USUARIO=ID_LOCAL) AS LOCAL_NOMBRE FROM CONCIERTO RIGHT JOIN USUARIO ON CONCIERTO.ID_GRUPO = USUARIO.ID_USUARIO WHERE USUARIO.ID_USUARIO=$grupo";
//    $result = $conexion->query($sql);
//    if ($result->num_rows > 0) {
//        while ($row = $result->fetch_assoc()) {
//            $nuevaFecha = date("d-m-Y", strtotime($row["FECHA"]));
//            $nuevaHora = date("H:i", strtotime($row["FECHA"]));
//            echo "<div>" . $row["NOMBRE"] . " " . $row["LOCAL_NOMBRE"] . " " . $nuevaFecha . " " . $nuevaHora . "</div>";
//        }
//    }
//    desconectar($conexion);
//}

/* CONCIERTOS POR LOCAL: */

function ListaLocales() {
    $conexion = conectar();
    $sql = "SELECT NOMBRE_LOCAL, ID_USUARIO FROM USUARIO WHERE TIPO_USUARIO = 'LOCAL' AND FECHA_BAJA is null GROUP BY NOMBRE_LOCAL";
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

function redirectURL($url) {
    echo '<script language="javascript">
    window.location.replace("' . $url . '");</script>';
}

function Registro($tipo, $nombre, $apellido, $email, $pswd, $nombrelocal, $ciudad, $ubicacion, $telefono, $aforo, $imagen, $web, $nombreartistico, $genero, $componentes, $pregunta, $respuesta, $descripcion) {
    $con = conectar();
    $resultado = "";
    $descripcion = '<pre>' . $descripcion;
    $email = strtolower($email);
    $alta = date('Y-m-d H:i:s');
    $answer = password_hash($respuesta, PASSWORD_DEFAULT);
    $pass = password_hash($pswd, PASSWORD_DEFAULT);
    $insert = "insert into USUARIO values ('null','$tipo','$nombre',
            " . (($apellido == 'NULL') ? "NULL" : ("'" . $apellido . "'")) . ",
            " . (($ubicacion == 'NULL') ? "NULL" : ("'" . $ubicacion . "'")) . "
            ,'$email',
            " . (($telefono == 'NULL') ? "NULL" : ("'" . $telefono . "'")) . ",
            " . (($imagen == 'NULL') ? "NULL" : ("'" . $imagen . "'")) . ",
            " . (($nombrelocal == 'NULL') ? "NULL" : ("'" . $nombrelocal . "'")) . ", 
            " . (($nombreartistico == 'NULL') ? "NULL" : ("'" . $nombreartistico . "'")) . ",
            " . (($componentes == 'NULL') ? "NULL" : ("'" . $componentes . "'")) . "
            ,'$pass',
            " . (($aforo == 'NULL') ? "NULL" : ("'" . $aforo . "'")) . ", 
            " . (($web == 'NULL') ? "NULL" : ("'" . $web . "'")) . ", 
            " . (($genero == 'NULL') ? "NULL" : ("'" . $genero . "'")) . ",
            " . (($ciudad == 'NULL') ? "NULL" : ("'" . $ciudad . "'")) . ",'$pregunta','$answer',
            " . (($descripcion == 'NULL') ? "NULL" : ("' . $descripcion . '")) . ",Now(),NULL)";
    if (mysqli_query($con, $insert)) {
        $resultado = "true";
    } else {
        $resultado = mysqli_error($con);
        echo $resultado;
        echo $descripcion;
    }
    return $resultado;
    desconectar($con);
}

function checkPassword($pas1, $pas2) {
    if ($pas1 == $pas2)
        return true;
    else
        return false;
}

function existNombreArtistico($nombre) {
    $con = conectar();
    $sql = "select * from USUARIO where NOMBRE_ARTISTICO = '$nombre'";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        return false;
    } else {
        return true;
    }
    desconectar($con);
}

function existNombreLocal($nombre) {
    $con = conectar();
    $sql = "select * from USUARIO where NOMBRE_LOCAL = '$nombre'";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        return false;
    } else {
        return true;
    }
    desconectar($con);
}

function existTelefono($telefono) {
    $con = conectar();
    $sql = "select * from USUARIO where NUMERO_CONTACTO = '$telefono'";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        return false;
    } else {
        return true;
    }
    desconectar($con);
}

function existUser($user) {
    $con = conectar();
    $sql = "select * from USUARIO where NOMBRE = '$user'";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        return false;
    } else {
        return true;
    }
    desconectar($con);
}

function existMail($mail) {
    $con = conectar();
    $sql = "select * from USUARIO where EMAIL = '$mail' AND FECHA_BAJA is null";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        return false;
    } else {
        return true;
    }
    desconectar($con);
}

function login($email, $password) {
    $con = conectar();
    $email = strtolower($email);
    $sql = "select * from USUARIO where EMAIL='$email'";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if (password_verify($password, $row['PASSWORD'])) {
                if ((isset($row['FECHA_ALTA'])) && $row['FECHA_BAJA'] == null) {
                    return $row['TIPO_USUARIO'];
                }
            } else {
                showAlert("Contraseña incorrecta");
                return false;
            }
        }
    } else {
        showAlert("El usuario no esta registrado");
        return false;
    }
    desconectar($con);
}

function mostrarSeguridad($email) {
    $con = conectar();
    $sql = "select * from USUARIO where EMAIL='$email'";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            return $row['PREGUNTA_SEGURIDAD'];
        }
    } else {
        return "false";
    }
    desconectar($con);
}

function comprobarSeguridad($email, $respuesta) {
    $con = conectar();
    $sql = "select * from USUARIO where EMAIL='$email'";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if (password_verify($respuesta, $row['RESPUESTA_SEGURIDAD'])) {
                $newpassword = randomString(6);
                $pass = password_hash($newpassword, PASSWORD_DEFAULT);
                $q1 = "update USUARIO set PASSWORD='$pass' where EMAIL ='$email'";
                if (mysqli_query($con, $q1)) {
                    return $newpassword;
                } else {
                    return "false";
                }
            } else {
                return "false";
            }
        }
    } else {
        return "false";
    }
    desconectar($con);
}

function randomString($length) {
    return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
}

function TraceEvent($tipo, $valor, $resultado, $comentario, $id_concierto) {
    $conexion = conectar();
    $sql = "INSERT INTO TRACE VALUES(null, '$tipo', '$valor', now(),
            " . (($resultado == 'NULL') ? "NULL" : ("'" . $resultado . "'")) . ",
            " . (($comentario == 'NULL') ? "NULL" : ("'" . $comentario . "'")) . ",
            " . (($id_concierto == 'NULL') ? "NULL" : ("'" . $id_concierto . "'")) . ")";
    if (mysqli_query($conexion, $sql)) {
        
    } else {
        echo mysqli_error($conexion);
    }
    desconectar($conexion);
}

function TrendingBusqueda($tipo) {
    $conexion = conectar();
    if ($tipo == "grupo") {
        $sql = "SELECT COUNT(VALOR) AS 'VECES', VALOR AS NOMBRE FROM TRACE WHERE COMENTARIO = 'MUSICO' GROUP BY VALOR ORDER BY VECES DESC LIMIT 3";
    } else if ($tipo == "local") {
        $sql = "SELECT COUNT(VALOR) AS 'VECES', VALOR AS NOMBRE FROM TRACE WHERE COMENTARIO='LOCAL' GROUP BY VALOR ORDER BY VECES DESC LIMIT 3";
    } else if ($tipo == "concierto") {
        
    }
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        return $result;
    } else {
        return null;
    }
}

//FUNCION QUE NO INTERACTUA DIRECTAMENTE CON LA BBDD, CREAMOS UN PHP NUEVO O LAS DEJAMOS AQUI?
function TrendingResultados() {
//TRENDING GRUPOS
    $resultGrupo = TrendingBusqueda("grupo");
    if ($resultGrupo == null) {
        echo'<script language="javascript">$("#trendingSearchGrupos").empty();</script>';
    } else {
        $trending_list_grupos = "<ul class='inline'>";
        while ($row = $resultGrupo->fetch_assoc()) {
            $nombre = str_replace(" ", "+", $row['NOMBRE']);
            $trending_list_grupos .= "<li class='inline paddingleft15red cursiva'><a class='fontblack' href=InfoGrupo.php?nombre=" . $nombre . ">" . $row['NOMBRE'] . "</a></li>";
        }
        $trending_list_grupos .= "</ul>";
        echo'<script language="javascript">$("#trendingSearchGrupos").append("' . $trending_list_grupos . '");</script>';
    }
    $resultLocal = TrendingBusqueda("local");
    if ($resultLocal == null) {
        echo'<script language="javascript">$("#trendingSearchLocales").empty();</script>';
    } else {
        $trending_list_locales = "<ul class='inline'>";
        while ($row = $resultLocal->fetch_assoc()) {
            $nombre = str_replace(" ", "+", $row['NOMBRE']);
            $trending_list_locales .= "<li class='inline paddingleft15red cursiva'><a class='fontblack' href=InfoLocal.php?nombre=" . $nombre . ">" . $row['NOMBRE'] . "</a></li>";
        }
        $trending_list_locales .= "</ul>";
        echo'<script language="javascript">$("#trendingSearchLocales").append("' . $trending_list_locales . '");</script>';
    }
}

function getNombreFecha($fecha) {
    $dias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado");
    $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

    $arrayFecha = explode("-", $fecha);

    $fecha = $dias[$arrayFecha[0]] . " " . $arrayFecha[1] . " de " . $meses[$arrayFecha[2] - 1] . " del " . $arrayFecha[3];
    return $fecha;
}

function ArtistasAlza($genero, $ciudad, $titulo) {
    $result = RankingMusicos($genero, $ciudad);
    $i = 1;
    echo $titulo . '<br>';
    echo '<div id="div_parent_ranking">';
    while ($row = $result->fetch_assoc()) {
        $imagen = getImageID($row['ID_USUARIO']);
        $nombre_artistico = str_replace(" ", "+", $row['NOMBRE']);
        echo '<div id="musicoRanking' . $i . '" style="margin-bottom:20px">';
        echo '<div class="div_peque_ranking"></div>';
        echo '<div class="div_ranking">';
        echo '<img class="img_div_ranking inline" src="' . $imagen . '">';
        echo '<div class="nombre_artista inline vertical_top" style="padding-top:10px;padding-left:10px;text-align:left"><a href="InfoGrupo.php?nombre=' . $nombre_artistico . '"><b class="fontblack a_concierto" style="font-size:25px">' . $row['NOMBRE'] . '</b><br><i class="color_rojo_general"> ' . $row['NOMBRE_GENERO'] . ' - ' . $row['NOMBRE_CIUDAD'] . '</i></a></div>';
        echo '</div>';
        echo '<img class="img_ranking_numero" src="Imagenes/ranking' . $i . '.png">';
        echo '<div style="vertical-align:bottom;padding-right:10px">';
        $average = votosLocal($row['ID_USUARIO']);
        mostrarEstrellasPuntuacionLocal($average, $i);
        echo '</div>';
        echo '</div>';
        echo '<br>';
        $i++;
        if ($i == 6) {
            break;
        }
    }
    echo '</div>';
}

function LocalesAlza($ciudad, $titulo) {
    $result = RankingLocales($ciudad);
    $i = 1;
    echo'<i>' . $titulo . '</i><br>';
    echo '<div id="div_parent_ranking">';
    while ($row = $result->fetch_assoc()) {
        $imagen = getImageID($row['ID_USUARIO']);
        $nombre_local = str_replace(" ", "+", $row['NOMBRE_LOCAL']);
        echo '<div id="musicoRanking' . $i . '" style="margin-bottom:20px">';
        echo '<div class="div_peque_ranking"></div>';
        echo '<div class="div_ranking">';
        echo '<img class="img_div_ranking inline" src="' . $imagen . '">';
        echo '<div class="nombre_artista inline vertical_top" style="padding-top:10px;padding-left:10px"><a href="InfoLocal.php?nombre=' . $nombre_local . '"><b class="fontblack a_concierto" style="font-size:25px">' . $row['NOMBRE'] . '</b><br><i style="float:left" class="color_rojo_general"> ' . $row['NOMBRE_CIUDAD'] . '</i></a></div>';
        echo '</div>';
        echo '<img class="img_ranking_numero" src="Imagenes/ranking' . $i . '.png">';
        echo '<div style="padding-right:10px">';
        $average = votosLocal($row['ID_USUARIO']);
        mostrarEstrellasPuntuacionLocal($average, $i);
        echo '</div>';
        echo '</div>';
        echo '<br>';
        $i++;
        if ($i == 6) {
            break;
        }
    }
    echo '</div>';
}

function NoticiasNuevoMusico() {
    $conexion = conectar();
    $sql = "SELECT * FROM TRACE INNER JOIN USUARIO ON TRACE.VALOR = USUARIO.NOMBRE_ARTISTICO WHERE TIPO = 'REGISTRO' AND COMENTARIO = 'NUEVO MUSICO' ORDER BY FECHA DESC LIMIT 1";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row;
    } else {
        return null;
    }
    desconectar();
}

function NoticiasNuevoLocal() {
    $conexion = conectar();
    $sql = "SELECT * FROM TRACE INNER JOIN USUARIO ON TRACE.VALOR = USUARIO.NOMBRE_LOCAL WHERE TIPO = 'REGISTRO' AND COMENTARIO = 'NUEVO LOCAL' ORDER BY FECHA DESC LIMIT 1";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row;
    } else {
        return null;
    }
    desconectar();
}

function NoticiasNuevoConcierto() {
    $conexion = conectar();
    $sql = "SELECT *,(SELECT UBICACION FROM USUARIO WHERE TIPO_USUARIO = 'LOCAL' AND FECHA_BAJA is null AND CONCIERTO.ID_LOCAL = USUARIO.ID_USUARIO) AS UBICACION, CONCIERTO.FECHA AS CONCIERTO_FECHA FROM TRACE INNER JOIN CONCIERTO ON TRACE.ID_CONCIERTO = CONCIERTO.ID_CONCIERTO WHERE TIPO = 'CONCIERTO' AND COMENTARIO = 'NUEVO CONCIERTO' ORDER BY TRACE.FECHA DESC LIMIT 1";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row;
    } else {
        return null;
    }
    desconectar();
}

function ShowNoticiasMusico() {
    $nuevoGrupo = NoticiasNuevoMusico();
    $url = "url('Imagenes/img_forest.jpg')";
    $nombre_grupo = str_replace(" ", "+", $nuevoGrupo['VALOR']);
    $nombre_ciudad = getNombreCiudad($nuevoGrupo['ID_CIUDAD']);
    $nombre_genero = getNombreGenero($nuevoGrupo['ID_GENERO']);
    echo '<a class="a_noticia" href="InfoGrupo.php?nombre=' . $nombre_grupo . '">';
    echo '<div style = "height:250px;background-image:' . $url . ';background-size:cover;background-position:center">';
    echo '<div style="position: relative;top: 0;background-color:rgba(0, 0, 0, 0.8)">';
    echo '<b style="color:white;font-size:30px">Un nuevo <b class="color_rojo_general">grupo</b> se acaba de unir</b>';
    echo '</div>';
    echo '<div style="position: relative;bottom: 0;background-color:rgba(0, 0, 0, 0.8)">';
    echo '<h1>' . $nuevoGrupo['VALOR'] . '</h1>';
    echo '<i style="color:white">' . $nombre_ciudad . ', ' . $nombre_genero . '</i>';
    echo '</div>';
    echo '</div></a>';
}

function ShowNoticiasLocal() {
    $nuevoLocal = NoticiasNuevoLocal();
    if (isset($nuevoLocal)) {
        $nombre_local = str_replace(" ", "+", $nuevoLocal['VALOR']);
        $url = "url('Imagenes/img_lights.jpg')";
        $nombre_ciudad = getNombreCiudad($nuevoLocal['ID_CIUDAD']);
        echo '<a class="a_noticia" href="InfoLocal.php?nombre=' . $nombre_local . '">';
        echo '<div style = "height:250px;background-image:' . $url . ';background-size:cover;background-position:center">';
        echo '<div style="position: relative;top: 0;background-color:rgba(0, 0, 0, 0.8)">';
        echo '<b style="color:white;font-size:30px">Un nuevo <b class="color_rojo_general">local</b> se acaba de unir</b>';
        echo '</div>';
        echo '<div style="position: relative;bottom: 0;background-color:rgba(0, 0, 0, 0.8)">';
        echo '<h1>' . $nuevoLocal['VALOR'] . '</h1>';
        echo '<i style="color:white">' . $nuevoLocal['UBICACION'] . ', ' . $nombre_ciudad . '</i>';
        echo '</div>';
        echo '</div></a>';
    } else {
        echo 'No hay nuevo local';
    }
}

function ShowNoticiasConcierto() {
    $nuevoConcierto = NoticiasNuevoConcierto();
    $nombres = split("-", $nuevoConcierto['VALOR']);
    $url = "url('Imagenes/img_mountains.jpg')";
    $nuevaFecha = date("w-d-m-Y", strtotime($nuevoConcierto["CONCIERTO_FECHA"]));
    $nuevaHora = date("H:i", strtotime($nuevoConcierto["CONCIERTO_FECHA"]));
    $fechaFinal = getNombreFecha($nuevaFecha);
    $nombre_ciudad = getNombreCiudad($nuevoConcierto['ID_CIUDAD']);

    echo '<a class="a_noticia" href="InfoConcierto.php?idcon=' . $nuevoConcierto['ID_CONCIERTO'] . '">';
    echo '<div style = "height:250px;background-image:' . $url . ';background-size:cover;background-position:center">';
    echo '<div style="position: relative;top: 0;background-color:rgba(0, 0, 0, 0.8)">';
    echo '<b style="color:white;font-size:30px">Nuevo <b class="color_rojo_general">concierto</b></b>';
    echo '</div>';
    echo '<div style="position: relative;top: 50%;transform: translateY(-50%);background-color:rgba(0, 0, 0, 0.8)">';
    echo '<b style="font-size:40px">' . $nombres[0] . '</b>';
    echo '<p style="color:white;font-size:20px;display:inline">' . $fechaFinal . '</p>';
    echo '<b style="font-size:40px">' . $nombres[1] . '</b><br>';
    echo '<i style="color:white;font-size:20px">' . $nuevoConcierto['UBICACION'] . ', ' . $nombre_ciudad . '</i>';
    echo '</div>';
    echo '</div></a>';
}

function getNombreCiudad($id_ciudad) {
    $conexion = conectar();
    $sql = "SELECT NOMBRE FROM CIUDAD WHERE ID_CIUDAD= $id_ciudad";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['NOMBRE'];
    } else {
        return null;
    }
    desconectar();
}

function getNombreGenero($id_genero) {
    $conexion = conectar();
    $sql = "SELECT NOMBRE FROM GENERO WHERE ID_GENERO = $id_genero";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['NOMBRE'];
    } else {
        return null;
    }
    desconectar();
}

function fileUpload($email) {
    if ($_FILES['fileToUpload']["name"] != null) {
        $target_dir = 'Imagenes/';
        $extension = explode(".", $_FILES["fileToUpload"]["name"]);
        $newFileName = randomString(6) . '.' . end($extension);
        $target_file = $target_dir . $newFileName;
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
            $resultado = 0;
        }
        if (file_exists($target_file)) {
            $uploadOk = 0;
            $resultado = 1;
        }
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            $uploadOk = 0;
            $resultado = 2;
        }
        $imageFileType = strtolower($imageFileType);
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "") {
            $uploadOk = 0;
            $resultado = 3;
        }
        if ($uploadOk == 0) {
// if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $resultado = 6;
            } else {
                $resultado = 5;
            }
        }
        switch ($resultado) {
            case 0:
                return "No se ha subido ninguna imagen";
                break;
            case 1:
                return "El archivo ya existe";
                break;
            case 2:
                return "El archivo es demasiado grande";
                break;
            case 3:
                return "Solo JPG, JPEG y PNG estan soportados";
                break;
            case 4:
                return "Tu archivo no se ha subido";
                break;
            case 5:
                return "Se ha producido un error subiendo el archivo";
                break;
            case 6:
                $conexion = conectar();
                $sql = "update USUARIO SET IMAGEN = '$target_file' where EMAIL = '$email'";
                if (mysqli_query($conexion, $sql)) {
                    
                } else {
                    echo mysqli_error($conexion);
                }
                desconectar($conexion);
                return 1;
                break;
        }
    } else {
        return "No has subido imagen";
    }
}

function getInfoUser($email) {
    $conexion = conectar();
    $sql = "SELECT * FROM USUARIO WHERE EMAIL = '$email'";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row;
    } else {
        echo mysqli_error($conexion);
        return null;
    }
    desconectar();
}

function ModificarPassword($userEmail, $newpassword) {
    $conexion = conectar();
    $newPasscif = password_hash($newpassword, PASSWORD_DEFAULT);
    $query = "UPDATE USUARIO SET PASSWORD='$newPasscif' WHERE EMAIL='$userEmail'";
    if (mysqli_query($conexion, $query)) {
        return true;
    } else {
        echo mysqli_error($conexion);
        return false;
    }
    desconectar($conexion);
}

function verificarUser($userEmail, $pass) {
    $conexion = conectar();
    $query = "SELECT PASSWORD FROM USUARIO WHERE EMAIL='$userEmail'";
    $result = $conexion->query($query);
    if ($result->num_rows > 0) {
// Comprobamos que la contraseña es correcta
        $row = $result->fetch_assoc();
        return password_verify($pass, $row['PASSWORD']);
    } else {    // Este else no hace falta
        echo mysqli_error($conexion);

        return false;
    }
    desconectar($conexion);
}

function modificarDatosFan($usuario, $nuevoNombre, $nuevoApellido, $nuevaUbicacion, $nuevadescripcion, $nuevoNumeroContacto) {
    $conexion = conectar();
    if (!existTelefono($nuevoNumeroContacto)) {
        showAlert("El telefono ya existe");
        return false;
    }
    $nuevadescripcion = '<pre>' . $nuevadescripcion;
    $query = "SELECT * FROM USUARIO WHERE EMAIL = '$usuario'";
    $result = $conexion->query($query);
    if ($result->num_rows > 0) {
        $queryUpdate = "UPDATE USUARIO SET NUMERO_CONTACTO = $nuevoNumeroContacto ,NOMBRE='$nuevoNombre', APELLIDOS='$nuevoApellido', UBICACION='$nuevaUbicacion', DESCRIPCION='$nuevadescripcion' WHERE EMAIL ='$usuario'";
        if (mysqli_query($conexion, $queryUpdate)) {
            return true;
        } else {
            echo mysqli_error($conexion);
            return false;
        }
    } else {
        echo mysqli_error($conexion);
        return false;
    }
    desconectar($conexion);
}

function modificarDatosLocal($usuario, $nuevaUbicacion, $nuevoNumeroContacto, $nuevoNombreLocal, $nuevoAforo, $nuevaWeb, $nuevadescripcion) {
    $conexion = conectar();
    if (!existTelefono($nuevoNumeroContacto)) {
        showAlert("El telefono ya existe");
        return false;
    }
    $nuevadescripcion = '<pre>' . $nuevadescripcion;
    $query = "SELECT * FROM USUARIO WHERE EMAIL = '$usuario'";
    $result = $conexion->query($query);
    if ($result->num_rows > 0) {
        $queryUpdate = "UPDATE USUARIO SET UBICACION='$nuevaUbicacion', DESCRIPCION ='$nuevadescripcion',NUMERO_CONTACTO = $nuevoNumeroContacto, NOMBRE_LOCAL = '$nuevoNombreLocal', AFORO = $nuevoAforo, WEB='$nuevaWeb' WHERE EMAIL ='$usuario'";
        if (mysqli_query($conexion, $queryUpdate)) {
            return true;
        } else {
            echo mysqli_error($conexion);
            return false;
        }
    } else {
        echo mysqli_error($conexion);
        return false;
    }
    desconectar($conexion);
}

function modificarDatosMusico($usuario, $nuevaUbicacion, $nuevoNumeroContacto, $nuevoNombreArtistico, $nuevoNumeroComponentes, $nuevadescripcion, $nuevaWeb) {
    $conexion = conectar();
    if (!existTelefono($nuevoNumeroContacto)) {
        showAlert("El telefono ya existe");
        return false;
    }
    $nuevadescripcion = '<pre>' . $nuevadescripcion;
    $query = "SELECT * FROM USUARIO WHERE EMAIL = '$usuario'";
    $result = $conexion->query($query);
    if ($result->num_rows > 0) {
        $queryUpdate = "UPDATE USUARIO SET UBICACION='$nuevaUbicacion', NUMERO_CONTACTO = $nuevoNumeroContacto, NOMBRE_ARTISTICO = '$nuevoNombreArtistico', NUMERO_COMPONENTES = $nuevoNumeroComponentes, DESCRIPCION = '$nuevadescripcion', WEB='$nuevaWeb' WHERE EMAIL ='$usuario'";
        if (mysqli_query($conexion, $queryUpdate)) {
            return true;
        } else {
            echo mysqli_error($conexion);
            return false;
        }
    } else {
        echo mysqli_error($conexion);
        return false;
    }
    desconectar($conexion);
}

function showImage($user) {
    $conexion = conectar();
    $sql = "SELECT * FROM USUARIO WHERE EMAIL = '$user'";
    $resultado = $conexion->query($sql);
    $row = mysqli_fetch_array($resultado);
    $imagen = '<img src="data:image/jpeg;base64,' . $row['IMAGEN'] . '"/>';
    return $imagen;
    desconectar($conexion);
}

function infoConcierto($id) {
    $conexion = conectar();
    $sql = "SELECT * FROM CONCIERTO inner join USUARIO on USUARIO.ID_USUARIO = CONCIERTO.ID_GRUPO  WHERE ID_CONCIERTO = '$id'";
    $resultado = $conexion->query($sql);
    $row = mysqli_fetch_array($resultado);
    return $row;
    desconectar($conexion);
}

function comentariosConcierto($id) {
    $conexion = conectar();
    $sql = "SELECT * FROM VOTAR_COMENTAR inner join USUARIO on VOTAR_COMENTAR.ID_FAN = USUARIO.ID_USUARIO WHERE ID_VOTADO = '$id' AND VOTO_CONCIERTO = 1;";
    $resultado = $conexion->query($sql);
    if ($resultado->num_rows > 0) {
        return $resultado;
    } else {
        return false;
    }
    desconectar($conexion);
}

function votosConcierto($id) {
    $conexion = conectar();
    $sql = "SELECT SUM(PUNTOS) as suma,count(*) as count, TRUNCATE(AVG(PUNTOS),1) AS AVERAGE FROM VOTAR_COMENTAR WHERE ID_VOTADO = '$id' AND VOTO_CONCIERTO = 1";
    $resultado = $conexion->query($sql);
    $row = mysqli_fetch_array($resultado);
    return $row['AVERAGE'];
    desconectar($conexion);
}

function votosLocal($id) {
    $conexion = conectar();
    $sql = "SELECT SUM(PUNTOS) AS SUMA, COUNT(*) AS COUNT, TRUNCATE(AVG(PUNTOS),1) AS AVERAGE FROM VOTAR_COMENTAR WHERE ID_VOTADO=$id AND VOTO_CONCIERTO = 0";
    $resultado = $conexion->query($sql);
    $row = $resultado->fetch_assoc();
    return $row['AVERAGE'];
    desconectar($conexion);
}

function getNombreLocal($id) {
    $conexion = conectar();
    $sql = "SELECT * FROM USUARIO WHERE ID_USUARIO ='$id'";
    $resultado = $conexion->query($sql);
    $row = mysqli_fetch_array($resultado);
    return $row;
    desconectar($conexion);
}

function getNombreGrupo($id) {
    $conexion = conectar();
    $sql = "SELECT * FROM USUARIO WHERE ID_USUARIO ='$id'";
    $resultado = $conexion->query($sql);
    $row = mysqli_fetch_array($resultado);
    return $row;
    desconectar($conexion);
}

function getInfoGrupoName($name) {
    $conexion = conectar();
    $sql = "SELECT * FROM USUARIO WHERE NOMBRE_ARTISTICO = '$name'";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row;
    } else {
        return null;
    }
    desconectar();
}

function votosGrupo($id) {
    $conexion = conectar();
    $sql = "SELECT SUM(PUNTOS) as suma,count(*) as count, TRUNCATE(AVG(PUNTOS),1) AS AVERAGE FROM VOTAR_COMENTAR WHERE ID_VOTADO = '$id' AND VOTO_CONCIERTO = 0";
    $resultado = $conexion->query($sql);
    $row = $resultado->fetch_assoc();
    return $row['AVERAGE'];
    desconectar($conexion);
}

function roundToHalf($num) {
    if ($num >= ($half = ($ceil = ceil($num)) - 0.5) + 0.25)
        return $ceil;
    else if ($num < $half - 0.25)
        return floor($num);
    else
        return $half;
}

function mostrarEstrellasPuntuacionLocal($average, $i) {
    $puntos = roundToHalf($average);
    if ($puntos == '5') {
        echo '<form style="padding-left:0" class="inline rating_fixed">
                        <input type="radio" id="star5' . $i . '" checked name="rating' . $i . '" value="5" /><label class = "full" for="star5" title="Fantástico - 5 stars"></label>
                        <input type="radio" id="star4half' . $i . '" name="rating' . $i . '" value="4 and a half" /><label class="half" for="star4half" title="Bastante bien - 4.5 stars"></label>
                        <input type="radio" id="star4' . $i . '" name="rating' . $i . '" value="4" /><label class = "full" for="star4" title="Bastante bien - 4 stars"></label>
                        <input type="radio" id="star3half' . $i . '" name="rating' . $i . '" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                        <input type="radio" id="star3' . $i . '" name="rating' . $i . '" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                        <input type="radio" id="star2half' . $i . '" name="rating' . $i . '" value="2 and a half" /><label class="half" for="star2half" title="No muy bueno - 2.5 stars"></label>
                        <input type="radio" id="star2' . $i . '" name="rating' . $i . '" value="2" /><label class = "full" for="star2" title=" - 2 stars"></label>
                        <input type="radio" id="star1half' . $i . '" name="rating' . $i . '" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                        <input type="radio" id="star1' . $i . '" name="rating' . $i . '" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                        <input type="radio" id="star' . $i . '" name="rating' . $i . '" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
    </form> ';
    } elseif ($puntos == '4.5') {
        echo '<form style="padding-left:0" class="inline rating_fixed">
                        <input type="radio" id="star5' . $i . '" name="rating' . $i . '" value="5" /><label class = "full" for="star5" title="Fantástico - 5 stars"></label>
                        <input type="radio" id="star4half' . $i . '" checked name="rating' . $i . '" value="4 and a half" /><label class="half" for="star4half" title="Bastante bien - 4.5 stars"></label>
                        <input type="radio" id="star4' . $i . '" name="rating' . $i . '" value="4" /><label class = "full" for="star4" title="Bastante bien - 4 stars"></label>
                        <input type="radio" id="star3half' . $i . '" name="rating' . $i . '" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                        <input type="radio" id="star3' . $i . '" name="rating' . $i . '" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                        <input type="radio" id="star2half' . $i . '" name="rating' . $i . '" value="2 and a half" /><label class="half" for="star2half" title="No muy bueno - 2.5 stars"></label>
                        <input type="radio" id="star2' . $i . '" name="rating' . $i . '" value="2" /><label class = "full" for="star2" title=" - 2 stars"></label>
                        <input type="radio" id="star1half' . $i . '" name="rating' . $i . '" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                        <input type="radio" id="star1' . $i . '" name="rating' . $i . '" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                        <input type="radio" id="star' . $i . '" name="rating' . $i . '" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
    </form> ';
    } elseif ($puntos == '4') {
        echo '<form style="padding-left:0" class="inline rating_fixed">
                        <input type="radio" id="star5' . $i . '" name="rating' . $i . '" value="5" /><label class = "full" for="star5" title="Fantástico - 5 stars"></label>
                        <input type="radio" id="star4half' . $i . '" name="rating' . $i . '" value="4 and a half" /><label class="half" for="star4half" title="Bastante bien - 4.5 stars"></label>
                        <input type="radio" id="star4' . $i . '" checked name="rating' . $i . '" value="4" /><label class = "full" for="star4" title="Bastante bien - 4 stars"></label>
                        <input type="radio" id="star3half' . $i . '" name="rating' . $i . '" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                        <input type="radio" id="star3' . $i . '" name="rating' . $i . '" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                        <input type="radio" id="star2half' . $i . '" name="rating' . $i . '" value="2 and a half" /><label class="half" for="star2half" title="No muy bueno - 2.5 stars"></label>
                        <input type="radio" id="star2' . $i . '" name="rating' . $i . '" value="2" /><label class = "full" for="star2" title=" - 2 stars"></label>
                        <input type="radio" id="star1half' . $i . '" name="rating' . $i . '" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                        <input type="radio" id="star1' . $i . '" name="rating' . $i . '" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                        <input type="radio" id="star' . $i . '" name="rating' . $i . '" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
    </form> ';
    } elseif ($puntos == '3.5') {
        echo '<form style="padding-left:0" class="inline rating_fixed">
                        <input type="radio" id="star5' . $i . '" name="rating' . $i . '" value="5" /><label class = "full" for="star5" title="Fantástico - 5 stars"></label>
                        <input type="radio" id="star4half' . $i . '" name="rating' . $i . '" value="4 and a half" /><label class="half" for="star4half" title="Bastante bien - 4.5 stars"></label>
                        <input type="radio" id="star4' . $i . '" name="rating' . $i . '" value="4" /><label class = "full" for="star4" title="Bastante bien - 4 stars"></label>
                        <input type="radio" id="star3half' . $i . '" checked name="rating' . $i . '" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                        <input type="radio" id="star3' . $i . '" name="rating' . $i . '" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                        <input type="radio" id="star2half' . $i . '" name="rating' . $i . '" value="2 and a half" /><label class="half" for="star2half" title="No muy bueno - 2.5 stars"></label>
                        <input type="radio" id="star2' . $i . '" name="rating' . $i . '" value="2" /><label class = "full" for="star2" title=" - 2 stars"></label>
                        <input type="radio" id="star1half' . $i . '" name="rating' . $i . '" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                        <input type="radio" id="star1' . $i . '" name="rating' . $i . '" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                        <input type="radio" id="star' . $i . '" name="rating' . $i . '" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
    </form> ';
    } elseif ($puntos == '3') {
        echo '<form style="padding-left:0" class="inline rating_fixed">
                        <input type="radio" id="star5' . $i . '" name="rating' . $i . '" value="5" /><label class = "full" for="star5" title="Fantástico - 5 stars"></label>
                        <input type="radio" id="star4half' . $i . '" name="rating' . $i . '" value="4 and a half" /><label class="half" for="star4half" title="Bastante bien - 4.5 stars"></label>
                        <input type="radio" id="star4' . $i . '" name="rating' . $i . '" value="4" /><label class = "full" for="star4" title="Bastante bien - 4 stars"></label>
                        <input type="radio" id="star3half' . $i . '" name="rating' . $i . '" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                        <input type="radio" id="star3' . $i . '" checked name="rating' . $i . '" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                        <input type="radio" id="star2half' . $i . '"  name="rating' . $i . '" value="2 and a half" /><label class="half" for="star2half" title="No muy bueno - 2.5 stars"></label>
                        <input type="radio" id="star2' . $i . '" name="rating' . $i . '" value="2" /><label class = "full" for="star2" title=" - 2 stars"></label>
                        <input type="radio" id="star1half' . $i . '" name="rating' . $i . '" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                        <input type="radio" id="star1' . $i . '" name="rating' . $i . '" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                        <input type="radio" id="star' . $i . '" name="rating' . $i . '" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
    </form> ';
    } elseif ($puntos == '2.5') {
        echo '<form id="' . $i . '" style="padding-left:0" class="inline rating_fixed">
                        <input type="radio" id="star5' . $i . '" name="rating2' . $i . '" value="5" /><label class = "full" for="star5" title="Fantástico - 5 stars"></label>
                        <input type="radio" id="star4half' . $i . '" name="rating2' . $i . '" value="4 and a half" /><label class="half" for="star4half" title="Bastante bien - 4.5 stars"></label>
                        <input type="radio" id="star4' . $i . '" name="rating2' . $i . '" value="4" /><label class = "full" for="star4" title="Bastante bien - 4 stars"></label>
                        <input type="radio" id="star3half' . $i . '" name="rating2' . $i . '" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                        <input type="radio" id="star3' . $i . '" name="rating2' . $i . '" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                        <input type="radio" id="star2half' . $i . '" checked name="rating2' . $i . '" value="2 and a half" /><label class="half" for="star2half" title="No muy bueno - 2.5 stars"></label>
                        <input type="radio" id="star2' . $i . '" name="rating2' . $i . '" value="2" /><label class = "full" for="star2" title=" - 2 stars"></label>
                        <input type="radio" id="star1half' . $i . '" name="rating2' . $i . '" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                        <input type="radio" id="star1' . $i . '" name="rating2' . $i . '" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                        <input type="radio" id="star' . $i . '" name="rating2' . $i . '" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
    </form> ';
    } elseif ($puntos == '2') {
        echo '<form style="padding-left:0" class="inline rating_fixed">
                        <input type="radio" id="star5' . $i . '" name="rating' . $i . '" value="5" /><label class = "full" for="star5" title="Fantástico - 5 stars"></label>
                        <input type="radio" id="star4half' . $i . '" name="rating' . $i . '" value="4 and a half" /><label class="half" for="star4half" title="Bastante bien - 4.5 stars"></label>
                        <input type="radio" id="star4' . $i . '" name="rating' . $i . '" value="4" /><label class = "full" for="star4" title="Bastante bien - 4 stars"></label>
                        <input type="radio" id="star3half' . $i . '" name="rating' . $i . '" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                        <input type="radio" id="star3' . $i . '" name="rating' . $i . '" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                        <input type="radio" id="star2half' . $i . '" name="rating' . $i . '" value="2 and a half" /><label class="half" for="star2half" title="No muy bueno - 2.5 stars"></label>
                        <input type="radio" id="star2' . $i . '" checked name="rating' . $i . '" value="2" /><label class = "full" for="star2" title=" - 2 stars"></label>
                        <input type="radio" id="star1half' . $i . '" name="rating' . $i . '" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                        <input type="radio" id="star1' . $i . '" name="rating' . $i . '" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                        <input type="radio" id="star' . $i . '" name="rating' . $i . '" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
    </form> ';
    } elseif ($puntos == '1.5') {
        echo '<form style="padding-left:0" class="inline rating_fixed">
                        <input type="radio" id="star5' . $i . '" name="rating' . $i . '" value="5" /><label class = "full" for="star5" title="Fantástico - 5 stars"></label>
                        <input type="radio" id="star4half' . $i . '" name="rating' . $i . '" value="4 and a half" /><label class="half" for="star4half" title="Bastante bien - 4.5 stars"></label>
                        <input type="radio" id="star4' . $i . '" name="rating' . $i . '" value="4" /><label class = "full" for="star4" title="Bastante bien - 4 stars"></label>
                        <input type="radio" id="star3half' . $i . '" name="rating' . $i . '" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                        <input type="radio" id="star3' . $i . '" name="rating' . $i . '" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                        <input type="radio" id="star2half' . $i . '"  name="rating' . $i . '" value="2 and a half" /><label class="half" for="star2half" title="No muy bueno - 2.5 stars"></label>
                        <input type="radio" id="star2' . $i . '" name="rating' . $i . '" value="2" /><label class = "full" for="star2" title=" - 2 stars"></label>
                        <input type="radio" id="star1half' . $i . '" checked name="rating' . $i . '" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                        <input type="radio" id="star1' . $i . '" name="rating' . $i . '" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                        <input type="radio" id="star' . $i . '" name="rating' . $i . '" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
    </form> ';
    } elseif ($puntos == '1') {
        echo '<form style="padding-left:0" class="inline rating_fixed">
                        <input type="radio" id="star5' . $i . '" name="rating' . $i . '" value="5" /><label class = "full" for="star5" title="Fantástico - 5 stars"></label>
                        <input type="radio" id="star4half' . $i . '" name="rating' . $i . '" value="4 and a half" /><label class="half" for="star4half" title="Bastante bien - 4.5 stars"></label>
                        <input type="radio" id="star4' . $i . '" name="rating' . $i . '" value="4" /><label class = "full" for="star4" title="Bastante bien - 4 stars"></label>
                        <input type="radio" id="star3half' . $i . '" name="rating' . $i . '" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                        <input type="radio" id="star3' . $i . '" name="rating' . $i . '" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                        <input type="radio" id="star2half' . $i . '"  name="rating' . $i . '" value="2 and a half" /><label class="half" for="star2half" title="No muy bueno - 2.5 stars"></label>
                        <input type="radio" id="star2' . $i . '" name="rating' . $i . '" value="2" /><label class = "full" for="star2" title=" - 2 stars"></label>
                        <input type="radio" id="star1half' . $i . '" name="rating' . $i . '" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                        <input type="radio" id="star1' . $i . '" checked name="rating' . $i . '" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                        <input type="radio" id="star' . $i . '" name="rating' . $i . '" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
    </form> ';
    } elseif ($puntos == '0.5') {
        echo '<form style="padding-left:0" class="inline rating_fixed">
                        <input type="radio" id="star5' . $i . '" name="rating' . $i . '" value="5" /><label class = "full" for="star5" title="Fantástico - 5 stars"></label>
                        <input type="radio" id="star4half' . $i . '" name="rating' . $i . '" value="4 and a half" /><label class="half" for="star4half" title="Bastante bien - 4.5 stars"></label>
                        <input type="radio" id="star4' . $i . '" name="rating' . $i . '" value="4" /><label class = "full" for="star4" title="Bastante bien - 4 stars"></label>
                        <input type="radio" id="star3half' . $i . '" name="rating' . $i . '" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                        <input type="radio" id="star3' . $i . '" name="rating' . $i . '" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                        <input type="radio" id="star2half' . $i . '" name="rating' . $i . '" value="2 and a half" /><label class="half" for="star2half" title="No muy bueno - 2.5 stars"></label>
                        <input type="radio" id="star2' . $i . '" name="rating' . $i . '" value="2" /><label class = "full" for="star2" title=" - 2 stars"></label>
                        <input type="radio" id="star1half' . $i . '" name="rating' . $i . '" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                        <input type="radio" id="star1' . $i . '" name="rating' . $i . '" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                        <input type="radio" id="star' . $i . '" checked name="rating' . $i . '" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
    </form> ';
    } elseif ($puntos == null) {
        echo '<form style="padding-left:0" class="inline rating_fixed">
                        <input type="radio" id="star5' . $i . '" name="rating' . $i . '" value="5" /><label class = "full" for="star5" title="Fantástico - 5 stars"></label>
                        <input type="radio" id="star4half' . $i . '" name="rating' . $i . '" value="4 and a half" /><label class="half" for="star4half" title="Bastante bien - 4.5 stars"></label>
                        <input type="radio" id="star4' . $i . '" name="rating' . $i . '" value="4" /><label class = "full" for="star4" title="Bastante bien - 4 stars"></label>
                        <input type="radio" id="star3half' . $i . '" name="rating' . $i . '" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                        <input type="radio" id="star3' . $i . '" name="rating' . $i . '" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                        <input type="radio" id="star2half' . $i . '" name="rating' . $i . '" value="2 and a half" /><label class="half" for="star2half" title="No muy bueno - 2.5 stars"></label>
                        <input type="radio" id="star2' . $i . '" name="rating' . $i . '" value="2" /><label class = "full" for="star2" title=" - 2 stars"></label>
                        <input type="radio" id="star1half' . $i . '" name="rating' . $i . '" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                        <input type="radio" id="star1' . $i . '" name="rating' . $i . '" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                        <input type="radio" id="star' . $i . '" name="rating' . $i . '" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
    </form> ';
    }
}

function getInfoLocalName($name) {
    $conexion = conectar();
    $sql = "SELECT * FROM USUARIO WHERE NOMBRE_LOCAL = '$name'";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row;
    } else {
        return null;
    }
    desconectar();
}

function comentariosGrupo($id) {
    $conexion = conectar();
    $sql = "SELECT * FROM VOTAR_COMENTAR inner join USUARIO on VOTAR_COMENTAR.ID_FAN = USUARIO.ID_USUARIO WHERE ID_VOTADO = '$id' AND VOTO_CONCIERTO = 0;";
    $resultado = $conexion->query($sql);
    if ($resultado->num_rows > 0) {
        return $resultado;
    } else {
        echo mysqli_error($conexion);
        return false;
    }
    desconectar($conexion);
}

function modificarConcierto($idconcierto, $idgrupo, $idlocal, $fecha, $precio, $totalEntradas) {
    $conexion = conectar();
    $fechaSinHora = date('Y-m-d', strtotime($fecha));
    $sql = "SELECT * FROM CONCIERTO WHERE ID_GRUPO = $idgrupo AND ID_LOCAL = $idlocal AND DATE(FECHA) = '$fechaSinHora' AND VISIBLE = 1";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo '<h1>Ya existe un concierto del mismo grupo el mismo día</h1>';
        $idconcierto = $row['ID_CONCIERTO'];
        header("Refresh:2;url='CrearConcierto.php?idgrupo=$idgrupo&idconcierto=$idconcierto&mod=true'");
        return false;
    } else {
        $sql = "UPDATE CONCIERTO SET FECHA = '$fecha' AND PRECIO = $precio AND TOTAL_ENTRADAS = $totalEntradas WHERE ID_CONCIERTO = $idconcierto";
        if (mysqli_query($conexion, $sql)) {
            $nombreGrupo = getNombreGrupo($idgrupo);
            $nombreLocal = getNombreLocal($idlocal);
            TraceEvent("CONCIERTO", $nombreGrupo['NOMBRE_ARTISTICO'] . '-' . $nombreLocal['NOMBRE_LOCAL'], 1, "CONCIERTO MODIFICADO", $idconcierto);
            return true;
        } else {
            echo mysqli_error($conexion);
        }
    }

    desconectar($conexion);
}

function crearConcierto($idgrupo, $idlocal, $fecha, $precio, $totalEntradas, $idgenero, $idciudad) {
    $conexion = conectar();
    $fechaSinHora = date('Y-m-d', strtotime($fecha));
    $sql = "SELECT * FROM CONCIERTO WHERE ID_GRUPO = $idgrupo AND ID_LOCAL = $idlocal AND DATE(FECHA) = '$fechaSinHora' AND VISIBLE = 1";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        echo '<h1>Ya existe un concierto del mismo grupo el mismo día</h1>';
        header("Refresh:2;url='CrearConcierto.php?local=$idlocal&idgrupo=$idgrupo'");
        return false;
    } else {
        $sql2 = "INSERT INTO CONCIERTO VALUES(null,$idgrupo,$idlocal,'$fecha',1,$precio,1,$totalEntradas,0,$idgenero,$idciudad)";
        if (mysqli_query($conexion, $sql2)) {
            $sql3 = "SELECT ID_CONCIERTO FROM CONCIERTO WHERE ID_GRUPO =$idgrupo AND ID_LOCAL = $idlocal AND FECHA = '$fecha'";
            $result = $conexion->query($sql3);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $nombreGrupo = getNombreGrupo($idgrupo);
                $nombreLocal = getNombreLocal($idlocal);
                $propuesta = proponerConcierto($row['ID_CONCIERTO'], $idlocal, $idgrupo, $fecha);
                if ($propuesta) {
                    return true;
                    TraceEvent("CONCIERTO", $nombreGrupo['NOMBRE_ARTISTICO'] . '-' . $nombreLocal['NOMBRE_LOCAL'], 1, "NUEVO CONCIERTO PROPUESTO", $row['ID_CONCIERTO']);
                } else {
                    return false;
                }
            } else {
                echo mysqli_error($conexion);
                return false;
            }
        } else {
            echo mysqli_error($conexion);
            return false;
        }
    }
    desconectar($conexion);
}

function getInfoPropuesta($idconcierto) {
    $conexion = conectar();
    $sql = "SELECT * FROM PROPONER WHERE ID_CONCIERTO = $idconcierto";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['ESTADO'];
    } else {
        echo mysqli_error($conexion);
        return false;
    }
    desconectar($conexion);
}

function lanzarConcierto($idconcierto) {
    $conexion = conectar();
    $sql = "UPDATE CONCIERTO SET ESTADO = 1 WHERE ID_CONCIERTO = $idconcierto";
    if (mysqli_query($conexion, $sql)) {
        return true;
    } else {
        echo mysqli_error($conexion);
    }
    redirectURL('Perfil.php');
    desconectar($conexion);
}

function proponerConcierto($idconcierto, $idlocal, $idgrupo, $fecha) {
    $conexion = conectar();
    $sql = "INSERT INTO PROPONER VALUES(null, $idlocal, $idgrupo,$idconcierto,'$fecha', now(),'PENDIENTE')";
    if (mysqli_query($conexion, $sql)) {
        return true;
    } else {
        ECHO'AQUI';
        echo mysqli_error($conexion);
    }
    desconectar($conexion);
}

function cancelarConcierto($idconcierto) {
    $conexion = conectar();
    if (isset($idconcierto)) {
        $sql = "UPDATE CONCIERTO SET VISIBLE = 0 WHERE ID_CONCIERTO = $idconcierto";
        $informacion = getInfoConcierto($idconcierto)->fetch_assoc();
        $nombreGrupo = getNombreGrupo($informacion['ID_GRUPO']);
        $nombreLocal = getNombreLocal($informacion['ID_LOCAL']);
        TraceEvent("CONCIERTO", $nombreGrupo['NOMBRE_ARTISTICO'] . '-' . $nombreLocal['NOMBRE_LOCAL'], 1, "CONCIERTO CANCELADO", $idconcierto);
    } else {
        echo 'No has indicado un id_concierto';
    }
    if (mysqli_query($conexion, $sql)) {
        return true;
    } else {
        echo mysqli_error($conexion);
    }
    desconectar($conexion);
}

function getInfoConcierto($id) {
    $conexion = conectar();
    $sql = "SELECT * FROM CONCIERTO WHERE ID_CONCIERTO = $id";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        return $result;
    } else {
        echo mysqli_error($conexion);
        return false;
    }
}

function votarComentarNoConcierto($fan, $votado, $puntos, $comentario) {
    $conexion = conectar();
    $comentario = '<pre>' . $comentario;
    $sql = "INSERT INTO VOTAR_COMENTAR values (null,$fan,$votado,$puntos,0,'$comentario',now(),'A')";
    echo $puntos . 'hola';
    if (mysqli_query($conexion, $sql)) {
        return true;
    } else {
        echo mysqli_error($conexion);
    }
    desconectar($conexion);
}

function checkVotar($votado, $fan) {
    $conexion = conectar();
    $sql = "SELECT * FROM VOTAR_COMENTAR WHERE ID_VOTADO ='$votado' AND ID_FAN='$fan'";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
    desconectar($conexion);
}

function mostrarVotarComentar() {
    echo'<fieldset class="rating">
        <input type="radio" id="estrella5" name="erating" value="5" /><label class = "lleno" for="estrella5" title="Fantástico - 5 stars"></label>
        <input type="radio" id="estrella4medio" name="erating" value="4.5" /><label class="medio" for="estrella4medio" title="Bastante bien - 4.5 stars"></label>
        <input type="radio" id="estrella4" name="erating" value="4" /><label class = "lleno" for="estrella4" title="Bastante bien - 4 stars"></label>
        <input type="radio" id="estrella3medio" name="erating" value="3.5" /><label class="medio" for="estrella3medio" title="Meh - 3.5 stars"></label>
        <input type="radio" id="estrella3" name="erating" value="3" /><label class = "lleno" for="estrella3" title="Meh - 3 stars"></label>
        <input type="radio" id="estrella2medio" name="erating" value="2.5" /><label class="medio" for="estrella2medio" title="No muy bueno - 2.5 stars"></label>
        <input type="radio" id="estrella2" name="erating" value="2" /><label class = "lleno" for="estrella2" title=" - 2 stars"></label>
        <input type="radio" id="estrella1medio" name="erating" value="1.5" /><label class="medio" for="estrella1medio" title="Meh - 1.5 stars"></label>
        <input type="radio" id="estrella1" name="erating" value="1" /><label class = "lleno" for="estrella" title="Sucks big time - 1 star"></label>
        <input type="radio" id="estrella" name="erating" value="0.5" /><label class="medio" for="estrellamedio" title="Sucks big time - 0.5 stars"></label>';
    echo '</fieldset>';
}

function votarComentarConcierto($fan, $votado, $puntos, $comentario) {
    $conexion = conectar();
    $comentario = '<pre>' . $comentario;
    $sql = "INSERT INTO VOTAR_COMENTAR values (null,$fan,$votado,$puntos,1,'$comentario',Now(),'A')";
    if (mysqli_query($conexion, $sql)) {
        return true;
    } else {
        echo mysqli_error($conexion);
    }
    desconectar($conexion);
}

function getImageID($id) {
    $conexion = conectar();
    $sql = "SELECT * FROM USUARIO WHERE ID_USUARIO = $id";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['IMAGEN'] != null) {
            $imagen = $row['IMAGEN'];
            return $imagen;
        } else {
            return 'Imagenes/image.jpeg';
        }
    } else {
        return false;
    }
    desconectar($conexion);
}

function getImageEmail($email) {
    $conexion = conectar();
    $sql = "SELECT * FROM USUARIO WHERE EMAIL = '$email'";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['IMAGEN'] != null) {
            return $row['IMAGEN'];
        } else {
            return 'Imagenes/image.jpeg';
        }
    } else {
        return false;
    }
    desconectar($conexion);
}

function informacionFan($info) {

    if (isset($_POST['enviar'])) {
        $nuevoNombre = $_POST['nombre'];
        $nuevoApellido = $_POST['apellido'];
        $nuevaUbicacion = $_POST['ubicacion'];
        $nuevadescripcion = $_POST['descripcion'];
        $nuevoNumeroContacto = $_POST['numeroContacto'];
        if (modificarDatosFan($_SESSION['email'], $nuevoNombre, $nuevoApellido, $nuevaUbicacion, $nuevadescripcion, $nuevoNumeroContacto)) {
            echo '<h1 class=center">Datos <span class="color_rojo_general">Modificados</span> con Éxito</h1>';
            header("refresh:1; url=Perfil.php");
        } else {
            header("refresh:0;url = Perfil.php");
        }
    } else {
        if (isset($_POST['guardarImagen']) && isset($_FILES['fileToUpload'])) {
            if (isset($_FILES["fileToUpload"])) {
                $result = fileUpload($_SESSION['email']);
                if ($result != 1) {
                    showAlert($result);
                } else {
                    
                }
            } else {
                
            }
            //$result = modificarImagenEmail($nuevaImagen, $_SESSION['email']);
        } else {
            
        }
        $descripcion = str_replace("<pre>", "", $info['DESCRIPCION']);
        $urlDefaultImage = getImageEmail($_SESSION['email']);
        echo '<h1>Perfil <span class="color_rojo_general"> Fan</span></h1>';
        echo'<div id = "div1" class = "inline center" style = "vertical-align:top;width: 15%; height: 150%">
                        <div style = "width:250px; float:left">
                        <div id = "divConImagen" style = "border:1px solid gray">';

        $urlDefaultImage = getImageEmail($_SESSION['email']);
        echo '<div id="image-preview" style="background-image: url(' . $urlDefaultImage . ');background-size:cover">';
        echo '<label hidden for="image-upload" id="image-label">Escoger foto</label>';
        echo '<form action="" method="POST" id="formimg" enctype="multipart/form-data">';
        echo '<input type="file" name="fileToUpload" id="image-upload"/>';

        echo '</div>';
        echo'</div>';
        echo '</div>';

        echo '<div style="width:70%">';
        echo '<button style = "width:200px;margin:15px auto auto auto" name="guardarImagen" value="guardarImagen" type = "submit" id="guardarimagen" hidden class = "action-button">GUARDAR IMAGEN</button>';

        echo '</form>';
        echo'<button style = "width:200px;margin:15px auto auto auto" onclick = "modificarPerfil(2)" class = "action-button" id = "editarPerfil"><span class = "icon icon-wrench"></span>EDITAR PERFIL</button>
        </div>
                <a href = "ModificarPassword.php"><button style = "width:100%; margin:15px auto auto auto" id = "modificarContraseña" class = "action-button" hidden>MODIFICAR PASSWORD</button></a>
        <a href = "Baja.php"><button style = "width:100%; margin:15px auto auto auto" class = "action-button">DARSE DE BAJA</button></a>
        </div>
        <div id = "div2" class = "inline" style = "margin-left:50px;vertical-align: top; width: 60%; height: 150%">';
        echo'<form style = "width:100%" method = "POST" action = "" id = "msformLeft">
        <table style = "width:95%;text-align:left">
        <col width = "auto">
        <col width = "auto">
        <tr>
        <td style = "color:#d83c3c">Email:</td><td><input style = "width:80%" value = "' . $info['EMAIL'] . '" type = "text" disabled></td>
        <td style = "color:#d83c3c">Contacto:</td><td><input style = "width:100%" name = "numeroContacto" value = "' . $info['NUMERO_CONTACTO'] . '" class = "in" type = "number" disabled></td>
        </tr>
        <tr>
        <td style = "color:#d83c3c">Nombre:</td><td><input style = "width:80%" name = "nombre" value = "' . $info['NOMBRE'] . '" class = "in" type = "text" disabled></td>
        <td style = "color:#d83c3c">Apellidos:</td><td><input style = "width:80%" name = "apellido" value = "' . $info['APELLIDOS'] . '" class = "in" type = "text" disabled></td>
        </tr>
        <tr>
        <td style = "color:#d83c3c">Ubicacion:</td><td><input style = "width:80%" name = "ubicacion" value = "' . $info['UBICACION'] . '" class = "in" type = "text" disabled></td>
        <td style = "color:#d83c3c">Web:</td><td><input style = "width:80%" name = "web" value = "' . $info['WEB'] . '" class = "in" type = "text" disabled></td>
        </tr>
        </table>
        <table style = "width:95%;text-align:left">
        <col width = "110px">
        <tr>
        <td style = "color:#d83c3c">Descripción:</td><td><textarea class = "in" disabled style = "resize:none;width:100%;max-height:200px; height:300px; overflow-y:hidden" form = "msformLeft" name = "descripcion" >' . $descripcion . '</textarea></td>
        </tr>
        </table>
        <button style = "width:100%;margin:auto auto auto auto" id = "aplicarCambiosButton" hidden type = "submit" name = "enviar" class = "action-button">MODIFICAR DATOS</button>
        </form>';
        echo '</table > ';

        echo '</div>';
    }
}

function informacionMusico($info) {
    if (isset($_POST['enviar'])) {
        $nuevaUbicacion = $_POST['ubicacion'];
        $nuevoNumeroContacto = $_POST['numeroContacto'];
        $nuevoNombreArtistico = $_POST['nombreArtistico'];
        $nuevoNumeroComponentes = $_POST['numeroComponentes'];
        $nuevaDescripcion = $_POST['descripcion'];
        $nuevaWeb = $_POST['web'];

        if (modificarDatosMusico($_SESSION['email'], $nuevaUbicacion, $nuevoNumeroContacto, $nuevoNombreArtistico, $nuevoNumeroComponentes, $nuevaDescripcion, $nuevaWeb)) {
            echo '<h1 class = center">Datos <span class="color_rojo_general">Modificados</span> con Éxito</h1>';
            header("refresh:1;url = Perfil.php");
        } else {
            header("refresh:0;url = Perfil.php");
        }
    } else {
        if (isset($_POST['guardarImagen']) && isset($_FILES['fileToUpload'])) {
            if (isset($_FILES["fileToUpload"])) {
                $result = fileUpload($_SESSION['email']);
                if ($result != 1) {
                    showAlert($result);
                } else {
                    
                }
            } else {
                
            }
            //$result = modificarImagenEmail($nuevaImagen, $_SESSION['email']);
        } else {
            
        }
        $descripcion = str_replace("<pre>", "", $info['DESCRIPCION']);
        $urlDefaultImage = getImageEmail($_SESSION['email']);
        echo '<h1>Perfil <span class="color_rojo_general"> Musico</span></h1>';
        echo'<div id = "div1" class = "inline center" style = "vertical-align:top;
        width: 15%;
        height: 150%">
                        <div style = "width:250px;
        float:left">
                        <div id = "divConImagen" style = "border:1px solid gray">';

        $urlDefaultImage = getImageEmail($_SESSION['email']);
        echo '<div id="image-preview" style="background-image: url(' . $urlDefaultImage . ');
        background-size:cover">';
        echo '<label hidden for="image-upload" id="image-label">Escoger foto</label>';
        echo '<form action="" method="POST" id="formimg" enctype="multipart/form-data">';
        echo '<input type="file" name="fileToUpload" id="image-upload"/>';

        echo '</div>';
        echo'</div>';
        echo '</div>';

        echo '<div style="width:70%">';
        echo '<button style = "width:200px;
        margin:15px auto auto auto" name="guardarImagen" value="guardarImagen" type = "submit" id="guardarimagen" hidden class = "action-button">GUARDAR IMAGEN</button>';

        echo '</form>';
        echo'<button style = "width:200px;
        margin:15px auto auto auto" onclick = "modificarPerfil(2)" class = "action-button" id = "editarPerfil"><span class = "icon icon-wrench"></span>EDITAR PERFIL</button>
        </div>        
        <a href = "ModificarPassword.php"><button style = "width:100%;margin:15px auto auto auto" id = "modificarContraseña" class = "action-button" hidden>MODIFICAR PASSWORD</button></a>
        <a href = "Baja.php"><button style = "width:100%;margin:15px auto auto auto" class = "action-button">DARSE DE BAJA</button></a>       

        </div>
        <div id = "div2" class = "inline" style = "margin-left:50px;
        vertical-align: top;
        width: 25%;
        height: 150%">';
        $puntuacion = votosGrupo($info['ID_USUARIO']);
        echo '<div style = "float:left;
        text-align:left">';
        echo'<b style = "color:#d83c3c">RATING DEL GRUPO</b><i id = "puntuacion" hidden>' . $puntuacion . '</i><br>';
        echo '<fieldset class = "rating_fixed">
        <input type = "radio" id = "star5" name = "rating" value = "5" /><label class = "full" for = "star5" title = "Fantástico - 5 stars"></label>
        <input type = "radio" id = "star4half" name = "rating" value = "4 and a half" /><label class = "half" for = "star4half" title = "Bastante bien - 4.5 stars"></label>
        <input type = "radio" id = "star4" name = "rating" value = "4" /><label class = "full" for = "star4" title = "Bastante bien - 4 stars"></label>
        <input type = "radio" id = "star3half" name = "rating" value = "3 and a half" /><label class = "half" for = "star3half" title = "Meh - 3.5 stars"></label>
        <input type = "radio" id = "star3" name = "rating" value = "3" /><label class = "full" for = "star3" title = "Meh - 3 stars"></label>
        <input type = "radio" id = "star2half" name = "rating" value = "2 and a half" /><label class = "half" for = "star2half" title = "No muy bueno - 2.5 stars"></label>
        <input type = "radio" id = "star2" name = "rating" value = "2" /><label class = "full" for = "star2" title = " - 2 stars"></label>
        <input type = "radio" id = "star1half" name = "rating" value = "1 and a half" /><label class = "half" for = "star1half" title = "Meh - 1.5 stars"></label>
        <input type = "radio" id = "star1" name = "rating" value = "1" /><label class = "full" for = "star1" title = "Sucks big time - 1 star"></label>
        <input type = "radio" id = "starhalf" name = "rating" value = "half" /><label class = "half" for = "starhalf" title = "Sucks big time - 0.5 stars"></label>
        </fieldset> ';
        echo '</div>';
        $genero = getNombreGenero($info['ID_GENERO']);
        echo'<form style = "width:100%" method = "POST" action = "" id = "msformLeft">
        <table style = "width:95%">
        <col width = "100">
        <tr>
        <td style = "color:#d83c3c">Email:</td><td><input style = "width:100%" value = "' . $info['EMAIL'] . '" type = "text" disabled></td>
        </tr>
        <tr>
        <td style = "color:#d83c3c">Genero:</td><td><input style = "width:100%" value = "' . $genero . '" type = "text" disabled></td>
        </tr>

        <tr>
        <td style = "color:#d83c3c">Nombre:</td><td><input style = "width:100%" name = "nombreArtistico" value = "' . $info['NOMBRE_ARTISTICO'] . '" class = "in" type = "text" disabled></td>
        </tr>
        <tr>
        <td style = "color:#d83c3c">Numero de componentes:</td><td><input style = "width:100%" name = "numeroComponentes" value = "' . $info['NUMERO_COMPONENTES'] . '" class = "in" type = "numer" disabled></td>
        </tr>
        <tr>
        <td style = "color:#d83c3c">Ubicacion:</td><td><input style = "width:100%" name = "ubicacion" value = "' . $info['UBICACION'] . '" class = "in" type = "text" disabled></td>
        </tr>

        <tr>
        <td style = "color:#d83c3c">Web:</td><td><input style = "width:100%" name = "web" value = "' . $info['WEB'] . '" class = "in" type = "text" disabled></td>
        </tr>
        <tr>
        <td style = "color:#d83c3c">Contacto:</td><td><input style = "width:100%" name = "numeroContacto" value = "' . $info['NUMERO_CONTACTO'] . '" class = "in" type = "number" disabled></td>
        </tr>
        <tr>
        <td style = "color:#d83c3c">Descripción:</td><td><textarea class = "in" disabled style = "resize:none;width:100%;max-height:200px; height:300px; overflow-y:hidden" form = "msformLeft" name = "descripcion" >' . $descripcion . '</textarea></td>
        </tr>
        </table>
        <button style = "width:100%;margin:auto auto auto auto" id = "aplicarCambiosButton" hidden type = "submit" name = "enviar" class = "action-button">MODIFICAR DATOS</button>
        </form>
        </div>
        <div class = "inline" style = "width:200px;height:150%"></div>
        <div class = "inline" style = "vertical-align: top; width:30%; height: 150%">';
//                PROXIMOS CONCIERTOS
        echo'<div id = "div3" style = "border-bottom:2px solid gray">
        <h1 class = "fs-title">MIS PRÓXIMOS CONCIERTOS</h1>';
        echo '<div style = "max-height:325px;display:inline-block;overflow-y:auto; overflow-x:hidden" >';
        if ($fechas = ListaFechasConciertosGrupo(true, $info['ID_USUARIO'], 1)) {

            while ($row = $fechas->fetch_assoc()) {
                $nuevaFecha = date("w-d-m-Y", strtotime($row["FECHA"]));
                $nuevaHora = date("H:i", strtotime($row["FECHA"]));
                $fechaFinal = getNombreFecha($nuevaFecha);
                $estado = 1;
                $visible = 1;
                $result = ListaConciertosMusico($row['FECHA'], $info['ID_USUARIO'], 1);
                if ($result == null) {
                    echo '<script language = "javascript">$("#$fechaFinal").empty();</script>';
                } else {

                    echo '<div id="resultado" style="text-align:center">';
                    echo '<table cellspacing=0 style="width:100%;font-size:15px">';
                    echo '<tr><td>';
                    echo '<h3 id="' . $fechaFinal . '" class="color_rojo_general">' . $fechaFinal . '</h3>';
                    echo '</td></tr>';

                    while ($lista = $result->fetch_assoc()) {
                        $nombre_local = str_replace(" ", "+", $lista['NOMBRE_LOCAL']);
                        echo '<tr>';
                        echo '<td style="text-align:center;vertical-align:top">';
                        echo '<div class="inline">';
                        echo '<a class="fontblack a_concierto" href=InfoConcierto.php?idcon=' . $lista['ID_CONCIERTO'] . '>';
                        echo "<b id='h4_lista_img'>" . $lista['NOMBRE_LOCAL'] . "</b>";
                        echo "<br><i class='color_rojo_general'> " . $lista['UBICACION'] . "</i> <b>" . $nuevaHora . "h </b>";
                        echo "</a>";
                        echo '<form action="" method="POST">';
                        echo '<input type="text" hidden name="idconcierto" value="' . $lista['ID_CONCIERTO'] . '">';
                        echo '<button type = "submit" name = "cancelarConciertoEstado1" class = "action-button">CANCELAR</button>';
                        echo '</form>';
                        echo '</div>';
                        echo '</td>';
                        echo '</tr>';
                    }
                    echo'</table>';
                    echo'</div>';
                }
            }
            if (isset($_POST['cancelarConciertoEstado1'])) {
                $idconcierto = $_POST['idconcierto'];
                cancelarConcierto($idconcierto);
                redirectURL('Perfil.php');
            }
        } else {
            echo 'No hay conciertos<br><br>';
        }

        echo'</div>';
        echo'</div>';

//                FIN PROXIMOS CONCIERTOS
//                CONCIERTOS PENDIENTES

        echo '<div style="padding-top:20px;border-bottom:2px solid gray">';
        echo '<h1 class = "fs-title">PROPUESTAS Y CONCIERTOS PENDIENTES</h1>';
        echo '<div style = "max-height:325px;display:inline-block;text-align:center;height:auto;overflow-y:auto" >';
        $fechas = ListaFechasConciertosGrupo(true, $info['ID_USUARIO'], 0);
        if (!(empty($fechas))) {
            while ($row = $fechas->fetch_assoc()) {
                $nuevaFecha = date("w-d-m-Y", strtotime($row["FECHA"]));
                $nuevaHora = date("H:i", strtotime($row["FECHA"]));
                $fechaFinal = getNombreFecha($nuevaFecha);
                $estado = 0;
                $visible = 1;
                $result = ListaConciertosMusico($row['FECHA'], $info['ID_USUARIO'], 0);
                if ($result == null) {
                    echo 'No hay conciertos<br><br>';
                    echo '<script language = "javascript">$("#$fechaFinal").empty();</script>';
                } else {

                    echo '<div id="resultado" style="text-align:center">';
                    echo '<table cellspacing=0 style="width:100%;font-size:15px">';
                    echo '<tr><td>';
                    echo '<h3 id="' . $fechaFinal . '" class="color_rojo_general">' . $fechaFinal . '</h3>';
                    echo '</td></tr>';
                    while ($lista = $result->fetch_assoc()) {
                        $propuestaAceptada = getInfoPropuesta($lista['ID_CONCIERTO']);
                        $nombre_artistico = str_replace(" ", "+", $lista['NOMBRE_ARTISTICO']);
                        echo '<tr>';
                        echo '<td style="vertical-align:top">';
                        echo '<div class="inline">';
                        echo '<a class="fontblack a_concierto" href=InfoConcierto.php?idcon=' . $lista['ID_CONCIERTO'] . '>';
                        echo "<b id='h4_lista_img'>" . $lista['NOMBRE_ARTISTICO'] . "</b>";
                        if ($propuestaAceptada == 'A') {
                            $estadoPropuesta = " - <b class='color_rojo_general'>ACEPTADO</b>";
                        } elseif ($propuestaAceptada == 'P') {
                            $estadoPropuesta = " - <b class='color_rojo_general'>PENDIENTE</b>";
                        } else {
                            $estadoPropuesta = " - <b class='color_rojo_general'>CANCELADO</b>";
                        }
                        echo "<br><i class='color_rojo_general'> " . $lista['UBICACION'] . "</i> <b>" . $nuevaHora . "h </b>" . $estadoPropuesta;
                        echo "</a>";
                        echo '<form action="" method="POST">';
                        echo '<input type="text" hidden name="idconcierto" value="' . $lista['ID_CONCIERTO'] . '">';
                        if ($propuestaAceptada == 'P') {
                            echo '<button type = "submit" name = "aceptarConcierto" class = "action-button">ACEPTAR</button>';
                            echo '<button type = "submit" name = "rechazarConcierto" class = "action-button">RECHAZAR</button>';
                        } else {
                            
                        }
                        echo '</form>';
                        echo '</div>';
                        echo '</td>';
                        echo '</tr>';
                    }
                    echo'</table>';
                    echo'</div>';
                }
            }
            if (isset($_POST['rechazarConcierto'])) {
                $idconcierto = $_POST['idconcierto'];
                echo (ResponderPropuesta($idconcierto, 'C'));
                redirectURL('Perfil.php');
            }
            if (isset($_POST['aceptarConcierto'])) {
                $idconcierto = $_POST['idconcierto'];
                echo(ResponderPropuesta($idconcierto, 'A'));
                redirectURL('Perfil.php');
            }
        } else {
            echo 'No hay conciertos<br><br>';
        }
        echo'</div>';
        echo'</div>';
//          FIN CONCIERTOS PENDIENTES
//          
//        AQUI EMPIEZA CONCIERTOS PASADOS
        echo '<div style="padding-top:20px">';
        echo '<h1 class = "fs-title">CONCIERTOS PASADOS</h1>';
        echo '<div style = "max-height:325px;display:inline-block;text-align:center;height:325px;overflow-y:auto" >';
        $fechas = ListaFechasConciertosGrupo(false, $info['ID_USUARIO'], 1);
        if (!(empty($fechas))) {
            while ($row = $fechas->fetch_assoc()) {
                $nuevaFecha = date("w-d-m-Y", strtotime($row["FECHA"]));
                $nuevaHora = date("H:i", strtotime($row["FECHA"]));
                $fechaFinal = getNombreFecha($nuevaFecha);
                $estado = 1;
                $visible = 1;
                $result = ListaConciertosMusico($row['FECHA'], $info['ID_USUARIO'], 1);
                if ($result == null) {
                    echo 'No hay conciertos<br><br>';
                    echo '<script language = "javascript">$("#$fechaFinal").empty();</script>';
                } else {

                    echo '<div id="resultado" style="text-align:center">';
                    echo '<table cellspacing=0 style="width:100%;font-size:15px">';
                    echo '<tr><td>';
                    echo '<h3 id="' . $fechaFinal . '" class="color_rojo_general">' . $fechaFinal . '</h3>';
                    echo '</td></tr>';
                    while ($lista = $result->fetch_assoc()) {
                        $nombre_local = str_replace(" ", "+", $lista['NOMBRE_LOCAL']);
                        echo '<tr>';
                        echo '<td style="vertical-align:top">';
                        echo '<div class="inline">';
                        echo '<a class="fontblack a_concierto" href=InfoConcierto.php?idcon=' . $lista['ID_CONCIERTO'] . '>';
                        echo "<b id='h4_lista_img'>" . $lista['NOMBRE_LOCAL'] . "</b>";
                        echo "<br><i class='color_rojo_general'> " . $lista['UBICACION'] . "</i> <b>" . $nuevaHora . "h </b>";
                        echo "</a>";
                        echo '<form action="" method="POST">';
                        echo '<input type="text" hidden name="idconcierto" value="' . $lista['ID_CONCIERTO'] . '">';
                        echo '</form>';
                        echo '</div>';
                        echo '</td>';
                        echo '</tr>';
                    }
                    echo'</table>';
                    echo'</div>';
                }
            }
            if (isset($_POST['rechazarConcierto'])) {
                $idconcierto = $_POST['idconcierto'];
                echo (ResponderPropuesta($idconcierto, 'C'));
                redirectURL('Perfil.php');
            }
            if (isset($_POST['aceptarConcierto'])) {
                $idconcierto = $_POST['idconcierto'];
                echo(ResponderPropuesta($idconcierto, 'A'));
                redirectURL('Perfil.php');
            }
        } else {
            echo 'No hay conciertos<br><br>';
        }
        echo'</div>';
//        AQUI ACABA
        echo'</div>';
        echo'</div>';
        echo'<div id = "div4" class = "center" style = "width:60%;margin:auto auto 100px auto;">';
        $comentarios = comentariosGrupo($info['ID_USUARIO']);
        if ($comentarios != false) {
            echo '<div class="container center" style="width:500px">
            <h3><span class="color_rojo_general">Comentarios : </span></h3>';
            while ($lista = $comentarios->fetch_assoc()) {
                $imagen = getImageID($lista['ID_USUARIO']);
                echo '<div class="row center">';
                echo '<div class="col-sm-8">';
                echo '<div class="panel panel-white post panel-shadow">';
                echo '<div class="post-heading">';
                echo '<div class="pull-left image">';
                echo '<img src="' . $imagen . '" class="img-circle avatar" alt="user profile image">';
                echo '</div>';
                echo '<div class="pull-left meta">';
                echo '<div class="title h5">';
                echo '<b>' . $lista['NOMBRE'] . ' ' . $lista['APELLIDOS'] . '</b>';
                echo ' ha realizado un comentario';
                echo '</div>';
                echo '<h6 class="text-muted time">El ' . getNombreFecha(date("w-d-m-Y", strtotime($lista['FECHA']))) . '</h6>';
                echo '</div>';
                echo '</div>';
                echo '<div class="post-description">';
                echo '<p> ' . $lista['COMENTARIO'] . '</p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            echo'</div>';
        }
        echo'</div>';
    }
}

function informacionLocal($info) {
    if (isset($_POST['enviar'])) {
        $nuevaUbicacion = $_POST['ubicacion'];
        $nuevoNumeroContacto = $_POST['numeroContacto'];
        $nuevoNombreLocal = $_POST['nombreLocal'];
        $nuevoAforo = $_POST['aforo'];
        $nuevaWeb = $_POST['web'];
        $nuevadescripcion = $_POST['descripcion'];
        if (modificarDatosLocal($_SESSION['email'], $nuevaUbicacion, $nuevoNumeroContacto, $nuevoNombreLocal, $nuevoAforo, $nuevaWeb, $nuevadescripcion)) {
            echo '<h1 class=center">Datos <span class="color_rojo_general">Modificados</span> con Éxito</h1>';
            header("refresh:1; url=Perfil.php");
        } else {
            header("refresh:0;url = Perfil.php");
        }
    } else {
        if (isset($_POST['guardarImagen']) && isset($_FILES['fileToUpload'])) {
            if (isset($_FILES["fileToUpload"])) {
                $result = fileUpload($_SESSION['email']);
                if ($result != 1) {
                    showAlert($result);
                } else {
                    
                }
            } else {
                
            }
            //$result = modificarImagenEmail($nuevaImagen, $_SESSION['email']);
        } else {
            
        }
        $descripcion = str_replace("<pre>", "", $info['DESCRIPCION']);
        $urlDefaultImage = getImageEmail($_SESSION['email']);
        echo '<h1>Perfil <span class="color_rojo_general"> Local</span></h1>';
        echo'<div id = "div1" class = "inline center" style = "vertical-align:top;width: 15%; height: 150%">
                        <div style = "width:250px; float:left">
                        <div id = "divConImagen" style = "border:1px solid gray">';

        $urlDefaultImage = getImageEmail($_SESSION['email']);
        echo '<div id="image-preview" style="background-image: url(' . $urlDefaultImage . ');background-size:cover">';
        echo '<label hidden for="image-upload" id="image-label">Escoger foto</label>';
        echo '<form action="" method="POST" id="formimg" enctype="multipart/form-data">';
        echo '<input type="file" name="fileToUpload" id="image-upload"/>';

        echo '</div>';
        echo'</div>';
        echo '</div>';

        echo '<div style="width:70%">';
        echo '<button style = "width:200px;margin:15px auto auto auto" name="guardarImagen" value="guardarImagen" type = "submit" id="guardarimagen" hidden class = "action-button">GUARDAR IMAGEN</button>';

        echo '</form>';
        echo'<button style = "width:200px;margin:15px auto auto auto" onclick = "modificarPerfil(2)" class = "action-button" id = "editarPerfil"><span class = "icon icon-wrench"></span>EDITAR PERFIL</button>
        
        </div>
<a href = "ModificarPassword.php"><button style = "width:100%; margin:15px auto auto auto" id = "modificarContraseña" class = "action-button" hidden>MODIFICAR PASSWORD</button></a>
<a href = "Baja.php"><button style = "width:100%; margin:15px auto auto auto" class = "action-button">DARSE DE BAJA</button></a>

</div>
<div id = "div2" class = "inline" style = "margin-left:50px;vertical-align: top; width: 25%; height: 150%">';
        $puntuacion = votosLocal($info['ID_USUARIO']);
        echo '<div style = "float:left;text-align:left">';
        echo'<b style = "color:#d83c3c">LOCAL RATING</b><i id = "puntuacion" hidden>' . $puntuacion . '</i><br>';
        echo '<fieldset class = "rating_fixed">
<input type = "radio" id = "star5" name = "rating" value = "5" /><label class = "full" for = "star5" title = "Fantástico - 5 stars"></label>
<input type = "radio" id = "star4half" name = "rating" value = "4 and a half" /><label class = "half" for = "star4half" title = "Bastante bien - 4.5 stars"></label>
<input type = "radio" id = "star4" name = "rating" value = "4" /><label class = "full" for = "star4" title = "Bastante bien - 4 stars"></label>
<input type = "radio" id = "star3half" name = "rating" value = "3 and a half" /><label class = "half" for = "star3half" title = "Meh - 3.5 stars"></label>
<input type = "radio" id = "star3" name = "rating" value = "3" /><label class = "full" for = "star3" title = "Meh - 3 stars"></label>
<input type = "radio" id = "star2half" name = "rating" value = "2 and a half" /><label class = "half" for = "star2half" title = "No muy bueno - 2.5 stars"></label>
<input type = "radio" id = "star2" name = "rating" value = "2" /><label class = "full" for = "star2" title = " - 2 stars"></label>
<input type = "radio" id = "star1half" name = "rating" value = "1 and a half" /><label class = "half" for = "star1half" title = "Meh - 1.5 stars"></label>
<input type = "radio" id = "star1" name = "rating" value = "1" /><label class = "full" for = "star1" title = "Sucks big time - 1 star"></label>
<input type = "radio" id = "starhalf" name = "rating" value = "half" /><label class = "half" for = "starhalf" title = "Sucks big time - 0.5 stars"></label>
</fieldset> ';
        echo '</div>';
        echo'<form style = "width:100%" method = "POST" action = "" id = "msformLeft">
<table style = "width:95%">
<col width = "100">
<tr>
<td style = "color:#d83c3c">Email:</td><td><input style = "width:100%" value = "' . $info['EMAIL'] . '" type = "text" disabled></td>
</tr>
<tr>
<td style = "color:#d83c3c">Nombre:</td><td><input style = "width:100%" name = "nombreLocal" value = "' . $info['NOMBRE_LOCAL'] . '" class = "in" type = "text" disabled></td>
</tr>
<tr>
<td style = "color:#d83c3c">Ubicacion:</td><td><input style = "width:100%" name = "ubicacion" value = "' . $info['UBICACION'] . '" class = "in" type = "text" disabled></td>
</tr>
<tr>
<td style = "color:#d83c3c">Aforo:</td><td><input style = "width:100%" name = "aforo" value = "' . $info['AFORO'] . '" class = "in" type = "text" disabled></td>
</tr>
<tr>
<td style = "color:#d83c3c">Web:</td><td><input style = "width:100%" name = "web" value = "' . $info['WEB'] . '" class = "in" type = "text" disabled></td>
</tr>
<tr>
<td style = "color:#d83c3c">Contacto:</td><td><input style = "width:100%" name = "numeroContacto" value = "' . $info['NUMERO_CONTACTO'] . '" class = "in" type = "number" disabled></td>
</tr>
<tr>
<td style = "color:#d83c3c">Descripción:</td><td><textarea class = "in" disabled style = "resize:none;width:100%;max-height:200px; height:300px; overflow-y:hidden" form = "msformLeft" name = "descripcion" >' . $descripcion . '</textarea></td>
</tr>
</table>
<button style = "width:100%;margin:auto auto auto auto" id = "aplicarCambiosButton" hidden type = "submit" name = "enviar" class = "action-button">MODIFICAR DATOS</button>
</form>
</div>
<div class = "inline" style = "width:200px;height:150%"></div>
<div class = "inline" style = ";vertical-align: top; width:30%; height: 150%">
<div id = "div3" style = "border-bottom:2px solid gray">
<a href = "CrearConcierto.php?local=' . $info['ID_USUARIO'] . '" style = "width:100px" class = "action-button">CREAR CONCIERTO</a><br><br>

<h1 class = "fs-title">PRÓXIMOS CONCIERTOS EN MI LOCAL</h1>';
        echo '<div style = "max-height:325px;display:inline-block;overflow-y:auto; overflow-x:hidden" >';
        if ($fechas = ListaFechasConciertosLocal(true, $info['ID_USUARIO'], 1)) {

            while ($row = $fechas->fetch_assoc()) {
                $nuevaFecha = date("w-d-m-Y", strtotime($row["FECHA"]));
                $nuevaHora = date("H:i", strtotime($row["FECHA"]));
                $fechaFinal = getNombreFecha($nuevaFecha);
                $estado = 1;
                $visible = 1;
                $result = ListaConciertosFan($row['FECHA'], null, null, null, $info['ID_USUARIO'], $estado, $visible);
                if ($result == null) {
                    echo '<script language = "javascript">$("#$fechaFinal").empty();</script>';
                } else {
                    echo '<div id="resultado" style="text-align:center">';
                    echo '<table cellspacing=0 style="width:100%;font-size:15px">';
                    echo '<tr><td>';
                    echo '<h3 id="' . $fechaFinal . '" class="color_rojo_general">' . $fechaFinal . '</h3>';
                    echo '</td></tr>';

                    while ($lista = $result->fetch_assoc()) {
                        $nombre_artistico = str_replace(" ", "+", $lista['NOMBRE_ARTISTICO']);
                        echo '<tr>';
                        echo '<td style="text-align:center;vertical-align:top">';
                        echo '<div class="inline">';
                        echo '<a class="fontblack a_concierto" href=InfoConcierto.php?idcon=' . $lista['ID_CONCIERTO'] . '>';
                        echo "<b id='h4_lista_img'>" . $lista['NOMBRE_ARTISTICO'] . "</b>";
                        echo "<i>" . $lista['GENERO'] . "</i>";
                        echo "</a>";
                        echo '<form action="" method="POST">';
                        echo '<input type="text" hidden name="idconcierto" value="' . $lista['ID_CONCIERTO'] . '">';
                        echo '<button type = "submit" name = "cancelarConciertoEstado1" class = "action-button">CANCELAR</button>';
                        echo '</form>';
                        echo '</div>';
                        echo '</td>';
                        echo '</tr>';
                    }
                    echo'</table>';
                    echo'</div>';
                }
            }
            if (isset($_POST['cancelarConciertoEstado1'])) {
                $idconcierto = $_POST['idconcierto'];
                cancelarConcierto($idconcierto);
                redirectURL('Perfil.php');
            }
        } else {
            echo 'No hay conciertos<br><br>';
        }
        echo'</div>';
        echo'</div>';
        echo '<div style="padding-top:20px">';
        echo '<h1 class = "fs-title">CONCIERTOS PENDIENTES</h1>';
        echo '<div style = "max-height:325px;display:inline-block;text-align:center;height:325px;overflow-y:auto" >';
        $fechas = ListaFechasConciertosLocal(true, $info['ID_USUARIO'], 0);
        if (!(empty($fechas))) {
            while ($row = $fechas->fetch_assoc()) {
                $nuevaFecha = date("w-d-m-Y", strtotime($row["FECHA"]));
                $nuevaHora = date("H:i", strtotime($row["FECHA"]));
                $fechaFinal = getNombreFecha($nuevaFecha);
                $estado = 0;
                $visible = 1;
                $result = ListaConciertosFan($row['FECHA'], null, null, null, $info['ID_USUARIO'], $estado, $visible);
                if ($result == null) {
                    echo '<script language = "javascript">$("#$fechaFinal").empty();</script>';
                } else {

                    echo '<div id="resultado" style="text-align:center">';
                    echo '<table cellspacing=0 style="width:100%;font-size:15px">';
                    echo '<tr><td>';
                    echo '<h3 id="' . $fechaFinal . '" class="color_rojo_general">' . $fechaFinal . '</h3>';
                    echo '</td></tr>';
                    while ($lista = $result->fetch_assoc()) {
                        $propuestaAceptada = getInfoPropuesta($lista['ID_CONCIERTO']);
                        $nombre_artistico = str_replace(" ", "+", $lista['NOMBRE_ARTISTICO']);
                        echo '<tr>';
                        echo '<td style="vertical-align:top">';
                        echo '<div class="inline">';
                        echo '<a class="fontblack a_concierto" href=InfoConcierto.php?idcon=' . $lista['ID_CONCIERTO'] . '>';
                        echo "<b id='h4_lista_img'>" . $lista['NOMBRE_ARTISTICO'] . "</b>";
                        if ($propuestaAceptada == 'A') {
                            $estadoPropuesta = " - <i class='color_rojo_general'>ACEPTADO</i>";
                        } elseif ($propuestaAceptada == 'P' || $propuestaAceptada == 'PENDIENTE') {
                            $estadoPropuesta = " - <i class='color_rojo_general'>PENDIENTE</i>";
                        } else {
                            $estadoPropuesta = " - <i class='color_rojo_general'>CANCELADO</i>";
                        }
                        echo "<i class='color_rojo_general'> " . $lista['GENERO'] . "</i> <b>" . $nuevaHora . "h </b>" . $estadoPropuesta;
                        echo "</a>";
                        echo '<form action="" method="POST">';
                        echo '<input type="text" hidden name="idconcierto" value="' . $lista['ID_CONCIERTO'] . '">';
                        echo '<input type="text" hidden name="idgrupo" value="' . $lista['ID_GRUPO'] . '">';
                        if ($propuestaAceptada == 'A') {
                            echo '<button type = "submit" name = "lanzarConcierto" class = "action-button">LANZAR</button>';
                            echo '<button type = "submit" name = "cancelarConcierto" class = "action-button">CANCELAR</button>';
                        } elseif ($propuestaAceptada == 'C') {
                            echo '<button type = "submit" name = "cancelarConcierto" class = "action-button">CANCELAR</button>';
                        } else {
                            echo '<button type = "submit" name = "modificarConcierto" class = "action-button">MODIFICAR</button>';
                            echo '<button type = "submit" name = "cancelarConcierto" class = "action-button">CANCELAR</button>';
                        }
                        echo '</form>';
                        echo '</div>';
                        echo '</td>';
                        echo '</tr>';
                    }
                    echo'</table>';
                    echo'</div>';
                }
            }
            if (isset($_POST['lanzarConcierto'])) {
                $idconcierto = $_POST['idconcierto'];
                lanzarConcierto($idconcierto);
                redirectURL('Perfil.php');
            }
            if (isset($_POST['cancelarConcierto'])) {
                $idconcierto = $_POST['idconcierto'];
                cancelarConcierto($idconcierto);
            }
            if (isset($_POST['modificarConcierto'])) {
                $idconcierto = $_POST['idconcierto'];
                $idgrupo = $_POST['idgrupo'];
                echo'<script>window.location.replace("CrearConcierto.php?idgrupo=' . $idgrupo . '&idconcierto=' . $idconcierto . '&mod=true");</script>';
            }
        } else {
            echo 'No hay conciertos<br><br>';
        }
        echo'</div>';
        echo'</div>';

        echo'</div>';
        echo'<div id = "div4" class = "center" style = "width:60%;margin:auto auto 100px auto">';
        $comentarios = comentariosGrupo($info['ID_USUARIO']);
        if ($comentarios != false) {
            echo '<div class="container center" style="width:500px">
            <h3><span class="color_rojo_general">Comentarios : </span></h3>';
            while ($lista = $comentarios->fetch_assoc()) {
                $imagen = getImageID($lista['ID_USUARIO']);
                echo '<div class = "row center">';
                echo '<div class = "col-sm-8">';
                echo '<div class = "panel panel-white post panel-shadow">';
                echo '<div class = "post-heading">';
                echo '<div class = "pull-left image">';
                echo '<img src = "' . $imagen . '" class = "img-circle avatar" alt = "user profile image">';
                echo '</div>';
                echo '<div class = "pull-left meta">';
                echo '<div class = "title h5">';
                echo '<b>' . $lista['NOMBRE'] . ' ' . $lista['APELLIDOS'] . '</b>';
                echo ' ha realizado un comentario';
                echo '</div>';
                echo '<h6 class = "text-muted time">El ' . getNombreFecha(date("w-d-m-Y", strtotime($lista['FECHA']))) . '</h6>';
                echo '</div>';
                echo '</div>';
                echo '<div class = "post-description">';
                echo '<p> ' . $lista['COMENTARIO'] . '</p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            echo'</div>';
        }
        echo'</div>';
    }
}

function modificarImagenEmail($imagen, $email) {
    $conexion = conectar();
    $sql = "UPDATE USUARIO SET IMAGEN = '$imagen' WHERE EMAIL = '$email'";
    if (mysqli_query($conexion, $sql)) {
        return true;
    } else {
        echo mysqli_error($conexion);
    }
    desconectar($conexion);
}

function darBaja($email) {
    $conexion = conectar();
    $sql = "UPDATE USUARIO SET FECHA_BAJA = now() WHERE EMAIL = '$email'";
    if (mysqli_query($conexion, $sql)) {
        $infoUsuario = getInfoUser($email);
        if ($infoUsuario['TIPO_USUARIO'] == 'Musico') {
            $idgrupo = $infoUsuario['ID_USUARIO'];
            $sql2 = "SELECT * FROM PROPONER WHERE ID_GRUPO = $idgrupo";
            $result = $conexion->query($sql2);
            if ($result->num_rows > 0) {
                $sql3 = "UPDATE PROPONER SET ESTADO = 'C' WHERE ID_GRUPO = $idgrupo";
                if (mysqli_query($conexion, $sql3)) {
                    return true;
                } else {
                    echo mysqli_error($conexion);
                }
            } else {
                return null;
            }
        } elseif ($infoUsuario['TIPO_USUARIO'] == 'Local') {
            $idlocal = $infoUsuario['ID_USUARIO'];
            echo $idlocal;
            $sql2 = "SELECT * FROM PROPONER WHERE ID_LOCAL = $idlocal";
            $result = $conexion->query($sql2);
            if ($result->num_rows > 0) {
                $sql3 = "UPDATE PROPONER SET ESTADO = 'C' WHERE ID_LOCAL = $idlocal";
                if (mysqli_query($conexion, $sql3)) {
                    return true;
                } else {
                    echo mysqli_error($conexion);
                }
            } else {
                return null;
            }
        } else {
            return true;
        }
    } else {
        return false;
        echo mysqli_error($conexion);
    }
    desconectar($conexion);
}

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
