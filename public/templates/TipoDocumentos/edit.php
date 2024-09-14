<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TipoDocumento $tipoDocumento
 */
?>
<section class="content-header">
    <h1>
        Parámetros del sistema
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa  fa-dot-circle-o"></i> Tipos de Documentos</a></li> <i class="fa fa-arrow-right"></i>
        <li class="active">Editar</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header  with-border">
                    <h3 class="box-title"> <span class="fa fa-credit-card fa-lg"></span> Nuevo Tipo de Documento</h3>
                    <div class="box-tools pull-right">
                        <a href="/TipoDocumentos/index/" id="agregarUsuario" class="btn btn-sm btn-primary ">
                            <span class="fa fa-list"></span> <span class="hidden-xs"> Tipo de Documento</span>
                        </a>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-row">
                        <form id="TipoDocumentosAddForm" name="TipoDocumentosAddForm" role="form" action="/TipoDocumentos/edit/<?php echo $tipoDocumento->id; ?>" method="POST">
                            <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getAttribute('csrfToken'); ?>">

                            <div class="form-group col-sm-10 col-xs-8">
                                <label >Descripción</label>
                                <input style = 'text-transform: uppercase;' required type="text" maxlength="200" placeholder="Ingrese la descripción"
                                class="form-control" value="<?php echo $tipoDocumento->descripcion; ?>" name="descripcion" oninvalid="this.setCustomValidity('Debe completar la descripción')" oninput="this.setCustomValidity('')">
                            </div>
                            <div class="form-group   col-sm-2 col-xs-4">
                                <label>&nbsp;</label><br>
                                <label class="btn btn-default btn-block">
                                    <input type="hidden" name="activo" value="0">
                                    <input value="1" type="checkbox" name="activo" <?php echo (isset($tipoDocumento) and $tipoDocumento['activo']) == 'true' ? 'checked' : ''; ?>>
                                    <span>Activo</span>

                                </label>
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

