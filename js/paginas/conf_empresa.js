$(document).ready(function () {
    cargarEmpresas();       //tabla de empresas
});

function cargarEmpresas() {
    $.ajax({
        url: "../conection/ajax/ajax_getempresas.php",
        type: "POST",
        data: 'empresas=1',
        success: function (empresas) {
            $("#tabla_empresas").html(empresas);
        }
    });
}