<?php

declare(strict_types=1);

namespace App\Model\Table;


use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ObrasSocial Model
 *
 * @method \App\Model\Entity\ObraSocial newEmptyEntity()
 * @method \App\Model\Entity\ObraSocial newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\ObraSocial> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ObraSocial get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ObraSocial findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ObraSocial patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\ObraSocial> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ObraSocial|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ObraSocial saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ObraSocial>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ObraSocial>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ObraSocial>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ObraSocial> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ObraSocial>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ObraSocial>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ObraSocial>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ObraSocial> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ObrasSocialesTable extends Table
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
        $this->setEntityClass('ObraSocial');
        $this->setTable('obras_sociales');
        $this->setDisplayField('nombre');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->maxLength('nombre', 255)
            ->requirePresence('nombre', 'create')
            ->notEmptyString('nombre');

        $validator
            ->scalar('direccion')
            ->maxLength('direccion', 255)
            ->allowEmptyString('direccion');

        $validator
            ->scalar('telefono')
            ->maxLength('telefono', 20)
            ->allowEmptyString('telefono');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email');

        $validator
            ->scalar('cuit')
            ->maxLength('cuit', 20)
            ->requirePresence('cuit', 'create')
            ->notEmptyString('cuit');

        $validator
            ->boolean('activo')
            ->notEmptyString('activo');

        return $validator;
    }
}
