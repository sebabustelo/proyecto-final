<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pedido $pedido
 * @var \App\Model\Entity\Usuario $usuario
 * @var \App\Model\Entity\Producto $producto
 */
?>
<section class="content-header">
    <h1>
        <i class="fa fa-shopping-cart"></i> Gestión de Pedidos
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dot-circle-o"></i>Pedidos</a></li> <i class="fa fa-arrow-right"></i>
        <li class="active">Agregar</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"> <span class="fa fa-plus fa-lg"></span> Nuevo Pedido</h3>
                    <div class="box-tools pull-right">
                        <a title="Listado de pedidos" href="/Pedidos/index/" class="btn btn-sm btn-primary">
                            <span class="fa fa-list"></span> <span class="hidden-xs">Pedidos</span>
                        </a>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">

                    <form id="PedidosAddForm" name="PedidosAddForm" role="form" action="/Pedidos/add/" method="POST">
                        <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getAttribute('csrfToken'); ?>">

                        <p>
                            <i class="fa fa-fw  fa-cube"></i> <strong>Datos solicitados: </strong>
                        <div class="form-group col-sm-6">
                            <label>Usuario</label>

                            <select required class="form-control" name="usuario_id">
                                <?php foreach ($usuarios as $id=>$usuario): ?>
                                    <option value="<?php echo $id; ?>"><?php echo $usuario; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Producto -->
                        <div class="form-group col-sm-6">
                            <label>Producto</label>
                            <select required class="form-control" name="producto_id">
                                <?php foreach ($productos as $producto): ?>
                                    <option value="<?php echo $producto->id; ?>"><?php echo $producto->nombre; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-8">
                            <label for="orden_medica">Cargar receta médica</label>
                            <input type="file" class="form-control" name="orden_medica" id="orden_medica" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="fecha_intervencion">Fecha de Intervención</label>
                            <input type="hidden" value="<?php echo $producto->id; ?>" id="id" name="detalles_pedidos[0][producto_id]">
                            <input type="date" class="form-control" name="fecha_intervencion"
                                min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" id="fecha_intervencion" required>
                        </div>


                        <div class="form-group col-md-12">
                            <label for="comentario">Comentario</label>
                            <textarea class="form-control" name="comentario" value="<?php echo $this->request->getData('comentario') ?? ''; ?>" id="comentario" rows="2" maxlength="500" placeholder="Escriba aquí cualquier comentario..."></textarea>
                        </div>
                        </p>
                        <p>
                            <?php $direccion =     $this->getRequest()->getSession()->read('RbacUsuario')['direccion'];
                            // debug($direccion);
                            ?>
                            <i class="fa fa-map-marker"></i> <strong>Dirección de Entrega: </strong>
                        <div class="form-group col-md-6">
                            <label for="provincia_id">Provincia</label>
                            <select id="provincia_id" required name="provincia_id" class="form-control">
                                <option selected value="">Seleccione una provincia</option>
                                <?php foreach ($provincias as $id => $provincia) { ?>
                                    <option value="<?php echo $id; ?>" <?php echo ($direccion->localidade->provincia_id == $id) ? 'selected' : ''; ?>>
                                        <?php echo $provincia; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="localidad_id">Localidad</label>
                            <select id="localidad_id" required name="direccion[localidad_id]" class="form-control">
                                <option selected value="">Seleccione una localidad</option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="calle">Calle</label>
                            <input name="direccion[calle]" required type="text" maxlength="50"
                                value="<?php echo $direccion->calle ?? ''; ?>"
                                class="form-control" placeholder="Calle" oninput="this.value = this.value.replace(/[^a-zA-Z0-9' ]/g, '');">
                        </div>

                        <div class="form-group col-md-8">
                            <div class="row">
                                <div class="col-xs-4">
                                    <label for="numero">Número</label>
                                    <input name="direccion[numero]" required type="number"
                                        value="<?php echo $direccion->numero ?? ''; ?>"
                                        class="form-control" placeholder="Número" min="1" max="9999" oninput="this.value = this.value.slice(0, 5);" onkeydown="preventInvalidInput(event)">
                                </div>
                                <div class="col-xs-4">
                                    <label for="piso">Piso</label>
                                    <input name="direccion[piso]" type="text" class="form-control" placeholder="Piso" maxlength="3"
                                        value="<?php echo $direccion->piso ?? ''; ?>">
                                </div>
                                <div class="col-xs-4">
                                    <label for="departamento">Departamento</label>
                                    <input name="direccion[departamento]" type="text" class="form-control" placeholder="Depto" maxlength="3"
                                        value="<?php echo  $direccion->departamento ?? ''; ?>">
                                </div>
                            </div>
                        </div>
                        </p>


                        <!-- Botones -->
                        <div class="form-group col-sm-12 text-center">
                            <a href="/Pedidos/index" class="btn btn-danger">
                                <span class="fa fa-remove"></span> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <span class="fa fa-check-square-o"></span> Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
    document.addEventListener('DOMContentLoaded', function() {



        var provinciaSelect = document.getElementById('provincia_id');
        var localidadSelect = document.getElementById('localidad_id');

        provinciaSelect.addEventListener('change', function() {
            var provinciaId = this.value;


            if (provinciaId) {

                fetch('/localidades/localidades/' + provinciaId)

                    .then(response => response.json())
                    .then(data => {
                        localidadSelect.innerHTML = '<option selected value="">Seleccione una localidad</option>';

                        data.forEach(function(localidad) {

                            localidadSelect.innerHTML += '<option value="' + localidad.id + '">' + localidad.nombre + '</option>';
                        });
                    })
                    .catch(error => console.error('Error al cargar localidades:', error));
            } else {
                localidadSelect.innerHTML = '<option selected value="">Seleccione una localidad</option>';
            }
        });

        document.getElementById('provincia_id').dispatchEvent(new Event('change'));

        setTimeout(function() {

            var localidadId = "<?php echo $rbacUsuario->direccion->localidad_id ?? ''; ?>";
            if (localidadId) {
                document.getElementById('localidad_id').value = localidadId;
            }
        }, 1000); // Ajusta el tiempo según sea necesario



    });

    function preventInvalidInput(event) {
        const invalidChars = ['e', 'E', '+', '-']; // caracteres que quieres restringir
        if (invalidChars.includes(event.key)) {
            event.preventDefault();
        }
    }
</script>
