<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Producto $producto
 * @var \Cake\Collection\CollectionInterface|string[] $categorias
 * @var \Cake\Collection\CollectionInterface|string[] $proveedores
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Productos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="productos form content">
            <?= $this->Form->create($producto) ?>
            <fieldset>
                <legend><?= __('Add Producto') ?></legend>
                <?php
                    echo $this->Form->control('nombre');
                    echo $this->Form->control('descripcion');
                    echo $this->Form->control('categoria_id', ['options' => $categorias]);
                    echo $this->Form->control('proveedor_id', ['options' => $proveedores]);
                    echo $this->Form->control('imagen');
                    echo $this->Form->control('stock');
                    echo $this->Form->control('created_by');
                    echo $this->Form->control('modified_by');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
