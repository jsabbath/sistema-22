$(document).ready(function () {
    GetVehiculo(0, 0);
    ComboTipo();
    ComboChofer();
    ComboClasificacion();
    ComboVehiculo($("#tipo_vehiculo").val());
    $("#tipo_vehiculo").change(function () {
        $('#tabla_registro').dataTable().fnDestroy();
        GetVehiculo(0, 0);
        ComboVehiculo($(this).val(), 0);
    });
    $("#vehiculo").change(function () {
        $('#tabla_registro').dataTable().fnDestroy();
        GetVehiculo($(this).val(), 0);
    });

    $('#lt').keyup(function () {
        calculokm();
    });

    $('#km').keyup(function () {
        calculokm();
    });

});

function ComboTipo() {
    $.ajax({
        url: "../conection/tr_planilla.php",
        type: "POST",
        data: 'combo_tipo=1',
        success: function (opciones) {
            $("#tipo_vehiculo").html(opciones);
        }
    });
}

function ComboVehiculo(tipo, select) {
    $.ajax({
        url: "../conection/tr_planilla.php",
        type: "POST",
        data: 'combo_vehi=1&tipo_vehi=' + tipo + '&select=' + select,
        success: function (opciones) {
            $("#vehiculo").html(opciones);
        }
    });
}

function ComboChofer() {
    $.ajax({
        url: "../conection/tr_planilla.php",
        type: "POST",
        data: 'combo_chofer=1',
        success: function (opciones) {
            $("#chofer").html(opciones);
        }
    });
}

function ComboClasificacion() {
    $.ajax({
        url: "../conection/tr_planilla.php",
        type: "POST",
        data: 'combo_clasi=1',
        success: function (opciones) {
            $("#clasificacion").html(opciones);
        }
    });
}

function GetVehiculo(idvehi, patente) {
    if (patente == 0) {
        $('#patente').html("-- -- --");
        $.ajax({
            dataType: "json",
            url: "../conection/tr_planilla.php",
            type: "POST",
            data: 'vehiculo=' + idvehi,
            success: function (r) {
                $("#km_anterior").val(r.km);
                $("#patente").html(r.patente);
            }
        });
        $('#tabla_registro').dataTable({
            "ajax": "../conection/tr_planilla.php?&idvehi=" + idvehi + "&limite=1",
            "columns": [
                {"data": "fecha"},
                {"data": "chofer"},
                {"data": "km"},
                {"data": "lt"},
                {"data": "rendimiento"},
                {"data": "detalle"}
            ],
            "language": {
                "url": "../js/dataTable_es.txt"
            },
            "bPaginate": false,
            "bFilter": false,
            "bSort": false,
            "bInfo": false,
            "sDom": 'Tlfrtip',
            "oTableTools": {
            }
        });
    } else {
        $.ajax({
            dataType: "json",
            url: "../conection/tr_planilla.php",
            type: "POST",
            data: 'vehiculo=' + idvehi,
            success: function (r) {
                $("#patente_modal").html(r.patente);
            }
        });
    }
}

function calculokm() {
    $('#rendimiento').val("");

    if ($('#km_anterior').val()) {
        if ($('#lt').val() && $('#km').val()) {

            var km = $('#km').val();
            var km_a = $('#km_anterior').val();
            var lt = $('#lt').val();

            var resta = km - km_a;
            if (resta > 0) {
                var rendimiento = resta / lt;
                $('#rendimiento').val(rendimiento.toFixed(2));
            }
        }
    }
}

function resetPlanilla() {
    $('#obs').val("");
    $('#km').val("");
    $('#patente').html("-- -- --");
    $('#km_anterior').val("");
    $('#lt').val("");
    $('#rendimiento').val("");
    $('#tipo_vehiculo').val(0);
    $('#vehiculo').val(0);
    $('#chofer').val(0);
    $('#clasificacion').val(0);
    $('#tabla_registro').dataTable().fnDestroy();
    GetVehiculo(0, 0);
}

function registrarPlanilla() {
    var km;
    var lt;
    var km_a;
    var rendimiento;
    var tipo_vehiculo;
    var vehiculo;
    var chofer;
    var clasificacion;

    if ($('#km').val() == "") {
        km = false;
        $('#grupo_km').addClass("has-error");
        $('#km').val("");
        $('#km').attr('placeholder', '!');
    } else {
        km = true;
        $('#grupo_km').removeClass("has-error");
        $('#km').attr('placeholder', '');
    }

    if ($('#km_anterior').val() == "") {
        km_a = false;
        $('#grupo_km_anterior').addClass("has-error");
        $('#km_anterior').val("");
        $('#km_anterior').attr('placeholder', '!');
    } else {
        km_a = true;
        $('#grupo_km_anterior').removeClass("has-error");
        $('#km_anterior').attr('placeholder', '');
    }

    if ($('#lt').val() == "") {
        lt = false;
        $('#grupo_lt').addClass("has-error");
        $('#lt').val("");
        $('#lt').attr('placeholder', '!');
    } else {
        lt = true;
        $('#grupo_lt').removeClass("has-error");
        $('#lt').attr('placeholder', '');
    }

    if ($('#rendimiento').val() == "") {
        rendimiento = false;
        $('#grupo_rendimiento').addClass("has-error");
        $('#rendimiento').val("");
        $('#rendimiento').attr('placeholder', '!');
    } else {
        rendimiento = true;
        $('#grupo_rendimiento').removeClass("has-error");
        $('#rendimiento').attr('placeholder', '');
    }

    if ($('#chofer').val() == 0) {
        chofer = false;
        $('#grupo_chofer').addClass("has-error");
    } else {
        chofer = true;
        $('#grupo_chofer').removeClass("has-error");
    }

    if ($('#tipo_vehiculo').val() == 0) {
        tipo_vehiculo = false;
        $('#grupo_tipo_vehiculo').addClass("has-error");
    } else {
        tipo_vehiculo = true;
        $('#grupo_tipo_vehiculo').removeClass("has-error");
    }

    if ($('#vehiculo').val() == 0) {
        vehiculo = false;
        $('#grupo_vehiculo').addClass("has-error");
    } else {
        vehiculo = true;
        $('#grupo_vehiculo').removeClass("has-error");
    }

    if ($('#clasificacion').val() == 0) {
        clasificacion = false;
        $('#grupo_clasificacion').addClass("has-error");
    } else {
        clasificacion = true;
        $('#grupo_clasificacion').removeClass("has-error");
    }

    if (km && km_a && lt && rendimiento && tipo_vehiculo && vehiculo && chofer && clasificacion) {
        registroFinal();

    }
}

