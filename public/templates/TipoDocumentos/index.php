<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\TipoDocumento> $tipoDocumentos
 */
?>
<section class="content-header">
    <h1>
        Parámetros del sistema
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa  fa-dot-circle-o"></i> Tipos de Documentos</a></li> <i class="fa fa-arrow-right"></i>
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
                        action="/TipoDocumentos/index">
                        <div class="form-row">
                            <div class="form-group col-md-10 col-xs-8 ">
                                <input type="text" name="descripcion" placeholder="descripción" style='text-transform: uppercase;' class="form-control"
                                    id="descripcion" aria-label="descripcion"
                                    value="<?php echo (isset($filters['descripcion'])) ? $filters['descripcion'] : '' ?>">
                            </div>
                            <div class=" form-group col-sm-2 col-xs-4">
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
                    <h3 class="box-title"> <span class="fa fa-list"></span> Tipos de Documentos</h3>
                    <div class="box-tools pull-right">
                        <?php if (!empty($accionesPermitidas['TipoDocumentos']['add'])) { ?>
                            <a href="/TipoDocumentos/add/" class="btn btn-primary btn-sm ">
                                <span class="glyphicon glyphicon-plus-sign"></span> <span class="buttonText  hidden-xs">Nuevo Tipo de Documento</span>
                            </a>
                        <?php } ?>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <?php if (isset($tipoDocumentos)) { ?>
                        <?php if (count($tipoDocumentos) > 0) { ?>
                            <div class="table-responsive">
                                <table class="table table-hover table-striped table-ajax">
                                    <thead>
                                        <tr>
                                            <th>
                                                <?php echo $this->Paginator->sort('descripcion', 'Descripción'); ?>
                                            </th>
                                            <th>
                                            </th>
                                            <th>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($tipoDocumentos as $tipoDocumento) {  ?>
                                            <tr>
                                                <td>
                                                    <?php echo $tipoDocumento->descripcion; ?>
                                                </td>
                                                <td>
                                                    <a href="/TipoDocumentos/edit/<?php echo $tipoDocumento->id; ?>" class="editar btn btn-success btn-xs pencil" title="Editar" target="_self"><i class="fa fa-pencil"></i></a>
                                                </td>
                                                <td>
                                                    <?= $this->Form->postLink(
                                                        __('<i class="fa fa-remove"></i>'),
                                                        ['action' => 'delete', $tipoDocumento->id],
                                                        [
                                                            'confirm' => __('¿Esta seguro de eliminar el documento {0}?', $tipoDocumento->descripcion),
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
                                <p> <i class="fa-lg fa fa-info" aria-hidden="true"></i> Todavía no se ha cargado ningún Tipo de Documento.</p>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
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
