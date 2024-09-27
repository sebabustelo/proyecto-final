<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\Exception\PersistenceFailedException;

/**
 * Localidades Model
 *
 * @method \App\Model\Entity\Localidad newEmptyEntity()
 * @method \App\Model\Entity\Localidad newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Localidad> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Localidad get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Localidad findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Localidad patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Localidad> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Localidad|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Localidad saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Localidad>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Localidad>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Localidad>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Localidad> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Localidad>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Localidad>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Localidad>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Localidad> deleteManyOrFail(iterable $entities, array $options = [])
 */
class LocalidadesTable extends Table
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

        $this->setTable('localidades');
        $this->setDisplayField('nombre');
        $this->setPrimaryKey('id');
        $this->setEntityClass('Localidad');

        $this->belongsTo('Provincias', [
            'foreignKey' => 'provincia_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Direcciones', [
            'className' => 'Rbac.Direcciones',
            'foreignKey' => 'localidad_id',
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
            ->integer('provincia_id')
            ->requirePresence('provincia_id', 'create')
            ->notEmptyString('provincia_id', 'Este campo no puede quedar vacío.');

        $validator
            ->scalar('nombre')
            ->maxLength('nombre', 255)
            ->requirePresence('nombre', 'create')
            ->notEmptyString('nombre', 'Este campo no puede quedar vacío.');

        $validator
            ->boolean('activo')
            ->notEmptyString('activo');

        return $validator;
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
        
        $direccionesCount = $this->Direcciones->find()
            ->where(['localidad_id' => $entity->id])
            ->count();

        if ($direccionesCount > 0) {
            $entity->setError('delete', __('No se puede eliminar la localidad porque está asociada a una o más direcciones de usuarios.'));
            return false;
        }

    }
}
