<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OrdenesMedica Entity
 *
 * @property int $id
 * @property int|null $pedido_id
 * @property string|null $descripcion
 * @property string|null $file_name
 * @property string|null $file_extension
 * @property int|null $file_size
 * @property string|null $file_path
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Pedido $pedido
 */
class OrdenesMedica extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'pedido_id' => true,
        'descripcion' => true,
        'file_name' => true,
        'file_extension' => true,
        'file_size' => true,
        'file_path' => true,
        'created' => true,
        'modified' => true,
        'pedido' => true,
    ];
}
