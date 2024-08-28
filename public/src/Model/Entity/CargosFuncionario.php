<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CargosFuncionario Entity
 *
 * @property int $id
 * @property int $cargo_id
 * @property int $funcionario_id
 * @property bool $es_firmante
 * @property bool $es_interino
 * @property bool $activo
 * @property \Cake\I18n\DateTime|null $fecha_baja
 * @property \Cake\I18n\Date|null $nombramiento
 *
 * @property \App\Model\Entity\Cargo $cargo
 * @property \App\Model\Entity\Funcionario $funcionario
 */
class CargosFuncionario extends Entity
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
        'cargo_id' => true,
        'funcionario_id' => true,
        // 'es_firmante' => true,
        // 'es_interino' => true,
        // 'activo' => true,
        // 'fecha_baja' => true,
        'nombramiento' => true,
        // 'cargo' => true,
        // 'funcionario' => true,
        'id'
    ];
}
