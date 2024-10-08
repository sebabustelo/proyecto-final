<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\RbacUsuarios> $rbacUsuarios
 */

use Cake\Core\Configure;
?>
<section class="content-header">
    <h1>
        <?php echo Configure::read('Menu.GestionPermisos') ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-users"></i> Usuarios</a></li> <i class="fa fa-arrow-right"></i>
        <li class="active">Listado</li>
    </ol>
</section>
<section id="RbacUsuariosList" class="content">
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
                        action="/rbac/rbac_usuarios/index">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <input type="text" name="apellido" placeholder="Apellido" class="form-control"
                                    id="apellido" aria-label="Apellido"
                                    value="<?php echo (isset($filters['apellido'])) ? $filters['apellido'] : '' ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <input type="text" name="razon_social" placeholder="Razon social" class="form-control" id="nombre"
                                    aria-label="Nombre"
                                    value="<?php echo (isset($filters['razon_social'])) ? $filters['razon_social'] : '' ?>">
                            </div>
                            <div class="form-group col-md-2">
                                <input type="text" name="usuario" placeholder="Usuario" class="form-control"
                                    id="usuario" aria-label="Usuario"
                                    value="<?php echo (isset($filters['usuario'])) ? $filters['usuario'] : '' ?>">
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
                    <h3 class="box-title"> <span class="fa fa-users fa-lg"></span> Usuarios</h3>
                    <div class="box-tools pull-right">
                        <?php if (!empty($accionesPermitidas['RbacUsuarios']['add'])) { ?>
                            <a href="/rbac/rbacUsuarios/add/" id="agregarUsuario" class="btn btn-primary btn-sm ">
                                <span class="glyphicon glyphicon-plus-sign"></span> <span class="buttonText hidden-xs">Nuevo
                                    Usuario</span></a>
                        <?php } ?>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <?php //debug(($rbacUsuarios));die;
                    ?>

                    <?php if (isset($rbacUsuarios)) { ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-ajax">
                                <thead>
                                    <tr>
                                        <th>
                                            <?php echo $this->Paginator->sort('usuario'); ?>
                                        </th>
                                        <th class="hidden-xs">
                                            <?php echo "Apellido,Nombre / Razon Social"; ?>
                                        </th>
                                        <th class="hidden-xs">
                                            <?php echo "DocumentoT" ?>
                                        </th>

                                        <th class="hidden-xs">
                                            <?php echo 'Perfil'; ?>
                                        </th>
                                        <th>
                                        </th>
                                        <th>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($rbacUsuarios as $k => $usuario) {  ?>
                                        <tr>
                                            <td>
                                                <?php echo $usuario->usuario; ?>
                                            </td>
                                            <td class="hidden-xs">
                                                <?php if (!empty($usuario->apellido)) { ?>
                                                    <?php echo $usuario->apellido . "," . $usuario->nombre; ?>
                                                <?php } else { ?>
                                                    <?php echo $usuario->razon_social; ?>
                                                <?php } ?>
                                            </td>
                                            <td class="hidden-xs">
                                                <?php echo $usuario->tipo_documento->descripcion . ":" . $usuario->documento; ?>
                                            </td>

                                            <td class="hidden-xs">
                                                <?php echo $usuario->rbac_perfil->descripcion; ?>
                                            </td>
                                            <td class="pencil">
                                                <a href="/rbac/RbacUsuarios/edit/<?php echo $usuario->id; ?>" class="editar btn btn-success btn-xs pencil" title="Editar" target="_self"><i class="fa fa-pencil"></i></a>
                                            </td>
                                            <!-- <td class="remove">
                                                <a href="/rbac/RbacUsuarios/delete/<?php echo $usuario->id; ?>" class="editar btn btn-danger btn-xs pencil" title="Eliminar" target="_self"><i class="fa fa-remove"></i></a>
                                            </td> -->
                                            <td class="remove">
                                                <?= $this->Form->postLink(
                                                    __('<i class="fa fa-remove"></i>'),
                                                    ['action' => 'delete', $usuario->id],
                                                    [
                                                        'confirm' => __('¿Esta seguro de eliminar el usuario {0}?', $usuario->usuario),
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
