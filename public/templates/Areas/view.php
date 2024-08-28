<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Organismo $organismo
 */
?>
<section id="AreasAdd" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header  with-border">
                    <h3 class="box-title"> <span class="fa fa-building fa-lg"></span>&nbsp;Área</h3>
                    <div class="box-tools pull-right">
                        <a href="/areas/index/" id="agregarOrganismo" class="btn btn-primary ">
                            <span class="fa fa-list"></span>Áreas</a>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                        <label for="nombre" class="col-sm-2 control-label">Código:</label>
                        <div class="col-sm-10">
                            <span class=""><?php echo $area->codigo ?></span>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="descripcion" class="col-sm-2 control-label">Descripción:</label>
                        <div class="col-sm-10">
                            <span class=" "><?php echo isset($area->descripcion) ? $area->descripcion : "-------" ?></span>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="descripcion" class="col-sm-2 control-label">Activo:</label>
                        <div class="col-sm-10">
                            <span class=" "><?php echo isset($area->activo) ? "Si" : "No" ?></span>
                        </div>
                    </div>
                    <br>
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
                    <div class="form-group">
                        <div class=" col-sm-12">
                            <a href="<?php echo $url; ?>" class="btn btn-primary">
                                <span class="glyphicon glyphicon-arrow-left"></span> Volver</a>

                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
</section>