<?php

declare(strict_types=1);

namespace Rbac\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Direcciones Model
 *
 * @property \Rbac\Model\Table\RbacUsuariosTable&\Cake\ORM\Association\BelongsTo $RbacUsuarios
 * @property \Rbac\Model\Table\LocalidadesTable&\Cake\ORM\Association\BelongsTo $Localidades
 *
 * @method \Rbac\Model\Entity\Direccion newEmptyEntity()
 * @method \Rbac\Model\Entity\Direccion newEntity(array $data, array $options = [])
 * @method array<\Rbac\Model\Entity\Direccion> newEntities(array $data, array $options = [])
 * @method \Rbac\Model\Entity\Direccion get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \Rbac\Model\Entity\Direccion findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \Rbac\Model\Entity\Direccion patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\Rbac\Model\Entity\Direccion> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Rbac\Model\Entity\Direccion|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \Rbac\Model\Entity\Direccion saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\Rbac\Model\Entity\Direccion>|\Cake\Datasource\ResultSetInterface<\Rbac\Model\Entity\Direccion>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\Rbac\Model\Entity\Direccion>|\Cake\Datasource\ResultSetInterface<\Rbac\Model\Entity\Direccion> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\Rbac\Model\Entity\Direccion>|\Cake\Datasource\ResultSetInterface<\Rbac\Model\Entity\Direccion>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\Rbac\Model\Entity\Direccion>|\Cake\Datasource\ResultSetInterface<\Rbac\Model\Entity\Direccion> deleteManyOrFail(iterable $entities, array $options = [])
 */
class DireccionesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setEntityClass('Rbac.Direccion');
        $this->setTable('direcciones');
        $this->setDisplayField('calle');
        $this->setPrimaryKey('id');


        $this->belongsTo('Localidades', [
            'foreignKey' => 'localidad_id',
            'joinType' => 'INNER',
            'className' => 'Localidades',
        ]);
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
            ->scalar('calle')
            ->maxLength('calle', 100)
            ->requirePresence('calle', 'create')
            ->notEmptyString('calle')
            ->add('calle', 'noOnlySpaces', [
                'rule' => function ($value, $context) {
                    return strlen(trim($value)) > 0;
                },
                'message' => 'La calle no puede contener solo espacios en blanco.',
            ]);

        $validator
            ->scalar('numero')
            ->maxLength('numero', 10)
            ->allowEmptyString('numero');

        $validator
            ->scalar('piso')
            ->maxLength('piso', 10)
            ->allowEmptyString('piso');

        $validator
            ->scalar('departamento')
            ->maxLength('departamento', 10)
            ->allowEmptyString('departamento');

        $validator
            ->integer('localidad_id')
            ->notEmptyString('localidad_id');

        $validator
            ->scalar('codigo_postal')
            ->maxLength('codigo_postal', 10)
            ->allowEmptyString('codigo_postal');

        return $validator;
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
        $rules->add($rules->existsIn(['localidad_id'], 'Localidades'), ['errorField' => 'localidad_id']);

        return $rules;
    }
}
