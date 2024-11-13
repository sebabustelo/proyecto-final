<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Proveedor> $proveedor
 */
?>
<section class="content-header">
    <h1>
        <i class="fa fa-cubes"></i> Gestión de Pedidos
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa  fa-dot-circle-o"></i>Pedidos</a></li> <i class="fa fa-arrow-right"></i>
        <li class="active">Listado</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header  with-border">
                    <h3 class="box-title"> <span class="fa fa-search fa-lg"></span> Buscador</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <form method="get" accept-charset="utf-8" class="form abox" id="formOrderFilter" action="/Pedidos/index">
                        <div class="form-row">
                            <div class="form-group col-md-3">

                                <select name="estado_id" class="form-control" id="estado" aria-label="estado">
                                    <option value="">Seleccione un estado</option>
                                    <?php foreach ($estados as $id => $estado) : ?>
                                        <option value="<?php echo $id; ?>" <?php echo (isset($filters['estado_id']) && $filters['estado_id'] == $id) ? 'selected' : '' ?>>
                                            <?php echo $estado; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                            <input type="text" placeholder="Número de Doc." maxlength="11"
                                    class="form-control"
                                    value="<?php echo (isset($filters['documento'])) ? $filters['documento'] : '' ?>"
                                    name="documento" id="documento"
                                    oninput="validateDocumentInput()"
                                    onkeydown="if(event.key === '-' || event.key === ' ' || event.key === '+') event.preventDefault();">

                            </div>

                            <div class="form-group col-md-3">
                                <input type="text" name="apellido"
                                placeholder="Apellido" class="form-control" id="nombre"
                                aria-label="nombre"
                                maxlength="50"
                                value="<?php echo (isset($filters['nombre'])) ? $filters['nombre'] : '' ?>">
                            </div>
                            <div class="form-group col-md-3">
                                <input type="email" name="email" placeholder="Correo electrónico"
                                class="form-control" id="nombre" aria-label="email"
                                  maxlength="50"
                                value="<?php echo (isset($filters['email'])) ? $filters['email'] : '' ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">&nbsp;</label>
                                <input type="text" name="producto" placeholder="Producto" class="form-control" id="nombre" aria-label="producto"
                                value="<?php echo (isset($filters['producto'])) ? $filters['producto'] : '' ?>">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="">Fecha de pedido</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control" value="<?php echo (isset($filters['fecha_pedido'])) ? $filters['fecha_pedido'] : '' ?>" id="fecha_pedido" name="fecha_pedido" placeholder="fecha desde - fecha hasta">
                                </div>
                                <!-- /.input group -->
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">Fecha de intervención</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right"
                                    value="<?php echo (isset($filters['fecha_intervencion'])) ? $filters['fecha_intervencion'] : '' ?>"
                                    id="fecha_intervencion" name="fecha_intervencion" placeholder="fecha desde - fecha hasta">
                                </div>
                                <!-- /.input group -->
                            </div>
                        </div>

                        <div class=" form-row">
                            <div class="form-group col-md-12 text-center ">
                                <button type="button" id="limpiar" class="btn btn-default">
                                    <span class="glyphicon glyphicon-trash"></span>
                                    Limpiar
                                </button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <button type="submit" id="enviar" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-search"></span>
                                    Buscar
                                </button>

                                <script>
                                    $(function() {
                                        $('#limpiar').on('click', function() {
                                            $('#formOrderFilter').find(
                                                'input:text, input:password,  input[type="email"], select, textarea').val('');
                                            // $('#formOrderFilter').find(
                                            //     'input:radio, input:checkbox:not(#activo)').prop(
                                            //     'checked', false);
                                            // document.getElementById("activo").checked = true;

                                            $('#formOrderFilter').submit();

                                            return false;
                                        });
                                    });
                                </script>
                                <div id="filterErrors">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header  with-border">
                    <h3 class="box-title"> <span class="fa fa-list"></span> Pedidos</h3>
                    <div class="box-tools pull-right">
                        <?php if (!empty($accionesPermitidas['Pedidos']['add'])) { ?>
                            <a title="Agregar pedido" href="/Pedidos/add/" class="btn btn-primary btn-sm ">
                                <span class="glyphicon glyphicon-plus-sign"></span> <span class="buttonText hidden-xs">Nuevo Pedido</span>
                            </a>
                        <?php } ?>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">

                    <?php if (isset($pedidos)) { ?>
                        <?php if (count($pedidos) > 0) { ?>
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th class="col-sm-2">
                                                <?php echo $this->Paginator->sort('PedidosEstados.nombre', 'Estado'); ?>
                                            </th>
                                            <th class="col-sm-3">
                                                <?php echo $this->Paginator->sort('RbacUsuarios.nombre', __('Cliente')); ?>
                                            </th>
                                            <th class="col-sm-2">
                                                <?php echo $this->Paginator->sort('Productos.nombre', __('Productos')); ?>
                                            </th>
                                            <th class="hidden-xs col-sm-2">
                                                <?php echo $this->Paginator->sort('Pedidos.fecha_pedido', 'Fecha de Pedido'); ?>
                                            </th>
                                            <th class="hidden-xs col-sm-2">
                                                <?php echo $this->Paginator->sort('Pedidos.fecha_intervencion', ' Fecha de Intervención'); ?>

                                            </th class="hidden-xs col-sm-2">
                                            <th>
                                            </th>
                                            <th>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <td colspan="12">
                                                <div class="text-center">
                                                    <ul class="pagination justify-content-center">
                                                        <li class="page-item">
                                                            <?php echo $this->Paginator->first('<<'); ?>
                                                            <?php echo $this->Paginator->prev('<'); ?>
                                                        </li>
                                                        <li class="page-item">
                                                            <?php echo $this->Paginator->numbers(['modulus' => 4]); ?>
                                                        </li>
                                                        <li class="page-item">
                                                            <?php echo $this->Paginator->next('>'); ?>
                                                            <?php echo $this->Paginator->last('>>'); ?>
                                                        </li>
                                                    </ul>
                                                    <p class="text-center">
                                                        Página: <?php echo $this->Paginator->counter('{{page}} de {{pages}}, mostrando {{current}} pedidos de {{count}}'); ?>
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php foreach ($pedidos as $pedido) {  ?>
                                            <tr>
                                                <td class="hidden-xs">
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
                                                <td>
                                                    <?php echo $pedido->cliente->tipo_documento->descripcion . ":" . $pedido->cliente->documento; ?><br>
                                                    <?php if (!empty($pedido->cliente->apellido)) { ?>
                                                        <?php echo $pedido->cliente->apellido . ", " . $pedido->cliente->nombre; ?><br>
                                                    <?php } else { ?>
                                                        <?php echo $pedido->cliente->razon_social; ?><br>
                                                    <?php } ?>
                                                    <?php echo $pedido->cliente->email; ?>
                                                </td>
                                                <td>
                                                    <?php echo $pedido->detalles_pedidos[0]->producto->nombre; ?>
                                                </td>
                                                <td class="hidden-xs">
                                                    <?php echo $this->Time->format($pedido->fecha_pedido, 'dd/MM/Y HH:mm:ss'); ?>
                                                </td>
                                                <td>
                                                    <?php echo $this->Time->format($pedido->fecha_intervencion, 'dd/MM/Y'); ?>
                                                </td>
                                                <td class="pencil">
                                                    <?php if ((isset($accionesPermitidas['Pedidos']['edit']) && $accionesPermitidas['Pedidos']['edit'])) { ?>
                                                        <?php if ($pedido->pedidos_estado->nombre != 'CANCELADO') {  ?>
                                                            <?php if ((isset($accionesPermitidas['Pedidos']['edit']) && $accionesPermitidas['Pedidos']['edit'])) { ?>
                                                                <a href="/Pedidos/edit/<?php echo $pedido->id; ?>" class="editar btn btn-success btn-xs pencil" title="Editar" target="_self">
                                                                    <i class="fa fa-pencil"></i></a>
                                                            <?php  } ?>
                                                        <?php } else {  ?>
                                                            <a href="#" class=" btn btn-default btn-xs " title="Cancelado, no se puede editar" target="_self">
                                                                <i class="fa fa-minus"></i></a>
                                                        <?php  } ?>
                                                    <?php  } ?>
                                                </td>
                                                <!-- <td class="remove">
                                                    <?= $this->Form->postLink(
                                                        __('<i class="fa fa-remove"></i>'),
                                                        ['action' => 'delete', $pedido->id],
                                                        [
                                                            'confirm' => __('¿Esta seguro de eliminar el pedido {0}?', $pedido->id),
                                                            'class' => 'btn btn-danger btn-xs pencil',
                                                            'title' => 'Eliminar',
                                                            'escape' => false
                                                        ]
                                                    ) ?>
                                                </td> -->
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } else { ?>
                            <div class="callout callout-danger">
                                <p> <i class="icon fa fa-warning" aria-hidden="true"></i> No se encontraron resultados que
                                    coincidan con el criterio de búsqueda.</p>
                            </div>

                        <?php } ?>
                    <?php } else {
                    ?>
                        <div class="callout callout-info">
                            <p> <i class="fa-lg fa fa-info" aria-hidden="true"></i> Todavía no se ha cargado ningún pedido.</p>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</section>
<script>
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
        //"drops": "up",
        "autoUpdateInput": false, // Esto asegura que no se muestre ninguna fecha por defecto en el input

    });



    $('#fecha_pedido').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
    });

    $('#fecha_pedido').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });

    $('#fecha_intervencion').daterangepicker({
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
        //"drops": "up",
        "autoUpdateInput": false, // Esto asegura que no se muestre ninguna fecha por defecto en el input

    });



    $('#fecha_intervencion').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
    });

    $('#fecha_intervencion').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
</script>
