<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\RbacUsuarios> $rbacUsuario
 */

use Cake\Core\Configure;
?>
<section class="content-header">
    <h1>
        <?php echo Configure::read('Menu.GestionPermisos') ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-users"></i> Usuarios</a></li> <i class="fa fa-arrow-right"></i>
        <li class="active">Agregar</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header  with-border">
                    <h3 class="box-title"> <span class="fa fa-user-plus fa-lg"></span> Nuevo Usuario</h3>
                    <div class="box-tools pull-right">
                        <a href="/rbac/rbacUsuarios/index/" id="agregarUsuario" class="btn btn-sm btn-primary ">
                            <span class="fa fa-users"></span> Usuarios</a>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-row">
                        <form id="RbacUsuariosAddForm" name="RbacUsuariosAddForm" role="form" action="/rbac/rbacUsuarios/add/" method="POST">
                            <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getAttribute('csrfToken'); ?>">

                            <div class="form-group col-sm-4">
                                <label id="lblUsuario" for="usuario">Usuario (mail)</label>
                                <input type="email" name="usuario" required id="RbacUsuarioUsuario"
                                    oninvalid="this.setCustomValidity('Complete el usuario (mail)')" oninput="this.setCustomValidity('')"
                                    placeholder="Ingrese el usuario" class="form-control" maxlength="120" value="<?php echo $this->request->getData('usuario'); ?>">
                            </div>

                            <div class="form-group col-sm-4">
                                <label for="nombre">Nombre</label>
                                <input required type="text" placeholder="Ingrese el/los nombre/s" class="form-control" name="nombre" value="<?php echo $this->request->getData('nombre'); ?>" oninvalid="this.setCustomValidity('Debe completar el/los nombre/s')" oninput="this.setCustomValidity('')">
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="apellido">Apellido</label>
                                <input required type="text" placeholder="Ingrese el/los apellido/s" class="form-control" name="apellido" value="<?php echo $this->request->getData('apellido'); ?>" oninvalid="this.setCustomValidity('Debe completar el/los apellido/s')" oninput="this.setCustomValidity('')">
                            </div>

                            <div class="form-group col-sm-2">
                                <label>Tipo de Documento</label><br>
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
                            <div class="form-group col-sm-2">
                                <label for="documento">Documento</label>
                                <input required type="text" placeholder="Número de Doc." maxlength="11" class="form-control"
                                    value="<?php echo $this->request->getData('documento'); ?>" name="documento" id="documento"
                                    oninput="validateDocumentInput()">
                            </div>
                            <div class="form-group col-sm-4">
                                <label>Provincia</label><br>
                                <select id="provincia_id" required name="provincia_id" class="form-control">
                                    <option selected value="">Seleccione una provincia</option>
                                    <?php foreach ($provincias as $id => $provincia) { ?>
                                        <?php if ($this->request->getData('provincia_id') == $id) { ?>
                                            <option selected value="<?php echo $id ?>"><?php echo $provincia; ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $id ?>"><?php echo $provincia; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-sm-4">
                                <label>Localidad</label><br>
                                <select required id="localidad_id" name="direcciones[][localidad_id]" class="form-control">
                                    <option selected value="">Seleccione una localidad</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-2">
                                <label for="direccion">Calle</label>
                                <input name="direcciones[0][calle]" required
                                    value="<?php echo !empty($this->request->getData('direcciones')[0]['calle']) ? $this->request->getData('direcciones')[0]['calle'] : ''; ?>"
                                    type="text" class="form-control"
                                    oninput="this.value = this.value.replace(/[^a-zA-Z0-9' ]/g, '');"
                                    placeholder="Calle" maxlength="100" min="1">
                            </div>

                            <div class="form-group col-sm-2">
                                <label for="direccion">Número</label>
                                <input name="direcciones[0][numero]" required value="<?php echo !empty($this->request->getData('direcciones')[0]['numero']) ? $this->request->getData('direcciones')[0]['numero'] : ''; ?>" type="number" class="form-control" placeholder="Número" maxlength="4" min="1">
                            </div>

                            <div class="form-group col-sm-2">
                                <label for="direccion">Piso</label>
                                <input name="direcciones[0][piso]" value="<?php echo !empty($this->request->getData('direcciones')[0]['piso']) ? $this->request->getData('direcciones')[0]['piso'] : ''; ?>" type="text" class="form-control" placeholder="Piso" maxlength="3">
                            </div>

                            <div class="form-group col-sm-2">
                                <label for="direccion">Depto</label>
                                <input name="direcciones[0][departamento]" value="<?php echo !empty($this->request->getData('direcciones')[0]['departamento']) ? $this->request->getData('direcciones')[0]['departamento'] : ''; ?>" type="text" class="form-control" placeholder="Depto" maxlength="10">
                            </div>



                            <div class="form-group col-sm-4">
                                <label>Perfil</label><br>
                                <select required name="perfil_id" class="form-control">
                                    <option value="">Seleccione un perfil</option>
                                    <?php foreach ($rbacPerfiles as $id => $perfil) : ?>
                                        <?php if ($this->request->getData('perfil_id') == $id) { ?>
                                            <option selected value="<?php echo $id; ?>"><?php echo $perfil; ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $id; ?>"><?php echo $perfil; ?></option>
                                        <?php } ?>

                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <?php
                            if ($this->request->getSession()->check('previousUrl')) {
                                $url = $this->request->getSession()->read('previousUrl');
                                if (strpos($url, "Usuarios") !== false or strpos($url, "usuarios") !== false) {
                                    $url = $this->request->getSession()->read('previousUrl');
                                } else {
                                    $url = "/rbac/rbacUsuarios/index/";
                                }
                            } else {
                                $url = '/rbac/rbacUsuarios/index';
                            }
                            ?>
                            <div class="form-group col-sm-12 text-center">
                                <a href="<?php echo $url; ?>" class="btn btn-danger">
                                    <span class="glyphicon glyphicon-remove"></span> Cancelar</a>
                                <button type="submit" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-check"></span>
                                    Guardar</button>
                            </div>
                            <div class="form-group col-sm-12">
                                <div class="callout callout-info">
                                    <p><i class="icon fa fa-info"></i> El usuario recibirá un mail a su correo con un link donde deberá ingresar una contraseña para poder completar el alta del mismo.

                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Llama a la función también cuando se cambie el tipo de documento
        document.getElementById('tipo_documento_id').addEventListener('change', function() {
            validateDocumentInput();
        });

        const provinciaSelect = document.getElementById('provincia_id');
        const localidadSelect = document.getElementById('localidad_id');

        provinciaSelect.addEventListener('change', function() {
            const provinciaId = this.value;


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
            var localidadId = "<?php echo $this->request->getData('direcciones')[0]['localidad_id'] ?? ''; ?>";
            if (localidadId) {
                document.getElementById('localidad_id').value = localidadId;
            }
        }, 1000); // Ajusta el tiempo según sea necesario



    });

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
</script>
