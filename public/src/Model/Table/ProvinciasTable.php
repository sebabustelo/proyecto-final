<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\Exception\PersistenceFailedException;

/**
 * Provincias Model
 *
 * @method \App\Model\Entity\Provincia newEmptyEntity()
 * @method \App\Model\Entity\Provincia newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Provincia> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Provincia get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Provincia findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Provincia patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Provincia> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Provincia|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Provincia saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Provincia>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Provincia>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Provincia>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Provincia> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Provincia>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Provincia>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Provincia>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Provincia> deleteManyOrFail(iterable $entities, array $options = [])
 */
class ProvinciasTable extends Table
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

        $this->setTable('provincias');
        $this->setDisplayField('nombre');
        $this->setPrimaryKey('id');



        $this->hasMany('Localidades', [
            'foreignKey' => 'provincia_id',
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
            ->scalar('nombre')
            ->maxLength('nombre', 100, 'El nombre no puede ser mayor a 100 caracteres')
            ->requirePresence('nombre', 'create', 'El nombre es obligatorio')
            ->notEmptyString('nombre', 'El nombre no puede ser vació')
            ->add('nombre', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'Ya existe una Provincia con ese nombre. Por favor, elija un nombre diferente.']);

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
        $rules->add($rules->isUnique(['nombre']), ['errorField' => 'nombre']);

        return $rules;
    }

    /**
     * Modifies the entity before saving it to the database.
     * Converts the 'nombre' field to uppercase the first letter before the save operation.
     *
     * @param \Cake\Event\EventInterface $event The event object.
     * @param \Cake\ORM\Entity $entity The entity being saved.
     * @param \ArrayObject $options Additional options for the save operation.
     * @return void
     */
    public function beforeDelete($event, $entity, $options)
    {
        $localidadesCount = $this->Localidades->find()
            ->where(['provincia_id' => $entity->id])
            ->count();

        if ($localidadesCount > 0) {
            $entity->setError('delete', __('No se puede eliminar la provincia porque está asociada a una o más localidades.'));
            return false;
        }
    }
}
