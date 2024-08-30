<section id="RbacUsuariosAdd" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header  with-border">
                    <h3 class="box-title"> <span class="fa fa-user-plus fa-lg"></span> Nuevo Usuario</h3>
                    <div class="box-tools pull-right">
                        <a href="/rbac/rbacUsuarios/index/" id="agregarUsuario" class="btn btn-sm btn-primary ">
                            <span class="fa fa-users"></span> Usuarios</a>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-row">
                        <form id="RbacUsuariosAddForm" name="RbacUsuariosAddForm" role="form" action="/rbac/rbacUsuarios/add/" method="POST">
                            <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getAttribute('csrfToken'); ?>">

                            <div class="form-group col-sm-4">
                                <label id="lblUsuario" for="usuario">Usuario (mail)</label>
                                <input type="email" name="usuario" required id="RbacUsuarioUsuario" oninvalid="this.setCustomValidity('Complete el usuario (mail)')" oninput="this.setCustomValidity('')" placeholder="Ingrese el usuario" class="form-control" maxlength="40" value="<?php echo (!$rbacUsuario->getError('usuario')) ? $this->request->getData('usuario') : ''; ?>">
                            </div>

                            <div class="form-group col-sm-4">
                                <label for="nombre">Nombre</label>
                                <input required type="text" placeholder="Ingrese el/los nombre/s" class="form-control" name="nombre" oninvalid="this.setCustomValidity('Debe completar el/los nombre/s')" oninput="this.setCustomValidity('')">
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="apellido">Apellido</label>
                                <input required type="text" placeholder="Ingrese el/los apellido/s" class="form-control" name="apellido" oninvalid="this.setCustomValidity('Debe completar el/los apellido/s')" oninput="this.setCustomValidity('')">
                            </div>
                            <div class="form-group col-sm-2">
                                <label>Tipo de Documento</label><br>
                                <select required name="tipo_documento_id" class="form-control">
                                    <option value="">Seleccione un tipo de documento</option>
                                    <?php foreach ($tipoDocumentos as $id => $tipoDocumento) : ?>
                                        <option value="<?php echo $id; ?>"><?php echo $tipoDocumento; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group col-sm-2">
                                <label for="documento">Documento</label>
                                <input required type="text" placeholder="Ingrese el número de documento" class="form-control" name="documento" oninvalid="this.setCustomValidity('Debe completar el número de documento')" oninput="this.setCustomValidity('')">
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="direccion">Dirección</label>
                                <input required type="text" placeholder="Ingrese la dirección" class="form-control" name="direccion" oninvalid="this.setCustomValidity('Debe completar la dirección')" oninput="this.setCustomValidity('')">
                            </div>
                           
                            <div class="form-group col-sm-4">
                                <label>Perfil</label><br>
                                <select required name="perfil_id" class="form-control">
                                    <option value="">Seleccione un perfil</option>
                                    <?php foreach ($rbacPerfiles as $id => $perfil) : ?>
                                        <option value="<?php echo $id; ?>"><?php echo $perfil; ?></option>
                                    <?php endforeach; ?>
                                </select>
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
                            <div class="form-group col-sm-12">
                                <div class="callout callout-info">
                                    <p><i class="icon fa fa-info"></i> El usuario recibirá un mail a su correo con un link donde deberá ingresar una contraseña para poder completar el alta del mismo.
        
                                  </p>
                                </div>
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