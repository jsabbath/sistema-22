
$(document).ready(function () {
    facturasdeCompra();
    //facturasdeVenta();
});

function facturasdeCompra() {
    $.ajax({
        dataType: "json",
        url: "../conection/index.php",
        type: "post",
        data: {facturas: 1},
        success: function (r) {
            $("#compra_cantidad").html(r.compra);
            $("#venta_cantidad").html(r.venta);
            if (r.compra >= 1) {
                $("#compra_panel_color").removeClass("panel-green");
                $("#compra_panel_color").removeClass("panel-danger");
                $("#compra_panel_color").addClass("panel-yellow");
            } else if (r.compra >= 10) {
                $("#compra_panel_color").removeClass("panel-green");
                $("#compra_panel_color").removeClass("panel-yellow");
                $("#compra_panel_color").addClass("panel-danger");
            } else if (r.compra === 0) {
                $("#compra_panel_color").removeClass("panel-danger");
                $("#compra_panel_color").removeClass("panel-yellow");
                $("#compra_panel_color").addClass("panel-green");
            }

            if (r.venta >= 1) {
                $("#venta_panel_color").removeClass("panel-green");
                $("#venta_panel_color").removeClass("panel-danger");
                $("#venta_panel_color").addClass("panel-yellow");
            } else if (r.venta >= 10) {
                $("#venta_panel_color").removeClass("panel-green");
                $("#venta_panel_color").removeClass("panel-yellow");
                $("#venta_panel_color").addClass("panel-danger");
            } else if (r.venta === 0) {
                $("#venta_panel_color").removeClass("panel-danger");
                $("#venta_panel_color").removeClass("panel-yellow");
                $("#venta_panel_color").addClass("panel-green");
            }
        }
    });
}


function recarga() {
    $("#morris-bar-chart").html("");
    Morris.Bar({
        element: 'morris-bar-chart',
        data: [
            {y: '2009', a: 100, b: 90},
            {y: '2009', a: 100, b: 90},
            {y: '2009', a: 100, b: 90},
            {y: '2009', a: 100, b: 90},
            {y: '2009', a: 100, b: 90},
            {y: '2009', a: 100, b: 90}
        ],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Series A', 'Series B'],
        hideHover: 'auto',
        resize: true
    });
}
