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
                        <form id="ConstulasAddForm" name="ConstulasAddForm" role="form" action="/Consultas/add/" method="POST">
                            <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getAttribute('csrfToken'); ?>">
                            <input type="hidden" name="usuario_consulta_id" value="<?php echo  $_SESSION['RbacUsuario']['id']; ?>">

                            <div class="form-group col-sm-12">
                                <label>Mótivo</label>
                                <textarea required maxlength="2000" rows="5" placeholder="Ingrese el mótivo de la consulta" class="form-control" name="motivo"></textarea>
                                <?php if ($consulta->getError('motivo')) { ?>
                                    <?php foreach ($consulta->getError('motivo') as $error) { ?>
                                        <span class="badge bg-red"><i class="fa fa-warning"></i> <?php echo $error; ?></span>
                                    <?php } ?>
                                <?php } ?>
                            </div>

                            <div class="form-group col-sm-12 text-center">

                                <button type="submit" class="btn btn-primary">
                                    <span class="fa  fa-check-square-o"></span>
                                    Enviar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
