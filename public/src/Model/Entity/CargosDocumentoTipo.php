<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CargosDocumentoTipo Entity
 *
 * @property int $id
 * @property int $cargo_id
 * @property int|null $documento_tipo_id
 * @property \Cake\I18n\DateTime|null $fecha_baja
 *
 * @property \App\Model\Entity\Cargo $cargo
 * @property \App\Model\Entity\DocumentoTipo $documento_tipo
 */
class CargosDocumentoTipo extends Entity
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
        'documento_tipo_id' => true,
        'fecha_baja' => true,
        'cargo' => true,
        'documento_tipo' => true,
        'created' => true,
        'created_by' => true,
        'modified' => true,
        'modified_by' => true,
        'deleted' => true,
        'deleted_by' => true,
    ];
}
