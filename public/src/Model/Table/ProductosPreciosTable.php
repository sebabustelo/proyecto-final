<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProductosPrecios Model
 *
 * @property \App\Model\Table\ProductosTable&\Cake\ORM\Association\BelongsTo $Productos
 *
 * @method \App\Model\Entity\ProductosPrecio newEmptyEntity()
 * @method \App\Model\Entity\ProductosPrecio newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\ProductosPrecio> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProductosPrecio get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ProductosPrecio findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ProductosPrecio patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\ProductosPrecio> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProductosPrecio|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ProductosPrecio saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ProductosPrecio>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProductosPrecio>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ProductosPrecio>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProductosPrecio> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ProductosPrecio>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProductosPrecio>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ProductosPrecio>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProductosPrecio> deleteManyOrFail(iterable $entities, array $options = [])
 */
class ProductosPreciosTable extends Table
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

        $this->setTable('productos_precios');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Productos', [
            'foreignKey' => 'producto_id',
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
            ->integer('producto_id')
            ->allowEmptyString('producto_id');

        $validator
            ->decimal('precio')
            ->requirePresence('precio', 'create')
            ->notEmptyString('precio');

        $validator
            ->dateTime('fecha_desde')
            ->requirePresence('fecha_desde', 'create')
            ->notEmptyDateTime('fecha_desde');

        $validator
            ->dateTime('fecha_hasta')
            ->allowEmptyDateTime('fecha_hasta');

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
        $rules->add($rules->existsIn(['producto_id'], 'Productos'), ['errorField' => 'producto_id']);

        return $rules;
    }
}
