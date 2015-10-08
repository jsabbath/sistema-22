$(document).ready(function () {
    cargarTabla();
    extraerCorrelativoEgreso();
});
function cargarTabla() {
    $('#tabla_facturas').dataTable({
        "ajax": "../conection/fc_new_egreso.php?tabla_fact=1",
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


function extraerCorrelativoEgreso() {
    // Realizar la petición
    var parametros = {corre_egreso: 0};
    var post = $.post("../conection/fc_new_egreso.php", parametros, imprimirCorrelativo, 'json');
    post.error(error);
}

function error(e) {
    alert('error al procesar la informacion');
}

function imprimirCorrelativo(r) {
    $("#correlativo").html(r.corre);
}

function eliminar(ndoc) {
    var parametros = {fact_eli: ndoc};
    var post = $.post("../conection/fc_new_egreso.php", parametros, respuestaEliminar, 'json');
    post.error(error);
}

function respuestaEliminar(r) {
    if (r.estado == 1) {
        $('#tabla_facturas').dataTable().fnDestroy();
        cargarTabla(r.listado);
    } else {
        alert("error en el retorno de informacion..!");
    }
}

function agregarFactura(factura) {
    if (factura) {
        var parametros = {new_fact: factura};
        var post = $.post("../conection/fc_new_egreso.php", parametros, respuestaAgregar, 'json');
        post.error(error_agregarFactura);
    }
}
function error_agregarFactura() {
    $('#error_modal').modal('show');
    $('#mensaje_error').html('La factura no existe o corresponde a otro proveedor.');
    $('#egreso_add_factura').val("");
}
function respuestaAgregar(r) {
    if (r.estado == 1) {
        $('#tabla_facturas').dataTable().fnDestroy();
        cargarTabla();
        $('#egreso_add_factura').val("");
        
    } else if (r.estado == 2) {
        $('#error_modal').modal('show');
        $('#mensaje_error').html('Factura existente en la lista.');
        $('#egreso_add_factura').val("");
    } else if (r.estado == 0) {
        $('#error_modal').modal('show');
        $('#mensaje_error').html('La factura no existe o corresponde a otro proveedor.');
    }
}

function cancelarNewEgreso() {
    var post = $.post("../conection/fc_new_egreso.php", {cancelar: 1}, respuestaCancelar, 'json');
    post.error();
}
function respuestaCancelar(r) {
    if (r.estado == 1) {
        location.href = "fc_listado.php";
    }
}



function registrarEgreso() {
    var n_docs = $('#egreso_docu').val();
    var n_docs_boolean = false;
    //validar ingreso de rut 
    if (!n_docs) {
        n_docs_boolean = false;
        $('#ndocs_grupo').addClass("has-error");
        $('#egreso_docu').attr('placeholder', '!');
    } else {
        n_docs_boolean = true;
        $('#ndocs_grupo').removeClass("has-error");
        $('#egreso_docu').attr('placeholder', '');
    }
    if (n_docs_boolean) {
        enviarDatos();
    }
}

function enviarDatos() {

    var parametros = {
        tipo_pago: $('#combo_proveedor').val(),
        docs: $('#egreso_docu').val(),
        proveedor_id: $('#egreso_proveedor_id').val(),
        glosa: $('#egreso_glosa').val(),
        facturas: arrayDetalle()
    };

    request = $.ajax({
        url: "../conection/ajax/ajax_addnewegreso.php",
        type: "post",
        data: parametros
    });

    request.done(function (response, textStatus, jqXHR) {
        $('#modal_loadNewEgreso').modal('show');
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
        url: "../conection/ajax/ajax_addnewegreso.php",
        type: "post",
        data: {reset: 1}
    });
    request.done(function (response, textStatus, jqXHR) {
        location.href = "fc_egreso_detalle.php?corre_eg=" + response;

    });
}
  