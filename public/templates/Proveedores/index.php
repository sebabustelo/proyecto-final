<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Proveedor> $proveedor
 */
?>

<section class="content-header">
    <h1>
        Parámetros del sistema
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa  fa-dot-circle-o"></i>Proveedores</a></li> <i class="fa fa-arrow-right"></i>
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
                <div class="box-body">
                    <form method="get" accept-charset="utf-8" class="form abox" id="formOrderFilter"
                        action="/Proveedores/index">
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <input type="text" name="nombre" placeholder="Nombre" class="form-control"
                                    id="nombre" aria-label="nombre"
                                    value="<?php echo (isset($filters['nombre'])) ? $filters['nombre'] : '' ?>">
                            </div>
                            <div class="form-group col-md-2">
                                <input type="email" name="email" placeholder="Correo electrónico" class="form-control"
                                    id="nombre" aria-label="email"
                                    value="<?php echo (isset($filters['email'])) ? $filters['email'] : '' ?>">
                            </div>
                            <div class="form-group col-md-2">
                                <input type="number" name="cuit" placeholder="CUIT" class="form-control"
                                    id="cuit" aria-label="cuit"
                                    value="<?php echo (isset($filters['cuit'])) ? $filters['cuit'] : '' ?>">
                            </div>
                            <div class="form-group col-md-4">
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
                    <h3 class="box-title"> <span class="fa fa-list"></span> Proveedores</h3>
                    <div class="box-tools pull-right">
                        <?php if (!empty($accionesPermitidas['Proveedores']['add'])) { ?>
                            <a title="Agregar proveedor" href="/Proveedores/add/" class="btn btn-primary btn-sm ">
                                <span class="glyphicon glyphicon-plus-sign"></span> <span class="buttonText hidden-xs">Nuevo Proveedor</span>
                            </a>
                        <?php } ?>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <?php if (isset($proveedores)) { ?>
                        <?php if (count($proveedores) > 0) { ?>
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>
                                                <?php echo $this->Paginator->sort('nombre', 'Nombre'); ?>
                                            </th>
                                            <th>
                                                <?php echo $this->Paginator->sort('email', 'Correo'); ?>
                                            </th>
                                            <th class="hidden-xs">
                                                <?php echo $this->Paginator->sort('cuit', 'CUIT'); ?>
                                            </th>
                                            <th class="hidden-xs">
                                                <?php echo $this->Paginator->sort('telefono', 'Telefóno'); ?>
                                            </th>
                                            <th class="hidden-xs">
                                                <?php echo $this->Paginator->sort('created', 'Creación'); ?>
                                            </th class="hidden-xs">
                                            <th class="hidden-xs">
                                                <?php echo $this->Paginator->sort('modified', 'Modificación'); ?>
                                            </th>
                                            <th>
                                            </th>
                                            <th>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($proveedores as $proveedor) {  ?>
                                            <tr>
                                                <td>
                                                    <?php echo $proveedor->nombre; ?>
                                                </td>
                                                <td>
                                                    <?php echo $proveedor->email; ?>
                                                </td>
                                                <td class="hidden-xs">
                                                    <?php echo $proveedor->cuit; ?>
                                                </td>
                                                <td class="hidden-xs">
                                                    <?php echo $proveedor->telefono; ?>
                                                </td>
                                                <td class="hidden-xs">
                                                    <?php echo $this->Time->format($proveedor->created, 'dd/MM/Y HH:mm:ss'); ?>
                                                </td>
                                                <td class="hidden-xs">
                                                    <?php echo $this->Time->format($proveedor->modified, 'dd/MM/Y HH:mm:ss'); ?>
                                                </td>
                                                <td class="pencil">
                                                    <a href="/Proveedores/edit/<?php echo $proveedor->id; ?>" class="editar btn btn-success btn-xs pencil" title="Editar" target="_self"><i class="fa fa-pencil"></i></a>
                                                </td>
                                                <td class="remove">
                                                    <?= $this->Form->postLink(
                                                        __('<i class="fa fa-remove"></i>'),
                                                        ['action' => 'delete', $proveedor->id],
                                                        [
                                                            'confirm' => __('¿Esta seguro de eliminar el proveedor {0}?', $proveedor->nombre),
                                                            'class' => 'btn btn-danger btn-xs pencil',
                                                            'title' => 'Eliminar',
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
                                <p> <i class="fa-lg fa fa-info" aria-hidden="true"></i> Todavía no se ha cargado ningún proveedor.</p>
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
