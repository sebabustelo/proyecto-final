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
                                <i class="fa fa-tag"></i> <strong>Precio: </strong><?php echo $producto->productos_precios[0]->precio; ?>
                            </p>
                            <p>
                                <i class="fa fa-info-circle"></i> <strong>Info del producto: </strong><?php echo $producto->descripcion_breve; ?>
                            </p>
                            <p>
                                <i class="fa fa-align-left"></i> <strong>Descripción: </strong><?php echo $producto->descripcion_larga; ?>
                            </p>
                            <!-- Formulario para cargar receta y aclaración -->
                            <form action="/Pedidos/uploadPrescription" method="POST" enctype="multipart/form-data">

                                <div class="form-group col-md-6">
                                    <label for="receta">Cargar receta médica</label>
                                    <input type="file" class="form-control" name="receta" id="receta" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="fecha_aplicacion">Fecha de Aplicación</label>
                                    <input type="date" class="form-control" name="fecha_aplicacion" id="fecha_aplicacion" required>
                                </div>
                                <!-- Cantidad -->
                                <div class="form-group col-md-2">
                                    <label for="cantidad">Cantidad</label>
                                    <input type="number" class="form-control" name="cantidad" id="cantidad" min="1" required>
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
    document.getElementById('cantidad').addEventListener('keydown', function(e) {
        if (e.key === 'e' || e.key === 'E') {
            e.preventDefault();
        }
    });
</script>
