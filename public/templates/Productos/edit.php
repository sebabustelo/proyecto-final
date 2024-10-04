<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Producto $producto
 * @var \Cake\Collection\CollectionInterface|string[] $categorias
 * @var \Cake\Collection\CollectionInterface|string[] $proveedores
 */
?>
<section class="content-header">
    <h1>
        <i class="fa fa-fw fa-medkit"></i> Gestión de Productos
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa  fa-dot-circle-o"></i>Productos</a></li> <i class="fa fa-arrow-right"></i>
        <li class="active">Editar</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header  with-border">
                    <h3 class="box-title"> <span class="fa fa-refresh fa-lg"></span> Editar Producto</h3>
                    <div class="box-tools pull-right">
                        <a href="/Productos/index/" class="btn btn-sm btn-primary ">
                            <span class="fa fa-list"></span> Productos</a>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-row">
                        <form id="ProductosEditForm" name="ProductosEditForm" role="form" action="/Productos/edit/<?php echo $producto->id; ?>" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getAttribute('csrfToken'); ?>">
                            <div class="form-group col-sm-4">
                                <label>Nombre</label>
                                <input required type="text" maxlength="150" placeholder="Ingrese el nombre" class="form-control" name="nombre" value="<?php echo $producto->nombre; ?>">
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
                                        <?php if ($id ==  $producto->categoria_id) { ?>
                                            <option selected value="<?php echo $id; ?>"><?php echo $categoria; ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $id; ?>"><?php echo $categoria; ?></option>
                                        <?php } ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group col-sm-2">
                                <label>Proveedores</label><br>
                                <select required name="proveedor_id" class="form-control">
                                    <option value="">Seleccione un proveedor</option>
                                    <?php foreach ($proveedores as $id => $proveedor) : ?>
                                        <?php if ($id ==  $producto->proveedor_id) { ?>
                                            <option selected value="<?php echo $id; ?>"><?php echo $proveedor; ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $id; ?>"><?php echo $proveedor; ?></option>
                                        <?php } ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group col-sm-2">
                                <label>Stock</label>
                                <input required type="number" maxlength="3" name="stock" min="0" placeholder="Ingrese el stock" 
                                class="form-control" value="<?php echo $producto->stock; ?>">
                                <?php if ($producto->getError('stock')) { ?>
                                    <?php foreach ($producto->getError('stock') as $error) { ?>
                                        <span class="badge bg-red"><i class="fa fa-warning"></i> <?php echo $error; ?></span>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <div class="form-group col-sm-2">
                                <label>Precio</label>
                                <input required type="number" maxlength="6" placeholder="Ingrese el precio" name="productos_precios[0][precio]" step="0.01" min="0" class="form-control" value="<?php echo $producto->productos_precios[0]->precio; ?>">
                                <?php if ($producto->getError('precio')) { ?>
                                    <?php foreach ($producto->getError('precio') as $error) { ?>
                                        <span class="badge bg-red"><i class="fa fa-warning"></i> <?php echo $error; ?></span>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <div class="form-group col-sm-12">
                                <label>Descripción</label>
                                <textarea required maxlength="2000" rows="3" placeholder="Ingrese la descripción" class="form-control" name="descripcion_breve"><?php echo $producto->descripcion_breve; ?></textarea>
                                <?php if ($producto->getError('descripcion_breve')) { ?>
                                    <?php foreach ($producto->getError('descripcion_breve') as $error) { ?>
                                        <span class="badge bg-red"><i class="fa fa-warning"></i> <?php echo $error; ?></span>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <div class="col-sm-12">
                                <div class="verify-sub-box">
                                    <div class="file-loading">
                                        <input id="imagenes" name="imagenes[]" accept=".jpg, .jpeg, .png, .gif" type="file" multiple>
                                    </div>
                                </div>
                                <div class="kv-avatar-hint">
                                    <small>Las imagenes deben ser menor a < 1500 KB para optimizar la carga del portal</small>
                                </div>
                            </div>

                            <div class="form-row form-group col-sm-12 callout callout-info" role="alert">
                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                                La primera imagen se mostrará en la vista de productos del cliente, y las imágenes secundarias serán visibles al ingresar en el detalle del mismo.
                            </div>


                            <?php
                            if ($this->request->getSession()->check('previousUrl')) {
                                $url = $this->request->getSession()->read('previousUrl');
                                if (strpos($url, "Productos") !== false) {
                                    $url = $this->request->getSession()->read('previousUrl');
                                } else {
                                    $url = "/Productos/index/";
                                }
                            } else {
                                $url = '/Productos/index';
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

                        <div class="col-sm-12">
                            <label>Historial de Precios</label>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>

                                        <th>Fecha Desde</th>
                                        <th>Fecha Hasta</th>
                                        <th>Precio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($producto->productos_precios as $precio) : ?>
                                        <tr>

                                            <td><?php echo "" . $precio->fecha_desde->format('d/m/Y h:i:s'); ?></td>
                                            <td>
                                                <?php
                                                if ($precio->fecha_hasta) {
                                                    echo $precio->fecha_hasta->format('d/m/Y h:i:s');
                                                } else {
                                                    echo 'Actual';
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo "$" . number_format($precio->precio, 2); ?> </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
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
    $("#imagenes").fileinput({
        language: "es",
        theme: "fa4",
        uploadUrl: "/ProductosArchivos/add", // URL donde se procesan los archivos
        maxFileSize: 1500, // Tamaño máximo de archivo
        allowedFileExtensions: ["jpg", "jpeg", "png", "gif"], // Extensiones permitidas
        overwriteInitial: false,

        showRemove: false,
        showUpload: false,
        showClose: false,
        showCaption: false,


        browseClass: "btn btn-success",
        browseLabel: "Imagenes",
        browseIcon: "<i class='fa fa-plus'></i>",
        allowedFileExtensions: ["jpg", "png", "gif"],

        // fileActionSettings: {
        //     showUpload: false,
        //     showRotate: false,
        //     allowFullScreen: false,
        //     zoomIcon: '<i class="fa fa-search-plus"></i> ',
        //     removeIcon: '<i class="fa fa-trash-o"></i> ',
        // },

        initialPreview: [
            <?php foreach ($producto->productos_archivos as $archivo) : ?> '<img src="/img/productos/<?php echo $archivo['file_name']; ?>" class="file-preview-image kv-preview-data">',
            <?php endforeach; ?>
        ],
        initialPreviewConfig: [

            <?php foreach ($producto->productos_archivos as $archivo) : ?>
                <?php
                $underscorePos = strpos($archivo['file_name'], '_');
                $nombreOriginal = substr($archivo['file_name'], $underscorePos + 1);
                ?> {
                    caption: "<?php echo $nombreOriginal; ?>",
                    size: <?php echo $archivo['file_size']; ?>,
                    url: "/ProductosArchivos/delete/<?php echo $archivo['id']; ?>",
                    key: "<?php echo $archivo['es_principal']; ?>"
                },
            <?php endforeach; ?>
        ],
        ajaxDeleteSettings: {
            headers: {
                'X-CSRF-Token': '<?php echo $this->request->getAttribute('csrfToken'); ?>'
            }
        },
        uploadExtraData: function() {
            return {
                '_csrfToken': '<?php echo $this->request->getAttribute('csrfToken'); ?>',
                'producto_id': '<?php echo $producto->id; ?>'
            };
        },
    }).on("filebatchselected", function(event, files) {
        $("#imagenes").fileinput("upload");
    });;
</script>