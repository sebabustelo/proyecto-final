<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estado $estado
 */
use Cake\Core\Configure;
?>
<section class="content-header">
    <h1>
        <?php echo Configure::read('Menu.ParamatrosSistema') ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa  fa-dot-circle-o"></i>Estados de pedido</a></li> <i class="fa fa-arrow-right"></i>
        <li class="active">Editar</li>
    </ol>
</section>
<section id="EstadosEditForm" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header  with-border">
                    <h3 class="box-title"> <span class="fa fa-refresh fa-lg"></span> Editar Estado de Pedido</h3>
                    <div class="box-tools pull-right">
                        <a title="Listado de Estados de pedido" href="/PedidosEstados/index/" class="btn btn-sm btn-primary ">
                            <span class="fa fa-list"></span><span class="hidden-xs">Estados de Pedido</span></a>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-row">
                        <form id="EstadosEditForm" name="EstadosEditForm" role="form" action="/PedidosEstados/edit/<?php echo $estado->id; ?>" method="POST">
                            <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getAttribute('csrfToken'); ?>">
                            <div class="form-group col-sm-4">
                                <label >Nombre</label>
                                <input style='text-transform: uppercase;' required type="text" maxlength="100" placeholder="Ingrese el nombre"
                                    class="form-control" name="nombre" value="<?php echo $estado->nombre; ?>" oninvalid="this.setCustomValidity('Debe completar el nombre')" oninput="this.setCustomValidity('')">
                                <?php if ($estado->getError('nombre')) { ?>
                                    <?php foreach ($estado->getError('nombre') as $error) { ?>
                                        <span class="badge bg-red"><i class="fa fa-warning"></i> <?php echo $error; ?></span>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Descripción</label>
                                <input value="<?php echo $estado->descripcion; ?>" type="text" maxlength="300" placeholder="Ingrese la descripción"
                                 class="form-control" name="descripcion">
                                <?php if ($estado->getError('descripcion')) { ?>
                                    <?php foreach ($estado->getError('descripcion') as $error) { ?>
                                        <span class="badge bg-red"><i class="fa fa-warning"></i> <?php echo $error; ?></span>
                                    <?php } ?>
                                <?php } ?>

                            </div>
                            <div class="form-group   col-sm-2">
                                <label>&nbsp;</label><br>
                                <label class="btn btn-default btn-block">
                                    <input type="hidden" name="activo" value="0">
                                    <input value="1" type="checkbox" name="activo" <?php echo (isset($estado) and $estado['activo']) == 'true' ? 'checked' : ''; ?>>
                                    <span>Activo</span>

                                </label>
                            </div>
                            <?php
                            if ($this->request->getSession()->check('previousUrl')) {
                                $url = $this->request->getSession()->read('previousUrl');
                                if (strpos($url, "PedidosEstados") !== false) {
                                    $url = $this->request->getSession()->read('previousUrl');
                                } else {
                                    $url = "/PedidosEstados/index/";
                                }
                            } else {
                                $url = '/PedidosEstados/index';
                            }
                            ?>
                            <div class="form-group col-sm-12 text-center">
                                <a href="<?php echo $url; ?>" class="btn btn-danger">
                                    <span class="fa fa-remove"></span> Cancelar</a>
                                <button type="submit" class="btn btn-primary">
                                    <span class="fa  fa-check-square-o"></span>
                                    Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
