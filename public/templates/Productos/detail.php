<!-- Product Detail Section -->
<section class="content-header">
    <h1><i class="fa fa-fw fa-medkit"></i> <?php echo $producto->categoria->nombre . ": " . $producto->nombre; ?></h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-users"></i> Productos</a></li>
        <li class="active">Detalles</li>
    </ol>
</section>

<section id="ProductDetail" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"></h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <!-- Carrusel de imágenes del producto -->
                        <div class="col-md-4">
                            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <?php if (count($producto->productos_archivos) > 1) { ?>
                                        <?php foreach ($producto->productos_archivos as $k => $archivo) { ?>
                                            <li data-target="#carousel-example-generic" data-slide-to="<?php echo $k ?>" class="active"></li>
                                        <?php } ?>
                                    <?php } ?>

                                </ol>
                                <div class="carousel-inner">
                                    <?php foreach ($producto->productos_archivos as $k => $archivo) { ?>
                                        <div class="item active">
                                            <img src="/img/productos/<?php echo $archivo->file_name; ?>" alt="<?php echo $archivo->file_name; ?>">
                                        </div>
                                    <?php } ?>

                                </div>
                                <?php if (count($producto->productos_archivos) > 1) { ?>
                                    <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                                        <span class="fa fa-angle-left"></span>
                                    </a>
                                    <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                                        <span class="fa fa-angle-right"></span>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                        <!-- Información del producto -->
                        <div class="col-md-8">

                            <p>
                                <i class="fa fa-tag"></i> <strong>Precio: </strong><?php echo "$" . $producto->productos_precios[0]->precio; ?>
                            </p>
                            <p>
                                <i class="fa fa-info-circle"></i> <strong>Info del producto: </strong><?php echo $producto->descripcion_breve; ?>
                            </p>
                            <p>
                                <i class="fa fa-align-left"></i> <strong>Descripción: </strong><?php echo $producto->descripcion_larga; ?>
                            </p>
                            <!-- Formulario para cargar receta y aclaración -->
                            <form id="pedidoForm" action="/Pedidos/addForCliente" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getAttribute('csrfToken'); ?>">

                                <div class="form-group col-md-6">
                                    <label for="orden_medica">Cargar receta médica</label>
                                    <input type="file" class="form-control" name="orden_medica" id="orden_medica" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="fecha_aplicacion">Fecha de Aplicación</label>
                                    <input type="hidden" value="<?php echo $producto->id; ?>" id="id" name="detalles_pedidos[0][producto_id]">
                                    <input type="date" class="form-control" name="fecha_aplicacion"
                                        min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" id="fecha_aplicacion" required>
                                </div>
                                <!-- Cantidad -->
                                <div class="form-group col-md-2">
                                    <label for="cantidad">Cantidad</label>
                                    <input onkeydown="preventInvalidInput(event)" oninput="limitInputLength(this)"
                                        type="number" class="form-control" id="cantidad"
                                        name="detalles_pedidos[0][cantidad]" min="1" max="99" required>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="aclaracion">Aclaraciones</label>
                                    <textarea class="form-control" name="aclaracion" id="aclaracion" rows="2" maxlength="500" placeholder="Escriba aquí cualquier aclaración..." required></textarea>
                                </div>
                                <div class="button-group">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fa fa-check" style="color: white;"></i> Solicitar
                                    </button>
                                    <a href="/Pedidos/addCart" class="btn btn-primary" role="button">
                                        <span class="fa fa-shopping-cart"></span> Agregar al Carrito
                                    </a>
                                    <a href="/productos/catalogoCliente" class="btn btn-default" role="button"><i class="fa fa-arrow-left"></i> Volver a Productos</a>
                                </div>
                            </form>

                            <br>
                            <div class="alert alert-info mt-3" role="alert">
                                <strong>Nota1:</strong> El pedido está sujeto a la verificación de la receta médica. Una vez aprobada, recibirás un correo electrónico con el enlace para realizar el pago.
                                <br>
                                <strong>Nota2:</strong> La fecha de aplicación es importante para preparar la entrega del pedido antes de la intervención quirúrgica. Asegúrese de que la fecha coincida con el plan de la intervención.
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .carousel-inner img {
        width: 100%;
        height: auto;
    }

    .carousel-inner {
        height: 350px;
        overflow: hidden;
    }

    .carousel-inner .item {
        height: 100%;
    }

    .button-group a {
        margin-right: 10px;
    }

    .box-body p {
        font-size: 16px;
        line-height: 1.5;
    }

    .box-body i {
        margin-right: 5px;
        color: #3c8dbc;
    }

    /* Estilos adicionales para el formulario */
    .form-group {
        margin-bottom: 20px;
    }

    #receta {
        padding: 6px;
    }

    #aclaracion {
        resize: none;
    }
