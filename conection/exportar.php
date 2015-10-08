<?php
require_once("../pages/template/cabecera.php");

if (isset($_POST["id_fact"])) {
    //Incluimos la librería
    require_once '../dist/html2pdf_v4.03/html2pdf.class.php';
    //Recogemos el contenido de la vista
    ob_start();
    
    $_SESSION['facturapdf']=$_POST["id_fact"];
    require_once '../reporte/facturapdf.php';
    $html = ob_get_clean();

    //Pasamos esa vista a PDF
    //Le indicamos el tipo de hoja y la codificación de caracteres
    $mipdf = new HTML2PDF('P', 'Letter', 'es', 'true', 'UTF-8');

    //Escribimos el contenido en el PDF
    $mipdf->writeHTML($html);

    //Generamos el PDF
    $mipdf->Output('factura_'.$_POST["num_fact"].'.pdf','P');
}
?>
