$(document).ready(function () {
    cargarVehiculo();       //tabla de choferes
    cargarTipo();  //tabla de clasificaciones
    ComboTipo();            //combo con tipos de vehiculos
    //ComboVehiculo(0); // combo con vehiculos
    //$("#addchofer_tipo_vehiculo").change(function () {
    //    ComboVehiculo($(this).val(), 0);
    //});
    //$("#showchofer_tipo_vehiculo").change(function () {
    //    ComboVehiculo($(this).val(), 0);
    //});
});

function recargarVehiculo() {
    $('#listado_vehiculo').dataTable().fnDestroy();
    cargarVehiculo();
}
function recargarTipo() {
    $('#listado_tipo').dataTable().fnDestroy();
    cargarTipo();
}
function ComboTipo() {
    $.ajax({
        url: "../conection/conf_vehiculo.php",
        type: "POST",
        data: 'combo_tipo=1',
        success: function (opciones) {
            $("#addvehiculo_tipo").html(opciones);
            $("#showvehiculo_tipo").html(opciones);
        }
    });
}
function cargarVehiculo() {
    $('#listado_vehiculo').dataTable({
        "ajax": "../conection/conf_vehiculo.php?listado_vehiculo=1",
        "columns": [
            {"data": "patente"},
            {"data": "descripcion"},
            {"data": "tipo"},
            {"data": "km"},
            {"data": "detalle"}
        ],
        "pageLength": 7,
        "bPaginate": true,
        "bFilter": true,
        "bSort": true,
        "language": {
            "url": "../js/dataTable_es.txt"
        }
    });
}
function cargarTipo() {
    $('#listado_tipo').dataTable({
        "ajax": "../conection/conf_vehiculo.php?tipo=1",
        "columns": [
            {"data": "nombre"},
            {"data": "detalle"}
        ],
        "pageLength": 7,
        "bPaginate": false,
        "bFilter": false,
        "language": {
            "url": "../js/dataTable_es.txt"
        },
        "order": [[0, "desc"]]
    });
}
$('#addvehiculo_patente').focusout(function () {
    $.ajax({
        dataType: "json",
        url: "../conection/conf_vehiculo.php",
        type: "POST",
        data: 'verificar_patente=' + $(this).val(),
        success: function (r) {
            if (r.contador == 1) {
                $('#patente_grupo').addClass("has-error");
                $('#addvehiculo_patente').val("");
                $('#addvehiculo_patente').attr('placeholder', 'Esta patente ya existe');
                $('#addvehiculo_patente').focus();
            } else {
                $('#patente_grupo').removeClass("has-error");
                $('#addvehiculo_patente').attr('placeholder', 'Patente');
            }
        }
    });
});
function showaddVehiculo() {
    $('#addvehiculo_patente').val("");
    $('#patente_grupo').removeClass("has-error");
    $('#addvehiculo_patente').attr('placeholder', 'Patente');

    $('#addvehiculo_descripcion').val("");
    $('#descripcion_grupo').removeClass("has-error");
    $('#addvehiculo_descripcion').attr('placeholder', 'Descripcion (opcional)');

    $('#addvehiculo_tipo').val(0);
    $('#tipo_grupo').removeClass("has-error");
    $('#addchofer_nombre').attr('placeholder', 'Nombre del chofer');

    $('#addvehiculo_km').removeClass("has-error");
    $('#km_grupo').removeClass("has-error");
    $('#addvehiculo_km').val("0");
    ComboTipo();

    $('#modal_addvehiculo').modal('show');
}
/* function showmodVehiculo(idvehiculo) {
    $('#showvehiculo_patente').val("");
    $('#showpatente_grupo').removeClass("has-error");
    $('#showvehiculo_patente').attr('placeholder', 'Patente');

    $('#showvehiculo_descripcion').val("");
    $('#showdescripcion_grupo').removeClass("has-error");
    $('#showaddvehiculo_descripcion').attr('placeholder', 'Descripcion (opcional)');

    $('#showaddvehiculo_tipo').val(0);
    $('#showtipo_grupo').removeClass("has-error");
    $('#showaddchofer_nombre').attr('placeholder', 'Nombre del chofer');

    $('#showaddvehiculo_km').removeClass("has-error");
    $('#showkm_grupo').removeClass("has-error");
    $('#showaddvehiculo_km').val("0");
    ComboTipo();

    $('#modal_showvehiculo').modal('show');
} */
function showaddTipoVehiculo() {
    $('#addTipoVehiculo_nombre').val("");
    $('#tipoVehiculo_grupo').removeClass("has-error");
    $('#modal_addTipoVehiculo').modal('show');
}
function registrarVehiculo() {
    var patente = false;
    var tipo = false;
    var km = false;

    var txt_patente = $('#addvehiculo_patente').val();
    var txt_descripcion = $('#addvehiculo_descripcion').val();
    var txt_km = $('#addvehiculo_km').val();
    var tipo_val = $('#addvehiculo_tipo').val();

    if (!txt_patente) {
        patente = false;
        $('#patente_grupo').addClass("has-error");
        $('#addvehiculo_patente').val("");
        $('#addvehiculo_patente').attr('placeholder', 'Falta patente');
    } else {
        patente = true;
        $('#rut_grupo').removeClass("has-error");
        $('#addchofer_rut').attr('placeholder', 'Patente');
    }

    if (!txt_km) {
        km = false;
        $('#km_grupo').addClass("has-error");
        $('#addvehiculo_km').val("");
        $('#addvehiculo_km').attr('placeholder', 'Falta km inicial');
    } else {
        km = true;
        $('#km_grupo').removeClass("has-error");
        $('#addvehiculo_km').attr('placeholder', '');
    }

    if (tipo_val == 0) {
        tipo = false;
        $('#tipo_grupo').addClass("has-error");
    } else {
        tipo = true;
        $('#tipo_grupo').removeClass("has-error");
    }

    if (patente && tipo && km) {
        var parametros = {
            patente: txt_patente,
            descripcion: txt_descripcion,
            tipo: tipo_val,
            km: txt_km
        };
        $.ajax({
            url: "../conection/ajax/ajax_addvehiculo.php",
            type: "POST",
            data: parametros,
            success: function (r) {
                $('#modal_addvehiculo').modal('hide');
                $('#modal_vehiculoMensaje').modal('show');
                if (r == "correcto") {
                    recargarVehiculo();
                    $('#modal_mensaje_titulo').html('Agregado!');
                    $('#modal_mensaje_msg').html('El chofer ha sido correctamente agregado.');
                } else {
                    $('#modal_mensaje_titulo').html('Error');
                    $('#modal_mensaje_msg').html('Error al procesar la informacion ...');
                }
            }
        });
    }
}
function addTipoVehiculo(tipoVehiculo) {
    var parametros =
            {tipoVehiculo: tipoVehiculo};
    $.ajax({
        url: "../conection/ajax/ajax_addTipoVehiculo.php",
        type: "POST",
        data: parametros,
        success: function (r) {
            recargarTipo();
            $('#modal_addTipoVehiculo').modal('hide');
        }
    });
}
function eliminarTipoVehiculo(tipoVehiculo) {
    $('#modal_deleteTipoVehiculo').modal('show');
    $('#deletetipovehiculo_id').val(tipoVehiculo);
}
function confirmarEliminarTipoVehiculo(idtipovehiculo) {
    var parametros =
            {idtipovehiculo: idtipovehiculo};
    $.ajax({
        url: "../conection/conf_vehiculo.php?eliminar_tipovehiculo=1",
        type: "POST",
        data: parametros,
        success: function (r) {
            recargarTipo();
            $('#modal_deleteTipoVehiculo').modal('hide');
        }
    });
}
function detalleVehiculo(idvehiculo) {
    $.ajax({
        dataType: "json",
        url: "../conection/conf_vehiculo.php",
        type: "POST",
        data: 'extraerVehiculo=' + idvehiculo,
        success: function (r) {
            if (r) {
                $('#showvehiculo_id').val(r.idvehiculo);
                $('#showvehiculo_patente').val(r.patente);
                $('#showvehiculo_descripcion').val(r.descripcion);
                $('#showvehiculo_tipo').val(r.tipo_vehi_id);
                $('#showvehiculo_km').val(r.km);
            } else {

            }
        }
    });
    $('#showvehiculo_patente').attr('readonly', 'yes');
    $('#showvehiculo_descripcion').attr('readonly', 'yes');
    $('#showvehiculo_km').attr('readonly', 'yes');
    $('#showvehiculo_tipo').attr('disabled', 'yes');
    $('#btn_del_conf').hide();
    $('#modal_showvehiculo').modal('show');
    
    $('#btn_mod_show').removeAttr('disabled');
    $('#btn_reg_show').attr('disabled', 'yes');
    $('#btn_del_conf').hide();
    $('#btn_del').removeAttr('disabled');
    
    $('#showpatente_grupo').removeClass("has-error");
    $('#showtipo_grupo').removeClass("has-error");
    $('#showkm_grupo').removeClass("has-error");
}
$('#btn_mod_show').click(function () {
    $('#showvehiculo_patente').removeAttr('readonly');
    $('#showvehiculo_tipo').removeAttr('disabled');
    $('#showvehiculo_descripcion').removeAttr('readonly');
    $('#btn_mod_show').attr('disabled', 'yes');
    $('#btn_reg_show').removeAttr('disabled');
});
$('#btn_del').click(function () {
    $('#btn_del_conf').show();
    $('#btn_del').attr('disabled', 'yes');
});
//// actualizacion
function updateVehiculo() {
    var idvehiculo = $('#showvehiculo_id').val();
    var patente = false;
    var tipo = false;
    var txt_patente = $('#showvehiculo_patente').val();
    var txt_descripcion = $('#showvehiculo_descripcion').val();
    var tipo_vehi = $('#showvehiculo_tipo').val();
    if (!txt_patente) {
        patente = false;
        $('#showpatente_grupo').addClass("has-error");
        $('#showvehiculo_patente').val("");
        $('#showvehiculo_patente').attr('placeholder', 'Falta Nombre');
    } else {
        patente = true;
        $('#nombre_grupo_show').removeClass("has-error");
        $('#showchofer_nombre').attr('placeholder', 'Nombre del chofer');
    }
    if (tipo_vehi == 0) {
        tipo = false;
        $('#showtipo_grupo').addClass("has-error");
    } else {
        tipo = true;
        $('#showtipo_grupo').removeClass("has-error");
    }
    
    if (patente && tipo) {
        var parametros = {
            id: idvehiculo,
            patente: txt_patente,
            descripcion: txt_descripcion,
            tipo:tipo_vehi
        };

        request = $.ajax({
            url: "../conection/ajax/ajax_upvehiculo.php",
            type: "POST",
            data: parametros
        });

        request.done(function (response, textStatus, jqXHR) {
            $('#modal_showvehiculo').modal('hide');
            $('#modal_vehiculoMensaje').modal('show');
            if (response === "correcto") {
                recargarVehiculo();
                $('#modal_mensaje_titulo').html('Actualizado!');
                $('#modal_mensaje_msg').html('El chofer ha sido actualizado correctamente..');
            } else {
                $('#modal_mensaje_titulo').html('Error');
                $('#modal_mensaje_msg').html('Error al procesar la informacion ...');
            }
        });
    }
}
//// registro
$('#btn_del_conf').click(function () {
    var idvehiculo = $('#showvehiculo_id').val();
    var parametros =
            {eliminar_vehiculo: idvehiculo};
    $.ajax({
        url: "../conection/conf_vehiculo.php",
        type: "POST",
        data: parametros,
        success: function (r) {
            recargarVehiculo();
            $('#modal_showvehiculo').modal('hide');
            $('#modal_vehiculoMensaje').modal('show');
            if (r === "correcto") {
                $('#modal_mensaje_titulo').html('Eliminado!');
                $('#modal_mensaje_msg').html('El vehiculo ha sido eliminado pero sus datos persisten.');
            } else {
                $('#modal_mensaje_titulo').html('Error');
                $('#modal_mensaje_msg').html('Error al procesar la informacion ...');
            }
        }
    });
});

function volver() {
    location.href = "factura_list.php";
}
