<section id="RbacUsuariosEdit" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-aqua-active">
                    <h3 class="widget-user-username"><?php echo $rbacUsuario->nombre . " " . $rbacUsuario->apellido; ?></h3>

                </div>
                <div class="widget-user-image">
                    <img src="/img/user-profile.png" alt="User Avatar" class="img-circle">
                </div>
                <div class="box-footer">
                    <div class="row">

                        <form id="formEditMyUser" role="form" action="/editMyUser" method="POST">
                            <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getAttribute('csrfToken'); ?>">
                            <input type="hidden" name="id" value="<?php echo $rbacUsuario->id; ?>">

                            <div class="form-group col-sm-4">
                                <label id="lblUsuario" for="usuario">Usuario</label>
                                <input type="text" name="usuario" required value="<?php echo $rbacUsuario->usuario; ?>"
                                    oninvalid="this.setCustomValidity('Complete el usuario')" oninput="this.setCustomValidity('')" placeholder="Ingrese el usuario" class="form-control" maxlength="120" value="<?php echo (!$rbacUsuario->getError('usuario')) ? $this->request->getData('usuario') : ''; ?>">
                                <?php foreach ($rbacUsuario->getError('usuario') as $k => $v) { ?>
                                    <div class="form-group   label label-danger">
                                        <span class=" "> <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                            <?php echo $v; ?>
                                        </span>
                                    </div>
                                <?php  } ?>
                            </div>
                            <?php if (!empty($rbacUsuario->nombre)) { ?>
                                <div class="form-group col-sm-4">
                                    <label>Nombre</label>
                                    <input required type="text" value="<?php echo $rbacUsuario->nombre; ?>" placeholder="Ingrese el nombre" class="form-control" name="nombre" oninvalid="this.setCustomValidity('Debe completar el/los nombre/s')" oninput="this.setCustomValidity('')">
                                    <?php foreach ($rbacUsuario->getError('nombre') as $k => $v) { ?>
                                        <div class="form-group   label label-danger">
                                            <span class=" "> <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                                <?php echo $v; ?>
                                            </span>
                                        </div>
                                    <?php  } ?>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label >Apellido</label>
                                    <input required type="text" value="<?php echo $rbacUsuario->apellido; ?>" placeholder="Ingrese el apellido" class="form-control" name="apellido" oninvalid="this.setCustomValidity('Debe completar el/los apellido/s')" oninput="this.setCustomValidity('')">
                                    <?php foreach ($rbacUsuario->getError('apellido') as $k => $v) { ?>
                                        <div class="form-group   label label-danger">
                                            <span class=" "> <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                                <?php echo $v; ?>
                                            </span>
                                        </div>
                                    <?php  } ?>
                                </div>
                            <?php } else { ?>
                                <div class="form-group col-sm-8">
                                    <label >Razon Social</label>
                                    <input required type="text" value="<?php echo $rbacUsuario->razon_social; ?>" placeholder="Ingrese la razón social"
                                     class="form-control" name="apellido" oninvalid="this.setCustomValidity('Debe completar la razón social')" oninput="this.setCustomValidity('')">
                                    <?php foreach ($rbacUsuario->getError('razon_social') as $k => $v) { ?>
                                        <div class="form-group   label label-danger">
                                            <span class=" "> <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                                <?php echo $v; ?>
                                            </span>
                                        </div>
                                    <?php  } ?>
                                </div>
                            <?php } ?>
                            <div class="form-group col-sm-4">
                                <label id="lblUsuario">Email</label>
                                <input type="email" name="email" required value="<?php echo $rbacUsuario->email; ?>"
                                    oninvalid="this.setCustomValidity('Complete el usuario (mail)')" oninput="this.setCustomValidity('')"
                                    placeholder="Ingrese el email" class="form-control" maxlength="120"
                                    value="<?php echo (!$rbacUsuario->getError('email')) ? $this->request->getData('usuario') : ''; ?>">
                                <?php foreach ($rbacUsuario->getError('email') as $k => $v) { ?>
                                    <div class="form-group   label label-danger">
                                        <span class=" "> <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                            <?php echo $v; ?>
                                        </span>
                                    </div>
                                <?php  } ?>
                            </div>

                            <div class="form-group col-sm-2">
                                <label>Tipo de Documento</label><br>
                                <select required name="tipo_documento_id" class="form-control">
                                    <option value="">Seleccione</option>
                                    <?php foreach ($tipoDocumentos as $id => $tipoDocumento) : ?>
                                        <?php if ($rbacUsuario->tipo_documento_id == $id) { ?>
                                            <option selected value="<?php echo $id; ?>"><?php echo $tipoDocumento; ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $id; ?>"><?php echo $tipoDocumento; ?></option>
                                        <?php } ?>

                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group col-sm-2">
                                <label>Documento</label>
                                <input required type="text" placeholder="Número de Doc." maxlength="20"
                                    class="form-control" value="<?php echo $rbacUsuario->documento; ?>" name="documento"
                                    oninput="this.value = this.value.replace(/[^a-zA-Z0-9]/g, '');"
                                    onkeydown="if(event.key === '-' || event.key === ' ' || event.key === '+') event.preventDefault();">
                            </div>
                            <div class="form-group col-sm-4">
                                <label>Celular</label>
                                <input name="celular" required type="number" step="1"
                                    oninput="if(this.value.length > 12) this.value = this.value.slice(0, 12);" class="form-control"
                                    placeholder="Celular"
                                    value="<?php echo $rbacUsuario->celular; ?>"
                                    min="1" max="999999999999" onkeydown="preventInvalidInput(event)"
                                    oninput="if(this.value.length > 5) this.value = this.value.slice(0, 5);">
                            </div>

                            <div class="form-group col-sm-3">
                                <label>Provincia</label><br>
                                <select id="provincia_id" required name="direccion[localidade][provincia][id]" class="form-control">
                                    <option selected value="">Seleccione una provincia</option>
                                    <?php foreach ($provincias as $id => $provincia) { ?>
                                        <?php if ($rbacUsuario->direccion->localidade['provincia']['id'] == $id) { ?>
                                            <option selected value="<?php echo $id ?>"><?php echo $provincia; ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $id ?>"><?php echo $provincia; ?></option>
                                        <?php } ?>

                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-sm-3">
                                <label>Localidad</label><br>
                                <select required id="localidad_id" name="direccion[localidad_id]" class="form-control">
                                    <option selected value="">Seleccione una localidad</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-2">
                                <label>Calle</label>
                                <input name="direccion[calle]" required
                                    value="<?php echo isset($rbacUsuario->direccion->calle) ? $rbacUsuario->direccion->calle : ''; ?>" type="text" class="form-control"
                                    oninput="this.value = this.value.replace(/[^a-zA-Z0-9' ]/g, '');"
                                    placeholder="Calle" maxlength="100">
                            </div>

                            <div class="form-group col-sm-2">
                                <label>Número</label>
                                <input name="direccion[numero]"
                                    value="<?php echo isset($rbacUsuario->direccion->numero) ? $rbacUsuario->direccion->numero : ''; ?>"
                                    type="number" class="form-control" placeholder="Número" min="1" max="9999" onkeydown="preventInvalidInput(event)"
                                    oninput="if(this.value.length > 5) this.value = this.value.slice(0, 5);">
                            </div>
                            <div class="form-group col-sm-1">
                                <label>Piso</label>
                                <input name="direccion[piso]" type="text" class="form-control"
                                    value="<?php echo isset($rbacUsuario->direccion->piso) ? $rbacUsuario->direccion->piso : ''; ?>" placeholder="Piso" maxlength="3">
                            </div>
                            <div class="form-group col-sm-1">
                                <label>Depto</label>
                                <input name="direccion[departamento]" type="text" class="form-control"
                                    value="<?php echo isset($rbacUsuario->direccion->departamento) ? $rbacUsuario->direccion->departamento : ''; ?>" placeholder="Depto" maxlength="10">
                            </div>



                            <div class="form-group col-sm-12 text-center">

                                <button type="submit" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-check"></span>
                                    Guardar</button>
                            </div>
                        </form>
                    </div>
                    <div class="form-row  col-sm-12 callout callout-info" role="alert">
                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                        Si modifica el email, deberá confirmarlo desde su bandeja de entrada. Hasta que no lo haga, se seguirá mostrando el email anterior.
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>


<script>
    document.addEventListener('DOMContentLoaded', function() {

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

        document.getElementById('provincia_id').dispatchEvent(new Event('change'));

        setTimeout(function() {

            var localidadId = "<?php echo $rbacUsuario->direccion->localidad_id ?? ''; ?>";
            if (localidadId) {
                document.getElementById('localidad_id').value = localidadId;
            }
        }, 1000); // Ajusta el tiempo según sea necesario



    });

    function preventInvalidInput(event) {
        const invalidChars = ['e', 'E', '+', '-']; // caracteres que quieres restringir
        if (invalidChars.includes(event.key)) {
            event.preventDefault();
        }
    }
</script>
