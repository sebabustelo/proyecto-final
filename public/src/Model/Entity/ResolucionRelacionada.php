<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ResolucionRelacionada Entity
 *
 * @property int $id
 * @property int|null $resolucion_modificadora_id
 * @property int|null $resolucion_modificada_id
 *
 * @property \App\Model\Entity\Resolucione $resolucione
 */
class ResolucionRelacionada extends Entity
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
        'resolucion_modificadora_id' => true,
        'resolucion_modificada_id' => true,
        'resolucione' => true,
    ];
}
