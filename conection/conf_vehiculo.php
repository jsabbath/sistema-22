<?php
session_start();
//obtener tabla de usuarios
if (isset($_GET['listado_vehiculo'])) {
    require("fun_sistema.php");
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();
    $consulta = "select*from vistavehiculo where estado!=2 and idvehiculo!=1;";
    mysqli_set_charset($conexion, "utf8");
    $registro = mysqli_query($conexion, $consulta);
    $i = 0;
    $tabla = "";
    while ($row = mysqli_fetch_array($registro)) {
        $estado = '';
        $detalle = '<button type=\"button\" onclick=\"detalleVehiculo(' . $row['idvehiculo'] . ')\" class=\"btn btn-info btn-block btn-xs\"><span class=\"fa fa-external-link fa-fw\"></span> detalle </button>';
        $tabla.='{"patente":"' . $row['patente'] . '","descripcion":"' . $row['descripcion'] . '","tipo":"' . $row['tipo_vehi_nombre'] . '","km":"' . $row['km'] . '","detalle":"' . $detalle . '"},';
        $i++;
    }
    $tabla = substr($tabla, 0, strlen($tabla) - 1);
    echo '{"data":[' . $tabla . ']}';
}

//obtener tabla de clasificacion
if (isset($_GET['tipo'])) {
    require("fun_sistema.php");
    $opcion = $_GET['tipo'];
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();
    $consulta = "select*from tipo_vehi order by idtipo_vehi;";
    mysqli_set_charset($conexion, "utf8");
    $registro = mysqli_query($conexion, $consulta);
    $i = 0;
    $tabla = "";
    while ($row = mysqli_fetch_array($registro)) {
        if ($row[0] == 1) {
            $delete = '<button type=\"button\" class=\"btn btn-default btn-block btn-xs\"><span class=\"fa fa-trash fa-fw\"></span> Eliminar </button>';
        } else {
            $delete = '<button type=\"button\" onclick=\"eliminarTipoVehiculo(' . $row[0] . ')\" class=\"btn btn-danger btn-block btn-xs\"><span class=\"fa fa-trash fa-fw\"></span> Eliminar </button>';
        }
        $tabla.='{"nombre":"' . $row[1] . '","detalle":"' . $delete . '"},';
        $i++;
    }
    $tabla = substr($tabla, 0, strlen($tabla) - 1);
    echo '{"data":[' . $tabla . ']}';
}

if (isset($_POST["combo_tipo"])) {
    require("fun_sistema.php");
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();
    $consulta = "select * from tipo_vehi";
    mysqli_set_charset($conexion, "utf8");
    $registro = mysqli_query($conexion, $consulta);
    $opciones = " <option value=\"0\"> -- </option>";
    while ($rs = mysqli_fetch_array($registro)) {
        $opciones.='<option value="' . $rs[0] . '">' . $rs[1] . '</option>';
    }
    echo $opciones;
}

//verificar rut de chofer antes del boton registrar
if (isset($_POST['verificar_patente'])) {
    $patente = $_POST['verificar_patente'];
    require("fun_sistema.php");
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();
    $consulta = "select count(idvehiculo) as contador from vehiculo where patente='$patente';";
    mysqli_set_charset($conexion, "utf8");
    $registro = mysqli_query($conexion, $consulta);

    if ($row = mysqli_fetch_array($registro)) {
        echo '{"contador":' . $row['contador'] . '}';
    }
}


if (isset($_POST['extraerVehiculo'])) {
    $id = $_POST['extraerVehiculo'];
    require_once("fun_sistema.php");
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();
    $consulta = "select*from vistavehiculo where idvehiculo=" . $id . ";";
    mysqli_set_charset($conexion, "utf8");
    $registro = mysqli_query($conexion, $consulta);
    if ($registro) {
        while ($rs = mysqli_fetch_array($registro)) {
            $datos_array['idvehiculo'] = $rs[0];
            $datos_array['tipo_vehi_id'] = $rs[1];
            $datos_array['tipo_vehi_nombre'] = $rs[2];
            $datos_array['patente'] = $rs[3];
            $datos_array['descripcion'] = $rs[4];
            $datos_array['km'] = $rs[5];
            $datos_array['estado'] = $rs[6];
        }
        echo json_encode($datos_array);
    }
}

if (isset($_GET["eliminar_tipovehiculo"]) && isset($_POST["idtipovehiculo"])) {
    require_once("fun_sistema.php");
    $ad = new fun_sistema();
    $consulta = "call eliminartipovehiculo(".$_SESSION['idusuario'] ."," . $_POST["idtipovehiculo"] . ")";
    $conexion = $ad->Query($consulta);
}

