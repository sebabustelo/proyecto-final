<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Upload Entity
 *
 * @property int $id
 * @property string $nombre_archivo
 * @property string $nombre_original
 * @property string $hash_archivo
 * @property string $extension_archivo
 * @property string $hash_llave
 * @property string|null $subdir_zero
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime|null $modified
 * @property int|null $modified_by
 * @property int $created_by
 */
class Upload extends Entity
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
        'nombre_archivo' => true,
        'nombre_original' => true,
        'hash_archivo' => true,
        'extension_archivo' => true,
        'hash_llave' => true,
        'kit_cirugia_id' => true,
        'created' => true,
        'modified' => true,        
        'productos' => true,
        'es_principal' => true,
    ];
}
