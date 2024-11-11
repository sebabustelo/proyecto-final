<!-- Content Header (Page header) -->
<?php setlocale(LC_TIME, 'es_ES.UTF-8'); ?>
<section class="content-header">
    <h1>
        Informes

    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-area-chart"></i> Informes</a></li>
        <li class="active">index</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12 ">
            <div class="info-box">
                <div class="info-box-content">
                    <form method="get" accept-charset="utf-8" class="form abox" id="formOrderFilter" action="/Informes/index">
                        <div class=" form-row">
                            <div class="form-group col-md-8">
                                <label for="">Rango de fecha de pedidos</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control" value="<?php echo (isset($filters['fecha_pedido'])) ? $filters['fecha_pedido'] : '' ?>" id="fecha_pedido" name="fecha_pedido" placeholder="fecha desde - fecha hasta">
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">&nbsp;</label>
                                <div class="input-group">

                                    <button type="submit" id="enviar" class="btn btn-primary">
                                        <span class="glyphicon glyphicon-search"></span>
                                        Buscar
                                    </button>
                                </div>


                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Info boxes -->
    <div class="row">

        <!-- /.col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="ion ion-ios-cart-outline"></i></span>


                <div class="info-box-content">
                    <span class="info-box-text">Pedidos PENDIENTES</span>
                    <span class="info-box-number">41</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-lg fa-dollar"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Ventas</span>
                    <span class="info-box-number">74</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Nuevos Clientes</span>
                    <span class="info-box-number"><?php echo count($clientes); ?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Informe mensual de ventas</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="text-center">
                                <strong>Ventas: <?php echo $filters['fecha_pedido'] ?></strong>
                            </p>

                            <div class="chart">
                                <!-- Sales Chart Canvas -->
                                <canvas id="salesChart" style="height: 180px;"></canvas>
                            </div>
                            <!-- /.chart-responsive -->
                        </div>
                        <!-- /.col -->
                       
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- ./box-body -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-sm-12 col-xs-6">
                            <div class="description-block border-right">

                                <h5 class="description-header">$35,210.43</h5>
                                <span class="description-text">INGRESOS TOTALES</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->

                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.box-footer -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Main row -->
    <div class="row">
        <!-- Left col -->
        <div class="col-md-12">



            <!-- /.col -->

            <div class="row">

                <!-- /.col -->

                <div class="col-md-12">
                    <!-- USERS LIST -->
                    <div class="box">
                        <div class="box box-danger">
                            <div class="box-header with-border">
                                <h3 class="box-title">Registros de últimos clientes <?php echo $filters['fecha_pedido']  ?> (máximo 8)</h3>

                                <div class="box-tools pull-right">
                                    <span class="label label-danger"><?php echo count($clientes); ?> clientes nuevos</span>
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body ">
                                <ul class="users-list clearfix">
                                    <?php                                  
                                    $meses = [
                                        '01' => 'Ene',
                                        '02' => 'Feb',
                                        '03' => 'Mar',
                                        '04' => 'Abr',
                                        '05' => 'May',
                                        '06' => 'Jun',
                                        '07' => 'Jul',
                                        '08' => 'Ago',
                                        '09' => 'Sep',
                                        '10' => 'Oct',
                                        '11' => 'Nov',
                                        '12' => 'Dic'
                                    ];

                                    ?>
                                    <?php 
                                    //muestra como maximo 8 registros
                                    $cantidadClientes = 0;
                                    foreach ($clientes as $k => $cliente) { 
                                        $dia = $cliente->created->format('d');
                                        $mes = $meses[$cliente->created->format('m')]; 
                                        $cantidadClientes = $cantidadClientes +1;
                                        if($cantidadClientes== 9){
                                            break;
                                        }
                                        ?>
                                        <li>
                                            <img src="/img/user-profile.png" style="width: 75px;" alt="User Avatar" class="img-circle">
                                            <a target="_blank" class="users-list-name" href="/rbac/RbacUsuarios/edit/<?php echo $cliente['id']; ?>">
                                                <?php echo $cliente['nombre'] . " " . $cliente['apellido']; ?></a>
                                            <span class="users-list-date"><?php echo  $dia . ' ' . $mes; ?></span>
                                        </li>
                                    <?php } ?>

                                </ul>
                                <!-- /.users-list -->
                            </div>
                            <br>

                            <!-- /.box-footer -->
                        </div>
                    </div>
                    <!--/.box -->
                </div>
               


                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- TABLE: LATEST ORDERS -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Pedidos <?php echo $filters['fecha_pedido'] ?></h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table no-margin">
                            <thead>
                                <tr>
                                    <th>Pedido</th>
                                    <th>Producto</th>
                                    <th>Estado</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><a href="pages/examples/invoice.html">OR9842</a></td>
                                    <td>Call of Duty IV</td>
                                    <td><span class="label label-success">Enviado</span></td>

                                </tr>
                                <tr>
                                    <td><a href="pages/examples/invoice.html">OR1848</a></td>
                                    <td>Samsung Smart TV</td>
                                    <td><span class="label label-warning">Pendiente</span></td>

                                </tr>
                                <tr>
                                    <td><a href="pages/examples/invoice.html">OR7429</a></td>
                                    <td>iPhone 6 Plus</td>
                                    <td><span class="label label-danger">Entregado</span></td>

                                </tr>
                                <tr>
                                    <td><a href="pages/examples/invoice.html">OR7429</a></td>
                                    <td>Samsung Smart TV</td>
                                    <td><span class="label label-info">En proceso</span></td>

                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
                    <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>
                </div>
                <!-- /.box-footer -->
            </div>
            <!-- /.box -->


        </div>
        <!-- /.row -->
