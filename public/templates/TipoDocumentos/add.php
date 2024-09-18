<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TipoDocumento $tipoDocumento
 */
use Cake\Core\Configure;
?>
<section class="content-header">
    <h1>
        <?php echo Configure::read('Menu.ParamatrosSistema') ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"> Tipos de Documentos</a></li> <i class="fa fa-arrow-right"></i>
        <li class="active">Agregar</li>
    </ol>
</section>
<section id="TipoDocumentosAdd" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header  with-border">
                    <h3 class="box-title"> <span class="fa fa-plus fa-lg"></span> Tipo de Documento</h3>
                    <div class="box-tools pull-right">
                        <a title="Listado de Tipos de Documentos" href="/TipoDocumentos/index/" id="agregarUsuario" class="btn btn-sm btn-primary ">
                            <span class="fa fa-list "></span><span class="buttonText  hidden-xs">
                                Tipos de Documentos
                            </span></a>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-row">
                        <form id="TipoDocumentosAddForm" name="TipoDocumentosAddForm" role="form" action="/TipoDocumentos/add/" method="POST">
                            <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getAttribute('csrfToken'); ?>">

                            <div class="form-group col-sm-12">
                                <label for="direccion">Descripción</label>
                                <input style='text-transform: uppercase;' required type="text" maxlength="200" placeholder="Ingrese la descripción" class="form-control" name="descripcion" oninvalid="this.setCustomValidity('Debe completar la descripción')" oninput="this.setCustomValidity('')">
                            </div>

                            <?php
                            if ($this->request->getSession()->check('previousUrl')) {
                                $url = $this->request->getSession()->read('previousUrl');
                                if (strpos($url, "TipoDocumentos") !== false or strpos($url, "tipos_documentos") !== false) {
                                    $url = $this->request->getSession()->read('previousUrl');
                                } else {
                                    $url = "/TipoDocumentos/index/";
                                }
                            } else {
                                $url = '/TipoDocumentos/index';
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
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
</section>
