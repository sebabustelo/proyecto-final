<?php $this->layout = 'AdminLTE.change_password'; ?>
<?php

use Cake\Core\Configure; ?>

<form class="form-signin well" id="formChangePassword" name="formChangePassword" role="form" action="/rbac/rbac_usuarios/changePassword/<?php echo $token; ?>/" method="POST">
    <div class="register-logo">
        <a href="<?php echo $this->Url->build(); ?>"><?php echo Configure::read('Theme.logo.large') ?></a>
    </div>

    <div class="form-group has-feedback">
        <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getAttribute('csrfToken'); ?>">
        <input minlength="6" name="password" id="password" required type="password" class="form-control" placeholder="Contraseña">
        <span class="fa fa-lock fa-lg form-control-feedback"></span>
        <?php //$user->getErrors() ?>
    </div>
    <div class="form-group has-feedback">
        <input minlength="6" name="password_confirm" id="password_confirm" required type="password" class="form-control" placeholder="Repita la contraseña">
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
        <div class="col-xs-12">
            <button id="submitButton" type="submit" class="btn btn-lg btn-primary btn-block "><i class="fa fa-lg fa-edit"></i> Guardar</button>
        </div>
    </div>

</form>
<script>
    document.getElementById('formChangePassword').addEventListener('submit', function(event) {
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
