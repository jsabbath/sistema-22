$(document).ready(function () {
    $('#fact_fecha_doc').datepicker({
        format: "dd/mm/yyyy",
        language: "es",
        autoclose: true,
        orientation: "top left"
    });
    // if (!$('#fact_fecha_plazo').hasAttr('readonly')) {
    $('#fact_fecha_plazo').datepicker({
        format: "dd/mm/yyyy",
        language: "es",
        autoclose: true,
        orientation: "top left"
    });
    // }
    $("#btn_reg").click(function () {
        registrarCompra();
    });
});
$('#fact_rut').typeahead({
    ajax: '../conection/fc_compra.php'
});
function calcular_plazo() {
    var fecha = $("#fact_fecha_doc").val();
    if (fecha) {
        elem = document.getElementsByName('fact_radio_plazo');
        for (i = 0; i < elem.length; i++) {
            if (elem[i].checked) {
                dias = elem[i].value;
            }
        }
        if (dias == 0) {

            $('#fact_fecha_plazo').attr('disabled', false);
            $('#fact_fecha_plazo').attr('readonly', false);
            $("#fact_fecha_plazo").val("");
            $("#fact_fecha_plazo").focus();
        } else {
            var parametros = {fecha: fecha, dias: dias};
            var post = $.post("../conection/ajax/ajax_funciones.php", parametros, imprimirFecha, 'json');
            post.error(Errorfecha);
            $('#fact_fecha_plazo').attr('disabled', true);
            $('#fact_fecha_plazo').attr('readonly', false);
        }
    } else {
        $('#fact_fecha_plazo').attr('disabled', true);
        $('#fact_fecha_plazo').attr('readonly', false);
        $("#fact_fecha_plazo").val("");
    }
}
function Errorfecha() {
    alert("error");
}
function imprimirFecha(r) {
    $("#fact_fecha_plazo").val(r.fecha);
    $('#fact_fecha_plazo').attr('readonly', true);
}
$("#btn_info_prove").click(function () {
    if ($('#fact_prove').val()) {
        $("#modal_info_prove").modal("show");
    }
});
/*$('#fact_rut').Rut({
 on_error: function ()
 {
 $("#fact_rut").val("");
 $("#grupo_rut").addClass("has-error");
 $("#rut_prove").focus();
 $("#rut_prove").attr("placeholder", "Error! Rut Incorrecto").placeholder();
 }
 ,
 format_on: 'keyup'
 ,
 on_success: function ()
 {
 $("#grupo_rut").removeClass("has-error");
 $("#grupo_rut").addClass("has-success");
 }
 }); */
