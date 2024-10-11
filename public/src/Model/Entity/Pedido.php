<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Pedido Entity
 *
 * @property int $id
 * @property int $cliente_id
 * @property int $estado_id
 * @property \Cake\I18n\DateTime $fecha_pedido
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\RbacUsuario $rbac_usuario
 * @property \App\Model\Entity\PedidoEstado $pedidos_estado
 * @property \App\Model\Entity\DetallesPedido[] $detalles_pedidos
 * @property \App\Model\Entity\OrdenesMedica[] $ordenes_medicas
 */
class Pedido extends Entity
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
        'cliente_id' => true,
        'estado_id' => true,
        'fecha_pedido' => true,
        'created' => true,
        'modified' => true,
        'rbac_usuario' => true,
        'pedidos_estado' => true,
        'detalles_pedidos' => true,
        'ordenes_medicas' => true,
        'fecha_aplicacion' => true,
        'aclaracion' => true,
        'direccion_id' => true,
        'direccion' => true,
    ];
}