function registroFinal() {
    $('#modal_loadPlanilla').modal('show');
    var parametros = {
        km_anterior: $('#km_anterior').val(),
        km: $('#km').val(),
        lt: $('#lt').val(),
        rendimiento: $('#rendimiento').val(),
        vehiculo: $('#vehiculo').val(),
        chofer: $('#chofer').val(),
        clasificacion: $('#clasificacion').val(),
        obs: $('#obs').val()
    };
    if (parametros) {
        var post = $.post("../conection/ajax/ajax_addplanilla.php", parametros, registroOKPlanilla, 'json');
        post.error(registroOKPlanilla);
        $('#cuerpo').html("<div id='message' align='center'></div> \n\
                                            <br> \n\
                                          <div id='load'></div>\n\
                                             <br> \n\
                                          <div id='option'>\n\
                                          </div>");
        $('#load').html("<div class='progress'> <div class='progress-bar progress-bar-striped active' role='progressbar' aria-valuenow='45' aria-valuemin='0' aria-valuemax='100' style='width: 100%'> <span class='sr-only'>100% Complete</span></div>");
        $('#message').html("<h2>Espere mientras se registran los datos</h2>")
                .append("<p>Validando...</p>")
                .hide();

    }
}

function registroOKPlanilla(r) {
    $('#message').append("")
            .fadeIn(1500, function () {
                $('#message').append("<img id='checkmark' src='../adj/sistema/loadOk.png' width='100px' />");
                $('#load').hide();
            });
    $('#cerrar_modal_load').removeAttr('disabled');
    resetPlanilla();
}

function errorOKPlanilla(r) {
    $('#message').append("")
            .fadeIn(1500, function () {
                $('#message').append("<img id='checkmark' src='../adj/sistema/loadError.png' width='100px' />");
                $('#load').hide();
                $('#option').html("<div class='row'>\n\
                                                <div class='col-lg-12'>\n\
                                                  <div class='panel panel panel-danger'> \n\
                                                  <div class='panel-heading'>Opciones</div> \n\
                                                   <div class='panel-body'>\n\
                                                    <div class='row' align='center'>\n\
                                                        <div class='col-lg-12'>\n\
                                                        <a class='btn btn-lg btn-warning btn-block' id='btn_error' name='btn_error'>Notificar Error</a>\n\
                                                        <p>No se ha podido procesar su informacion, esto puede deberse a una falla de sistema como tambien un mal ingreso de datos.</p>\n\
                                                        <p>Precione <b>Notificar error</b> para hacer llegar un informativo al desarrollador del sistema.</p>\n\
                                                        <p>Sea paciente, estamos en fase de pruebas.</p>\n\
                                                        </div>\n\
                                                    </div>\n\
                                                  </div>\n\
                                                </div>\n\
                                            </div>");
            });
}

function Consulta(consulta) {
    if ($('#busqueda').val()) {
        $('#busqueda').val("");
        var parametros = {
            consulta: consulta
        };
        if (parametros) {
            var post = $.post("../conection/ajax/ajax_getchofer.php", parametros, consultaOK, 'json');
            post.error(consultaError);
        }
    }
}

function consultaOK(r) {
    $("#tipo_vehiculo").val(r.tipo_vehiculo);
    ComboVehiculo($("#tipo_vehiculo").val(), r.vehiculo);
    $("#chofer").val(r.idchofer);
    $("#clasificacion").val(r.clasificacion);
    $('#tabla_registro').dataTable().fnDestroy();
    GetVehiculo(r.vehiculo, 0);
    $("#km").focus();

}
function consultaError(r) {
    $('#modal_Busqueda_sin_resultado').modal('show');
}

function abrirRegistros(idvehiculo) {
    if (idvehiculo != 0) {
        GetVehiculo(idvehiculo, 1);
        $('#modal_showPlanillaVehiculo').modal('show');
        $('#registros_vehiculo').dataTable().fnDestroy();
        $('#registros_vehiculo').dataTable({
            "ajax": "../conection/tr_planilla.php?&idvehi=" + idvehiculo + "&modal=1",
            "columns": [
                {"data": "fecha"},
                {"data": "chofer"},
                {"data": "class"},
                {"data": "km"},
                {"data": "lt"},
                {"data": "rendi"},
                {"data": "obs"}
            ],
            "language": {
                "url": "../js/dataTable_es.txt"
            },
            "pageLength": 7,
            "bLengthChange": false,
            "bPaginate": true,
            "bFilter": false,
            "bSort": true,
            "bInfo": true,
            "sDom": 'Tlfrtip',
            "oTableTools": {
            }
        });
    }
}