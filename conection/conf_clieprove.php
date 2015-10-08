<?php
session_start();
//obtener tabla de usuarios
if (isset($_GET['clieprove'])) {
    require("fun_sistema.php");
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();
    $consulta = "select id,rut,nombre,comuna,fono,giro,tipo,estado from vistaclieprove where tipo=" . $_GET['clieprove'] . " and estado=1;";
    mysqli_set_charset($conexion, "utf8");
    $registro = mysqli_query($conexion, $consulta);
    $i = 0;
    $tabla = "";
    while ($row = mysqli_fetch_array($registro)) {
        $estado = '';
        $detalle = '<button type=\"button\" onclick=\"detalleClieprove(' . $row['id'] . ')\" class=\"btn btn-info btn-block btn-xs\"><span class=\"fa fa-external-link fa-fw\"></span> detalle </button>';
        $tabla.='{"rut":"' . $row['rut'] . '","nombre":"' . $row['nombre'] . '","comuna":"' . $row['comuna'] . '","fono":"' . $row['fono'] . '","giro":"' . $row['giro'] . '","detalle":"' . $detalle . '"},';
        $i++;
    }
    $tabla = substr($tabla, 0, strlen($tabla) - 1);
    echo '{"data":[' . $tabla . ']}';
}
if (isset($_POST["combo_region"])) {
    require("fun_sistema.php");
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();
    $consulta = "select * from region";
    mysqli_set_charset($conexion, "utf8");
    $registro = mysqli_query($conexion, $consulta);
    $opciones = " <option value=\"0\"> -- </option>";
    while ($rs = mysqli_fetch_array($registro)) {
        $opciones.='<option value="' . $rs[0] . '">' . $rs[1] . '</option>';
    }
    echo $opciones;
}
if (isset($_POST["combo_empresas"])) {
    require_once("fun_sistema.php");
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();
    $consulta = "select idempresa,nombre from empresa where estado=1 and idempresa not in(select empresa from emp_clieprove where clieprove=". $_POST["combo_empresas"] .");";
    mysqli_set_charset($conexion, "utf8");
    $opciones = '<option value="0">Empresas disponibles</option>';
    $registro = mysqli_query($conexion, $consulta);
    while ($rs = mysqli_fetch_array($registro)) {
        $opciones.='<option value="' . $rs[0] . '">' . $rs[1] . '</option>';
    }
    echo $opciones;
}
if (isset($_POST["combo_provincia"])) {
    require("fun_sistema.php");
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();
    $consulta = "select*from provincia where idregion=" . $_POST["combo_provincia"];
    mysqli_set_charset($conexion, "utf8");
    $registro = mysqli_query($conexion, $consulta);
    $opciones = " <option value=\"0\"> -- </option>";
    while ($rs = mysqli_fetch_array($registro)) {
        $opciones.='<option value="' . $rs[0] . '">' . $rs[1] . '</option>';
    }
    echo $opciones;
}
if (isset($_POST["combo_provinciashow"])) {
    require("fun_sistema.php");
    echo $_POST["select"];
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();
    $consulta = "select*from provincia where idregion=" . $_POST["combo_provinciashow"];
    mysqli_set_charset($conexion, "utf8");
    $registro = mysqli_query($conexion, $consulta);
    $opciones = " <option value=\"0\"> -- </option>";
    while ($rs = mysqli_fetch_array($registro)) {
        if ($rs[0] == $_POST["select"]) {
            $opciones.='<option value="' . $rs[0] . '" selected>' . $rs[1] . '</option>';
        } else {
            $opciones.='<option value="' . $rs[0] . '">' . $rs[1] . '</option>';
        }
    }
    echo $opciones;
}
if (isset($_POST["combo_comuna"])) {
    require("fun_sistema.php");
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();
    $consulta = "select*from comuna where idprovincia=" . $_POST["combo_comuna"];
    mysqli_set_charset($conexion, "utf8");
    $registro = mysqli_query($conexion, $consulta);
    $opciones = " <option value=\"0\"> -- </option>";
    while ($rs = mysqli_fetch_array($registro)) {
        $opciones.='<option value="' . $rs[0] . '">' . $rs[1] . '</option>';
    }
    echo $opciones;
}
if (isset($_POST["combo_comunashow"])) {
    require("fun_sistema.php");
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();
    $consulta = "select*from comuna where idprovincia=" . $_POST["combo_comunashow"];
    mysqli_set_charset($conexion, "utf8");
    $registro = mysqli_query($conexion, $consulta);
    $opciones = " <option value=\"0\"> -- </option>";
    while ($rs = mysqli_fetch_array($registro)) {
        if ($rs[0] == $_POST["select"]) {
            $opciones.='<option value="' . $rs[0] . '" selected>' . $rs[1] . '</option>';
        } else {
            $opciones.='<option value="' . $rs[0] . '">' . $rs[1] . '</option>';
        }
    }
    echo $opciones;
}
if (isset($_POST['verificar_rut'])) {
    $rut_clieprove = $_POST['verificar_rut'];
    require("fun_sistema.php");
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();
    $consulta = "select count(rut) as contador from vistaclieprove where rut='$rut_clieprove'";
    mysqli_set_charset($conexion, "utf8");
    $registro = mysqli_query($conexion, $consulta);

    if ($row = mysqli_fetch_array($registro)) {
        echo '{"contador":' . $row['contador'] . '}';
    }
}
if (isset($_POST['extraerClieprove'])) {
    $id = $_POST['extraerClieprove'];
    require_once("fun_sistema.php");
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();
    $consulta = "select id,rut,nombre,giro,direccion,comuna_id,provincia_id,region_id,fono,tipo,estado from vistaclieprove where id=" . $id . ";";
    mysqli_set_charset($conexion, "utf8");
    $registro = mysqli_query($conexion, $consulta);
    if ($registro) {
        while ($rs = mysqli_fetch_array($registro)) {

            $datos_array['id'] = $rs[0];
            $datos_array['rut'] = $rs[1];
            $datos_array['nombre'] = $rs[2];
            $datos_array['giro'] = $rs[3];
            $datos_array['direccion'] = $rs[4];
            $datos_array['comuna_id'] = $rs[5];
            $datos_array['provincia_id'] = $rs[6];
            $datos_array['region_id'] = $rs[7];
            $datos_array['fono'] = $rs[8];
            $datos_array['tipo'] = $rs[9];
            $datos_array['estado'] = $rs[10];
        }
        echo json_encode($datos_array);
    }
}
if (isset($_GET['clieprove_empresa'])) {
    require("fun_sistema.php");
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();
    $consulta = "select*from vistaempclieprove where clieprove=" . $_GET['clieprove_empresa'] . " and estado=1 order by defecto desc";
    mysqli_set_charset($conexion, "utf8");
    $registro = mysqli_query($conexion, $consulta);
    $i = 0;
    $tabla = "";
    while ($row = mysqli_fetch_array($registro)) {
        $eliminar = '<button type=\"button\" onclick=\"eliminarEmpclieprove(' . $row['empresa'] . ')\" class=\"btn btn-danger btn-block btn-xs\"><span class=\"fa fa-trash-o fa-fw\"></span> eliminar </button>';
        $tabla.='{"nombre":"' . $row['nombre'] . '","eliminar":"' . $eliminar . '"},';
        $i++;
    }
    $tabla = substr($tabla, 0, strlen($tabla) - 1);
    echo '{"data":[' . $tabla . ']}';
}
if (isset($_POST["clieprove"]) && isset($_POST["empresa"])) {
    require_once("fun_sistema.php");
    $ad = new fun_sistema();
    $consulta = "insert into emp_clieprove(empresa,clieprove) values(" . $_POST["empresa"] . "," . $_POST["clieprove"] . ");";
    $conexion = $ad->Query($consulta);
}
if (isset($_POST["eli_clieprove"]) && isset($_POST["eli_empresa"])) {
    require_once("fun_sistema.php");
    $ad = new fun_sistema();
    echo $consulta = "delete from emp_clieprove where empresa=" . $_POST["eli_empresa"] . " and clieprove=" . $_POST["eli_clieprove"] . ";";
    $conexion = $ad->Query($consulta);
}
if (isset($_POST["idclieprove_estado"]) && isset($_POST["estado"])) {
    require_once("fun_sistema.php");
    $ad = new fun_sistema();
    $consulta = "update clieprove set estado=".$_POST["estado"]." where id=".$_POST["idclieprove_estado"]."";
    $conexion = $ad->Query($consulta);
}