    <?php
require_once("sistema/cabecera.php");
if ($_SESSION['transporte'] == 1) {
    header("location:tr_planilla.php");
}
?>
<!DOCTYPE html>

<!--[if gt IE 9]><!--> 
<!--<html class="gt-ie8 gt-ie9 not-ie">--> 
    <!--<![endif]-->

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Inicio</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

        <!-- Open Sans font from Google CDN -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&amp;subset=latin" rel="stylesheet" type="text/css">
        <!-- LanderApp's stylesheets -->
        <link href="../assets/stylesheets/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="../assets/stylesheets/landerapp.min.css" rel="stylesheet" type="text/css">
        <link href="../assets/stylesheets/widgets.min.css" rel="stylesheet" type="text/css">
        <link href="../assets/stylesheets/rtl.min.css" rel="stylesheet" type="text/css">
        <link href="../assets/stylesheets/themes.min.css" rel="stylesheet" type="text/css">
        <!--[if lt IE 9]>
                <script src="assets/javascripts/ie.min.js"></script>
        <![endif]-->
    </head>

    <body class="<?php echo $_SESSION['template'] ?> main-menu-animated main-navbar-fixed main-menu-fixed">

        <script>var init = [];
        </script>

        <div id="main-wrapper">

            <!-- 2. $MAIN_NAVIGATION ===========================================================================
            
                    Main navigation
            -->
            <?php
            require 'sistema/navbar.php';
            require 'sistema/menu.php';
            ?> <!-- / #main-menu -->
            <!-- /4. $MAIN_MENU -->

            <div id="content-wrapper">
                <ul class="breadcrumb breadcrumb-page">
                    <div class="breadcrumb-label text-light-gray" >Tu estas aqui: </div>
                    <li><a href="index.php">Inicio</a></li>
                    <!--                    <li class="active"><a href="#">Dashboard</a></li>-->
                </ul>
                <div class="page-header">

                    <div class="row">
                        <!-- Page header, center on small screens -->
                        <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Resumen Administrativo</h1>

                        <div class="col-xs-12 col-sm-8">
                            <div class="row">
                                <hr class="visible-xs no-grid-gutter-h">
                                <!-- "Create project" button, width=auto on desktops -->
