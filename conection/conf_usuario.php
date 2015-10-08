<?php

//obtener tabla de usuarios
if (isset($_GET['usuarios'])) {
    require("fun_sistema.php");
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();
    $consulta = "select*from vistausuario where usuario_estado!=3;";
    mysqli_set_charset($conexion, "utf8");
    $registro = mysqli_query($conexion, $consulta);
    $i = 0;
    $tabla = "";
    while ($row = mysqli_fetch_array($registro)) {
        $estado = '';
        $detalle = '<button type=\"button\" onclick=\"detalleUsuario(' . $row['idusuario'] . ')\" class=\"btn btn-info btn-block btn-xs\"><span class=\"fa fa-external-link fa-fw\"></span> detalle </button>';
        if ($row['usuario_estado'] == 1) {
            $estado = '<button type=\"button\" class=\"btn btn-success disabled btn-block btn-xs\"> Activo </button>';
        } else {
            $estado = '<button type=\"button\" class=\"btn btn-danger  disabled btn-block btn-xs\"> Inactivo </button>';
        }
        $tabla.='{"usuario":"' . $row['usuario_login'] . '","nombre":"' . $row['usuario_nombre'] . '","perfil":"' . $row['usuario_rol_nombre'] . '","detalle":"' . $detalle . '","estado":"' . $estado . '"},';
        $i++;
    }
    $tabla = substr($tabla, 0, strlen($tabla) - 1);
    echo '{"data":[' . $tabla . ']}';
}

//obtener tabla de roles
if (isset($_GET['perfiles'])) {
    require("fun_sistema.php");
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();
    $consulta = "select idrol,nombre from rol;";
    mysqli_set_charset($conexion, "utf8");
    $registro = mysqli_query($conexion, $consulta);
    $i = 0;
    $tabla = "";
    while ($row = mysqli_fetch_array($registro)) {

        $detalle = '<button type=\"button\" onclick=\"detallePerfil(' . $row['idrol'] . ')\" class=\"btn btn-info btn-block btn-xs\"><span class=\"fa fa-external-link fa-fw\"></span> detalle </button>';
        $tabla.='{"nombre":"' . $row['nombre'] . '","detalle":"' . $detalle . '"},';
        $i++;
    }
    $tabla = substr($tabla, 0, strlen($tabla) - 1);
    echo '{"data":[' . $tabla . ']}';
}

//verificar rut de usuario antes del boton registrar
if (isset($_POST['verificar_rut'])) {
    $rut_usuario = $_POST['verificar_rut'];
    require("fun_sistema.php");
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();
    $consulta = "select count(idusuario) as contador from usuario where rut='$rut_usuario';";
    mysqli_set_charset($conexion, "utf8");
    $registro = mysqli_query($conexion, $consulta);

    if ($row = mysqli_fetch_array($registro)) {
        echo '{"contador":' . $row['contador'] . '}';
    }
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

if (isset($_POST['idusuario_detalle'])) {
    $id = $_POST['idusuario_detalle'];
    require_once("fun_sistema.php");
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();
    $consulta = "select*from vistausuario where idusuario=" . $id . "";
    mysqli_set_charset($conexion, "utf8");
    $registro = mysqli_query($conexion, $consulta);
    if ($registro) {
        while ($rs = mysqli_fetch_array($registro)) {

            $datos_array['idusuario'] = $rs[0];
            $datos_array['usuario_rut'] = $rs[1];
            $datos_array['usuario_nombre'] = $rs[2];
            $datos_array['usuario_login'] = $rs[3];
            $datos_array['usuario_pass'] = $rs[4];
            $datos_array['usuario_correo'] = $rs[5];
            $datos_array['usuario_fono'] = $rs[6];
            $datos_array['usuario_rol_id'] = $rs[7];
            $datos_array['usuario_rol_nombre'] = $rs[8];
            $datos_array['usuario_estado'] = $rs[9];
            $datos_array['empresa_id'] = $rs[10];
            $datos_array['empresa_nombre'] = $rs[11];
        }
        echo json_encode($datos_array);
    }
}

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

if (isset($_POST["eli_usuario"]) && isset($_POST["eli_empresa"])) {
    require_once("fun_sistema.php");
    $ad = new fun_sistema();
    $consulta = "delete from usu_emp where empresa=" . $_POST["eli_empresa"] . " and usuario=" . $_POST["eli_usuario"] . ";";
    $conexion = $ad->Query($consulta);
}
if (isset($_POST["idusuario_estado"]) && isset($_POST["estado"])) {
    require_once("fun_sistema.php");
    $ad = new fun_sistema();
    $consulta = "update usuario set estado=".$_POST["estado"]." where idusuario=".$_POST["idusuario_estado"]."";
    $conexion = $ad->Query($consulta);
}
