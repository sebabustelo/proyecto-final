<!-- Main content -->
<section id="RbacAccionesList" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header  with-border">
                    <h3 class="box-title"> <span class="fa fa-search fa-lg"></span> Buscador</h3>
                    <div class="box-tools pull-right">

                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form method="get" accept-charset="utf-8" class="form abox" id="formOrderFilter" action="/rbac/RbacAcciones/index">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <input type="text" name="controller" placeholder="Controlador" class="form-control" id="apellido"
                                    aria-label="Controlador" value="<?php echo (isset($filters['controller'])) ? $filters['controller'] : '' ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" name="action" placeholder="Acción" class="form-control" id="nombre" aria-label="Acción"
                                    value="<?php echo (isset($filters['action'])) ? $filters['action'] : '' ?>">
                            </div>

                        </div>

                        <div class=" form-row">
                            <div class="form-group col-md-12 text-center ">
                                <button type="button" id="limpiar" class="btn btn-default">
                                    <span class="glyphicon glyphicon-trash"></span>
                                    Limpiar</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <button type="submit" id="enviar" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-search"></span>
                                    Buscar</button>

                                <!--div class="form-group col-md-4"!-->
                                <!--a href="#" id="limpiar" class="btn btn-default" title=""><span class="glyphicon glyphicon-trash"></span> Limpiar</a!-->
                                <script>
                                    $(function() {
                                        $('#limpiar').on('click', function() {
                                            $('#formOrderFilter').find('input:text, input:password, select, textarea').val('');
                                            $('#formOrderFilter').submit();
                                            return false;
                                        });
                                    });
                                </script>
                                <div id="filterErrors">
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header  with-border">
                    <h3 class="box-title"> <span class="fa  fa-lock fa-lg"></span> Permisos</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-primary" onclick="sincronizar()">
                            <span class="fa fa-refresh"></span> Sincronizar
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered tree">
                            <thead>
                                <tr>
                                    <th class="col-sm-4">Controlador
                                    </th>
                                    <th class="col-sm-5">Acción
                                    </th>
                                    <th class="col-sm-2">Publica
                                    </th>
                                    <th class="col-sm-1">Acciones</th>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                $num = 0;
                                $aux = '';
                                $controllers = [];

                                foreach ($rbacAcciones as $rbacAccion) :
                                    if (!in_array($rbacAccion['controller'], $controllers)) {

                                        $controllers[] =  $rbacAccion['controller'];
                                        $treeGrid = 'class="treegrid-' . $i . '"';
                                        $i++;
                                ?>
                                        <tr id="headerTable" <?php echo $treeGrid; ?>>
                                            <td colspan="3">
                                                <?php echo  $rbacAccion['controller']; ?>
                                            </td>
                                            <?php $num++; ?>
                                        </tr>
                                    <?php } ?>
                                    <?php $treeGrid =  'class="treegrid-parent-' . ($i - 1) . '"'; ?>
                                    <tr id="headerTable" <?php echo $treeGrid; ?>>
                                        <td></td>
                                        <td>
                                            <?php echo $rbacAccion['action']; ?>
                                        </td>
                                        <td>
                                            <input type="checkbox" id="" class="btn-sm requiere-login"
                                                data-id="<?php echo $rbacAccion['id']; ?>" <?php echo ($rbacAccion['publico'] == 1) ? ' checked' : ''; ?>>
                                        </td>
                                        <td class="remove">
                                            <?= $this->Form->postLink(
                                                __('<i class="fa fa-remove"></i>'),
                                                ['action' => 'delete', $rbacAccion->id],
                                                [
                                                    'confirm' => __('¿Esta seguro de eliminar la acción {0}?', $rbacAccion->action),
                                                    'class' => 'btn btn-danger btn-xs pencil',
                                                    'escape' => false
                                                ]
                                            ) ?>
                                        </td>

                                        <?php $num++; ?>
                                    </tr>
                                <?php //}
                                endforeach; ?>
                            </tbody>
                        </table>


                    </div>

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>


