<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Producto> $productos
 */
?>
<div class="productos index content">
    <?= $this->Html->link(__('New Producto'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Productos') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('nombre') ?></th>
                    <th><?= $this->Paginator->sort('categoria_id') ?></th>
                    <th><?= $this->Paginator->sort('proveedor_id') ?></th>
                    <th><?= $this->Paginator->sort('imagen') ?></th>
                    <th><?= $this->Paginator->sort('stock') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('created_by') ?></th>
                    <th><?= $this->Paginator->sort('modified_by') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                <tr>
                    <td><?= $this->Number->format($producto->id) ?></td>
                    <td><?= h($producto->nombre) ?></td>
                    <td><?= $producto->hasValue('categoria') ? $this->Html->link($producto->categoria->nombre, ['controller' => 'Categorias', 'action' => 'view', $producto->categoria->id]) : '' ?></td>
                    <td><?= $producto->hasValue('proveedore') ? $this->Html->link($producto->proveedore->nombre, ['controller' => 'Proveedores', 'action' => 'view', $producto->proveedore->id]) : '' ?></td>
                    <td><?= h($producto->imagen) ?></td>
                    <td><?= $producto->stock === null ? '' : $this->Number->format($producto->stock) ?></td>
                    <td><?= h($producto->created) ?></td>
                    <td><?= h($producto->modified) ?></td>
                    <td><?= h($producto->created_by) ?></td>
                    <td><?= h($producto->modified_by) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $producto->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $producto->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $producto->id], ['confirm' => __('Are you sure you want to delete # {0}?', $producto->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
