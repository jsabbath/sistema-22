$("#btn_listar_historial").click(function () {
    ListarDatos();
});
$("#btn_clean").click(function () {
    $('#fecha_desde').val("");
    $('#fecha_hasta').val("");
});
function ListarDatos() {
    $('#tabla_historial').dataTable().fnDestroy();
    var desde = $('#fecha_desde').val();
    var hasta = $('#fecha_hasta').val();
    var accion = $('#accion').val();
    var usuario = $('#usuario').val();
    $('#tabla_historial').dataTable({
        "ajax": "../conection/rep_historial.php?desde=" + desde + "&hasta=" + hasta +"&accion="+accion+"&usuario="+usuario,
        "columns": [
            {"data": "fecha"},
            {"data": "accion"},
            {"data": "afectado"},
            {"data": "usuario"},
            {"data": "descripcion"},
            {"data": "detalle"}
        ],

        "language": {
            "url": "../js/dataTable_es.txt"
        },
        "order": [[0, "desc"]]
    });
    // ",
}