if (isset($_POST["eliminar_vehiculo"])) {
    require_once("fun_sistema.php");
    $ad = new fun_sistema();
    $consulta = "call eliminarvehiculo(".$_SESSION['idusuario']."," . $_POST["eliminar_vehiculo"] . ")";
    $conexion = $ad->Query($consulta);
}
/*
if (isset($_GET["eliminar_tipovehsdficulo"]) && isset($_POST["idtipovehiculo"])) {
    require_once("fun_sistema.php");
    $ad = new fun_sistema();
    $consulta = "update chofer set estado=2 where idchofer=" . $_POST["idtipovehiculo"] . "";
    $conexion = $ad->Query($consulta);
}


//verificar nombre de usuario antes del boton registrar
if (isset($_POST['verificar_usuario'])) {
    $usuario_usuario = $_POST['verificar_usuario'];
    require("fun_sistema.php");
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();
    $consulta = "select count(idusuario) as contador from usuario where login='$usuario_usuario';";
    mysqli_set_charset($conexion, "utf8");
    $registro = mysqli_query($conexion, $consulta);

    if ($row = mysqli_fetch_array($registro)) {
        echo '{"contador":' . $row['contador'] . '}';
    }
}

//obtener empresas pertenecientes a un usuario para mostrarlas en su detalle
if (isset($_GET['usuario_empresa'])) {
    require("fun_sistema.php");
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();
    $consulta = "select*from vistaempusu where usuario=" . $_GET['usuario_empresa'] . " and estado=1 order by defecto desc";
    mysqli_set_charset($conexion, "utf8");
    $registro = mysqli_query($conexion, $consulta);
    $i = 0;
    $tabla = "";
    while ($row = mysqli_fetch_array($registro)) {
        $eliminar = "";
        $defecto = "";
        $def = $row['defecto'];
        if ($def == 1) {
            $defecto = "DEFECTO";
            $eliminar = '<button type=\"button\" class=\"btn btn-default disabled btn-block btn-xs\"><span class=\"fa fa-trash-o fa-fw\"></span> eliminar </button>';
        } else {
            $defecto = "";
            $eliminar = '<button type=\"button\" onclick=\"eliminarUsuEmp(' . $row['empresa'] . ')\" class=\"btn btn-danger btn-block btn-xs\"><span class=\"fa fa-trash-o fa-fw\"></span> eliminar </button>';
        }
        $tabla.='{"defecto":"' . $defecto . '","nombre":"' . $row['nombre'] . '","eliminar":"' . $eliminar . '"},';
        $i++;
    }
    $tabla = substr($tabla, 0, strlen($tabla) - 1);
    echo '{"data":[' . $tabla . ']}';
}
*/

/*
if (isset($_POST["idusuario_empresas"])) {
    require_once("fun_sistema.php");
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();
    $consulta = "select idempresa,nombre from empresa where estado=1 and idempresa not in(select empresa from usu_emp where usuario=" . $_POST["idusuario_empresas"] . ");";
    mysqli_set_charset($conexion, "utf8");

    $opciones = '<option value="0">Empresas disponibles</option>';
    $registro = mysqli_query($conexion, $consulta);
    while ($rs = mysqli_fetch_array($registro)) {
        $opciones.='<option value="' . $rs[0] . '">' . $rs[1] . '</option>';
    }
    echo $opciones;
}

if (isset($_POST["idusuario_empresas_defecto"])) {
    require_once("fun_sistema.php");
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();
    $consulta = "select idempresa,nombre from empresa where estado=1 and idempresa in(select empresa from usu_emp where usuario=" . $_POST["idusuario_empresas_defecto"] . ");";
    mysqli_set_charset($conexion, "utf8");
    $opciones = '';
    $registro = mysqli_query($conexion, $consulta);
    while ($rs = mysqli_fetch_array($registro)) {
        $opciones.='<option value="' . $rs[0] . '">' . $rs[1] . '</option>';
    }
    echo $opciones;
}
if (isset($_POST["usuario"]) && isset($_POST["empresa"])) {
    require_once("fun_sistema.php");
    $ad = new fun_sistema();
    $consulta = "insert into usu_emp(usuario,empresa,defecto) values(" . $_POST["usuario"] . "," . $_POST["empresa"] . ",0);";
    $conexion = $ad->Query($consulta);
}

if (isset($_POST["idusuario_estado"]) && isset($_POST["estado"])) {
    require_once("fun_sistema.php");
    $ad = new fun_sistema();
    $consulta = "update usuario set estado=" . $_POST["estado"] . " where idusuario=" . $_POST["idusuario_estado"] . "";
    $conexion = $ad->Query($consulta);
}
*/