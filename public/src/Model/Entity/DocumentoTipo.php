<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DocumentoTipo Entity
 *
 * @property int $id
 * @property string|null $codigo
 * @property string|null $descripcion
 * @property bool $activo
 * @property \Cake\I18n\DateTime|null $fecha_baja
 *
 * @property \App\Model\Entity\CargosDocumentoTiposOriginal[] $cargos_documento_tipos_original
 * @property \App\Model\Entity\Resolucione[] $resoluciones
 * @property \App\Model\Entity\Cargo[] $cargos
 */
class DocumentoTipo extends Entity
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
        'id'=>true,
        'codigo' => true,
        'descripcion' => true,
        'activo' => true,
        'fecha_baja' => true,
        'cargos_documento_tipos_original' => true,
        'resoluciones' => true,
        'cargos' => true,
        'getFullName' =>true,
        'full_name' => true
    ];

    protected array $_virtual = ['full_name'];

    protected function _getFullName()
    {
        return   $this->codigo . ' (' . $this->descripcion . ')';
    }
}
