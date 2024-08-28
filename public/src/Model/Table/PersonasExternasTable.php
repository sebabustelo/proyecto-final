<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PersonasExternas Model
 *
 * @method \App\Model\Entity\PersonasExterna newEmptyEntity()
 * @method \App\Model\Entity\PersonasExterna newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\PersonasExterna> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PersonasExterna get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\PersonasExterna findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\PersonasExterna patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\PersonasExterna> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\PersonasExterna|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\PersonasExterna saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\PersonasExterna>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PersonasExterna>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\PersonasExterna>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PersonasExterna> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\PersonasExterna>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PersonasExterna>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\PersonasExterna>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PersonasExterna> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PersonasExternasTable extends Table
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

        $this->setTable('personas_externas');
        $this->setDisplayField('id');
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
            ->maxLength('nombre', 80)
            ->allowEmptyString('nombre')
            ->add('nombre', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('created_by')
            ->maxLength('created_by', 16)
            ->allowEmptyString('created_by');

        $validator
            ->scalar('modified_by')
            ->maxLength('modified_by', 16)
            ->allowEmptyString('modified_by');

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
        $rules->add($rules->isUnique(['nombre'], ['allowMultipleNulls' => true]), ['errorField' => 'nombre']);

        return $rules;
    }
}
