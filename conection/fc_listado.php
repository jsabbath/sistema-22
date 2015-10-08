<?php

if (isset($_GET['idprove']) && isset($_GET['estado'])) {
    session_start();
    $idprove = $_GET['idprove'];
    $estado = $_GET['estado'];
    $idempresa = $_SESSION['empresa_def_id'];
    
    require("fun_sistema.php");
    $ad = new fun_sistema();

    $conexion = $ad->conectarBD();

    $sqlprove = ($idprove == 0) ? "" : "clieprove_id=$idprove and ";
    $sqlestado = ($estado == 0) ? "estado!=3" : "estado=$estado";
    $consulta = "select * from vistafactura where tipo=1 and ($sqlprove $sqlestado) and clieprove_id in(select clieprove from emp_clieprove where empresa=$idempresa ) order by fecha_plazo";
    mysqli_set_charset($conexion, "utf8");
    $registro = mysqli_query($conexion, $consulta);

    $i = 0;
    $tabla = "";
    //1 pendiente, 2 pagada , 3 eliminada
    while ($row = mysqli_fetch_array($registro)) {
        $boton = "";
        $check = "";
        $estado = "";
        $estado_pago = $row['estado'];
        //deshabilitar check box dependiendo del estado
        if ($estado_pago == 1) {
            $check = "<input name='" . $row['iddocumento'] . "' id='" . $row['iddocumento'] . "' type='checkbox' >";
        } else if ($row['estado'] == 2) {
            $check = "<input type='checkbox' disabled>";
        }
   
        
        //setear fecha en el formato usuario
        $fecha_doc = date("d/m/Y", strtotime($row['fecha_doc']));
        $fecha_plazo = date("d/m/Y", strtotime($row['fecha_plazo']));

        if ($estado_pago != 2) {
            //calcular dias de plazo para las facturas y setear el color 
            $dias = $ad->dias_transcurridos($fecha_plazo, date("d/m/Y"));

            if ($dias < 0) {
                $estado = "<button type=button class='btn btn-danger btn-block btn-xs' data-toggle=tooltip data-placement=top title='' data-original-title='$dias dias pasado'>$dias</button>";
            } else if ($dias == 0) {
                $estado = "<button type=button class='btn btn-danger btn-block btn-xs' data-toggle=tooltip data-placement=top title='' data-original-title='Vence Hoy!'>$dias</button>";
            } else if ($dias < 1) {
                $estado = "<button type=button class='btn btn-warning btn-block btn-xs' data-toggle=tooltip data-placement=top title='' data-original-title='$dias dia(s) para vencer'>$dias</button>";
            } else if ($dias < 30) {
                $estado = "<button type=button class='btn btn-info btn-block btn-xs' data-toggle=tooltip data-placement=top title='' data-original-title='$dias dia(s) para vencer'>$dias</button>";
            } else {
                $estado = "<button type=button class='btn btn-success btn-block btn-xs' data-toggle=tooltip data-placement=top title='' data-original-title='$dias dia(s) para vencer'>$dias</button>";
            }
        } else if ($estado_pago == 2) {
            $estado = "<button type=button class='btn btn-default btn-block btn-xs' data-toggle=tooltip data-placement=top title='' data-original-title='fecha de pago : " . date("d/m/Y", strtotime($row['pago_fecha'])) . "'>Pagado</button>";
        }

        $detalle = "<button onclick=abrirFacturaListado(" . $row['iddocumento'] . "," . $row['ndoc'] . ",'" . $row['clieprove_id'] . "') class='btn btn-success btn-block btn-xs' id=btn_detalle name=btn_detalle>Detalle </button>";
        $tabla.='{"check":"' . $check . '","ndoc":"' . $row['ndoc'] . '","clieprove_nombre":"' . $row['clieprove_nombre'] . '","total":"' . "$" . number_format($row['total'], 0) . '","fecha_doc":"' . $fecha_doc . '","fecha_plazo":"' . $fecha_plazo . '","usuario_reg_nombre":"' . $row['usuario_reg_nombre'] . '","detalle":"' . $detalle . '","estado":"' . $estado . '"},';

        $i++;
    }
    $tabla = substr($tabla, 0, strlen($tabla) - 1);

    echo '{"data":[' . $tabla . ']}';
}

