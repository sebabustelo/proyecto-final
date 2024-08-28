<?php
namespace Rbac\Model\Entity;

use Cake\ORM\Entity;

/**
 * RbacUsuario Entity
 *
 * @property int $id
 * @property string $usuario
 * @property string|null $nombre
 * @property string|null $apellido
 * @property string $valida_ldap
 * @property string|null $password
 * @property string|null $seed
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \Rbac\Model\Entity\RbacPerfil[] $rbac_perfiles
 */
class RbacUsuario extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected array $_accessible = [
        'usuario' => true,
        'nombre' => true,
        'activo' => true,        
        'apellido' => true,
        'correo' => true,
        'perfil_id' => true,
        'password' => true,
        'seed' => true,
        'created' => true,
        'modified' => true,        
        'rbac_perfil' => true,        
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected array $_hidden = [
        'password'
    ];

    protected array $_virtual = ['full_name'];

    protected function _getFullName()
    {
        return   $this->usuario. ' ['.$this->apellido .', '.$this->nombre .']';
    }
}