</style>
<script>
    // Evita que se ingresen caracteres no numéricos
    function preventInvalidInput(event) {
        if (event.key.length === 1 && !/[0-9]/.test(event.key)) {
            event.preventDefault();
        }
    }

    // Limitar a 2 dígitos en total
    function limitInputLength(input) {
        if (input.value.length > 2) {
            input.value = input.value.slice(0, 2);
        }
    }

    function validarCantidad() {
        const cantidadInput = document.getElementById("cantidad");
        const cantidad = parseInt(cantidadInput.value);
        const productoId = document.getElementById('id').value;

        // Obtener el token CSRF desde la metaetiqueta generada por CakePHP
        const csrfToken = "<?php echo $this->request->getAttribute('csrfToken'); ?>";

        if (isNaN(cantidad) || cantidad <= 0) {
            alert("Por favor, ingrese una cantidad válida.");
            return;
        }

        fetch(`/productos/stock/${productoId}`)

            .then(response => response.json())
            .then(data => {
                const stockDisponible = data.stock;
                if (cantidad > stockDisponible) {
                    alert(`La cantidad ingresada (${cantidad}) excede el stock disponible (${stockDisponible}).`);
                    cantidadInput.value = ""; // Borrar la cantidad
                }
            })
            .catch(error => console.error('Error al cargar localidades:', error));


    }



    // Función para validar la fecha de aplicación que sea mayor a la actual
    function validarFechaAplicacion() {
        const fechaAplicacionInput = document.getElementById("fecha_aplicacion");
        const fechaAplicacion = new Date(fechaAplicacionInput.value);
        const fechaActual = new Date();
        fechaActual.setDate(fechaActual.getDate() + 1);
        // Eliminar horas, minutos y segundos para comparar solo las fechas
        fechaActual.setHours(0, 0, 0, 0);

        if (fechaAplicacion <= fechaActual) {
            alert("La fecha de aplicación debe ser mayor a la fecha actual.");
            // Establecer la fecha actual en el input
            const año = fechaActual.getFullYear();
            const mes = ("0" + (fechaActual.getMonth() + 1)).slice(-2); // Asegura que el mes tenga 2 dígitos
            const dia = ("0" + fechaActual.getDate()).slice(-2); // Asegura que el día tenga 2 dígitos
            const fechaHoy = `${año}-${mes}-${dia}`;

            fechaAplicacionInput.value = fechaHoy; // Establecer la fecha actual
            return false;
        }
        return true;
    }


    document.addEventListener("DOMContentLoaded", function() {

        const fechaAplicacionInput = document.getElementById("fecha_aplicacion");

        // Evento 'blur' para avisar al dejar el campo
        fechaAplicacionInput.addEventListener('blur', function() {
            validarFechaAplicacion();
        });

        const cantidadInput = document.getElementById("cantidad");

        // Evento 'blur' para avisar al dejar el campo
        cantidadInput.addEventListener('blur', function() {
            validarCantidad();
        });

        // Evento 'submit' para validar al enviar el formulario
        document.getElementById("pedidoForm").addEventListener("submit", function(event) {
            if (!validarFechaAplicacion()) {
                event.preventDefault(); // Prevenir el envío si la fecha es inválida
            }
            if (!validarCantdidad()) {
                event.preventDefault(); // Prevenir el envío si no existe stock para la cantidad solicitada
            }
        });
    });
</script>
