<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DetallesPedido Entity
 *
 * @property int $id
 * @property int $pedido_id
 * @property int $producto_id
 * @property int $cantidad
 * @property string|null $aclaracion
 * @property \Cake\I18n\DateTime $fecha_aplicacion
 *
 * @property \App\Model\Entity\Pedido $pedido
 * @property \App\Model\Entity\Producto $producto
 */
class DetallesPedido extends Entity
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
        'producto_id' => true,
        'cantidad' => true,            
        'pedido' => true,
        'producto' => true,
    ];
}
