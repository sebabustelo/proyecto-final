<?php

use Cake\Core\Configure; ?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo Configure::read('Theme.title'); ?> </title>
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

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="<?php echo $this->Url->build(); ?>"><?php //echo Configure::read('Theme.logo.large')
                                                            ?></a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Cambiar contraseña</p>

            <?php echo $this->fetch('content'); ?>

        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery 3 -->
    <?php echo $this->Html->script('AdminLTE./bower_components/jquery/dist/jquery.min'); ?>
    <!-- Bootstrap 3.3.7 -->
    <?php echo $this->Html->script('AdminLTE./bower_components/bootstrap/dist/js/bootstrap.min'); ?>



</body>

</html>
