<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Proveedores Model
 *
 * @method \App\Model\Entity\Proveedor newEmptyEntity()
 * @method \App\Model\Entity\Proveedor newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Proveedor> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Proveedor get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Proveedor findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Proveedor patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Proveedor> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Proveedor|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Proveedor saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Proveedor>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Proveedor>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Proveedor>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Proveedor> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Proveedor>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Proveedor>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Proveedor>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Proveedor> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProveedoresTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
        parent::initialize($config);

        $this->setEntityClass('Proveedor');
        $this->setTable('proveedores');
        $this->setDisplayField('nombre');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo(
            'Direcciones',
            [
                'className'        => 'Rbac.Direcciones',
                'foreignKey' => 'direccion_id',
                'propertyName' => 'direccion'
            ]
        );
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('nombre')
            ->maxLength('nombre', 50)
            ->requirePresence('nombre', 'create')
            ->notEmptyString('nombre', 'El nombre es obligatorio')
            ->add('nombre', 'notEmpty', [
                'rule' => function ($value, $context) {
                    return preg_match('/^\s|\s$/', $value) && preg_match("/^[a-zA-ZÁÉÍÓÚáéíóúñÑ' ]+$/u", $value)?false:true;
                },
                'message' => 'El nombre es obligatorio y no puede tener solo espacios en blanco.',
            ]);

        $validator
            ->scalar('descripcion')
            ->maxLength('nombre', 150)
            ->requirePresence('descripcion', 'create')
            ->notEmptyString('descripcion', 'La descripción es obligatoria')
            ->add('descripcion', 'notEmpty', [
                'rule' => function ($value, $context) {
                    return preg_match('/^\s|\s$/', $value) && preg_match("/^[a-zA-ZÁÉÍÓÚáéíóúñÑ' ]+$/u", $value)?false:true;
                },
                'message' => 'La descripción no puede contener solo espacios en blanco.',
            ]);

        $validator
            ->integer('direccion_id')
            ->allowEmptyString('direccion_id');

        $validator
            ->allowEmptyString('celular');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email')
            ->add(
                'email',
                [
                    'unique' => [
                        'rule' => 'validateUnique',
                        'provider' => 'table',
                        'message' => 'Existe un proveedor con ese email, no pueden haber duplicados.',
                    ],
                ]
            );

        $validator
            ->scalar('cuit')
            ->maxLength('cuit', 11, 'El CUIT debe tener 11 caracteres')
            ->requirePresence('cuit', 'create')
            ->notEmptyString('cuit', 'El CUIT es obligatorio')
            ->add('cuit', 'validFormat', [
                'rule' => [$this, 'validarCuit'],
                'message' => 'El CUIT no es válido.',
            ])
            ->add(
                'cuit',
                [
                    'unique' => [
                        'rule' => 'validateUnique',
                        'provider' => 'table',
                        'message' => 'Existe un proveedor con el mismo cuit, no pueden haber duplicados.',
                    ],
                ]
            );

        $validator
            ->boolean('activo')
            ->notEmptyString('activo');

        return $validator;
    }

    /**
     * Valida que el CUIT tenga un formato correcto y que pase la verificación del dígito verificador.
     *
     * @param string $cuit El CUIT a validar.
     * @return bool True si el CUIT es válido, False en caso contrario.
     */
    public function validarCuit($cuit): bool
    {
        // El CUIT debe tener exactamente 11 dígitos
        if (!preg_match('/^\d{11}$/', $cuit)) {
            return false;
        }

        // Cálculo del dígito verificador
        $multiplicadores = [5, 4, 3, 2, 7, 6, 5, 4, 3, 2];
        $suma = 0;
        for ($i = 0; $i < 10; $i++) {
            $suma += intval($cuit[$i]) * $multiplicadores[$i];
        }

        $verificador = (11 - ($suma % 11)) % 11;

        // Verificamos si el dígito calculado coincide con el último dígito del CUIT
        return intval($cuit[10]) === $verificador;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['direccion_id'], 'Direcciones'), ['errorField' => 'direccion_id']);

        return $rules;
    }
}
