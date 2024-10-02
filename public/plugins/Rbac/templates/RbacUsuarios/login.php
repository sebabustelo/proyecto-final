<?php $this->layout = 'Rbac.login'; ?>
<?php

use Cake\Core\Configure; ?>
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
            <input type="text" class="form-control" maxlength="50" name="usuario" required placeholder="Usuario o Correo electrónico">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <!-- <div class="form-group has-feedback">
            <input type="email" class="form-control" placeholder="Email">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div> -->
        <div class="form-group has-feedback">
            <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>



        <?php if (isset($captcha) && $captcha == 'Si') { ?>

            <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
            <script src="https://www.google.com/recaptcha/api.js?render=<?php echo env('RECAPTCHA_CLAVE_PUBLICA'); ?>"></script>
            <script>
                grecaptcha.ready(function() {
                    grecaptcha.execute('<?php echo env('RECAPTCHA_CLAVE_PUBLICA'); ?>', {
                        action: 'login'
                    }).then(function(token) {
                        document.getElementById('g-recaptcha-response').value = token;
                    });
                });
            </script>
            <br>
        <?php }
        ?>

        <button class="btn btn-lg btn-primary btn-block" type="submit"><i class="fa fa-lg fa-sign-in"></i>  Ingresar</button>
        <br />
        <?php if (!empty($authUrl)) { ?>
            <a class="wow fadeInUp" href="<?php echo $authUrl; ?>" data-wow-delay="0.4s"><i class="fa fa-google-plus">
                    <img src="<?php echo $this->Url->image('login_google.png'); ?>" alt=" Google"></i></a>
        <?php } ?>

        <?= $this->Flash->render() ?>

    </form>

</div>
