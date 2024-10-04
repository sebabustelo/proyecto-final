<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProductosPrecio Entity
 *
 * @property int $id
 * @property int|null $producto_id
 * @property string $precio
 * @property \Cake\I18n\DateTime $fecha_desde
 * @property \Cake\I18n\DateTime|null $fecha_hasta
 *
 * @property \App\Model\Entity\Producto $producto
 */
class ProductosPrecio extends Entity
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
        'producto_id' => true,
        'precio' => true,
        'fecha_desde' => true,
        'fecha_hasta' => true,
        'producto' => true,
        'productos_precios' => true,

    ];
}