function mascara(o, f) {
    v_obj = o;
    v_fun = f;
    setTimeout("execmascara()", 1);
}
function execmascara() {
    v_obj.value = v_fun(v_obj.value);
}
function cpf(v) {
    v = v.replace(/([^0-9]+)/g, '');
    v = v.replace(/^[\.]/, '');
    v = v.replace(/[\.][\.]/g, '');
    v = v.replace(/\.(\d)(\d)(\d)/g, '.$1$2');
    v = v.replace(/\.(\d{1,2})\./g, '.$1');
    v = v.toString().split('').reverse().join('').replace(/(\d{3})/g, '$1,');
    v = v.split('').reverse().join('').replace(/^[\,]/, '');
    return v;
}
function calcular() {
    var varMonto;
    var varIva;
    var varSubTotal;
    varMonto = document.getElementById("fact_neto").value;
    varMonto = varMonto.replace(/[\,]/g, '');

    varIva = parseFloat(varMonto).toFixed(2) * 0.19;
    document.getElementById("fact_iva").value = addCommas(parseFloat(varIva).toFixed(0));

    varSubTotal = parseFloat(varMonto) + parseFloat(varIva);
    document.getElementById("fact_total").value = addCommas(parseFloat(varSubTotal).toFixed(0));
}
function addCommas(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}
function consultarProveedor(id) {
    // Realizar la petición
    var parametros = {
        idemp: id,
        rut: $('#fact_rut').val(),
        tipo: 1
    };
    var post = $.post("../conection/ajax/ajax_getclieprove.php", parametros, imprimiProveedor, 'json');

    post.error(ErrorProve);
}
function ErrorProve(e) {
    $('#modal_error_rut').modal("show");
    document.getElementById("fact_rut").value = "";
    document.getElementById("fact_prove").value = "";
    document.getElementById("cerrar_modal_rut").focus();
    document.getElementById("idclieprove").value = "";
}
function imprimiProveedor(r) {
    if (r != null) {
        $("#idclieprove").val(r.id);
        $("#fact_prove").val(r.nombre);
        /*   document.getElementById("modal_rut_prove").value = r.rut;
         document.getElementById("modal_nombre_prove").value = r.nombre;
         document.getElementById("modal_fono_prove").value = r.fono;
         document.getElementById("modal_giro_prove").value = r.giro;
         document.getElementById("modal_direccion_prove").value = r.direccion;
         document.getElementById("modal_comuna_prove").value = r.comuna;
         document.getElementById("modal_provincia_prove").value = r.provincia;
         document.getElementById("modal_region_prove").value = r.region;
         document.getElementById("modal_fecha_prove").value = r.fecha;
         document.getElementById("modal_mod_prove").value = r.ultimo_mod + " - " + r.fecha_mod; */
    } else {
        /* mostrarModal('#modal_error_rut');
         document.getElementById("fact_rut").value = "";
         document.getElementById("fact_prove").value = "";
         document.getElementById("cerrar_modal_rut").focus();
         document.getElementById("idclieprove").value = ""; */
    }
}
function registrarCompra() {
    //calcular_plazo();
    var ndoc;
    var prove_id;
    var fecha_e;
    var fecha_p;
    var neto;

    if ($('#fact_numero').val() == "") {
        ndoc = false;
        $('#grupo_ndoc').addClass("has-error");
        $('#fact_numero').val("");
        $('#fact_numero').attr('placeholder', '!');
    } else {
        ndoc = true;
        $('#grupo_ndoc').removeClass("has-error");
        $('#fact_numero').attr('placeholder', 'Numero de factura');
    }
    if ($('#fact_prove').val() == "") {
        prove_id = false;
        $('#grupo_prove').addClass("has-error");
        $('#fact_prove').val("");
        $('#fact_prove').attr('placeholder', '!');
    } else {
        prove_id = true;
        $('#grupo_prove').removeClass("has-error");
        $('#fact_prove').attr('placeholder', '');
    }
    if ($('#fact_fecha_doc').val() == "") {
        fecha_e = false;
        $('#grupo_fecha_e').addClass("has-error");
        $('#fact_fecha_doc').val("");
        $('#fact_fecha_doc').attr('placeholder', '!');
    } else {
        fecha_e = true;
        $('#grupo_fecha_e').removeClass("has-error");
        $('#fact_fecha_doc').attr('placeholder', '');
    }
    if ($('#fact_fecha_plazo').val() == "") {
        fecha_p = false;
        $('#grupo_fecha_p').addClass("has-error");
        $('#fact_fecha_plazo').val("");
        $('#fact_fecha_plazo').attr('placeholder', '!');
    } else {
        fecha_p = true;
        $('#grupo_fecha_p').removeClass("has-error");
        $('#fact_fecha_plazo').attr('placeholder', '');
    }
    if ($('#fact_neto').val() == "") {
        neto = false;
        $('#grupo_neto').addClass("has-error");
        $('#fact_neto').val("");
        $('#fact_neto').attr('placeholder', '!');
    } else {
        neto = true;
        $('#grupo_neto').removeClass("has-error");
        $('#fact_neto').attr('placeholder', '');
    }

    if (ndoc && prove_id && fecha_e && fecha_p && neto) {
        //registroFinal();
        var parametros = {
            numfact: $('#fact_numero').val(),
            idprove: $('#idclieprove').val()
        };

        $.ajax({
            dataType: "json",
            url: "../conection/ajax/ajax_getfactura.php",
            type: "post",
            data: parametros,
            success: function (r) {
                if (r.dato === 0) {
                    var parametros = {
                        fecha_1: $('#fact_fecha_doc').val(),
                        fecha_2: $('#fact_fecha_plazo').val()
                    };
                    $.ajax({
                        dataType: "json",
                        url: "../conection/ajax/ajax_funciones.php",
                        type: "post",
                        data: parametros,
                        success: function (r) {
                            if (r.dias > 0) {
                                registrarFactura();
                            } else {
                                $('#modal_facturamensaje').modal("show");
                                $('#modal_mensaje_titulo').html('Error!');
                                $('#modal_mensaje_msg').html('La fecha de plazo es anterior a la del documento');
                                $('#fact_fecha_plazo').val("");
                            }
                        }
                    });
                } else {
                    $('#modal_factura_repetida_rut').html($('#fact_rut').val());
                    $("#modal_factura_repetida").modal("show");
                    $('#fact_numero').val("");
                    $('#grupo_ndoc').addClass("has-error");
                    $('#fact_numero').focus();
                }
            }
        });


    }
}
function registrarFactura() {
    var parametros = {
        fact_numero: $('#fact_numero').val(),
        idclieprove: $('#idclieprove').val(),
        fact_fecha_doc: $('#fact_fecha_doc').val(),
        fact_fecha_plazo: $('#fact_fecha_plazo').val(),
        empresa: $('#empresa').val(),
        fact_glosa: $('#fact_glosa').val(),
        fact_neto: $('#fact_neto').val(),
        fact_iva: $('#fact_iva').val(),
        fact_total: $('#fact_total').val()
    };
    $.ajax({
        url: "../conection/ajax/ajax_addfactura.php",
        type: "post",
        data: parametros,
        success: function (r) {
            $('#fact_registro').html("<div id='message' align='center'></div> \n\
                                            <br> \n\
                                          <div id='load'></div>\n\
                                             <br> \n\
                                          <div id='option'>\n\
                                          </div>");
            $('#load').html("<div class='progress'> <div class='progress-bar progress-bar-striped active' role='progressbar' aria-valuenow='45' aria-valuemin='0' aria-valuemax='100' style='width: 100%'> <span class='sr-only'>100% Complete</span></div>");
            $('#message').html("<h2>Espere mientras se registran los datos</h2>")
                    .append("<p>Validando...</p>")
                    .hide();
            if (r === "correcto") {
                $('#message').append("")
                        .fadeIn(1500, function () {
                            $('#message').append("<img id='checkmark' src='../adj/sistema/loadOk.png' width='100px' />");
                            $('#load').hide();
                            $('#option').html("<div class='row'>\n\
                                                <div class='col-lg-4'></div>\n\
                                                <div class='col-lg-4'>\n\
                                                  <div class='panel panel panel-primary'> \n\
                                                  <div class='panel-heading' align='center'>Registro Ingresado correctamente, Opciones:</div> \n\
                                                   <div class='panel-body'>\n\
                                                    <div class='row'>\n\
                                                        <div class='col-lg-12'>\n\
                                                        <a class='btn btn-lg btn-warning btn-block' id='btn_volver' onclick='javascript:location.reload();' name='btn_volver'>Volver al Formulario </a>\n\
                                                        </div>\n\
                                                    </div>\n\
                                                  </div>\n\
                                                </div>\n\
                                            </div>");
                        });
            } else {
                $('#message').append("")
                        .fadeIn(1500, function () {
                            $('#message').append("<img id='checkmark' src='../adj/sistema/loadError.png' width='100px' />");
                            $('#load').hide();
                            $('#option').html("<div class='row'>\n\
                                                <div class='col-lg-4'></div>\n\
                                                <div class='col-lg-4'>\n\
                                                  <div class='panel panel panel-danger'> \n\
                                                  <div class='panel-heading'>Opciones</div> \n\
                                                   <div class='panel-body'>\n\
                                                    <div class='row' align='center'>\n\
                                                        <div class='col-lg-12'>\n\
                                                        <a class='btn btn-lg btn-warning btn-block' id='btn_error' name='btn_error'>Notificar Error</a>\n\
                                                        <p>No se ha podido procesar su informacion, esto puede deberse a una falla de sistema como tambien un mal ingreso de datos.</p>\n\
                                                        <p>El sistema ya registro el evento que produjo la falla la su posterior revision.</p>\n\
                                                        </div>\n\
                                                    </div>\n\
                                                  </div>\n\
                                                </div>\n\
                                            </div>");
                        });
            }
        },
        error: function () {

        }
    });
}

  