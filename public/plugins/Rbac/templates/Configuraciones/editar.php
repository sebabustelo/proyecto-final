<section id="ConfiguracionesEdit" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header  with-border">
                    <h3 class="box-title"> <span class="fa fa-user fa-lg"></span> Editar Configuración</h3>
                    <div class="box-tools pull-right">
                        <a href="/rbac/configuraciones/index/" id="agregarUsuario" class="btn btn-primary ">
                            <span class="fa fa-list"></span> Listado de Configuraciones</a>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="box-body">
                        <form class="form-horizontal" id="ConfiguracionesEditForm" name="ConfiguracionesEditForm" role="form" action="/rbac/configuraciones/editar/<?php echo $configuracion->id; ?>" method="POST">
                            <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getAttribute('csrfToken'); ?>">

                            <div class="form-group">
                                <label for="clave" class="col-sm-2 control-label">Clave</label>
                                <div class="col-sm-10">
                                    <input type="hidden" value="<?php echo $configuracion->id; ?>" name="id">
                                    <input type="text" placeholder="Clave" class="form-control" value="<?php echo $configuracion->clave; ?>" name="clave">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="valor" class="col-sm-2 control-label">Valor</label>
                                <div class="col-sm-10">
                                    <input type="text" value="<?php echo $configuracion->valor; ?>" placeholder="Valor" class="form-control" name="valor">
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
        var formulario = document.getElementById("ConfiguracionesEditForm");
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
        $('#ConfiguracionesEditForm').validate({
            rules: {
                'data[Configuracion][clave]': {
                    required: true
                },
                'data[Configuracion][valor]': {
                    required: true
                }
            },
            messages: {
                'data[Configuracion][clave]': {
                    required: "La clave es obligatoria"
                },
                'data[Configuracion][valor]': {
                    required: "El valor es obligatorio"
                }
            },
            highlight: function(element) {
                $(element).closest('.control-group').removeClass('success').addClass('error');
            }
        });
    }
</script>