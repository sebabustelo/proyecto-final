<div class="form-group <?php echo  $options['class'] ?>">
    <label ><?php echo $options['title'] ?></label><br>
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
            dropUp: true,
           
            numberDisplayed: <?php echo $options['numberDisplayed'] ?>,
            nonSelectedText: '<?php echo isset($options['empty']) ? $options['empty'] : '' ?>',
            multiselect: true,
           // widthSynchronizationMode: 'always',  
            buttonWidth: '<?php echo isset($options['buttonWidth']) ? $options['buttonWidth'] : '100%' ?>',  
            buttonContainer:'<div class="btn-group button-select-width" /> '
            
           // buttonClass: 'button-select-width'
        });
    });
</script>