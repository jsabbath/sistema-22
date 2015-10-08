$(document).ready(function () {
    var d = new Date();
    var month = d.getMonth() + 1;
    var year = d.getFullYear();
    $('#egresos_combo_mes').val(month);
    $('#egresos_combo_ano').val(year);
});

function ListarDatosEgresos() {
    $('#listado_egresos').dataTable().fnDestroy();
    var mes = $('#egresos_combo_mes').val();
    var ano = $('#egresos_combo_ano').val();
    var clieprove = $('#combo_proveedor').val();
    $('#listado_egresos').dataTable({
        "ajax": "../conection/fc_egresos.php?mes=" + mes + "&ano=" + ano + "&clieprove=" + clieprove,
        "columns": [
            {"data": "check"},
            {"data": "correlativo"},
            {"data": "clieprove"},
            {"data": "fecha_pago"},
            {"data": "total"},
            {"data": "detalle"},
            {"data": "pdf"}
        ],
        "language": {
            "url": "../js/dataTable_es.txt"
        },
        //"sDom": 'Tlfrtip',
        "oTableTools": {
        }
    });
    // "order": [[4, "desc"]],
}

function detalleEgreso(corre) {
    location.href = "fc_egreso_detalle.php?corre_eg=" + corre;
}
