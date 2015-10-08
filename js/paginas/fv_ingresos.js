$(document).ready(function () {
    var d = new Date();
    var month = d.getMonth() + 1;
    var year = d.getFullYear();
    $('#ingresos_combo_mes').val(month);
    $('#ingresos_combo_ano').val(year);
});
function ListarDatos() {
    $('#listado_ingresos').dataTable().fnDestroy();
    var mes = $('#ingresos_combo_mes').val();
    var ano = $('#ingresos_combo_ano').val();
    var clieprove = $('#combo_proveedor').val();
    $('#listado_ingresos').dataTable({
        "ajax": "../conection/fv_ingresos.php?mes="+mes+"&ano="+ano+"&clieprove="+clieprove,
        "columns": [
            {"data": "check"},
            {"data": "correlativo"},
            {"data": "clieprove"},
            {"data": "fecha_pago"},
            {"data": "total"},
            {"data": "detalle"},
            {"data": "pdf"}
        ],
        "pageLength": 7,
        "bLengthChange": true,
        "bPaginate": true,
        "bFilter": true,
        "bSort": true,
        "language": {
            "url": "../js/dataTable_es.txt"
        }
    });
    // "order": [[4, "desc"]],
}

function detalleIngreso(corre){
    location.href = "fv_ingreso_detalle.php?corre_in="+corre;
}
