<?php

use Cake\Core\Configure;

$controller =   $this->request->getParam('controller');
$action =   $this->request->getParam('action');
?>
<ul class="sidebar-menu" data-widget="tree">
    <li class="header"> </li>
    <?php if ((isset($accionesPermitidas['Pages']['display']) && $accionesPermitidas['Pages']['display'])) { ?>
        <li><a href="<?php echo $this->Url->build('/pages/home2'); ?>"><i class="fa fa-area-chart"></i> <span>Informes</span></a></li>
    <?php } ?>
    <?php
    if (
        (isset($accionesPermitidas['Configuraciones']['index']) && $accionesPermitidas['Configuraciones']['index']) ||
        (isset($accionesPermitidas['RbacUsuarios']['index']) && $accionesPermitidas['RbacUsuarios']['index']) ||
        (isset($accionesPermitidas['RbacPerfiles']['index']) && $accionesPermitidas['RbacPerfiles']['index']) ||
        (isset($accionesPermitidas['RbacAcciones']['index']) && $accionesPermitidas['RbacAcciones']['index'])

    ) {
        //Preguntar si esta ingresando a algunos de los menus de "Sistema" array $menu_sistema[],
        //para esto pregunto por el contralador y la accion
        $menu_sistema = array("Configuraciones", "RbacAcciones", "RbacPerfiles", "RbacPermisos", "RbacUsuarios");
        if (in_array($controller, $menu_sistema) and $action!='detail') {
            $active = "active";
            $menu_open = "menu-open";
        } else {
            $active = "";
            $menu_open = "";
        }
    ?>
        <li class="treeview <?php echo $active . " " . $menu_open ?>">
            <a href="#">
                <i class="fa fa-gears"></i> <span>Aplicación</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <?php if ((isset($accionesPermitidas['RbacUsuarios']['index']) && $accionesPermitidas['RbacUsuarios']['index'])) { ?>
                    <li class=" <?php echo ($controller == 'RbacUsuarios' && ($action == 'index' || $action == '') ? ' active' : ''); ?>">
                        <a href="<?php echo $this->Url->build('/rbac/RbacUsuarios/index'); ?>"><i class="fa fa-users"></i> Usuarios</a>
                    </li>
                <?php } ?>
                <?php if ((isset($accionesPermitidas['RbacPerfiles']['index']) && $accionesPermitidas['RbacPerfiles']['index'])) { ?>
                    <li class=" <?php echo ($controller == 'RbacPerfiles' && ($action == 'index' || $action == '') ? ' active' : ''); ?>">
                        <a href="<?php echo $this->Url->build('/rbac/RbacPerfiles/index'); ?>"><i class="fa fa-suitcase"></i>Perfiles</a>
                    </li>
                <?php } ?>
                <?php if ((isset($accionesPermitidas['RbacAcciones']['index']) && $accionesPermitidas['RbacAcciones']['index'])) { ?>
                    <li class=" <?php echo ($controller == 'RbacAcciones' && ($action == 'index' || $action == '') ? ' active' : ''); ?>">
                        <a href="<?php echo $this->Url->build('/rbac/RbacAcciones/index'); ?>"><i class="fa fa-lock fa-lg"></i>Permisos</a>
                    </li>
                <?php } ?>
                <?php if ((isset($accionesPermitidas['Configuraciones']['index']) && $accionesPermitidas['Configuraciones']['index'])) { ?>
                    <li class=" <?php echo ($controller == 'Configuraciones' && ($action == 'index' || $action == '') ? ' active' : ''); ?>">
                        <a href="<?php echo $this->Url->build('/rbac/Configuraciones/index'); ?>"><i class="fa fa-wrench fa-lg"></i>Configuraciones</a>
                    </li>
                <?php } ?>
            </ul>
        </li>
    <?php } ?>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-folder"></i> <span>Parametricas</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo $this->Url->build('/TipoDocumentos/index'); ?>">
                    <i class="fa fa-circle-o"></i> Tipo de Documentos</a>
            </li>
            <li>
                <a href="<?php echo $this->Url->build('/pages/en_construccion'); ?>">
                    <i class="fa fa-circle-o"></i> <span>Productos</span>

                </a>
            </li>
        </ul>

    </li>
    <li>
        <a href="<?php echo $this->Url->build('/pages/en_construccion'); ?>">
            <i class="fa fa-fw  fa-cubes"></i> <span>Productos</span>
        </a>
    </li>

    <?php //if ((isset($accionesPermitidas['Pages']['index']) && $accionesPermitidas['Pages']['display'])) {
    ?>
    <li>
        <a href="<?php echo $this->Url->build('/pages/en_construccion'); ?>">
            <i class="fa fa-edit"></i>
            <span>Pedidos</span></a>
    </li>
    <?php //}
    ?>
    <li class="treeview">
    <a href="#">
      <i class="fa fa-files-o"></i>
      <span>Layout Options</span>
      <span class="pull-right-container">
        <span class="label label-primary pull-right">4</span>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="<?php //echo $this->Url->build('/pages/layout/top-nav');
                    ?>"><i class="fa fa-circle-o"></i> Top Navigation</a></li>
      <li><a href="<?php //echo $this->Url->build('/pages/layout/boxed');
                    ?>"><i class="fa fa-circle-o"></i> Boxed</a></li>
      <li><a href="<?php //echo $this->Url->build('/pages/layout/fixed');
                    ?>"><i class="fa fa-circle-o"></i> Fixed</a></li>
      <li><a href="<?php //echo $this->Url->build('/pages/layout/collapsed-sidebar');
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
    </li>
    <li>
        <a href="<?php echo $this->Url->build('/pages/calendar'); ?>">
            <i class="fa fa-calendar"></i> <span>Agenda</span>
            <span class="pull-right-container">
                <small class="label pull-right bg-red">3</small>
                <small class="label pull-right bg-blue">17</small>
            </span>
        </a>
    </li>
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
