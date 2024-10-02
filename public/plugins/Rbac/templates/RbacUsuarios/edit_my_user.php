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

                        <?= $this->Form->create($rbacUsuario) ?>
                        <div class="form-group col-sm-4">
                            <label>Nombre</label>
                            <?= $this->Form->input('nombre', ['class' => 'form-control', 'label' => false]) ?>
                        </div>

                        <div class="form-group col-sm-4">
                            <label>Apellido</label>
                            <?= $this->Form->input('apellido', ['class' => 'form-control', 'label' => false]) ?>
                        </div>

                        <div class="form-group col-sm-4">
                            <label>Usuario</label>
                            <?= $this->Form->input('usuario', ['class' => 'form-control', 'label' => false]) ?>
                        </div>

                        <div class="form-group col-sm-4">
                            <label>Email</label>
                            <?= $this->Form->input('email', ['class' => 'form-control', 'label' => false]) ?>
                        </div>

                        <div class="form-group col-sm-2">
                            <label>Tipo de Documento</label>
                            <?= $this->Form->control('tipo_documento_id', ['options' => $tipoDocumentos, 'class' => 'form-control', 'label' => false]) ?>
                        </div>

                        <div class="form-group col-sm-2">
                            <label>Documento</label>
                            <?= $this->Form->input('documento', ['class' => 'form-control', 'label' => false]) ?>
                        </div>

                        <div class="form-group col-sm-4">
                            <label>Teléfono</label>
                            <?= $this->Form->input('telefono', ['class' => 'form-control', 'label' => false]) ?>
                        </div>

                        <div class="form-group col-sm-3">
                            <label>Provincia</label><br>
                            <select id="provincia_id" required name="direcciones[0][localidade][provincia][id]" class="form-control">
                                <option selected value="">Seleccione una provincia</option>
                                <?php foreach ($provincias as $id => $provincia) { ?>
                                    <?php if ($rbacUsuario->direcciones[0]->localidade['provincia']['id'] == $id) { ?>
                                        <option selected value="<?php echo $id ?>"><?php echo $provincia; ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $id ?>"><?php echo $provincia; ?></option>
                                    <?php } ?>

                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-sm-3">
                            <label>Localidad</label><br>
                            <select required id="localidad_id" name="direcciones[0][localidad_id]" class="form-control">
                                <option selected value="">Seleccione una localidad</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-2">
                            <label>Calle</label>
                            <input name="direcciones[0][calle]" required
                                value="<?php echo isset($rbacUsuario->direcciones[0]->calle) ? $rbacUsuario->direcciones[0]->calle : ''; ?>" type="text" class="form-control"
                                oninput="this.value = this.value.replace(/[^a-zA-Z0-9' ]/g, '');"
                                placeholder="Calle" maxlength="100">
                        </div>

                        <div class="form-group col-sm-2">
                            <label>Número</label>
                            <input name="direcciones[0][numero]" required type="number" min="1" class="form-control"
                                value="<?php echo isset($rbacUsuario->direcciones[0]->numero) ? $rbacUsuario->direcciones[0]->numero : ''; ?>" placeholder="Número" maxlength="4">
                        </div>
                        <div class="form-group col-sm-1">
                            <label>Piso</label>
                            <input name="direcciones[0][piso]" type="text" class="form-control"
                                value="<?php echo isset($rbacUsuario->direcciones[0]->piso) ? $rbacUsuario->direcciones[0]->piso : ''; ?>" placeholder="Piso" maxlength="3">
                        </div>
                        <div class="form-group col-sm-1">
                            <label>Depto</label>
                            <input name="direcciones[0][departamento]" type="text" class="form-control"
                                value="<?php echo isset($rbacUsuario->direcciones[0]->departamento) ? $rbacUsuario->direcciones[0]->departamento : ''; ?>" placeholder="Depto" maxlength="10">
                        </div>



                        <div class="form-row form-group col-sm-12 callout callout-info" role="alert">
                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                            Si modifica el email, deberá confirmarlo desde su bandeja de entrada. Hasta que no lo haga, se seguirá mostrando el email anterior.
                        </div>


                        <div class="form-group text-center">
                            <a href="<?= $this->Url->build(['action' => 'view', $rbacUsuario->id]) ?>" class="btn btn-default">Cancelar</a>
                            <?= $this->Form->button(__('Guardar'), ['class' => 'btn btn-primary']) ?>

                        </div>
                        <?= $this->Form->end() ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
    document.addEventListener('DOMContentLoaded', function() {
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

            var localidadId = "<?php echo $rbacUsuario->direcciones[0]->localidad_id ?? ''; ?>";
            if (localidadId) {
                document.getElementById('localidad_id').value = localidadId;
            }
        }, 1000); // Ajusta el tiempo según sea necesario



    });
</script>

