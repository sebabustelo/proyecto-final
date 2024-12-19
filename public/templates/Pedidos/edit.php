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
                <div class="box-header with-border">
                    <h3 class="box-title row" style="display: block !important;">
                        <div class="col-md-4">
                            Pedido: <?php echo h($pedido->id); ?>
                        </div>

                        <div class="col-md-4">
                            Estado:
                            <span class="label <?php
                                                switch ($pedido->pedidos_estado->nombre) {
                                                    case 'PENDIENTE':
                                                        echo 'bg-yellow';
                                                        break;
                                                    case 'INCOMPLETO':
                                                        echo 'bg-red';
                                                        break;
                                                    case 'EN_PROCESO':
                                                        echo 'bg-blue';
                                                        break;
                                                    case 'PAGADO':
                                                        echo 'bg-purple';
                                                        break;
                                                    case 'EN_CAMINO':
                                                        echo 'bg-orange';
                                                        break;
                                                    case 'FINALIZADO':
                                                        echo 'bg-green';
                                                        break;
                                                    default:
                                                        echo 'bg-gray';
                                                        break;
                                                }
                                                ?>">
                                <?php echo $pedido->pedidos_estado->nombre; ?>
                            </span>
                        </div>

                        <div class="col-md-4">
                            Fecha: <?php echo h($pedido->fecha_pedido->format('d/m/Y H:i:s')); ?>
                        </div>
                    </h3>

                    <div class="box-tools pull-right">
                        <a title="Listado de Pedidos" href="/Pedidos/index/" class="btn btn-sm btn-primary">
                            <span class="fa fa-list"></span> <span class="hidden-xs">Pedidos</span>
                        </a>
                    </div>
                </div>

                <div class="box-body">
                    <div class="form-row">

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Datos del cliente</h3>
                            </div>
                            <div class="panel-body">
                                <dl class="dl-horizontal">
                                    <dt>Nombre y Apellido:</dt>
                                    <dd><?php echo h($pedido->cliente->nombre) . " " . $pedido->cliente->apellido; ?>
                                    </dd>

                                    <dt>Documento:</dt>
                                    <dd><?php echo h($pedido->cliente->tipo_documento->descripcion) . ":" . h($pedido->cliente->documento); ?>
                                    </dd>

                                    <dt>Email:</dt>
                                    <dd><?php echo h($pedido->cliente->email); ?></dd>

                                    <dt>Teléfono:</dt>
                                    <dd><?php echo h($pedido->cliente->celular); ?></dd>

                                    <dt>Dirección:</dt>
                                    <dd><?php echo h($pedido->direccion->localidade->provincia->nombre . ", " . $pedido->direccion->localidade->nombre); ?></dd>
                                    <dd>
                                        <?php echo h($pedido->direccion->calle . " " . $pedido->direccion->numero); ?>
                                        <?php echo h(" (".$pedido->direccion->piso . " " . $pedido->direccion->departamento.")"); ?>
                                    </dd>



                                </dl>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Orden Médica</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-3">

                                        <?php if (!empty($pedido->ordenes_medicas[0]->file_name)) : ?>
                                            <a href="/uploads/ordenes_medicas/<?php echo h($pedido->ordenes_medicas[0]->file_name); ?>"
                                                target="_blank" class="btn btn-success flex-fill ">
                                                <span class="fa fa-file-pdf-o"></span> Descargar Orden Médica
                                            </a>
                                        <?php else : ?>
                                            <span class="text-danger">No se ha subido una orden médica.</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-3">
                                        <?php if ($pedido->pedidos_estado->nombre == 'PENDIENTE') : ?>
                                            <form id="VerificarOrdenForm" method="POST"
                                                action="/Pedidos/ordenMedicaValida/<?php echo $pedido->id; ?>"
                                                class="flex-fill">
                                                <input type="hidden" name="_csrfToken"
                                                    value="<?php echo $this->request->getAttribute('csrfToken'); ?>">
                                                <button type="submit" class="btn btn-primary flex-fill"
                                                    onclick="return confirmValidation(event)">
                                                    <span class="fa fa-check"></span> Orden Médica Válida
                                                </button>
                                            </form>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Detalle del Pedido</h3>
                            </div>
                            <div class="panel-body">
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
                            <a href="<?php echo $url; ?>" class="btn btn-default">
                                <span class="fa fa-arrow-left"></span> Volver</a>
                            <a id="cancelar_pedido" href="/Pedidos/cancelar/<?php echo $pedido->id; ?>"
                                class="btn btn-danger" onclick="cancelarPedido(event, this)">
                                <span class="fa fa-remove"></span> Cancelar Pedido
                            </a>

                        </div>

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
        const userConfirmed = confirm(
            "¿Está seguro de que la orden médica es válida? Esto cambiará el estado del pedido y enviará un email al cliente con el link de pago."
        );

        if (userConfirmed) {
            form.submit(); // Si el usuario confirma, enviar el formulario
        }
    }

    function cancelarPedido(event, element) {
        event.preventDefault(); // Prevenir la acción por defecto del enlace

        // Mostrar el popup de confirmación
        const userConfirmed = confirm(
            "¿Está seguro de cancelar el pedido? Esto cambiará el estado del pedido a CANCELADO y no podrá recuperarse."
        );

        if (userConfirmed) {
            window.location.href = element.href; // Redirigir a la URL del enlace si el usuario confirma
        }
    }
</script>
