<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\EventInterface;
use Cake\ORM\Exception\PersistenceFailedException;

/**
 * ConsultasEstados Model
 *
 * @method \App\Model\Entity\ConsultaEstado newEmptyEntity()
 * @method \App\Model\Entity\ConsultaEstado newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\ConsultaEstado> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ConsultaEstado get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ConsultaEstado findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ConsultaEstado patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\ConsultaEstado> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ConsultaEstado|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ConsultaEstado saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ConsultaEstado>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ConsultaEstado>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ConsultaEstado>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ConsultaEstado> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ConsultaEstado>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ConsultaEstado>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ConsultaEstado>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ConsultaEstado> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ConsultasEstadosTable extends Table
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
        $this->setEntityClass('ConsultaEstado');
        $this->setTable('consultas_estados');
        $this->setDisplayField('nombre');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Consultas', [
            'foreignKey' => 'consulta_estado_id',
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
            ->maxLength('nombre', 100)
            ->requirePresence('nombre', 'create')
            ->notEmptyString('nombre')
            ->add('nombre', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('descripcion')
            ->maxLength('descripcion', 300)
            ->allowEmptyString('descripcion');

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

        $consultasCount = $this->Consultas->find()
            ->where(['consulta_estado_id' => $entity->id])
            ->count();

        if ($consultasCount > 0) {
            $entity->setError('delete', __('No se puede eliminar el estado porque está asociada a uno o más consultas.'));
            return false;
        }
    }
}
