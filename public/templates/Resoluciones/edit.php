<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Resolucione $resolucione
 * @var string[]|\Cake\Collection\CollectionInterface $documentoTipos
 * @var string[]|\Cake\Collection\CollectionInterface $palabrasClave
 */


?>
<section id="ResolucionEdit" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header  with-border">
                    <h3 class="box-title"> <span class="fa fa-file fa-lg"></span> Editar Registro</h3>
                    <div class="box-tools pull-right">
                        <a href="/resoluciones/index" id="agregarArea" class="btn btn-primary ">
                            <span class="fa fa-list"></span> Registros</a>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-row">
                        <form id="ResolucionesEditForm" name="ResolucionesEditForm" role="form" enctype="multipart/form-data" action="/resoluciones/edit/<?php echo $resolucion['id'];  ?>" method="POST">
                            <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getAttribute('csrfToken'); ?>">
                            <div class="form-group  col-sm-5">
                                <label for="titulo">Título</label>
                                <input type="text" name="titulo" required id="titulo" oninvalid="this.setCustomValidity('Complete el Título')" oninput="this.setCustomValidity('')" class="form-control" maxlength="200" value="<?php echo (isset($resolucion['titulo'])) ? $resolucion['titulo'] : ''; ?>">
                            </div>                           
                            <div class="form-group  col-sm-3">
                                <label for="expediente">Expediente</label>
                                <input type="text" name="expediente" id="expediente" class="form-control" value="<?php echo (isset($resolucion['expediente'])) ? $resolucion['expediente'] : ''; ?>">
                            </div>
                            <div class="form-group  col-sm-2">
                                <label for="proyecto">Proyecto</label>
                                <input type="text" name="proyecto" id="proyecto" class="form-control" value="<?php echo (isset($resolucion['proyecto'])) ? $resolucion['proyecto'] : ''; ?>">
                            </div>
                            <div class="form-group  col-sm-1">
                                <label for="numero">Número</label>
                                <input type="text" name="numero" required id="numero" class="form-control" maxlength="20" value="<?php echo (isset($resolucion['numero'])) ? $resolucion['numero'] : ''; ?>">
                            </div>
                            <div class="form-group  col-sm-1">
                                <label for="anio">Año</label>
                                <select name="anio" class="form-control">
                                    <?php
                                    $anio_actual = date("Y");
                                    $anio_inicial = 1990;

                                    // Iterar desde el año inicial hasta el año actual
                                    for ($anio = $anio_actual; $anio >= $anio_inicial; $anio--) {
                                        if ($resolucion['anio'] == $anio) {
                                            echo "<option selected value=\"$anio\">$anio</option>";
                                        } else {
                                            echo "<option value=\"$anio\">$anio</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group  col-sm-2">
                                <label for="fecha">Fecha</label>
                                <input type="date" name="fecha" required id="fecha" class="form-control" value="<?php echo isset($resolucion['fecha']) ? $resolucion['fecha']->format('Y-m-d')  : ''; ?>">
                            </div>
                            

                            
                            <div class="form-group  col-sm-3">
                                <label for="area_id">Área de Origen</label>
                                <select name="area_id" required id="codigo" class="form-control">
                                    <option value="">Selecione un Área</option>
                                    <?php foreach ($areas as $key => $value) { ?>
                                        <?php if ($key == $resolucion['area_id']) { ?>
                                            <option value="<?php echo $key ?>" selected><?php echo $value ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $key ?>"><?php echo $value ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group  col-sm-3">
                                <label for="documento_tipo_id">Tipo de Documento</label>     
                                <select type="text" name="documento_tipo_id" required id="documento_tipo_id" class="form-control">
                                    <option value="">Selecione un Documento</option>
                                    <?php foreach ($documentoTipos as $key => $value) { ?>
                                        <?php if ($key == $resolucion['documento_tipo_id']) { ?>
                                            <option value="<?php echo $key ?>" selected><?php echo $value ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $key ?>"><?php echo $value ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>                           
                            <div class="form-group  col-sm-4">
                                <label for="cargo_firmante">Firmante (depende del Tipo de doc. seleccionado)</label>
                                <select name="cargo_firmante" required id="cargo_firmante" class="form-control">
                                    <option value="">Selecione un Firmante</option>
                                    <?php foreach ($funcionarios as $key => $value) { ?>
                                        <?php if ($value['id'] == $resolucion['cargo_firmante']) { ?>
                                            <option value="<?php echo $value['id'] ?>" selected><?php echo $value['full_name'] ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $value['id'] ?>"><?php echo $value['full_name'] ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group  col-sm-2">
                                <label>Es documento conjunto</label>
                                <select name="modifica_complementa" id="modifica_complementa" class="form-control">
                                    <?php if ($resolucion['modifica_complementa']) { ?>
                                        <option value="0">No</option>
                                        <option value="1" selected>Sí</option>
                                    <?php } else { ?>
                                        <option value="0" selected>No</option>
                                        <option value="1">Sí</option>
                                    <?php }
                                    // sumar dos numeros

                                    ?>
                                </select>
                            </div>
                            <div id="documento_conjunto" style="display: none;">
                                <div class="form-group  col-sm-2 modifica_complementa">
                                    <label for="nro_organismo">Número</label>
                                    <input type="text" name="nro_organismo" id="nro_organismo" class="form-control" value="<?php echo (isset($resolucion['nro_organismo'])) ? $resolucion['nro_organismo'] : ''; ?>">
                                </div>

                                <div class="form-group  col-sm-8 modifica_complementa">
                                    <label for="organismo_id">Organismo</label>
                                    <select name="organismo_id" id="organismo_id" class="form-control">
                                        <option value="">Selecione un Organismo</option>
                                        <?php foreach ($organismos as $key => $value) { ?>
                                            <?php if ($key == $resolucion['organismo_id']) { ?>
                                                <option value="<?php echo $key ?>" selected><?php echo $value ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $key ?>"><?php echo $value ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <?php
                            $listPalabrasClave = [];
                            foreach ($resolucion['palabras_clave'] as $k => $v) {
                                $listPalabrasClave[] = $v->id;
                            }
                            $options['empty'] = 'Seleccione la/s Palabra/s ';
                            $options['name'] = 'palabras_clave';
                            $options['id'] = 'palabras_clave';
                            $options['list'] = $palabrasClaves;
                            $options['selected'] = $listPalabrasClave;
                            $options['numberDisplayed'] = 12;
                            $options['title'] = 'Palabra/s Clave/s';
                            $options['class'] = 'col-sm-12';
                            echo $this->element('custom_fields/multiselect', [
                                'options' => $options,
                            ]);
                            ?>
                            <br>
                            <div class="form-group col-sm-12">
                                <span class="btn btn-default btn-file">
                                    <i class="fa fa-cloud-upload"></i> Subir archivo
                                    <input id="attachments" type="file" class="multi" multiple accept="application/pdf" name="attachments[]" />
                                </span>
                                <?php if (!empty($resolucion->uploads)) {
                                    $n = 0;
                                ?>
                            </div>
                            <div class="form-group col-sm-12">
                                <div class="btn btn-default">
                                    <label class="btn"> <i class="fa fa-file fa-lg"></i>&nbsp;&nbsp; Archivos Asociados</label><br>
                                    <?php foreach ($resolucion->uploads as $key => $upload) { ?>
                                        <br>
                                        <div style="text-align: left;" class="MultiFile-label">
                                            <input type="hidden" class="borrar_archivo" name="delete[<?php echo $n; ?>]" value="" />
                                            <a id="<?php echo $n; ?>" data-id="<?php echo $upload['id']; ?>" class="remove-file MultiFile-remove  btn-sm btn-danger " href="#">
                                                <span class="glyphicon glyphicon-remove"></span></a>
                                            <span id="<?php echo $n; ?>"><?php echo "<a href='/resoluciones/descargarArchivo/". $resolucion['id']."/" . $upload['id'] . "'> " . $upload['nombre_original'] . "." . $upload['extension_archivo'] . "</a>"; ?>
                                            </span>
                                        </div>

                                    <?php
                                        $n++;
                                    } ?>
                                </div>
                            <?php } ?>
                            </div>

                            <div class="form-group col-sm-11 input-group" style="float: left;margin-left: 14px;">
                                <button class="btn btn-success" id="btnBuscarResolucion" formnovalidate>
                                    <span class="glyphicon glyphicon-search"></span> Resolución Asociada</button>

                            </div>
                            <?php //debug($resolucion); 
                            ?>
                            <div class="col-md-12 table">
                                <div class="table-responsive">
                                    <table id="tablaDestino" class="table table-hover table-striped">
                                        <?php if ((isset($resolucion['resolucion_relacionadas_modificada']) and count($resolucion['resolucion_relacionadas_modificada']) > 0)
                                            or (isset($resolucion['resolucion_relacionadas_modificadora']) and count($resolucion['resolucion_relacionadas_modificadora']) > 0)
                                        ) { ?>
                                            <thead>
                                                <tr>
                                                    <th>Relación</th>
                                                    <th>
                                                        Tipo Documento
                                                    </th>
                                                    <th>
                                                        Nro/Anio
                                                    </th>
                                                    <th>
                                                        Fecha
                                                    </th>
                                                    <th>
                                                        Área
                                                    </th>
                                                    <th>
                                                        Firmante
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if ((isset($resolucion['resolucion_relacionadas_modificada']) and count($resolucion['resolucion_relacionadas_modificada']) > 0)) { ?>
                                                    <?php foreach ($resolucion['resolucion_relacionadas_modificada'] as $k => $resolucion_modificada) {  ?>
                                                        <tr>
                                                            <td class="col-md-1">Modificado Por</td>
                                                            <td class="col-md-3">
                                                                <input type="hidden" name="resolucion_relacionadas_modificada[][resolucion_modificadora_id]" value="<?php echo $resolucion_modificada['resolucion_modificadora_id'] ?>">
                                                                <?php echo $resolucion_modificada['resolucion_modificada']['documento_tipo']['descripcion'] ?>
                                                            </td>
                                                            <td>
                                                                <span class="badge ">
                                                                    <?php echo $resolucion_modificada['resolucion_modificada']['numero'] . "/" . $resolucion_modificada['resolucion_modificada']['anio'] ?>
                                                                </span>
                                                            </td>
                                                            <td class="col-md-1">
                                                                <?php echo isset($resolucion_modificada['resolucion_modificada']['fecha']) ? $resolucion_modificada['resolucion_modificada']['fecha']->format('d/m/Y')  : ''; ?>
                                                            </td>

                                                            <td class="col-md-1">
                                                                <?php echo isset($resolucion_modificada['resolucion_modificada']['area']['codigo']) ? $resolucion_modificada['resolucion_modificada']['area']['codigo'] : ''; ?>

                                                            </td>
                                                            <td class="col-md-3">

                                                                <?php echo isset($resolucion['cargos_funcionario']['funcionario']['full_name']) ?  $resolucion['cargos_funcionario']['cargo']['descripcion'] . '<br>' . $resolucion['cargos_funcionario']['funcionario']['full_name'] : ''; ?>
                                                            </td>
                                                            <td class="col-md-1"><button class="btn-sm btn-danger eliminar-fila"><span class="glyphicon glyphicon-remove"></span></button></td>
                                                        </tr>
                                                    <?php } ?>
                                                <?php } ?>
                                                <?php if ((isset($resolucion['resolucion_relacionadas_modificadora']) and count($resolucion['resolucion_relacionadas_modificadora']) > 0)) { ?>
                                                    <?php foreach ($resolucion['resolucion_relacionadas_modificadora'] as $k => $resolucion_modificadora) {  ?>
                                                        <tr>
                                                            <td class="col-md-1">Modificada a</td>
                                                            <td class="col-md-3">
                                                                <input type="hidden" name="resolucion_relacionadas_modificadora[][resolucion_modificada_id]" value="<?php echo $resolucion_modificadora['resolucion_modificada_id'] ?>">
                                                                <?php echo $resolucion_modificadora['resolucion_modificadora']['documento_tipo']['descripcion'] ?>
                                                            </td>
                                                            <td>
                                                                <span class="badge ">
                                                                    <?php echo $resolucion_modificadora['resolucion_modificadora']['numero'] . "/" . $resolucion_modificadora['resolucion_modificadora']['anio'] ?>
                                                                </span>
                                                            </td>
                                                            <td class="col-md-1">
                                                                <?php echo isset($resolucion_modificadora['resolucion_modificadora']['fecha']) ? $resolucion_modificadora['resolucion_modificadora']['fecha']->format('d/m/Y')   : ''; ?>
                                                            </td>
                                                            <td class="col-md-1">
                                                                <?php echo $resolucion_modificadora['resolucion_modificadora']['area']['codigo'] ?>
                                                            </td>
                                                            <td class="col-md-3">
                                                                <?php echo isset($resolucion['cargos_funcionario']['funcionario']['full_name']) ? $resolucion['cargos_funcionario']['funcionario']['full_name'] : ''; ?>
                                                            </td>
                                                            <td class="col-md-1"><button class="btn-sm btn-danger eliminar-fila"><span class="glyphicon glyphicon-remove"></span></button></td>
                                                        </tr>
                                                    <?php } ?>
                                                <?php } ?>

                                            </tbody>
                                        <?php } ?>
                                    </table>
                                </div>
                            </div>
                            <?php
                           
                            if ($this->request->getSession()->check('previousUrl')) {
                                $url = $this->request->getSession()->read('previousUrl');
                                if (strpos($url, "resoluciones/index") !== false or strpos($url, "Resoluciones/index") !== false) {
                                    $url = $this->request->getSession()->read('previousUrl');
                                } else {
                                    $url = "/resoluciones/index/";
                                }
                            } else {
                                $url = '/resoluciones/index';
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
    $('.remove-file').click(function(e) {
        e.preventDefault(); // Previene la acción predeterminada del evento (por ejemplo, seguir un enlace).

        var idArchivo = $(this).data('id'); // Obtiene el valor del atributo 'data-id' del elemento clicado.
        var id = $(this).attr('id'); // Obtiene el valor del atributo 'id' del elemento clicado.

        // Establece el valor del input con name="attachments[delete][id]" al idArchivo.
        $('input[name="delete[' + id + ']"]').val(idArchivo);

        // Remueve el elemento con el id correspondiente dentro de '.MultiFile-label'.
        $('.MultiFile-label #' + id).remove();

        // Remueve el span con el id correspondiente dentro de '.MultiFile-label'.
        $('.MultiFile-label span#' + id).remove();

        return false; // Evita el comportamiento predeterminado adicional.
    });


    // document.getElementById("attachments").addEventListener("change", function() {
    //     document.getElementById("linkDescarga").style.display = "none";
    //     document.getElementById("file").style.display = "block";
    // });
    // Obtener el formulario
    const formulario = document.getElementById('ResolucionesEditForm');

    // Función para enviar el formulario
    function enviarFormulario() {
        const formulario = document.getElementById('ResolucionesEditForm');
        // Obtener todos los campos del formulario
        const campos = formulario.querySelectorAll('input, select, textarea');

        campos.forEach(campo => {
            // Restaurar el atributo required si estaba presente inicialmente
            if (campo.dataset.required === 'true') {
                campo.setAttribute('required', true);
            }
        });

        verificaDocumentoConjunto();
    }

    function verificaDocumentoConjunto() {
        // Obtener el valor del elemento con el id 'modifica_complementa'
        const valor = document.getElementById('modifica_complementa').value
        // Obtener el div  'documento_conjunto'
        const divDocumentoConjunto = document.getElementById('documento_conjunto')
        // Verificar si el valor es '1' y mostrar u ocultar documento_conjunto en consecuencia
        if (valor === '1') {
            divDocumentoConjunto.style.display = 'block'
        } else {
            divDocumentoConjunto.style.display = 'none'
            document.getElementById('nro_organismo').value = ''
            document.getElementById('organismo_id').selectedIndex = 0
        }
    }

    $(document).ready(function() {
        verificaDocumentoConjunto();

        // Obtener todos los elementos input de tipo file
        const inputFiles = document.querySelectorAll('input[type="file"]');

        // Iterar sobre cada elemento input file
        document.querySelectorAll('input[type="file"]').forEach(input => {
            // Agregar un event listener 'change' a cada elemento
            input.addEventListener('change', function() {
                // Obtener el valor del input file
                var t = this.value;
                // Extraer el nombre del archivo de la ruta
                var labelText = 'Archivo : ' + t.substr(12, t.length);
                // Asignar el nombre del archivo al input con id 'file'
                document.getElementById('file').value = labelText;
            });
        });

        document.getElementById('modifica_complementa').addEventListener('change', function() {
            verificaDocumentoConjunto()
        });

        var selectElement = document.getElementById('documento_tipo_id');
        var event = new Event('change');
        selectElement.dispatchEvent(event);
        selectElement.addEventListener('change', function() {
            var selectedOption = this.value;

            var options = {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest' // Aquí agregamos el encabezado personalizado
                }
            };

            fetch('/resoluciones/buscarFuncionariosPorDocumentoTipo/' + selectedOption, options)
                .then(response => response.json()) // Parsea la respuesta JSON
                .then(data => {
                    // Limpia el select antes de agregar nuevas opciones
                    document.getElementById('cargo_firmante').innerHTML = '';

                    if (data.length > 0) {
                        let optionEmpty = document.createElement('option');
                        //console.log(funcionario)
                        optionEmpty.value = 0
                        optionEmpty.text = "Seleccione un firmante"
                        document.getElementById('cargo_firmante').appendChild(optionEmpty);
                        data.forEach(funcionario => {
                            let option = document.createElement('option');
                            option.value = funcionario.id;
                            option.text = funcionario.full_name;
                            document.getElementById('cargo_firmante').appendChild(option);
                        });
                    } else {
                        let optionEmpty = document.createElement('option');
                        optionEmpty.value = ""
                        optionEmpty.text = "Tipo de Documento sin firmantes asociados"
                        document.getElementById('cargo_firmante').appendChild(optionEmpty)

                    }

                })
                .catch(error => {
                    //mostrar popup con vista de login
                    $('#loginContent').load('/login', function(response, status, xhr) {
                        if (status == 'error') {
                            console.error('Error al cargar la vista de login:', xhr.status, xhr.statusText);
                            // Manejar el error aquí
                        } else {
                            // Mostrar el modal después de cargar la vista de login
                            $('#loginModal').modal('show');
                        }
                    });
                });
        });



        // Obtener todos los botones de eliminar
        var botonesEliminar = document.querySelectorAll('.eliminar-fila');

        // Iterar sobre cada botón de eliminar y agregar un evento de clic
        botonesEliminar.forEach(function(boton) {
            boton.addEventListener('click', function() {
                // Obtener la fila a eliminar (el padre del padre del botón, es decir, la fila)
                var fila = this.parentNode.parentNode;
                // Eliminar la fila de la tabla
                fila.remove();
            });
        });

        $('#btnBuscarResolucion').on('click', function(e) {
            // Cargar el contenido de buscarResolucionAsociada.php
            //abrirPopup();
            e.preventDefault();

            $.get('<?php echo $this->Url->build(['controller' => 'Resoluciones', 'action' => 'buscarResolucionAsociada/' . $resolucion['id']]); ?>', function(data) {
                // Crear un modal o popup y mostrar el contenido
                var modalResolucion = $('<div id="modalBuscarResolucion">' + data + '</div>');
                modalResolucion.dialog({
                    title: 'Buscar Resolución Asociada',
                    modal: true,
                    width: 1100,
                    close: function(event, ui) {
                        $(this).dialog('destroy').remove();
                    }
                });
                // Manejar el envío del formulario por AJAX
                modalResolucion.find('#formOrderFilter').on('submit', function(event) {
                    event.preventDefault(); // Evita la acción predeterminada del formulario

                    // Realizar la búsqueda por AJAX
                    $.ajax({
                        url: $(this).attr('action'),
                        method: $(this).attr('method'),
                        data: $(this).serialize(), // Serializa los datos del formulario
                        success: function(response) {
                            // Mostrar los resultados de la búsqueda dentro del popup
                            modalResolucion.find('#listadoResoluciones').html(response);
                            // console.log(response)
                        }
                    });
                });
            });
        });

    });
</script>
<?php echo $this->Html->css('AdminLTE./plugins/bootstrap-daterangepicker/daterangepicker', ['block' => 'css']); ?>
<?php echo $this->Html->script('AdminLTE./plugins/moment/min/moment.min', ['block' => 'script']); ?>
<?php echo $this->Html->script('AdminLTE./plugins/bootstrap-daterangepicker/daterangepicker', ['block' => 'script']); ?>
<!-- 