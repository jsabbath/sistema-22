<?php

if (isset($_POST['rut']) && isset($_POST['tipo']) && isset($_POST['idemp'])) {
    $idemp = $_POST['idemp'];
    $rut_clieprove = $_POST['rut'];
    $tipo_clieprove = $_POST['tipo'];

    require_once("../fun_sistema.php");
    $ad = new fun_sistema();

    $conexion = $ad->conectarBD();   //     id empresa,rut emp,tipo,estado ---tipo= 1 proveedor, 2 cliente
    $consulta = "call verificarEmpClieprove($idemp,'$rut_clieprove',$tipo_clieprove,1);";
    mysqli_set_charset($conexion, "utf8");
    $registro = mysqli_query($conexion, $consulta);
    //si hay registro se inicia el while
    if ($registro) {
        while ($rs = mysqli_fetch_array($registro)) {
            $datos_array['id'] = $rs[0];
            $datos_array['rut'] = $rs[1];
            $datos_array['nombre'] = $rs[2];
            $datos_array['giro'] = $rs[3];
            $datos_array['direccion'] = $rs[4];
            $datos_array['comuna'] = $rs[5];
            $datos_array['provincia'] = $rs[6];
            $datos_array['region'] = $rs[7];
            $datos_array['fono'] = $rs[8];
            $datos_array['fecha_mod'] = $rs[9];
            $datos_array['tipo'] = $rs[10];
            $datos_array['estado'] = $rs[11];
        }
        echo json_encode($datos_array);
    } else {
        echo '{"estado":0}';
    }
}
?>