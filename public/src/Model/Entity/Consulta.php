<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Consulta Entity
 *
 * @property int $id
 * @property int|null $cliente_id
 * @property int|null $usuario_respuesta_id
 * @property string $motivo
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 */
class Consulta extends Entity
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
        'usuario_respuesta_id' => true,
        'motivo' => true,
        'respuesta' => true,
        'created' => true,
        'modified' => true,
    ];
}
