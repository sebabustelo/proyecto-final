<?php

use Cake\Core\Configure;
?>
<section class="content-header">
    <h1>
        <i class="fa fa-database"></i> Consultas DB
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dot-circle-o"></i>Categorías</a></li>
        <i class="fa fa-arrow-right"></i>
        <li class="active">Listado</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"> <span class="fa fa-list"></span> Configure la consulta</h3>
                    <div class="box-tools pull-right">
                        <?php if (!empty($accionesPermitidas['Categorias']['add'])) { ?>
                            <a title="Agregar categoría" href="/Categorias/add/" id="agregarUsuario" class="btn btn-primary btn-sm ">
                                <span class="glyphicon glyphicon-plus-sign"></span> <span class="buttonText hidden-xs">Nueva Categoría</span>
                            </a>
                        <?php } ?>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <?php
                    $session = $this->getRequest()->getSession();
                    $accionesPermitidas = @$session->read('permitidas');
                    ?>
                    
                    <span id="mensajes"></span>
                    <style>
                        .infoCell {
                            word-wrap: break-word;
                            word-break: break-all;
                        }
                    </style>
                    <br />
                    <form action="" method="post">
                        <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getAttribute('csrfToken'); ?>">
                        
                        <!-- Opción para elegir cómo armar la consulta -->
                        <div class="row">
                            <div class="col-xs-12">
                                <label class="control-label">¿Cómo desea armar la consulta?</label>
                                <select id="modoConsulta" class="form-control" onchange="toggleConsultaMode()">
                                    <option value="asistente">Con Asistente</option>
                                    <option value="manual">Manual</option>
                                </select>
                            </div>
                        </div>
                        <br />

                        <!-- Formulario asistente -->
                        <div id="formAsistente">
                            <div class="row">
                                <div class="col-xs-4">
                                    <label class="control-label">Conector</label>
                                    <select name="conector" class="form-control">
                                        <?php
                                        foreach ($conectores as $conector => $nombre) {
                                            echo '<option value="' . $nombre . '">' . $nombre . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-xs-4">
                                    <label class="control-label">Operación:</label>
                                    <select name="operacion" class="form-control" id="operacion">
                                        <option value="select">SELECT</option>
                                        <option value="insert">INSERT</option>
                                        <option value="update">UPDATE</option>
                                        <option value="delete">DELETE</option>
                                    </select>
                                </div>
                                <div class="col-xs-4">
                                    <label class="control-label">Tabla</label>
                                    <select name="tabla" class="form-control">
                                        <?php foreach ($tablas as $k => $tabla) { ?>
                                            <option value="<?php echo $tabla ?>"><?php echo $tabla ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row" id="selectRow">
                                <div class="col-xs-4">
                                    <label class="control-label">Desde ID</label>
                                    <input type="text" name="desdeID" class="form-control">
                                </div>
                                <div class="col-xs-4">
                                    <label class="control-label">Limite</label>
                                    <input type="text" name="limite" class="form-control">
                                </div>
                                <div class="col-xs-4">
                                    <label class="control-label">Formato</label>
                                    <select name="formato" class="form-control">
                                        <option value="json">JSON</option>
                                        <option value="sql">SQL</option>
                                        <option value="pretty">Pretty JSON</option>
                                        <option value="csv">CSV</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row" id="insertRow" style="display: none">
                                <div class="col-xs-6">
                                    <label class="control-label">Campos</label>
                                    <input type="text" name="camposInsert" class="form-control">
                                </div>
                                <div class="col-xs-6">
                                    <label class="control-label">Valores</label>
                                    <input type="text" name="valoresInsert" class="form-control">
                                </div>
                            </div>
                            <div class="row" id="deleteRow" style="display:none">
                                <div class="col-xs-6">
                                    <label class="control-label">ID de registro a eliminar</label>
                                    <input type="text" name="id2Delete" class="form-control">
                                </div>
                            </div>
                            <div class="row" id="updateRow" style="display: none">
                                <div class="col-xs-4">
                                    <label class="control-label">ID de registro a actualizar</label>
                                    <input type="text" name="Id2Update" class="form-control">
                                </div>
                                <div class="col-xs-4">
                                    <label class="control-label">Campos</label>
                                    <input type="text" name="camposUpdate" class="form-control">
                                </div>
                                <div class="col-xs-4">
                                    <label class="control-label">Valores</label>
                                    <input type="text" name="valoresUpdate" class="form-control">
                                </div>
                            </div>
                        </div>

                        <!-- Textarea para consulta manual -->
                        <div id="formManual" style="display: none;">
                            <div class="row">
                                <div class="col-xs-12">
                                    <label class="control-label">Ingrese su consulta SQL:</label>
                                    <textarea name="consultaManual" class="form-control" rows="5"></textarea>
                                </div>
                            </div>
                        </div>

                        <br />
                        <div class="row text-center">
                            <input type="submit" value="ENVIAR CONSULTA" class="btn btn-primary">
                        </div>
                    </form>
                    <hr /><br />
                    <div class="alert alert-info">
                        <H4>AYUDA</H4>
                        <strong>Para operaciones de UPDATE E INSERT:</strong> Los campos y los valores deben ir separados por doble coma y sin utilizar comillas. Ejemplo de campos: nombre,,apellido. Ejemplo de valores: John,,Doe<br />
                        <strong>UNDO EN UN CLICK:</strong> Disponible para operaciones de UPDATE, INSERT Y DELETE<br />
                        <strong>HISTORIAL DE CONSULTAS:</strong> Registra operaciones UPDATE, DELETE E INSERT. (NO registra SELECT)
                        <?php
                        if (!empty($filesHistorial)) {
                            echo '<hr /><H4>HISTORIALES ARCHIVADOS</h4><p>A medida que el historial crece se recomienda ir archivando los registros para mantener una mejor experiencia. El listado de historiales archivados se listan aquí mismo para su consulta.</p><br />';
                            foreach ($filesHistorial as $fileHisto) {
                                echo '<a href="/db/index/historial__' . basename($fileHisto) . '">' . basename($fileHisto) . '</a><br />';
                            }
                        }
                        ?>
                    </div>
                    <hr />
                    <h3>Historial en el archivo: <?php echo $fileHistorial; ?></h3><br />
                    <p align="center"><a href="/db/index/archivar" class="btn btn-primary">Archivar Historial Actual</a></p>
                    <?php
                    if (!empty($listado) && count($listado)) {
                    ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover dataTable" id="tabla">
                                <thead>
                                    <tr>
                                        <th class="sorting_asc"><a href="/db?sort=fecha&amp;direction=des">Fecha</a></th>
                                        <th>Usuario</th>
                                        <th>IP</th>
                                        <th>CONECTOR</th>
                                        <th>Query</th>
                                        <th>Undo Query</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($listado as $registro) {
                                    $undoBT = 'No disponible';
                                    if ($registro["undoQuery"] != '') {
                                        if (!$verArchivado) {
                                            $undoBT = '<a href="/db/index/' . $registro['id'] . '" alt="Ejecutar undo">Undo</a>';
                                        }
                                    }
                                    echo '<tr>
                                            <td>' . h($registro['fecha']) . '</td>
                                            <td>' . h($registro['usuario']) . '</td>
                                            <td>' . h($registro['ip']) . '</td>
                                            <td>' . h($registro['conector']) . '</td>
                                            <td>' . h($registro['query']) . '</td>
                                            <td>' . $undoBT . '</td>
                                          </tr>';
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    <?php
                    } else {
                        echo '<div class="alert alert-warning">No hay registros en el historial.</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function toggleConsultaMode() {
        var modo = document.getElementById("modoConsulta").value;
        if (modo === "asistente") {
            document.getElementById("formAsistente").style.display = "block";
            document.getElementById("formManual").style.display = "none";
        } else {
            document.getElementById("formAsistente").style.display = "none";
            document.getElementById("formManual").style.display = "block";
        }
    }
</script>
