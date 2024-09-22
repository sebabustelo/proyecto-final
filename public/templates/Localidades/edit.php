<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Localidade $localidade
 * @var string[]|\Cake\Collection\CollectionInterface $provincias
 */
?>

<section class="content-header">
    <h1>
        <i class="fa  fa-map"></i> Localidades
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa  fa-dot-circle-o"></i>Localidades</a></li> <i class="fa fa-arrow-right"></i>
        <li class="active">Agregar</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header  with-border">
                    <h3 class="box-title"> <span class="fa fa-refresh fa-lg"></span> Editar Localidad</h3>
                    <div class="box-tools pull-right">
                        <a href="/Localidades/index/" class="btn btn-sm btn-primary ">
                            <span class="fa fa-list"></span> <span class=" hidden-xs">Localidades</span></a>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>

                <div class="box-body">
                    <div class="form-row">
                        <form id="LocalidadesEditForm" name="LocalidadesEditForm" role="form" action="/Localidades/edit/<?php echo $localidad->id; ?>" method="POST">
                            <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getAttribute('csrfToken'); ?>">
                            <div class="form-group col-sm-4">
                                <label>Provincia</label>
                                <select required name="provincia_id" class="form-control">
                                    <?php foreach ($provincias as $k => $provincia) { ?>
                                        <?php if ($localidad['provincia_id'] == $k) { ?>
                                            <option selected value="<?php echo $k ?>"><?php echo $provincia; ?></option>
                                        <?php  } else { ?>
                                            <option value="<?php echo $k ?>"><?php echo $provincia; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                                <?php if ($localidad->getError('provincia_id')) { ?>
                                    <?php foreach ($localidad->getError('provincia_id') as $error) { ?>
                                        <span class="badge bg-red"><i class="fa fa-warning"></i> <?php echo $error; ?></span>
                                    <?php } ?>
                                <?php } ?>

                            </div>
                            <div class="form-group col-sm-6">
                                <label>Nombre</label>
                                <input required type="text" maxlength="255" placeholder="Ingrese el nombre" value="<?php echo $localidad->nombre; ?>"
                                    class="form-control" name="nombre">
                                <?php if ($localidad->getError('nombre')) { ?>
                                    <?php foreach ($localidad->getError('nombre') as $error) { ?>
                                        <span class="badge bg-red"><i class="fa fa-warning"></i> <?php echo $error; ?></span>
                                    <?php } ?>
                                <?php } ?>
                            </div>

                            <div class="form-group   col-sm-2">
                                <label>&nbsp;</label><br>
                                <label class="btn btn-default btn-block">
                                    <input type="hidden" name="activo" value="0">
                                    <input value="1" type="checkbox" name="activo" <?php echo (isset($localidad) and $localidad['activo']) == 'true' ? 'checked' : ''; ?>>
                                    <span>Activo</span>

                                </label>
                            </div>

                            <?php
                            if ($this->request->getSession()->check('previousUrl')) {
                                $url = $this->request->getSession()->read('previousUrl');
                                if (strpos($url, "Localidades") !== false or strpos($url, "localidades") !== false) {
                                    $url = $this->request->getSession()->read('previousUrl');
                                } else {
                                    $url = "/Localidades/index/";
                                }
                            } else {
                                $url = '/Localidades/index';
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
