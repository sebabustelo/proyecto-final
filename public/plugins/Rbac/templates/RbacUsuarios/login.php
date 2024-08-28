<?php $this->layout = 'Rbac.login'; ?>
<?php use Cake\Core\Configure; ?>
<div>

    <form id="formLogin" class="form-signin well" role="form" action="/login/" method="POST">

        <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getAttribute('csrfToken'); ?>">
        <div class="register-logo">
            <a href="<?php echo $this->Url->build(); ?>"><?php echo Configure::read('Theme.logo.large') ?></a>
        </div>

        <!--Icono de usuario-->
        <!-- <h3 class="Icon"
            	<span class="glyphicon glyphicon-user"></span>
            </h3>-->


        <div class="form-group has-feedback">
            <input type="text" class="form-control" name="data[RbacUsuario][usuario]" required placeholder="Usuario">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <!-- <div class="form-group has-feedback">
            <input type="email" class="form-control" placeholder="Email">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div> -->
        <div class="form-group has-feedback">
            <input type="password" name="data[RbacUsuario][password]" class="form-control" placeholder="Password" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>

        <!-- <div class="input-group input-group-lg">
            <span class="input-group-addon" id="sizing-addon1"><i class="glyphicon glyphicon-lock"></i></span>
            <input id="password" type="password" aria-describedby="sizing-addon1" name="data[RbacUsuario][password]" class="form-control" placeholder="Contraseña" required>
        </div> -->
        <!--<label class="checkbox"> <input type="checkbox" value="remember-me">Recordarme </label>-->
        <br>
        <?php if (isset($captcha) && $captcha == 'Si') { ?>

            <div id="captcha">
                <script src='https://www.google.com/recaptcha/api.js'></script>
                <div class="g-recaptcha" data-sitekey="<?php echo $captcha_public[0]["valor"]; ?>" summary="Espacio asignado al captcha"></div>
            </div>
        <?php } ?>


        <button class="btn btn-primary btn-block" type="submit">Ingresar</button>
        <br />
        <?php if (!empty($authUrl)) { ?>
            <a class="wow fadeInUp" href="<?php echo $authUrl; ?>" data-wow-delay="0.4s"><i class="fa fa-google-plus">
                    <img src="<?php echo $this->Url->image('login_google.png'); ?>" alt=" Google"></i></a>
        <?php } ?>
        <?= $this->Flash->render() ?>
        <!-- <a href="/rbac/rbac_usuarios/recuperar"><span class="label label-danger">Recuperar contraseña</span></a>-->
    </form>

</div>
