<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Provincias> $provincias
 */
?>
<section class="content-header">
    <h1>
        <i class="fa  fa-map"></i> Provincias
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa  fa-dot-circle-o"></i>Provincias</a></li> <i class="fa fa-arrow-right"></i>
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
                        action="/Provincias/index">
                        <div class="form-row">
                            <div class="form-group col-md-10">
                                <input type="text" name="nombre" placeholder="nombre" class="form-control"
                                    id="cuit" aria-label="cuit"
                                    value="<?php echo (isset($filters['cuit'])) ? $filters['cuit'] : '' ?>">
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
                    <h3 class="box-title"> <span class="fa fa-list"></span> Provincias</h3>
                    <div class="box-tools pull-right">
                        <?php if (!empty($accionesPermitidas['Provincias']['add'])) { ?>
                            <a title="Agregar provincia" href="/Provincias/add/" id="agregarUsuario" class="btn btn-primary btn-sm ">
                                <span class="glyphicon glyphicon-plus-sign"></span> <span class="buttonText hidden-xs">Nueva Provincia</span>
                            </a>
                        <?php } ?>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <?php if (isset($provincias)) { ?>
                        <?php if (count($provincias) > 0) { ?>
                            <div class="table-responsive">
                                <table class="table table-hover table-striped table-ajax">
                                    <thead>
                                        <tr>
                                            <th class="col-md-10">
                                                <?php echo $this->Paginator->sort('nombre', 'Nombre'); ?>
                                            </th>
                                            <th class="col-md-1">
                                            </th>
                                            <th class="col-md-1">
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
                                                            <?php echo $this->Paginator->numbers(); ?>
                                                        </li>
                                                        <li class="page-item">
                                                            <?php echo $this->Paginator->next('>'); ?>
                                                            <?php echo $this->Paginator->last('>>'); ?>
                                                        </li>
                                                    </ul>
                                                    <p class="text-center">
                                                        Página: <?php echo $this->Paginator->counter('{{page}} de {{pages}}, mostrando {{current}} provincias de {{count}}'); ?>
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>

                                    <tbody>
                                        <?php foreach ($provincias as $provincia) {  ?>
                                            <tr>
                                                <td class="col-md-10">
                                                    <?php echo $provincia->nombre; ?>
                                                </td>
                                                <td class="col-md-1">
                                                    <a href="/Provincias/edit/<?php echo $provincia->id; ?>" class="editar btn btn-success btn-xs pencil" title="Editar" target="_self"><i class="fa fa-pencil"></i></a>
                                                </td>
                                                <td class="col-md-1">
                                                    <?= $this->Form->postLink(
                                                        __('<i class="fa fa-remove"></i>'),
                                                        ['action' => 'delete', $provincia->id],
                                                        [
                                                            'confirm' => __('¿Esta seguro de eliminar la provincia {0}?', $provincia->nombre),
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
                                <p> <i class="fa-lg fa fa-info" aria-hidden="true"></i> Todavía no se ha cargado ningúna provincia.</p>
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
