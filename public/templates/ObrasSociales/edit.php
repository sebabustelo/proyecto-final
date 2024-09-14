<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ObraSocial $obraSocial
 */
?>
<section class="content-header">
    <h1>
        Parámetros del sistema
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa  fa-dot-circle-o"></i>Obras Sociales</a></li> <i class="fa fa-arrow-right"></i>
        <li class="active">Editar</li>
    </ol>
</section>
<section  class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header  with-border">
                    <h3 class="box-title"> <span class="fa fa-refresh fa-lg"></span> Editar Obra Social</h3>
                    <div class="box-tools pull-right">
                        <a href="/ObrasSociales/index/" class="btn btn-sm btn-primary ">
                            <span class="fa fa-list"></span> <span class=" hidden-xs">Obras Sociales</span></a>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-row">
                        <form id="ObrasSocialesAddForm" name="ObrasSocialesAddForm" role="form" action="/ObrasSociales/edit/<?php echo $obraSocial->id; ?>" method="POST">
                            <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getAttribute('csrfToken'); ?>">
                            <div class="form-group col-sm-4">
                                <label >Nombre</label>
                                <input required type="text" maxlength="255" placeholder="Ingrese el nombre" value="<?php echo $obraSocial->nombre; ?>"
                                    class="form-control" name="nombre" >
                                <?php if ($obraSocial->getError('nombre')) { ?>
                                    <?php foreach ($obraSocial->getError('nombre') as $error) { ?>
                                        <span class="badge bg-red"><i class="fa fa-warning"></i> <?php echo $error; ?></span>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <div class="form-group col-sm-2">
                                <label >CUIT</label>
                                <input required type="text" maxlength="20" placeholder="Ingrese el cuit" value="<?php echo $obraSocial->cuit; ?>"
                                    class="form-control" name="cuit" >
                                <?php if ($obraSocial->getError('cuit')) { ?>
                                    <?php foreach ($obraSocial->getError('cuit') as $error) { ?>
                                        <span class="badge bg-red"><i class="fa fa-warning"></i> <?php echo $error; ?></span>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <div class="form-group col-sm-6">
                                <label >Email</label>
                                <input type="email" maxlength="255" placeholder="Ingrese la descripción" class="form-control" name="email" value="<?php echo $obraSocial->email; ?>">
                                <?php if ($obraSocial->getError('email')) { ?>
                                    <?php foreach ($obraSocial->getError('email') as $error) { ?>
                                        <span class="badge bg-red"><i class="fa fa-warning"></i> <?php echo $error; ?></span>
                                    <?php } ?>
                                <?php } ?>

                            </div>
                            <div class="form-group col-sm-8">
                                <label >Dirección</label>
                                <input type="text" maxlength="255" placeholder="Ingrese la dirección" value="<?php echo $obraSocial->direccion; ?>"
                                    class="form-control" name="direccion" >
                                <?php if ($obraSocial->getError('direccion')) { ?>
                                    <?php foreach ($obraSocial->getError('direccion') as $error) { ?>
                                        <span class="badge bg-red"><i class="fa fa-warning"></i> <?php echo $error; ?></span>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <div class="form-group col-sm-4">
                                <label >Teléfono</label>
                                <input type="text" maxlength="20" placeholder="Ingrese el télefono" value="<?php echo $obraSocial->telefono; ?>"
                                    class="form-control" name="telefono" >
                                <?php if ($obraSocial->getError('telefono')) { ?>
                                    <?php foreach ($obraSocial->getError('telefono') as $error) { ?>
                                        <span class="badge bg-red"><i class="fa fa-warning"></i> <?php echo $error; ?></span>
                                    <?php } ?>
                                <?php } ?>

                            </div>

                            <?php
                            if ($this->request->getSession()->check('previousUrl')) {
                                $url = $this->request->getSession()->read('previousUrl');
                                if (strpos($url, "ObrasSociales") !== false or strpos($url, "obras_sociales") !== false) {
                                    $url = $this->request->getSession()->read('previousUrl');
                                } else {
                                    $url = "/ObrasSociales/index/";
                                }
                            } else {
                                $url = '/ObrasSociales/index';
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
