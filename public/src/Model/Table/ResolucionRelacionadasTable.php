<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ResolucionRelacionadas Model
 *
 * @property \App\Model\Table\ResolucionesTable&\Cake\ORM\Association\BelongsTo $Resoluciones
 * @property \App\Model\Table\ResolucionesTable&\Cake\ORM\Association\BelongsTo $Resoluciones
 *
 * @method \App\Model\Entity\ResolucionRelacionada newEmptyEntity()
 * @method \App\Model\Entity\ResolucionRelacionada newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\ResolucionRelacionada> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ResolucionRelacionada get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ResolucionRelacionada findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ResolucionRelacionada patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\ResolucionRelacionada> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ResolucionRelacionada|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ResolucionRelacionada saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ResolucionRelacionada>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ResolucionRelacionada>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ResolucionRelacionada>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ResolucionRelacionada> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ResolucionRelacionada>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ResolucionRelacionada>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ResolucionRelacionada>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ResolucionRelacionada> deleteManyOrFail(iterable $entities, array $options = [])
 */
class ResolucionRelacionadasTable extends Table
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

        $this->setTable('resolucion_relacionadas');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('ResolucionModificada', [
            'className' => 'Resoluciones',
            'foreignKey' => 'resolucion_modificadora_id',
        ]);
        $this->belongsTo('ResolucionModificadora', [
            'className' => 'Resoluciones',
            'foreignKey' => 'resolucion_modificada_id',
        ]);
        // $this->belongsTo('Resoluciones', [
        //     'foreignKey' => 'resolucion_modificadora_id',
        // ]);
        // $this->belongsTo('Resoluciones', [
        //     'foreignKey' => 'resolucion_modificada_id',
        // ]);
    }

    // /**
    //  * Default validation rules.
    //  *
    //  * @param \Cake\Validation\Validator $validator Validator instance.
    //  * @return \Cake\Validation\Validator
    //  */
    // public function validationDefault(Validator $validator): Validator
    // {
    //     $validator
    //         ->nonNegativeInteger('resolucion_modificadora_id')
    //         ->allowEmptyString('resolucion_modificadora_id');

    //     $validator
    //         ->nonNegativeInteger('resolucion_modificada_id')
    //         ->allowEmptyString('resolucion_modificada_id');

    //     return $validator;
    // }

    // /**
    //  * Returns a rules checker object that will be used for validating
    //  * application integrity.
    //  *
    //  * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
    //  * @return \Cake\ORM\RulesChecker
    //  */
    // public function buildRules(RulesChecker $rules): RulesChecker
    // {
    //     $rules->add($rules->existsIn('resolucion_modificadora_id', 'Resoluciones'), ['errorField' => 'resolucion_modificadora_id']);
    //     $rules->add($rules->existsIn('resolucion_modificada_id', 'Resoluciones'), ['errorField' => 'resolucion_modificada_id']);

    //     return $rules;
    // }
}
