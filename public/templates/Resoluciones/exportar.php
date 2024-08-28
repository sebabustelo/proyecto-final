<?php if ($resoluciones) { ?>
    <Worksheet ss:Name="SINDRE">
        <Table>


            <Column ss:AutoFitWidth="0" ss:Width="150" />
            <Column ss:AutoFitWidth="0" ss:Width="40" />
            <Column ss:AutoFitWidth="0" ss:Width="40" />
            <Column ss:AutoFitWidth="0" ss:Width="80" />
            <Column ss:AutoFitWidth="0" ss:Width="150" />
            <Column ss:AutoFitWidth="0" ss:Width="80" />
            <Column ss:AutoFitWidth="0" ss:Width="400" />
            <Column ss:AutoFitWidth="0" ss:Width="150" />
            <Row>
                <Cell ss:StyleID="TituloColumna"><Data ss:Type="String">Tipo de Documento</Data></Cell>
                <Cell ss:StyleID="TituloColumna"><Data ss:Type="String">Nro</Data></Cell>
                <Cell ss:StyleID="TituloColumna"><Data ss:Type="String">Año</Data></Cell>
                <Cell ss:StyleID="TituloColumna"><Data ss:Type="String">Fecha de firma</Data></Cell>
                <Cell ss:StyleID="TituloColumna"><Data ss:Type="String">Firmante</Data></Cell>
                <Cell ss:StyleID="TituloColumna"><Data ss:Type="String">Area de origen</Data></Cell>
                <Cell ss:StyleID="TituloColumna"><Data ss:Type="String">Título</Data></Cell>
                <Cell ss:StyleID="TituloColumna"><Data ss:Type="String">Palabras clave</Data></Cell>
                <!-- <Cell ss:StyleID="TituloColumna"><Data ss:Type="String">Docum. Relac.</Data></Cell> -->
            </Row>

            <?php
            $i = 0;
            //debug($resoluciones);
            foreach ($resoluciones as $data) {
                if ($i == 0) {
                    $color = 'color1';
                    $i = 1;
                } else {
                    $color = 'color2';
                    $i = 0;
                }
            ?>
                <Row>
                    <Cell ss:StyleID="<?php print $color; ?>"><Data ss:Type="String"><?php print $data['documento_tipo']['descripcion']; ?></Data></Cell>
                    <Cell ss:StyleID="<?php print $color; ?>"><Data ss:Type="String"><?php print intval($data['numero']); ?></Data></Cell>
                    <Cell ss:StyleID="<?php print $color; ?>"><Data ss:Type="String"><?php print intval($data['anio']); ?></Data></Cell>
                    <Cell ss:StyleID="<?php print $color; ?>"><Data ss:Type="String"><?php print $data['fecha']; ?></Data></Cell>
                    <Cell ss:StyleID="<?php print $color; ?>"><Data ss:Type="String"><?php print isset($data['cargos_funcionario']['funcionario']['full_name']) ? $data['cargos_funcionario']['funcionario']['full_name'] : ''; ?></Data></Cell>
                    <Cell ss:StyleID="<?php print $color; ?>"><Data ss:Type="String"><?php print $data['area']['codigo']; ?></Data></Cell>
                    <Cell ss:StyleID="<?php print $color; ?>"><Data ss:Type="String"><?php print $data['titulo']; ?></Data></Cell>
                    <Cell ss:StyleID="<?php print $color; ?>"><Data ss:Type="String"><?php if (isset($data['palabras_clave'])) {
                                                                                            foreach ($data['palabras_clave'] as $k => $v) {
                                                                                                print $v['palabra'] . "\n";
                                                                                            }
                                                                                        }
                                                                                        ?></Data>
                    </Cell>

                    <?php //debug($data); 
                    ?>
                    <!-- <Cell ss:StyleID="<?php print $color; ?>"><Data ss:Type="String">
					<?php if (isset($data['resolucion_relacionadas_modificada']) and count($data['resolucion_relacionadas_modificada']) > 0) {
                    ?>
                        Este documento es complementado o modificado por <?php echo count($data['resolucion_relacionadas_modificada']) ?> documento(s)
                    <?php } else { ?>
                        Este documento no modifica ni complementa a ningún documento
                    <?php } ?>
                    <?php if (isset($data['resolucion_relacionadas_modificadora']) and count($data['resolucion_relacionadas_modificadora']) > 0) {
                    ?>
                        Este documento es complementado o modificado por <?php echo count($data['resolucion_relacionadas_modificadora']) ?> documento(s)
                    <?php } else { ?>
                        Este documento no modifica ni complementa a ningún documento
                    <?php } ?>
                    </Data></Cell> -->
                </Row>
            <?php } ?>
            <!-- <Row>
				<Cell ss:MergeAcross="<?php print $cantidadDeColumnas; ?>" ss:StyleID="PieCuadro">
					<Data ss:Type="String">Pagina <?php //echo $pagina . "/" . $total; 
                                                    ?></Data>
				</Cell>
			</Row>-->
        </Table>
    </Worksheet>
<?php } ?>