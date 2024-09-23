<?php
declare(strict_types=1);

namespace Rbac\Model\Entity;

use Cake\ORM\Entity;

/**
 * Direccion Entity
 *
 * @property int $id
 * @property int $usuario_id
 * @property string $calle
 * @property string|null $numero
 * @property string|null $piso
 * @property string|null $departamento
 * @property int $localidad_id
 * @property string|null $codigo_postal
 *
 * @property \Rbac\Model\Entity\RbacUsuario $rbac_usuario
 * @property \Rbac\Model\Entity\Localidade $localidade
 */
class Direccion extends Entity
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
        'calle' => true,
        'numero' => true,
        'piso' => true,
        'departamento' => true,
        'localidad_id' => true,
        'codigo_postal' => true,
        'rbac_usuario' => true,
        'localidade' => true,
    ];
}
