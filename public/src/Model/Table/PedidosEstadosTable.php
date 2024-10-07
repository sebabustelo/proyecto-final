<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\EventInterface;
use Cake\ORM\Exception\PersistenceFailedException;

/**
 * Estados Model
 *
 * @property \App\Model\Table\PedidosTable&\Cake\ORM\Association\HasMany $Pedidos
 *
 * @method \App\Model\Entity\Estado newEmptyEntity()
 * @method \App\Model\Entity\Estado newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Estado> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Estado get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Estado findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Estado patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Estado> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Estado|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Estado saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Estado>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Estado>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Estado>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Estado> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Estado>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Estado>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Estado>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Estado> deleteManyOrFail(iterable $entities, array $options = [])
 */
class PedidosEstadosTable extends Table
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
        $this->setEntityClass('PedidoEstado');
        $this->setTable('pedidos_estados');
        $this->setDisplayField('nombre');
        $this->setPrimaryKey('id');

        $this->hasMany('Pedidos', [
            'foreignKey' => 'estado_id',
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
            ->maxLength('nombre', 100, 'El nombre no puede ser mayor a 200 caracteres')
            ->requirePresence('nombre', 'create')
            ->notEmptyString('nombre')
            ->add('nombre', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'Ya existe un estado con ese nombre. Por favor, elija un nombre diferente.']);;

        $validator
            ->boolean('activo')
            ->notEmptyString('activo');

        $validator
        ->scalar('descripcion')
        ->maxLength('descripcion', 300, 'La descripción no puede ser mayor a 300 caracteres');

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
     * Converts the 'nombre' field to uppercase before the save operation.
     *
     * @param \Cake\Event\EventInterface $event The event object.
     * @param \Cake\ORM\Entity $entity The entity being saved.
     * @param \ArrayObject $options Additional options for the save operation.
     * @return void
     */
    public function beforeSave(EventInterface $event, $entity, $options)
    {
        if ($entity->isNew() || $entity->isDirty('nombre')) {
            $entity->nombre = strtoupper($entity->nombre);
        }
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
        $pedidosCount = $this->Pedidos->find()
            ->where(['estado_id' => $entity->id])
            ->count();

        if ($pedidosCount > 0) {
            throw new PersistenceFailedException($entity, __('No se puede eliminar el estado porque tiene pedidos asociados.'));
        }
    }
}
