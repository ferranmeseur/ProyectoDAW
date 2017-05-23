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
    $sql = "SELECT *, GENERO.NOMBRE AS NOMBRE_GENERO FROM USUARIO INNER JOIN GENERO ON USUARIO.ID_GENERO = GENERO.ID_GENERO WHERE NOMBRE_ARTISTICO LIKE '%" . $busqueda . "%'";
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
    $sql = "SELECT *,LEFT(NOMBRE_ARTISTICO,1) AS LETRA FROM USUARIO WHERE TIPO_USUARIO = 'Musico' ";
    $isFirst = 1;
    if ($ciudad != null) {
        if ($isFirst == 1) {
            $sql .= " WHERE ID_CIUDAD = $ciudad";
        } else {
            $sql .= " AND ID_CIUDAD = $ciudad";
        }
    }
    if ($genero != null) {
        if ($isFirst == 1) {
            $sql .= " WHERE ID_GENERO = $genero";
        } else {
            $sql .= " AND ID_GENERO = $genero";
        }
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
    $sql = "SELECT LEFT(NOMBRE_ARTISTICO, 1) AS LETRA FROM USUARIO WHERE TIPO_USUARIO = 'MUSICO' GROUP BY LETRA ORDER BY NOMBRE_ARTISTICO ASC";
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

function RankingMusicos($genero, $ciudad) {
    $conexion = conectar();
    $isFirst = 1;
    if (!isset($genero) && !isset($ciudad)) {
        $sql = "SELECT SUM(PUNTOS) AS PUNTOS,(SELECT NOMBRE FROM GENERO WHERE ID_GENERO = USUARIO.ID_GENERO) AS NOMBRE_GENERO, (SELECT NOMBRE FROM CIUDAD WHERE ID_CIUDAD = USUARIO.ID_CIUDAD) AS NOMBRE_CIUDAD, USUARIO.ID_GENERO AS GENERO, USUARIO.ID_CIUDAD AS CIUDAD, ID_VOTADO, NOMBRE FROM VOTAR_COMENTAR INNER JOIN USUARIO ON VOTAR_COMENTAR.ID_VOTADO=USUARIO.ID_USUARIO WHERE USUARIO.TIPO_USUARIO = 'MUSICO' GROUP BY ID_VOTADO ORDER BY PUNTOS DESC";
    } else {
        $sql = "SELECT SUM(PUNTOS) AS PUNTOS,(SELECT NOMBRE FROM GENERO WHERE ID_GENERO = USUARIO.ID_GENERO) AS NOMBRE_GENERO, (SELECT NOMBRE FROM CIUDAD WHERE ID_CIUDAD = USUARIO.ID_CIUDAD) AS NOMBRE_CIUDAD, USUARIO.ID_GENERO AS GENERO, USUARIO.ID_CIUDAD AS CIUDAD, ID_VOTADO, NOMBRE FROM VOTAR_COMENTAR INNER JOIN USUARIO ON VOTAR_COMENTAR.ID_VOTADO=USUARIO.ID_USUARIO WHERE USUARIO.TIPO_USUARIO = 'MUSICO' GROUP BY ID_VOTADO";
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

function ListaConciertosFan($fechaConciertos, $genero, $ciudad, $grupo, $local) {
    $conexion = conectar();
    if (empty($genero) && empty($ciudad) && empty($grupo) && empty($local)) {
        $sql = "SELECT *,(SELECT UBICACION FROM USUARIO WHERE ID_USUARIO=CONCIERTO.ID_LOCAL) AS UBICACION, (SELECT NOMBRE FROM GENERO WHERE ID_GENERO = CONCIERTO.ID_GENERO) AS GENERO, (SELECT NOMBRE FROM CIUDAD WHERE ID_CIUDAD = CONCIERTO.ID_CIUDAD) AS CIUDAD, (SELECT NOMBRE_LOCAL FROM USUARIO WHERE ID_USUARIO=ID_LOCAL) AS NOMBRE_LOCAL FROM CONCIERTO INNER JOIN USUARIO ON CONCIERTO.ID_GRUPO = USUARIO.ID_USUARIO WHERE CONCIERTO.FECHA>='$fechaConciertos'";
    } else {
        $sql = "SELECT *,(SELECT UBICACION FROM USUARIO WHERE ID_USUARIO=CONCIERTO.ID_LOCAL) AS UBICACION, (SELECT NOMBRE FROM GENERO WHERE ID_GENERO = CONCIERTO.ID_GENERO) AS GENERO, (SELECT NOMBRE FROM CIUDAD WHERE ID_CIUDAD = CONCIERTO.ID_CIUDAD) AS CIUDAD, (SELECT NOMBRE_LOCAL FROM USUARIO WHERE ID_USUARIO=ID_LOCAL) AS NOMBRE_LOCAL FROM CONCIERTO INNER JOIN USUARIO ON CONCIERTO.ID_GRUPO = USUARIO.ID_USUARIO WHERE CONCIERTO.FECHA>='$fechaConciertos'";
        if (!empty($genero)) {
            $sql = $sql . ' AND CONCIERTO.ID_GENERO = "' . $genero . '"';
        } else if (!empty($ciudad)) {
            $sql = $sql . " AND CONCIERTO.ID_CIUDAD = '" . $ciudad . "'";
        } else if (!empty($grupo)) {
            $sql = $sql . " AND CONCIERTO.ID_GRUPO = '$grupo' ";
        } else if (!empty($local)) {
            $sql = $sql . " HAVING CONCIERTO.ID_LOCAL = '$local'";
        }
    }
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        return $result;
    } else {
        return null;
    }
    desconectar($conexion);
}

function ListaFechasConciertos($futurosConciertos) {
    $conexion = conectar();
    if ($futurosConciertos == 'true') {
        $sql = "SELECT FECHA FROM CONCIERTO WHERE FECHA>=now() GROUP BY FECHA";
        $result = $conexion->query($sql);
        if ($result->num_rows > 0) {
            return $result;
        } else {
            echo 'error ListaFEchasConciertos';
        }
    } else {
        $sql = "SELECT FECHA FROM CONCIERTO WHERE FECHA<now() GROUP BY FECHA";
        $result = $conexion->query($sql);
        if ($result->num_rows > 0) {
            return $result;
        } else {
            echo 'error ListaFEchasConciertos';
//echo mysqli_error($conexion);
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

function redirectURL($url) {
    echo '<script language="javascript">
    window.location.replace("' . $url . '");</script>';
}

function Registro($tipo, $nombre, $apellido, $email, $pswd, $nombrelocal, $ciudad, $ubicacion, $telefono, $aforo, $imagen, $web, $nombreartistico, $genero, $componentes, $pregunta, $respuesta, $descripcion) {
    $con = conectar();
    $resultado = "";
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
    $sql = "select * from USUARIO where EMAIL = '$mail'";
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
                    return true;
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
        $sql = "SELECT COUNT(VALOR) AS 'VECES', VALOR AS NOMBRE FROM TRACE WHERE COMENTARIO = 'MUSICO' GROUP BY VALOR ORDER BY VECES DESC LIMIT 5";
    } else if ($tipo == "local") {
        $sql = "SELECT COUNT(VALOR) AS 'VECES', VALOR AS NOMBRE FROM TRACE WHERE COMENTARIO='LOCAL' GROUP BY VALOR ORDER BY VECES DESC LIMIT 5";
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

function ArtistasAlza($genero, $ciudad) {
    $result = RankingMusicos($genero, $ciudad);
    $i = 1;
    echo'<h2>ARTISTAS EN ALZA</h2>';
    echo'<i>Artistas con más votos de los fans</i>';
    echo '<div id="div_parent_ranking">';
    while ($row = $result->fetch_assoc()) {
        $nombre_artistico = str_replace(" ", "+", $row['NOMBRE']);
        echo '<div id="musicoRanking' . $i . '">';
        echo '<div class="div_peque_ranking"></div>';
        echo '<div class="div_ranking">';
        echo '<img class="img_div_ranking inline" src="Imagenes/image.jpeg">';
        echo '<div class="nombre_artista inline vertical_top" style="padding-top:10px;padding-left:10px"><a href="InfoGrupo.php?nombre=' . $nombre_artistico . '"><b class="fontblack a_concierto" style="font-size:25px">' . $row['NOMBRE'] . '</b><br><i class="color_rojo_general"> ' . $row['NOMBRE_GENERO'] . ' - ' . $row['NOMBRE_CIUDAD'] . '</i></a></div>';
        echo '</div>';
        echo '<img class="img_ranking_numero" src="Imagenes/ranking' . $i . '.png">';
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
        return $result;
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
        return $result;
    } else {
        return null;
    }
    desconectar();
}

function NoticiasNuevoConcierto() {
    $conexion = conectar();
    $sql = "SELECT *,(SELECT UBICACION FROM USUARIO WHERE TIPO_USUARIO = 'LOCAL' AND CONCIERTO.ID_LOCAL = USUARIO.ID_USUARIO) AS UBICACION, CONCIERTO.FECHA AS CONCIERTO_FECHA FROM TRACE INNER JOIN CONCIERTO ON TRACE.ID_CONCIERTO = CONCIERTO.ID_CONCIERTO WHERE TIPO = 'CONCIERTO' AND COMENTARIO = 'NUEVO CONCIERTO' ORDER BY TRACE.FECHA DESC LIMIT 1";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        return $result;
    } else {
        return null;
    }
    desconectar();
}

function ShowNoticiasMusico() {
    $nuevoGrupo = NoticiasNuevoMusico()->fetch_assoc();
    $url = "url('Imagenes/img_forest.jpg')";
    $nombre_grupo = str_replace(" ", "+", $nuevoGrupo['VALOR']);
    $nombre_ciudad = getNombreCiudad($nuevoGrupo['ID_CIUDAD'])->fetch_assoc();
    $nombre_genero = getNombreGenero($nuevoGrupo['ID_GENERO'])->fetch_assoc();
    echo '<a class="a_noticia" href="InfoGrupo.php?nombre=' . $nombre_grupo . '">';
    echo '<div style = "height:250px;background-image:' . $url . ';background-size:cover;background-position:center">';
    echo '<div style="position: relative;top: 0;background-color:rgba(0, 0, 0, 0.8)">';
    echo '<b style="color:white;font-size:30px">Un nuevo grupo se acaba de unir</b>';
    echo '</div>';
    echo '<div style="position: relative;bottom: 0;background-color:rgba(0, 0, 0, 0.8)">';
    echo '<h1>' . $nuevoGrupo['VALOR'] . '</h1>';
    echo '<i style="color:white">' . $nombre_ciudad['NOMBRE'] . ', ' . $nombre_genero['NOMBRE'] . '</i>';
    echo '</div>';
    echo '</div></a>';
}

function ShowNoticiasLocal() {
    $nuevoLocal = NoticiasNuevoLocal()->fetch_assoc();
    $nombre_local = str_replace(" ", "+", $nuevoLocal['VALOR']);
    $url = "url('Imagenes/img_lights.jpg')";
    $nombre_ciudad = getNombreCiudad($nuevoLocal['ID_CIUDAD'])->fetch_assoc();
    $nombre_genero = getNombreGenero($nuevoLocal['ID_GENERO'])->fetch_assoc();
    echo '<a class="a_noticia" href="InfoGrupo.php?nombre=' . $nombre_local . '">';
    echo '<div style = "height:250px;background-image:' . $url . ';background-size:cover;background-position:center">';
    echo '<div style="position: relative;top: 0;background-color:rgba(0, 0, 0, 0.8)">';
    echo '<b style="color:white;font-size:30px">Un nuevo local se acaba de unir</b>';
    echo '</div>';
    echo '<div style="position: relative;bottom: 0;background-color:rgba(0, 0, 0, 0.8)">';
    echo '<h1>' . $nuevoLocal['VALOR'] . '</h1>';
    echo '<i style="color:white">' . $nuevoLocal['UBICACION'] . ', ' . $nombre_ciudad['NOMBRE'] . ', ' . $nombre_genero['NOMBRE'] . '</i>';
    echo '</div>';
    echo '</div></a>';
}

function ShowNoticiasConcierto() {
    $nuevoConcierto = NoticiasNuevoConcierto()->fetch_assoc();
    $nombres = split("-", $nuevoConcierto['VALOR']);
    $url = "url('Imagenes/img_mountains.jpg')";
    $nuevaFecha = date("w-d-m-Y", strtotime($nuevoConcierto["CONCIERTO_FECHA"]));
    $nuevaHora = date("H:i", strtotime($nuevoConcierto["CONCIERTO_FECHA"]));
    $fechaFinal = getNombreFecha($nuevaFecha);
    $nombre_ciudad = getNombreCiudad($nuevoConcierto['ID_CIUDAD'])->fetch_assoc();

    echo '<a class="a_noticia" href="InfoConcierto.php?idCon=' . $nuevoConcierto['ID_CONCIERTO'] . '">';
    echo '<div style = "height:250px;background-image:' . $url . ';background-size:cover;background-position:center">';
    echo '<div style="position: relative;top: 0;background-color:rgba(0, 0, 0, 0.8)">';
    echo '<b style="color:white;font-size:30px">Nuevo concierto</b>';
    echo '</div>';
    echo '<div style="position: relative;top: 50%;transform: translateY(-50%);background-color:rgba(0, 0, 0, 0.8)">';
    echo '<b style="font-size:40px">' . $nombres[0] . '</b>';
    echo '<p style="color:white;font-size:20px;display:inline">' . $fechaFinal . '</p>';
    echo '<b style="font-size:40px">' . $nombres[1] . '</b><br>';
    echo '<i style="color:white;font-size:20px">' . $nuevoConcierto['UBICACION'] . ', ' . $nombre_ciudad['NOMBRE'] . '</i>';
    echo '</div>';
    echo '</div></a>';
}

function getNombreCiudad($id_ciudad) {
    $conexion = conectar();
    $sql = "SELECT NOMBRE FROM CIUDAD WHERE ID_CIUDAD= $id_ciudad";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        return $result;
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
        return $result;
    } else {
        return null;
    }
    desconectar();
}

function fileUpload($email) {
    $target_dir = "C:/Users/THOR/Desktop/Subidas/";
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
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
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
            return "El archivo no es una imagen";
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
}
function getInfoUser($email) {
    $conexion = conectar();
    $sql = "SELECT * FROM USUARIO WHERE EMAIL = '$email'";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row;
    } else {
        return null;
    }
    desconectar();
}

