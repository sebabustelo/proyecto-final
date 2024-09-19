<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Categorias> $categorias
 */

use Cake\Core\Configure;
?>
<section class="content-header">
    <h1>
        Gestión de Consultas
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa  fa-dot-circle-o"></i>Consultas</a></li> <i class="fa fa-arrow-right"></i>
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
                    <form method="get" accept-charset="utf-8" class="form abox" id="formOrderFilter" action="/Consultas/index">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <select class="form-control" name="consulta_estado_id">
                                    <option value="">Seleccione un estado</option>
                                    <?php foreach ($estados as $key => $estado) { ?>

                                        <?php if (isset($filters['consulta_estado_id']) and $filters['consulta_estado_id'] == $estado->id) {  ?>
                                            <option selected value="<?php echo $estado->id; ?>"><?php echo $estado->nombre; ?></option>
                                        <?php  } else { ?>
                                            <option value="<?php echo $estado->id; ?>"><?php echo $estado->nombre; ?></option>
                                        <?php  } ?>
                                    <?php } ?>

                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <input type="text" name="cliente_id" placeholder="Usuario" class="form-control" id="cliente_id" aria-label="cliente_id" value="<?php echo (isset($filters['cliente_id'])) ? $filters['cliente_id'] : '' ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" name="motivo" placeholder="puede ingresar una parte del mótivo y el sistema buscará coincidencias" class="form-control" id="motivo" aria-label="motivo"
                                value="<?php echo (isset($filters['motivo'])) ? $filters['motivo'] : '' ?>">
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
                                                'input:radio, input:checkbox').prop(
                                                'checked', false);


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
                    <h3 class="box-title"> <span class="fa fa-list"></span> Consultas de Clientes desde el Portal</h3>

                </div>
                <?php //debug($consultas);
                ?>
                <div class="box-body">

                    <?php if (isset($consultas)) { ?>
                        <?php if (count($consultas) > 0) { ?>
                            <div class="table-responsive">
                                <table class="table table-hover table-striped table-ajax">
                                    <thead>
                                        <tr>
                                            <th class="col-md-1">
                                                Estado
                                            </th>
                                            <th class="col-md-2">
                                                <?php echo $this->Paginator->sort('created', 'Creación'); ?>
                                            </th>

                                            <th class="col-md-2">
                                                <?php echo $this->Paginator->sort('modified', 'Modificación'); ?>
                                            </th>
                                            <th class="col-md-3">
                                                <?php echo $this->Paginator->sort('cliente.usuario', 'Usuario'); ?>
                                            </th>
                                            <th class="hidden-xs col-md-4">
                                                <?php echo $this->Paginator->sort('motivo', 'Mótivo'); ?>
                                            </th>

                                            <th>
                                            </th>
                                            <th>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($consultas as $consulta) {  ?>
                                            <tr>
                                                <td>
                                                    <span class="pull-right-container">
                                                        <span class="label label-warning "><?php echo $consulta->consultas_estado->nombre ?></span>
                                                    </span>


                                                </td>
                                                <td>
                                                    <?php echo $this->Time->format($consulta->created, 'dd/MM/Y HH:mm:ss'); ?>
                                                </td>
                                                <td>
                                                    <?php echo $this->Time->format($consulta->modified, 'dd/MM/Y HH:mm:ss'); ?>
                                                </td>
                                                <td>
                                                    <?php echo $consulta->cliente->usuario; ?>
                                                </td>
                                                <td class="hidden-xs">
                                                    <?php echo $consulta->motivo; ?>
                                                </td>

                                                <td>
                                                    <?php if ($consulta->created == $consulta->modified) { ?>
                                                        <a href="/Consultas/response/<?php echo $consulta->id; ?>" class="btn btn-primary btn-xs " title="Responder" target="_self"><i class="fa fa-mail-forward "></i></a>
                                                    <?php  } else { ?>
                                                        <a href="/Consultas/view/<?php echo $consulta->id; ?>" class="btn btn-success btn-xs " title="Ver" target="_self"><i class="fa  fa-eye "></i></a>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                <td class="remove">
                                                    <?= $this->Form->postLink(
                                                        __('<i class="fa fa-remove"></i>'),
                                                        ['action' => 'delete', $consulta->id],
                                                        [
                                                            'confirm' => __('¿Esta seguro de eliminar la consulta de {0}?', $consulta->cliente->usuario),
                                                            'class' => 'btn btn-danger btn-xs pencil',
                                                            'title' => 'Eliminar',
                                                            'escape' => false
                                                        ]
                                                    ) ?>
                                                </td>
                                                </td>

                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } else { ?>
                            <div class="callout callout-info">
                                <p> <i class="fa-lg fa fa-info" aria-hidden="true"></i> Todavía no se ha cargado ningúna Categoría.</p>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <div class="callout callout-danger">
                            <p> <i class="icon fa fa-warning" aria-hidden="true"></i> No se encontraron resultados que
                                coincidan con el criterio de búsqueda.</p>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</section>
