<?php $this->layout = 'Rbac.forget_password';


use Cake\Core\Configure;
?>
<div>

    <form id="formForgetPassword" class="well" role="form" action="/rbac/RbacUsuarios/forgetPassword/" method="POST">

        <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getAttribute('csrfToken'); ?>">
        <div class="register-logo">
            <a href="<?php echo $this->Url->build(); ?>"><?php echo Configure::read('Theme.logo.large') ?></a>
        </div>

        <div class="form-group has-feedback">
            <input required type="text" class="form-control" maxlength="40" name="usuario" required placeholder="Usuario o Correo electrónico">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>



        <?php if (isset($captcha) && $captcha == 'Si') { ?>

            <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
            <script src="https://www.google.com/recaptcha/api.js?render=<?php echo env('RECAPTCHA_CLAVE_PUBLICA'); ?>"></script>
            <script>
                grecaptcha.ready(function() {
                    grecaptcha.execute('<?php echo env('RECAPTCHA_CLAVE_PUBLICA'); ?>', {
                        action: 'login'
                    }).then(function(token) {
                        document.getElementById('g-recaptcha-response').value = token;
                    });
                });
            </script>
            <br>
        <?php }
        ?>

        <button class="btn btn-lg btn-primary btn-block" type="submit"><i class="fa fa-lg fa-history"></i> Recuperar</button>
        <br />
        <div class="callout callout-success">
            <p><i class="fa fa-lg fa fa-info"></i> Por favor, ingresa tu dirección de correo electrónico. Te enviaremos un enlace para restablecer tu contraseña.</p>
        </div>
        <?= $this->Flash->render() ?>
        <!-- <a href="/rbac/rbac_usuarios/recuperar"><span class="label label-danger">Recuperar contraseña</span></a>-->
    </form>

</div>
