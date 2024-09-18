<?php
declare(strict_types=1);

namespace Rbac\Model\Entity;

use Cake\ORM\Entity;

/**
 * RbacToken Entity
 *
 * @property int $id
 * @property int $rbac_usuario_id
 * @property string $token
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 * @property int $validez
 */
class RbacToken extends Entity
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
        'rbac_usuario_id' => true,
        'token' => true,
        'created' => true,
        'modified' => true,
        'validez' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array<string>
     */
    protected array $_hidden = [
        'token',
    ];
}
