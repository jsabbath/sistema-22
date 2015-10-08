<?php
if (isset($_SESSION['facturapdf'])) {
    require_once("../conection/fun_sistema.php");
    $ad = new fun_sistema();
    $sql = "select
            d.ndoc,
            d.tipo,
            d.fecha_doc,
            d.fecha_plazo,
            d.glosa,
            d.neto,
            d.iva,
            d.total,
            d.estado,
            c.rut as rut_clieprove,
            c.nombre as nombre_clieprove,
            c.giro_principal as giro_clieprove,
            c.direccion as direccion_clieprove,
            co.nombre as comuna_clieprove,
            c.fono as fono_clieprove,
            c.tipo as tipo_clieprove
            from documento d inner join clieprove c on d.clieprove=c.id inner join comuna co on c.comuna=co.idcomuna where iddocumento=" . $_SESSION['facturapdf'];

    $rawdata = $ad->getArraySQL($sql);
    if ($rawdata) {
        $ndoc = $rawdata[0]['ndoc'];
        $tipo = $rawdata[0]['tipo'];
        $fecha_doc = $rawdata[0]['fecha_doc'];
        $fecha_plazo = $rawdata[0]['fecha_plazo'];
        $glosa = $rawdata[0]['glosa'];
        $neto = $rawdata[0]['neto'];
        $iva = $rawdata[0]['iva'];
        $total = $rawdata[0]['total'];
        $estado = $rawdata[0]['estado'];
        $rut_clieprove = $rawdata[0]['rut_clieprove'];
        $nombre_clieprove = $rawdata[0]['nombre_clieprove'];
        $giro_clieprove = $rawdata[0]['giro_clieprove'];
        $direccion_clieprove = $rawdata[0]['direccion_clieprove'];
        $comuna_clieprove = $rawdata[0]['comuna_clieprove'];
        $fono_clieprove = $rawdata[0]['fono_clieprove'];
        $tipo_clieprove = $rawdata[0]['tipo_clieprove'];
    }

    if ($tipo == 1) {
        $tipo_factura = "COMPRA";
        $tipo_clieprove = "Proveedor";
    } else if ($tipo == 2) {
        $tipo_factura = "VENTA";
        $tipo_clieprove = "Cliente";
    }

    if ($estado == 1) {
        $estado_str = "Pendiente";
    } else if ($estado == 2) {
        $estado_str = "Pagado";
    }

    $fecha2 = date("d/m/Y", strtotime($fecha_doc));
    $fecha1 = date("d/m/Y", strtotime($fecha_plazo));

    $dias_plazo = $ad->dias_transcurridos($fecha1, $fecha2);
}
?>
<style type="text/css">
    <!--
    table { vertical-align: top; }
    tr    { vertical-align: top; height:20px;}
    td    { vertical-align: top; }
    .titulo{ text-align:left; background: #E7E7E7; font-size: 13pt; width: 30%;font-weight:lighter;}
    .proveedor{text-align:center; width:40%; font-size:10pt;}
    #documento2{ text-align:left; font-size:17pt;}

    .valor{width: 70%;font-size: 15pt;font-weight:lighter; text-align:left;}

    #tabla{width: 100%;  border: solid 1px black; border-radius:5px;}

    #documento{text-align:left; font-size:20pt;}
    #sub{text-align:left; font-size:14pt; font-weight:bold;}
    #glosa{width:100%;height:100px; border: 1px solid black; background: #E7E7E7; text-align:left; font-size:12pt;}
    -->
</style>
<page backcolor="#FEFEFE" backimgx="center" backimgy="bottom" backimgw="100%" backtop="0" backbottom="30mm" footer="date;heure;page" style="font-size: 12pt">
    <bookmark title="Lettre" level="0" ></bookmark>


    <table height="665" cellspacing="0" style="border: solid 1px black; border-radius:2px; width: 100%; text-align: center; font-size: 14px">
        <tr>
            <td height="32" id="documento5" >&nbsp;</td>
            <td width="10%" rowspan="4">
                <img src="<?php echo $_SESSION['empresa_def_logo'] ?>" alt="Logo" width="97%" height="173" style="width: 100%;" ></td>
        </tr>
        <tr>
            <td height="32" id="documento" ><b>FACTURA DE <?php echo $tipo_factura ?> Nº<?php echo $ndoc ?></b></td>
        </tr>
        <tr>
            <td height="24" id="sub" >Estado : <?php echo $estado_str; ?></td>
        </tr>
        <tr>
            <td width="90%" height="2"></td>
        </tr>
        <tr>
            <td style="width: 60%;"></td>
            <td class="proveedor"><b><?php echo $_SESSION['empresa_def_nom'] ?></b></td>
            <td></td>
        </tr>
        <tr>
            <td style="width: 100%;" colspan="2">


                <p>&nbsp;</p> 
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <th id="documento2">Datos <?php echo $tipo_clieprove ?></th>
                    </tr>
                </table>

                <table id="tabla">
                    <tr >
                        <th class="titulo">Rut</th>
                        <th class="valor"><?php echo $rut_clieprove ?></th>
                    </tr>
                    <br />
                    <tr >
                        <th class="titulo">Razon Social</th>
                        <th class="valor"><?php echo $nombre_clieprove ?></th>
                    </tr>
                    <br />
                    <tr>
                        <th class="titulo">Giro</th>
                        <td class="valor"><?php echo $giro_clieprove ?></td>
                    </tr>
                    <br />
                    <tr>
                        <th class="titulo">Direccion </th>
                        <td class="valor"><?php echo $direccion_clieprove ?></td>
                    </tr>
                    <br />
                    <tr>
                        <th scope="row" class="titulo">Fono</th>
                        <td class="valor"><?php echo $fono_clieprove ?></td>
                    </tr>     
                </table>
                <p>&nbsp;</p>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <th id="documento2">Detalle</th>
                    </tr>
                </table>
                <table id="tabla">
                    <tr >
                        <th class="titulo">Fecha Factura</th>
                        <th class="valor"><?php echo date("d/m/Y", strtotime($fecha_doc)); ?></th>
                    </tr>
                    <br />
                    <tr>
                        <th class="titulo">Dias </th>
                        <td class="valor"><?php echo $dias_plazo ?></td>
                    </tr>
                    <br />
                    <tr>
                        <th class="titulo">Fecha Plazo</th>
                        <td class="valor"><?php echo date("d/m/Y", strtotime($fecha_plazo)); ?></td>
                    </tr>
                    <br />
                    <tr>
                        <th scope="row" class="titulo">Neto</th>
                        <td class="valor"><?php echo "$" . number_format($neto, 0); ?></td>
                    </tr>
                    <br />
                    <tr>
                        <th class="titulo">Iva(19%)</th>
                        <td class="valor"><?php echo "$" . number_format($iva, 0); ?></td>
                    </tr>
                    <br />
                    <tr>
                        <th class="titulo">Total</th>
                        <td class="valor"><?php echo "$" . number_format($total, 0); ?></td>
                    </tr>
                </table> 
                <p>&nbsp;</p>

                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <th id="documento2">Glosa</th>
                    </tr>
                </table>           
                <textarea cols="75" id="glosa" readonly><?php echo $glosa; ?></textarea>

            </td>
        </tr>
    </table>
    <nobreak></nobreak>
</page>
