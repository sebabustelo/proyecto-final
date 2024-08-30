<?php
use Cake\Core\Configure;
use Cake\Routing\Router;
$session = $this->request->getSession();
$perfilDefault = @$session->read('PerfilDefault');
$perfilPorUsuario = @$session->read('PerfilesPorUsuario');
if (!$session->check("PerfilesPorUsuario")) {
    header("location:/login");exit();
}
$autorizados = array('Desarrollador','Administrador');  //Perfiles autorizados
$arr_perfil = array_filter($perfilPorUsuario, function ($obj) use ($perfilDefault) {
    return $obj['id'] == $perfilDefault;
});
/*if (count($perfilPorUsuario)>1)
    $perfilDefault = @$session->read('PerfilDefault');
else
    $perfilDefault=0;
*/
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo Configure::read('Tema.titulo'); ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  	<?php
	    //echo header("Cache-Control: no-cache, must-revalidate");
        //echo header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");

        echo $this->Html->meta('icon');
        echo $this->Html->css('AdminLTE./bootstrap/css/bootstrap.min');
        echo $this->Html->css('font-awesome.min');
        echo $this->Html->css('font-sourcesanspro');
        echo $this->Html->css('ionicons.min');
        echo $this->Html->css('AdminLTE./css/AdminLTE.min');
        echo $this->Html->css('AdminLTE./css/skins/skin-'. Configure::read('Theme.skin') .'.min');
        echo $this->Html->css('jquery-ui.min');
        echo $this->Html->css('bootstrap-duallistbox');
        echo $this->Html->css('table-fixed-header');
        echo $this->Html->css('bootstrap-checkbox');
        echo $this->Html->css('bootstrap-multiselect');
        echo $this->Html->css('bootstrap-select.min');
        echo $this->Html->css('bootstrap-switch.min');
        echo $this->Html->css('jquery.treegrid');
        echo $this->Html->css('bootstrap-editable');
        echo $this->Html->css('default');
        echo $this->Html->css('loading');



        //echo $this->Html->script('jquery.min');
        echo $this->Html->script('AdminLTE./plugins/jquery/jquery-2.2.3.min');
        echo $this->Html->script('AdminLTE./bootstrap/js/bootstrap.min');
        echo $this->Html->script('AdminLTE./plugins/slimScroll/jquery.slimscroll.min');
        echo $this->Html->script('AdminLTE./plugins/fastclick/fastclick');
        echo $this->Html->script('loading');
        echo $this->Html->script('jquery.easing.1.3');
        echo $this->Html->script('jquery.validate.min');
        echo $this->Html->script('bootbox.min');
        echo $this->Html->script('jquery-ui.min');
        echo $this->Html->script('jquery.bootstrap-duallistbox');
        echo $this->Html->script('bootstrap-checkbox');
        echo $this->Html->script('bootstrap-multiselect');
        echo $this->Html->script('bootstrap-select.min');
        echo $this->Html->script('jquery.treegrid');
        echo $this->Html->script('jquery.treegrid.bootstrap3.js');
        echo $this->Html->script('bootstrap-switch.min');
        echo $this->Html->script('bootstrap-editable.min.js');
        echo $this->Html->script('AdminLTE./js/app');
        echo $this->Html->script('jspdf.min');
        echo $this->Html->script('jquery.sheepItPlugin-1.1.1');
        echo $this->Html->script('default');
        echo $this->Html->script('crypto-js.min'); //NHG para Hash



        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');

        $inicio = $this->request->getSession()->read('inicio');
  ?>
