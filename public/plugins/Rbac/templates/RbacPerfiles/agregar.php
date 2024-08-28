<section id="RbacPerfilesEdit" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header  with-border">
                    <h3 class="box-title"> <span class="fa fa-sitemap fa-lg"></span> Nuevo Perfil</h3>
                    <div class="box-tools pull-right">
                        <a href="/rbac/RbacPerfiles/index/" class="btn btn-primary ">
                            <span class="fa fa-list"></span> Perfiles</a>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-row">
                        <form class="form-horizontal" id="RbacPerfilesAddForm" name="RbacPerfilesAddForm" role="form" action="/rbac/RbacPerfiles/agregar/" method="POST">
                            <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getAttribute('csrfToken'); ?>">

                            <div class="form-group col-sm-12">
                                <label for="descripcion">Descripción</label>
                                <input type="text" required="required" id="RbacPerfilesDescripcion" value="" placeholder="Descripción" class="form-control" name="descripcion">
                            </div>
                            <div class="form-group col-sm-12" id="dual-list">
                                <select id="rbac-acciones-ids" name="rbac_acciones[_ids][]" class="form-control" multiple="multiple">
                                    <?php foreach ($acciones as $k => $accion) {
                                        echo  '<option value="' . $accion->id . '">' .  $accion->controller . ' => ' .  $accion->action . '</option>';
                                    } ?>
                                </select>
                                <br>
                            </div>
                            <div class="form-group col-sm-12">
                                <label for="ca-inicio">Página de inicio</label>
                                <select id="ca-inicio" required name="accion_default_id" class="form-control">
                                    <!-- Carga automatica-->
                                </select>

                            </div>
                            <div class="form-group col-sm-12">
                                <div class="callout callout-info">
                                    <p><i class="icon fa fa-info"></i> Debe asignar al menos una acción al perfil, para poder elegir una página de inicio </p>
                                </div>
                            </div>
                            <?php
                            if ($this->request->getSession()->check('previousUrl')) {
                                $url = $this->request->getSession()->read('previousUrl');
                                if (strpos($url, "rbacPerfiles") !== false or strpos($url, "rbac_perfiles") !== false) {
                                    $url = $this->request->getSession()->read('previousUrl');
                                } else {
                                    $url = "/rbac/rbacPerfiles/index/";
                                }
                            } else {
                                $url = '/rbac/rbacPerfiles/index';
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
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
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
            .bootstrapDualListbox('refresh', true);

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
            //select.prop('selectedIndex', 0);
        });
    });
</script>