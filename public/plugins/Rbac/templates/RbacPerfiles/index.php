<!-- Main content -->
<section class="content-header">
    <h1>
        Administración - Gestión de Permisos
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"></i> Perfiles</a></li> <i class="fa fa-arrow-right"></i>
        <li class="active">Agregar</li>
    </ol>
</section>
<section id="RbacPerfilesList" class="content">
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
          <form method="get" accept-charset="utf-8" class="form abox" id="formOrderFilter" action="/rbac/RbacPerfiles/index">
            <div class="form-row">
              <div class="form-group col-md-12">
                <input type="text" name="descripcion" placeholder="Descripción" class="form-control" id="descripcion" aria-label="Descripcion" value="<?php echo (isset($filters['descripcion'])) ? $filters['descripcion'] : '' ?>">
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
          <h3 class="box-title"> <span class="fa fa-suitcase fa-lg"></span> Perfiles</h3>
          <div class="box-tools pull-right">
            <?php if (!empty($accionesPermitidas['RbacPerfiles']['agregar'])) { ?>
              <a href="/rbac/rbacPerfiles/agregar/" id="agregarUsuario" class="btn btn-primary btn-sm ">
                <span class="glyphicon glyphicon-plus-sign"></span> <span class="buttonText">Nuevo Perfil</span></a>
            <?php } ?>
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">

          <?php //debug($rbacPerfiles);
          ?>

          <?php if (isset($rbacPerfiles)) { ?>
            <div class="table-responsive">
              <table class="table table-hover table-striped table-ajax">
                <thead>
                  <tr>
                    <th>
                      <?php echo $this->Paginator->sort('descripcion', 'Descripción'); ?>
                    </th>
                    <th>
                    </th>
                    <th>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($rbacPerfiles as $k => $perfil) {  ?>
                    <tr>
                      <td>
                        <?php echo $perfil->descripcion; ?>
                      </td>

                      <td class="pencil">
                      <a href="/rbac/RbacPerfiles/editar/<?php echo $perfil->id; ?>" class="editar btn btn-success btn-xs pencil" title="Editar" target="_self"><i class="fa fa-pencil"></i></a>
                      </td>
                      <td class="remove">
                      <a href="/rbac/RbacPerfiles/eliminar/<?php echo $perfil->id; ?>" class="editar btn btn-danger btn-xs pencil" title="Eliminar" target="_self"><i class="fa fa-remove"></i></a>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          <?php } else {
          ?>
            <div class="callout callout-danger">
              <p> <i class="icon fa fa-warning" aria-hidden="true"></i> No se encontraron resultados que coincidan con el criterio de búsqueda.</p>
            </div>
          <?php } ?>
          <?php
          //debug($rbacPerfiles)    ;
          // if (isset($rbacPerfiles)) {
          //   $this->DiticHtml->generateReportTable(
          //     $rbacPerfiles,
          //     array(
          //       'RbacPerfil.descripcion'              => array('truncate', 'sort', 'title' => 'Descripción'),
          //       'RbacPerfil.es_default'              => array('show-status', 'no-sort', 'title' => 'Perfil default'),
          //       'RbacPerfil.permisos_virtual_host.permiso'              => array('truncate', 'no-sort', 'title' => 'Virtual Host'),
          //       'edit'                          => array(
          //         'no-sort',
          //         'edit-action' => 'editar',
          //         'tooltip'       => 'Editar',
          //         'class' => 'pencil'
          //       ),
          //       'eliminar'                        => array(
          //         'confirm'       => '¿Está seguro de que quiere borrar el Perfil?',
          //         'tooltip'       => 'Eliminar',
          //         'class'         => 'remove'
          //       )
          //     )
          //   );
          // }


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
<!-- /.content -->