<!--                                <div class="pull-right col-xs-12 col-sm-auto"><a href="#" class="btn btn-primary btn-labeled" style="width: 100%;"><span class="btn-label icon fa fa-plus"></span>Create project</a></div>-->

                                <!-- Margin -->
                                <div class="visible-xs clearfix form-group-margin"></div>
                            </div>
                        </div>
                    </div>
                </div> <!-- / .page-header -->


                <div class="row">

                    <div class="col-md-4">
                        <div class="row">

                            <div class="col-sm-4 col-md-12">
                                <div class="stat-panel" style="height: 100px;">
                                    <!-- Success background, bordered, without top and bottom borders, without left border, without padding, vertically and horizontally centered text, large text -->
                                    <a href="#" class="stat-cell col-xs-5 bg-success bordered no-border-vr no-border-l no-padding valign-middle text-center text-lg">
                                        <i class="fa fa-calendar"></i>&nbsp;&nbsp;<strong><?php echo date("j"); ?></strong><br>
                                        <span class="text-lg text-slim">Diciembre</span>
                                    </a> <!-- /.stat-cell -->
                                    <!-- Without padding, extra small text -->
                                    <div class="stat-cell col-xs-7 no-padding valign-middle">
                                        <!-- Add parent div.stat-rows if you want build nested rows -->
                                        <div class="stat-rows">
                                            <div class="stat-row">
                                                <!-- Success background, small padding, vertically aligned text -->
                                                <a href="#" class="stat-cell bg-success padding-sm valign-middle">
                                                    Compras
                                                    <span class=" pull-right">$1,000,000</span>
                                                </a>
                                            </div>
                                            <div class="stat-row">
                                                <!-- Success darken background, small padding, vertically aligned text -->
                                                <a href="#" class="stat-cell bg-success darken padding-sm valign-middle">
                                                    Ventas
                                                    <span class=" pull-right">$1,000,000,000</span>
                                                </a>
                                            </div>
                                            <div class="stat-row">
                                                <!-- Success darker background, small padding, vertically aligned text -->
                                                <a href="#" class="stat-cell bg-success darker padding-sm valign-middle">
                                                    Combultible
                                                    <span class=" pull-right">3,450 LT</span>
                                                </a>
                                            </div>
                                        </div> <!-- /.stat-rows -->
                                    </div> <!-- /.stat-cell -->
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-12">
                                <div class="stat-panel">
                                    <div class="stat-row">
                                        <!-- Dark gray background, small padding, extra small text, semibold text -->
                                        <div class="stat-cell bg-primary padding-sm text-xs ext-semibold">
                                            <i class="fa fa-archive">
                                            </i>&nbsp;&nbsp;FACTURAS DE COMPRA &nbsp;&nbsp;
                                            <i class="fa  fa-arrow-right pull-right"></i>
                                        </div>
                                    </div>
                                    <!-- Danger background, vertically centered text -->
                                    <div class="stat-cell bg-success valign-middle">
                                        <!-- Stat panel bg icon -->
                                        <i class="fa fa-file bg-icon"></i>
                                        <!-- Extra large text -->
                                        <span class="text-xlg"><strong>0</strong> Pendientes</span>
                                        <br>
                                        <!-- Big text -->
                                        <span class="text-bg">Earned today</span><br>
                                        <!-- Small text -->

                                    </div> <!-- /.stat-cell -->
                                </div> <!-- /.stat-panel -->
                            </div>
                            <div class="col-sm-4 col-md-12">
                                <div class="stat-panel">
                                    <div class="stat-row">
                                        <!-- Dark gray background, small padding, extra small text, semibold text -->
                                        <div class="stat-cell bg-primary padding-sm text-xs text-semibold">
                                            <i class="fa fa-archive">
                                            </i>&nbsp;&nbsp;FACTURAS DE VENTA &nbsp;&nbsp;
                                            <i class="fa  fa-arrow-left pull-right"></i>
                                        </div>
                                    </div>
                                    <!-- Danger background, vertically centered text -->
                                    <div class="stat-cell bg-warning valign-middle">
                                        <!-- Stat panel bg icon -->
                                        <i class="fa fa-file bg-icon"></i>
                                        <!-- Extra large text -->
                                        <span class="text-xlg"><strong>147</strong> Pendientes</span>
                                        <br>
                                        <!-- Big text -->
                                        <span class="text-bg">Earned today</span><br>
                                        <!-- Small text -->

                                    </div> <!-- /.stat-cell -->
                                </div> <!-- /.stat-panel -->
                            </div>
                        </div>

                    </div>

                    <div class="col-md-8">

                        <script>
                            init.push(function () {
                                var uploads_data = [
                                    {day: 'dom', v: 0, k: 0},
                                    {day: 'sab', v: 0, k: 0},
                                    {day: 'vie', v: 5, k: 2},
                                    {day: 'jue', v: 12, k: 9},
                                    {day: 'mie', v: 15, k: 8},
                                    {day: 'mar', v: 10, k: 12},
                                    {day: 'lun', v: 20, k: 31}
                                ];
                                Morris.Line({
                                    element: 'hero-graph',
                                    data: uploads_data,
                                    xkey: 'day',
                                    ykeys: ['v', 'k'],
                                    labels: ['Este mes', 'Mes anteior'],
                                    lineColors: ['#fff', '#E45846'],
                                    lineWidth: 2,
                                    pointSize: 4,
                                    gridLineColor: 'rgba(255,255,255,.5)',
                                    resize: true,
                                    gridTextColor: '#fff',
//                                    xLabels: 'day',
                                    parseTime: false
//                                    xLabelFormat: function (d) {
//                                        return ['Ene', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'][d.getMonth()] + ' ' + d.getDate();
//                                    }
                                });
                            });

                        </script>
                        <!-- / Javascript -->

                        <div class="stat-panel">
                            <div class="stat-row">
                                <!-- Small horizontal padding, bordered, without right border, top aligned text -->
                                <div class="stat-cell col-sm-4 padding-sm-hr bordered no-border-r valign-top">
                                    <!-- Small padding, without top padding, extra small horizontal padding -->
                                    <h4 class="padding-sm no-padding-t padding-xs-hr"><i class="fa fa-truck text-primary"></i>&nbsp;Rendimiento y Consumo</h4>
                                    <!-- Without margin -->
                                    <ul class="list-group no-margin">
                                        <!-- Without left and right borders, extra small horizontal padding, without background, no border radius -->
                                        <li class="list-group-item no-border-hr padding-xs-hr no-bg no-border-radius">
                                            Consumo de la semana <span class="label label-pa-purple pull-right">1.23</span>
                                        </li> <!-- / .list-group-item -->
                                        <!-- Without left and right borders, extra small horizontal padding, without background -->
                                        <li class="list-group-item no-border-hr padding-xs-hr no-bg">
                                            Consumo del mes <span class="label label-danger pull-right">12.3</span>
                                        </li> <!-- / .list-group-item -->
                                        
                                    </ul>
                                </div> <!-- /.stat-cell -->
                                <!-- Primary background, small padding, vertically centered text -->
                                <div class="stat-cell col-sm-8 bg-primary padding-sm valign-middle">
                                    <div id="hero-graph" class="graph" style="height: 230px;"></div>
                                </div>
                            </div>
                        </div> <!-- /.stat-panel -->
                        <!-- /5. $UPLOADS_CHART -->

                        <!-- 6. $EASY_PIE_CHARTS ===========================================================================
                        
                                                        Easy Pie charts
                        -->
                        <!-- Javascript -->
                        <script>
                            init.push(function () {
                                // Easy Pie Charts
                                var easyPieChartDefaults = {
                                    animate: 2000,
                                    scaleColor: false,
                                    lineWidth: 9,
                                    lineCap: 'square',
                                    size: 90,
                                    trackColor: '#e5e5e5',
                                    barColor: function (percent) {
                                        return (percent < 50 ? '#5cb85c' : percent < 85 ? '#f0ad4e' : '#cb3935');
                                    }

                                };
                                $('.pie-chart').easyPieChart($.extend({}, easyPieChartDefaults, {
                                }));
                                
                            });
                        </script>
                        <!-- / Javascript -->

                        <div class="row">
                            <div class="col-xs-4">
                                <!-- Centered text -->
                                <div class="stat-panel text-center">
                                    <div class="stat-row">
                                        <!-- Dark gray background, small padding, extra small text, semibold text -->
                                        <div class="stat-cell bg-dark-gray padding-sm text-xs text-semibold">
                                            <i class="fa fa-globe"></i>&nbsp;&nbsp;Estanque 1
                                        </div>
                                    </div> <!-- /.stat-row -->
                                    <div class="stat-row">
                                        <!-- Bordered, without top border, without horizontal padding -->
                                        <div class="stat-cell bordered no-border-t no-padding-hr">
                                            <div class="pie-chart" data-percent="80" id="easy-pie-chart-1">
                                                <div class="pie-chart-label">80%</div>
                                            </div>
                                        </div>
                                    </div> <!-- /.stat-row -->
                                </div> <!-- /.stat-panel -->
                            </div>
                            <div class="col-xs-4">
                                <div class="stat-panel text-center">
                                    <div class="stat-row">
                                        <!-- Dark gray background, small padding, extra small text, semibold text -->
                                        <div class="stat-cell bg-dark-gray padding-sm text-xs text-semibold">
                                            <i class="fa fa-flash"></i>&nbsp;&nbsp;Estanque 2
                                        </div>
                                    </div> <!-- /.stat-row -->
                                    <div class="stat-row">
                                        <!-- Bordered, without top border, without horizontal padding -->
                                        <div class="stat-cell bordered no-border-t no-padding-hr">
                                            <div class="pie-chart" data-percent="93" id="easy-pie-chart-2">
                                                <div class="pie-chart-label">93%</div>
                                            </div>
                                        </div>
                                    </div> <!-- /.stat-row -->
                                </div> <!-- /.stat-panel -->
                            </div>
                            <div class="col-xs-4">
                                <div class="stat-panel text-center">
                                    <div class="stat-row">
                                        <!-- Dark gray background, small padding, extra small text, semibold text -->
                                        <div class="stat-cell bg-dark-gray padding-sm text-xs text-semibold">
                                            <i class="fa fa-cloud"></i>&nbsp;&nbsp;Estanque 3
                                        </div>
                                    </div> <!-- /.stat-row -->
                                    <div class="stat-row">
                                        <!-- Bordered, without top border, without horizontal padding -->
                                        <div class="stat-cell bordered no-border-t no-padding-hr">
                                            <div class="pie-chart" data-percent="75" id="easy-pie-chart-3">
                                                <div class="pie-chart-label">12GB</div>
                                            </div>
                                        </div>
                                    </div> <!-- /.stat-row -->
                                </div> <!-- /.stat-panel -->
                            </div>
                            <div class="col-xs-4">
                                <div class="stat-panel text-center">
                                    <div class="stat-row">
                                        <!-- Dark gray background, small padding, extra small text, semibold text -->
                                        <div class="stat-cell bg-dark-gray padding-sm text-xs text-semibold">
                                            <i class="fa fa-cloud"></i>&nbsp;&nbsp;Estanque 3
                                        </div>
                                    </div> <!-- /.stat-row -->
                                    <div class="stat-row">
                                        <!-- Bordered, without top border, without horizontal padding -->
                                        <div class="stat-cell bordered no-border-t no-padding-hr">
                                            <div class="pie-chart" data-percent="75" id="easy-pie-chart-3">
                                                <div class="pie-chart-label">12GB</div>
                                            </div>
                                        </div>
                                    </div> <!-- /.stat-row -->
                                </div> <!-- /.stat-panel -->
                            </div>
                            <div class="col-xs-4">
                                <div class="stat-panel text-center">
                                    <div class="stat-row">
                                        <!-- Dark gray background, small padding, extra small text, semibold text -->
                                        <div class="stat-cell bg-dark-gray padding-sm text-xs text-semibold">
                                            <i class="fa fa-cloud"></i>&nbsp;&nbsp;Estanque 3
                                        </div>
                                    </div> <!-- /.stat-row -->
                                    <div class="stat-row">
                                        <!-- Bordered, without top border, without horizontal padding -->
                                        <div class="stat-cell bordered no-border-t no-padding-hr">
                                            <div class="pie-chart" data-percent="75" id="easy-pie-chart-3">
                                                <div class="pie-chart-label">12GB</div>
                                            </div>
                                        </div>
                                    </div> <!-- /.stat-row -->
                                </div> <!-- /.stat-panel -->
                            </div>
                            <div class="col-xs-4">
                                <div class="stat-panel text-center">
                                    <div class="stat-row">
                                        <!-- Dark gray background, small padding, extra small text, semibold text -->
                                        <div class="stat-cell bg-dark-gray padding-sm text-xs text-semibold">
                                            <i class="fa fa-cloud"></i>&nbsp;&nbsp;Estanque 3
                                        </div>
                                    </div> <!-- /.stat-row -->
                                    <div class="stat-row">
                                        <!-- Bordered, without top border, without horizontal padding -->
                                        <div class="stat-cell bordered no-border-t no-padding-hr">
                                            <div class="pie-chart" data-percent="75" id="easy-pie-chart-3">
                                                <div class="pie-chart-label">12GB</div>
                                            </div>
                                        </div>
                                    </div> <!-- /.stat-row -->
                                </div> <!-- /.stat-panel -->
                            </div>
                            <div class="col-xs-4">
                                <div class="stat-panel text-center">
                                    <div class="stat-row">
                                        <!-- Dark gray background, small padding, extra small text, semibold text -->
                                        <div class="stat-cell bg-dark-gray padding-sm text-xs text-semibold">
                                            <i class="fa fa-cloud"></i>&nbsp;&nbsp;Estanque 3
                                        </div>
                                    </div> <!-- /.stat-row -->
                                    <div class="stat-row">
                                        <!-- Bordered, without top border, without horizontal padding -->
                                        <div class="stat-cell bordered no-border-t no-padding-hr">
                                            <div class="pie-chart" data-percent="75" id="easy-pie-chart-3">
                                                <div class="pie-chart-label">12GB</div>
                                            </div>
                                        </div>
                                    </div> <!-- /.stat-row -->
                                </div> <!-- /.stat-panel -->
                            </div>
                            <div class="col-xs-4">
                                <div class="stat-panel text-center">
                                    <div class="stat-row">
                                        <!-- Dark gray background, small padding, extra small text, semibold text -->
                                        <div class="stat-cell bg-dark-gray padding-sm text-xs text-semibold">
                                            <i class="fa fa-cloud"></i>&nbsp;&nbsp;Estanque 3
                                        </div>
                                    </div> <!-- /.stat-row -->
                                    <div class="stat-row">
                                        <!-- Bordered, without top border, without horizontal padding -->
                                        <div class="stat-cell bordered no-border-t no-padding-hr">
                                            <div class="pie-chart" data-percent="75" id="easy-pie-chart-3">
                                                <div class="pie-chart-label">12GB</div>
                                            </div>
                                        </div>
                                    </div> <!-- /.stat-row -->
                                </div> <!-- /.stat-panel -->
                            </div>
                            <div class="col-xs-4">
                                <div class="stat-panel text-center">
                                    <div class="stat-row">
                                        <!-- Dark gray background, small padding, extra small text, semibold text -->
                                        <div class="stat-cell bg-dark-gray padding-sm text-xs text-semibold">
                                            <i class="fa fa-cloud"></i>&nbsp;&nbsp;Estanque 3
                                        </div>
                                    </div> <!-- /.stat-row -->
                                    <div class="stat-row">
                                        <!-- Bordered, without top border, without horizontal padding -->
                                        <div class="stat-cell bordered no-border-t no-padding-hr">
                                            <div class="pie-chart" data-percent="75" id="easy-pie-chart-3">
                                                <div class="pie-chart-label">12GB</div>
                                            </div>
                                        </div>
                                    </div> <!-- /.stat-row -->
                                </div> <!-- /.stat-panel -->
                            </div>
                            <div class="col-xs-4">
                                <div class="stat-panel text-center">
                                    <div class="stat-row">
                                        <!-- Dark gray background, small padding, extra small text, semibold text -->
                                        <div class="stat-cell bg-dark-gray padding-sm text-xs text-semibold">
                                            <i class="fa fa-cloud"></i>&nbsp;&nbsp;Estanque 3
                                        </div>
                                    </div> <!-- /.stat-row -->
                                    <div class="stat-row">
                                        <!-- Bordered, without top border, without horizontal padding -->
                                        <div class="stat-cell bordered no-border-t no-padding-hr">
                                            <div class="pie-chart" data-percent="75" id="easy-pie-chart-3">
                                                <div class="pie-chart-label">12GB</div>
                                            </div>
                                        </div>
                                    </div> <!-- /.stat-row -->
                                </div> <!-- /.stat-panel -->
                            </div>
                            <div class="col-xs-4">
                                <div class="stat-panel text-center">
                                    <div class="stat-row">
                                        <!-- Dark gray background, small padding, extra small text, semibold text -->
                                        <div class="stat-cell bg-dark-gray padding-sm text-xs text-semibold">
                                            <i class="fa fa-cloud"></i>&nbsp;&nbsp;Estanque 3
                                        </div>
                                    </div> <!-- /.stat-row -->
                                    <div class="stat-row">
                                        <!-- Bordered, without top border, without horizontal padding -->
                                        <div class="stat-cell bordered no-border-t no-padding-hr">
                                            <div class="pie-chart" data-percent="75" id="easy-pie-chart-3">
                                                <div class="pie-chart-label">12%</div>
                                            </div>
                                        </div>
                                    </div> <!-- /.stat-row -->
                                </div> <!-- /.stat-panel -->
                            </div>
                            <div class="col-xs-4">
                                <div class="stat-panel text-center">
                                    <div class="stat-row">
                                        <!-- Dark gray background, small padding, extra small text, semibold text -->
                                        <div class="stat-cell bg-dark-gray padding-sm text-xs text-semibold">
                                            <i class="fa fa-cloud"></i>&nbsp;&nbsp;Estanque 3
                                        </div>
                                    </div> <!-- /.stat-row -->
                                    <div class="stat-row">
                                        <!-- Bordered, without top border, without horizontal padding -->
                                        <div class="stat-cell bordered no-border-t no-padding-hr">
                                            <div class="pie-chart" data-percent="75" id="easy-pie-chart-3">
                                                <div class="pie-chart-label">12GB</div>
                                            </div>
                                        </div>
                                    </div> <!-- /.stat-row -->
                                </div> <!-- /.stat-panel -->
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /9. $UNIQUE_VISITORS_STAT_PANEL -->

                <!-- Page wide horizontal line -->
                <hr class="no-grid-gutter-h grid-gutter-margin-b no-margin-t">

            </div> <!-- / #content-wrapper -->
            <div id="main-menu-bg"></div>
        </div> <!-- / #main-wrapper -->

        <!-- Get jQuery from Google CDN -->
        <!--[if !IE]> -->
        <script type="text/javascript"> window.jQuery || document.write('<script src="../assets/javascripts/jquery.min.js">' + "<" + "/script>");</script>
        <!-- <![endif]-->

        <!-- LanderApp's javascripts -->
        <script src="../js/carga_base.js"></script>
        <script src="../js/paginas/index.js"></script>
        <script src="../assets/javascripts/bootstrap.min.js"></script>
        <script src="../assets/javascripts/landerapp.min.js"></script>

        <script type="text/javascript">
            init.push(function () {
                
            });
            window.LanderApp.start(init);
        </script>

    </body>
</html>