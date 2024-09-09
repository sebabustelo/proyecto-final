<style>
    #termsMessage {
        display: none;
        margin-top: 10px;
        margin-bottom: 10px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        background-color: #f9f9f9;
    }

    /* Para Chrome, Safari, Edge, y Opera */
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Para Firefox */
    input[type="number"] {
        -moz-appearance: textfield;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var acceptTermsCheckbox = document.getElementById('acceptTerms');
        var termsMessage = document.getElementById('termsMessage');
        var submitButton = document.getElementById('submitButton');

        if (acceptTermsCheckbox && termsMessage && submitButton) {
            function toggleTermsMessage() {
                if (acceptTermsCheckbox.checked) {
                    termsMessage.style.display = 'block';
                    submitButton.disabled = false; // Habilitar el botón
                } else {
                    termsMessage.style.display = 'none';
                    submitButton.disabled = true; // Deshabilitar el botón
                }
            }
            // Añadir el manejador de eventos
            acceptTermsCheckbox.addEventListener('change', toggleTermsMessage);
            // Inicializar el estado del botón al cargar la página
            toggleTermsMessage();
        } else {
            console.error('Uno o más elementos no se encuentran en el DOM.');
        }
    });
</script>
<?php $this->layout = 'AdminLTE.register'; ?>
<?php

use Cake\Core\Configure; ?>
<form id="formLogin" class="form-signin well" role="form" action="/register" method="POST">
    <div class="register-logo">
        <a href="<?php echo $this->Url->build(); ?>"><?php echo Configure::read('Theme.logo.large') ?></a>
    </div>
    <div class="form-group has-feedback">
        <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getAttribute('csrfToken'); ?>">
        <input name="usuario" required type="email" class="form-control" placeholder="Correo electrónico">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
        <input name="nombre" required type="text" class="form-control" placeholder="Nombre">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
        <input name="apellido" required type="text" class="form-control" placeholder="Apellido">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
        <div class="row">

            <div class="col-xs-6">
                <select required name="tipo_documento_id" class="form-control">
                    <option value="">Seleccione un tipo de documento</option>
                    <?php foreach ($tipoDocumentos as $id => $tipoDocumento) : ?>
                        <option value="<?php echo $id; ?>"><?php echo $tipoDocumento; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-xs-6">
                <input name="documento" required type="number" step="1" min="8" class="form-control" placeholder="Documento" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                <span class="glyphicon fa fa-lg fa-credit-card form-control-feedback" style="margin-right: 14px;"></span>
            </div>
        </div>
    </div>
    <div class="form-group has-feedback">
        <input name="direccion" required type="text" class="form-control" placeholder="Dirección">
        <span class="glyphicon fa fa-lg fa-home form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
        <input name="celular" required type="number" step="1" min="8" class="form-control" placeholder="Celular" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
        <span class="glyphicon fa fa-lg fa-mobile-phone form-control-feedback"></span>
    </div>


    <div class="row">
        <div class="col-xs-12">
            <div class="checkbox ">
                <label>
                    <input id="acceptTerms" type="checkbox">&nbsp; Acepto los terminos
                </label>
            </div>
            <div id="termsMessage">
                <p>1 - De acuerdo con la Ley N° 25.326, el titular podrá en cualquier momento solicitar el retiro o bloqueo de su nombre de los bancos de datos a los que se refiere. El titular de los datos personales tiene la facultad de ejercer el derecho de acceso a los mismos en forma gratuita a intervalos no inferiores a seis meses, salvo que se acredite un interés legítimo al efecto conforme lo establecido en el artículo 14, inciso 3 de la Ley N° 25.326.</p>
                <p>2 - La DIRECCIÓN NACIONAL DE PROTECCIÓN DE DATOS PERSONALES, Órgano de Control de la Ley 25.326, tiene la atribución de atender las denuncias y reclamos que se interpongan con relación al incumplimiento de las normas sobre protección de datos personales.</p>
            </div>
        </div>
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
    <div class="row">
        <!-- /.col -->
        <div class="col-xs-12">
            <button id="submitButton" type="submit" class="btn btn-lg btn-primary btn-block "><i class="fa fa-lg fa-edit"></i> Registrarse</button>
        </div>
        <!-- /.col -->
    </div>

</form>
<br>
<div class="row">
    <div class="col-xs-12">
        <?= $this->Flash->render() ?>
    </div>
</div>
