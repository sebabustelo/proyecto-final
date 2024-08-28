<!-- Main content -->
<section id="RbacUsuariosList" class="content">
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

					<?php				
					$this->DiticHtml->addFilter(
						'apellido',
						[
							'label'    => false,
							'placeholder'    => 'Apellido',
							'class' => 'form-control',
							'templates' => [
								'inputContainer' => '<div class="form-group col-md-4">{{content}}</div>'
							],
							'value' => (isset($filters['apellido'])) ? $filters['apellido'] : ''
							// 'div'	=> false
						]
					);
					$this->DiticHtml->addFilter(
						'nombre',
						[
							'label'    => false,
							'placeholder'    => 'Nombre',

							'class' => 'form-control',
							'templates' => [
								'inputContainer' => '<div class="form-group col-md-4">{{content}}</div>'
							],
							'value' => (isset($filters['nombre'])) ? $filters['nombre'] : ''

							// 'div'	=> false
						]
					);
					$this->DiticHtml->addFilter(
						'usuario',
						[
							'label'    => false,
							'placeholder'    => 'Usuario',
							'class' => 'form-control',
							'templates' => [
								'inputContainer' => '<div class="form-group col-md-2">{{content}}</div>'
							],
							'value' => (isset($filters['usuario'])) ? $filters['usuario'] : ''
							// 'div'	=> false
						]
					);
					$options['class'] = 'col-sm-2';
					$options['checked'] =  (!isset($filters['activo'])) ? 'checked' : (($filters['activo']) ? 'checked' : '');
					$options['style'] = "";

					$this->DiticHtml->addFilterElement(
						'custom_fields/checkbox',
						[
							'type' => 'checkbox',
							'class' => 'form-control',
							'options' => $options,
						]
					);
					echo $this->DiticHtml->showFilter();
					?>


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
					<h3 class="box-title"> <span class="fa fa-users fa-lg"></span> Usuarios</h3>
					<div class="box-tools pull-right">
						<?php if (!empty($accionesPermitidas['rbac_usuarios']['agregar'])) { ?>
							<a href="/usuarios/agregar/" id="agregarUsuario" class="btn btn-primary ">
								<span class="glyphicon glyphicon-plus-sign"></span> <span class="buttonText">Nuevo Usuario</span></a>
						<?php } ?>
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="table-responsive">
						<?php
						if (isset($rbacUsuarios) and count($rbacUsuarios) > 0) {
							$this->DiticHtml->generateReportTable(
								$rbacUsuarios,
								array(
									'RbacUsuario.apellido'              => array('truncate',  'title' => 'Apellido'),
									'RbacUsuario.nombre'              => array('truncate', 'title' => 'Nombre'),
									'RbacUsuario.usuario'              => array('truncate',  'title' => 'Usuario'),
									'RbacUsuario.perfil_default.descripcion'              => array('truncate', 'no-sort', 'title' => 'Perfil default'),
									'RbacUsuario.rbac_perfiles.descripcion'              => array('truncate', 'no-sort', 'title' => 'Perfiles'),
									'edit'                          => array(
										'no-sort',
										'edit-action' => 'editar',
										'tooltip'       => 'Editar',
										'class' => 'pencil'
									),
									'delete'                        => array(
										'confirm'       => '¿Está seguro de que quiere borrar el Usuario?',
										'tooltip'       => 'Eliminar',
										'class'         => 'remove'
									)
								)
							);
						} else {
						?>
							<div class="panel-body text-center ">
								<span class="label label-danger  col-md-12"> <i class="fa fa-times-circle" aria-hidden="true"></i>No se encontraron resultados que coincidan con el criterio de búsqueda.</span>
							</div>
						<?php } ?>


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
<!-- /.content -->
<script type="text/javascript">
	$(document).ready(function() {

		/*$("#agregarUsuario").on("click", function(event) {
		  //$(".table-ajax").loading();

		  window.history.pushState("object or string", "Paginacion", $(this).attr("href"));
		  event.preventDefault();
		  fetch($(this).attr("href"), {
		      method: "GET",
		      headers: {
		        "X-Requested-With": "XMLHttpRequest"
		      }
		    })
		    .then(response => response.text())
		    .then((response) => {
		      jQuery("#accordion").hide();
		      jQuery("#RbacUsuariosList").html(response);
		      //console.log(response)
		    })
		    .catch(function(err) {
		      console.log(err);
		      fetch("https://cake5-rbac.local/rbac/rbac_usuarios/login", {
		          method: "GET",
		          headers: {
		            "X-Requested-With": "XMLHttpRequest"
		          }
		        })
		        .then((response) => response.text())
		        .then((response) => {
		          jQuery("#divDialog").html(response)
		          $("#myModal").modal("show")
		        })


		    });



		});*/
		if (window.location.pathname.split("/")[3] == "agregar") {
			$("#agregarUsuario").click()
		}

	});
</script>