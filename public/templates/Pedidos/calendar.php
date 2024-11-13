<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <i class="fa fa-cubes"></i> Gestión de Pedidos
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa  fa-dot-circle-o"></i>Pedidos</a></li> <i class="fa fa-arrow-right"></i>
        <li class="active">Agenda</li>
    </ol>
</section>

<section class="content">
    <div class="row">

        <!-- /.col -->
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"> <span class="fa fa-calendar fa-lg"></span> Agenda</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- Leyenda de colores -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-3">
                            <span class="badge" style="background-color: #f39c12;"> </span> Pedido Pendiente
                        </div>
                        <div class="col-md-3">
                            <span class="badge" style="background-color: #0073b7;"> </span> Pedido En Proceso
                        </div>
                        <div class="col-md-3">
                            <span class="badge" style="background-color: #00a65a;"> </span> Pedido Pagado
                        </div>
                        <div class="col-md-3">
                            <span class="badge" style="background-color: #f56954;"> </span> Pedido Cancelado
                        </div>
                    </div>
                </div>
                <!-- THE CALENDAR -->
                <div id="calendar"></div>

                <!-- Leyenda de colores -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-3">
                            <span class="badge" style="background-color: #f39c12;"> </span> Pedido Pendiente
                        </div>
                        <div class="col-md-3">
                            <span class="badge" style="background-color: #0073b7;"> </span> Pedido En Proceso
                        </div>
                        <div class="col-md-3">
                            <span class="badge" style="background-color: #00a65a;"> </span> Pedido Pagado
                        </div>
                        <div class="col-md-3">
                            <span class="badge" style="background-color: #f56954;"> </span> Pedido Cancelado
                        </div>
                    </div>
                </div>

                <!-- /.box-body -->
            </div>
            <!-- /. box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>


<!-- fullCalendar -->
<?php echo $this->Html->css('AdminLTE./bower_components/fullcalendar/dist/fullcalendar.min', ['block' => 'css']); ?>
<?php echo $this->Html->css('AdminLTE./bower_components/fullcalendar/dist/fullcalendar.print.min', ['block' => 'css', 'media' => 'print']); ?>

<!-- jQuery UI 1.11.4 -->
<?php echo $this->Html->script('AdminLTE./bower_components/jquery-ui/jquery-ui.min', ['block' => 'script']); ?>
<!-- fullCalendar -->
<?php echo $this->Html->script('AdminLTE./bower_components/moment/moment', ['block' => 'script']); ?>
<?php echo $this->Html->script('AdminLTE./bower_components/fullcalendar/dist/fullcalendar.min', ['block' => 'script']); ?>
<?php echo $this->Html->script('AdminLTE./bower_components/fullcalendar/dist/locale/es.js', ['block' => 'script']); ?>


<?php $this->start('scriptBottom'); ?>
<script>
    $(function() {

        /* initialize the calendar
         -----------------------------------------------------------------*/

        var pedidos = <?php echo json_encode(array_map(function ($pedido) {
                            // Convertimos la fecha a un formato ISO adecuado
                            $pedido->fecha_pedido = $pedido->fecha_pedido->format('Y-m-d H:i:s'); // Este es el formato 'YYYY-MM-DD HH:MM:SS'
                            return $pedido;
                        }, $pedidos)); ?>;

        var events = pedidos.map(function(pedido) {
            // Definir color según el estado del pedido
            var backgroundColor;
            var borderColor;

            // Asignar colores basados en estado
            if (pedido.estado_id === 2) {
                backgroundColor = '#f39c12'; // Naranja pendiente
                borderColor = '#f39c12';
            } else if (pedido.estado_id === 5) {
                backgroundColor = '#00a65a'; // Verde pagado
                borderColor = '#00a65a';
            } else if (pedido.estado_id === 3) {
                backgroundColor = '#0073b7'; // Azul en proceso
                borderColor = '#0073b7';
            } else if (pedido.estado_id === 4) {
                backgroundColor = '#f56954'; // Rojo cancelado
                borderColor = '#f56954';
            } else {
                backgroundColor = '#cccccc'; // Gris para estados desconocidos
                borderColor = '#cccccc';
            }

            return {
                title: 'Cliente: ' + pedido.cliente.nombre + ' ' + pedido.cliente.apellido, // Aquí se pone la aclaración del pedido como título
                start: pedido.fecha_pedido,
                backgroundColor: backgroundColor, // Color dinámico basado en el estado
                url: '/pedidos/edit/' + pedido.id,
                allDay: true,
                borderColor: borderColor, // El borde del evento con el mismo color
            };
        });

        $('#calendar').fullCalendar({
            locale: 'es', // Configurar el idioma en español
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            buttonText: {
                today: 'hoy',
                month: 'mes',
                week: 'semana',
                day: 'día'
            },

            //Random default events
            events: events,
            // Manejo de evento click
            eventClick: function(event) {
                window.open(event.url, '_blank'); // Abrir la URL en una nueva pestaña
                return false; // Prevenir la acción predeterminada (como ir a la URL)
            },
            editable: false,
            droppable: false,
        })


    })
</script>
<?php $this->end(); ?>
<style>
    a:hover,
    a:active,
    a:focus {
        color: #fff;
    }
</style>