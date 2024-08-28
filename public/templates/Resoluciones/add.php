<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Resolucione $resolucione
 * @var \Cake\Collection\CollectionInterface|string[] $documentoTipos
 * @var \Cake\Collection\CollectionInterface|string[] $palabrasClave
 */
?>
<section id="ResolucionAdd" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header  with-border">
                    <h3 class="box-title"> <span class="fa fa-file fa-lg"></span> Nuevo Registro</h3>
                    <div class="box-tools pull-right">
                        <a href="/resoluciones/index/" id="agregarArea" class="btn btn-primary ">
                            <span class="fa fa-list"></span> Registros</a>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-row">
                        <form id="ResolucionesAddForm" name="ResolucionesAddForm" role="form" enctype="multipart/form-data" action="/resoluciones/add" method="POST">
                            <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getAttribute('csrfToken'); ?>">
                            <div class="form-group  col-sm-5">
                                <label for="titulo">Título</label>
                                <input type="text" name="titulo" required id="titulo" oninvalid="this.setCustomValidity('Complete el Título')" oninput="this.setCustomValidity('')" class="form-control" value="<?php echo (!is_null($this->request->getData('titulo')) ? $this->request->getData('titulo') : ''); ?>" maxlength="200">
                            </div>
                            <div class="form-group  col-sm-3">
                                <label for="expediente">Expediente</label>
                                <input type="text" name="expediente" id="expediente" class="form-control" value="<?php echo (!is_null($this->request->getData('expediente')) ? $this->request->getData('expediente') : ''); ?>">
                            </div>
                            <div class="form-group  col-sm-2">
                                <label for="proyecto">Proyecto</label>
                                <input type="text" name="proyecto" id="proyecto" class="form-control" value="<?php echo (!is_null($this->request->getData('proyecto')) ? $this->request->getData('proyecto') : ''); ?>">
                            </div>
                            <div class="form-group  col-sm-1">
                                <label for="numero">Número</label>
                                <input type="text" name="numero" required id="numero" oninvalid="this.setCustomValidity('Complete el número')" oninput="this.setCustomValidity('')" class="form-control" maxlength="20" value="<?php echo (!is_null($this->request->getData('numero')) ? $this->request->getData('numero') : ''); ?>">
                            </div>
                            <div class="form-group  col-sm-1">
                                <label for="anio">Año</label>
                                <select name="anio" class="form-control">
                                    <?php
                                    $anio_actual = date("Y");
                                    $anio_inicial = 1990;

                                    // Iterar desde el año inicial hasta el año actual
                                    for ($anio = $anio_actual; $anio >= $anio_inicial; $anio--) { ?>

                                        <?php if ($anio ==   (!is_null($this->request->getData('anio')) ? $this->request->getData('anio') : '')) { ?>
                                            <option value="<?php echo $anio ?>" selected><?php echo $anio ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $anio ?>"><?php echo $anio ?></option>
                                    <?php }
                                    }
                                    ?>
                                </select>

                            </div>
                            <div class="form-group  col-sm-2">
                                <label for="fecha">Fecha</label>
                                <input type="date" name="fecha" required id="fecha" class="form-control" value="<?php echo (!is_null($this->request->getData('fecha')) ? $this->request->getData('fecha') : ''); ?>">
                            </div>     
                            <div class="form-group  col-sm-3">
                                <label for="area_id">Área de Origen</label>
                                <select name="area_id" required id="codigo" class="form-control">
                                    <option value="">Selecione un Área</option>
                                    <?php foreach ($areas as $key => $value) { ?>
                                        <?php if ($key ==  (!is_null($this->request->getData('area_id')) ? $this->request->getData('area_id') : '')) { ?>
                                            <option value="<?php echo $key ?>" selected><?php echo $value ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $key ?>"><?php echo $value ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>                                              
                            <div class="form-group  col-sm-3">
                                <label for="documento_tipo_id">Tipo de Documento</label>
                                <?php $documentoTiposId = (!is_null($this->request->getData('documento_tipo_id')) ? $this->request->getData('documento_tipo_id') : '');  ?>
                                <select type="text" name="documento_tipo_id" required id="documento_tipo_id" class="form-control">
                                    <option value="">Selecione un Documento</option>
                                    <?php foreach ($documentoTipos as $key => $value) { ?>
                                        <?php if ($key ==  $documentoTiposId) { ?>
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
                                    <?php
                                    if (isset($funcionarios)) {
                                        foreach ($funcionarios as $key => $value) { ?>
                                            <?php if ($key ==  (!is_null($this->request->getData('cargo_firmante')) ? $this->request->getData('cargo_firmante') : '')) { ?>
                                                <option value="<?php echo $key ?>" selected><?php echo $value ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $key ?>"><?php echo $value ?></option>
                                            <?php } ?>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group  col-sm-2">
                                <label>Es documento conjunto</label>
                                <select name="modifica_complementa" id="modifica_complementa" class="form-control">
                                    <option value="0">No</option>
                                    <option value="1">Sí</option>
                                </select>
                            </div>
                            <div id="documento_conjunto" style="display: none;">
                                <div class="form-group  col-sm-2 ">
                                    <label for="numero">Número</label>
                                    <input type="text" name="nro_organismo" id="nro_organismo" class="form-control" value="">
                                </div>
                                <div class="form-group  col-sm-8 ">
                                    <label for="organismo">Organismo</label>
                                    <select name="organismo_id" id="organismo_id" class="form-control">
                                        <option value="">Selecione un Organismo</option>
                                        <?php foreach ($organismos as $key => $value) { ?>
                                            <option value="<?php echo $key ?>"><?php echo $value ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <?php
                            $palabrasClaveIds = !is_null($this->request->getData('palabras_clave')) ? $this->request->getData('palabras_clave')['_ids'] : [];
                            $options['empty'] = 'Seleccione la/s Palabra/s ';
                            $options['name'] = 'palabras_clave';
                            $options['id'] = 'palabras_clave';
                            $options['list'] = $palabrasClaves;
                            $options['selected'] = $palabrasClaveIds;
                            $options['numberDisplayed'] = 4;
                            $options['title'] = 'Palabra/s Clave/s';
                            $options['class'] = 'col-sm-12';
                            echo $this->element('custom_fields/multiselect', [
                                'options' => $options,
                            ]);
                            ?>

                            <!-- <div class="form-group col-sm-11 input-group" style="float: left;margin-left: 14px;">
                                <input readonly id="documento_file" class=" form-control" type="text" />
                                <div class="input-group-btn">
                                    <label for="attachments" class="btn btn-default"><i class="fa fa-book"></i> Documento Escaneados</label>
                                    <input id="attachments" type="file" accept="application/pdf" name="attachments" class="btn btn-default" style="display: none;" />
                                </div>
                            </div> -->

                            <!-- <div class="form-group col-sm-12">

                                <input id="attachments" type="file" class="multi" multiple accept="application/pdf" name="attachments[]" />

                            </div> -->
                            <div class="form-group col-sm-12">
                                <span class="btn btn-default btn-file">
                                    <i class="fa fa-cloud-upload"></i> Subir archivo <input id="attachments" type="file" class="multi" multiple accept="application/pdf" name="attachments[]" />
                                </span>
                            </div>


                            <div class="form-group col-sm-11 input-group" style="float: left;margin-left: 14px;">
                                <button class="btn btn-success" id="btnBuscarResolucion" formnovalidate>
                                    <span class="glyphicon glyphicon-search"></span> Resolución Asociada</button>

                            </div>
                            <div class="col-md-12 table">
                                <div class="table-responsive">
                                    <table id="tablaDestino" class="table table-hover table-striped">

                                    </table>
                                </div>
                            </div>


                            <?php
                            if ($this->request->getSession()->check('previousUrl')) {
                                $url = $this->request->getSession()->read('previousUrl');
                                if (strpos($url, "resoluciones") !== false) {
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
    // Obtener el formulario
    const formulario = document.getElementById('ResolucionesAddForm');

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


        // $('input[type=file]').change(function() {
        //     var t = $(this).val();
        //     var labelText = 'Archivo : ' + t.substr(12, t.length);
        //     //$(this).prev('label').text(labelText);
        //     $('#documento_file').val(labelText);
        // })


        // alert("a")
        var event = new Event('change');
        document.getElementById('documento_tipo_id').dispatchEvent(event);
        //const formulario = document.getElementById('ResolucionesAddForm');


        $('#btnBuscarResolucion').on('click', function(e) {
            // Cargar el contenido de buscarResolucionAsociada.php            
            e.preventDefault();
            $.get('<?php echo $this->Url->build(['controller' => 'Resoluciones', 'action' => 'buscarResolucionAsociada']); ?>', function(data) {
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

    $('#modifica_complementa').change(function() {
        verificaDocumentoConjunto();
    });
    var selectElement = document.getElementById('documento_tipo_id');
    var selectedCargoFirmante = <?php echo json_encode($this->request->getData('cargo_firmante')); ?>;

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
                    var optionEmpty = document.createElement('option');

                    optionEmpty.value = 0
                    optionEmpty.text = "Seleccione un firmante"
                    document.getElementById('cargo_firmante').appendChild(optionEmpty);
                    data.forEach(funcionario => {
                        var option = document.createElement('option');

                        option.value = funcionario.id;
                        option.text = funcionario.full_name;
                        document.getElementById('cargo_firmante').appendChild(option);
                    });
                } else {
                    var optionEmpty = document.createElement('option');
                    //console.log(funcionario)
                    optionEmpty.value = ""
                    optionEmpty.text = "Tipo de Documento sin firmantes asociados"
                    document.getElementById('cargo_firmante').appendChild(optionEmpty)

                }
            })
            .catch(error => {
                //mostrar popup con vista de login
                // $('#loginContent').load('/login', function(response, status, xhr) {
                //     if (status == 'error') {
                //         console.error('Error al cargar la vista de login:', xhr.status, xhr.statusText);
                //         // Manejar el error aquí
                //     } else {
                //         // Mostrar el modal después de cargar la vista de login
                //         $('#loginModal').modal('show');
                //     }
                // });
            });
    });
</script>
<?php echo $this->Html->css('AdminLTE./plugins/bootstrap-daterangepicker/daterangepicker', ['block' => 'css']); ?>
<?php echo $this->Html->script('AdminLTE./plugins/moment/min/moment.min', ['block' => 'script']); ?>
<?php echo $this->Html->script('AdminLTE./plugins/bootstrap-daterangepicker/daterangepicker', ['block' => 'script']); ?>
<!-- 