<section class="content-header">
    <h1>
        <i class="fa fa-lg fa-fw fa-shopping-cart"></i> Mis Pedidos
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-fw fa-shopping-cart"></i> Mis Pedidos</a></li>
        <li class="active">inicio</li>
    </ol>
</section>



<section id="MisPedidos" class="content">

    <div class="row">
        <?php foreach ($pedidos as $k => $pedido) { ?>
            <div class="col-xs-12 col-sm-6 ">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <i class="fa fa-calendar"></i>
                        <?php setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'Spanish_Spain', 'es_AR'); ?>
                        <h3 class="box-title">Fecha de Pedido <?php echo $pedido->fecha_pedido->i18nFormat('dd/MM/yyyy'); ?>


                        </h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="col-xs-4">
                            <img src="/img/productos/<?php echo $pedido->detalles_pedidos[0]->producto->productos_archivos[0]->file_name  ?>" alt="Photo" class="img-responsive pad">
                        </div>
                        <div class="col-xs-8">
                            <br>
                            <div class="comment-text">
                                <span class="label
                                                    <?php
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
                                                        case 'CANCELADO':
                                                            echo 'bg-red'; // Fondo verde
                                                            break;
                                                        default:
                                                            echo 'bg-gray'; // Fondo gris por defecto
                                                            break;
                                                    }
                                                    ?>">
                                    <?php echo $pedido->pedidos_estado->nombre; ?>
                                </span><br>
                                <?php echo  "Fecha de Intervención:", $pedido->fecha_intervencion; ?> <br>
                                <?php echo  $pedido->detalles_pedidos[0]->producto->nombre ?>
                            </div>
                            <div class="comment-text pull-right">
                                <button type="button" class="btn btn-block btn-primary">Ver detalles</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>



    </div>
</section>
