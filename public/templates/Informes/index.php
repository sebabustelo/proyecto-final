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
                <?php $cantidadVentas = count($pedidos_pagados); ?>

                <div class="info-box-content">
                    <span class="info-box-text">Ventas</span>
                    <span class="info-box-number"><?php echo $cantidadVentas; ?></span>
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
                    <span class="info-box-number"><?php echo number_format($total, 0, ',', '.'); ?></span>
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
                    <h3 class="box-title">Informe mensual de pedidos</h3>

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
                                <strong>Período: <?php echo $filters['fecha_pedido'] ?></strong>
                            </p>

                            <div class="chart">
                                <div id="chart-legend"></div>
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

                                <!-- <h5 class="description-header">$35,210.43</h5>
                                <span class="description-text">INGRESOS TOTALES</span> -->
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
                                <h3 class="box-title">Últimos clientes registrados <?php echo $filters['fecha_pedido']  ?> (máximo 8)</h3>

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
                                        $cantidadClientes = $cantidadClientes + 1;
                                        if ($cantidadClientes == 9) {
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
                    <h3 class="box-title">Últimos pedidos registrados <?php echo $filters['fecha_pedido'] ?> (máximo 10)</h3>

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
                                    <th>Fecha Pedido</th>
                                    <th>Producto</th>
                                    <th>Estado</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $cantidadPedidos = count($pedidos); ?>
                                <?php foreach ($pedidos as $k => $pedido) { ?>
                                    <tr>
                                        <td><a target="_blank" href="/pedidos/edit/<?php echo $pedido['id']; ?>"> <?php echo $this->Time->format($pedido->fecha_pedido, 'dd/MM/Y HH:mm:ss'); ?></a></td>
                                        <td><?php echo $pedido->detalles_pedidos[0]->producto->nombre ?></td>
                                        <td>
                                            <small class="label
                                                    <?php
                                                    switch ($pedido->pedidos_estado->nombre) {
                                                        case 'PENDIENTE':
                                                            echo 'bg-yellow'; // Fondo amarillo
                                                            break;
                                                        case 'INCOMPLETO':
                                                            echo 'bg-red'; // Fondo rojo
                                                            break;
                                                        case 'EN_PROCESO':
                                                            echo 'bg-blue'; // Fondo azul
                                                            break;
                                                        case 'PAGADO':
                                                            echo 'bg-purple'; // Fondo morado
                                                            break;
                                                        case 'EN_CAMINO':
                                                            echo 'bg-orange'; // Fondo naranja
                                                            break;
                                                        case 'FINALIZADO':
                                                            echo 'bg-green'; // Fondo verde
                                                            break;
                                                        case 'CANCELADO':
                                                            echo 'bg-red'; // Fondo verde
                                                            break;
                                                        default:
                                                            echo 'bg-gray'; // Fondo gris por defecto
                                                            break;
                                                    }
                                                    ?>">
                                                <?php echo $pedido->pedidos_estado->nombre; ?>
                                            </small>
                                        </td>

                                    </tr>
                                <?php
                                    if ($cantidadPedidos == 11) {
                                        break;
                                    }
                                } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->


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
            $totalPedidosCancelados[] = $pedido['total_pedidos_cancelados'];
            $totalPedidosPendientes[] = $pedido['total_pedidos_pendientes'];
            $totalPedidosEnProcesos[] = $pedido['total_pedidos_en_procesos'];
            $totalVentas[] = $pedido['total_ventas'];
        }
        ?>

        var mesesLabels = <?php echo json_encode($mesLabels); ?>; // Los nombres de los meses
        var pedidosPorMes = <?php echo json_encode($totalPedidos); ?>; // Los totales de pedidos por mes
        var pedidosCanceladosPorMes = <?php echo json_encode($totalPedidosCancelados); ?>;
        var pedidosPendientesPorMes = <?php echo json_encode($totalPedidosPendientes); ?>;
        var pedidosEnProcesosPorMes = <?php echo json_encode($totalPedidosEnProcesos); ?>;
        var ventasPorMes = <?php echo json_encode($totalVentas); ?>; // Los totales de ventas por mes

        console.log(pedidosPorMes)
        console.log(pedidosCanceladosPorMes)
        console.log(pedidosPendientesPorMes)
        console.log(ventasPorMes)

        var salesChartData = {
            labels: mesesLabels,

            datasets: [{
                    label: 'Pedidos Realizados',
                    fillColor: 'rgba(210, 214, 222, 0.3)', // Mayor transparencia
                    strokeColor: 'rgba(210, 214, 222, 0.5)', // Moderada transparencia
                    pointColor: 'rgba(210, 214, 222, 0.5)',
                    pointStrokeColor: 'rgba(193, 199, 209, 0.6)', // Con un poco de transparencia
                    pointHighlightFill: 'rgba(255, 255, 255, 0.8)', // Algo de transparencia en el highlight
                    pointHighlightStroke: 'rgba(220, 220, 220, 0.6)',
                    data: pedidosPorMes,
                },
                {
                    label: 'Pedidos Cancelados',
                    fillColor: 'rgba(255, 99, 132, 0.1)', // Rojo claro con mayor transparencia
                    strokeColor: 'rgba(255, 99, 132, 0.5)', // Rojo moderado con transparencia
                    pointColor: 'rgba(255, 99, 132, 0.5)', // Rojo para puntos
                    pointStrokeColor: 'rgba(200, 80, 120, 0.6)', // Rojo oscuro con algo de transparencia
                    pointHighlightFill: 'rgba(255, 255, 255, 0.8)', // Blanco con algo de transparencia
                    pointHighlightStroke: 'rgba(255, 99, 132, 0.6)', // Rojo con moderada transparencia
                    data: pedidosCanceladosPorMes,
                },
                {
                    label: 'Pedidos Pendientes',
                    fillColor: 'rgba(255, 165, 0, 0.2)', // Naranja claro con mayor transparencia
                    strokeColor: 'rgba(255, 165, 0, 0.5)', // Naranja moderado con algo de transparencia
                    pointColor: 'rgba(255, 165, 0, 0.5)', // Naranja para los puntos
                    pointStrokeColor: 'rgba(255, 140, 0, 0.6)', // Naranja más oscuro con algo de transparencia
                    pointHighlightFill: 'rgba(255, 255, 255, 0.8)', // Blanco para resaltado con algo de transparencia
                    pointHighlightStroke: 'rgba(255, 165, 0, 0.6)', // Naranja moderado con transparencia
                    data: pedidosPendientesPorMes,
                },
                {
                    label: 'Pedidos En Proceso',
                    fillColor: 'rgba(173, 216, 230, 0.2)', // Azul claro con mucha transparencia
                    strokeColor: 'rgba(173, 216, 230, 0.5)', // Azul moderado con algo de transparencia
                    pointColor: 'rgba(173, 216, 230, 0.5)', // Azul para los puntos
                    pointStrokeColor: 'rgba(135, 206, 235, 0.6)', // Azul más intenso con algo de transparencia
                    pointHighlightFill: 'rgba(255, 255, 255, 0.8)', // Blanco para resaltado con algo de transparencia
                    pointHighlightStroke: 'rgba(173, 216, 230, 0.6)', // Azul moderado con transparencia
                    data: pedidosEnProcesosPorMes, // Asumiendo que los datos son los mismos
                },
                {
                    label: 'Pedidos Pagados',
                    fillColor: 'rgba(96, 92, 168, 0.3)', // Más transparencia para el fondo
                    strokeColor: 'rgba(96, 92, 168, 0.5)', // Líneas con moderada transparencia
                    pointColor: 'rgba(96, 92, 168, 0.6)', // Transparencia en puntos
                    pointStrokeColor: 'rgba(96, 92, 168, 0.6)', // Transparente en bordes de punto
                    pointHighlightFill: 'rgba(255, 255, 255, 0.8)', // Highlight transparente
                    pointHighlightStroke: 'rgba(96, 92, 168, 0.6)', // Bordes de highlight
                    data: ventasPorMes,
                }
            ],
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
            pointDot: true,
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

        // Genera la leyenda manualmente con el color de la línea (strokeColor)
        var legendHtml = '<ul>';
        salesChartData.datasets.forEach(function(dataset) {
            legendHtml += '<li style=" list-style: none;"><span style="display:inline-block;width:12px;height:12px;background-color:' + dataset.strokeColor + ';margin-right:5px;"></span>' + dataset.label + '</li>';
        });
        legendHtml += '</ul>';

        // Agrega la leyenda al contenedor #chart-legend
        $('#chart-legend').html(legendHtml);



    });
</script>
