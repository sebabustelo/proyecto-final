<?php
$controller =   $this->request->getParam('controller');
$action =   $this->request->getParam('action');
?>
<ul class="sidebar-menu" data-widget="tree">
  <li class="header"> </li>
  <li><a href="<?php echo $this->Url->build('/pages/home2'); ?>"><i class="fa fa-dashboard"></i> <span>Informes</span></a></li>

  <?php
  if (
    (isset($accionesPermitidas['Configuraciones']['index']) && $accionesPermitidas['Configuraciones']['index']) ||
    (isset($accionesPermitidas['RbacUsuarios']['index']) && $accionesPermitidas['RbacUsuarios']['index']) ||
    (isset($accionesPermitidas['RbacUsuarios']['editar']) && $accionesPermitidas['RbacUsuarios']['editar']) ||
    (isset($accionesPermitidas['RbacUsuarios']['agregar']) && $accionesPermitidas['RbacUsuarios']['agregar']) ||
    (isset($accionesPermitidas['RbacPerfiles']['index']) && $accionesPermitidas['RbacPerfiles']['index']) ||
    (isset($accionesPermitidas['RbacAcciones']['index']) && $accionesPermitidas['RbacAcciones']['index']) ||
    (isset($accionesPermitidas['Productos']['index']) && $accionesPermitidas['Productos']['index'])
  ) {
    //Preguntar si esta ingresando a algunos de los menus de "Sistema" array $menu_sistema[],
    //para esto pregunto por el contralador y la accion
    $menu_sistema = array("Configuraciones", "RbacAcciones", "RbacPerfiles", "RbacPermisos", "RbacUsuarios", "Productos");
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
        <i class="fa fa-gears"></i> <span>Aplicación</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li class=" <?php echo ($controller == 'RbacUsuarios' && ($action == 'index' || $action == '') ? ' active' : ''); ?>">
          <a href="<?php echo $this->Url->build('/rbac/RbacUsuarios/index'); ?>"><i class="fa fa-users"></i> Usuarios</a>
        </li>
        <li class=" <?php echo ($controller == 'RbacPerfiles' && ($action == 'index' || $action == '') ? ' active' : ''); ?>">
          <a href="<?php echo $this->Url->build('/rbac/RbacPerfiles/index'); ?>"><i class="fa fa-suitcase"></i>Perfiles</a>
        </li>
        <li class=" <?php echo ($controller == 'RbacAcciones' && ($action == 'index' || $action == '') ? ' active' : ''); ?>">
          <a href="<?php echo $this->Url->build('/rbac/RbacAcciones/index'); ?>"><i class="fa fa-list"></i>Acciones</a>
        </li>

      </ul>
    </li>
  <?php } ?>
  <li>
    <a href="<?php echo $this->Url->build('/productos'); ?>">
      <i class="fa fa-fw  fa-cubes"></i> <span>Productos</span>
      <span class="pull-right-container">

      </span>
    </a>
  </li>
  <!-- <li class="treeview">
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
  </li> -->
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
      <i class="fa fa-calendar"></i> <span>Calendar</span>
      <span class="pull-right-container">
        <small class="label pull-right bg-red">3</small>
        <small class="label pull-right bg-blue">17</small>
      </span>
    </a>
  </li>
  <li>
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
  </li>
  <li class="treeview">
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
  </li>
  <li><a href="https://adminlte.io/docs"><i class="fa fa-book"></i> <span>Documentation</span></a></li>

  <li><a href="<?php echo $this->Url->build('/pages/debug'); ?>"><i class="fa fa-bug"></i> <span>Debug</span></a></li>
</ul>
