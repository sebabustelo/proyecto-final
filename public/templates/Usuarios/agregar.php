<section id="RbacUsuariosAdd" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header  with-border">
                    <h3 class="box-title"> <span class="fa fa-user-plus fa-lg"></span> Nuevo Usuario</h3>
                    <div class="box-tools pull-right">
                        <a href="/Usuarios/index/" id="agregarUsuario" class="btn btn-primary ">
                            <span class="fa fa-list"></span> Usuarios</a>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-row">
                        <form id="RbacUsuariosAddForm" name="RbacUsuariosAddForm" role="form" action="/usuarios/agregar/" method="POST">
                            <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getAttribute('csrfToken'); ?>">
                            <!-- <div class="form-group form-inline col-sm-12">
                                <label for="valida_ldap" class="col-sm-2 control-label">¿Valida LDAP?</label>

                                <div class="radio">
                                    <label>
                                        <input type="radio" name="valida_ldap[]" id="optionsRadios" onclick="validaLdap(true)" value="1" checked>
                                        Si
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="valida_ldap[]" id="optionsRadios" onclick="validaLdap(false)" value="0">
                                        No
                                    </label>
                                </div>

                            </div> -->
                            <div class="form-group col-sm-2">
                                <label id="lblUsuario" for="usuario">Usuario</label>
                                <input type="text" maxlength="3" name="usuario" tabindex="1" required id="RbacUsuarioUsuario" oninvalid="this.setCustomValidity('Complete el usuario')" oninput="this.setCustomValidity('')" placeholder="Ingrese el usuario" class="form-control" maxlength="20" value="<?php echo (!$rbacUsuario->getError('usuario')) ? $this->request->getData('usuario') : ''; ?>">
                                <?php
                                foreach ($rbacUsuario->getError('usuario') as $k => $v) { ?>
                                    <div class="form-group   label label-danger">
                                        <span class=" "> <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                            <?php echo $v; ?>
                                        </span>

                                    </div>
                                <?php  } ?>
                            </div>
                            
                            <div id="contrasenia-group">
                                <!-- <div class="form-group">
                                    <label for="contrasenia" class="col-sm-3 control-label">Contraseña</label>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control" name="password" id="contrasenia" placeholder="Contraseña">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="contrasenia2" class="col-sm-3 control-label">Reingrese Contraseña</label>
                                    <div class="col-sm-6">
                                        <input type="new-password" class="form-control" name="contrasenia2" id="contrasenia2" placeholder="Reingrese Contraseña">
                                    </div>
                                </div> -->
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="nombre">Nombre</label>
                                <input type="text" id="RbacUsuarioNombre" placeholder="Se autocompleta automáticamente al asociar un usuarios(trigrama)" class="form-control" name="nombre">
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="apellido">Apellido</label>
                                <input type="text" id="RbacUsuarioApellido" placeholder="Se autocompleta automáticamente al asociar un usuarios(trigrama)" class="form-control" name="apellido">
                            </div>
                            <div class="form-group col-sm-2">
                                <label id="lblUsuario" for="usuario">Área</label>
                                <input type="text" readonly name="area" required id="RbacUsuarioArea" class="form-control" maxlength="5">

                            </div>
                            <br><br>
                            <div class="form-group col-sm-6" style="clear: left;"
                                <label for="rbac-perfiles-ids">Perfil</label><br>
                                <select required id="rbac-perfiles-ids" name="rbac_perfiles[_ids][]" class="form-control" multiple required>
                                    <?php foreach ($rbacPerfiles as $id => $perfil) : ?>
                                        <option value="<?php echo $id; ?>"><?php echo $perfil; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="RbacUsuarioPerfilDefault">Perfil por Defecto</label>
                                <select id="perfil-default-id" name="perfil_default_id" class="form-control">

                                </select>
                            </div>
                            <div class="form-group col-sm-5" id="correo-group">
                                <label for="correo">Correo</label>
                                <input type="email" id="correo" placeholder="Correo" class="form-control" name="correo">
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



