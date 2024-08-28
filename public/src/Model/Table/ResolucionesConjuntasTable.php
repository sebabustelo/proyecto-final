<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ResolucionesConjuntas Model
 *
 * @method \App\Model\Entity\ResolucionesConjunta newEmptyEntity()
 * @method \App\Model\Entity\ResolucionesConjunta newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\ResolucionesConjunta> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ResolucionesConjunta get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ResolucionesConjunta findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ResolucionesConjunta patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\ResolucionesConjunta> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ResolucionesConjunta|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ResolucionesConjunta saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ResolucionesConjunta>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ResolucionesConjunta>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ResolucionesConjunta>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ResolucionesConjunta> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ResolucionesConjunta>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ResolucionesConjunta>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ResolucionesConjunta>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ResolucionesConjunta> deleteManyOrFail(iterable $entities, array $options = [])
 */
class ResolucionesConjuntasTable extends Table
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

        $this->setTable('resoluciones_conjuntas');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
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
            ->nonNegativeInteger('resolucion_origen')
            ->requirePresence('resolucion_origen', 'create')
            ->notEmptyString('resolucion_origen');

        $validator
            ->nonNegativeInteger('resolucion_complementada')
            ->requirePresence('resolucion_complementada', 'create')
            ->notEmptyString('resolucion_complementada');

        $validator
            ->dateTime('fecha_baja')
            ->allowEmptyDateTime('fecha_baja');

        return $validator;
    }
}
