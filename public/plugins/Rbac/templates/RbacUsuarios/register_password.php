<?php $this->layout = 'AdminLTE.login';

use Cake\Core\Configure; ?>
<?php
if (isset($user)) { ?>
    <h2 class="sub-header"><small>

            <?php echo  "Nuevo Usuario |" . $user['nombre'] . ' ' . $user['apellido'] . ' (' . $user['usuario'] . ')'; ?></small></h2>

<?php } else { ?>
    <h2 class="sub-header"><small>Recuperar contraseña | No se encontro el usuario solicitado</small></h2>
<?php } ?>



<form id="formRegisterPassword" class="form-signin well" role="form" action="/rbac/rbac_usuarios/registerPassword/<?php echo $token;?>" method="POST">
    <div class="register-logo">
        <a href="<?php echo $this->Url->build(); ?>"><?php echo Configure::read('Theme.logo.large') ?></a>
    </div>

    <div class="form-group has-feedback">
        <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getAttribute('csrfToken'); ?>">
        <input name="password" required type="password" class="form-control" placeholder="Contraseña">
        <span class="fa fa-lock fa-lg form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
        <input name="password_confirm" required type="password" class="form-control" placeholder="Repita la Contraseña">
        <span class="fa fa-lock fa-lg form-control-feedback"></span>
    </div>


    <div class="row">
        <!-- /.col -->
        <div class="col-xs-12">
            <button id="submitButton" type="submit" class="btn btn-primary btn-block ">Confirmar</button>
        </div>
        <!-- /.col -->
    </div>

</form>

<script type="text/javascript">
    $(function() {
        inicialize();
    });

    function inicialize() {
        $.validator.addMethod('alfanumerico', function(value, element, param) {
            var vsExprReg = /(([\d]+[A-Za-z]+)|[A-Za-z]+[\d]+$)/;
            return vsExprReg.test(value);
        });

        $('#formRegisterPassword').validate({
            rules: {

                'password': {
                    minlength: 8,
                    maxlength: 24,
                    alfanumerico: true,
                    required: true
                },
                'password_repeat': {
                    minlength: 8,
                    maxlength: 24,
                    alfanumerico: true,
                    required: true
                }
            },
            messages: {
                'password': {
                    alfanumerico: "La contraseña debe ser tener al menos un número y una letra",
                    minlength: "Por favor, ingrese al menos 8 caracteres",
                    maxlength: "Como máximo solo puede ingresar 24 caracteres"
                },
                'password_repeat': {
                    alfanumerico: "La contraseña debe ser tener al menos un número y una letra",
                    minlength: "Por favor, ingrese al menos 8 caracteres",
                    maxlength: "Como máximo solo puede ingresar 24 caracteres"
                }
            },
            highlight: function(element) {
                $(element).closest('.control-group').removeClass('success').addClass('error');
            },
            success: function(element) {
                element
                    .text('OK!').addClass('valid')
                    .closest('.control-group').removeClass('error').addClass('success');
            }
        });
    }

    function cambiar() {
        if ($('#formRegisterPassword').valid()) {
            if ($('#contraseniaNueva').val() != $('#contraseniaNuevaConfirm').val()) {
                var validator = $("#formRegisterPassword").validate();
                validator.showErrors({
                    "contraseniaNuevaConfirm": "La contraseña ingresada no es igual"
                });
            } else {
                bootbox.confirm("¿Está seguro de que desea cambiar contraseña de usuario?", function(result) {
                    if (result) {
                        $('#formRegisterPassword').submit();
                        //alert('lalala');
                    }
                });
            }
        }
    }
</script>