<script type="text/javascript">
    $(function() {
        $('#optionsRadios').change();
        <?php if ($LDAP->valor == 'No') { ?>
            $('.ldap').hide();
        <?php } else { ?>
            $('.ldap').show();
        <?php } ?>
        inicialize();
    });

    function inicialize() {

        $('#rbac-perfiles-ids').multiselect({
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Buscar',
            nonSelectedText: 'Lista de Perfiles',
            buttonWidth:  '100%',
            buttonContainer:'<div class="btn-group button-select-width" /> ',
            onChange: function(element, checked) {
                if (checked) {
                    //agregar en el select                     
                    $('#perfil-default-id').append('<option value="' + element.val() + '" >' + element.text() + '</option>');
                } else {
                    //eliminar del select
                    $("#perfil-default-id").find("option[value='" + element.val() + "']").remove();
                }
            }
            //buttonWidth: '571px',    
            //buttonClass: 'btn-primary'
        });
        validaLdap(true);
    }

    // function validar_form() {
    //     $('#RbacUsuariosAddForm').validate({
    //         rules: {
    //             'usuario': {
    //                 required: true
    //             },
    //             'rbac_perfiles[_ids]': {
    //                 required: true
    //             },
    //             'perfil_default_id': {
    //                 required: true
    //             }
    //         },
    //         messages: {
    //             'usuario': {
    //                 required: "Complete usuario"
    //             }
    //         },
    //         highlight: function(element) {
    //             // alert("entro")
    //             $(element).closest('.form-control').removeClass('success').addClass('error');
    //         }
    //     });
    // }

    function guardar() {

        // if ($("input[name='valida_ldap']:checked").val() != 1 && $('#contrasenia').val() != $('#contrasenia2').val()) {
        //     var validator = $("#RbacUsuariosAddForm").validate();
        //     validator.showErrors({
        //         "contrasenia2": "Por favor reingrese la contraseña"
        //     });
        // } else {
        if ($('#RbacUsuariosAddForm').valid()) {
            usuario = $("#RbacUsuarioUsuario").val();
            //validar en BD                 
            $.ajax({
                url: '/rbac/rbacUsuarios/validarLoginDB/',
                cache: false,
                type: 'POST',
                dataType: 'json',
                headers: {
                    'X-CSRF-Token': "<?php echo $this->request->getAttribute('csrfToken'); ?>"
                },
                data: {
                    usuario: usuario
                },
                success: function(data) {
                    if (data.result) {
                        var validator = $("#RbacUsuariosAddForm").validate();
                        validator.showErrors({
                            "usuario": "El usuario ya existe."
                        });
                    } else {
                        if (!$('#RbacUsuariosAddForm').submit()) {
                            window.top.location.href = '/index/';
                        }
                    }
                }
            });
        }
        // }
    }

    function validaLdap(valida) {
        if (valida) {
            $('#correo-group').hide();
            $('#contrasenia-group').hide();
            //$('#RbacUsuarioUsuario').rules('remove', 'correo');
            //$('#contrasenia').rules('remove');
            //$('#contrasenia2').rules('remove');
            $('#RbacUsuarioNombre').attr('readonly', true);
            $('#RbacUsuarioNombre').attr('placeholder', "Se autocompleta automáticamente al asociar un usuario");
            $('#RbacUsuarioApellido').attr('readonly', true);
            $('#RbacUsuarioApellido').attr('placeholder', "Se autocompleta automáticamente al asociar un usuario");
            document.getElementById('lblUsuario').innerHTML = 'Usuario (trigrama)';
            autocompleteLdap(true);
        } else {
            $('#correo-group').show();
            //$('#RbacUsuarioUsuario').rules('add', 'correo');
            // $('#RbacUsuarioNombre').rules('add', 'required');
            // $('#contrasenia').rules('add', 'required');
            // $('#contrasenia2').rules('add', 'required');
            $('#RbacUsuarioNombre').removeAttr('readonly');
            $('#RbacUsuarioNombre').attr('placeholder', "Nombre");
            $('#RbacUsuarioApellido').removeAttr('readonly');
            $('#RbacUsuarioApellido').attr('placeholder', "Apellido");
            document.getElementById('lblUsuario').innerHTML = 'Usuario';
            autocompleteLdap(false);
        }
        $('#RbacUsuarioNombre').val('');
        $('#RbacUsuarioApellido').val('');
        $('#RbacUsuarioUsuario').val('');
        // $("label[for=RbacUsuarioUsuario]").removeClass('error').hide();
    }


    function autocompleteLdap(autocomplete) {

        if (autocomplete) {

            $("#RbacUsuarioUsuario").autocomplete({
                source: function(request, response) {

                    $.ajax({
                        url: "/rbac/rbacUsuarios/autocompleteLdap/",
                        type: 'POST',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-Token': "<?php echo $this->request->getAttribute('csrfToken'); ?>"
                        },
                        data: {
                            usuario: request.term
                        },
                        success: function(data) {
                            console.log(data);
                            response($.map(data.result, function(item) {
                                $('#RbacUsuarioArea').val( (data.result[0].area).toUpperCase())
                                return {
                                    label: item.label,
                                    value: item.value
                                   
                                };
                            }));
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            alert("No se puede validar el usuario: ");

                        }
                    });
                },
                minLength: 1,
                select: function(event, ui) {
                    var nombreCompleto = ui.item.label.split(",")[1].trim();
                    var nombre = nombreCompleto.split('(');

                    $('#RbacUsuarioNombre').val(nombre[0]);
                    $('#RbacUsuarioApellido').val(ui.item.label.split(",")[0].trim());
                }
            });
        } else {
            $('#RbacUsuarioUsuario').autocomplete("destroy");
        }

    }
</script>