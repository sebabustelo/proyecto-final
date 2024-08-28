<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ResolucionesAreasConocimiento Model
 *
 * @property \App\Model\Table\ResolucionesTable&\Cake\ORM\Association\BelongsTo $Resoluciones
 *
 * @method \App\Model\Entity\ResolucionesAreasConocimiento newEmptyEntity()
 * @method \App\Model\Entity\ResolucionesAreasConocimiento newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\ResolucionesAreasConocimiento> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ResolucionesAreasConocimiento get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ResolucionesAreasConocimiento findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ResolucionesAreasConocimiento patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\ResolucionesAreasConocimiento> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ResolucionesAreasConocimiento|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ResolucionesAreasConocimiento saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ResolucionesAreasConocimiento>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ResolucionesAreasConocimiento>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ResolucionesAreasConocimiento>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ResolucionesAreasConocimiento> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ResolucionesAreasConocimiento>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ResolucionesAreasConocimiento>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ResolucionesAreasConocimiento>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ResolucionesAreasConocimiento> deleteManyOrFail(iterable $entities, array $options = [])
 */
class ResolucionesAreasConocimientoTable extends Table
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

        $this->setTable('resoluciones_areas_conocimiento');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Resoluciones', [
            'foreignKey' => 'resolucion_id',
            'joinType' => 'INNER',
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
            ->nonNegativeInteger('resolucion_id')
            ->notEmptyString('resolucion_id');

        $validator
            ->scalar('area')
            ->maxLength('area', 10)
            ->allowEmptyString('area');

        $validator
            ->dateTime('fecha_baja')
            ->allowEmptyDateTime('fecha_baja');

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
        $rules->add($rules->existsIn('resolucion_id', 'Resoluciones'), ['errorField' => 'resolucion_id']);

        return $rules;
    }
}
