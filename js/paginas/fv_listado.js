function recargarFv() {
    $('#tabla_facturasFv').dataTable().fnDestroy();
    listar($("#combo_proveedor").val(), $("#listado_tipo").val());
}

function listar(proveedor, estado) {
    $('#tabla_facturasFv').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    });
    $('#tabla_facturasFv').dataTable({
        "ajax": "../conection/fv_listado.php?&idclie=" + proveedor + "&estado=" + estado,
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
    window.location = "fv_detalle.php?idfact="+idfact+"&fact=" + numero + "&prove=" + prove;
}

$(function () {
    $('.selectpicker').on('change', function () {
        var idprove = $(this).find("option:selected").attr("value");
        //cambiarWhere(idprove, 1);
    });
});

var ides = "";
$('#pagoFv').click(function () {
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
        var post = $.post("../conection/fv_new_ingreso.php", parametros, redireccionar, 'json');
        post.error(null);
    }

}
function redireccionar(r) {
    if (r.estado == 1) {
        location.href = 'fv_new_ingreso.php';
    }else{
        mostrarModal('#error_listaFacturas');
    }
}

