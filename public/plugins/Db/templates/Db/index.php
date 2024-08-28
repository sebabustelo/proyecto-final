<!-- Main content -->
<section id="Db" class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-primary">
				<div class="box-header  with-border">
					<h3 class="box-title"> <span class="fa fa-database fa-lg"></span> Consulta a la Base de Datos</h3>
					<div class="box-tools pull-right">

						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body">

					<form action="" method="post">
						<input type="hidden" name="_csrfToken" value="<?php echo $this->request->getAttribute('csrfToken'); ?>">
						<div class="form-row">
							<div class="form-group col-md-4">
								<label class="control-label">Conector</label>
								<select name="conector" class="form-control">
									<?php
									foreach ($conectores as $conector => $nombre) {
										echo '<option value="' . $nombre . '">' . $nombre . '</option>';
									}
									?>
								</select>
							</div>
							<div class="form-group col-md-4">
								<label class="control-label">Operación:</label>
								<select name="operacion" class="form-control" id="operacion">
									<option value="select">SELECT</option>
									<option value="insert">INSERT</option>
									<option value="update">UPDATE</option>
									<option value="delete">DELETE</option>
								</select>
							</div>
							<div class="form-group col-md-4">
								<label class="control-label">Tabla</label>
								<input type="text" name="tabla" class="form-control">
							</div>
						</div>
						<div class="form-row" id="selectRow">
							<div class="form-group col-md-4">
								<label class="control-label">Desde ID</label>
								<input type="text" name="desdeID" class="form-control">
							</div>
							<div class="form-group col-md-4">
								<label class="control-label">Limite</label>
								<input type="text" name="limite" class="form-control">
							</div>
							<div class="form-group col-md-4">
								<label class="control-label">Formato</label>
								<select name="formato" class="form-control">
									<option value="json">JSON</option>
									<option value="sql">SQL</option>
									<option value="pretty">Pretty JSON</option>
									<option value="csv">CSV</option>
								</select>
							</div>
						</div>
						<div class="form-row" id="insertRow" style="display: none">
							<div class="form-group col-md-6">
								<label class="control-label">Campos</label>
								<input type="text" name="camposInsert" class="form-control">
							</div>
							<div class="form-group col-md-6">
								<label class="control-label">Valores</label>
								<input type="text" name="valoresInsert" class="form-control">
							</div>
						</div>
						<div class="form-row" id="deleteRow" style="display:none">
							<div class="form-group col-md-6">
								<label class="control-label">ID de registro a eliminar</label>
								<input type="text" name="id2Delete" class="form-control">
							</div>
						</div>
						<div class="form-row" id="updateRow" style="display: none">
							<div class="form-group col-md-4">
								<label class="control-label">ID de registro a actualizar</label>
								<input type="text" name="Id2Update" class="form-control">
							</div>
							<div class="form-group col-md-4">
								<label class="control-label">Campos</label>
								<input type="text" name="camposUpdate" class="form-control">
							</div>
							<div class="form-group col-md-4">
								<label class="control-label">Valores</label>
								<input type="text" name="valoresUpdate" class="form-control">
							</div>
						</div>
						
						<div class="text-center form-row">						
							<button type="submit" id="enviar" class="btn btn-primary">
								<span class="glyphicon glyphicon-check"></span>
								Enviar Consulta</button>
								
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
											$undoBT = '<a href="/db/index/' . $registro['id'] . '" alt="Ejecutar" title="Ejecutar" class="confirmation">' . $registro["undoQuery"] . '</a>';
										} else {
											$undoBT = $registro["undoQuery"];
										}
									}
									echo '<tr id="headerTable">';
									echo '<td>' . $registro["fecha"] . '</td>';
									echo '<td>' . $registro["usuario"] . '</td>';
									echo '<td>' . $registro["remote_address"] . '</td>';
									echo '<td>' . $registro["conector"] . '</td>';
									echo '<td style="width: 40%"><div class="infoCell">' . stripslashes($registro["query"]) . '</div></td>';
									echo '<td style="width: 40%"><div class="infoCell">' . stripslashes($undoBT) . '</div></td>';
									echo '</tr>';
								}
								echo '</tbody></table></div><div style="clear:both"></div>';
							} else {
								echo '<div class="centro"><h4>No hay resultados para mostrar</h4></div>';
							}
								?>


						</div>
						<!-- /.box-body -->
				</div>
				<!-- /.box -->
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
</section>




<script>
	$('#operacion').change(function() {
		switch (this.value) {
			case 'select':
				$('#selectRow').show();
				$('#updateRow').hide();
				$('#deleteRow').hide();
				$('#insertRow').hide();
				break;
			case 'update':
				$('#selectRow').hide();
				$('#updateRow').show();
				$('#deleteRow').hide();
				$('#insertRow').hide();
				break;
			case 'delete':
				$('#selectRow').hide();
				$('#updateRow').hide();
				$('#deleteRow').show();
				$('#insertRow').hide();
				break;
			case 'insert':
				$('#selectRow').hide();
				$('#updateRow').hide();
				$('#deleteRow').hide();
				$('#insertRow').show();
				break;
		}
	});

	$('.confirmation').on('click', function() {
		return confirm('Esta seguro?');
	});
</script>