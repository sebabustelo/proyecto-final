<section id="RbacPerfilesEdit" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header  with-border">
                    <h3 class="box-title"> <i class="fa fa-suitcase fa-lg"></i> Editar Perfil</h3>
                    <div class="box-tools pull-right">
                        <a href="/rbac/RbacPerfiles/index/" class="btn btn-sm btn-primary ">
                            <i class="fa fa-list"></i>&nbsp;Perfiles</a>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="box-body">
                        <form class="form-horizontal" id="RbacPerfilesEditForm" name="RbacPerfilesEditForm" role="form" action="/rbac/RbacPerfiles/editar/<?php echo $rbacPerfil->id; ?>" method="POST">
                            <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getAttribute('csrfToken'); ?>">
                            <div class="form-group col-sm-12">
                                <label for="descripcion">Descripción</label>
                                <input type="hidden" required="required" id="id" value="<?php echo $rbacPerfil->id; ?>" placeholder="Descripción" class="form-control" name="id">
                                <input type="text" required="required" id="RbacPerfilesDescripcion" value="<?php echo $rbacPerfil->descripcion; ?>" placeholder="Descripción" class="form-control" name="descripcion">
                            </div>

                            <div class="form-group well" id="dual-list">
                                <div class="controls col-sm-12">
                                    <select id="rbac-acciones-ids" name="rbac_acciones[_ids][]" class="form-control" multiple="multiple">
                                        <!-- Carga automatica-->
                                        <?php foreach ($accionesPosibles as $accion) : ?>
                                            <option value="<?php echo $accion->id; ?>"><?php echo $accion->controller . "=>" . $accion->action; ?></option>
                                        <?php endforeach; ?>
                                        <?php foreach ($accionesAsignadas as $accion) : ?>
                                            <option value="<?php echo $accion->id; ?>" selected><?php echo $accion->controller . "=>" . $accion->action; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <br>
                                </div>
                            </div>
                            <div class="form-group col-sm-12">
                                <label for="ca-inicio">Página de inicio</label>
                                <select id="ca-inicio" name="accion_default_id" class="form-control" required="required">
                                        <!-- Carga automatica segun virtual host-->
                                        <option value="">Seleccionar Página Inicio</option>
                                        <?php foreach ($accionesAsignadas as $ra) { ?>
                                            <?php if ($rbacPerfil->accion_default_id == $ra->id) { ?>
                                                <option selected="selected" value="<?php echo $ra->id; ?>"><?php echo $ra->controller . '=>' . $ra->action; ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $ra->id; ?>"><?php echo $ra->controller . '=>' . $ra->action; ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                            </div>

                            <div class="form-group">
                                <div class=" col-sm-9 col-md-offset-5">
                                    <a href="/rbac/RbacPerfiles/index/" class="btn btn-danger">
                                        <span class="glyphicon glyphicon-remove"></span> Cancelar</a>
                                    <button type="submit" class="btn btn-primary">
                                        <span class="glyphicon glyphicon-check"></span>
                                        Guardar</button>
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


<script type="text/javascript">
    $(function() {


        var RbacAcciones = $('#rbac-acciones-ids')
            .bootstrapDualListbox({
                bootstrap2Compatible: false,
                moveAllLabel: 'Asignar todas',
                removeAllLabel: 'Eliminar todas',
                moveSelectedLabel: 'MOVE SELECTED',
                removeSelectedLabel: 'REMOVE SELECTED',
                filterPlaceHolder: 'Buscar',
                filterSelected: '2',
                filterNonSelected: '1',
                moveOnSelect: false,
                //preserveSelectionOnMove: 'all',
                helperSelectNamePostfix: '_myhelper',
                selectedListLabel: 'Acciones Permitidas',
                nonSelectedListLabel: 'Acciones',
                selectOrMinimalHeight: 300
            })
            .bootstrapDualListbox('setMoveAllLabel', 'Mover todas las acciones')
            .bootstrapDualListbox('setRemoveAllLabel', 'Eliminar todas las acciones')
            .bootstrapDualListbox('setSelectedFilter', undefined)
            .bootstrapDualListbox('setNonSelectedFilter', undefined)
            //.append('<option>added element</option>')
            .bootstrapDualListbox('refresh');


        $("#rbac-acciones-ids").change(function() {
            var select = $('[name="accion_default_id"]');
            var acciondefault = $('[name="accion_default_id"]').val();

            $('option', select).remove();
            $('[name="rbac_acciones[_ids][]_myhelper2"').find('option').each(function(index, item) {
                var $item = $(item);
                console.log($item.val() + " - " + $item.text());
                select.append('<option value="' + $item.val() + '">' + $item.text() + '</option>');
            });
            if (acciondefault) {
                $('[name="accion_default_id"]').val(acciondefault);
            } else {
                $('[name="accion_default_id"] option:first').attr('selected', 'selected');
            }
            //$('[name="data[RbacPerfil][accion_default_id]"] option:first').attr('selected', 'selected');

            //select.prop('selectedIndex', 0);
        });

    });

    function enviar() {


        //var ff = $('select[name="rbac_acciones[_ids][]"]').bootstrapDualListbox();


        //$("#RbacPerfilesEditForm").append('<input type="hidden" name="RbacAccionAux" value="'+ff.val()+'" /> ');

        $("#RbacPerfilesEditForm").submit();

    }

    function changeRadio(value) {
        //reseteo todo
        $('#ca-inicio').html('');
        $('#RbacAcciones').html('');
        $('[name="permiso_virtual_host_id"]').val('');

        //indica donde se debe cargar cuando se haga un cambio en el virtual host si en el duallist o en el combo de default accion
        esDefault = value;

        data = null;

        if (value == 1) {
            //ocultar acciones dual list
            $('#dual-list').hide();
            data = PermisosVirtualHostDisponiblesDefault;

            //cargar $('#vh') con los virtual host disponibles es decir con $PermisosVirtualHostDisponiblesDefault

        } else {
            //mostrar dual list
            $('#dual-list').show();

            data = PermisosVirtualHost;

            //cargar $('#vh') $PermisosVirtualHost
        }

        $('#vh').html('');
        var options = '<option value="">Seleccionar Virtual Host</option>';
        $.each(data, function(key, value) {
            options = options + '<option value="' + value.PermisosVirtualHost.id + '">' + value.PermisosVirtualHost.permiso + '</option>';
            //console.log(value.PermisosVirtualHost.permiso);
        });
        $('#vh').html(options);

    }
</script>

