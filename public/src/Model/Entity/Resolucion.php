<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Resolucione Entity
 *
 * @property int $id
 * @property int|null $numero
 * @property int|null $anio
 * @property int|null $documento_tipo_id
 * @property \Cake\I18n\Date|null $fecha
 * @property string|null $titulo
 * @property string|null $area
 * @property int|null $cargo_firmante
 * @property int|null $cargo_interino
 * @property bool $modifica_complementa
 * @property \Cake\I18n\DateTime|null $fecha_baja
 * @property \Cake\I18n\DateTime|null $created
 * @property string|null $created_by
 * @property \Cake\I18n\DateTime|null $modified
 * @property string|null $modified_by
 * @property string|null $expediente
 * @property string|null $proyecto
 * @property string|null $nro_organismo
 *
 * @property \App\Model\Entity\DocumentoTipo $documento_tipo
 * @property \App\Model\Entity\PalabrasClave[] $palabras_clave
 */
class Resolucion extends Entity
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
        'numero' => true,
        'anio' => true,
        'documento_tipo_id' => true,
        'fecha' => true,
        'titulo' => true,
        'area' => true,
        'organismo_id' => true,
        'cargo_firmante' => true,
        'cargo_interino' => true,
        'modifica_complementa' => true,
        'fecha_baja' => true,
        'created' => true,
        'created_by' => true,
        'modified' => true,
        'modified_by' => true,
        'expediente' => true,
        'proyecto' => true,
        'nro_organismo' => true,
        'documento_tipo' => true,
        'palabras_clave' => true,
        'cargos_funcionarios' => true,
        'cargos' => true,
        'area_id' => true,
        'uploads' => true,
        'resolucion_relacionadas_modificada'=>true,
        'resolucion_relacionadas_modificadora'=>true,
    ];
}
