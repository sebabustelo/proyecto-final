<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PalabrasClave Model
 *
 * @property \App\Model\Table\ResolucionesTable&\Cake\ORM\Association\BelongsToMany $Resoluciones
 *
 * @method \App\Model\Entity\PalabrasClave newEmptyEntity()
 * @method \App\Model\Entity\PalabrasClave newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\PalabrasClave> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PalabrasClave get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\PalabrasClave findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\PalabrasClave patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\PalabrasClave> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\PalabrasClave|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\PalabrasClave saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\PalabrasClave>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PalabrasClave>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\PalabrasClave>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PalabrasClave> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\PalabrasClave>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PalabrasClave>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\PalabrasClave>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PalabrasClave> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PalabrasClaveTable extends Table
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

        $this->setTable('palabras_clave');
        $this->setDisplayField('palabra');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsToMany('Resoluciones', [
            'foreignKey' => 'palabra',
            'targetForeignKey' => 'resolucion_id',
            'joinTable' => 'resoluciones_palabras_clave',
            'saveStrategy' => 'replace'
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
            ->scalar('palabra')
            ->maxLength('palabra', 50,  'La palabra clave debe ser menor a 50 caracteres.')
            ->allowEmptyString('palabra')
            ->add('palabra', 'unique', ['rule' => 'validateUnique', 'provider' => 'table','message'=>'La Palabra Clave se encuentra en la base de datos, no pueden existir duplicadas']);

        $validator
            ->scalar('descripcion')
            ->maxLength('descripcion', 255, 'La descripción debe ser menor a 255 caracteres.')
            ->allowEmptyString('descripcion');

        $validator
            ->boolean('activo')
            ->notEmptyString('activo');

        $validator
            ->dateTime('fecha_baja')
            ->allowEmptyDateTime('fecha_baja');

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
        $rules->add($rules->isUnique(['palabra'], ['allowMultipleNulls' => true]), ['errorField' => 'palabra']);

        return $rules;
    }
}
