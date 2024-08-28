<div class="form-group col-md-4">
    <label>Fecha de Firma Desde/Hasta</label>

    <div class="input-group">
        <div class="input-group-addon">
            <i class="fa fa-clock-o"></i>
        </div>
        <input type="text" name="fecha_firma" class="form-control pull-right" id="fecha_firma">
        
    </div>
    
</div>
<?php echo $this->Html->css('AdminLTE./plugins/bootstrap-daterangepicker/daterangepicker', ['block' => 'css']); ?>
<?php echo $this->Html->script('AdminLTE./plugins/moment/min/moment.min', ['block' => 'script']); ?>
<?php echo $this->Html->script('AdminLTE./plugins/bootstrap-daterangepicker/daterangepicker', ['block' => 'script']); ?>
<?php
$fecha_actual = new DateTime();
// Obtener la fecha menos 60 días
$fecha_menos_60_dias = new DateTime();
$fecha_menos_60_dias->modify('-60 days');
?>

<script>
    $('#fecha_firma').daterangepicker({
        "locale": {
            "direction": "ltr",
            "format": 'DD/MM/YYYY',
            "separator": " - ",
            "applyLabel": "Aplicar",
            "cancelLabel": "Cancelar",
            "fromLabel": "Desde",
            "toLabel": "Hasta",


        },
        // "dateLimit": {
        //      "days": 365,
        //  },

        // "minDate": moment().startOf('year'), // Establece la fecha mínima como el primer día del año actual
        // "maxDate": moment().endOf('year'),
        // minDate: moment().add(10, 'days').calendar(),
        "showWeekNumbers":true,
       // "maxDate": moment().add(2, 'days').calendar(),
        "startDate": <?php echo (isset($startDate) and !empty($startDate)) ? "'" . $startDate . "'" : "'" . $fecha_menos_60_dias->format('d/m/y') . "'" ?>,
        "endDate": <?php echo (isset($endDate) and !empty($startDate)) ?  "'" . $endDate . "'" :  "'" . $fecha_actual->format('d/m/y') . "'" ?>,
        "opens": "right",
        "drops": "up"

    })
</script>
<!-- /.input group -->