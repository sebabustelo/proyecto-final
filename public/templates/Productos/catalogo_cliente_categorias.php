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
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header  with-border">
                    <h3 class="box-title"> <span class="fa fa-search fa-lg"></span> </h3>
                    <form method="get" accept-charset="utf-8" class="form abox" id="formOrderFilter" action="/productos/catalogo_cliente_categorias/<?php echo $categoria_id; ?>">

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
