<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estado $estado
 */
?>
<section class="content-header">
    <h1>
        <i class="fa fa-cubes"></i> Gestión de Pedidos
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa  fa-dot-circle-o"></i>Pedidos</a></li> <i class="fa fa-arrow-right"></i>
        <li class="active">Editar</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header  with-border">
                    <h3 class="box-title"> <span class="fa fa-refresh fa-lg"></span> Editar Pedido</h3>
                    <div class="box-tools pull-right">
                        <a title="Listado de Pedidos" href="/Pedidos/index/" class="btn btn-sm btn-primary ">
                            <span class="fa fa-list"></span> <span class=" hidden-xs">Pedidos</span>
                        </a>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-row">
                        <form id="ProveedoresEditForm" name="ProveedoresEditForm" role="form" action="/Pedidos/edit/<?php echo $pedido->id; ?>" method="POST">
                            <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getAttribute('csrfToken'); ?>">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Datos del cliente</h3>
                                </div>
                                <div class="panel-body">
                                    <dl class="dl-horizontal">
                                        <dt>Nombre y Apellido:</dt>
                                        <dd><?php echo h($pedido->rbac_usuario->nombre) . " " . $pedido->rbac_usuario->apellido; ?></dd>

                                        <dt>Documento:</dt>
                                        <dd><?php echo h($pedido->rbac_usuario->tipo_documento->descripcion) . ":" . h($pedido->rbac_usuario->documento); ?></dd>

                                        <dt>Email:</dt>
                                        <dd><?php echo h($pedido->rbac_usuario->email); ?></dd>

                                        <dt>Teléfono:</dt>
                                        <dd><?php echo h($pedido->rbac_usuario->celular); ?></dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Orden Médica</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center mb-2">
                                                <?php if (!empty($pedido->ordenes_medicas[0]->file_name)) : ?>
                                                    <a href="/img/ordenes_medicas/<?php echo h($pedido->ordenes_medicas[0]->file_name); ?>" target="_blank" class="btn btn-success flex-fill ">
                                                        <span class="fa fa-file-pdf-o"></span> Descargar Orden Médica
                                                    </a>
                                                <?php else : ?>
                                                    <span class="text-danger">No se ha subido una orden médica.</span>
                                                <?php endif; ?>

                                                <?php if ($pedido->pedidos_estado->nombre == 'PENDIENTE') : ?>
                                                    <form id="VerificarOrdenForm" method="POST" action="/Pedidos/verificarOrden/<?php echo $pedido->id; ?>" class="flex-fill">
                                                        <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getAttribute('csrfToken'); ?>">
                                                        <button type="submit" class="btn btn-primary flex-fill" onclick="return confirmValidation(event)">
                                                            <span class="fa fa-check"></span> Validar Orden Médica
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Datos del Pedido</h3>
                                </div>
                                <div class="panel-body">

                                    <div class="row align-items-center">
                                        <div class="col-md-3 d-flex">
                                            <div class="mr-2 font-weight-bold"><strong>ID:</strong> <?php echo h($pedido->id); ?></div>
                                        </div>

                                        <div class="col-md-3 d-flex">
                                            <div class="mr-2 font-weight-bold"><strong>Estado:</strong>
                                                <span class="label <?php
                                                                    switch ($pedido->pedidos_estado->nombre) {
                                                                        case 'PENDIENTE':
                                                                            echo 'bg-yellow'; // Fondo amarillo
                                                                            break;
                                                                        case 'INCOMPLETO':
                                                                            echo 'bg-red'; // Fondo rojo
                                                                            break;
                                                                        case 'EN_PROCESO':
                                                                            echo 'bg-blue'; // Fondo azul
                                                                            break;
                                                                        case 'PAGADO':
                                                                            echo 'bg-purple'; // Fondo morado
                                                                            break;
                                                                        case 'EN_CAMINO':
                                                                            echo 'bg-orange'; // Fondo naranja
                                                                            break;
                                                                        case 'FINALIZADO':
                                                                            echo 'bg-green'; // Fondo verde
                                                                            break;
                                                                        default:
                                                                            echo 'bg-gray'; // Fondo gris por defecto
                                                                            break;
                                                                    }
                                                                    ?>">
                                                    <?php echo $pedido->pedidos_estado->nombre; ?>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="col-md-3 d-flex">
                                            <div class="mr-2 font-weight-bold"><strong>Fecha:</strong><?php echo h($pedido->fecha_pedido->format('d/m/Y H:i:s')); ?></div>
                                           
                                        </div>
                                    </div>



                                    <br>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Producto</th>
                                                    <th>Cantidad</th>
                                                    <th>Precio Unitario</th>
                                                    <th>Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $total = 0; ?>
                                                <?php foreach ($pedido->detalles_pedidos as $detalle) : ?>
                                                    <?php
                                                    $precioUnitario = h($detalle->producto->productos_precios[0]['precio']);
                                                    $subtotal = $precioUnitario * $detalle->cantidad;
                                                    $total += $subtotal;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo h($detalle->producto->nombre); ?></td>
                                                        <td><?php echo h($detalle->cantidad); ?></td>
                                                        <td>$<?php echo h(number_format($precioUnitario, 2)); ?></td>
                                                        <td>$<?php echo h(number_format($subtotal, 2)); ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="3" class="text-right"><strong>Total:</strong></td>
                                                    <td>$<?php echo h(number_format($total, 2)); ?></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>




                            <?php
                            if ($this->request->getSession()->check('previousUrl')) {
                                $url = $this->request->getSession()->read('previousUrl');
                                if (strpos($url, "Pedidos") !== false) {
                                    $url = $this->request->getSession()->read('previousUrl');
                                } else {
                                    $url = "/Pedidos/index/";
                                }
                            } else {
                                $url = '/Pedidos/index';
                            }
                            ?>
                            <div class="form-group col-sm-12 text-center">
                                <a href="<?php echo $url; ?>" class="btn btn-danger">
                                    <span class="fa fa-remove"></span> Cancelar</a>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    document.getElementById('ProveedoresAddForm').addEventListener('submit', function(event) {
        const cuit = document.getElementById('cuit').value;
        const mensajeError = document.getElementById('mensaje-error');

        if (!validarCuit(cuit)) {
            mensajeError.style.display = 'block';
            event.preventDefault(); // Prevenir el envío del formulario si el CUIT es inválido
        } else {
            mensajeError.style.display = 'none'; // Si el CUIT es válido, ocultar el mensaje
        }
    });

    function validarCuit(cuit) {
        // Eliminar cualquier guión, espacio o carácter no numérico
        cuit = cuit.replace(/[^0-9]/g, '');

        // Verificar que tenga 11 dígitos
        if (cuit.length !== 11) {
            return false;
        }

        // Multiplicadores para los primeros 10 dígitos
        const multiplicadores = [5, 4, 3, 2, 7, 6, 5, 4, 3, 2];

        // Calcular el dígito verificador
        let suma = 0;
        for (let i = 0; i < 10; i++) {
            suma += parseInt(cuit[i]) * multiplicadores[i];
        }

        let verificador = (11 - (suma % 11)) % 11;

        // Comparar con el dígito verificador (último dígito del CUIT)
        return verificador === parseInt(cuit[10]);
    }


    function confirmValidation(event) {
        event.preventDefault(); // Prevenir el envío del formulario
        const form = event.target.closest('form'); // Obtener el formulario

        // Mostrar el popup de confirmación
        const userConfirmed = confirm("¿Está seguro de que desea validar la orden médica? Esto cambiará el estado del pedido y enviará un email al cliente con el link de pago.");

        if (userConfirmed) {
            form.submit(); // Si el usuario confirma, enviar el formulario
        }
    }
</script>