<div class="form-group <?php echo  $options['class'] ?>">
    <label><?php echo $options['title'] ?></label><br>
    <select style="display: none;" name="<?php echo $options['name'] ?>[_ids][]" multiple="multiple" size="10" class="form-control" id="<?php echo $options['id'] ?>">
        <?php
        if (isset($options['list'])) {
            foreach ($options['list'] as $k => $v) {
                if (in_array($k, $options['selected'])) {
                    echo '<option selected value="' . $k . '">' . $v . '</option>';
                } else {
                    echo '<option value="' . $k . '">' . $v . '</option>';
                }
            }
        }
        ?>
    </select>
</div>
<?php //debug($options) 
?>

<script type="text/javascript">
    $(function() {

        $("#<?php echo $options['id'] ?>").multiselect({
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Buscar',
            nSelectedText: ' Seleccionados',
          
            //buttonWidth: '500',
            maxHeight: '220',
            onChange: function(option, checked) {
                // Obtener todos los checkboxes dentro del contenedor  
                var divCargos = document.querySelector('.divCargos');              
                var checkboxes = divCargos.querySelectorAll('.multiselect-container input[type="checkbox"]');
                // Crear un array para almacenar los valores
                var cargoIds = [];
                // Crear un array para almacenar los valores
                var values = [];

                // Recorrer todos los checkboxes y obtener sus valores si están seleccionados
                checkboxes.forEach(function(checkbox) {
                    if (checkbox.checked) {
                        cargoIds.push(checkbox.value);
                    }
                });

                fetch('/cargos/get-firmantes', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',

                            'X-CSRF-Token': <?= json_encode($this->getRequest()->getAttribute('csrfToken')) ?> // Incluir token CSRF
                        },
                        body: JSON.stringify({
                            cargoIds: cargoIds,
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }

                        return response.json();
                    })
                    .then(data => {

                        var firmantesSelect = document.getElementById('firmantes');
                        var selectedValues = Array.from(firmantesSelect.options)
                            .filter(option => option.selected)
                            .map(option => option.value);

                            firmantesSelect.innerHTML = '';

                        for (let i = 0; i < data.length; i++) {
                            let option = document.createElement('option');
                            option.value = data[i].id; // Asignar el valor del ID del objeto
                            option.textContent = data[i].full_name; // Asignar el texto del nombre completo del objeto

                            // Mantener las opciones seleccionadas si están en selectedValues
                            if (selectedValues.includes(data[i].id.toString())) {
                                option.selected = true;
                            }

                            firmantesSelect.appendChild(option); // Agregar la opción al elemento <select>
                        }

                        // Reconstruir el multiselect
                        $("#firmantes").multiselect('rebuild');
                        
                       

                    })
                    .catch(error => {
                        console.error('There has been a problem with your fetch operation:', error);
                    });

            },


            numberDisplayed: <?php echo $options['numberDisplayed'] ?>,
            nonSelectedText: '<?php echo isset($options['empty']) ? $options['empty'] : '' ?>',
            multiselect: true,
            // widthSynchronizationMode: 'always',  
            buttonWidth: '<?php echo isset($options['buttonWidth']) ? $options['buttonWidth'] : '100%' ?>',
            buttonContainer:'<div class="btn-group button-select-width" /> '
            //buttonClass: 'btn-primary'
        });
    });
</script>