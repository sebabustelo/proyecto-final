<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Resolucione $resolucione
 */
?>


<section id="AreasAdd" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header  with-border">
                    <h3 class="box-title"> <span class="fa fa-eye fa-lg"></span> Detalle Registro</h3>
                    <div class="box-tools pull-right">
                        <a href="/resoluciones/index" id="agregarArea" class="btn btn-primary ">
                            <span class="fa fa-list"></span> Registros</a>

                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-row">
                        <?php //debug($resolucion); 
                        ?>

                        <div class="  col-sm-12">
                            <label for="documento_tipo_id">Tipo de Documento: </label><span><?php echo $resolucion->documento_tipo->descripcion; ?></span>

                        </div>

                        <div class="  col-sm-12">
                            <label for="numero">Número/Año: </label>
                            <?php echo $resolucion->numero === null ? '' : $this->Number->format($resolucion->numero) . "/" . ($resolucion->anio === null ? '' : $resolucion->anio); ?>
                        </div>
                        <div class="  col-sm-12">
                            <label for="fecha">Fecha: </label>
                            <?php echo $resolucion->fecha === null ? '' : $this->Number->format($resolucion->fecha) . "/" . ($resolucion->anio === null ? '' : $resolucion->anio); ?>
                        </div>
                        <div class="col-sm-12">
                            <label for="area_id">Área: </label>
                            <?php echo $resolucion->area->descripcion; ?>

                        </div>
                        <div class="col-sm-12">
                            <label for="expediente">Expediente: </label>
                            <?php echo $resolucion->expediente === null ? '' : $resolucion->expediente ?>
                        </div>
                        <div class="col-sm-12">
                            <label for="proyecto">Proyecto: </label>
                            <?php echo $resolucion->proyecto === null ? '--' : $resolucion->proyecto ?>
                        </div>

                        <div class="col-sm-12">
                            <label for="titulo">Título: </label>
                            <?php echo $resolucion->titulo === null ? '' : $resolucion->titulo; ?>
                        </div>

                        <?php //debug($resolucion->cargos_funcionario->cargo->descripcion); 
                        ?>
                        <div class="col-sm-12">
                            <label for="cargo_firmante">Firmante: </label>
                            <?php echo isset($resolucion->cargos_funcionario->cargo->descripcion) ? $resolucion->cargos_funcionario->cargo->descripcion : '';
                            echo " / ";
                            echo isset($resolucion->cargos_funcionario->funcionario->full_name) ? $resolucion->cargos_funcionario->funcionario->full_name : '';
                            ?>
                        </div>


                        <div class="col-sm-3">
                            <label>Es documento conjunto</label>

                            <?php if ($resolucion['modifica_complementa']) {
                                echo "Si";
                                $style = "display:block";
                            } else {
                                echo "No";
                                $style = "display:none";
                            }
                            ?>

                        </div>
                        <div id="documento_conjunto" style=<?php echo $style; ?>>
                            <div class="col-sm-2 modifica_complementa">
                                <label for="nro_organismo">Número: </label>
                                <?php echo (isset($resolucion['nro_organismo'])) ? $resolucion['nro_organismo'] : ''; ?>
                            </div>

                            <div style=<?php echo $style; ?> class="form-group  col-sm-6">
                                <label>Organismo: </label>
                                <?php echo (isset($resolucion->organismo->descripcion)) ? $resolucion->organismo->descripcion : '--'; ?>
                            </div>
                        </div>
                        <div class="col-sm-12 ">
                            <label>Palabras Claves: </label>
                            <?php
                            foreach ($resolucion->palabras_clave as $key => $palabras_clave) {
                                echo "[" . $palabras_clave->palabra . "]&nbsp&nbsp&nbsp&nbsp;";
                            }
                            ?>
                        </div>
                        <?php if (!empty($resolucion->uploads)) {
                            $n = 0;
                        ?>
                            <div class="form-group col-sm-12">
                                <div class="btn btn-default">
                                    <label class="btn"> <i class="fa fa-file fa-lg"></i>&nbsp;&nbsp; Archivos Asociados</label><br>
                                    <?php foreach ($resolucion->uploads as $key => $upload) { ?>
                                        <br>
                                        <div style="text-align: left;" class="MultiFile-label">
                                            <input type="hidden" class="borrar_archivo" name="delete[<?php echo $n; ?>]" value="" />
                                            <a id="<?php echo $n; ?>" data-id="<?php echo $upload['id']; ?>" class="remove-file MultiFile-remove  btn-sm btn-danger " href="#">
                                                <span class="glyphicon glyphicon-remove"></span></a>
                                            <span id="<?php echo $n; ?>"><?php echo "<a href='/resoluciones/descargarArchivoPublico/" . $resolucion['id'] . "/" . $upload['id'] . "'> " . $upload['nombre_original'] . "." . $upload['extension_archivo'] . "</a>"; ?>
                                            </span>
                                        </div>
                                    <?php
                                        $n++;
                                    } ?>
                                </div>

                            </div>
                        <?php } ?>
                    </div>
                                 
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
                        if (strpos($url, "resoluciones") !== false) {
                            $url = $this->request->getSession()->read('previousUrl');
                        } else {
                            $url = "/resoluciones/index/";
                        }
                    } else {
                        $url = '/resoluciones/index';
                    }
                    ?>
                    <div class="form-group">
                        <div class=" col-sm-12">
                            <a href="<?php echo $url; ?>" class="btn btn-primary">
                                <span class="glyphicon glyphicon-arrow-left"></span> Volver</a>

                        </div>
                    </div>

                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
    </div>
</section>