</section>
<!-- /.content -->

<!-- ChartJS -->
<?php echo $this->Html->script('AdminLTE./bower_components/chart.js/Chart', ['block' => 'script']); ?>
<?php //echo $this->Html->script('informes', ['block' => 'script']); 
?>
<script>
    // Calcular el rango de los últimos 30 días
    const startOfLast30Days = moment().subtract(30, 'days').format('DD/MM/YYYY');
    const endOfToday = moment().format('DD/MM/YYYY');

    $('#fecha_pedido').daterangepicker({
        "locale": {
            "direction": "ltr",
            "format": 'DD/MM/YYYY',
            "separator": " - ",
            "applyLabel": "Aplicar",
            "cancelLabel": "Cancelar",
            "fromLabel": "Desde",
            "toLabel": "Hasta",
        },
        "showWeekNumbers": true,
        "opens": "right",
        "autoUpdateInput": true,
        // "startDate": moment().subtract(30, 'days'), // Fecha de inicio: 30 días antes de hoy
        //  "endDate": moment() // Fecha de fin: hoy
    });

    let fechas = "<?php echo isset($filters['fecha_pedido']) ? $filters['fecha_pedido'] : ''; ?>";

    // Si la variable fechas tiene un rango de fechas, se asignan al daterangepicker
    if (fechas) {
        var dateRange = fechas.split(' - ');
        $('#fecha_pedido').val(fechas);
        $('#fecha_pedido').data('daterangepicker').setStartDate(dateRange[0]);
        $('#fecha_pedido').data('daterangepicker').setEndDate(dateRange[1]);
    }

    // $('#fecha_pedido').on('apply.daterangepicker', function(ev, picker) {
    //     $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
    // });

    // $('#fecha_pedido').on('cancel.daterangepicker', function(ev, picker) {
    //     $(this).val('');
    // });

    $(function() {
        "use strict";

        /* ChartJS
         * -------
         * Here we will create a few charts using ChartJS
         */

        // -----------------------
        // - MONTHLY SALES CHART -
        // -----------------------

        // Get context with jQuery - using jQuery's .get() method.
        var salesChartCanvas = $("#salesChart").get(0).getContext("2d");
        // This will get the first returned node in the jQuery collection.
        var salesChart = new Chart(salesChartCanvas);

        <?php
        $meses = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre'
        ];

        $mesLabels = [];
        foreach ($mesesRango as $k => $pedido) {
            // Mapeo de mes numérico a nombre
            $mesLabels[] = $meses[$pedido['mes']];
            $totalPedidos[] = $pedido['total_pedidos'];
        }
        ?>

        var mesesLabels = <?php echo json_encode($mesLabels); ?>; // Los nombres de los meses
        var pedidosPorMes = <?php echo json_encode($totalPedidos); ?>; // Los totales de pedidos por mes

        var salesChartData = {


            labels:  mesesLabels, 
            datasets: [{
                label: "Pedidos",
                fillColor: "rgba(60,141,188,0.9)",
                strokeColor: "rgba(60,141,188,0.8)",
                pointColor: "#3b8bba",
                pointStrokeColor: "rgba(60,141,188,1)",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(60,141,188,1)",
                data: pedidosPorMes,
            }, ],
        };

        var salesChartOptions = {
            // Boolean - If we should show the scale at all
            showScale: true,
            // Boolean - Whether grid lines are shown across the chart
            scaleShowGridLines: false,
            // String - Colour of the grid lines
            scaleGridLineColor: "rgba(0,0,0,.05)",
            // Number - Width of the grid lines
            scaleGridLineWidth: 1,
            // Boolean - Whether to show horizontal lines (except X axis)
            scaleShowHorizontalLines: true,
            // Boolean - Whether to show vertical lines (except Y axis)
            scaleShowVerticalLines: true,
            // Boolean - Whether the line is curved between points
            bezierCurve: true,
            // Number - Tension of the bezier curve between points
            bezierCurveTension: 0.3,
            // Boolean - Whether to show a dot for each point
            pointDot: false,
            // Number - Radius of each point dot in pixels
            pointDotRadius: 4,
            // Number - Pixel width of point dot stroke
            pointDotStrokeWidth: 1,
            // Number - amount extra to add to the radius to cater for hit detection outside the drawn point
            pointHitDetectionRadius: 20,
            // Boolean - Whether to show a stroke for datasets
            datasetStroke: true,
            // Number - Pixel width of dataset stroke
            datasetStrokeWidth: 2,
            // Boolean - Whether to fill the dataset with a color
            datasetFill: true,
            // String - A legend template
            legendTemplate: "<ul class='<%=name.toLowerCase()%>-legend'><% for (var i=0; i<datasets.length; i++){%><li><span style='background-color:<%=datasets[i].lineColor%>'></span><%=datasets[i].label%></li><%}%></ul>",
            // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio: true,
            // Boolean - whether to make the chart responsive to window resizing
            responsive: true,
        };

        // Create the line chart
        salesChart.Line(salesChartData, salesChartOptions);







    });
</script>