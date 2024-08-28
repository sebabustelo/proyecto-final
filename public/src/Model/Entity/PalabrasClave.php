<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PalabrasClave Entity
 *
 * @property int $id
 * @property string|null $palabra
 * @property string|null $descripcion
 * @property bool $activo
 * @property \Cake\I18n\DateTime|null $fecha_baja
 * @property \Cake\I18n\DateTime|null $created
 * @property string|null $created_by
 * @property \Cake\I18n\DateTime|null $modified
 * @property string|null $modified_by
 *
 * @property \App\Model\Entity\Resolucion[] $resoluciones
 */
class PalabrasClave extends Entity
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
        'palabra' => true,
        'descripcion' => true,
        'activo' => true,
        'fecha_baja' => true,
        'created' => true,
        'created_by' => true,
        'modified' => true,
        'modified_by' => true,
        'resoluciones' => true,
    ];
}
