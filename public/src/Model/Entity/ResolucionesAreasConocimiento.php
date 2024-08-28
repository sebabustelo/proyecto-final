<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ResolucionesAreasConocimiento Entity
 *
 * @property int $id
 * @property int $resolucion_id
 * @property string|null $area
 * @property \Cake\I18n\DateTime|null $fecha_baja
 *
 * @property \App\Model\Entity\Resolucione $resolucione
 */
class ResolucionesAreasConocimiento extends Entity
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
        'resolucion_id' => true,
        'area' => true,
        'fecha_baja' => true,
        'resolucione' => true,
    ];
}
