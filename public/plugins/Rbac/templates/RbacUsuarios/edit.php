<?php

/**
 * @var \App\View\AppView $this
 * @var \Rbac\Model\Entity\RbacUsuarios $rbacUsuario
 */

use Cake\Core\Configure;
?>
<section class="content-header">
    <h1>
        <?php echo Configure::read('Menu.GestionPermisos') ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-users"></i> Usuarios</a></li> <i class="fa fa-arrow-right"></i>
        <li class="active">Editar</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header  with-border">
                    <h3 class="box-title"> <i class="fa fa-user fa-lg"></i> Editar Usuario</h3>
                    <div class="box-tools pull-right">
                        <a href="/rbac/rbacUsuarios/index/" id="agregarUsuario" class="btn btn-sm btn-primary ">
                            <i class="fa fa-users"></i> Usuarios</a>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-row">
                        <form id="RbacUsuariosAddForm" name="RbacUsuariosAddForm" role="form" action="/rbac/rbacUsuarios/edit/<?php echo $rbacUsuario->id; ?>" method="POST">
                            <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getAttribute('csrfToken'); ?>">
                            <div class="form-group col-sm-4">
                                <label id="lblUsuario" for="usuario">Usuario (mail)</label>
                                <input type="email" name="usuario" required value="<?php echo $rbacUsuario->usuario; ?>" oninvalid="this.setCustomValidity('Complete el usuario (mail)')" oninput="this.setCustomValidity('')" placeholder="Ingrese el usuario" class="form-control" maxlength="120" value="<?php echo (!$rbacUsuario->getError('usuario')) ? $this->request->getData('usuario') : ''; ?>">
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
                                    <label for="nombre">Nombre</label>
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
                                    <label for="apellido">Apellido</label>
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
                                    <label>Razon Social</label>
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
                                <label for="documento">Documento</label>
                                <input required type="text" placeholder="Número de Doc." maxlength="20"
                                    class="form-control" value="<?php echo $rbacUsuario->documento; ?>" name="documento"
                                    oninput="this.value = this.value.replace(/[^a-zA-Z0-9]/g, '');"
                                    onkeydown="if(event.key === '-' || event.key === ' ' || event.key === '+') event.preventDefault();">
                            </div>
                            <?php //debug($rbacUsuario->direcciones[0] )
                            ?>
                            <div class="form-group col-sm-4">
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
                            <div class="form-group col-sm-4">
                                <label>Localidad</label><br>
                                <select required id="localidad_id" name="direcciones[0][localidad_id]" class="form-control">
                                    <option selected value="">Seleccione una localidad</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-2">
                                <label for="direccion">Calle</label>
                                <input name="direcciones[0][calle]" required
                                    value="<?php echo isset($rbacUsuario->direcciones[0]->calle) ? $rbacUsuario->direcciones[0]->calle : ''; ?>" type="text" class="form-control"
                                    oninput="this.value = this.value.replace(/[^a-zA-Z0-9' ]/g, '');"
                                    placeholder="Calle" maxlength="100">
                            </div>

                            <div class="form-group col-sm-2">
                                <label for="direccion">Número</label>
                                <input name="direcciones[0][numero]" required type="number" min="1" class="form-control"
                                    value="<?php echo isset($rbacUsuario->direcciones[0]->numero) ? $rbacUsuario->direcciones[0]->numero : ''; ?>" placeholder="Número" maxlength="4">
                            </div>
                            <div class="form-group col-sm-2">
                                <label for="direccion">Piso</label>
                                <input name="direcciones[0][piso]" type="text" class="form-control"
                                    value="<?php echo isset($rbacUsuario->direcciones[0]->piso) ? $rbacUsuario->direcciones[0]->piso : ''; ?>" placeholder="Piso" maxlength="3">
                            </div>
                            <div class="form-group col-sm-2">
                                <label for="direccion">Depto</label>
                                <input name="direcciones[0][departamento]" type="text" class="form-control"
                                    value="<?php echo isset($rbacUsuario->direcciones[0]->departamento) ? $rbacUsuario->direcciones[0]->departamento : ''; ?>" placeholder="Depto" maxlength="10">
                            </div>

                            <div class="form-group col-sm-2">
                                <label for="rbac-perfiles-ids">Perfil</label><br>
                                <select required id="rbac-perfiles-ids" name="rbac_perfiles[_ids][]" class="form-control">
                                    <?php foreach ($rbacPerfiles as $id => $perfil) : ?>
                                        <?php if ($rbacUsuario->perfil_id == $id) { ?>
                                            <option selected value="<?php echo $id; ?>"><?php echo $perfil; ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $id; ?>"><?php echo $perfil; ?></option>
                                        <?php } ?>

                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group   col-sm-2">
                                <label for="">&nbsp;</label><br>
                                <label class="btn btn-default btn-block">
                                    <input type="hidden" name="activo" value="0">
                                    <input value="1" type="checkbox" name="activo" <?php echo (isset($rbacUsuario) and $rbacUsuario->activo) == 'true' ? 'checked' : ''; ?>>
                                    <span>Activo</span>

                                </label>
                            </div>
                            <div class="form-group col-sm-12 callout callout-info" role="alert">
                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                                Si desactiva el Usuario, esta quedara en la base de datos, pero el mismo no podra acceder el sistema.
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
