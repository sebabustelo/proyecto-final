<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ResolucionesConjunta Entity
 *
 * @property int $id
 * @property int $resolucion_origen
 * @property int $resolucion_complementada
 * @property \Cake\I18n\DateTime|null $fecha_baja
 */
class ResolucionesConjunta extends Entity
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
        'resolucion_origen' => true,
        'resolucion_complementada' => true,
        'fecha_baja' => true,
    ];
}
