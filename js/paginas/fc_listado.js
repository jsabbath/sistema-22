function recargar() {
    $('#tabla_facturas').dataTable().fnDestroy();
    listar($("#combo_proveedor").val(), $("#listado_tipo").val());
}

function listar(proveedor, estado) {
    $('#tabla_facturas').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    });
    $('#tabla_facturas').dataTable({
        "ajax": "../conection/fc_listado.php?&idprove=" + proveedor + "&estado=" + estado,
        "columns": [
            {"data": "check"},
            {"data": "ndoc"},
            {"data": "clieprove_nombre"},
            {"data": "total", sClass: "alignRight"},
            {"data": "fecha_doc"},
            {"data": "fecha_plazo"},
            {"data": "usuario_reg_nombre"},
            {"data": "estado"},
            {"data": "detalle"}
        ],
        "language": {
            "url": "../js/dataTable_es.txt"
        },
//        "sDom": 'Tlfrtip',
//        "oTableTools": {
//        },
        "order": [[7, "asc"]]
    });
}



function abrirFacturaListado(idfact,numero, prove) {
    window.location = "fc_detalle.php?idfact="+idfact+"&fact=" + numero + "&prove=" + prove;
}

$(function () {
    $('.selectpicker').on('change', function () {
        var idprove = $(this).find("option:selected").attr("value");
        //cambiarWhere(idprove, 1);
    });
});

var ides = "";
$('#pago').click(function () {
    var ids;

    ids = $('input[type=checkbox]:checked').map(function () {
        return $(this).attr('id');
    }).get();

    ides = ids.join(',');
    if (ides !== "") {
        pagar(ides);
    }

});

function pagar(array) {

    //location.href = 'fc_egreso.php?fact=' + array;
    var parametros = {
        facturas: array
    };

    if (parametros) {
        var post = $.post("../conection/fc_new_egreso.php", parametros, redireccionar, 'json');
        post.error(null);
    }

}
function redireccionar(r) {
    if (r.estado == 1) {
        location.href = 'fc_new_egreso.php';
    }else{
        $('#error_listaFacturas').modal("show");
    }
}

