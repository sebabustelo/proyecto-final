<div class=" form-group <?php echo  isset($options['class'])?$options['class']:'' ;?>" style="<?php echo isset($options['style'])?$options['style']:'' ;?>">
<?php if(isset($options['titulo'])){ ?>
    <label for=""> <?php echo $options['titulo'] ;?></label><br>
    <?php } ?>
    <label class="btn btn-default btn-block" >
        <input type="hidden" name="activo" value="0">
        <input value="1"  type="checkbox" id='activo' name="activo" <?php echo (isset($options['checked']) and $options['checked']==true) ? 'checked' : ''; ?>  >
        <span>Activo</span>

    </label>
</div>