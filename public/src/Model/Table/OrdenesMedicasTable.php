<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrdenesMedicas Model
 *
 * @property \App\Model\Table\PedidosTable&\Cake\ORM\Association\BelongsTo $Pedidos
 *
 * @method \App\Model\Entity\OrdenesMedica newEmptyEntity()
 * @method \App\Model\Entity\OrdenesMedica newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\OrdenesMedica> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrdenesMedica get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\OrdenesMedica findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\OrdenesMedica patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\OrdenesMedica> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrdenesMedica|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\OrdenesMedica saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\OrdenesMedica>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\OrdenesMedica>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\OrdenesMedica>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\OrdenesMedica> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\OrdenesMedica>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\OrdenesMedica>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\OrdenesMedica>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\OrdenesMedica> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OrdenesMedicasTable extends Table
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

        $this->setTable('ordenes_medicas');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Pedidos', [
            'foreignKey' => 'pedido_id',
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
            ->integer('pedido_id')
            ->allowEmptyString('pedido_id');

        $validator
            ->scalar('descripcion')
            ->maxLength('descripcion', 500)
            ->allowEmptyString('descripcion');

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
        $rules->add($rules->existsIn(['pedido_id'], 'Pedidos'), ['errorField' => 'pedido_id']);

        return $rules;
    }
}
