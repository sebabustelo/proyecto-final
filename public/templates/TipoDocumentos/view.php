<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TipoDocumento $tipoDocumento
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Tipo Documento'), ['action' => 'edit', $tipoDocumento->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Tipo Documento'), ['action' => 'delete', $tipoDocumento->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tipoDocumento->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Tipo Documentos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Tipo Documento'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="tipoDocumentos view content">
            <h3><?= h($tipoDocumento->descripcion) ?></h3>
            <table>
                <tr>
                    <th><?= __('Descripcion') ?></th>
                    <td><?= h($tipoDocumento->descripcion) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($tipoDocumento->id) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Rbac Usuarios') ?></h4>
                <?php if (!empty($tipoDocumento->rbac_usuarios)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Perfil Id') ?></th>
                            <th><?= __('Tipo Documento Id') ?></th>
                            <th><?= __('Documento') ?></th>
                            <th><?= __('Usuario') ?></th>
                            <th><?= __('Nombre') ?></th>
                            <th><?= __('Apellido') ?></th>
                            <th><?= __('Direccion') ?></th>
                            <th><?= __('Password') ?></th>
                            <th><?= __('Seed') ?></th>
                            <th><?= __('Activo') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Created By') ?></th>
                            <th><?= __('Modified By') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($tipoDocumento->rbac_usuarios as $rbacUsuarios) : ?>
                        <tr>
                            <td><?= h($rbacUsuarios->id) ?></td>
                            <td><?= h($rbacUsuarios->perfil_id) ?></td>
                            <td><?= h($rbacUsuarios->tipo_documento_id) ?></td>
                            <td><?= h($rbacUsuarios->documento) ?></td>
                            <td><?= h($rbacUsuarios->usuario) ?></td>
                            <td><?= h($rbacUsuarios->nombre) ?></td>
                            <td><?= h($rbacUsuarios->apellido) ?></td>
                            <td><?= h($rbacUsuarios->direccion) ?></td>
                            <td><?= h($rbacUsuarios->password) ?></td>
                            <td><?= h($rbacUsuarios->seed) ?></td>
                            <td><?= h($rbacUsuarios->activo) ?></td>
                            <td><?= h($rbacUsuarios->created) ?></td>
                            <td><?= h($rbacUsuarios->modified) ?></td>
                            <td><?= h($rbacUsuarios->created_by) ?></td>
                            <td><?= h($rbacUsuarios->modified_by) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'RbacUsuarios', 'action' => 'view', $rbacUsuarios->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'RbacUsuarios', 'action' => 'edit', $rbacUsuarios->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'RbacUsuarios', 'action' => 'delete', $rbacUsuarios->id], ['confirm' => __('Are you sure you want to delete # {0}?', $rbacUsuarios->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
