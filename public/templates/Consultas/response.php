<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Categorias $categoria
 */

use Cake\Core\Configure;
?>
<section class="content-header">
    <h1>
        Gestión de Consultas

    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dot-circle-o"></i>Consulta</a></li> <i class="fa fa-arrow-right"></i>
        <li class="active">Responder</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary  direct-chat direct-chat-primary">
                <div class="box-header  with-border">
                    <h3 class="box-title"> <span class="fa fa-fw  fa-envelope"></span> Consulta de Cliente <?php echo $consulta->cliente->usuario; ?></h3>
                    <div class="box-tools pull-right">
                        <a title="Listado de Consultas" href="/Consultas/index/" class="btn btn-sm btn-primary ">
                            <span class="fa fa-list"></span> <span class=" hidden-xs">Consultas</span>
                        </a>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>

                <br>

                <div class="box-body">
                    <form id="ConstulasAddForm" name="ConstulasAddForm" role="form" action="/Consultas/response/<?php echo $consulta->id; ?>" method="POST">
                        <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getAttribute('csrfToken'); ?>">
                        <input type="hidden" name="cliente_id" value="<?php echo  $consulta->cliente->id; ?>">

                        <div class="direct-chat-messages">

                            <div class="direct-chat-msg">
                                <div class="direct-chat-info clearfix">
                                    <span class="direct-chat-name pull-left"><?php echo $consulta->cliente->usuario ?></span>
                                    <span class="direct-chat-timestamp pull-right"> <?php echo "Fecha " . $this->Time->format($consulta->created, 'dd/MM/Y HH:mm:ss') ?></span>
                                </div>
                                <img src="/img/user-profile.png" alt="Message User Image" class="direct-chat-img"><!-- /.direct-chat-img -->
                                <div class="direct-chat-text">
                                    <?php echo $consulta->motivo ?>
                                </div>
                            </div>
                            <br>
                            <div class="direct-chat-msg right">
                                <div class="direct-chat-info clearfix">
                                    <span class="direct-chat-name pull-right"><?php echo $_SESSION['RbacUsuario']['usuario']; ?></span>
                                    <span class="direct-chat-timestamp pull-left"></span>
                                </div>
                                <img src="/admin_l_t_e/img/user3-128x128.jpg" alt="Message User Image" class="direct-chat-img"><!-- /.direct-chat-img -->
                                <div class="direct-chat-text">

                                    <textarea required class="form-control btn-primary" name="respuesta" placeholder="Ingrese la respuesta"></textarea>
                                </div>
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

                        </div>
                        <div class="form-group col-sm-12 text-center">
                            <a href="<?php echo $url; ?>" class="btn btn-danger">
                                <span class="fa fa-remove"></span> Cancelar</a>
                            <button type="submit" class="btn btn-success">
                                <span class="fa fa-mail-forward "></span>
                                Responder</button>
                        </div>
                    </form>
                    <br><br>
                    <div class="content">
                        <div class="form-row form-group  callout callout-info row" role="alert">
                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                            Tenga en cuenta que al responder a la consulta, se enviara automáticamente la misma vía email al Cliente y se guardara en el sistema.
                        </div>
                    </div>
                </div>

            </div>
        </div>
</section>
<!-- CSS -->
<style>
    textarea::placeholder {


        font-style: italic;
    }
</style>