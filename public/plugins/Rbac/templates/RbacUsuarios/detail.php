<section id="RbacUsuariosAdd" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-aqua-active">
                    <h3 class="widget-user-username"><?php echo $rbacUsuario->nombre . " " . $rbacUsuario->apellido ; ?></h3>
                    <h5 class="widget-user-desc"><?php echo $rbacUsuario->rbac_perfil->descripcion; ?></h5>
                </div>
                <div class="widget-user-image">
                    <img src="/img/user-profile.png" alt="User Avatar" class="img-circle">
                </div>
                <div class="box-footer">
                    <br><br>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="description-block">
                                <h5 class="description-header">Usuario</h5>
                                <span class="description-text"><?php echo $rbacUsuario->usuario; ?></span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <div class="col-sm-3">
                            <div class="description-block">
                                <h5 class="description-header">Email</h5>
                                <span class="description-text"><?php echo $rbacUsuario->email; ?></span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <div class="col-sm-3">
                            <div class="description-block">
                                <h5 class="description-header">Documento</h5>
                                <span class="description-text"><?php echo $rbacUsuario->tipo_documento->descripcion . ":" . $rbacUsuario->documento; ?></span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <div class="col-sm-3">
                            <div class="description-block">
                                <h5 class="description-header">Celular</h5>
                                <span class="description-text"><?php echo $rbacUsuario->celular; ?></span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <div class="col-sm-3 ">
                            <div class="description-block">
                                <h5 class="description-header">Dirección</h5>
                                <span class="description-text">
                                    <?php if (
                                        !empty($rbacUsuario->direcciones[0]->localidade->provincia->nombre) &&
                                        !empty($rbacUsuario->direcciones[0]->localidade->nombre)
                                    ): ?>
                                        <?php echo $rbacUsuario->direcciones[0]->localidade->provincia->nombre . ", " . $rbacUsuario->direcciones[0]->localidade->nombre; ?><br>
                                    <?php endif; ?>

                                    <?php if (!empty($rbacUsuario->direcciones[0]->calle) && !empty($rbacUsuario->direcciones[0]->numero)): ?>
                                        <?php echo "Calle: " . $rbacUsuario->direcciones[0]->calle . " " . $rbacUsuario->direcciones[0]->numero . " "; ?>
                                    <?php endif; ?>

                                    <?php if (!empty($rbacUsuario->direcciones[0]->piso)): ?>
                                        <?php echo "Piso: " . $rbacUsuario->direcciones[0]->piso . " "; ?>
                                    <?php endif; ?>

                                    <?php if (!empty($rbacUsuario->direcciones[0]->departamento)): ?>
                                        <?php echo "Depto: " . $rbacUsuario->direcciones[0]->departamento; ?>
                                    <?php endif; ?>
                                </span>

                            </div>
                            <!-- /.description-block -->
                        </div>

                        <!-- /.col -->

                        <!-- /.col -->


                        <!-- /.col -->
                    </div>
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <a href="<?php echo $this->Url->build(['controller' => 'RbacUsuarios', 'action' => 'editMyUser']); ?>" class="btn btn-primary">
                                Modificar Datos
                            </a>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
            </div>


            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
</section>
