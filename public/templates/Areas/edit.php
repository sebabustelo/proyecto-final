<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Area $area
 */
?>
<section id="AreasEdit" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header  with-border">
                    <h3 class="box-title"> <span class="fa fa-sitemap fa-lg"></span> Editar Área</h3>
                    <div class="box-tools pull-right">
                        <a href="/areas/index" class="btn btn-primary ">
                            <span class="fa fa-list"></span> Áreas</a>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form id="AreasAddForm" name="AreasAddForm" role="form" action="/areas/edit/<?php echo $area['id'] ?>" method="POST">
                        <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getAttribute('csrfToken'); ?>">
                        <div class="form-row">
                            <div class="form-group col-sm-2">
                                <label for="codigo">Código</label>
                                <input type="text" name="codigo" required id="codigo" oninvalid="this.setCustomValidity('Complete el código')" oninput="this.setCustomValidity('')" 
                                placeholder="Código" class="form-control" maxlength="20" 
                                value="<?php echo  (!$area->getError('codigo'))?$area['codigo']:''; ?>">                                
                                <?php foreach ($area->getError('codigo') as $k => $v) { ?>
                                    <div class="form-group   label label-danger">
                                        <span class=" "> <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                            <?php echo $v; ?>
                                        </span>                                        
                                    </div>
                                <?php  } ?>
                            </div>
                            <div class="form-group col-sm-7">
                                <label for="descripcion" required="required">Descripción</label>
                                <input type="text" name="descripcion" required id="descripcion" oninvalid="this.setCustomValidity('Complete la descripción')" oninput="this.setCustomValidity('')" 
                                placeholder="Descripción" class="form-control" 
                                value="<?php echo  (!$area->getError('descripcion'))?$area['descripcion']:''; ?>" maxlength="100">
                                <?php foreach ($area->getError('descripcion') as $k => $v) { ?>
                                    <div class="form-group   label label-danger">
                                        <span class=" "> <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                            <?php echo $v; ?>
                                        </span>                                        
                                    </div>
                                <?php  } ?>
                            </div>
                            <div class="form-group col-sm-1">
                                <label>Resoluciones </label><br>
                                <button class="btn btn-default" type="button">
                                    <span class="badge">&nbsp;&nbsp;&nbsp;<?php echo (isset($area->resoluciones[0]['cantidad'])) ? $area->resoluciones[0]['cantidad'] : 0; ?>&nbsp;&nbsp;&nbsp;</span>
                                </button>
                            </div>
                            <div class="form-group   col-sm-2">
                                <label for="">&nbsp;</label><br>
                                <label class="btn btn-default btn-block">
                                    <input type="hidden" name="activo" value="0">
                                    <input value="1" type="checkbox" name="activo" <?php echo (isset($area) and $area['activo']) == 'true' ? 'checked' : ''; ?>>
                                    <span>Activo</span>

                                </label>
                            </div>
                        </div>
                        <?php
                        if ($this->request->getSession()->check('previousUrl')) {
                            $url = $this->request->getSession()->read('previousUrl');
                            if (strpos($url, "areas") !== false) {
                                $url = $this->request->getSession()->read('previousUrl');
                            } else {
                                $url = "/areas/index/";
                            }
                        } else {
                            $url = '/areas/index';
                        }
                        ?>
                        <div class="form-group col-sm-12 text-center">
                            <a href="<?php echo $url; ?>" class="btn btn-danger">
                                <span class="glyphicon glyphicon-remove"></span> Cancelar</a>
                            <button type="submit" class="btn btn-primary">
                                <span class="glyphicon glyphicon-check"></span>
                                Guardar</button>

                        </div>
                    </form>
                    <?php
                    if (count($area['resoluciones']) > 0) {
                    ?>
                        <div class="form-row form-group col-sm-12 callout callout-info" role="alert"> <i class="fa fa-info-circle" aria-hidden="true"></i>
                            El Área <?php echo $area['codigo'] . ' (' . $area['descripcion'] . ') '; ?> tiene <span class="badge "> 
                                <?php echo $area->resoluciones[0]['cantidad']; ?> 
                            </span> Resoluciones asociadas, al modificar el Área, el cambio se vera reflejado en los datos asociados.
                            <br><i class="fa fa-info-circle" aria-hidden="true"></i>
                            No se activara/desactivara el Área hasta que no guarde los cambios .
                            <br><i class="fa fa-info-circle" aria-hidden="true"></i>
                            Si desactiva el Área, esta quedara asociada a las resoluciones anteriores, pero al crear una nueva Resolución está Área
                            no aparecera para asociarla .
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
</section>