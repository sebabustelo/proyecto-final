<!-- Product Detail Section -->
<section class="content-header">
    <h1><i class="fa fa-fw fa-medkit"></i> Detalles del Producto</h1>
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
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                                    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                                    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                                </ol>
                                <div class="carousel-inner">
                                    <div class="item active">
                                        <img src="/img/productos/<?php echo $producto->productos_archivos[0]->file_name; ?>" alt="Producto 1">
                                    </div>
                                    <div class="item">
                                        <img src="http://placehold.it/900x500/3c8dbc/ffffff&text=I+Love+Bootstrap" alt="Second slide">
                                    </div>
                                    <div class="item">
                                        <img src="http://placehold.it/900x500/f39c12/ffffff&text=I+Love+Bootstrap" alt="Third slide">
                                    </div>
                                </div>
                                <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                                    <span class="fa fa-angle-left"></span>
                                </a>
                                <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                                    <span class="fa fa-angle-right"></span>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h4><?php echo $producto->nombre; ?></h4>
                            <p>
                                <i class="fa fa-tag"></i> <strong>Precio: </strong><?php echo $producto->precio; ?>
                            </p>
                            <p>
                                <i class="fa fa-info-circle"></i> <strong>Info del producto: </strong><?php echo $producto->descripcion_breve; ?>
                            </p>
                            <p>
                                <i class="fa fa-align-left"></i> <strong>Descripción: </strong><?php echo $producto->descripcion_larga; ?>
                            </p>
                            <div class="button-group">
                                <a href="/Pedidos/buy" class="btn btn-success" role="button">Comprar</a>
                                <a href="/Pedidos/addCart" class="btn btn-primary" role="button">
                                    <span class="fa fa-shopping-cart"></span> Agregar al Carrito
                                </a>
                                <a href="/productos/catalogoCliente" class="btn btn-default" role="button">Volver a Productos</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
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
        margin-right: 10px; /* Espacio entre botones */
    }

    /* Estilos para el icono en la información del producto */
    .box-body p {
        font-size: 16px; /* Aumenta el tamaño de fuente */
        line-height: 1.5; /* Mejora el espaciado de línea */
    }

    /* Estilos para los iconos */
    .box-body i {
        margin-right: 5px; /* Espacio entre el icono y el texto */
        color: #3c8dbc; /* Cambia el color de los iconos */
    }
</style>
