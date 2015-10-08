$(document).ready(function () {
    cargarTablaIngreso();
    extraerCorrelativoIngreso();
});
function cargarTablaIngreso() {
    $('#tabla_facturas_ingreso').dataTable({
        "ajax": "../conection/fv_new_ingreso.php?tabla_factura_in=1",
        "columns": [
            {"data": "check"},
            {"data": "ndoc"},
            {"data": "total", sClass: "alignRight"},
            {"data": "eliminar", sClass: "alignRight"}
        ],
        "language": {
            "url": "../js/dataTable_es.txt"
        },
        "bPaginate": false,
        "bFilter": false,
        "bInfo": false,
        "bSort": false
    });
}


function extraerCorrelativoIngreso() {
    // Realizar la petición
    var parametros = {corre_ingreso: 1};
    var post = $.post("../conection/fv_new_ingreso.php", parametros, imprimirCorrelativoIngreso, 'json');
    post.error(error);
}

function error(e) {
    alert('error al procesar la informacion');
}

function imprimirCorrelativoIngreso(r) {
    $("#correlativoIngreso").html(r.corre);
    $("title").html("Comprobante de pago Nº" + r.corre);
}

function eliminarIngreso(ndoc) {
    var parametros = {fact_eli_ingreso: ndoc};
    var post = $.post("../conection/fv_new_ingreso.php", parametros, respuestaEliminar, 'json');
    post.error(error);
}

function respuestaEliminar(r) {
    if (r.estado == 1) {
        $('#tabla_facturas_ingreso').dataTable().fnDestroy();
        cargarTablaIngreso(r.listado);
    } else {
        alert("error en el retorno de informacion..!");
    }
}

function agregarFacturaIngreso(factura) {
    if (factura) {
        var parametros = {new_fact: factura};
        var post = $.post("../conection/fv_new_ingreso.php", parametros, respuestaAgregarIngreso, 'json');
        post.error(error_agregarFactura);
    }
}
function error_agregarFactura() {
    $('#error_modal').modal('show');
    $('#mensaje_error').html('La factura no existe o corresponde a otro proveedor.');
    $('#ingreso_add_factura').val("");
}
function respuestaAgregarIngreso(r) {
    if (r.estado == 1) {
        $('#tabla_facturas_ingreso').dataTable().fnDestroy();
        cargarTablaIngreso();
        $('#ingreso_add_factura').val("");
        
    } else if (r.estado == 2) {
        $('#error_modal').modal('show');
        $('#mensaje_error').html('Factura existente en la lista.');
        $('#ingreso_add_factura').val("");
    } else if (r.estado == 0) {
        $('#error_modal').modal('show');
        $('#mensaje_error').html('La factura no existe o corresponde a otro proveedor.');
    }
}

function cancelarNewIngreso() {
    var post = $.post("../conection/fv_new_ingreso.php", {cancelar: 1}, respuestaCancelar, 'json');
    post.error();
}
function respuestaCancelar(r) {
    if (r.estado == 1) {
        location.href = "fv_listado.php";
    }
}


function registrarIngreso() {
    var n_docs = $('#ingreso_docu').val();
    var n_docs_boolean = false;
    //validar ingreso de rut 
    if (!n_docs) {
        n_docs_boolean = false;
        $('#ingreso_numero_documento').addClass("has-error");
        $('#ingreso_docu').attr('placeholder', '!');
    } else {
        n_docs_boolean = true;
        $('#ingreso_numero_documento').removeClass("has-error");
        $('#ingreso_docu').attr('placeholder', '');
    }
    if (n_docs_boolean) {
        enviarDatos();
    }
}

function enviarDatos() {

    var parametros = {
        tipo_pago: $('#combo_pago_ingreso').val(),
        docs: $('#ingreso_docu').val(),
        proveedor_id: $('#ingreso_proveedor_id').val(),
        glosa: $('#ingreso_glosa').val(),
        facturas: arrayDetalle()
    };

    request = $.ajax({
        url: "../conection/ajax/ajax_addnewingreso.php",
        type: "post",
        data: parametros
    });

    request.done(function (response, textStatus, jqXHR) {
        $('#modal_loadNewIngreso').modal('show');
        $('#estado_registro').html("<div id='message' align='center'></div> \n\
                                            <br> \n\
                                          <div id='load'></div>\n\
                                             <br> \n\
                                          </div>");
        $('#load').html("<div class='progress'> <div class='progress-bar progress-bar-striped active' role='progressbar' aria-valuenow='45' aria-valuemin='0' aria-valuemax='100' style='width: 100%'> <span class='sr-only'>100% Complete</span></div>");
        $('#message').html("<h2>Espere mientras se registran los datos</h2>")
                .append("<p>Validando...</p>")
                .hide();
        if (response === "correcto") {

            resetDatos();

            $('#message').append("")
                    .fadeIn(1500, function () {
                        $('#message').append("<img id='checkmark' src='../adj/sistema/loadOk.png' width='100px' />");
                        $('#load').hide();
                    });
        } else {
            $('#message').append("")
                    .fadeIn(1500, function () {
                        $('#message').append("<img id='checkmark' src='../adj/sistema/loadError.png' width='100px' />");
                        $('#load').hide();
                    });
        }
    });
}
function arrayDetalle() {
    var lista_facturas = "";
    ids = $('input[type=checkbox]:checked').map(function () {
        return $(this).attr('id');
    }).get();

    lista_facturas = ids.join(',');
    if (lista_facturas !== "") {
        return lista_facturas;
    }
}

function resetDatos() {
    request = $.ajax({
        url: "../conection/ajax/ajax_addnewingreso.php",
        type: "post",
        data: {reset: 1}
    });
    request.done(function (response, textStatus, jqXHR) {
        location.href = "fv_ingreso_detalle.php?corre_in=" + response;

    });
}
  