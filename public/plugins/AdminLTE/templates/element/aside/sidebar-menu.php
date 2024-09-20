<?php

use Cake\Core\Configure;

$controller =   $this->request->getParam('controller');
$action =   $this->request->getParam('action');

?>
<ul class="sidebar-menu" data-widget="tree">
    <?php if ($_SESSION['RbacUsuario']['perfil_id'] <> 8) { ?>
        <li class="header"><i class="fa f-lg  fa-arrow-circle-right"></i> Menú Administración </li>

        <?php if ((isset($accionesPermitidas['Db']['index']) && $accionesPermitidas['Db']['index'])) { ?>
            <li class=" <?php echo ($controller == 'Db' && ($action == 'index' ) ? ' active' : ''); ?>">
                <a href="<?php echo $this->Url->build('/Db/Db/index'); ?>">
                    <i class="fa fa-database"></i> <span>Consulta DB</span>
                </a>
            </li>
        <?php } ?>
        <?php if ((isset($accionesPermitidas['Consultas']['index']) && $accionesPermitidas['Consultas']['index'])) { ?>
            <li>
                <a href="<?php echo $this->Url->build('Consultas/index'); ?>">
                    <i class="fa fa-fw  fa-envelope"></i>
                    <span>Gestión de Consultas</span></a>
            </li>
        <?php  } ?>

        <?php
        // if (
        //     (isset($accionesPermitidas['Configuraciones']['index']) && $accionesPermitidas['Configuraciones']['index']) ||
        //     (isset($accionesPermitidas['RbacUsuarios']['index']) && $accionesPermitidas['RbacUsuarios']['index']) ||
        //     (isset($accionesPermitidas['RbacPerfiles']['index']) && $accionesPermitidas['RbacPerfiles']['index']) ||
        //     (isset($accionesPermitidas['RbacAcciones']['index']) && $accionesPermitidas['RbacAcciones']['index'])

        // ) {
        //Preguntar si esta ingresando a algunos de los menus de "Sistema" array $menu_sistema[],
        //para esto pregunto por el contralador y la accion
        $menu_permisos = array("Configuraciones", "RbacAcciones", "RbacPerfiles", "RbacPermisos", "RbacUsuarios");
        if (in_array($controller, $menu_permisos)) {
            $active = "active";
            $menu_open = "menu-open";
        } else {
            $active = "";
            $menu_open = "";
        }
        ?>
        <li class="treeview <?php echo $active . " " . $menu_open ?>">
            <a href="#">
                <i class="fa fa-files-o"></i> <span>Gestión de Pedidos</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <?php //if ((isset($accionesPermitidas['Configuraciones']['index']) && $accionesPermitidas['Configuraciones']['index'])) {
                ?>
                <li>
                    <a href="<?php echo $this->Url->build('/pages/calendar'); ?>">
                        <i class="fa fa-calendar"></i> <span>Agenda</span>
                        <span class="pull-right-container">
                            <small class="label pull-right bg-red">3</small>
                            <small class="label pull-right bg-blue">17</small>
                        </span>
                    </a>
                </li>
                <?php //}
                ?>
                <?php //if ((isset($accionesPermitidas['RbacUsuarios']['index']) && $accionesPermitidas['RbacUsuarios']['index'])) {
                ?>
                <li>
                    <a href="<?php echo $this->Url->build('/pages/en_construccion'); ?>">
                        <i class="fa fa-files-o"></i>
                        <span>Listado</span></a>
                </li>
                <?php //}
                ?>


            </ul>
        </li>
        <?php //}
        ?>
        <?php
        if (
            (isset($accionesPermitidas['Configuraciones']['index']) && $accionesPermitidas['Configuraciones']['index']) ||
            (isset($accionesPermitidas['RbacUsuarios']['index']) && $accionesPermitidas['RbacUsuarios']['index']) ||
            (isset($accionesPermitidas['RbacPerfiles']['index']) && $accionesPermitidas['RbacPerfiles']['index']) ||
            (isset($accionesPermitidas['RbacAcciones']['index']) && $accionesPermitidas['RbacAcciones']['index'])

        ) {
            //Preguntar si esta ingresando a algunos de los menus de "Sistema" array $menu_sistema[],
            //para esto pregunto por el contralador y la accion
            $menu_permisos = array("Configuraciones", "RbacAcciones", "RbacPerfiles", "RbacPermisos", "RbacUsuarios");
            if (in_array($controller, $menu_permisos)) {
                $active = "active";
                $menu_open = "menu-open";
            } else {
                $active = "";
                $menu_open = "";
            }
        ?>
            <li class="treeview <?php echo $active . " " . $menu_open ?>">
                <a href="#">
                    <i class="fa fa-gears"></i> <span>Gestión de Permisos</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php if ((isset($accionesPermitidas['Configuraciones']['index']) && $accionesPermitidas['Configuraciones']['index'])) { ?>
                        <li class=" <?php echo ($controller == 'Configuraciones' && ($action == 'index' || $action == ''  || $action == 'add' || $action == 'edit') ? ' active' : ''); ?>">
                            <a href="<?php echo $this->Url->build('/rbac/Configuraciones/index'); ?>"><i class="fa fa-wrench fa-lg"></i> Configuraciones</a>
                        </li>
                    <?php } ?>
                    <?php if ((isset($accionesPermitidas['RbacUsuarios']['index']) && $accionesPermitidas['RbacUsuarios']['index'])) { ?>
                        <li class=" <?php echo ($controller == 'RbacUsuarios' && ($action == 'index' || $action == ''  || $action == 'add' || $action == 'edit') ? ' active' : ''); ?>">
                            <a href="<?php echo $this->Url->build('/rbac/RbacUsuarios/index'); ?>"><i class="fa fa-users"></i> Usuarios</a>
                        </li>
                    <?php } ?>
                    <?php if ((isset($accionesPermitidas['RbacPerfiles']['index']) && $accionesPermitidas['RbacPerfiles']['index'])) { ?>
                        <li class=" <?php echo ($controller == 'RbacPerfiles' && ($action == 'index' || $action == ''  || $action == 'add' || $action == 'edit') ? ' active' : ''); ?>">
                            <a href="<?php echo $this->Url->build('/rbac/RbacPerfiles/index'); ?>"><i class="fa fa-suitcase"></i>Perfiles</a>
                        </li>
                    <?php } ?>
                    <?php if ((isset($accionesPermitidas['RbacAcciones']['index']) && $accionesPermitidas['RbacAcciones']['index'])) { ?>
                        <li class=" <?php echo ($controller == 'RbacAcciones' && ($action == 'index' || $action == ''  || $action == 'add' || $action == 'edit') ? ' active' : ''); ?>">
                            <a href="<?php echo $this->Url->build('/rbac/RbacAcciones/index'); ?>"><i class="fa fa-lock fa-lg"></i>Permisos</a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>

        <?php if ((isset($accionesPermitidas['Productos']['index']) && $accionesPermitidas['Productos']['index'])) { ?>
            <li class=" <?php echo ($controller == 'Productos' && ($action == 'index' || $action == '' || $action == 'add' || $action == 'edit') ? ' active' : ''); ?>">
                <a href="<?php echo $this->Url->build('/Productos/index'); ?>">
                    <i class="fa fa-fw fa-medkit"></i> <span>Gestión de Productos</span>
                </a>
            </li>
        <?php } ?>
        <?php if ((isset($accionesPermitidas['Informes']['index']) && $accionesPermitidas['Informes']['index'])) { ?>
            <li class=" <?php echo ($controller == 'Informes' && ($action == 'index' || $action == ''  || $action == 'add' || $action == 'edit') ? ' active' : ''); ?>">
                <a href="<?php echo $this->Url->build('/Informes/index'); ?>">
                    <i class="fa fa-area-chart"></i> <span>Informes</span>
                </a>
            </li>
        <?php } ?>
        <?php if ((isset($accionesPermitidas['ObrasSociales']['index']) && $accionesPermitidas['ObrasSociales']['index'])) { ?>
            <li class=" <?php echo ($controller == 'ObrasSociales' && ($action == 'index' || $action == '' || $action == 'add' || $action == 'edit') ? ' active' : ''); ?>">
                <a href="<?php echo $this->Url->build('/ObrasSociales/index'); ?>">
                    <i class="fa fa-heartbeat"></i> <span>Obras Sociales</span>
                </a>
            </li>
        <?php } ?>

        <?php
        if (
            (isset($accionesPermitidas['TipoDocumentos']['index']) && $accionesPermitidas['TipoDocumentos']['index']) ||
            (isset($accionesPermitidas['PedidoEstados']['index']) && $accionesPermitidas['PedidoEstados']['index']) ||
            (isset($accionesPermitidas['ConsultasEstados']['index']) && $accionesPermitidas['ConsultasEstados']['index']) ||
            (isset($accionesPermitidas['Categorias']['index']) && $accionesPermitidas['Categorias']['index'])
        ) {
            $menu_sistema = array("TipoDocumentos", "Categorias",  "Categorias", "PedidosEstados", "ConsultasEstados");
            if (in_array($controller, $menu_sistema) and $action != 'detail') {
                $active = "active";
                $menu_open = "menu-open";
            } else {
                $active = "";
                $menu_open = "";
            }
        ?>
            <li class="treeview <?php echo $active . " " . $menu_open ?>">
                <a href="#">
                    <i class="fa fa-laptop"></i> <span>Parámetros del sistema</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php if ((isset($accionesPermitidas['Categorias']['index']) && $accionesPermitidas['Categorias']['index'])) { ?>
                        <li class=" <?php echo ($controller == 'Categorias' && ($action == 'index' || $action == '' || $action == 'add' || $action == 'edit') ? ' active' : ''); ?>">
                            <a href="<?php echo $this->Url->build('/Categorias/index'); ?>">
                                <i class="fa fa-circle-o"></i> Categorías
                            </a>
                        </li>
                    <?php } ?>
                    <?php if ((isset($accionesPermitidas['ConsultasEstados']['index']) && $accionesPermitidas['ConsultasEstados']['index'])) { ?>
                        <li class=" <?php echo ($controller == 'ConsultasEstados' && ($action == 'index' || $action == '' || $action == 'add' || $action == 'edit') ? ' active' : ''); ?>">
                            <a href="<?php echo $this->Url->build('/ConsultasEstados/index'); ?>">
                                <i class="fa fa-circle-o"></i> Estados de consulta
                            </a>
                        </li>
                    <?php } ?>
                    <?php if ((isset($accionesPermitidas['PedidosEstados']['index']) && $accionesPermitidas['PedidosEstados']['index'])) { ?>
                        <li class=" <?php echo ($controller == 'PedidosEstados' && ($action == 'index' || $action == '' || $action == 'add' || $action == 'edit') ? ' active' : ''); ?>">
                            <a href="<?php echo $this->Url->build('/PedidosEstados/index'); ?>">
                                <i class="fa fa-circle-o"></i> Estados de pedido
                            </a>
                        </li>
                    <?php } ?>
                    <?php if ((isset($accionesPermitidas['TipoDocumentos']['index']) && $accionesPermitidas['TipoDocumentos']['index'])) { ?>
                        <li class=" <?php echo ($controller == 'TipoDocumentos' && ($action == 'index' || $action == '' || $action == 'add' || $action == 'edit') ? ' active' : ''); ?>">
                            <a href="<?php echo $this->Url->build('/TipoDocumentos/index'); ?>">
                                <i class="fa fa-circle-o"></i> Tipo de Documentos
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>
        <?php if ((isset($accionesPermitidas['Proveedores']['index']) && $accionesPermitidas['Proveedores']['index'])) { ?>
            <li class=" <?php echo ($controller == 'Proveedores' && ($action == 'index' || $action == ''  || $action == 'add' || $action == 'edit') ? ' active' : ''); ?>">
                <a href="<?php echo $this->Url->build('/Proveedores/index'); ?>">
                    <i class="fa fa-cubes"></i> <span>Proveedores</span>
                </a>
            </li>
        <?php } ?>

    <?php }  ?>

    <li class="header"><i class="fa f-lg  fa-arrow-circle-right"></i> Menú Cliente </li>

    <?php //if ((isset($accionesPermitidas['Categorias']['view']) && $accionesPermitidas['Categorias']['view'])) {
    ?>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-fw  fa-cubes"></i> <span>Categorias</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <?php foreach ($categoriasMenu as $id => $categoria) : ?>
                <li><a href="<?php echo $this->Url->build(['controller' => 'Categorias', 'action' => 'view', $id]); ?>">
                        <i class="fa fa-circle-o"></i> <?php echo h($categoria); ?>
                    </a></li>
            <?php endforeach; ?>
        </ul>
    </li>
    <?php //}
    ?>
    <?php if ((isset($accionesPermitidas['Productos']['catalogoCliente']) && $accionesPermitidas['Productos']['catalogoCliente'])) { ?>
        <li class=" <?php echo ($controller == 'Productos' && ($action == 'catalogoCliente') ? ' active' : ''); ?>">
            <a href="<?php echo $this->Url->build('/Productos/catalogoCliente'); ?>">
                <i class="fa fa-fw fa-medkit"></i> <span>Productos</span>
            </a>
        </li>
    <?php } ?>

    <?php if ((isset($accionesPermitidas['Pedidos']['misPedidos']) && $accionesPermitidas['Pedidos']['misPedidos'])) {    ?>
        <li>
            <a href="<?php echo $this->Url->build('/Pedidos/misPedidos'); ?>">
                <i class="fa fa-fw fa-shopping-cart"></i>
                <span>Mis pedidos</span></a>
        </li>
    <?php }  ?>
    <?php if ((isset($accionesPermitidas['Consultas']['add']) && $accionesPermitidas['Consultas']['add'])) { ?>
        <li>
            <a href="<?php echo $this->Url->build('/Consultas/add'); ?>">
                <i class="fa fa-fw  fa-envelope"></i>
                <span>Consultas</span></a>
        </li>
    <?php }    ?>

    <!-- <li class="treeview">
        <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Layout Options</span>
            <span class="pull-right-container">
                <span class="label label-primary pull-right">4</span>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo $this->Url->build('/pages/layout/top-nav');
                            ?>"><i class="fa fa-circle-o"></i> Top Navigation</a></li>
            <li><a href="<?php echo $this->Url->build('/pages/layout/boxed');
                            ?>"><i class="fa fa-circle-o"></i> Boxed</a></li>
            <li><a href="<?php echo $this->Url->build('/pages/layout/fixed');
                            ?>"><i class="fa fa-circle-o"></i> Fixed</a></li>
            <li><a href="<?php echo $this->Url->build('/pages/layout/collapsed-sidebar');
                            ?>"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>
        </ul>
    </li>
    <li>
        <a href="<?php echo $this->Url->build('/pages/widgets'); ?>">
            <i class="fa fa-th"></i> <span>Widgets</span>
            <span class="pull-right-container">
                <small class="label pull-right bg-green">new</small>
            </span>
        </a>
    </li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-pie-chart"></i>
            <span>Charts</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo $this->Url->build('/pages/charts/chartjs'); ?>"><i class="fa fa-circle-o"></i> ChartJS</a></li>
            <li><a href="<?php echo $this->Url->build('/pages/charts/morris'); ?>"><i class="fa fa-circle-o"></i> Morris</a></li>
            <li><a href="<?php echo $this->Url->build('/pages/charts/flot'); ?>"><i class="fa fa-circle-o"></i> Flot</a></li>
            <li><a href="<?php echo $this->Url->build('/pages/charts/inline'); ?>"><i class="fa fa-circle-o"></i> Inline charts</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-laptop"></i>
            <span>UI Elements</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo $this->Url->build('/pages/ui/general'); ?>"><i class="fa fa-circle-o"></i> General</a></li>
            <li><a href="<?php echo $this->Url->build('/pages/ui/icons'); ?>"><i class="fa fa-circle-o"></i> Icons</a></li>
            <li><a href="<?php echo $this->Url->build('/pages/ui/buttons'); ?>"><i class="fa fa-circle-o"></i> Buttons</a></li>
            <li><a href="<?php echo $this->Url->build('/pages/ui/sliders'); ?>"><i class="fa fa-circle-o"></i> Sliders</a></li>
            <li><a href="<?php echo $this->Url->build('/pages/ui/timeline'); ?>"><i class="fa fa-circle-o"></i> Timeline</a></li>
            <li><a href="<?php echo $this->Url->build('/pages/ui/modals'); ?>"><i class="fa fa-circle-o"></i> Modals</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-edit"></i> <span>Forms</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo $this->Url->build('/pages/forms/general'); ?>"><i class="fa fa-circle-o"></i> General Elements</a></li>
            <li><a href="<?php echo $this->Url->build('/pages/forms/advanced'); ?>"><i class="fa fa-circle-o"></i> Advanced Elements</a></li>
            <li><a href="<?php echo $this->Url->build('/pages/forms/editors'); ?>"><i class="fa fa-circle-o"></i> Editors</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-table"></i> <span>Tables</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo $this->Url->build('/pages/tables/simple'); ?>"><i class="fa fa-circle-o"></i> Simple tables</a></li>
            <li><a href="<?php echo $this->Url->build('/pages/tables/data'); ?>"><i class="fa fa-circle-o"></i> Data tables</a></li>
        </ul>
    </li> -->

    <!-- <li>
        <a href="<?php echo $this->Url->build('/pages/mailbox/mailbox'); ?>">
            <i class="fa fa-envelope"></i> <span>Mailbox</span>
            <span class="pull-right-container">
                <small class="label pull-right bg-yellow">12</small>
                <small class="label pull-right bg-green">16</small>
                <small class="label pull-right bg-red">5</small>
            </span>
        </a>
    </li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-folder"></i> <span>Examples</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo $this->Url->build('/pages/examples/invoice'); ?>"><i class="fa fa-circle-o"></i> Invoice</a></li>
            <li><a href="<?php echo $this->Url->build('/pages/examples/profile'); ?>"><i class="fa fa-circle-o"></i> Profile</a></li>
            <li><a href="<?php echo $this->Url->build('/pages/examples/login'); ?>"><i class="fa fa-circle-o"></i> Login</a></li>
            <li><a href="<?php echo $this->Url->build('/pages/examples/register'); ?>"><i class="fa fa-circle-o"></i> Register</a></li>
            <li><a href="<?php echo $this->Url->build('/pages/examples/lockscreen'); ?>"><i class="fa fa-circle-o"></i> Lockscreen</a></li>
            <li><a href="<?php echo $this->Url->build('/pages/examples/404'); ?>"><i class="fa fa-circle-o"></i> 404 Error</a></li>
            <li><a href="<?php echo $this->Url->build('/pages/examples/500'); ?>"><i class="fa fa-circle-o"></i> 500 Error</a></li>
            <li><a href="<?php echo $this->Url->build('/pages/examples/blank'); ?>"><i class="fa fa-circle-o"></i> Blank Page</a></li>
            <li><a href="<?php echo $this->Url->build('/pages/examples/pace'); ?>"><i class="fa fa-circle-o"></i> Pace Page</a></li>
        </ul>
    </li> -->
    <!-- <li class="treeview">
    <a href="#">
      <i class="fa fa-share"></i> <span>Multilevel</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
      <li class="treeview">
        <a href="#"><i class="fa fa-circle-o"></i> Level One
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
          <li class="treeview">
            <a href="#"><i class="fa fa-circle-o"></i> Level Two
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
              <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
            </ul>
          </li>
        </ul>
      </li>
      <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
    </ul>
  </li> -->
    <!-- <li><a href="https://adminlte.io/docs"><i class="fa fa-book"></i> <span>Documentation</span></a></li> -->
    <?php if (Configure::read('debug')) { ?>
        <li><a href="<?php echo $this->Url->build('/pages/debug'); ?>">
                <i class="fa fa-bug"></i> <span>Debug</span></a>
        </li>
    <?php  } ?>
</ul>
