<?php

/**
 * @var \App\View\AppView $this 
 */
?>
<section id="AreasAdd" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header  with-border">
                    <h3 class="box-title"> <span class="fa fa-sitemap fa-lg"></span> Nueva Área</h3>
                    <div class="box-tools pull-right">
                        <a href="/areas/index/" id="agregarArea" class="btn btn-primary ">
                            <span class="fa fa-list"></span> Áreas</a>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->                
                <div class="box-body">
                    <div class="form-row">
                        <form class="" id="AreasAddForm" name="AreasAddForm" role="form" action="/areas/add" method="POST">
                            <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getAttribute('csrfToken'); ?>">
                            <div class="form-group col-sm-4">
                                <label for="codigo">Código</label>
                                <input type="text" name="codigo" required id="codigo" oninvalid="this.setCustomValidity('Complete el código')" 
                                oninput="this.setCustomValidity('')" placeholder="Código" class="form-control" maxlength="20" 
                                value="<?php echo  (!$area->getError('codigo'))?$this->request->getData('codigo'):''; ?>" >
                                <?php foreach ($area->getError('codigo') as $k => $v) { ?>
                                    <div class="form-group   label label-danger">
                                        <span class=" "> <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                            <?php echo $v; ?>
                                        </span>
                                        
                                    </div>
                                <?php  } ?>
                            </div>
                            <div class="form-group col-sm-8">
                                <label for="descripcion">Descripción</label>
                                <input type="text" name="descripcion" required id="descripcion" oninvalid="this.setCustomValidity('Complete la descripción')"
                                 oninput="this.setCustomValidity('')" placeholder="Descripción" class="form-control"  maxlength="100"
                                 value="<?php echo (!$area->getError('descripcion'))?$this->request->getData('descripcion'):''; ?>" >
                                 <?php foreach ($area->getError('descripcion') as $k => $v) { ?>
                                    <div class="form-group   label label-danger">
                                        <span class=" "> <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                            <?php echo $v; ?>
                                        </span>
                                        
                                    </div>
                                <?php  } ?>
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
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
</section>