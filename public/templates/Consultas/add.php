<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Categorias $categoria
 */

use Cake\Core\Configure;
?>
<section class="content-header">
    <h1>
        <?php echo "Cliente: ".$_SESSION['RbacUsuario']['nombre']." ".$_SESSION['RbacUsuario']['apellido'];  ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dot-circle-o"></i>Consulta</a></li> <i class="fa fa-arrow-right"></i>
        <li class="active">Nueva</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header  with-border">
                    <h3 class="box-title"> <span class="fa fa-plus fa-lg"></span> Nueva Consulta</h3>

                </div>
                <div class="box-body">
                    <div class="form-row">
                        <form id="CategoriasAddForm" name="CategoriasAddForm" role="form" action="/Consultas/add/" method="POST">
                            <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getAttribute('csrfToken'); ?>">

                            <div class="form-group col-sm-12">
                                <label>Mótivo</label>
                                <textarea style='text-transform: uppercase;' required maxlength="2000" rows="5" placeholder="Ingrese el mótivo de la consulta" class="form-control" name="descripcion" oninvalid="this.setCustomValidity('Debe completar la descripción')" oninput="this.setCustomValidity('')"></textarea>
                                <?php if ($consulta->getError('motivo')) { ?>
                                    <?php foreach ($consulta->getError('motivo') as $error) { ?>
                                        <span class="badge bg-red"><i class="fa fa-warning"></i> <?php echo $error; ?></span>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <?php
                            if ($this->request->getSession()->check('previousUrl')) {
                                $url = $this->request->getSession()->read('previousUrl');
                                if (strpos($url, "Consultas") !== false) {
                                    $url = $this->request->getSession()->read('previousUrl');
                                } else {
                                    $url = "/Consultas/index/";
                                }
                            } else {
                                $url = '/Consultas/index';
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
