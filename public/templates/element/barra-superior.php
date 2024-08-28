
  <div class="navbar-custom-menu ">
    <ul class="nav navbar-nav" >
      <li class="dropdown user user-menu">
        <a href="#" class="dropdown-toggle btn btn-primary" style="border-width:0px;" data-toggle="dropdown">
          <?php //echo $this->Html->image('user2-160x160.jpg', array('class' => 'user-image', 'alt' => 'User Image')); 
          ?>
          <i class="glyphicon glyphicon-user"></i>
          <span class="hidden-xs"><?php echo $usuario['usuario']; ?></span>
        </a>
        <ul class="dropdown-menu">
          <!-- User image -->
          <li class="user-header">
           
            <?php //echo $this->Html->image('user2-160x160.jpg', array('class' => 'img-circle', 'alt' => 'User Image')); 
            ?>
            <a href="<?php echo $this->Url->build('/'); ?>usuarios/edit/<?php echo $usuario['id']; ?>">                            
            <i class="glyphicon glyphicon-user"></i> <?php echo $usuario['nombres'] . " " . $usuario['apellidos']; ?>             
            </a>
          </li>
          <?php if (!empty($perfilesPorUsuario)) { ?>
            <li class="dropdown-submenu user-body">
              <a href="#">
                <?php foreach ($perfilesPorUsuario as $perfil) {
                  if ($perfilDefault == $perfil['id']) {
                    echo '<b>' . $perfil['descripcion'] . ' [actual]</b>';
                  }
                } ?>
                <?php if (count($perfilesPorUsuario) > 1) { ?>
                  <b class="caret"></b>
              </a>
              <ul class="dropdown-menu">
                <?php foreach ($perfilesPorUsuario as $perfil) {
                    if ($perfilDefault != $perfil['id']) { ?>
                    <li><a href="<?php echo $this->Url->build('/'); ?>rbac/rbac_usuarios/cambiarPerfil/<?php echo $perfil['id'] ?>">
                        <?php echo '<b>' . $perfil['descripcion'] . '</b>'; ?>
                      </a></li>
                <?php }
                  } ?>
              </ul>
            <?php } else { ?>
              </a>
            <?php } ?>
            </li>
          <?php } ?>
          <!-- Menu Footer-->
          <li class="user-footer">
            <div class="pull-left">
              <?php if (isset($accionesPermitidas['usuarios']['changePass']) && $usuario['valida_ldap'] == 0) { ?>
                <a href="<?php echo $this->Url->build('/'); ?>usuarios/changePass/" class="btn btn-default ">Cambiar contraseña</a>
              <?php } ?>
            </div>
            <div class="pull-right">
              <a href="<?php echo $this->Url->build('/'); ?>rbac/rbac_usuarios/logout" class="btn btn-default btn-block">Salir</a>
            </div>
          </li>
        </ul>
      </li>      
    </ul>
    </div>