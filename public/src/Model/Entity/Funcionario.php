<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Funcionario Entity
 *
 * @property int $id
 * @property string|null $nombre
 * @property string|null $apellido
 * @property \Cake\I18n\DateTime|null $fecha_baja
 * @property bool|null $activo
 * @property string|null $nombre_migracion
 *
 * @property \App\Model\Entity\AutorizaFirmante[] $autoriza_firmantes
 * @property \App\Model\Entity\Cargo[] $cargos
 */
class Funcionario extends Entity
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
        'nombre' => true,
        'apellido' => true,
        'fecha_baja' => true,
        'activo' => true,
        'nombre_migracion' => true,
        'cargos_funcionarios' =>true,
        //'autoriza_firmantes' => true,
        'cargos' => true,
        'created' => true,
        'created_by' => true,
        'modified' => true,
        'modified_by' => true,
        
        
    ];

    protected array $_virtual = ['full_name'];

    protected function _getFullName()
    {
        return $this->apellido . ',  ' . $this->nombre;
    }
    
}
