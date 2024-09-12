<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProductosArchivos Model
 *
 * @property \App\Model\Table\ProductosTable&\Cake\ORM\Association\BelongsTo $Productos
 *
 * @method \App\Model\Entity\ProductosArchivo newEmptyEntity()
 * @method \App\Model\Entity\ProductosArchivo newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\ProductosArchivo> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProductosArchivo get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ProductosArchivo findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ProductosArchivo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\ProductosArchivo> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProductosArchivo|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ProductosArchivo saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ProductosArchivo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProductosArchivo>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ProductosArchivo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProductosArchivo> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ProductosArchivo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProductosArchivo>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ProductosArchivo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProductosArchivo> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProductosArchivosTable extends Table
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

        $this->setTable('productos_archivos');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

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
            ->scalar('file_name')
            ->maxLength('file_name', 255)
            ->allowEmptyString('file_name');

        $validator
            ->scalar('file_extension')
            ->maxLength('file_extension', 10)
            ->allowEmptyString('file_extension');

        $validator
            ->integer('file_size')
            ->allowEmptyString('file_size');

        $validator
            ->scalar('file_path')
            ->maxLength('file_path', 255)
            ->allowEmptyString('file_path');

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
