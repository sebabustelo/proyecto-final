<section id="RbacUsuariosAdd" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header  with-border">
                    <h3 class="box-title"> <i class="fa fa-user-plus fa-lg"></i> Nuevo Usuario</h3>
                    <div class="box-tools pull-right">
                        <a href="/rbac/rbacUsuarios/index/" id="agregarUsuario" class="btn btn-sm btn-primary ">
                            <i class="fa fa-users"></i> Usuarios</a>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-row">
                        <form id="RbacUsuariosAddForm" name="RbacUsuariosAddForm" role="form" action="/rbac/rbacUsuarios/agregar/" method="POST">
                            <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getAttribute('csrfToken'); ?>">

                            <div class="form-group col-sm-2">
                                <label id="lblUsuario" for="usuario">Usuario (mail)</label>
                                <input type="email" name="usuario" required value="<?php echo $rbacUsuario->usuario; ?>" 
                                oninvalid="this.setCustomValidity('Complete el usuario (mail)')" oninput="this.setCustomValidity('')" 
                                placeholder="Ingrese el usuario" class="form-control" maxlength="20" value="<?php echo (!$rbacUsuario->getError('usuario')) ? $this->request->getData('usuario') : ''; ?>">
                                <?php foreach ($rbacUsuario->getError('usuario') as $k => $v) { ?>
                                    <div class="form-group   label label-danger">
                                        <span class=" "> <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                            <?php echo $v; ?>
                                        </span>
                                    </div>
                                <?php  } ?>
                            </div>

                            <div class="form-group col-sm-4">
                                <label for="nombre">Nombre</label>
                                <input required type="text" value="<?php echo $rbacUsuario->nombre; ?>" 
                                placeholder="Ingrese el nombre" class="form-control" name="nombre"
                                oninvalid="this.setCustomValidity('Debe completar el/los nombre/s')" oninput="this.setCustomValidity('')"  >
                                <?php foreach ($rbacUsuario->getError('nombre') as $k => $v) { ?>
                                    <div class="form-group   label label-danger">
                                        <span class=" "> <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                            <?php echo $v; ?>
                                        </span>
                                    </div>
                                <?php  } ?>
                            </div>
                            <div class="form-group col-sm-3">
                                <label for="apellido">Apellido</label>
                                <input required type="text" value="<?php echo $rbacUsuario->apellido; ?>" placeholder="Ingrese el apellido" 
                                class="form-control" name="apellido"
                                oninvalid="this.setCustomValidity('Debe completar el/los apellido/s')" oninput="this.setCustomValidity('')" >
                                <?php foreach ($rbacUsuario->getError('apellido') as $k => $v) { ?>
                                    <div class="form-group   label label-danger">
                                        <span class=" "> <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                            <?php echo $v; ?>
                                        </span>
                                    </div>
                                <?php  } ?>
                            </div>
                            <div class="form-group col-sm-2">
                                <label for="rbac-perfiles-ids">Perfil</label><br>
                                <select required id="rbac-perfiles-ids" name="rbac_perfiles[_ids][]" class="form-control">
                                    <?php foreach ($rbacPerfiles as $id => $perfil) : ?>
                                        <option value="<?php echo $id; ?>"><?php echo $perfil; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group   col-sm-1">
                                <label for="">&nbsp;</label><br>
                                <label class="btn btn-default btn-block">
                                    <input type="hidden" name="activo" value="0">
                                    <input value="1" type="checkbox" name="activo" <?php echo (isset($rbacUsuario) and $rbacUsuario->activo) == 'true' ? 'checked' : ''; ?>>
                                    <span>Activo</span>

                                </label>
                            </div>
                            <div class="form-group col-sm-12 callout callout-info" role="alert">
                               <i class="fa fa-info-circle" aria-hidden="true"></i>
                                Si desactiva el Usuario, esta quedara asociada a las productos anteriores como historial, pero el mismo no podra acceder el sistema.
                            </div>
                            <?php
                            if ($this->request->getSession()->check('previousUrl')) {
                                $url = $this->request->getSession()->read('previousUrl');
                                if (strpos($url, "Usuarios") !== false or strpos($url, "usuarios") !== false) {
                                    $url = $this->request->getSession()->read('previousUrl');
                                } else {
                                    $url = "/rbac/rbacUsuarios/index/";
                                }
                            } else {
                                $url = '/rbac/rbacUsuarios/index';
                            }
                            ?>
                            <div class="form-group col-sm-12 text-center">
                                <a href="<?php echo $url; ?>" class="btn btn-danger">
                                    <span class="glyphicon glyphicon-remove"></span> Cancelar</a>
                                <button type="submit" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-check"></span>
                                    Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
</section>