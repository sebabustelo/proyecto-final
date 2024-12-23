<!-- Products Section -->
<section class="content-header">
    <h1>
        Categoría de Producto : <?php echo $categoria->nombre; ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-fw fa-medkit"></i> Productos</a></li>
        <li class="active">categorías</li>
    </ol>
</section>
<section id="CatalogoClienteList" class="content">
    <?php if (count($productos) > 0) { ?>
        <div class="row">
            <?php foreach ($productos as $k => $producto) { ?>
                <div class="col-sm-6 col-md-3 " style="margin-bottom: 20px;">
                    <div class="thumbnail product-item">
                        <img src="/img/productos/<?php echo $producto->productos_archivos[0]->file_name; ?>" alt="Producto 1">
                        <div class="caption">
                            <h4><?php echo $producto->nombre; ?></h4>
                            <p>Precio: <?php echo "$" . $producto->productos_precios[0]->precio; ?></p>
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
                                <a href="/Productos/detail/<?php echo $producto->id ?>" class="btn btn-success" role="button"><i class="fa fa-shopping-bag"></i> Solicitar</a>
                                <!-- <a href="/Pedidos/addCart" class="btn btn-primary" role="button"> <span class="fa fa-shopping-cart"></span></a> -->
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div class="text-center">
            <ul class="pagination justify-content-center">
                <li class="page-item">
                    <?php echo $this->Paginator->first('<<'); ?>
                    <?php echo $this->Paginator->prev('<'); ?>
                </li>
                <li class="page-item">
                    <?php echo $this->Paginator->numbers(['modulus' => 4]); ?>
                </li>
                <li class="page-item">
                    <?php echo $this->Paginator->next('>'); ?>
                    <?php echo $this->Paginator->last('>>'); ?>
                </li>
            </ul>
            <p class="text-center">
                Página: <?php echo $this->Paginator->counter('{{page}} de {{pages}}, mostrando {{current}} productos de {{count}}'); ?>
            </p>
        </div>
    <?php } else { ?>
        <div class="no-products-message" style="text-align: center; margin-top: 50px;">
            <i class="fa fa-info-circle" style="font-size: 50px; color: #007bff;"></i>
            <h3 style="color: #333; margin-top: 10px;">No existen productos en esta categoría.Por favor, explore otras categorías.</h3>

        </div>

    <?php } ?>

</section>





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
        margin-bottom: 10px;
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
