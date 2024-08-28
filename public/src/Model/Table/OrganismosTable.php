<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Organismos Model
 *
 * @method \App\Model\Entity\Organismo newEmptyEntity()
 * @method \App\Model\Entity\Organismo newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Organismo> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Organismo get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Organismo findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Organismo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Organismo> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Organismo|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Organismo saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Organismo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Organismo>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Organismo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Organismo> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Organismo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Organismo>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Organismo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Organismo> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OrganismosTable extends Table
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

        $this->setTable('organismos');
        $this->setDisplayField('nombre');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Resoluciones')
            ->setForeignKey('organismo_id')
        ;
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
            ->maxLength('nombre', 64,'El nombre debe ser menor a 64 caracteres.')
            ->requirePresence('nombre', 'create')
            ->notEmptyString('nombre', 'El nombre debe contener información.')
            ->add(
                'nombre',
                [                   
                    'unique' => [
                        'rule' => 'validateUnique',
                        'provider' => 'table',
                        'message' => 'El nombre existe en la base de datos, no pueden existir nombres duplicadas.',
                    ],

                ]
            );

        $validator
            ->scalar('descripcion')
            ->maxLength('descripcion', 512, 'La descripción debe ser menor a 512 caracteres.')
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

        $validator
            ->scalar('nro_organismo')
            ->maxLength('nro_organismo', 20)
            ->allowEmptyString('nro_organismo');

        return $validator;
    }
}
