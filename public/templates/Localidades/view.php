<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Localidade $localidade
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Localidade'), ['action' => 'edit', $localidade->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Localidade'), ['action' => 'delete', $localidade->id], ['confirm' => __('Are you sure you want to delete # {0}?', $localidade->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Localidades'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Localidade'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="localidades view content">
            <h3><?= h($localidade->nombre) ?></h3>
            <table>
                <tr>
                    <th><?= __('Provincia') ?></th>
                    <td><?= $localidade->hasValue('provincia') ? $this->Html->link($localidade->provincia->nombre, ['controller' => 'Provincias', 'action' => 'view', $localidade->provincia->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Nombre') ?></th>
                    <td><?= h($localidade->nombre) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($localidade->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Activo') ?></th>
                    <td><?= $localidade->activo ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
