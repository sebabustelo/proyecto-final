<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Categorias> $categorias
 */
?>
<section class="content-header">
    <h1>
    <i class="fa fa-heartbeat"></i> Gestión de Obras Sociales
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa  fa-dot-circle-o"></i>Obras Sociales</a></li> <i class="fa fa-arrow-right"></i>
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
                        action="/ObrasSociales/index">
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <input type="text" name="cuit" placeholder="CUIT" class="form-control"
                                    id="cuit" aria-label="cuit"
                                    value="<?php echo (isset($filters['cuit'])) ? $filters['cuit'] : '' ?>">
                            </div>
                            <div class="form-group col-md-3">
                                <input type="text" name="nombre" placeholder="Nombre" class="form-control"
                                    id="nombre" aria-label="nombre"
                                    value="<?php echo (isset($filters['nombre'])) ? $filters['nombre'] : '' ?>">
                            </div>
                            <div class="form-group col-md-5">
                                <input type="text" name="email" placeholder="Email" class="form-control"
                                    id="email" aria-label="email"
                                    value="<?php echo (isset($filters['email'])) ? $filters['email'] : '' ?>">
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
                    <h3 class="box-title"> <span class="fa fa-list"></span> Obras Sociales</h3>
                    <div class="box-tools pull-right">
                        <?php if (!empty($accionesPermitidas['ObrasSociales']['add'])) { ?>
                            <a  title="Agregar obra social" href="/ObrasSociales/add/" id="agregarUsuario" class="btn btn-primary btn-sm ">
                                <span class="glyphicon glyphicon-plus-sign"></span> <span class="buttonText hidden-xs">Nueva Obra Social</span>
                            </a>
                        <?php } ?>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <?php if (isset($obrasSociales)) { ?>
                        <?php if (count($obrasSociales) > 0) { ?>
                            <div class="table-responsive">
                                <table class="table table-hover table-striped table-ajax">
                                    <thead>
                                        <tr>
                                            <th class="hidden-xs">
                                                <?php echo $this->Paginator->sort('cuit', 'CUIT'); ?>
                                            </th>
                                            <th>
                                                <?php echo $this->Paginator->sort('nombre', 'Nombre'); ?>
                                            </th>
                                            <th >
                                                <?php echo $this->Paginator->sort('email', 'Email'); ?>
                                            </th>
                                            <th class="hidden-xs">
                                                <?php echo $this->Paginator->sort('direccion', 'Dirección'); ?>
                                            </th>
                                            <th class="hidden-xs">
                                                <?php echo $this->Paginator->sort('created', 'Creación'); ?>
                                            </th>
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
                                        <?php foreach ($obrasSociales as $obraSocial) {  ?>
                                            <tr>
                                                <td class="hidden-xs">
                                                    <?php echo $obraSocial->cuit; ?>
                                                </td>
                                                <td>
                                                    <?php echo $obraSocial->nombre; ?>
                                                </td>
                                                <td>
                                                    <?php echo $obraSocial->email; ?>
                                                </td>
                                                <td class="hidden-xs">
                                                    <?php echo $obraSocial->direccion; ?>
                                                </td>
                                                <td class="hidden-xs">
                                                    <?php echo $this->Time->format($obraSocial->created, 'dd/MM/Y HH:mm:ss'); ?>
                                                </td>
                                                <td class="hidden-xs">
                                                    <?php echo $this->Time->format($obraSocial->modified, 'dd/MM/Y HH:mm:ss'); ?>
                                                </td>
                                                <td >
                                                    <a href="/ObrasSociales/edit/<?php echo $obraSocial->id; ?>" class="editar btn btn-success btn-xs pencil" title="Editar" target="_self"><i class="fa fa-pencil"></i></a>
                                                </td>
                                                <td >
                                                    <?= $this->Form->postLink(
                                                        __('<i class="fa fa-remove"></i>'),
                                                        ['action' => 'delete', $obraSocial->id],
                                                        [
                                                            'confirm' => __('¿Esta seguro de eliminar la obra social {0}?', $obraSocial->nombre),
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
                                <p> <i class="fa-lg fa fa-info" aria-hidden="true"></i> Todavía no se ha cargado ningúna obra social.</p>
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
