<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\Exception\PersistenceFailedException;

/**
 * Categorias Model
 *
 * @method \App\Model\Entity\Categoria newEmptyEntity()
 * @method \App\Model\Entity\Categoria newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Categoria> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Categoria get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Categoria findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Categoria patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Categoria> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Categoria|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Categoria saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Categoria>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Categoria>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Categoria>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Categoria> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Categoria>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Categoria>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Categoria>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Categoria> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CategoriasTable extends Table
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

        $this->setTable('categorias');
        $this->setDisplayField('nombre');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Productos', [
            'foreignKey' => 'categoria_id',
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
            ->maxLength('nombre', 200, 'El nombre no puede ser mayor a 200 caracteres')
            ->requirePresence('nombre', 'create', 'El nombre es obligatorio')
            ->notEmptyString('nombre', 'El nombre es obligatorio')
            ->add('nombre', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'Ya existe una categoría con ese nombre. Por favor, elija un nombre diferente.'])
            ->add('nombre', 'notEmpty', [
                'rule' => function ($value, $context) {
                    return !empty(trim($context['data']['nombre']));
                },
                'message' => 'El nombre es obligatorio y no puede tener solo espacios en blanco.',
            ]);

        $validator
            ->scalar('descripcion')
            ->maxLength('descripcion', 500, 'La descripción no puede ser mayor a 500 caracteres');

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
        $productosCount = $this->Productos->find()
            ->where(['categoria_id' => $entity->id])
            ->count();

        if ($productosCount > 0) {
            $entity->setError('delete', __('No se puede eliminar la categoría porque está asociada a uno o más productos.'));
            return false;
        }
    }

    public function beforeSave($event, $entity, $options)
    {

        $productosCount = $this->Productos->find()
            ->where(['categoria_id' => (isset($entity->id)) ? $entity->id : 0])
            ->count();


        if ($productosCount > 0 && !$entity->activo) {
            $entity->setError('delete', __('No se puede desactivar esta categoría porque está asociada a uno o más productos.'));
            return false;
        }
    }
}
