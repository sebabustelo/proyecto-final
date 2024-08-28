<section id="RbacUsuariosAdd" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header  with-border">
                    <h3 class="box-title"> <span class="fa fa-user-plus fa-lg"></span> Nuevo Usuario</h3>
                    <div class="box-tools pull-right">
                        <a href="/rbac/rbacUsuarios/index/" id="agregarUsuario" class="btn btn-primary ">
                            <span class="fa fa-list"></span> Usuarios</a>
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
                                <input type="email" name="usuario" required id="RbacUsuarioUsuario" oninvalid="this.setCustomValidity('Complete el usuario (mail)')" oninput="this.setCustomValidity('')" placeholder="Ingrese el usuario" class="form-control" maxlength="20" value="<?php echo (!$rbacUsuario->getError('usuario')) ? $this->request->getData('usuario') : ''; ?>">
                            </div>                           

                            <div class="form-group col-sm-5">
                                <label for="nombre">Nombre</label>
                                <input required type="text" id="RbacUsuarioNombre" placeholder="Se autocompleta automáticamente al asociar un usuarios LDAP" class="form-control" name="nombre">
                            </div>
                            <div class="form-group col-sm-5">
                                <label for="apellido">Apellido</label>
                                <input required type="text" id="RbacUsuarioApellido" placeholder="Se autocompleta automáticamente al asociar un usuarios LDAP" class="form-control" name="apellido">
                            </div>
                            <div class="form-group col-sm-2">
                                <label for="rbac-perfiles-ids">Perfil</label><br>
                                <select required id="rbac-perfiles-ids" name="rbac_perfiles[_ids][]" class="form-control" >
                                    <?php foreach ($rbacPerfiles as $id => $perfil) : ?>
                                        <option value="<?php echo $id; ?>"><?php echo $perfil; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>                                                     
                            <div class="form-group col-sm-5">
                                <label for="contrasenia">Contraseña</label>
                                <input required type="password" class="form-control" name="password" id="contrasenia" placeholder="Contraseña">

                            </div>
                            <div class="form-group col-sm-5">
                                <label for="contrasenia2" >Reingrese Contraseña</label>
                                <input required type="password" class="form-control" name="contrasenia2" id="contrasenia2" placeholder="Reingrese Contraseña">

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
                                <button type="submit" class="btn btn-primary" >
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