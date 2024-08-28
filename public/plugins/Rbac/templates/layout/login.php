<?php use Cake\Core\Configure; ?>
<!DOCTYPE html>
<html>
<head>
<?php echo $this->Html->charset(); ?>
<title>ADMINISTRACION <?php echo Configure::read('Tema.titulo'); ?></title>
<?php
echo $this->Html->meta('icon');
//echo $this->Html->meta('_csrfToken', $this->request->getAttribute('csrfToken'));
echo $this->Html->css('AdminLTE./bootstrap/css/bootstrap.min');

echo $this->Html->css('font-awesome.min');
echo $this->Html->css('ionicons.min');
echo $this->Html->css('AdminLTE./css/AdminLTE.min');
echo $this->Html->css('AdminLTE./css/skins/skin-blue.min');

echo $this->Html->css('signin');


echo $this->fetch('css');
echo $this->fetch('script');
?>
</head>
<body>
	<div class="container">
		<?php echo $this->fetch('content'); ?>
		<?php echo $this->Flash->render(); ?>
	</div>
</body>

</html>
