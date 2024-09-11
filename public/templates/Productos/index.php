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
        Administración
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"> Kit de Cirugías</a></li> <i class="fa fa-arrow-right"></i>
        <li class="active">Listado</li>
    </ol>
</section>
<section id="ProductosList" class="content">
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
                                <input type="text" name="nombre" placeholder="Nombre" class="form-control" id="nombre" aria-label="nombre" value="<?php echo (isset($filters['nombre'])) ? $filters['nombre'] : '' ?>">
                            </div>
                            <div class="form-group col-md-8">
                                <input type="text" name="descripcion" placeholder="Descripción" class="form-control" id="descripcion" aria-label="descripcion" value="<?php echo (isset($filters['descripcion'])) ? $filters['descripcion'] : '' ?>">
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
                    <h3 class="box-title"> <span class="fa fa-list"></span> Kits de Cirugías</h3>
                    <div class="box-tools pull-right">
                        <?php if (!empty($accionesPermitidas['Productos']['add'])) { ?>
                            <a href="/Productos/add/" id="agregarProducto" class="btn btn-primary btn-sm ">
                                <span class="glyphicon glyphicon-plus-sign"></span> <span class="buttonText">Nuevo Kit de Cirugía
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
                                                <?php echo $this->Paginator->sort('created', 'Alta'); ?>
                                            </th>
                                            <th class="col-sm-2 hidden-xs">
                                                <?php echo $this->Paginator->sort('modified', 'Última modificación'); ?>
                                            </th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($productos as $producto) { ?>
                                            <tr>
                                                <!-- Columna Imagen -->
                                                <td>
                                                    <img src="/img/productos/<?php echo $producto->uploads[0]['nombre_archivo'] . "." . $producto->uploads[0]['extension_archivo']; ?>" alt="Imagen" class="img-thumbnail" style="width: 90%;">
                                                </td>

                                                <td>
                                                    <?php echo $producto->nombre; ?>
                                                </td>
                                                <td class=" hidden-xs">
                                                    <?php echo mostrarResumen($producto->descripcion, 200); ?>
                                                </td>
                                                <td class=" hidden-xs">
                                                    <?php echo $this->Time->format($producto->created, 'dd/MM/Y HH:mm:ss'); ?>
                                                </td>
                                                <td class=" hidden-xs">
                                                    <?php echo $this->Time->format($producto->modified, 'dd/MM/Y HH:mm:ss'); ?>
                                                </td>

                                                <td class="pencil">
                                                    <a href="/Productos/edit/<?php echo $producto->id; ?>" class="editar btn btn-success btn-xs pencil" title="Editar" target="_self">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                </td>

                                                <td class="remove">
                                                    <?= $this->Form->postLink(
                                                        __('<i class="fa fa-remove"></i>'),
                                                        ['action' => 'delete', $producto->id],
                                                        [
                                                            'confirm' => __('¿Está seguro de eliminar el producto {0}?', $producto->descripcion),
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



<?php
function mostrarResumen($texto, $limite = 100)
{
    if (strlen($texto) <= $limite) {
        return $texto; // Si el texto es menor o igual al límite, lo devuelve tal cual.
    }

    $corte = substr($texto, 0, $limite);
    $ultimoEspacio = strrpos($corte, ' '); // Encuentra la última posición de un espacio.

    if ($ultimoEspacio !== false) {
        $corte = substr($corte, 0, $ultimoEspacio); // Corta en el último espacio para no cortar palabras.
    }

    return $corte . '...'; // Agrega puntos suspensivos.
}
?>