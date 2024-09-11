<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Producto Entity
 *
 * @property int $id
 * @property string $nombre
 * @property string $descripcion
 * @property int $categoria_id
 * @property int $proveedor_id
 * @property string|null $imagen
 * @property int|null $stock
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 * @property string|null $created_by
 * @property string|null $modified_by
 *
 * @property \App\Model\Entity\Categoria $categoria
 * @property \App\Model\Entity\Proveedore $proveedore
 */
class Producto extends Entity
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
        'id' => true,
        'nombre' => true,
        'descripcion' => true,
        'categoria_id' => true,
        'proveedor_id' => true,       
        'stock' => true,
        'precio' => true,
        'created' => true,
        'modified' => true,       
        'categoria' => true,
        'proveedore' => true,
    ];
}
