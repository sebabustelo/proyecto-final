<?php
$controller =   $this->request->getParam('controller');
$action =   $this->request->getParam('action');
?>

<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
           

            <li class="treeview">

                <a href="#" class=" sidebar-toggle" data-toggle="offcanvas" role="button">
                    <i class="fa fa-bars"></i><span class="sr-only">Toggle navigation</span>
                </a>

            </li>
            <!-- <li class="treeview">
                <a href="/admin/index">
                    <i class="fa fa-home"></i> <span>Inicio</span>
                </a>
            </li> -->
            <?php echo $this->element('menu-ejemplos'); 
            ?>
            <?php if (isset($accionesPermitidas['resoluciones']['index']) && $accionesPermitidas['resoluciones']['index']) {  ?>
                <li class="treeview <?php echo ($controller == 'Resoluciones') ? ' active' : ''; ?>">
                    <a href="<?php echo $this->Url->build('/'); ?>Resoluciones/index" class="menu">
                        <i class="fa fa-book"> </i><span>Registros</span>
                    </a>
                </li>
            <?php }; ?>

            <?php //debug($accionesPermitidas) 
            ?>
            <?php if ((isset($accionesPermitidas['areas']['index']) && $accionesPermitidas['areas']['index'])
            ) {

                $menu_parametricas = array("Areas");

                if (in_array($controller, $menu_parametricas)) {
                    $active = "active";
                    $menu_open = "menu-open";
                } else {
                    $active = "";
                    $menu_open = "";
                }

            ?>
                <li class="treeview <?php echo $active . " " . $menu_open ?>">
                    <a href="#">
                        <i class="fa fa-th"></i> <span>Paramétricas</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-down pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">

                        <?php

                        $actions = array("index", "add", "edit", "view", "delete", "");
                        if (isset($accionesPermitidas['areas']['index']) && $accionesPermitidas['areas']['index']) { ?>
                            <li class="treeview <?php echo ($controller == 'Areas' && (in_array($action, $actions)) ? ' active' : ''); ?>">
                                <a href="<?php echo $this->Url->build('/'); ?>Areas/index" class="menu">
                                    <i class="fa fa-sitemap fa-lg"> </i> Áreas
                                </a>
                            </li>
                        <?php }; ?>

                      

                    </ul>
                </li>
            <?php } ?>

            <?php if (isset($accionesPermitidas['usuarios']['index']) && $accionesPermitidas['usuarios']['index']) {  ?>
                <li class="treeview <?php echo ($controller == 'Usuarios') ? ' active' : ''; ?>">
                    <a href="<?php echo $this->Url->build('/'); ?>Usuarios/index" class="menu">
                        <i class="fa fa-users"> </i><span>Usuarios</span>
                    </a>
                </li>
            <?php }; ?>

            <?php if ((isset($accionesPermitidas['rbac_acciones']['index']) && $accionesPermitidas['rbac_acciones']['index']) ||
                (isset($accionesPermitidas['configuraciones']['index']) && $accionesPermitidas['configuraciones']['index']) ||
                (isset($accionesPermitidas['rbac_perfiles']['index']) && $accionesPermitidas['rbac_perfiles']['index']) ||
                (isset($accionesPermitidas['rbac_usuarios']['index']) && $accionesPermitidas['rbac_usuarios']['index']) ||
                (isset($accionesPermitidas['rbac_usuarios']['editar']) && $accionesPermitidas['rbac_usuarios']['editar']) ||
                (isset($accionesPermitidas['rbac_usuarios']['agregar']) && $accionesPermitidas['rbac_usuarios']['agregar']) ||
                (isset($accionesPermitidas['rbac_permisos']['index']) && $accionesPermitidas['rbac_permisos']['index']) ||
                (isset($accionesPermitidas['db']['index']) && $accionesPermitidas['db']['index'])
            ) {
                //Preguntar si esta ingresando a algunos de los menus de "Sistema" array $menu_sistema[], 
                //para esto pregunto por el contralador y la accion   
                // debug($controller); 
                $menu_sistema = array("Configuraciones", "RbacAcciones", "RbacPerfiles", "RbacPermisos", "RbacUsuarios", "Db");
                if (in_array($controller, $menu_sistema)) {
                    $active = "active";
                    $menu_open = "menu-open";
                } else {
                    $active = "";
                    $menu_open = "";
                }
            ?>
                <li class="treeview <?php echo $active . " " . $menu_open ?>">
                    <a href="#">
                        <i class="fa fa-gear"></i> <span>Sistema</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-down pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">

                        <?php //if (isset($accionesPermitidas['rbac_acciones']['index']) && $accionesPermitidas['rbac_acciones']['index']) { 
                        ?>
                        <li class="treeview <?php echo ($controller == 'RbacAcciones' && ($action == 'index' || $action == '') ? ' active' : ''); ?>">
                            <a href="<?php echo $this->Url->build('/'); ?>rbac/rbac_acciones/index" class="menu">
                                <i class="fa fa-list"> </i>Acciones
                            </a>
                        </li>
                        <?php //}; 
                        ?>
                        <?php if (isset($accionesPermitidas['configuraciones']['index']) && $accionesPermitidas['configuraciones']['index']) { ?>
                            <li class="treeview <?php echo ($controller == 'Configuraciones' && ($action == 'index' || $action == 'agregar' || $action == 'editar') ? ' active' : ''); ?>">
                                <a href="<?php echo $this->Url->build('/'); ?>rbac/configuraciones/index" class="menu">
                                    <i class="fa fa-wrench"> </i>Configuraciones
                                </a>
                            </li>
                        <?php }; ?>
                        <?php if (isset($accionesPermitidas['rbac_perfiles']['index']) && $accionesPermitidas['rbac_perfiles']['index']) { ?>
                            <li class="treeview <?php echo ($controller == 'RbacPerfiles' && ($action == 'index' || $action == 'agregar' || $action == 'editar') ? ' active' : ''); ?>">
                                <a href="<?php echo $this->Url->build('/'); ?>rbac/rbac_perfiles/index" class="menu">
                                    <i class="fa fa-sitemap"> </i>Perfiles
                                </a>
                            </li>
                        <?php }; ?>
                        <?php if (isset($accionesPermitidas['rbac_usuarios']['index']) && $accionesPermitidas['rbac_usuarios']['index']) { ?>
                            <li class="treeview <?php echo ($controller == 'RbacUsuarios' && ($action == 'index' || $action == 'agregar' || $action == 'editar') ? ' active' : ''); ?>">
                                <a href="<?php echo $this->Url->build('/'); ?>rbac/rbac_usuarios/index" class="menu">
                                    <i class="fa fa-users"> </i>Usuarios
                                </a>
                            </li>
                        <?php }; ?>
                        <?php if (isset($accionesPermitidas['rbac_permisos']['index']) && $accionesPermitidas['rbac_permisos']['index']) { ?>
                            <li class="treeview <?php echo ($controller == 'RbacPermisos' && ($action == 'index' || $action == '') ? ' active' : ''); ?>">
                                <a href="<?php echo $this->Url->build('/'); ?>rbac/rbac_permisos/index" class="menu">
                                    <i class="fa fa-key"> </i>Permiso VH
                                </a>
                            </li>
                        <?php }; ?>
                        <?php if (isset($accionesPermitidas['db']['index']) && $accionesPermitidas['db']['index']) { ?>
                            <li class="treeview <?php echo ($controller == 'Db' && ($action == 'index' || $action == '') ? ' active' : ''); ?>">
                                <a href="<?php echo $this->Url->build('/'); ?>db/index" class="menu">
                                    <i class="fa fa-database"> </i>DB Queries
                                </a>
                            </li>
                        <?php }; ?>




                    </ul>
                </li>
            <?php } ?>
        </ul>
    </section>
</aside>
<div style="clear:both;"></div>