<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Producto $producto
 * @var \Cake\Collection\CollectionInterface|string[] $categorias
 * @var \Cake\Collection\CollectionInterface|string[] $proveedores
 */
?>
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estado $estado
 */
?>


<section class="content-header">
    <h1>
        Administración
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"> Kit de Cirugías</a></li> <i class="fa fa-arrow-right"></i>
        <li class="active">Agregar</li>
    </ol>
</section>
<section id="ProductosAddForm" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header  with-border">
                    <h3 class="box-title"> <span class="fa fa-plus fa-lg"></span> Nuevo Kit de Cirugía</h3>
                    <div class="box-tools pull-right">
                        <a href="/Productos/index/" class="btn btn-sm btn-primary ">
                            <span class="fa fa-list"></span> Kits de Cirugías</a>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-row">
                        <form id="ProductosAddForm" name="ProductosAddForm" role="form" action="/Productos/add/" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getAttribute('csrfToken'); ?>">
                            <div class="form-group col-sm-4">
                                <label >Nombre</label>
                                <input required type="text" maxlength="150" placeholder="Ingrese el nombre" class="form-control" name="nombre" oninvalid="this.setCustomValidity('Debe completar el nombre')" oninput="this.setCustomValidity('')">
                                <?php if ($producto->getError('nombre')) { ?>
                                    <?php foreach ($producto->getError('nombre') as $error) { ?>
                                        <span class="badge bg-red"><i class="fa fa-warning"></i> <?php echo $error; ?></span>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <div class="form-group col-sm-2">
                                <label>Categoría</label><br>
                                <select required name="categoria_id" class="form-control">
                                    <option value="">Seleccione una categoría</option>
                                    <?php foreach ($categorias as $id => $categoria) : ?>
                                        <option value="<?php echo $id; ?>"><?php echo $categoria; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group col-sm-2">
                                <label>Proveedores</label><br>
                                <select required name="proveedor_id" class="form-control">
                                    <option value="">Seleccione un proveedor</option>
                                    <?php foreach ($proveedores as $id => $proveedor) : ?>
                                        <option value="<?php echo $id; ?>"><?php echo $proveedor; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group col-sm-2">
                                <label>Stock</label>
                                <input style='text-transform: uppercase;' required type="number" maxlength="3" placeholder="Ingrese el stock"
                                    class="form-control" onkeydown="preventInvalidInput(event)" name="stock" oninput="this.setCustomValidity('')">
                                <?php if ($producto->getError('stock')) { ?>
                                    <?php foreach ($producto->getError('stock') as $error) { ?>
                                        <span class="badge bg-red"><i class="fa fa-warning"></i> <?php echo $error; ?></span>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <div class="form-group col-sm-2">
                                <label>Precio</label>
                                <input style='text-transform: uppercase;' required type="number" maxlength="6" placeholder="Ingrese el precio"
                                    class="form-control" onkeydown="preventInvalidInput(event)" name="precio" step="0.01" oninput="this.setCustomValidity('')">
                                <?php if ($producto->getError('precio')) { ?>
                                    <?php foreach ($producto->getError('precio') as $error) { ?>
                                        <span class="badge bg-red"><i class="fa fa-warning"></i> <?php echo $error; ?></span>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <div class="form-group col-sm-12">
                                <label>Descripción</label>
                                <textarea style='text-transform: uppercase;' required maxlength="2000" rows="5" placeholder="Ingrese la descripción" class="form-control" name="descripcion" oninvalid="this.setCustomValidity('Debe completar la descripción')" oninput="this.setCustomValidity('')"></textarea>
                                <?php if ($producto->getError('descripcion')) { ?>
                                    <?php foreach ($producto->getError('descripcion') as $error) { ?>
                                        <span class="badge bg-red"><i class="fa fa-warning"></i> <?php echo $error; ?></span>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <!-- <div class="col-sm-3">
                                <div class="verify-sub-box">
                                    <div class="file-loading">
                                        <input id="imagen-principal" name="imagen-principal" type="file" required>
                                    </div>
                                </div>
                                <div class="kv-avatar-hint">
                                    <small>La imagen debe ser menor a < 1500 KB</small>
                                </div>
                            </div> -->
                            <div class="col-md-12">
                                <div class="verify-sub-box">
                                    <div class="file-loading">
                                        <input class="imagenes" type="file" accept=".jpg,.gif,.png"  multiple name="imagenes[]">
                                    </div>
                                </div>
                                <div class="kv-avatar-hint">
                                    <small>Las imagenes debe ser menor a < 1500 KB</small>
                                </div>
                            </div>

                            <?php
                            if ($this->request->getSession()->check('previousUrl')) {
                                $url = $this->request->getSession()->read('previousUrl');
                                if (strpos($url, "Estados") !== false) {
                                    $url = $this->request->getSession()->read('previousUrl');
                                } else {
                                    $url = "/Estados/index/";
                                }
                            } else {
                                $url = '/Estados/index';
                            }
                            ?>

                            <div class="form-group col-sm-12 text-center" style="margin-top:25px;">
                                <a href="<?php echo $url; ?>" class="btn btn-danger">
                                    <span class="fa fa-remove"></span> Cancelar</a>
                                <button type="submit" class="btn btn-primary">
                                    <span class="fa  fa-check-square-o"></span>
                                    Guardar</button>
                            </div>
                        </form>

                        <div class="form-row form-group col-sm-12 callout callout-info" role="alert">
                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                            La imagen principal se mostrará en la vista de kits de cirugías del cliente, y las imágenes secundarias serán visibles al ingresar en el detalle del mismo.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function preventInvalidInput(event) {
        const invalidChars = ['e', 'E', '+', '-']; // caracteres que quieres restringir
        if (invalidChars.includes(event.key)) {
            event.preventDefault();
        }
    }
    // theme: "explorer-fa4",
    // $("#imagen-principal").fileinput({
    //     language: "es",
    //     theme: "fa4",
    //     'uploadUrl': '#',
    //     maxFileSize: 1500,
    //     showRemove: false,
    //     showUpload: false,
    //     showClose: false,
    //     showCaption: false,

    //     browseClass: "btn btn-success",
    //     browseLabel: "Imagen Principal",
    //     browseIcon: "<i class='fa fa-plus'></i>",
    //     allowedFileExtensions: ["jpg", "png", "gif"],

    //     fileActionSettings: {
    //         showUpload: false,
    //         showRotate: false,
    //         allowFullScreen: false,
    //         zoomIcon: '<i class="fa fa-search-plus"></i> ',
    //         removeIcon: '<i class="fa fa-trash-o"></i> ',
    //     },
    // });

    $(".imagenes").fileinput({
       // language: "es",
       // theme: "fa4",
        'uploadUrl': '#',
        // maxFileSize: 1500,
        //showRemove: false,
        showUpload: false,
        // showZoom: false,
        // showCaption: false,
        maxFileCount: 4,

        browseClass: "btn btn-success",
        browseLabel: "Imagenes",
        browseIcon: "<i class='fa fa-plus'></i>",
        // overwriteInitial: false,
        // initialPreviewAsData: true,
        allowedFileExtensions: ["jpg", "png", "gif"],



    });
</script>
