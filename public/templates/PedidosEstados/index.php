<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\TipoDocumento> $tipoDocumentos
 */

use Cake\Core\Configure;
?>
<section class="content-header">
    <h1>
        <?php echo Configure::read('Menu.ParamatrosSistema') ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa  fa-dot-circle-o"></i>Estados de pedido</a></li> <i class="fa fa-arrow-right"></i>
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
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form method="get" accept-charset="utf-8" class="form abox" id="formOrderFilter"
                        action="/PedidosEstados/index">
                        <div class="form-row">
                            <div class="form-group col-md-10">
                                <input type="text" name="nombre" placeholder="nombre" style='text-transform: uppercase;' class="form-control"
                                    id="nombre" aria-label="nombre"
                                    value="<?php echo (isset($filters['nombre'])) ? $filters['nombre'] : '' ?>">
                            </div>
                            <div class=" form-group col-sm-2">
                                <label class="btn btn-default btn-block">
                                    <input type="hidden" name="activo" value="0">
                                    <input value="1" type="checkbox" id="activo" name="activo" <?php echo (!isset($filters['activo']))
                                                                                                    ? 'checked' : (($filters['activo']) ? 'checked' : '') ?>>
                                    <span>Activo</span>

                                </label>
                            </div>
                        </div>

                        <div class=" form-row">
                            <div class="form-group col-md-12 text-center ">
                                <button type="button" id="limpiar" class="btn btn-default">
                                    <span class="glyphicon glyphicon-trash"></span>
                                    Limpiar</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <button type="submit" id="enviar" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-search"></span>
                                    Buscar</button>

                                <!--div class="form-group col-md-4"!-->
                                <!--a href="#" id="limpiar" class="btn btn-default" title=""><span class="glyphicon glyphicon-trash"></span> Limpiar</a!-->
                                <script>
                                    $(function() {
                                        $('#limpiar').on('click', function() {
                                            $('#formOrderFilter').find(
                                                'input:text, input:password, select, textarea').val('');
                                            $('#formOrderFilter').find(
                                                'input:radio, input:checkbox:not(#activo)').prop(
                                                'checked', false);
                                            document.getElementById("activo").checked = true;

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
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header  with-border">
                    <h3 class="box-title"> <span class="fa fa-list"></span> Estados de pedido</h3>
                    <div class="box-tools pull-right">
                        <?php if (!empty($accionesPermitidas['PedidosEstados']['add'])) { ?>
                            <a title="Agregar Estado de pedido" href="/PedidosEstados/add/" id="agregarUsuario" class="btn btn-primary btn-sm ">
                                <span class="glyphicon glyphicon-plus-sign"></span> <span class="buttonText hidden-xs">Nuevo
                                    Estado de pedido</span></a>
                        <?php } ?>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <?php if (isset($estados)) { ?>
                        <?php if (count($estados) > 0) { ?>
                            <div class="table-responsive">
                                <table class="table table-hover table-striped table-ajax">
                                    <thead>
                                        <tr>
                                            <th>
                                                <?php echo $this->Paginator->sort('nombre', 'Nombre'); ?>
                                            </th>
                                            <th class="hidden-xs">
                                                <?php echo $this->Paginator->sort('descripcion', 'Descripción'); ?>
                                            </th>

                                            <th>
                                            </th>
                                            <th>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($estados as $estado) {  ?>
                                            <tr>
                                                <td>
                                                    <?php echo $estado->nombre; ?>
                                                </td>
                                                <td class="hidden-xs">
                                                    <?php echo $estado->descripcion; ?>
                                                </td>
                                                <td>
                                                    <?php if ((isset($accionesPermitidas['PedidosEstados']['edit']) && $accionesPermitidas['PedidosEstados']['edit'])) { ?>
                                                        <a href="/PedidosEstados/edit/<?php echo $estado->id; ?>" class="editar btn btn-success btn-xs pencil" title="Editar" target="_self"><i class="fa fa-pencil"></i></a>
                                                    <?php  } ?>
                                                </td>

                                                <td class="remove">
                                                    <?php if ((isset($accionesPermitidas['PedidosEstados']['delete']) && $accionesPermitidas['PedidosEstados']['delete'])) { ?>
                                                        <?= $this->Form->postLink(
                                                            __('<i class="fa fa-remove"></i>'),
                                                            ['action' => 'delete', $estado->id],
                                                            [
                                                                'confirm' => __('¿Esta seguro de eliminar el documento {0}?', $estado->nombre),
                                                                'class' => 'btn btn-danger btn-xs pencil',
                                                                'title' => 'Eliminar',
                                                                'escape' => false
                                                            ]
                                                        ) ?>
                                                    <?php  } ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } else { ?>
                            <div class="callout callout-info">
                                <p> <i class="fa-lg fa fa-info" aria-hidden="true"></i> Todavía no se ha cargado ningún Estado.</p>
                            </div>
                        <?php } ?>
                    <?php } else {
                    ?>
                        <div class="callout callout-danger">
                            <p> <i class="icon fa fa-warning" aria-hidden="true"></i> No se encontraron resultados que
                                coincidan con el criterio de búsqueda.</p>
                        </div>
                    <?php } ?>

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
