<?php $this->layout = 'AdminLTE.change_password'; ?>
<?php

use Cake\Core\Configure; ?>




<form class="form-signin well" id="RbacPerfilesChangePass" name="RbacPerfilesChangePass" role="form" action="/rbac/rbac_usuarios/recuperarPass/<?php echo $token; ?>/" method="POST">
    <div class="register-logo">
        <a href="<?php echo $this->Url->build(); ?>"><?php echo Configure::read('Theme.logo.large') ?></a>
    </div>
    <div class="form-group has-feedback">
        <input type="password" name="contraseniaNueva" id="contraseniaNueva" placeholder="Nueva contraseña" class="form-control">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
    </div>
    <!-- <div class="form-group">
        <label for="nombre" class="col-sm-5 control-label">Nueva contraseña</label>
        <div class="col-sm-7">
            <input type="password" name="contraseniaNueva" id="contraseniaNueva" placeholder="Nueva contraseña" class="form-control">
        </div>
    </div> -->
    <div class="form-group">
        <label for="apellido" class="col-sm-5 control-label">Repita nueva contraseña</label>
        <div class="col-sm-7">
            <input type="password" name="contraseniaNuevaConfirm" id="contraseniaNuevaConfirm" placeholder="Repita nueva contraseña" class="form-control">
        </div>
    </div>
    <div class="row">
        <!-- /.col -->
        <div class="col-xs-12">
            <button id="submitButton" type="button" onclick="cambiar()" class="btn btn-lg btn-primary btn-block "><i class="fa fa-lg fa-edit"></i> Guardar</button>
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

        $('#RbacPerfilesChangePass').validate({
            rules: {
                'contraseniaActual': {
                    required: true
                },
                'contraseniaNueva': {
                    minlength: 8,
                    maxlength: 24,
                    alfanumerico: true,
                    required: true
                },
                'contraseniaNuevaConfirm': {
                    minlength: 8,
                    maxlength: 24,
                    alfanumerico: true,
                    required: true
                }
            },
            messages: {
                'contraseniaNueva': {
                    alfanumerico: "La contraseña debe ser tener al menos un número y una letra",
                    minlength: "Por favor, ingrese al menos 8 caracteres",
                    maxlength: "Como máximo solo puede ingresar 24 caracteres"
                },
                'contraseniaNuevaConfirm': {
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
        if ($('#RbacPerfilesChangePass').valid()) {
            if ($('#contraseniaNueva').val() != $('#contraseniaNuevaConfirm').val()) {
                var validator = $("#RbacPerfilesChangePass").validate();
                validator.showErrors({
                    "contraseniaNuevaConfirm": "La contraseña ingresada no es igual"
                });
            } else {
                bootbox.confirm("¿Está seguro de que desea cambiar contraseña de usuario?", function(result) {
                    if (result) {
                        $('#RbacPerfilesChangePass').submit();
                        //alert('lalala');
                    }
                });
            }
        }
    }
</script>
