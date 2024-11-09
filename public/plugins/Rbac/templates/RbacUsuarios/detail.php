<section id="RbacUsuariosAdd" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-aqua-active">
                    <h3 class="widget-user-username">
                        <?php if (!empty($usuario->nombre) or !empty($usuario->apellid)) { ?>
                            <?php echo $usuario->nombre . " " . $usuario->apellido; ?>

                        <?php } else { ?>
                            <?php echo $usuario->razon_social; ?>
                        <?php } ?>

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
                                <h5 class="description-header">
                                    Documento
                                </h5>
                                <span class="description-text">
                                    <?php echo $rbacUsuario->tipo_documento->descripcion . ":" . $rbacUsuario->documento; ?></span>
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
                        <div class="col-sm-12 ">
                            <div class="description-block">
                                <h5 class="description-header">Dirección</h5>
                                <span class="description-text">
                                    <?php if (
                                        !empty($rbacUsuario->direccion->localidade->provincia->nombre) &&
                                        !empty($rbacUsuario->direccion->localidade->nombre)
                                    ): ?>
                                        <?php echo $rbacUsuario->direccion->localidade->provincia->nombre . ", " . $rbacUsuario->direccion->localidade->nombre . " "; ?>
                                    <?php endif; ?>

                                    <?php if (!empty($rbacUsuario->direccion->calle) && !empty($rbacUsuario->direccion->numero)): ?>
                                        <?php echo "Calle: " . $rbacUsuario->direccion->calle . " " . $rbacUsuario->direccion->numero . " "; ?>
                                    <?php endif; ?>

                                    <?php if (!empty($rbacUsuario->direccion->piso)): ?>
                                        <?php echo "Piso: " . $rbacUsuario->direccion->piso . " "; ?>
                                    <?php endif; ?>

                                    <?php if (!empty($rbacUsuario->direccion->departamento)): ?>
                                        <?php echo "Depto: " . $rbacUsuario->direccion->departamento; ?>
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
                                <span class="glyphicon glyphicon-edit"></span>
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
