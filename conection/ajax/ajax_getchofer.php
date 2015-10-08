<?php

if (isset($_POST['consulta'])) {
    $query = $_POST['consulta'];
    require_once("../fun_sistema.php");
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();
    $consulta = "select*from vistachofer where estado=1 and codigo='$query'";
    mysqli_set_charset($conexion, "utf8");
    $registro = mysqli_query($conexion, $consulta);
    if ($registro) {
        while ($rs = mysqli_fetch_array($registro)) {
            $datos_array['idchofer'] = $rs[0];
            $datos_array['rut'] = $rs[1];
            $datos_array['nombre'] = $rs[2];
            $datos_array['estado'] = $rs[3];
            $datos_array['codigo'] = $rs[4];
            $datos_array['clasificacion'] = $rs[5];
            $datos_array['clasificacion_nombre'] = $rs[6];
            $datos_array['vehiculo'] = $rs[7];
            $datos_array['tipo_vehiculo'] = $rs[8];
            $datos_array['patente'] = $rs[9];
            $datos_array['descripcion'] = $rs[10];
            $datos_array['km'] = $rs[11];
        }
        echo json_encode($datos_array);
    }
}