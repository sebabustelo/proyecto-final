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
<?php $this->layout = 'AdminLTE.register'; ?>
<?php

use Cake\Core\Configure; ?>
<form id="formRegister" class="form-signin well" role="form" action="/register" method="POST">
    <div class="register-logo">
        <a href="<?php echo $this->Url->build(); ?>"><?php echo Configure::read('Theme.logo.large') ?></a>
    </div>
    <div class="form-group has-feedback">
        <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getAttribute('csrfToken'); ?>">
        <input name="usuario" id="usuario" maxlength="20" required type="text" class="form-control" placeholder="Nombre de usuario"
            value="<?php echo $this->request->getData('usuario'); ?>">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
        <input name="email" maxlength="50" required type="email" class="form-control" placeholder="Correo electrónico" value="<?php echo $this->request->getData('email'); ?>">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
    </div>
    <!-- Select para elegir entre Particular y Obra Social -->
    <div class="form-group has-feedback">
        <select id="tipoCliente" class="form-control">
            <option value="particular">Particular</option>
            <option value="obra_social">Obra Social</option>
        </select>
    </div>
    <!-- Campos para Particular -->
    <div id="particularFields">
        <div class="form-group has-feedback">
            <input name="nombre" maxlength="50" type="text" class="form-control" placeholder="Nombre" value="<?php echo $this->request->getData('nombre'); ?>">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input name="apellido" maxlength="50" required type="text" class="form-control" placeholder="Apellido" value="<?php echo $this->request->getData('apellido'); ?>">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
    </div>

    <!-- Campos para Obra Social -->
    <div id="obraSocialFields" style="display: none;">
        <div class="form-group has-feedback">
            <input name="razon_social" maxlength="100" type="text" class="form-control" placeholder="Razón Social">
            <span class="glyphicon glyphicon-briefcase form-control-feedback"></span>
        </div>
        <span id="mensaje-error" style="display: none;" class="badge bg-red"><i class="fa fa-warning"></i> El CUIT es inválido</span>
    </div>

    <div class="form-group has-feedback">
        <div class="row">
            <div class="col-xs-6">
                <select required name="tipo_documento_id" id="tipo_documento_id" class="form-control">
                    <option value="">Tipo de Doc.</option>
                    <?php foreach ($tipoDocumentos as $id => $tipoDocumento) : ?>
                        <?php if ($this->request->getData('tipo_documento_id') == $id) { ?>
                            <option selected value="<?php echo $id; ?>"><?php echo $tipoDocumento; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $id; ?>"><?php echo $tipoDocumento; ?></option>
                        <?php } ?>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-xs-6">
                <input required type="text" placeholder="Número de Doc." maxlength="11" class="form-control"
                    value="<?php echo $this->request->getData('documento'); ?>" name="documento" id="documento"
                    oninput="validateDocumentInput()">
                <span class="glyphicon fa fa-lg fa-credit-card form-control-feedback" style="margin-right: 14px;"></span>
            </div>
        </div>
    </div>
    <div class="form-group has-feedback">
        <select id="provincia_id" required name="provincia_id" class="form-control">
            <option selected value="">Seleccione una provincia</option>
            <?php foreach ($provincias as $id => $provincia) { ?>
                <?php if ($this->request->getData('provincia_id') == $id) { ?>
                    <option selected value="<?php echo $id; ?>"><?php echo $provincia; ?></option>
                <?php } else { ?>
                    <option value="<?php echo $id; ?>"><?php echo $provincia; ?></option>
                <?php } ?>

            <?php } ?>
        </select>


    </div>
    <div class="form-group has-feedback">
        <select required id="localidad_id" name="direcciones[0][localidad_id]" class="form-control">
            <option selected value="">Seleccione una localidad</option>
        </select>
    </div>
    <div class="form-group has-feedback">
        <input name="direcciones[0][calle]" required type="text" maxlength="50"
            value="<?php echo !empty($this->request->getData('direcciones')[0]['calle']) ? $this->request->getData('direcciones')[0]['calle'] : ''; ?>"
            class="form-control" placeholder="Calle" oninput="this.value = this.value.replace(/[^a-zA-Z0-9' ]/g, '');">
        <span class="glyphicon fa fa-lg fa-road form-control-feedback"></span>
    </div>

    <div class="form-group has-feedback">
        <div class="row">
            <div class="col-xs-4">
                <input name="direcciones[0][numero]" required
                    value="<?php echo !empty($this->request->getData('direcciones')[0]['numero']) ? $this->request->getData('direcciones')[0]['numero'] : ''; ?>"
                    type="number" class="form-control" placeholder="Número" min="1" max="9999" onkeydown="preventInvalidInput(event)"
                    oninput="if(this.value.length > 5) this.value = this.value.slice(0, 5);">
            </div>
            <div class="col-xs-4">
                <input name="direcciones[0][piso]" type="text" class="form-control" placeholder="Piso" maxlength="3"
                    value="<?php echo !empty($this->request->getData('direcciones')[0]['piso']) ? $this->request->getData('direcciones')[0]['piso'] : ''; ?>">
            </div>
            <div class="col-xs-4">
                <input name="direcciones[0][departamento]" type="text" class="form-control" placeholder="Depto" maxlength="3"
                    value="<?php echo !empty($this->request->getData('direcciones')[0]['departamento']) ? $this->request->getData('direcciones')[0]['departamento'] : ''; ?>">
            </div>
        </div>
    </div>

    <div class="form-group has-feedback">
        <input name="celular" required type="number" step="1" max="999999999999" oninput="if(this.value.length > 12) this.value = this.value.slice(0, 12);"
            value="<?php echo $this->request->getData('celular'); ?>" class="form-control" placeholder="Celular" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
        <span class="glyphicon fa fa-lg fa-mobile-phone form-control-feedback"></span>
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
<!-- Otros contenidos del formulario -->
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Llama a la función también cuando se cambie el tipo de documento
        document.getElementById('tipo_documento_id').addEventListener('change', function() {
            validateDocumentInput();
        });

        //Verificar si el usuario existe en la db
        const usernameInput = document.querySelector('input[name="usuario"]');

        usernameInput.addEventListener('blur', function() {
            const username = this.value;

            // Solo hacer la petición si el campo no está vacío
            if (username) {
                fetch('/rbac/RbacUsuarios/checkUsername/' + encodeURIComponent(username))
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {

                        if (data) {
                            alert('El nombre de usuario ya existe. Por favor, elige otro.');
                            usernameInput.value = ''; // Limpia el campo
                            usernameInput.focus(); // Regresa el enfoque al campo
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        });

        var provinciaSelect = document.getElementById('provincia_id');
        var localidadSelect = document.getElementById('localidad_id');

        provinciaSelect.addEventListener('change', function() {
            var provinciaId = this.value;


            if (provinciaId) {

                fetch('/localidades/localidades/' + provinciaId)

                    .then(response => response.json())
                    .then(data => {
                        localidadSelect.innerHTML = '<option selected value="">Seleccione una localidad</option>';

                        data.forEach(function(localidad) {

                            localidadSelect.innerHTML += '<option value="' + localidad.id + '">' + localidad.nombre + '</option>';
                        });
                    })
                    .catch(error => console.error('Error al cargar localidades:', error));
            } else {
                localidadSelect.innerHTML = '<option selected value="">Seleccione una localidad</option>';
            }
        });



        <?php if (!empty($this->request->getData('nombre'))) { ?>
            particularFields.style.display = 'block';
            obraSocialFields.style.display = 'none';
        <?php } else { ?>
            particularFields.style.display = 'none';
            obraSocialFields.style.display = 'block';
        <?php } ?>



        const tipoClienteSelect = document.getElementById('tipoCliente');
        tipoClienteSelect.addEventListener('change', function() {
            var tipoCliente = this.value;


            let particularFields = document.getElementById('particularFields');
            let obraSocialFields = document.getElementById('obraSocialFields');
            let nombreInput = document.querySelector('[name="nombre"]');
            let apellidoInput = document.querySelector('[name="apellido"]');
            let razonSocialInput = document.querySelector('[name="razon_social"]');


            if (tipoCliente === 'particular') {

                particularFields.style.display = 'block';
                obraSocialFields.style.display = 'none';
                nombreInput.setAttribute('required', 'required');
                apellidoInput.setAttribute('required', 'required');
                razonSocialInput.removeAttribute('required');

                razonSocialInput.value = '';

            } else if (tipoCliente === 'obra_social') {

                particularFields.style.display = 'none';
                obraSocialFields.style.display = 'block';
                razonSocialInput.setAttribute('required', 'required');
                nombreInput.removeAttribute('required');
                apellidoInput.removeAttribute('required');

                nombreInput.value = '';
                apellidoInput.value = '';
            }

        });

        // Inicializar los campos correctamente al cargar la página
        tipoClienteSelect.dispatchEvent(new Event('change'));

        //terminosCondiciones();


    });

    // document.getElementById('formRegister').addEventListener('submit', function(event) {
    //     const cuit = document.getElementById('cuit').value;
    //     const mensajeError = document.getElementById('mensaje-error');
    //     let tipoClienteSelect = document.getElementById('tipoCliente');
    //     let particularFields = document.getElementById('particularFields');
    //     let obraSocialFields = document.getElementById('obraSocialFields');

    //     if (tipoCliente === 'particular') {
    //         mensajeError.style.display = 'none';
    //     } else if (tipoCliente === 'obra_social') {
    //         if (!validarCuit(cuit)) {
    //             mensajeError.style.display = 'block';
    //             event.preventDefault(); // Prevenir el envío del formulario si el CUIT es inválido
    //         } else {
    //             mensajeError.style.display = 'none'; // Si el CUIT es válido, ocultar el mensaje
    //         }
    //     }

    // });

    function validateDocumentInput() {
        var tipoDocumento = document.getElementById('tipo_documento_id').value;
        var documentoInput = document.getElementById('documento');

        if (tipoDocumento === '3') { // Cambia 'PASAPORTE_ID' por el ID correspondiente al pasaporte
            // Permitir letras y números
            documentoInput.value = documentoInput.value.replace(/[^a-zA-Z0-9]/g, '');
        } else {
            // Permitir solo números
            documentoInput.value = documentoInput.value.replace(/\D/g, '');
        }
    }

    function terminosCondiciones() {
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
    }

    function validarCuit(cuit) {
        // Eliminar cualquier guión, espacio o carácter no numérico
        cuit = cuit.replace(/[^0-9]/g, '');

        // Verificar que tenga 11 dígitos
        if (cuit.length !== 11) {
            return false;
        }

        // Multiplicadores para los primeros 10 dígitos
        const multiplicadores = [5, 4, 3, 2, 7, 6, 5, 4, 3, 2];

        // Calcular el dígito verificador
        let suma = 0;
        for (let i = 0; i < 10; i++) {
            suma += parseInt(cuit[i]) * multiplicadores[i];
        }

        let verificador = (11 - (suma % 11)) % 11;

        // Comparar con el dígito verificador (último dígito del CUIT)
        return verificador === parseInt(cuit[10]);
    }

    function preventInvalidInput(event) {
        const invalidChars = ['e', 'E', '+', '-']; // caracteres que quieres restringir
        if (invalidChars.includes(event.key)) {
            event.preventDefault();
        }
    }

    document.getElementById('provincia_id').dispatchEvent(new Event('change'));

    setTimeout(function() {

        var localidadId = "<?php echo $this->request->getData('direcciones')[0]['localidad_id'] ?? ''; ?>";
        if (localidadId) {
            document.getElementById('localidad_id').value = localidadId;
        }
    }, 1000); // Ajusta el tiempo según sea necesario
</script>
