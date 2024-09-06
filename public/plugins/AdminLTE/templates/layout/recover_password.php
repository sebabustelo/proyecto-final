<?php use Cake\Core\Configure; ?>

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
  <!-- Font Awesome -->
  <?php echo $this->Html->css('AdminLTE./bower_components/font-awesome/css/font-awesome.min'); ?>
  
  <!-- Theme style -->
  <?php echo $this->Html->css('AdminLTE.AdminLTE.min'); ?>
 
 
  <?php echo $this->fetch('css'); ?>

</head>
<body class="hold-transition register-page">
<div class="register-box">


  <div class="register-box-body">
    <p class="login-box-msg">Recuperar contraseña</p>

    <?php echo $this->fetch('content'); ?>

    <?php if (Configure::read('Theme.login.show_remember')): ?>
      <a href="/login">Iniciar Sesión</a><br>
    <?php endif; ?>
    <?php if (Configure::read('Theme.login.show_register')): ?>
      <a href="/register" class="text-center">Registrarme</a>
    <?php endif; ?>

  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->

<!-- jQuery 3 -->
<?php echo $this->Html->script('AdminLTE./bower_components/jquery/dist/jquery.min'); ?>
<!-- Bootstrap 3.3.7 -->
<?php echo $this->Html->script('AdminLTE./bower_components/bootstrap/dist/js/bootstrap.min'); ?>


</body>
</html>
