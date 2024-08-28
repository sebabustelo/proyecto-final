<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PersonasExterna Entity
 *
 * @property int $id
 * @property string|null $nombre
 * @property \Cake\I18n\DateTime|null $created
 * @property string|null $created_by
 * @property \Cake\I18n\DateTime|null $modified
 * @property string|null $modified_by
 */
class PersonasExterna extends Entity
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
        'created' => true,
        'created_by' => true,
        'modified' => true,
        'modified_by' => true,
    ];
}
