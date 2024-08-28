<section id="RbacUsuariosList" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header  with-border">
                    <h3 class="box-title"> <span class="fa fa-user fa-lg"></span> Editar Usuario</h3>
                    <div class="box-tools pull-right">
                        <a href="/Usuarios/index/" id="agregarUsuario" class="btn btn-primary ">
                            <span class="glyphicon glyphicon-plus-sign"></span> Usuarios</a>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-row">
                        <form accept-charset="utf-8" id="RbacUsuarioEditForm" name="RbacUsuarioEditForm" role="form" action="/usuarios/editar/<?php echo $rbacUsuario->id; ?>" method="POST">
                            <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getAttribute('csrfToken'); ?>">

                            <div class="form-group col-sm-2">
                                <label id="lblUsuario" for="usuario">Usuario (trigrama)</label>
                                <input type="text" maxlength="3" readonly name="usuario" tabindex="1" required id="RbacUsuarioUsuario" placeholder="Ingrese el usuario" class="form-control" value="<?php echo $rbacUsuario->usuario; ?>">
                                <?php
                                foreach ($rbacUsuario->getError('usuario') as $k => $v) { ?>
                                    <div class="form-group   label label-danger">
                                        <span class=" "> <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                            <?php echo $v; ?>
                                        </span>

                                    </div>
                                <?php  } ?>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="nombre">Nombre</label>
                                <input type="text" readonly id="RbacUsuarioNombre" class="form-control" name="nombre" value="<?php echo $rbacUsuario->nombre; ?>">
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="apellido">Apellido</label>
                                <input type="text" readonly id="RbacUsuarioApellido" class="form-control" name="apellido" value="<?php echo $rbacUsuario->apellido; ?>">
                            </div>
                            <div class="form-group col-sm-2">
                                <label id="lblUsuario" for="usuario">Área</label>
                                <input type="text" readonly name="area" required id="RbacUsuarioArea" class="form-control" maxlength="5" value="<?php echo $rbacUsuario->area; ?>">
                            </div>
                            <br><br>
                            <div class="form-group col-sm-5" style="clear: left;"
                                <input type="hidden" id="rbac-perfil-ids" value="" name="RbacPerfil[_ids][]">
                                <label for="rbac-perfiles-ids">Perfil</label><br>
                                
                                    <select required id="rbac-perfiles-ids" name="rbac_perfiles[_ids][]" class="form-control" multiple="multiple">
                                        <?php foreach ($rbacPerfiles as $id => $perfil) : ?>
                                            <?php if (in_array($id, $rbacPerfilesIds)) { ?>
                                                <option value="<?php echo $id; ?>" selected="selected"><?php echo $perfil; ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $id; ?>"><?php echo $perfil; ?></option>
                                            <?php } ?>
                                        <?php endforeach; ?>
                                    </select>
                               
                            </div>
                            <div class="form-group col-sm-5">
                                <label for="RbacUsuarioPerfilDefault" >Perfil Default</label>
                             
                                    <select required="required" id="RbacUsuarioPerfilDefault" name="perfil_default_id" class="form-control">
                                        <?php foreach ($rbacPerfiles as $id => $perfil) : ?>
                                            <?php if (in_array($id, $rbacPerfilesIds)) { ?>
                                                <?php if ($rbacUsuario['perfil_default_id'] != $id) { ?>
                                                    <option value="<?php echo $id; ?>"><?php echo $perfil; ?></option>
                                                <?php } else { ?>
                                                    <option selected="selected" value="<?php echo $id; ?>"><?php echo $perfil; ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php endforeach; ?>
                                    </select>
                               
                            </div>
                            <div class="form-group   col-sm-2">
                                <label for="">&nbsp;</label><br>
                                <label class="btn btn-default btn-block">
                                    <input type="hidden" name="activo" value="0">
                                    <input value="1" type="checkbox" name="activo" <?php echo (isset($rbacUsuario) and $rbacUsuario['activo']) == 'true' ? 'checked' : ''; ?>>
                                    <span>Activo</span>

                                </label>
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
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
    </div>

</section>
<!-- /.box-body -->

<script type="text/javascript">
    $(function() {
        inicialize();
    });

    function inicialize() {

        $('#rbac-perfiles-ids').multiselect({
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Buscar',
            buttonWidth:  '100%',
            buttonContainer:'<div class="btn-group button-select-width" /> ',
            onChange: function(element, checked) {
                if (checked) {
                    //agregar en el select                     
                    $('#RbacUsuarioPerfilDefault').append('<option value="' + element.val() + '" >' + element.text() + '</option>');
                } else {
                    $("#RbacUsuarioPerfilDefault").find("option[value='" + element.val() + "']").remove();
                }
            }
        });


        $('#contrasenia-group').hide();

        $.validator.addMethod('correo', function(value, element, param) {
            return this.optional(element) || /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/.test(value);
        });
        $('#RbacUsuarioEditForm').validate({
            rules: {
                'data[RbacUsuario][usuario]': {
                    //lettersonly: true,
                    minlength: 3,
                    maxlength: 45,
                    required: true
                },
                'correo': {
                    correo: true,
                    required: true,
                },
                'data[RbacPerfil]': {
                    required: true
                }
            },
            messages: {
                'correo': {
                    correo: "Ingrese correo valido"
                }
            },
            highlight: function(element) {
                $(element).closest('.control-group').removeClass('success').addClass('error');
            }
            /*,
            success: function(element) {
                element
                .text('OK!').addClass('valid')
                .closest('.control-group').removeClass('error').addClass('success');
            }*/
        });
    }
</script>