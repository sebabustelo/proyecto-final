<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Producto> $productos
 */
?>
<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Categorias> $categorias
 */
?>

<section class="content-header">
    <h1>
        Administración
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-circle-o"></i> Kits de Cirugías</a></li>
        <li class="active">Listado</li>
    </ol>
</section>
<section id="CategoriasList" class="content">
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
                <div class="box-body">
                    <form method="get" accept-charset="utf-8" class="form abox" id="formOrderFilter"
                        action="/Categorias/index">
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <input type="text" name="nombre" placeholder="Nombre" class="form-control"
                                    id="nombre" aria-label="nombre"
                                    value="<?php echo (isset($filters['nombre'])) ? $filters['nombre'] : '' ?>">
                            </div>
                            <div class="form-group col-md-8">
                                <input type="text" name="descripcion" placeholder="Descripción" class="form-control"
                                    id="descripcion" aria-label="descripcion"
                                    value="<?php echo (isset($filters['descripcion'])) ? $filters['descripcion'] : '' ?>">
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
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header  with-border">
                    <h3 class="box-title"> <span class="fa fa-list"></span>  Kits de Cirugías</h3>
                    <div class="box-tools pull-right">
                        <?php if (!empty($accionesPermitidas['Productos']['add'])) { ?>
                            <a href="/Productos/add/" id="agregarProducto" class="btn btn-primary btn-sm ">
                                <span class="glyphicon glyphicon-plus-sign"></span> <span class="buttonText">Nuevo Kit de Cirugía
                                    </span></a>
                        <?php } ?>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <?php if (isset($productos)) { ?>
                        <?php if (count($productos) > 0) { ?>
                            <div class="table-responsive">
                                <table class="table table-hover table-striped table-ajax">
                                    <thead>
                                        <tr>
                                            <th>
                                                <?php echo $this->Paginator->sort('nombre', 'Nombre'); ?>
                                            </th>
                                            <th>
                                                <?php echo $this->Paginator->sort('descripcion', 'Descripción'); ?>
                                            </th>
                                            <th>
                                                <?php echo $this->Paginator->sort('created', 'Alta'); ?>
                                            </th>
                                            <th>
                                                <?php echo $this->Paginator->sort('modified', 'Última modificación'); ?>
                                            </th>
                                            <th>
                                            </th>
                                            <th>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($productos as $productos) {  ?>
                                            <tr>
                                                <td>
                                                    <?php echo $productos->nombre; ?>
                                                </td>
                                                <td>
                                                    <?php echo $productos->descripcion; ?>
                                                </td>
                                                <td>
                                                <?php echo $this->Time->format($productos->created, 'dd/MM/Y HH:mm:ss'); ?>
                                                </td>
                                                <td>
                                                <?php echo $this->Time->format($productos->modified, 'dd/MM/Y HH:mm:ss'); ?>
                                                </td>
                                                <td class="pencil">
                                                    <a href="/Productos/edit/<?php echo $productos->id; ?>" class="editar btn btn-success btn-xs pencil" title="Editar" target="_self"><i class="fa fa-pencil"></i></a>
                                                </td>
                                                <td class="remove">
                                                    <?= $this->Form->postLink(
                                                        __('<i class="fa fa-remove"></i>'),
                                                        ['action' => 'delete', $productos->id],
                                                        [
                                                            'confirm' => __('¿Esta seguro de eliminar la categoría {0}?', $productos->descripcion),
                                                            'class' => 'btn btn-danger btn-xs pencil',
                                                            'escape' => false
                                                        ]
                                                    ) ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } else { ?>
                            <div class="callout callout-info">
                                <p> <i class="fa-lg fa fa-info" aria-hidden="true"></i> Todavía no se ha cargado ningún Kit de Cirugía.</p>
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
            </div>
        </div>
    </div>
</section>



<div class="productos index content">
    <?= $this->Html->link(__('New Producto'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Productos') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('nombre') ?></th>
                    <th><?= $this->Paginator->sort('categoria_id') ?></th>
                    <th><?= $this->Paginator->sort('proveedor_id') ?></th>
                    <th><?= $this->Paginator->sort('imagen') ?></th>
                    <th><?= $this->Paginator->sort('stock') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('created_by') ?></th>
                    <th><?= $this->Paginator->sort('modified_by') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                <tr>
                    <td><?= $this->Number->format($producto->id) ?></td>
                    <td><?= h($producto->nombre) ?></td>
                    <td><?= $producto->hasValue('categoria') ? $this->Html->link($producto->categoria->nombre, ['controller' => 'Categorias', 'action' => 'view', $producto->categoria->id]) : '' ?></td>
                    <td><?= $producto->hasValue('proveedore') ? $this->Html->link($producto->proveedore->nombre, ['controller' => 'Proveedores', 'action' => 'view', $producto->proveedore->id]) : '' ?></td>
                    <td><?= h($producto->imagen) ?></td>
                    <td><?= $producto->stock === null ? '' : $this->Number->format($producto->stock) ?></td>
                    <td><?= h($producto->created) ?></td>
                    <td><?= h($producto->modified) ?></td>
                    <td><?= h($producto->created_by) ?></td>
                    <td><?= h($producto->modified_by) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $producto->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $producto->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $producto->id], ['confirm' => __('Are you sure you want to delete # {0}?', $producto->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
