<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Configuracion> $configuraciones
 */

use Cake\Core\Configure;
?>
<section class="content-header">
    <h1>
        <?php echo Configure::read('Menu.GestionPermisos') ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-wrench "></i>Configuraciones</a></li> <i class="fa fa-arrow-right"></i>
        <li class="active">Editar</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header  with-border">
                    <h3 class="box-title"> <span class="fa fa-wrench fa-lg"></span> Nueva Configuración</h3>
                    <div class="box-tools pull-right">
                        <a href="/rbac/configuraciones/index/" class="btn btn-primary ">
                            <span class="fa fa-list "></span> Configuraciones</a>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="box-body">
                        <form class="form-horizontal" id="ConfiguracionesAddForm" name="ConfiguracionesAddForm" role="form" action="/rbac/configuraciones/add/" method="POST">
                            <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getAttribute('csrfToken'); ?>">
                            <div class="form-group">
                                <label for="clave" class="col-sm-2 control-label">Clave</label>
                                <div class="col-sm-10">
                                    <input type="text" id="clave" placeholder="Clave" class="form-control" name="clave">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="apellido" class="col-sm-2 control-label">Valor</label>
                                <div class="col-sm-10">
                                    <input type="text" id="valor" placeholder="Valor" class="form-control" name="valor">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class=" col-sm-9 col-md-offset-5">
                                    <a href="/rbac/configuraciones/index/" id="agregarUsuario" class="btn btn-danger">
                                        <span class="glyphicon glyphicon-remove"></span> Cancelar</a>
                                    <button type="submit" class="btn btn-primary">
                                        <span class="glyphicon glyphicon-check"></span>
                                        Guardar</button>
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

<script type="text/javascript">
    $(function() {
        inicialize();
    });

    function inicialize() {
        validar_form();
    }

    function limpiarCampos() {
        // Obtén el formulario por su ID
        var formulario = document.getElementById("ConfiguracionesAddForm");
        // Recorre todos los elementos del formulario
        for (var i = 0; i < formulario.elements.length; i++) {
            // Verifica si el elemento es un campo de texto, contraseña, email, etc.
            if (formulario.elements[i].type !== "submit" && formulario.elements[i].type !== "button") {
                // Limpia el valor del campo
                formulario.elements[i].value = "";
            }
        }
    }

    function validar_form() {
        $('#ConfiguracionesAddForm').validate({
            rules: {
                'clave': {
                    required: true
                },
                'valor': {
                    required: true
                }
            },
            messages: {
                'clave': {
                    correo: "La clave es obligatoria"
                },
                'valor': {
                    correo: "El valor es obligatorio"
                }
            },
            highlight: function(element) {
                $(element).closest('.control-group').removeClass('success').addClass('error');
            }
        });
    }
</script>
