<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;

use Cake\Validation\Validator;

/**
 * Areas Model
 *
 * @method \App\Model\Entity\Area newEmptyEntity()
 * @method \App\Model\Entity\Area newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Area> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Area get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Area findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Area patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Area> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Area|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Area saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Area>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Area>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Area>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Area> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Area>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Area>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Area>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Area> deleteManyOrFail(iterable $entities, array $options = [])
 */
class AreasTable extends Table
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
        $this->addBehavior('Timestamp');

        $this->setTable('areas');
        $this->setDisplayField('codigo');
        $this->setPrimaryKey('id');

        $this->hasMany('Resoluciones', [
            'foreignKey' => 'area_id',
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
            ->scalar('codigo')
            ->requirePresence('codigo', 'create')
            ->notEmptyString('codigo', 'El código debe contener información .')
            ->maxLength('codigo', 20, 'El código debe ser menor a 20 caracteres.')
            ->requirePresence('codigo', 'create')
            ->add(
                'codigo',
                [
                    // 'maxLength' => [
                    //     'rule' => ['maxLength', 20],
                    //     'message' => 'El código no puede ser mayor a 20 caracteres.',
                    // ],
                    'unique' => [
                        'rule' => 'validateUnique',
                        'provider' => 'table',
                        'message' => 'El código existe en la base de datos, no pueden existir códigos duplicadas.',
                    ],

                ]
            );

        $validator
            ->scalar('descripcion')
            ->maxLength('descripcion', 100, 'La descripción debe ser menor a 100 caracteres.')
            ->requirePresence('descripcion', 'create')
            ->notEmptyString('descripcion', 'La descripción debe contener información.');

        $validator
            ->boolean('activo')
            ->notEmptyString('activo');


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
        $rules->add($rules->isUnique(['codigo'], ['allowMultipleNulls' => true]), ['errorField' => 'codigo']);

        return $rules;
    }
}
