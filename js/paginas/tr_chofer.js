$(document).ready(function () {
    $('#tabla_chofer').dataTable({
        "ajax": "../conection/tr_chofer.php?chofer=1",
        "columns": [
            {"data": "rut"},
            {"data": "nombre"},
            {"data": "codigo"},
            {"data": "patente"},
            {"data": "clasificacion"}
        ],
        "language": {
            "url": "../js/dataTable_es.txt"
        },
        "bPaginate": true,
        "bFilter": true,
        "bSort": true,
        "bInfo": true,
//        "sDom": 'Tlfrtip',
//        "oTableTools": {
//        }
    });
});

    