<div class="modal fade" id="modalSincronizarAcciones">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><br />
                <h4 class="modal-title">Sincronización</h4>
            </div>
            <div class="modal-body">
                <div id="datos">
                    <div class="col-md-12">
                        <div class="table-sincronizar">
                            <table class="table table-hover tree">
                                <thead>
                                    <tr>
                                        <th>Controlador</th>
                                        <th>Accion</th>
                                        <th id="marcar"><a href="#" id="valores[]" style="text-decoration:underline;">RBAC</a></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($rbacNuevos) && count($rbacNuevos)) { ?>
                                        <?php foreach ($rbacNuevos as $rbac) : ?>
                                            <?php if (isset($rbac['action']) && !empty($rbac['action'])) { ?>
                                                <tr id="headerTable2">
                                                    <td><?php echo  $rbac['controller']; ?></td>
                                                    <td><?php echo $rbac['action']; ?></td>
                                                    <td>
                                                        <input class="checkbox" name="valores[]" type="checkbox" data-action="<?php echo $rbac['action']; ?>" data-controller="<?php echo $rbac['controller']; ?>" data-plugin="<?php echo $rbac['plugin']; ?>" value="1" />
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        <?php endforeach; ?>
                                    <?php } else { ?>
                                        <tr>
                                            <td colspan="3">
                                                <h3 style="text-align:center;">No hay nuevas acciones...</h3>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php if (isset($rbacNuevos) && count($rbacNuevos)) { ?>
                        <div class="col-md-12" style="text-align:left;">
                            <button onClick="guardar()" type="button" class="btn btn-primary" title="Guardar"><span class="glyphicon glyphicon-check"> </span>Guardar</button>
                        </div>
                    <?php } ?>
                    <div style="clear:both;"></div>
                </div>
            </div>
            <div class="modal-footer" style="clear:both;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Cambio de Acciona Publica/No Publica -->
<div class="modal fade" id="responseModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Resultado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalMessage">
                <!-- Aquí se insertará el mensaje -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(function() {

        $('.tree').treegrid({
            'initialState': 'collapsed'
        });

        // Detectar cambios en los switches y enviar los datos por AJAX
        $('.requiere-login').on('change', function() {
            var accionId = $(this).data('id'); // ID de la acción
            var nuevoEstado = $(this).is(':checked') ? 1 : 0; // Estado del checkbox

            // Enviar la actualización por AJAX
            $.ajax({
                url: '/rbac/rbac_acciones/requireLogin/',
                type: 'POST',
                dataType: 'json',
                headers: {
                    'X-CSRF-Token': "<?php echo $this->request->getAttribute('csrfToken'); ?>"
                },
                data: {
                    accion_id: accionId,
                    atributo_id: 'publico',
                    valor: nuevoEstado
                },
                success: function(response) {
                    // Verifica si la respuesta contiene el resultado
                    if (response && response.result !== undefined) {
                        // Actualiza el mensaje del modal
                        $('#modalMessage').text(response.message);
                        // Muestra el modal
                        $('#responseModal').modal('show');
                    } else {
                        // Si no hay resultado, muestra un error genérico
                        $('#modalMessage').text('Ocurrió un error inesperado.');
                        $('#responseModal').modal('show');
                    }
                },
                error: function() {
                    // En caso de error en la petición AJAX
                    $('#modalMessage').text('Error en la solicitud. Intente de nuevo.');
                    $('#responseModal').modal('show');
                }
            });
        });
    });

    function actualizar(accion_id, atributo_id, valor) {
        if (accion_id != null) {
            $.ajax({
                url: "/rbac/rbac_acciones/switchAccion/",
                type: 'POST',
                dataType: 'json',
                headers: {
                    'X-CSRF-Token': "<?php echo $this->request->getAttribute('csrfToken'); ?>"
                },
                data: {
                    'accion_id': accion_id,
                    'atributo_id': atributo_id,
                    'valor': valor
                },
                success: function(data) {
                    //console.log(data);
                }
            });
        }
    }

    function sincronizar() {
        $("#modalSincronizarAcciones").modal("show");
    }

    function guardar() {
        var plugin;
        var atributo_id;
        var accion_id;
        var grabado;
        var miArray = [];
        $('#headerTable2 .checkbox:checked').each(function() {
            if (this.checked) {
                plugin = $(this).attr('data-plugin');
                atributo_id = $(this).attr('data-controller');
                accion_id = $(this).attr('data-action');
                valor = $(this).val();
                var item = plugin + ";" + atributo_id + ";" + accion_id + ";" + valor;
                miArray.push(item);
            }
        });
        if (miArray) {
            $.ajax({
                url: "/rbac/RbacAcciones/sincronizar/",
                type: 'POST',
                dataType: 'json',
                data: {
                    'miArray': miArray
                },
                headers: {
                    'X-CSRF-Token': "<?php echo $this->request->getAttribute('csrfToken'); ?>"
                },
                success: function(data) {
                    if (data) document.location.href = "/rbac/rbac_acciones/index";
                }
            });
        }
    }
</script>
