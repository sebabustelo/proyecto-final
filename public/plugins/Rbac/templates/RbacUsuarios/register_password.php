<?php $this->layout = 'AdminLTE.register_password';

use Cake\Core\Configure; ?>
<?php
$user = $token->rbac_usuario;
if (isset($user)) { ?>
    <h2 class="sub-header"><small>

            <?php echo  "Nuevo Usuario |" . $user['nombre'] . ' ' . $user['apellido'] . ' (' . $user['usuario'] . ')'; ?></small></h2>

<?php } else { ?>
    <h2 class="sub-header"><small>Recuperar contraseña | No se encontro el usuario solicitado</small></h2>
<?php } ?>



<form id="formRegisterPassword" class="form-signin well" role="form" action="/rbac/rbac_usuarios/registerPassword/<?php echo $token->token; ?>" method="POST">
    <div class="register-logo">
        <a href="<?php echo $this->Url->build(); ?>"><?php echo Configure::read('Theme.logo.large') ?></a>
    </div>

    <div class="form-group has-feedback">
        <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getAttribute('csrfToken'); ?>">
        <input minlength="6" maxlength="40" name="password" id="password" required type="password" class="form-control" placeholder="Contraseña">
        <span class="fa fa-lock fa-lg form-control-feedback"></span>
        <?php //$user->getErrors() ?>
    </div>
    <div class="form-group has-feedback">
        <input minlength="6" maxlength="40" name="password_confirm" id="password_confirm" required type="password" class="form-control" placeholder="Repita la contraseña">
        <span class="fa fa-lock fa-lg form-control-feedback"></span>
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
    <?php }  ?>

    <div class="row">
        <!-- /.col -->
        <div class="col-xs-12">
            <button id="submitButton" type="submit" class="btn btn-lg btn-primary btn-block">Confirmar</button>
        </div>
        <!-- /.col -->
    </div>
</form>
<div class="callout callout-info">
    <p><i class="icon fa fa-info"></i> El password debe contener como minimo 6 carácteres, al menos una mayúscula y un carácter especial.</p>
</div>
<div class="row">
    <div class="col-xs-12">
        <?= $this->Flash->render() ?>
    </div>
</div>
<script>
    document.getElementById('formRegisterPassword').addEventListener('submit', function(event) {
        // Obtener los valores de los campos de contraseña
        const password = document.getElementById('password').value;
        const password_confirm = document.getElementById('password_confirm').value;

        // Definir la expresión regular para la validación
        const passwordRegex = /^(?=.*[A-Z])(?=.*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?`~\s]).{6,}$/;


        // Validar si las contraseñas coinciden
        if (password !== password_confirm) {
            alert('Las contraseñas no coinciden.');
            event.preventDefault(); // Detener el envío del formulario
            return;
        }

        // Validar si las contraseñas cumplen con los requisitos
        if (!passwordRegex.test(password)) {
            alert('La contraseña debe tener al menos 6 caracteres, una mayúscula y un carácter especial.');
            event.preventDefault(); // Detener el envío del formulario
            return;
        }

        // Si todo es válido, permitir el envío del formulario
    });
</script>
