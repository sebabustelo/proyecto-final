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

<section id="RbacUsuariosList" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header  with-border">
                    <h3 class="box-title"> <span class="fa fa-search fa-lg"></span> </h3>

                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form method="get" accept-charset="utf-8" class="form abox" id="formOrderFilter" action="/productos/search">

                        <div class="form-row text-center">
                            <div class="input-group col-md-6 col-md-offset-3 ">
                                <input type="text" name="message" placeholder=" Buscar productos... " class="form-control">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-primary btn-flat"> <span class="glyphicon glyphicon-search"></span></button>
                                </span>
                            </div>

                            <!-- <div class="form-group col-md-4 ">
                                <button type="button" id="limpiar" class="btn btn-default">
                                    <span class="glyphicon glyphicon-trash"></span>
                                    Limpiar</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <button type="submit" id="enviar" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-search"></span>
                                    Buscar</button>


                                <script>
                                    $(function() {
                                        $('#limpiar').on('click', function() {
                                            $('#formOrderFilter').find(
                                                'input:text, input:password, select, textarea').val('');
                                            $('#formOrderFilter').find(
                                                'input:radio, input:checkbox:not(#activo)').prop(
                                                'checked', false);
                                            document.getElementById("activo").checked = true;

                                            $('#formOrderFilter').submit();

                                            return false;
                                        });
                                    });
                                </script>
                                <div id="filterErrors">
                                </div>
                            </div> -->

                        </div>


                    </form>
                </div>
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
                        <p>Precio: <?php echo $producto->precio; ?></p>
                        <p><a href="/Productos/buy" class="btn btn-success" role="button">Comprar</a>
                            <a href="/Productos/detail/<?php echo $producto->id ?>" class="btn btn-warning" role="button">Detalles</a>
                            <a href="/Pedidos/addCart" class="btn btn-primary" role="button"> <span class="fa fa-shopping-cart"></span></a>

                        </p>
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