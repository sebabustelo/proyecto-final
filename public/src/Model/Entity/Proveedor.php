<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Proveedore Entity
 *
 * @property int $id
 * @property string $nombre
 * @property string $descripcion
 * @property string|null $direccion
 * @property string|null $telefono
 * @property string $email
 * @property string $cuit
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 * @property string|null $created_by
 * @property string|null $modified_by
 */
class Proveedor extends Entity
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
        'nombre' => true,
        'descripcion' => true,
        'direccion' => true,
        'telefono' => true,
        'email' => true,
        'cuit' => true,
        'created' => true,
        'modified' => true,
        'activo' => true,
    ];
}
