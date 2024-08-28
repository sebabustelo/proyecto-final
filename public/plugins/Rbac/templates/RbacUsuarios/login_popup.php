<form id="formLoginPopup" class="form-signin well" role="form" action="/login/" method="POST">

    <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getAttribute('csrfToken'); ?>">
    <h3 class=" Icon">
        <!--Icono de usuario-->
        <span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;Login
    </h3>
    <br>
    <div class="input-group input-group-lg">
        <span class="input-group-addon" id="sizing-addon1"><i class="glyphicon glyphicon-user"></i></span>
        <input id="usuario_login" type="text" aria-describedby="sizing-addon1" name="data[RbacUsuario][usuario]" class="form-control" placeholder="Usuario" required autofocus>
    </div>
    <br>
    <div class="input-group input-group-lg">
        <span class="input-group-addon" id="sizing-addon1"><i class="glyphicon glyphicon-lock"></i></span>
        <input id="password" type="password" aria-describedby="sizing-addon1" name="data[RbacUsuario][password]" class="form-control" placeholder="Contraseña" required>
    </div>

    <!--<label class="checkbox"> <input type="checkbox" value="remember-me">Recordarme </label>-->
    <br>
    <?php if (isset($captcha) && $captcha == 'Si') { ?>
        <div id="captcha">
            <script src='https://www.google.com/recaptcha/api.js'></script>
            <div class="g-recaptcha" data-sitekey="<?php echo $captcha_public[0]["valor"]; ?>" summary="Espacio asignado al captcha"></div>
        </div>
    <?php } ?>
    <br>
    <button class="btn btn-lg btn-primary btn-block" id="btn_login" type="submit">Ingresar</button>
    <br />
    <?php if (isset($noLDAP)) { ?>
        <a href="/rbac/rbac_usuarios/recuperar"><span class="label label-danger">Recuperar contraseña</span></a>
    <?php } ?>
</form>

<script type="text/javascript">
    $("#formLoginPopup").on("submit", function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "/rbac/rbacUsuarios/login",
            dataType: 'html',
            timeout: 4000,
            data: {
                'data[RbacUsuario][usuario]': $("#usuario_login").val(),
                'data[RbacUsuario][password]': $("#password").val()
            },
            beforeSend: function(xhr) {
                dialog = bootbox.dialog({
                    message: '<div class="text-center"><i class="fa fa-spin fa-spinner"></i>Por favor espere mientras se procesan los datos...</div>',
                    closeButton: false
                });
                xhr.setRequestHeader(
                    'X-CSRF-Token',
                    <?= json_encode($this->request->getAttribute('csrfToken')); ?>
                );
            },
            success: function(data) {
                //$("#listado").html(data);
                dialog.modal('hide');
                location.reload();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // bootbox.alert("Ocurrio un problema , verifique las conexiones ");                   
            },
            complete: function(xhr, status) {
                $('#divDialog').dialog('close');
                dialog.modal('hide');
            },
        });
    });
</script>