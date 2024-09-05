<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Producto $producto
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Producto'), ['action' => 'edit', $producto->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Producto'), ['action' => 'delete', $producto->id], ['confirm' => __('Are you sure you want to delete # {0}?', $producto->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Productos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Producto'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="productos view content">
            <h3><?= h($producto->nombre) ?></h3>
            <table>
                <tr>
                    <th><?= __('Nombre') ?></th>
                    <td><?= h($producto->nombre) ?></td>
                </tr>
                <tr>
                    <th><?= __('Categoria') ?></th>
                    <td><?= $producto->hasValue('categoria') ? $this->Html->link($producto->categoria->nombre, ['controller' => 'Categorias', 'action' => 'view', $producto->categoria->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Proveedore') ?></th>
                    <td><?= $producto->hasValue('proveedore') ? $this->Html->link($producto->proveedore->nombre, ['controller' => 'Proveedores', 'action' => 'view', $producto->proveedore->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Imagen') ?></th>
                    <td><?= h($producto->imagen) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created By') ?></th>
                    <td><?= h($producto->created_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified By') ?></th>
                    <td><?= h($producto->modified_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($producto->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Stock') ?></th>
                    <td><?= $producto->stock === null ? '' : $this->Number->format($producto->stock) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($producto->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($producto->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Descripcion') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($producto->descripcion)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
