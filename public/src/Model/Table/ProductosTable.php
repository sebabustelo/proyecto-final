<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Productos Model
 *
 * @property \App\Model\Table\CategoriasTable&\Cake\ORM\Association\BelongsTo $Categorias
 * @property \App\Model\Table\ProveedoresTable&\Cake\ORM\Association\BelongsTo $Proveedores
 *
 * @method \App\Model\Entity\Producto newEmptyEntity()
 * @method \App\Model\Entity\Producto newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Producto> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Producto get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Producto findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Producto patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Producto> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Producto|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Producto saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Producto>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Producto>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Producto>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Producto> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Producto>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Producto>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Producto>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Producto> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProductosTable extends Table
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

        $this->setTable('productos');
        $this->setDisplayField('nombre');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Categorias', [
            'foreignKey' => 'categoria_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Proveedores', [
            'foreignKey' => 'proveedor_id',
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
            ->maxLength('nombre', 255)
            ->requirePresence('nombre', 'create')
            ->notEmptyString('nombre');

        $validator
            ->scalar('descripcion')
            ->requirePresence('descripcion', 'create')
            ->notEmptyString('descripcion');

        $validator
            ->integer('categoria_id')
            ->notEmptyString('categoria_id');

        $validator
            ->integer('proveedor_id')
            ->notEmptyString('proveedor_id');

        $validator
            ->scalar('imagen')
            ->maxLength('imagen', 255)
            ->allowEmptyString('imagen');

        $validator
            ->integer('stock')
            ->allowEmptyString('stock');

        $validator
            ->scalar('created_by')
            ->maxLength('created_by', 100)
            ->allowEmptyString('created_by');

        $validator
            ->scalar('modified_by')
            ->maxLength('modified_by', 100)
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
        $rules->add($rules->existsIn(['categoria_id'], 'Categorias'), ['errorField' => 'categoria_id']);
        $rules->add($rules->existsIn(['proveedor_id'], 'Proveedores'), ['errorField' => 'proveedor_id']);

        return $rules;
    }
}
