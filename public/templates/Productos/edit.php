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
        Administración
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"> Kit de Cirugías</a></li> <i class="fa fa-arrow-right"></i>
        <li class="active">Editar</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header  with-border">
                    <h3 class="box-title"> <span class="fa fa-refresh fa-lg"></span> Editar Kit de Cirugía</h3>
                    <div class="box-tools pull-right">
                        <a href="/Productos/index/" class="btn btn-sm btn-primary ">
                            <span class="fa fa-list"></span> Kits de Cirugías</a>
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
                                <input style='text-transform: uppercase;' required type="number" maxlength="3" placeholder="Ingrese el stock" class="form-control" value="<?php echo $producto->stock; ?>">
                                <?php if ($producto->getError('stock')) { ?>
                                    <?php foreach ($producto->getError('stock') as $error) { ?>
                                        <span class="badge bg-red"><i class="fa fa-warning"></i> <?php echo $error; ?></span>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <div class="form-group col-sm-2">
                                <label>Precio</label>
                                <input style='text-transform: uppercase;' required type="number" maxlength="6" placeholder="Ingrese el precio" class="form-control" value="<?php echo $producto->precio; ?>">
                                <?php if ($producto->getError('precio')) { ?>
                                    <?php foreach ($producto->getError('precio') as $error) { ?>
                                        <span class="badge bg-red"><i class="fa fa-warning"></i> <?php echo $error; ?></span>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <div class="form-group col-sm-12">
                                <label>Descripción</label>
                                <textarea style='text-transform: uppercase;' required maxlength="2000" rows="5" placeholder="Ingrese la descripción"
                                    class="form-control" name="descripcion_breve"><?php echo $producto->descripcion_breve; ?></textarea>
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
                                    <small>La imagen debe ser menor a < 1500 KB</small>
                                </div>
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
    $("#imagenes").fileinput({
        language: "es",
        theme: "fa4",
        'uploadUrl': '#',
        maxFileSize: 1500,
        showRemove: false,
        showUpload: false,
        showClose: false,
        showCaption: false,

        browseClass: "btn btn-success",
        browseLabel: "Imagenes",
        browseIcon: "<i class='fa fa-plus'></i>",
        allowedFileExtensions: ["jpg", "png", "gif"],

        overwriteInitial: false,


        fileActionSettings: {
            showUpload: false,
            showRotate: false,
            allowFullScreen: false,
            zoomIcon: '<i class="fa fa-search-plus"></i> ',
            removeIcon: '<i class="fa fa-trash-o"></i> ',
        },
        initialPreview: [
            // IMAGE DATA
            <?php
            foreach ($producto->productos_archivos as $k => $producto_archivo) { ?> '<img src="/img/productos/<?php echo $producto_archivo['file_name']; ?>" class="file-preview-image kv-preview-data" alt="fin_short.jpg" >',
            <?php }        ?>

        ],
       // initialPreviewAsData: true, // identify if you are sending preview data only and not the raw markup
        initialPreviewFileType: 'image', // image is the default and can be overridden in config below

        initialPreviewConfig: [{
                caption: "Desert.jpg",
                description: "<h5>The Desert</h5> This is a representative description number one for this image.",
                size: 827000,
                width: "120px",
                url: "/file-upload-batch/2",
                key: 1
            },
            {
                caption: "Lighthouse.jpg",
                description: "<h5>The Lighthouse</h5> This is a representative description number two for this image.",
                size: 549000,
                width: "120px",
                url: "/file-upload-batch/2",
                key: 2
            },

        ],

    });

    $('#ProductosEditForm').on('submit', function(event) {
        event.preventDefault(); // Evita el envío automático del formulario

        let formElement = document.getElementById('ProductosEditForm');

        let myFormData = new FormData(formElement); // Recoge todos los datos del formulario

        // Elimina los archivos previamente agregados en el FormData
        myFormData.delete('imagenes[]');

        // Obtén la lista de archivos seleccionados del plugin fileinput
        let filesObject = $('#imagenes').fileinput('getFileStack');

        // Convierte el objeto en un array de archivos
        let filesArray = Object.values(filesObject);

        // Añade los archivos al FormData
        filesArray.forEach(function(fileObj) {
            myFormData.append('imagenes[]', fileObj.file);
        });

        // Crea un formulario temporal para enviar los datos de FormData
        let tempForm = document.createElement('form');
        tempForm.method = 'POST';
        tempForm.action = formElement.action;
        tempForm.enctype = 'multipart/form-data';

        // Añade el CSRF Token
        let csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_csrfToken';
        csrfToken.value = formElement.querySelector('input[name="_csrfToken"]').value;
        tempForm.appendChild(csrfToken);

        // Añade los datos de FormData al formulario temporal
        for (let [key, value] of myFormData.entries()) {
            if (value instanceof File) {
                let inputFile = document.createElement('input');
                inputFile.type = 'file';
                inputFile.name = key;
                inputFile.files = new DataTransfer().files; // Necesario para los archivos
                let dataTransfer = new DataTransfer();
                dataTransfer.items.add(value);
                inputFile.files = dataTransfer.files;
                tempForm.appendChild(inputFile);
            } else {
                let input = document.createElement('input');
                input.type = 'hidden';
                input.name = key;
                input.value = value;
                tempForm.appendChild(input);
            }
        }

        // Añade el formulario temporal al documento y envíalo
        document.body.appendChild(tempForm);
        tempForm.submit();

        // Elimina el formulario temporal del documento
        document.body.removeChild(tempForm);

    });
</script>
<?php debug($producto) ?>
