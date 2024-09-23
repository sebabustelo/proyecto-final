<?php

use Cake\Core\Configure;
?>
<section class="content-header">
    <h1>
        <i class="fa fa-database"></i> Consultas DB
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dot-circle-o"></i>Db</a></li>
        <i class="fa fa-arrow-right"></i>
        <li class="active">Consulta</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"> <span class="fa fa-list"></span> Configure la consulta</h3>

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
                                    <textarea id="consultaManual" name="consultaManual"  class="form-control" rows="5" cols="50" oninput="mostrarSugerencias(event)"></textarea>

                                    <div id="sugerencias" style="border: 1px solid #ccc; display: none;"></div>
                                </div>
                            </div>
                        </div>
                        <div id="resultadoSQL"></div>
                        <br />
                        <div class="row text-center">
                            <input type="submit" value="ENVIAR CONSULTA" class="btn btn-primary">
                        </div>
                    </form>
                    <hr />
                    <?php
                    //debug($resultados);
                    if (isset($resultados) && !empty($resultados)) : ?>
                        <h3>Resultados de la consulta</h3>
                        <?php if (is_array($resultados) && isset($resultados[0]) && is_array($resultados[0])) : ?>
                            <!-- Si los resultados son un array asociativo (por ejemplo, de una consulta SELECT) -->
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <?php foreach (array_keys($resultados[0]) as $header) : ?>
                                                <th><?php echo h($header); ?></th>
                                            <?php endforeach; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($resultados as $fila) : ?>
                                            <tr>
                                                <?php foreach ($fila as $dato) : ?>
                                                    <td class="infoCell"><?php echo h($dato); ?></td>
                                                <?php endforeach; ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else : ?>
                            <!-- Si es una consulta que no devuelve filas (por ejemplo, INSERT, UPDATE o DELETE) -->
                            <div class="alert alert-success">
                                <strong>Consulta ejecutada con éxito.</strong> Filas afectadas: <?php echo h($resultados); ?>
                            </div>
                        <?php endif; ?>
                    <?php elseif (isset($resultados) && $resultados === false) : ?>
                        <!-- Si hubo un error en la ejecución de la consulta -->
                        <div class="alert alert-danger">
                            <strong>Error:</strong> No se pudo ejecutar la consulta.
                        </div>
                    <?php endif; ?>

                    <hr /><br />
                    <!-- <div class="alert alert-info">
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

                </div> -->
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
<script>
    const palabrasClave = [
        "SELECT", "FROM", "WHERE", "JOIN", "ON", "INSERT INTO", "VALUES",
        "UPDATE", "SET", "DELETE FROM", "CREATE TABLE", "DROP TABLE",
        "ALTER TABLE", "TRUNCATE TABLE", "AND", "OR", "NOT", "LIKE", "BETWEEN",
        "IN", "ORDER BY", "GROUP BY"
    ];

    function mostrarSugerencias(event) {
        const input = event.target.value;
        const sugerenciasDiv = document.getElementById("sugerencias");
        const resultadoDiv = document.getElementById("resultado");

        sugerenciasDiv.innerHTML = "";

        // Validar sintaxis
        validarSintaxisSQL(input);

        if (!input) {
            sugerenciasDiv.style.display = "none";
            return;
        }

        const coincidencias = palabrasClave.filter(palabra =>
            palabra.toLowerCase().startsWith(input.toLowerCase())
        );

        if (coincidencias.length > 0) {
            sugerenciasDiv.style.display = "block";
            coincidencias.forEach(palabra => {
                const item = document.createElement("div");
                item.textContent = palabra;
                item.onclick = () => seleccionarSugerencia(palabra);
                sugerenciasDiv.appendChild(item);
            });
        } else {
            sugerenciasDiv.style.display = "none";
        }
    }

    function seleccionarSugerencia(palabra) {
        const textarea = document.getElementById("consultaManual");
        textarea.value += (textarea.value ? " " : "") + palabra + " ";
        document.getElementById("sugerencias").style.display = "none";
        textarea.focus();
        validarSintaxisSQL(textarea.value); // Validar después de agregar la sugerencia
    }

    function validarSintaxisSQL(sql) {
        const resultadoDiv = document.getElementById("resultadoSQL");

        // Expresión regular avanzada con soporte para JOIN
        const sqlRegex = /^(SELECT|INSERT\s+INTO|UPDATE|DELETE\s+FROM|CREATE\s+(TABLE|DATABASE)|DROP\s+(TABLE|DATABASE)|ALTER\s+TABLE|TRUNCATE\s+TABLE)\s+[\s\S]+(JOIN\s+[\s\S]+\s+ON\s+[\s\S]+)?;?$/i;

        if (sql && sqlRegex.test(sql)) {
            resultadoDiv.textContent = "Consulta SQL válida.";
            resultadoDiv.style.color = "green";
        } else {
            resultadoDiv.textContent = "Error de sintaxis: La consulta no tiene el formato correcto.";
            resultadoDiv.style.color = "red";
        }
    }
</script>
