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
        'email' => true,
        'nombre' => true,
        'apellido' => true,
        'tipo_documento_id' => true,
        'documento' => true,
        'celular' => true,
        'seed' => true,
        'activo' => true,
        'created' => true,
        'modified' => true,
        'created_by' => true,
        'modified_by' => true,
        'rbac_perfil' => true,
        'tipo_documento' => true,
        'perfil_id' => true,
        'password' => true,
        'password_confirm'=>true,
        'direccion'=>true,
        'razon_social'=>true,
        'direccion_id' => true,
        'tipo_cliente' => true,

    ];

    protected function password_confirm()
    {
        return $this->password;
    }

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected array $_hidden = [
        'password'
    ];

    protected array $_virtual =['full_name', 'tipo_cliente'];

    protected function _getFullName()
    {
        return   $this->usuario . ' [' . $this->apellido . ', ' . $this->nombre . ']';
    }
}
