<!-- Products Section -->
<section class="content-header">
    <h1>
        Productos
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-users"></i> Productos</a></li>
        <li class="active">catalogo</li>
    </ol>
</section>

<section id="CatalogoClienteList" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header  with-border">
                    <h3 class="box-title"> <span class="fa fa-search fa-lg"></span> </h3>
                    <form method="get" accept-charset="utf-8" class="form abox" id="formOrderFilter" action="/productos/catalogo_cliente">

                        <div class="form-row text-center">
                            <div class="input-group col-md-6 col-md-offset-3 ">
                                <input type="text" name="search" value="<?php echo (isset($filters['search'])) ? $filters['search'] : '' ?>" placeholder=" Buscar productos... " class="form-control">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-primary btn-flat"> <span class="glyphicon glyphicon-search"></span></button>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.box-header -->

                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <div class="row">
        <?php foreach ($productos as $k => $producto) { ?>
            <div class="col-sm-6 col-md-3">
                <div class="thumbnail product-item">
                    <img src="/img/productos/<?php echo $producto->productos_archivos[0]->file_name; ?>" alt="Producto 1">
                    <div class="caption">
                        <h4><?php echo $producto->nombre; ?></h4>
                        <p>Precio: <?php echo "$".$producto->productos_precios[0]->precio; ?></p>
                        <p>
                            <?php
                            $descripcion = $producto->descripcion_breve;
                            if (strlen($descripcion) > 100) {
                                $descripcion = substr($descripcion, 0, strrpos(substr($descripcion, 0, 150), ' ')) . '...';
                            }
                            echo $descripcion;
                            ?>
                        </p>
                        <div class="button-group">
                            <a href="/Productos/detail/<?php echo $producto->id ?>" class="btn btn-success" role="button"><i class="fa fa-file"></i> Solicitud y Detalles</a>
                            <a href="/Pedidos/addCart" class="btn btn-primary" role="button"> <span class="fa fa-shopping-cart"></span></a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

    </div>
</section>






<!--
<div class="col-md-6">
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">Carousel</h3>
        </div>

        <div class="box-body">
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
                    <li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
                </ol>
                <div class="carousel-inner">
                    <div class="item active">
                        <img src="/img/productos/fassier-duval.jpg" alt="Producto 1">

                        <div class="carousel-caption">
                            fassier
                            <p><a href="#" class="btn btn-sm btn-primary" role="button">Comprar</a></p>

                        </div>
                    </div>
                    <div class="item">
                        <img src="http://placehold.it/900x500/3c8dbc/ffffff&text=I+Love+Bootstrap" alt="Second slide">

                        <div class="carousel-caption">
                            Second Slide
                        </div>
                    </div>
                    <div class="item">
                        <img src="http://placehold.it/900x500/f39c12/ffffff&text=I+Love+Bootstrap" alt="Third slide">

                        <div class="carousel-caption">
                            Third Slide
                        </div>
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

    </div>

</div> -->
<style>
    /* Para asegurar que las columnas sean flexibles */
    .row {
        display: flex;
        flex-wrap: wrap;
    }

    /* Asegura que cada tarjeta (thumbnail) tenga la misma altura y use flexbox */
    .thumbnail.product-item {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
    }

    /* Define que el contenido de la tarjeta crezca */
    .thumbnail .caption {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        flex-grow: 1;
    }

    /* Botones alineados al final */
    .button-group {
        margin-top: auto;
        display: flex;
        justify-content: space-between;
        padding-top: 10px;
    }

    /* Limitar la altura de la imagen para que no expanda la tarjeta */
    .thumbnail img {
        margin-bottom: 15px;
        max-height: 200px;
        width: 100%;
        object-fit: cover;
    }

    /* Asegurar que todos los thumbnails tengan la misma altura */
    .thumbnail {
        min-height: 400px;
        /* Ajusta esta altura dependiendo de lo que necesitas */
    }
</style>
