<section id="RbacUsuariosAdd" class="content">
    <div class="row">
        <div class="col-xs-12">
        <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-aqua-active" style="background: url('../dist/img/photo1.png') center center;">
              <h3 class="widget-user-username"><?php echo $rbacUsuario->nombre." ".$rbacUsuario->apellido." - ". $rbacUsuario->usuario; ?></h3>
              <h5 class="widget-user-desc"><?php echo $rbacUsuario->rbac_perfil->descripcion; ?></h5>
            </div>
            <div class="widget-user-image">
              <img src="/img/user-profile.png" alt="User Avatar" class="img-circle">            </div>
            <div class="box-footer">
            <br><br><br><br>
              <div class="row">
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-header">Telefóno</h5>
                    <span class="description-text"><?php echo "11-40876458"; ?></span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                  <h5 class="description-header">Dirección</h5>
                    <span class="description-text"><?php echo $rbacUsuario->direccion; ?></span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4">
                  <div class="description-block">
                    <h5 class="description-header">Documento</h5>
                    <span class="description-text"><?php echo $rbacUsuario->tipo_documento->descripcion.":".$rbacUsuario->documento; ?></span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <br><br><br><br><br><br><br><br><br>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
          </div>

           
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
</section>