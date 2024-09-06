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
                                <input type="text" name="controller" placeholder="Controlador" class="form-control" id="apellido" aria-label="Controlador" value="<?php echo (isset($filters['controller'])) ? $filters['apellido'] : '' ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" name="action" placeholder="Acción" class="form-control" id="nombre" aria-label="Acción" value="<?php echo (isset($filters['action'])) ? $filters['action'] : '' ?>">
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
                                    <th class="col-sm-7">Acción
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
                                            <td colspan="3"><?php echo  $rbacAccion['controller']; ?></td>
                                            <?php $num++; ?>
                                        </tr>
                                    <?php } //else { ?>
                                        <?php
                                        $treeGrid =  'class="treegrid-parent-' . ($i - 1) . '"';
                                        ?>
                                        <tr id="headerTable" <?php echo $treeGrid; ?>>
                                            <td></td>
                                            <td><?php echo $rbacAccion['action']; ?></td>
                                            <td>
                                                <button class="btn-xs btn-danger" onclick="eliminar(<?php echo $rbacAccion['id']; ?>,'<?php echo $rbacAccion['action']; ?>');">
                                                    <i class="fa fa-fw fa-remove"></i>
                                                </button>
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
                                    <?php
                                    if (isset($rbacNuevos) && count($rbacNuevos)) {
                                        foreach ($rbacNuevos as $rbac) :
                                            if (isset($rbac['action']) && !empty($rbac['action'])) {
                                                //foreach ($rbac['action'] as $accion):
                                    ?>
                                                <tr id="headerTable2">
                                                    <td><?php

                                                        echo  $rbac['controller']; ?></td>
                                                    <?php //debug($rbac['action']);
                                                    ?>
                                                    <td><?php echo ($rbac['action'] == '_null') ? 'NULO' : $rbac['action']; //echo ($accion=='_null')?'NULO':$accion;
                                                        ?></td>
                                                    <td>
                                                        <input class="checkbox" name="valores[]" type="checkbox" data-action="<?php echo $rbac['action']; ?>" data-controller="<?php echo $rbac['controller']; ?>" data-plugin="<?php echo $rbac['plugin']; ?>" value="1" />
                                                    </td>
                                                </tr>
                                        <?php //endforeach;
                                            }
                                        endforeach;
                                    } else { ?>
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

<script type="text/javascript">
    $(function() {

        $('.tree').treegrid({
            'initialState': 'collapsed'
        });
        //$('#headerTable input[type="checkbox"]').checkbox();

        //$('#headerTable .switch').bootstrapSwitch();
        //desactivar_filas();


    });

    function desactivar_filas() {
        $('input#heredado').each(function() {
            var myFila = $(this).closest('td').attr('class');
            var myOpcion = ($(this).is(":checked"));
            $('td.' + myFila + ' input').each(function() {
                if ($(this).attr('id') != 'heredado') {
                    //$(this).checkbox({enabled: myOpcion});
                    if (myOpcion) $(this).attr("disabled", false);
                }
            });
        });
    }

    function desactivar_filas_here(mifila, opcion) {
        $('td.' + mifila + ' input').each(function() {
            if ($(this).attr('id') != 'heredado') {
                $(this).attr('disabled', opcion);
                /*if (opcion) {
                	$(this).checkbox({enabled: false});
                } else {
                	$(this).checkbox({enabled: true});
                }*/
            }
        });

    }

    $('#headerTable input[type="checkbox"]').click(function() {
        var valor = $(this).is(":checked");
        var accion_id = $(this).attr('dataid');
        var atributo_id = $(this).attr('id');
        var pariente = $(this).attr('parentid');
        var miFila = $(this).closest('td').attr('class');
        actualizar(accion_id, atributo_id, (valor) ? 1 : 0);
        //if (atributo_id != 'oculto') {
        if (atributo_id == 'heredado' && valor === true) {
            $('tr.treegrid-parent-' + pariente + ' td.' + miFila + ' input').each(function() {
                var myId = $(this).attr('id');
                if (myId != undefined && myId != 'heredado') {
                    var myAccion = $(this).attr('dataid');
                    var myValor = $('tr.treegrid-' + pariente + ' td input#' + myId).is(":checked");
                    var myId = $(this).attr('id');
                    $(this).attr("checked", (myValor) ? 0 : 1);
                    //$(this).checkbox({checked: (myValor)?1:0});
                    actualizar(myAccion, myId, (myValor) ? 0 : 1);
                    desactivar_filas_here(miFila, true);
                }
            });
            //console.log('1');
        } else if (atributo_id == 'heredado' && valor === false) {
            desactivar_filas_here(miFila, false);
            //console.log('2');
        } else {
            if ($(this).closest('tr').hasClass('treegrid-expanded')) {
                $('tr.treegrid-parent-' + pariente + ' td input#' + atributo_id).each(function() {
                    var idFila = $(this).closest('td').attr('class');
                    var myId = $(this).attr('id');
                    if (myId != undefined && myId != 'heredado') {
                        //alert(idFila+" - "+$('tr.treegrid-parent-'+pariente+' td.'+idFila).find('input#heredado').is(":checked"));
                        if (!$('tr.treegrid-parent-' + pariente + ' td.' + idFila).find('input#heredado').is(":checked")) {
                            var myAccion = $(this).attr('dataid');
                            $(this).attr("checked", valor);
                            //$(this).checkbox({checked: valor});
                            actualizar(myAccion, atributo_id, (valor) ? 1 : 0);
                        }
                    }
                });
                //console.log('3');
            } else {
                if (atributo_id != 'heredado') {
                    var myAccion = $(this).attr('dataid');
                    $(this).attr("checked", valor);
                    //$(this).checkbox({checked: (valor)?1:0});
                    actualizar(myAccion, atributo_id, (valor) ? 1 : 0);
                }
                //console.log('4');
            }
        }
        //}
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

    function eliminar(id, accion) {
        bootbox.confirm("Está seguro de eliminar la Acción " + accion + "?", function(result) {
            if (result) {
                document.location.href = "/rbac/RbacAcciones/eliminar/" + id;
            }
        });
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

    function limpiar() {
        document.location.href = "/rbac/rbac_acciones/index";
    }
</script>
