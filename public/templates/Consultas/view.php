<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Categorias $categoria
 */

use Cake\Core\Configure;
?>
<section class="content-header">
    <h1>
        Consulta de Cliente <?php echo $consulta->cliente->usuario; ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dot-circle-o"></i>Consulta</a></li> <i class="fa fa-arrow-right"></i>
        <li class="active">Nueva</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary  direct-chat direct-chat-primary">
                <div class="box-header  with-border">
                    <h3 class="box-title"> <span class="fa fa-plus fa-lg"></span> Mótivo</h3>
                    <div class="box-tools pull-right">
                        <a title="Listado de Consultas href=" /Consultas/index/" class="btn btn-sm btn-primary ">
                            <span class="fa fa-list"></span> <span class=" hidden-xs">Consultas</span>
                        </a>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-row">
                        <form id="ConstulasAddForm" name="ConstulasAddForm" role="form" action="/Consultas/response/<?php echo $consulta->id; ?>" method="POST">
                            <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getAttribute('csrfToken'); ?>">
                            <input type="hidden" name="cliente_id" value="<?php echo  $_SESSION['RbacUsuario']['id']; ?>">
                           
                               
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <!-- Conversations are loaded here -->
                                    <div class="direct-chat-messages">
                                        <!-- Message. Default to the left -->
                                        <div class="direct-chat-msg">
                                            <div class="direct-chat-info clearfix">
                                                <span class="direct-chat-name pull-left">Alexander Pierce</span>
                                                <span class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span>
                                            </div>
                                            <!-- /.direct-chat-info -->
                                            <img src="/admin_l_t_e/img/user1-128x128.jpg" alt="Message User Image" class="direct-chat-img"><!-- /.direct-chat-img -->
                                            <div class="direct-chat-text">
                                                Is this template really for free? That's unbelievable!
                                            </div>
                                            <!-- /.direct-chat-text -->
                                        </div>
                                        <!-- /.direct-chat-msg -->

                                        <!-- Message to the right -->
                                        <div class="direct-chat-msg right">
                                            <div class="direct-chat-info clearfix">
                                                <span class="direct-chat-name pull-right">Sarah Bullock</span>
                                                <span class="direct-chat-timestamp pull-left">23 Jan 2:05 pm</span>
                                            </div>
                                            <!-- /.direct-chat-info -->
                                            <img src="/admin_l_t_e/img/user3-128x128.jpg" alt="Message User Image" class="direct-chat-img"><!-- /.direct-chat-img -->
                                            <div class="direct-chat-text">
                                                You better believe it!
                                            </div>
                                            <!-- /.direct-chat-text -->
                                        </div>
                                        <!-- /.direct-chat-msg -->
                                    </div>
                                    <!--/.direct-chat-messages-->

                                    <!-- Contacts are loaded here -->
                                    <div class="direct-chat-contacts">
                                        <ul class="contacts-list">
                                            <li>
                                                <a href="#">
                                                    <img src="/admin_l_t_e/img/user1-128x128.jpg" class="contacts-list-img" alt="">
                                                    <div class="contacts-list-info">
                                                        <span class="contacts-list-name">
                                                            Count Dracula
                                                            <small class="contacts-list-date pull-right">2/28/2015</small>
                                                        </span>
                                                        <span class="contacts-list-msg">How have you been? I was...</span>
                                                    </div>
                                                    <!-- /.contacts-list-info -->
                                                </a>
                                            </li>
                                            <!-- End Contact Item -->
                                        </ul>
                                        <!-- /.contatcts-list -->
                                    </div>
                                    <!-- /.direct-chat-pane -->
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <form action="#" method="post">
                                        <div class="input-group">
                                            <input type="text" name="message" placeholder="Type Message ..." class="form-control">
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn btn-primary btn-flat">Send</button>
                                            </span>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.box-footer-->
                          

                            <div class="direct-chat-msg">
                                <div class="direct-chat-info clearfix">
                                    <span class="direct-chat-name pull-left"><?php echo $consulta->cliente->usuario ?></span>
                                    <span class="direct-chat-timestamp pull-right"> <?php echo "Fecha " . $this->Time->format($consulta->created, 'dd/MM/Y HH:mm:ss') ?></span>
                                </div>
                                <!-- /.direct-chat-info -->
                                <img src="/img/user-profile.png" alt="Message User Image" class="direct-chat-img"><!-- /.direct-chat-img -->
                                <div class="direct-chat-text ">
                                    <?php echo $consulta->motivo ?>
                                </div>
                                <!-- /.direct-chat-text -->
                            </div>

                            <div class="direct-chat-msg right">
                                <div class="direct-chat-info clearfix">
                                    <span class="direct-chat-name pull-right">Sarah Bullock</span>
                                    <span class="direct-chat-timestamp pull-left">23 Jan 2:05 pm</span>
                                </div>
                                <!-- /.direct-chat-info -->
                                <img src="/img/logo-ipmagna.png" alt="Message User Image" class="direct-chat-img">
                                <div class="direct-chat-text">
                                    You better believe it!
                                </div>
                                <!-- /.direct-chat-text -->
                            </div>

                            <div class="direct-chat-msg">
                                <div class="direct-chat-info clearfix">
                                    <span class="direct-chat-name pull-left">Respuesta</span>
                                    <span class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span>
                                </div>
                                <!-- /.direct-chat-info -->
                                <img src="/img/user-profile.png" alt="Message User Image" class="direct-chat-img"><!-- /.direct-chat-img -->
                                <div class="direct-chat-text ">
                                    <input class="form-control" name="respuesta" placeholder="Ingrese la respuesta" />

                                    <?php if ($consulta->getError('motivo')) { ?>
                                        <?php foreach ($consulta->getError('motivo') as $error) { ?>
                                            <span class="badge bg-red"><i class="fa fa-warning"></i> <?php echo $error; ?></span>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                                <!-- /.direct-chat-text -->
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
                                <button type="submit" class="btn btn-success">
                                    <span class="fa  fa-check-square-o"></span>
                                    Enviar</button>
                            </div>
                        </form>
                        <div class="form-row form-group col-sm-12 callout callout-info" role="alert">
                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                            Tenga en cuenta que al guardar la respuesta a la consulta, se enviara automáticamente la misma vía email al Cliente.
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>