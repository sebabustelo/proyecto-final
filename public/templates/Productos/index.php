<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Producto> $productos
 */
?>
<style>
    .table tbody tr td {
        vertical-align: middle;
    }
</style>
<section class="content-header">
    <h1>
        <i class="fa fa-fw fa-medkit"></i> Gestión de Productos
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa  fa-dot-circle-o"></i>Productos</a></li> <i class="fa fa-arrow-right"></i>
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
                    <form method="get" accept-charset="utf-8" class="form abox" id="formOrderFilter" action="/Productos/index">
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <input type="text" name="nombre" placeholder="Nombre" class="form-control" id="nombre" aria-label="nombre"
                                    value="<?php echo (isset($filters['nombre'])) ? $filters['nombre'] : '' ?>">
                            </div>
                            <div class="form-group col-md-8">
                                <input type="text" name="descripcion_breve" placeholder="Descripción breve" class="form-control" id="descripcion_breve" aria-label="descripcion_breve" value="<?php echo (isset($filters['descripcion_breve'])) ? $filters['descripcion_breve'] : '' ?>">
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
                    <h3 class="box-title"> <span class="fa fa-list"></span> Productos</h3>
                    <div class="box-tools pull-right">
                        <?php if (!empty($accionesPermitidas['Productos']['add'])) { ?>
                            <a href="/Productos/add/" id="agregarProducto" class="btn btn-primary btn-sm ">
                                <span class="glyphicon glyphicon-plus-sign"></span> <span class="buttonText">Nuevo Producto
                                </span></a>
                        <?php } ?>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>

                <div class="box-body">
                    <?php if (isset($productos)) { ?>
                        <?php if (count($productos) > 0) { ?>
                            <div class="table-responsive">
                                <table class="table table-hover table-striped table-ajax">
                                    <thead>
                                        <tr>
                                            <th class="col-sm-2 ">Imagen Principal</th>
                                            <th class="col-sm-2 hidden-xs">
                                                <?php echo $this->Paginator->sort('nombre', 'Nombre'); ?>
                                            </th>
                                            <th class="col-sm-4 hidden-xs">
                                                <?php echo $this->Paginator->sort('descripcion', 'Descripción'); ?>
                                            </th>
                                            <th class="col-sm-2 hidden-xs">
                                                <?php echo $this->Paginator->sort('created', 'Creación'); ?>
                                            </th>
                                            <th class="col-sm-2 hidden-xs">
                                                <?php echo $this->Paginator->sort('modified', 'Modificación'); ?>
                                            </th>
                                            <th></th>
                                            <th></th>
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
                                                        Página: <?php echo $this->Paginator->counter('{{page}} de {{pages}}, mostrando {{current}} productos de {{count}}'); ?>
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>

                                    <tbody>
                                        <?php foreach ($productos as $producto) { ?>
                                            <tr>
                                                <!-- Columna Imagen -->
                                                <td>
                                                    <img src="/img/productos/<?php echo $producto->productos_archivos[0]['file_name']; ?>" alt="Imagen" class="img-thumbnail" style="width: 90%;">
                                                </td>

                                                <td>
                                                    <?php echo $producto->nombre; ?>
                                                </td>
                                                <td class=" hidden-xs">
                                                    <?php echo $producto->descripcion_breve;  ?>
                                                </td>
                                                <td class=" hidden-xs">
                                                    <?php echo $this->Time->format($producto->created, 'dd/MM/Y HH:mm:ss'); ?>
                                                </td>
                                                <td class=" hidden-xs">
                                                    <?php echo $this->Time->format($producto->modified, 'dd/MM/Y HH:mm:ss'); ?>
                                                </td>

                                                <td class="pencil">
                                                    <?php if ((isset($accionesPermitidas['Productos']['edit']) && $accionesPermitidas['Productos']['edit'])) { ?>
                                                        <a href="/Productos/edit/<?php echo $producto->id; ?>" class="editar btn btn-success btn-xs pencil" title="Editar" target="_self">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                    <?php  } ?>
                                                </td>

                                                <td class="remove">
                                                    <?php if ((isset($accionesPermitidas['Productos']['delete']) && $accionesPermitidas['Productos']['delete'])) { ?>
                                                        <?= $this->Form->postLink(
                                                            __('<i class="fa fa-remove"></i>'),
                                                            ['action' => 'delete', $producto->id],
                                                            [
                                                                'confirm' => __('¿Está seguro de eliminar el producto {0}?', $producto->nombre),
                                                                'class' => 'btn btn-danger btn-xs pencil',
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
                                <p> <i class="fa-lg fa fa-info" aria-hidden="true"></i> Todavía no se ha cargado ningún Producto.</p>
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
