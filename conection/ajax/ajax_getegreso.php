<?php
session_start();
if (isset($_POST['corre_egreso'])) {
    $corre_egreso = $_POST['corre_egreso'];

    require_once("../fun_sistema.php");
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();
    $consulta = "select * from vistapagos where correlativo=$corre_egreso and tipo=1";
    mysqli_set_charset($conexion, "utf8");
    $registro = mysqli_query($conexion, $consulta);
    $filas = mysqli_num_rows($registro);
    if ($filas) {
        while ($rs = mysqli_fetch_array($registro)) {
            $datos_array['idpago'] = $rs[0];
            $_SESSION['eg_adjunto_idegreso'] = $rs[0];
            $datos_array['usuario_id'] = $rs[1];
            $datos_array['usuario_nombre'] = $rs[2];
            $datos_array['clieprove_id'] = $rs[3];
            $datos_array['clieprove_nombre'] = $rs[4];
            $datos_array['forma_pago_id'] = $rs[5];
            $datos_array['forma_pago_nombre'] = $rs[6];
            $datos_array['documento_pago'] = $rs[7];
            $datos_array['fecha_pago'] = $rs[8];
            $datos_array['glosa'] = $rs[9];
            $datos_array['total_pago'] = "$" . number_format($rs[10]);
            $datos_array['correlativo'] = $rs[11];
            $datos_array['tipo'] = $rs[12];
            $datos_array['estado'] = $rs[13];
        }
        echo json_encode($datos_array);
    } else {
        echo '{"estado":0}';
    }
}
if (isset($_GET['corre_facturas'])) {
    $corre_facturas = $_GET['corre_facturas'];

    require("../fun_sistema.php");
    $ad = new fun_sistema();

    $conexion = $ad->conectarBD();
    //Creamos la consulta
    $consulta = "call pagodetallefacturas($corre_facturas,1)";
    //obtenemos los registros de la consulta
    mysqli_set_charset($conexion, "utf8");
    $registro = mysqli_query($conexion, $consulta);
    //obtenemos el array con toda la información
    $i = 0;
    $tabla = "";
    $neto=0;
    $iva=0;
    $total=0;
    while ($row = mysqli_fetch_array($registro)) {
        $view = '<button onclick=\"abrirFactura(' . $row['iddocumento'] . ','.  $row['ndoc'] .','.  $row['clieprove'] .')\" class=\"btn btn-info btn-block btn-xs\" id=\"btn_modal\" name=\"btn_modal\"><span class=\"fa fa-external-link fa-fw\"></span></button>';
        $tabla.='{"detalle":"' . $view . '","ndoc":"' . $row['ndoc'] . '","neto":"' . "$" . number_format($row['neto']) . '","iva":"' . "$" . number_format($row['iva']) . '","total":"' . "$" . number_format($row['total']) . '"},';
        $i++;
        $neto = $neto+ $row['neto'];
        $iva = $iva+ $row['iva'];
        $total = $total+ $row['total'];
    }
    $tabla.='{"detalle":"<b>TOTALES</b>","fecha":"","ndoc":"","neto":"<b>' . "$" . number_format($neto) . '</b>","iva":"<b>' . "$" . number_format($iva) . '</b>","total":"<b>' . "$" . number_format($total) . '</b>"},';
    $tabla = substr($tabla, 0, strlen($tabla) - 1);

    echo '{"data":[' . $tabla . ']}';
}

if (isset($_GET['idpago_adjunto'])) {
    $idpago_adjunto = $_GET['idpago_adjunto'];

    require("../fun_sistema.php");
    $ad = new fun_sistema();

    $conexion = $ad->conectarBD();

    //Creamos la consulta
    $consulta = "select * from vistaarchivo where idpadre=$idpago_adjunto and (tabla_padre='eg' and estado=1);";
    //obtenemos los registros de la consulta
    mysqli_set_charset($conexion, "utf8");
    $registro = mysqli_query($conexion, $consulta);
    //obtenemos el array con toda la información
    $i = 0;
    $tabla = "";

    while ($row = mysqli_fetch_array($registro)) {
        $view = '<button onclick=\"detallearchivo(' . $row['idadjunto'] . ')\" class=\"btn btn-success btn-block btn-xs\" id=\"btn_modal\" name=\"btn_modal\">Detalle </button>';
        $tabla.='{"tipo":"' . $row['archivo_tipo'] . '","archivo":"' . substr($row['archivo'], 0, 14) . '","fecha":"' . date("d/m/Y", strtotime($row['fecha'])) . '","detalle":"' . $view . '"},';
        $i++;
    }
    $tabla = substr($tabla, 0, strlen($tabla) - 1);

    echo '{"data":[' . $tabla . ']}';
}

if (isset($_POST["combo_tipo"]) && isset($_POST["select"])) {
    require_once("../fun_sistema.php");
    $ad = new fun_sistema();
    $conexion = $ad->conectarBD();
    $consulta = "select * from tipo_pago";
    mysqli_set_charset($conexion, "utf8");
    $registro = mysqli_query($conexion, $consulta);
    $opciones="";
    while ($rs = mysqli_fetch_array($registro)) {
        if ($rs[0] == $_POST["select"]) {
            $opciones.='<option value="' . $rs[0] . '" selected>' . $rs[1] . '</option>';
        } else {
            $opciones.='<option value="' . $rs[0] . '">' . $rs[1] . '</option>';
        }
    }
    echo $opciones;
}



?>