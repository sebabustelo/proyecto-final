<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Localidades> $localidades
 */
?>
<section class="content-header">
    <h1>
        <i class="fa  fa-map"></i> Localidades
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa  fa-dot-circle-o"></i>Localidades</a></li> <i class="fa fa-arrow-right"></i>
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
                    <form method="get" accept-charset="utf-8" class="form abox" id="formOrderFilter" action="/Localidades/index">
                        <div class="form-row">
                            <div class="form-group col-md-4">

                                <select name="provincia_id" class="form-control">
                                    <option value="">Seleccione un provincia</option>
                                    <?php foreach ($provincias as $k => $provincia) { ?>
                                        <?php if (isset($filters['provincia_id']) && $filters['provincia_id'] == $k) { ?>
                                            <option selected value="<?php echo $k ?>"><?php echo $provincia; ?></option>
                                        <?php  } else { ?>
                                            <option value="<?php echo $k ?>"><?php echo $provincia; ?></option>
                                        <?php } ?>
                                    <?php } ?>

                                </select>

                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" name="nombre" placeholder="nombre" class="form-control" id="cuit" aria-label="cuit" value="<?php echo (isset($filters['nombre'])) ? $filters['nombre'] : '' ?>">
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
                    <h3 class="box-title"> <span class="fa fa-list"></span> Localidades</h3>
                    <div class="box-tools pull-right">
                        <?php if (!empty($accionesPermitidas['Provincias']['add'])) { ?>
                            <a title="Agregar localidad" href="/Localidades/add/" id="agregarUsuario" class="btn btn-primary btn-sm ">
                                <span class="glyphicon glyphicon-plus-sign"></span> <span class="buttonText hidden-xs">Nueva Localidad</span>
                            </a>
                        <?php } ?>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>

                <div class="box-body">
                    <?php if (isset($localidades)) { ?>
                        <?php if (count($localidades) > 0) { ?>
                            <div class="table-responsive">
                                <table id="table-responsive" class="table table-hover table-striped table-ajax">
                                    <thead>
                                        <tr>
                                            <th class="col-md-2">
                                                <?php echo $this->Paginator->sort('Localidades.provincia_id', 'Provincia') ?>
                                            </th>
                                            <th class="col-md-6">
                                                <?php echo $this->Paginator->sort('Localidades.nombre', 'Localidad'); ?>
                                            </th>

                                            <th class=" col-md-2">
                                            </th>
                                            <th class=" col-md-2">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr >
                                            <td colspan="12" >
                                                <div class="text-center">
                                                    <ul class="pagination justify-content-center">
                                                        <li class="page-item">
                                                            <?php echo $this->Paginator->first('<<'); ?>
                                                            <?php echo $this->Paginator->prev('<'); ?>
                                                        </li>
                                                        <li class="page-item">
                                                            <?php echo $this->Paginator->numbers(['modulus'=>4]); ?>
                                                        </li>
                                                        <li class="page-item">
                                                            <?php echo $this->Paginator->next('>'); ?>
                                                            <?php echo $this->Paginator->last('>>'); ?>
                                                        </li>
                                                    </ul>
                                                    <p class="text-center">
                                                        Página: <?php echo $this->Paginator->counter('{{page}} de {{pages}}, mostrando {{current}} localidades de {{count}}'); ?>
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>

                                    <tbody>
                                        <?php foreach ($localidades as $localidad) {  ?>
                                            <tr>
                                                <td class="col-md-2">
                                                    <?php echo $localidad->provincia->nombre; ?>
                                                </td>
                                                <td class="col-md-6">
                                                    <?php echo $localidad->nombre; ?>
                                                </td>

                                                <td class="col-md-2">
                                                    <a href="/Localidades/edit/<?php echo $localidad->id; ?>" class="editar btn btn-success btn-xs pencil" title="Editar" target="_self"><i class="fa fa-pencil"></i></a>
                                                </td>
                                                <td class="col-md-">
                                                    <?= $this->Form->postLink(
                                                        __('<i class="fa fa-remove"></i>'),
                                                        ['action' => 'delete', $localidad->id],
                                                        [
                                                            'confirm' => __('¿Esta seguro de eliminar la localidad {0}?', $localidad->nombre),
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
                                <p> <i class="fa-lg fa fa-info" aria-hidden="true"></i> Todavía no se ha cargado ningúna localidad.</p>
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
<script type="text/javascript">
    // Manejo de paginación con Ajax
    $(".pag-ajax").on("click", function(event) {
        event.preventDefault();
        window.history.pushState("object or string", "Paginacion", $(this).attr("href"));
        fetch($(this).attr("href"), {
                method: "GET",
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            })
            .then(response => response.text())
            .then(response => {
                jQuery(".content-wrapper").html(response);
            })
            .catch(function(err) {
                console.log(err);
                fetch("/rbac/rbac_usuarios/login", {
                        method: "GET",
                        headers: {
                            "X-Requested-With": "XMLHttpRequest"
                        }
                    })
                    .then(response => response.text())
                    .then(response => {
                        jQuery("#divDialog").html(response);
                        $("#myModal").modal("show");
                    })
            })
    });
</script>
