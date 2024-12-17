<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estado $estado
 */
?>
<section class="content-header">
    <h1>
        <i class="fa fa-cubes"></i> Gestión de Proveedores
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa  fa-dot-circle-o"></i>Proveedores</a></li> <i class="fa fa-arrow-right"></i>
        <li class="active">Agregar</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header  with-border">
                    <h3 class="box-title"> <span class="fa fa-plus fa-lg"></span> Nuevo Proveedor</h3>
                    <div class="box-tools pull-right">
                        <a title="Listado de proveedores" href="/Proveedores/index/" class="btn btn-sm btn-primary ">
                            <span class="fa fa-list"></span> <span class=" hidden-xs">Proveedores</span>
                        </a>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-row">
                        <form id="ProveedoresAddForm" name="ProveedoresAddForm" role="form" action="/Proveedores/add/" method="POST">
                            <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getAttribute('csrfToken'); ?>">
                            <div class="form-group col-sm-4">
                                <label>(*) Nombre</label>
                                <input required type="text" maxlength="50"
                                    placeholder="Ingrese el nombre"
                                    class="form-control" name="nombre"
                                    value="<?php echo !empty($this->request->getData('nombre')) ? $this->request->getData('nombre') : ''; ?>">
                                <?php if ($proveedor->getError('nombre')) { ?>
                                    <?php foreach ($proveedor->getError('nombre') as $error) { ?>
                                        <span class="badge bg-red"><i class="fa fa-warning"></i> <?php echo $error; ?></span>
                                    <?php } ?>
                                <?php } ?>

                            </div>
                            <div class="form-group col-sm-4">
                                <label>(*) CUIT</label>
                                <input required type="number"
                                    maxlength="11"
                                    id="cuit"
                                    placeholder="Ingrese el CUIT"
                                    class="form-control"
                                    name="cuit"
                                    oninvalid="this.setCustomValidity('Debe completar el CUIT')"
                                    oninput="this.setCustomValidity('')"
                                    value="<?php echo !empty($this->request->getData('cuit')) ? $this->request->getData('cuit') : ''; ?>"
                                    onkeydown="preventInvalidInput(event)">
                                <?php if ($proveedor->getError('cuit')) { ?>
                                    <?php foreach ($proveedor->getError('cuit') as $error) { ?>
                                        <span class="badge bg-red"><i class="fa fa-warning"></i> <?php echo $error; ?></span>
                                    <?php } ?>
                                <?php } ?>
                                <span id="mensaje-error" style="display: none;" class="badge bg-red"><i class="fa fa-warning"></i> El CUIT es inválido</span>

                            </div>
                            <div class="form-group col-sm-4">
                                <label>(*) Email</label>
                                <input required
                                    type="email"
                                    maxlength="100"
                                    placeholder="Ingrese el email"
                                    value="<?php echo !empty($this->request->getData('email')) ? $this->request->getData('email') : ''; ?>"
                                    class="form-control"
                                    name="email">
                                <?php if ($proveedor->getError('email')) { ?>
                                    <?php foreach ($proveedor->getError('email') as $error) { ?>
                                        <span class="badge bg-red"><i class="fa fa-warning"></i> <?php echo $error; ?></span>
                                    <?php } ?>
                                <?php } ?>

                            </div><br><br><br><br><br>
                            <div class="form-group col-sm-2">
                                <label>(*) Celular</label>
                                <input required
                                    type="number"
                                    value="<?php echo !empty($this->request->getData('celular')) ? $this->request->getData('celular') : ''; ?>"
                                    oninput="if(this.value.length > 12) this.value = this.value.slice(0, 12);"
                                    placeholder="Ingrese el celular"
                                    onkeydown="preventInvalidInput(event)"
                                    class="form-control"
                                    name="celular">
                                <?php if ($proveedor->getError('celular')) { ?>
                                    <?php foreach ($proveedor->getError('celular') as $error) { ?>
                                        <span class="badge bg-red"><i class="fa fa-warning"></i> <?php echo $error; ?></span>
                                    <?php } ?>
                                <?php } ?>

                            </div>
                            <div class="form-group col-sm-10">
                                <label>(*) Descripción</label>
                                <input type="text"
                                    maxlength="150"
                                    placeholder="Ingrese una descripción"
                                    class="form-control"
                                    value="<?php echo !empty($this->request->getData('descripcion')) ? $this->request->getData('descripcion') : ''; ?>"
                                    name="descripcion">
                                <?php if ($proveedor->getError('descripcion')) { ?>
                                    <?php foreach ($proveedor->getError('descripcion') as $error) { ?>
                                        <span class="badge bg-red"><i class="fa fa-warning"></i> <?php echo $error; ?></span>
                                    <?php } ?>
                                <?php } ?>

                            </div>
                            <div class="form-group col-sm-3">
                                <label>(*) Provincia</label><br>
                                <select id="provincia_id" required name="provincia_id" class="form-control">
                                    <option selected value="">Seleccione una provincia</option>
                                    <?php foreach ($provincias as $id => $provincia) { ?>
                                        <?php if ($this->request->getData('provincia_id') == $id) { ?>
                                            <option selected value="<?php echo $id ?>"><?php echo $provincia; ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $id ?>"><?php echo $provincia; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-sm-3">
                                <label>(*) Localidad</label><br>
                                <select required id="localidad_id" name="direccion[localidad_id]" class="form-control">
                                    <option selected value="">Seleccione una localidad</option>
                                </select>
                            </div>

                            <div class="form-group col-sm-2">
                                <label for="direccion">(*) Calle</label>
                                <input name="direccion[calle]" required
                                    value="<?php echo isset($this->request->getData('direccion')['calle']) ? $this->request->getData('direccion')['calle'] : ''; ?>"
                                    type="text" class="form-control"
                                    oninput="this.value = this.value.replace(/[^a-zA-Z0-9' ]/g, '');"
                                    placeholder="Calle" maxlength="50" min="1">
                                <?php if ($proveedor->getError('calle')) { ?>
                                    <?php foreach ($proveedor->getError('calle') as $error) { ?>
                                        <span class="badge bg-red"><i class="fa fa-warning"></i> <?php echo $error; ?></span>
                                    <?php } ?>
                                <?php } ?>

                            </div>

                            <div class="form-group col-sm-1">
                                <label for="direccion">Número</label>
                                <input name="direccion[numero]" required
                                    value="<?php echo isset($this->request->getData('direccion')['numero']) ? $this->request->getData('direccion')['numero'] : ''; ?>"
                                    type="number"
                                    class="form-control"
                                    placeholder="Número"
                                    min="1" max="9999"
                                    onkeydown="preventInvalidInput(event)"
                                    oninput="if(this.value.length > 5) this.value = this.value.slice(0, 5);">
                            </div>
                            <div class="form-group col-sm-1">
                                <label for="direccion">Piso</label>
                                <input name="direccion[piso]"
                                    value="<?php echo isset($this->request->getData('direccion')['piso']) ? $this->request->getData('direccion')['piso'] : ''; ?>"
                                    type="number"
                                    class="form-control"
                                    placeholder="Piso"
                                    min="1"
                                    max="99"
                                    onkeydown="preventInvalidInput(event)"
                                    oninput="if(this.value.length > 2) this.value = this.value.slice(0, 2);">
                            </div>

                            <div class="form-group col-sm-2">
                                <label for="direccion">Depto</label>
                                <input name="direccion[departamento]"
                                    value="<?php echo isset($this->request->getData('direccion')['departamento']) ? $this->request->getData('direccion')['departamento'] : ''; ?>"
                                    type="text" class="form-control" placeholder="Depto" maxlength="3">
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
    document.addEventListener('DOMContentLoaded', function() {


        const provinciaSelect = document.getElementById('provincia_id');
        const localidadSelect = document.getElementById('localidad_id');

        provinciaSelect.addEventListener('change', function() {
            const provinciaId = this.value;

            if (provinciaId) {

                fetch('/localidades/localidades/' + provinciaId)

                    .then(response => response.json())
                    .then(data => {
                        localidadSelect.innerHTML = '<option selected value="">Seleccione una localidad</option>';

                        data.forEach(function(localidad) {

                            localidadSelect.innerHTML += '<option value="' + localidad.id + '">' + localidad.nombre + '</option>';
                        });
                    })
                    .catch(error => console.error('Error al cargar localidades:', error));
            } else {
                localidadSelect.innerHTML = '<option selected value="">Seleccione una localidad</option>';
            }
        });

        document.getElementById('provincia_id').dispatchEvent(new Event('change'));

        setTimeout(function() {
            var localidadId = "<?php echo $this->request->getData('direccion')['localidad_id'] ?? ''; ?>";
            if (localidadId) {
                document.getElementById('localidad_id').value = localidadId;
            }
        }, 1000); // Ajusta el tiempo según sea necesario



    });

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

    function preventInvalidInput(event) {
        const invalidChars = ['e', 'E', '+', '-', '.']; // caracteres que quieres restringir
        if (invalidChars.includes(event.key)) {
            event.preventDefault();
        }
    }
</script>
