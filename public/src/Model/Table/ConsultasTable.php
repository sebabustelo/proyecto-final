<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Consultas Model
 *
 * @method \App\Model\Entity\Consulta newEmptyEntity()
 * @method \App\Model\Entity\Consulta newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Consulta> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Consulta get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Consulta findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Consulta patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Consulta> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Consulta|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Consulta saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Consulta>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Consulta>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Consulta>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Consulta> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Consulta>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Consulta>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Consulta>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Consulta> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ConsultasTable extends Table
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

        $this->setTable('consultas');
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
            ->scalar('motivo')
            ->requirePresence('motivo', 'create')
            ->notEmptyString('motivo');

        return $validator;
    }
}
