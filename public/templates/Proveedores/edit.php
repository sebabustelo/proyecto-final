<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estado $estado
 */
?>
<section class="content-header">
    <h1>
        Parámetros del sistema
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa  fa-dot-circle-o"></i>Proveedores</a></li> <i class="fa fa-arrow-right"></i>
        <li class="active">Editar</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header  with-border">
                    <h3 class="box-title"> <span class="fa fa-refresh fa-lg"></span> Editar Proveedor</h3>
                    <div class="box-tools pull-right">
                        <a title="Listado de proveedores" href="/Proveedores/index/" class="btn btn-sm btn-primary ">
                            <span class="fa fa-list"></span> <span class=" hidden-xs">Proveedores</span>
                        </a>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-row">
                        <form id="ProveedoresEditForm" name="ProveedoresEditForm" role="form" action="/Proveedores/edit/<?php echo $proveedor->id; ?>" method="POST">
                            <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getAttribute('csrfToken'); ?>">
                            <div class="form-group col-sm-4">
                                <label>Nombre</label>
                                <input required type="text" maxlength="255" placeholder="Ingrese el nombre" value="<?php echo $proveedor->nombre; ?>"
                                    class="form-control" name="nombre">
                                <?php if ($proveedor->getError('nombre')) { ?>
                                    <?php foreach ($proveedor->getError('nombre') as $error) { ?>
                                        <span class="badge bg-red"><i class="fa fa-warning"></i> <?php echo $error; ?></span>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <div class="form-group col-sm-2">
                                <label>CUIT</label>
                                <input required type="number" maxlength="11" id="cuit" placeholder="Ingrese el CUIT"
                                    class="form-control" name="cuit" oninvalid="this.setCustomValidity('Debe completar el CUIT')" oninput="this.setCustomValidity('')"
                                    value="<?php echo $proveedor->cuit; ?>">
                                <?php if ($proveedor->getError('cuit')) { ?>
                                    <?php foreach ($proveedor->getError('cuit') as $error) { ?>
                                        <span class="badge bg-red"><i class="fa fa-warning"></i> <?php echo $error; ?></span>
                                    <?php } ?>
                                <?php } ?>
                                <span id="mensaje-error" style="display: none;" class="badge bg-red"><i class="fa fa-warning"></i> El CUIT es inválido</span>
                            </div>
                            <div class="form-group col-sm-4">
                                <label>Email</label>
                                <input required type="email" maxlength="100" placeholder="Ingrese el email" value="<?php echo $proveedor->email; ?>"
                                    class=" form-control" name="email">
                                <?php if ($proveedor->getError('email')) { ?>
                                    <?php foreach ($proveedor->getError('email') as $error) { ?>
                                        <span class="badge bg-red"><i class="fa fa-warning"></i> <?php echo $error; ?></span>
                                    <?php } ?>
                                <?php } ?>

                            </div>
                            <div class="form-group col-sm-2">
                                <label>Teléfono</label>
                                <input required type="number" maxlength="120" placeholder="Ingrese el teléfono"
                                    class="form-control" name="telefono" value="<?php echo $proveedor->telefono; ?>">
                                <?php if ($proveedor->getError('telefono')) { ?>
                                    <?php foreach ($proveedor->getError('telefono') as $error) { ?>
                                        <span class=" badge bg-red"><i class="fa fa-warning"></i> <?php echo $error; ?></span>
                                    <?php } ?>
                                <?php } ?>

                            </div>
                            <div class="form-group col-sm-6">
                                <label>Descripción</label>
                                <input type="text" maxlength="500" placeholder="Ingrese una descripción"
                                    class="form-control" name="descripcion" value="<?php echo $proveedor->descripcion; ?>">
                                <?php if ($proveedor->getError('descripcion')) { ?>
                                    <?php foreach ($proveedor->getError('descripcion') as $error) { ?>
                                        <span class=" badge bg-red"><i class="fa fa-warning"></i> <?php echo $error; ?></span>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <div class="form-group col-sm-4">
                                <label>Dirección</label>
                                <input required type="text" maxlength="255" placeholder="Ingrese la dirección"
                                    class="form-control" name="direccion" value="<?php echo $proveedor->direccion; ?>">
                                <?php if ($proveedor->getError('direccion')) { ?>
                                    <?php foreach ($proveedor->getError('direccion') as $error) { ?>
                                        <span class="badge bg-red"><i class="fa fa-warning"></i> <?php echo $error; ?></span>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <div class="form-group   col-sm-2">
                                <label>&nbsp;</label><br>
                                <label class="btn btn-default btn-block">
                                    <input type="hidden" name="activo" value="0">
                                    <input value="1" type="checkbox" name="activo" <?php echo (isset($proveedor) and $proveedor['activo']) == 'true' ? 'checked' : ''; ?>>
                                    <span>Activo</span>

                                </label>
                            </div>
                            <?php
                            if ($this->request->getSession()->check('previousUrl')) {
                                $url = $this->request->getSession()->read('previousUrl');
                                if (strpos($url, "Proveedores") !== false) {
                                    $url = $this->request->getSession()->read('previousUrl');
                                } else {
                                    $url = "/Proveedores/index/";
                                }
                            } else {
                                $url = '/Proveedores/index';
                            }
                            ?>
                            <div class="form-group col-sm-12 text-center">
                                <a href="<?php echo $url; ?>" class="btn btn-danger">
                                    <span class="fa fa-remove"></span> Cancelar</a>
                                <button type="submit" class="btn btn-primary">
                                    <span class="fa  fa-check-square-o"></span>
                                    Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    document.getElementById('ProveedoresAddForm').addEventListener('submit', function(event) {
        const cuit = document.getElementById('cuit').value;
        const mensajeError = document.getElementById('mensaje-error');

        if (!validarCuit(cuit)) {
            mensajeError.style.display = 'block';
            event.preventDefault(); // Prevenir el envío del formulario si el CUIT es inválido
        } else {
            mensajeError.style.display = 'none'; // Si el CUIT es válido, ocultar el mensaje
        }
    });

    function validarCuit(cuit) {
        // Eliminar cualquier guión, espacio o carácter no numérico
        cuit = cuit.replace(/[^0-9]/g, '');

        // Verificar que tenga 11 dígitos
        if (cuit.length !== 11) {
            return false;
        }

        // Multiplicadores para los primeros 10 dígitos
        const multiplicadores = [5, 4, 3, 2, 7, 6, 5, 4, 3, 2];

        // Calcular el dígito verificador
        let suma = 0;
        for (let i = 0; i < 10; i++) {
            suma += parseInt(cuit[i]) * multiplicadores[i];
        }

        let verificador = (11 - (suma % 11)) % 11;

        // Comparar con el dígito verificador (último dígito del CUIT)
        return verificador === parseInt(cuit[10]);
    }
</script>