</head>
<body class="hold-transition skin-<?php echo Configure::read('Theme.skin'); ?> sidebar-mini">
	<div class="wrapper">
        <div class="main-header">
            <div style="z-index: 9999;position: relative;clear:both;width:100%;height:80px;background-size:contain;background-image:url('<?php echo $this->Url->build('/').'img/fondo_cabecera.png';?>');background-repeat:repeat-x;">
        		<div style="width:35%;float:left;z-index:1000;">
        			<img src="<?php echo $this->Url->build('/').'img/cabecera_1.jpg';?>" border="0" height="80" />
        		</div>
        		<div style="width:30%;float:left;z-index:1000;text-align:center;">
        			<h2 style="font-weight:bold;">CakePHP 5 Base</h2>
        		</div>
        		<div style="width:35%;float:right;text-align:right;z-index:1;">
        			<img src="<?php echo $this->Url->build('/').'img/cabecera_2.jpg';?>" border="0" height="80" />
        		</div>
        	</div>
        	<!-- Sidebar toggle button-->
        	<div class="logo">
    			<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                   <span class="sr-only">Toggle navigation</span>
                </a>
            </div>
            <!-- Logo -->
            <!-- <a href="<?php //echo $this->Url->build('/'); ?>" class="logo">
                <span class="logo-mini"><?php //echo Configure::read('Tema.logo.mini'); ?></span>
                <span class="logo-lg"><?php //echo Configure::read('Tema.logo.large'); ?></span>
            </a>-->
            <?php echo $this->element('barra-superior') ?>
        </div>

        <!-- Left side column. contains the sidebar -->
        <?php echo $this->element('menu-principal'); ?>

        <!-- =============================================== -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <?php echo $this->Flash->render(); ?>
            <?php echo $this->Flash->render('auth'); ?>
            <?php echo $this->fetch('content'); ?>

        </div>

		<!-- Barra inferior -->
        <?php echo $this->element('barra-inferior'); ?>

        <!-- Menu del sistema -->
        <?php echo $this->element('menu-control'); ?>
    	<div class="control-sidebar-bg"></div>
</div>


<?php
if (Configure::read('debug') == 1 && in_array($arr_perfil[key($arr_perfil)]['descripcion'], $autorizados)) {
    echo $this->element('Rbac.entorno');
} ?>


<?php //echo $this->element('sql_dump'); ?>
<?php echo $this->fetch('scriptBottom'); ?>
<script type="text/javascript">
    $(document).ready(function(){

		//$('.alert-success, .alert-danger').fadeOut(20000);
        $('.alert-success').fadeOut(20000);
        //$('.conten-wrapper').css('height','674px');
        $(".navbar .menu").slimscroll({
            height: "200px",
            alwaysVisible: false,
            size: "3px"
        }).css("width", "100%");

        var a = $('a[href="<?php echo Router::url(); ?>"]');
        if (!a.parent().hasClass('treeview') && !a.parent().parent().hasClass('pagination')) {
            a.parent().addClass('active').parents('.treeview').addClass('active');
        }

        jQuery.extend(jQuery.validator.messages, {
         required: "Campo requerido.",
         remote: "Por favor, rellena este campo.",
         email: "Escribe una dirección de correo válida",
         url: "Escribe una URL válida.",
         date: "Escribe una fecha válida.",
         dateISO: "Por favor, escribe una fecha (ISO) válida.",
         number: "Por favor, escribe un número entero válido.",
         digits: "Por favor, escribe sólo dígitos.",
         creditcard: "Por favor, escribe un número de tarjeta válido.",
         equalTo: "Por favor, escribe el mismo valor de nuevo.",
         accept: "Por favor, escribe un valor con una extensión aceptada.",
         maxlength: jQuery.validator.format("Por favor, no escribas más de {0} caracteres."),
         minlength: jQuery.validator.format("Por favor, escriba al menos {0} caracteres."),
         rangelength: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1} caracteres."),
         range: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1}."),
         max: jQuery.validator.format("Por favor, escribe un valor menor o igual a {0}."),
         min: jQuery.validator.format("Por favor, escribe un valor mayor o igual a {0}.")
       });



    });
</script>
<input type="hidden" id="inicio" value="<?php echo $inicio; ?>" />
</body>
</html>
