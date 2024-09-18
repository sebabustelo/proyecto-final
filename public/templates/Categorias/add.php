<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Categorias $categoria
 */
use Cake\Core\Configure;
?>
<section class="content-header">
    <h1>
        <?php echo Configure::read('Menu.ParamatrosSistema') ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dot-circle-o"></i>Categorías</a></li> <i class="fa fa-arrow-right"></i>
        <li class="active">Agregar</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header  with-border">
                    <h3 class="box-title"> <span class="fa fa-plus fa-lg"></span> Nueva Categoría</h3>
                    <div class="box-tools pull-right">
                        <a title="Listado de categorías" href="/Categorias/index/" class="btn btn-sm btn-primary ">
                            <span class="fa fa-list"></span> <span class=" hidden-xs">Categorías</span>
                        </a>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-row">
                        <form id="CategoriasAddForm" name="CategoriasAddForm" role="form" action="/Categorias/add/" method="POST">
                            <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getAttribute('csrfToken'); ?>">
                            <div class="form-group col-sm-2">
                                <label>Nombre</label>
                                <input style='text-transform: uppercase;' required type="text" maxlength="100" placeholder="Ingrese el nombre"
                                    class="form-control" name="nombre" oninvalid="this.setCustomValidity('Debe completar el nombre')" oninput="this.setCustomValidity('')">
                                <?php if ($categoria->getError('nombre')) { ?>
                                    <?php foreach ($categoria->getError('nombre') as $error) { ?>
                                        <span class="badge bg-red"><i class="fa fa-warning"></i> <?php echo $error; ?></span>
                                    <?php } ?>
                                <?php } ?>

                            </div>
                            <div class="form-group col-sm-10">
                                <label>Descripción</label>
                                <input type="text" maxlength="300" placeholder="Ingrese la descripción" class="form-control" name="descripcion">
                                <?php if ($categoria->getError('descripcion')) { ?>
                                    <?php foreach ($categoria->getError('descripcion') as $error) { ?>
                                        <span class="badge bg-red"><i class="fa fa-warning"></i> <?php echo $error; ?></span>
                                    <?php } ?>
                                <?php } ?>

                            </div>
                            <?php
                            if ($this->request->getSession()->check('previousUrl')) {
                                $url = $this->request->getSession()->read('previousUrl');
                                if (strpos($url, "Categorias") !== false) {
                                    $url = $this->request->getSession()->read('previousUrl');
                                } else {
                                    $url = "/Categorias/index/";
                                }
                            } else {
                                $url = '/Categorias/index';
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
