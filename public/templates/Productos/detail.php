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
                                <input type="hidden" name="csrfToken" value="<?php echo $this->request->getAttribute('csrfToken'); ?>">
                                <p>
                                    <i class="fa fa-fw  fa-cube"></i> <strong>Datos solicitados: </strong>
                                <div class="form-group col-md-8">
                                    <label for="orden_medica">Cargar receta médica</label>
                                    <input type="file" class="form-control" name="orden_medica" id="orden_medica" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="fecha_intervencion" >Fecha de Intervención</label>
                                    <input type="hidden" value="<?php echo $producto->id; ?>" id="id" name="detalles_pedidos[0][producto_id]">
                                    <input type="date" class="form-control" name="fecha_intervencion"
                                        min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" id="fecha_intervencion" required>
                                </div>
                                <!-- Cantidad -->

                                <!-- <div class="form-group col-md-2">
                                <?php //debug($this->request->getData('detalle_pedido')[0]['cantidad']) ?>
                                    <label for="cantidad">Cantidad</label>
                                    <input onkeydown="preventInvalidInput(event)" oninput="limitInputLength(this)"
                                        type="number" class="form-control" id="cantidad"  value="<?php echo $this->request->getData('detalle_pedido')[0]['cantidad'] ?? ''; ?>"
                                        name="detalles_pedidos[0][cantidad]" min="1" max="99" required>
                                </div> -->

                                <div class="form-group col-md-12">
                                    <label for="comentario">Aclaraciones</label>
                                    <textarea class="form-control" name="comentario" value="<?php echo $this->request->getData('comentario') ?? ''; ?>" id="comentario" rows="2" maxlength="500" placeholder="Escriba aquí cualquier comentario..." ></textarea>
                                </div>
                                </p>
                                <p>
                                    <?php $direccion =     $this->getRequest()->getSession()->read('RbacUsuario')->direccion;
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
                                                class="form-control" placeholder="Número" min="1" max="9999" oninput="this.value = this.value.slice(0, 5);">
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

                                <div class="button-group">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fa fa-check" style="color: white;"></i> Solicitar
                                    </button>
                                    <!-- <a href="/Pedidos/addCart" class="btn btn-primary" role="button">
                                        <span class="fa fa-shopping-cart"></span> Agregar al Carrito
                                    </a> -->
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

    #comentario {
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



    // Función para validar la fecha de intervención que sea mayor a la actual
    function validarFechaIntervencion() {
        const fechaIntervencionInput = document.getElementById("fecha_intervencion");
        const fechaIntervencion = new Date(fechaIntervencionInput.value);
        const fechaActual = new Date();
        fechaActual.setDate(fechaActual.getDate() + 1);
        // Eliminar horas, minutos y segundos para comparar solo las fechas
        fechaActual.setHours(0, 0, 0, 0);

        if (fechaIntervencion <= fechaActual) {
            alert("La fecha de intervención debe ser mayor a la fecha actual.");
            // Establecer la fecha actual en el input
            const año = fechaActual.getFullYear();
            const mes = ("0" + (fechaActual.getMonth() + 1)).slice(-2); // Asegura que el mes tenga 2 dígitos
            const dia = ("0" + fechaActual.getDate()).slice(-2); // Asegura que el día tenga 2 dígitos
            const fechaHoy = `${año}-${mes}-${dia}`;

            fechaIntervencionInput.value = fechaHoy; // Establecer la fecha actual
            return false;
        }
        return true;
    }


    document.addEventListener("DOMContentLoaded", function() {

        const fechaIntervencionInput = document.getElementById("fecha_intervencion");

        // Evento 'blur' para avisar al dejar el campo
        fechaIntervencionInput.addEventListener('blur', function() {
            validarFechaIntervencion();
        });

       // const cantidadInput = document.getElementById("cantidad");

        // Evento 'blur' para avisar al dejar el campo
        // cantidadInput.addEventListener('blur', function() {
        //     validarCantidad();
        // });

        // Evento 'submit' para validar al enviar el formulario
        document.getElementById("pedidoForm").addEventListener("submit", function(event) {
            if (!validarFechaIntervencion()) {
                event.preventDefault(); // Prevenir el envío si la fecha es inválida
            }
            if (!validarCantdidad()) {
                event.preventDefault(); // Prevenir el envío si no existe stock para la cantidad solicitada
            }
        });

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

            var localidadId = "<?php echo $direccion->localidad_id ?? ''; ?>";
            if (localidadId) {
                document.getElementById('localidad_id').value = localidadId;
            }
        }, 1000); // Ajusta el tiempo según sea necesario
    });
</script>
