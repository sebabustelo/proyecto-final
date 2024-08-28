<?php $this->layout = 'AdminLTE.register'; ?>
<?php

use Cake\Core\Configure; ?>
<form id="formLogin" class="form-signin well" role="form" action="/register/" method="POST">
    <div class="register-logo">
        <a href="<?php echo $this->Url->build(); ?>"><?php echo Configure::read('Theme.logo.large') ?></a>
    </div>
    <div class="form-group has-feedback">
        <input required type="text" class="form-control" placeholder="Nombre">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
        <input required type="text" class="form-control" placeholder="Apellido">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
        <input required type="email" class="form-control" placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Confirme el password">
        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="checkbox icheck">
                <label>
                    <input type="checkbox">&nbsp; Acepto los <a href="#">terminos</a>
                </label>
            </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-12">
            <button type="submit" class="btn btn-primary btn-block ">Registrarse</button>
        </div>
        <!-- /.col -->
    </div>
</form>
