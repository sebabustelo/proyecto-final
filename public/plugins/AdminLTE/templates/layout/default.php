<?php

use Cake\Core\Configure; ?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo Configure::read('Theme.title'); ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <?php echo $this->Html->css('AdminLTE./bower_components/bootstrap/dist/css/bootstrap.min'); ?>
  <!-- Bootstrap-fileinput -->
  <?php echo $this->Html->css('AdminLTE./bower_components/bootstrap-fileinput/css/fileinput.min'); ?>
  <?php echo $this->Html->css('AdminLTE./bower_components/bootstrap-fileinput/themes/explorer-fa4/theme.css'); ?>
  <?php echo $this->Html->css('AdminLTE./bower_components/bootstrap-duallistbox/dist/bootstrap-duallistbox.min.css'); ?>
  <?php echo $this->Html->css('AdminLTE./bower_components/bootstrap-daterangepicker/daterangepicker', ['block' => 'css']); ?>
  <!-- Font Awesome -->
  <?php echo $this->Html->css('AdminLTE./bower_components/font-awesome/css/font-awesome.min'); ?>
  <!-- Ionicons -->
  <?php echo $this->Html->css('AdminLTE./bower_components/Ionicons/css/ionicons.min'); ?>
  <?php //echo $this->Html->css('AdminLTE./bower_commponents/jquery-treegrid/dist/css/jquery.treegrid');
  ?>
  <?php echo $this->Html->css('jquery.treegrid'); ?>
  <!-- Theme style -->
  <?php echo $this->Html->css('AdminLTE.AdminLTE.min'); ?>

  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <?php echo $this->Html->css('AdminLTE.skins/skin-' . Configure::read('Theme.skin') . '.min'); ?>
  <?php echo $this->Html->css('catalogo_cliente.css'); ?>


  <!-- jQuery 3 -->
  <?php echo $this->Html->script('AdminLTE./bower_components/jquery/dist/jquery.min'); ?>
  <?php //echo $this->Html->script('jquery.bootstrap-duallistbox'); ?>
  <?php echo $this->Html->script('jquery.treegrid'); ?>
  <?php //echo $this->Html->script('AdminLTE./bower_components/jquery-treegrid/dist/js/jquery.treegrid');
  ?>

  <!-- Bootstrap 3.3.7 -->
  <?php echo $this->Html->script('AdminLTE./bower_components/bootstrap/dist/js/bootstrap.min'); ?>
  <!-- Bootstrap-fileinput -->
  <?php echo $this->Html->script('AdminLTE./bower_components/bootstrap-fileinput/js/fileinput.min'); ?>
  <?php echo $this->Html->script('AdminLTE./bower_components/moment/min/moment.min', ['block' => 'script']); ?>
  <?php echo $this->Html->script('AdminLTE./bower_components/bootstrap-daterangepicker/daterangepicker', ['block' => 'script']); ?>
  <?php //echo $this->Html->script('AdminLTE./bower_components/bootstrap-fileinput/themes/explorer-fa4/theme.js'); ?>
  <?php echo $this->Html->script('AdminLTE./bower_components/bootstrap-fileinput/themes/fa4/theme.js'); ?>
  <?php echo $this->Html->script('AdminLTE./bower_components/bootstrap-fileinput/js/locales/es.js'); ?>
  <?php echo $this->Html->script('AdminLTE./bower_components/bootstrap-duallistbox/dist/jquery.bootstrap-duallistbox.min'); ?>


  <!-- AdminLTE App -->
  <?php echo $this->Html->script('AdminLTE.adminlte.min'); ?>
  <!-- Slimscroll -->
  <?php echo $this->Html->script('AdminLTE./bower_components/jquery-slimscroll/jquery.slimscroll.min'); ?>
  <!-- FastClick -->
  <?php echo $this->Html->script('AdminLTE./bower_components/fastclick/lib/fastclick'); ?>

  <?php echo $this->fetch('script'); ?>

  <?php echo $this->fetch('scriptBottom'); ?>


  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <?php echo $this->fetch('css'); ?>

</head>

<body class="hold-transition skin-<?php echo Configure::read('Theme.skin'); ?> sidebar-mini">
  <div class="wrapper">

    <header class="main-header">
      <!-- Logo -->
      <a href="<?php echo $this->Url->build('/'); ?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><?php echo Configure::read('Theme.logo.mini'); ?></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><?php echo Configure::read('Theme.logo.large'); ?></span>
      </a>
      <!-- Header Navbar: style can be found in header.less -->
      <?php echo $this->element('nav-top'); ?>
    </header>

    <?php echo $this->element('aside-main-sidebar'); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <?php echo $this->Flash->render(); ?>
      <?php echo $this->Flash->render('auth'); ?>
      <?php echo $this->fetch('content'); ?>

    </div>
    <!-- /.content-wrapper -->

    <?php echo $this->element('footer'); ?>

    <!-- Control Sidebar -->
    <?php echo $this->element('aside-control-sidebar'); ?>
    <!-- /.control-sidebar -->

    <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->

  <script type="text/javascript">
    $(document).ready(function() {
      $(".navbar .menu").slimscroll({
        height: "200px",
        alwaysVisible: false,
        size: "3px"
      }).css("width", "100%");

      var a = $('a[href="<?php echo $this->Url->build() ?>"]');
      if (!a.parent().hasClass('treeview') && !a.parent().parent().hasClass('pagination')) {
        a.parent().addClass('active').parents('.treeview').addClass('active');
      }

    });
  </script>


</body>

</html>
<script type="text/javascript">
  // $(document).ready(function() {

  $(".pag-ajax").on("click", function(event) {

    //$(".table-ajax").loading();
    window.history.pushState("object or string", "Paginacion", $(this).attr("href"));
    event.preventDefault();
    fetch($(this).attr("href"), {
        method: "GET",
        headers: {
          "X-Requested-With": "XMLHttpRequest"
        }
      })
      .then(response => response.text())
      .then((response) => {

        //jQuery("#accordion").show();

        jQuery(".content-wrapper").html(response);
        //console.log(response)
      })
      .catch(function(err) {
        console.log(err);
        fetch("https://ipmagna/login", {
            method: "GET",
            headers: {
              "X-Requested-With": "XMLHttpRequest"
            }
          })
          .then((response) => response.text())
          .then((response) => {
            jQuery("#divDialog").html(response)
            $("#myModal").modal("show")
          })
      })
  })
  // })
</script>
