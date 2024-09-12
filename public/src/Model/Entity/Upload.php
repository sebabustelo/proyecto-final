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
 * @property string $extension_archivo
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime|null $modified
 */
class Upload extends Entity
{
    /**
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'nombre_archivo' => true,
        'nombre_original' => true,
        'extension_archivo' => true,
        'kit_cirugia_id' => true,
        'created' => true,
        'modified' => true,
        'productos' => true,
        'es_principal' => true,
    ];
}
