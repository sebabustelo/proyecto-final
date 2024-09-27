<?php

use Cake\Core\Configure; ?>
<nav class="navbar navbar-static-top">

    <?php if (isset($layout) && $layout == 'top') : ?>
        <div class="container">

            <div class="navbar-header">
                <a href="<?php echo $this->Url->build('/'); ?>" class="navbar-brand"><?php echo Configure::read('Theme.logo.large') ?></a>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                    <i class="fa fa-bars"></i>
                </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
                    <li><a href="#">Link</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                            <li class="divider"></li>
                            <li><a href="#">One more separated link</a></li>
                        </ul>
                    </li>
                </ul>
                <form class="navbar-form navbar-left" role="search">
                    <div class="form-group">
                        <input type="text" class="form-control" id="navbar-search-input" placeholder="Search">
                    </div>
                </form>
            </div>
            <!-- /.navbar-collapse -->
        <?php else : ?>

            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

        <?php endif; ?>



        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                <!-- <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-cart-arrow-down"></i>
                        <span class="label label-success">2</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">Tienes 2 productos</li>
                        <li>
                            <ul class="menu">
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <?php echo $this->Html->image('productos/kmod-rev.jpg', array('class' => 'img-circle', 'alt' => 'User Image')); ?>
                                        </div>
                                        <h4>
                                            Kmod-Rev
                                            <small><i class="fa fa-clock-o"></i> </small>
                                        </h4>
                                        <p>Prótesis de rodilla</p>

                                    </a>
                                </li>

                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <?php echo $this->Html->image('productos/fin_short.jpg', array('class' => 'img-circle', 'alt' => 'User Image')); ?>
                                        </div>
                                        <h4>
                                            FIN SHORT
                                            <small><i class="fa fa-clock-o"></i> </small>
                                        </h4>
                                        <p>Tallo corto recto</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <li class="footer"><a href="#">Ver todos los mensajes</a></li> >
                    </ul>
                </li> -->
                <!-- Notifications: style can be found in dropdown.less -->
                <!-- <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-warning">1</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">Tienes notificaciones</li>
                        <li>

                            <ul class="menu" style="overflow: hidden; width: 100%; ">
                                <li>
                                    <a href="#">
                                        <i class="fa fa-shopping-cart text-green"></i> Su pedido fue recibido.
                                    </a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </li> -->

                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?php //echo $this->Html->image('user2-160x160.jpg', array('class' => 'user-image', 'alt' => 'User Image'));
                        $session = $session = $this->request->getSession();
                        $usuario = $session->read('RbacUsuario');
                        ?>
                        <span class="hidden-xs"> <i class="fa fa-user fa-lg"></i> <?php echo $usuario->usuario; ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <?php //echo $this->Html->image('user2-160x160.jpg', array('class' => 'img-circle', 'alt' => 'User Image'));
                            ?>
                            <p>

                                <a href="/rbac/RbacUsuarios/detail/<?php echo $_SESSION['RbacUsuario']['id'] ?>"><?php echo $usuario->nombre . " " . $usuario->apellido; ?></a>

                            </p>
                        </li>

                        <!-- Menu Footer-->
                        <li class="user-footer">

                            <div class="pull-right">
                                <a href="/rbac/RbacUsuarios/logout" style="background-color: #3c3c3b !important;border-color:#3c3c3c !important" class="btn btn-danger btn-block"><i class="fa  fa-sign-out"></i>Cerrar Sesión</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->

            </ul>
        </div>

        <?php if (isset($layout) && $layout == 'top') : ?>
        </div>
    <?php endif; ?>
</nav>
