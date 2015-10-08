<?php

if (isset($_POST['numfact_detalle']) && isset($_POST['idprove'])) {
    $factura = $_POST['numfact_detalle'];
    $rut_prov = $_POST['idprove'];

    require_once("../fun_sistema.php");
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();
    $consulta = "select iddocumento,fecha_doc,fecha_plazo,clieprove_nombre,neto,iva,total,glosa,estado from vistafactura where ndoc='$factura' and clieprove_id='$rut_prov'";
    mysqli_set_charset($conexion, "utf8");
    $registro = mysqli_query($conexion, $consulta);
    $filas = mysqli_num_rows($registro);
    if ($filas) {
        while ($rs = mysqli_fetch_array($registro)) {
            $datos_array['iddocumento'] = $rs[0];
            $datos_array['fecha_doc'] = $rs[1];
            $datos_array['fecha_plazo'] = $rs[2];
            $datos_array['clieprove_nombre'] = $rs[3];
            $datos_array['neto'] =  number_format($rs[4]);
            $datos_array['iva'] =  number_format($rs[5]);
            $datos_array['total'] =  number_format($rs[6]);
            $datos_array['glosa'] = $rs[7];
            $datos_array['estado'] = $rs[8];
        }
        echo json_encode($datos_array);
    } else {
        echo '{"estado":0}';
    }
}
if (isset($_POST['numfact']) && isset($_POST['idprove'])) {
    $factura = $_POST['numfact'];
    $rut_prov = $_POST['idprove'];

    require_once("../fun_sistema.php");
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();
    $consulta = "select * from vistafactura where ndoc='$factura' and clieprove_id='$rut_prov';";
    mysqli_set_charset($conexion, "utf8");
    $registro = mysqli_query($conexion, $consulta);
    $filas = mysqli_num_rows($registro);
    if ($filas) {
        echo '{"dato":1}';
    } else {
        echo '{"dato":0}';
    }
}
if (isset($_POST['correlativo_factura']) && isset($_GET['tipo_doc'])) {
    $correlativo = $_POST['correlativo_factura'];
    $tipo_doc = $_GET['tipo_doc']; //ingreso o egreso para diferenciar el correlativo

    require_once("../fun_sistema.php");
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();
    $consulta = "select correlativo from pago p inner join pago_detalle pd on p.idpago=pd.pago where pd.documento=$correlativo and p.tipo=$tipo_doc;";
    mysqli_set_charset($conexion, "utf8");
    $registro = mysqli_query($conexion, $consulta);
    $filas = mysqli_num_rows($registro);
    if ($filas) {
        if ($rs = mysqli_fetch_array($registro)) {
            echo $rs[0];
        }
    } else {
        echo '{"dato":0}';
    }
}
?>