<?php

if (isset($_POST["combo_tipo"])) {
    require_once("fun_sistema.php");
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();
    $consulta = "select*from tipo_vehi;";
    mysqli_set_charset($conexion, "utf8");

    $registro = mysqli_query($conexion, $consulta);
    $opciones = '<option value="0" selected> -- </option>';
    while ($rs = mysqli_fetch_array($registro)) {
        $opciones.='<option value="' . $rs[0] . '">' . $rs[1] . '</option>';
    }
    echo $opciones;
}

if (isset($_POST["combo_vehi"]) && isset($_POST["tipo_vehi"]) && isset($_POST["select"])) {
    require_once("fun_sistema.php");
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();
    $consulta = "select idvehiculo,patente from vehiculo where tipo_vehi=" . $_POST["tipo_vehi"]." and estado=1 and idvehiculo!=1";
    mysqli_set_charset($conexion, "utf8");

    $registro = mysqli_query($conexion, $consulta);
    $opciones = '<option value="0"> -- </option>';
    while ($rs = mysqli_fetch_array($registro)) {
        if ($rs[0] == $_POST["select"]) {
            $opciones.='<option value="' . $rs[0] . '" selected>' . $rs[1] . '</option>';
        } else {
            $opciones.='<option value="' . $rs[0] . '">' . $rs[1] . '</option>';
        }
    }
    echo $opciones;
}

if (isset($_POST["combo_chofer"])) {
    require_once("fun_sistema.php");
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();
    $consulta = "select idchofer,nombre from chofer";
    mysqli_set_charset($conexion, "utf8");

    $registro = mysqli_query($conexion, $consulta);
    $opciones = '<option value="0" selected> -- </option>';
    while ($rs = mysqli_fetch_array($registro)) {
        $opciones.='<option value="' . $rs[0] . '">' . $rs[1] . '</option>';
    }
    echo $opciones;
}


if (isset($_POST["combo_clasi"])) {
    require_once("fun_sistema.php");
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();
    $consulta = "select*from clasificacion;";
    mysqli_set_charset($conexion, "utf8");

    $registro = mysqli_query($conexion, $consulta);
    $opciones = '<option value="0" selected> -- </option>';
    while ($rs = mysqli_fetch_array($registro)) {
        $opciones.='<option value="' . $rs[0] . '">' . $rs[1] . '</option>';
    }
    echo $opciones;
}

if (isset($_POST["vehiculo"])) {
    $idvehiculo = $_POST["vehiculo"];
    if ($idvehiculo != 0) {
        require_once("fun_sistema.php");
        $ad = new fun_sistema();
        $conexion = $ad->conectarBD();
        $consulta = "select*from vehiculo where idvehiculo='$idvehiculo'";
        mysqli_set_charset($conexion, "utf8");
        $registro = mysqli_query($conexion, $consulta);
        if ($registro) {
            while ($rs = mysqli_fetch_array($registro)) {
                $datos_array['idvehiculo'] = $rs[0];
                $datos_array['tipo_vehi'] = $rs[1];
                $datos_array['patente'] = $rs[2];
                $datos_array['descripcion'] = $rs[3];
                $datos_array['km'] = $rs[4];
            }
            echo json_encode($datos_array);
        }
    }
}

if (isset($_GET["idvehi"]) && isset($_GET["limite"])) {
    $idvehiculo = $_GET["idvehi"];

    require_once("fun_sistema.php");
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();
    $consulta = "select * from vistaplanilla where vehiculo_id=$idvehiculo order by idplanilla desc limit 0,2;";
    mysqli_set_charset($conexion, "utf8");
    $registro = mysqli_query($conexion, $consulta);
    $i = 0;
    $tabla = "";

    while ($row = mysqli_fetch_array($registro)) {
        $view = '<button onclick=\"detallearchivo(' . $row['idplanilla'] . ')\" class=\"btn btn-success btn-block btn-xs\" id=\"btn_modal\" name=\"btn_modal\">Detalle </button>';
        $tabla.='{"fecha":"' . date("d/m/Y", strtotime($row['fecha'])) . '","chofer":"' . $row['chofer_nombre'] . '","km":"' . $row['km'] . '","lt":"' . $row['lt'] . '","rendimiento":"' . floatval($row['rendimiento']) . '","detalle":"' . $view . '"},';
        $i++;
    }
    $tabla = substr($tabla, 0, strlen($tabla) - 1);

    echo '{"data":[' . $tabla . ']}';
}

if (isset($_GET["idvehi"]) && isset($_GET["modal"])) {
    $idvehiculo = $_GET["idvehi"];

    require_once("fun_sistema.php");
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();
    $consulta = "select fecha,chofer_nombre,clasificacion_nombre,km,lt,rendimiento,obs from vistaplanilla where vehiculo_id=$idvehiculo order by idplanilla desc;";
    
    mysqli_set_charset($conexion, "utf8");
    $registro = mysqli_query($conexion, $consulta);
    $i = 0;
    $tabla = "";
    if($registro){
    while ($row = mysqli_fetch_array($registro)) {
        $tabla.='{"fecha":"' . date("d/m/Y", strtotime($row['fecha'])) . '","chofer":"' . $row['chofer_nombre'] . '","class":"' . $row['clasificacion_nombre'] . '","km":"' . $row['km'] . '","lt":"' . $row['lt'] . '","rendi":"' . $row['rendimiento'] . '","obs":"' . $row['obs'] . '"},';
        $i++;
    }
    $tabla = substr($tabla, 0, strlen($tabla) - 1);

    echo '{"data":[' . $tabla . ']}';
    }
}

