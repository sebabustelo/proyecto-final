<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DetallesPedidos Model
 *
 * @property \App\Model\Table\PedidosTable&\Cake\ORM\Association\BelongsTo $Pedidos
 * @property \App\Model\Table\ProductosTable&\Cake\ORM\Association\BelongsTo $Productos
 *
 * @method \App\Model\Entity\DetallesPedido newEmptyEntity()
 * @method \App\Model\Entity\DetallesPedido newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\DetallesPedido> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DetallesPedido get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\DetallesPedido findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\DetallesPedido patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\DetallesPedido> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\DetallesPedido|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\DetallesPedido saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\DetallesPedido>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\DetallesPedido>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\DetallesPedido>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\DetallesPedido> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\DetallesPedido>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\DetallesPedido>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\DetallesPedido>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\DetallesPedido> deleteManyOrFail(iterable $entities, array $options = [])
 */
class DetallesPedidosTable extends Table
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

        $this->setTable('detalles_pedidos');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Pedidos', [
            'foreignKey' => 'pedido_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Productos', [
            'foreignKey' => 'producto_id',
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
            ->integer('pedido_id')
            ->notEmptyString('pedido_id', 'El campo pedido es obligatorio.')
            ->add('pedido_id', 'validFormat', [
                'rule' => 'numeric',
                'message' => 'El ID del pedido debe ser un número.'
            ]);

        $validator
            ->integer('producto_id')
            ->notEmptyString('producto_id', 'El campo producto es obligatorio.')
            ->add('producto_id', 'validFormat', [
                'rule' => 'numeric',
                'message' => 'El ID del producto debe ser un número.'
            ]);

        $validator
            ->integer('cantidad')
            ->requirePresence('cantidad', 'create', 'El campo cantidad es obligatorio.')
            ->notEmptyString('cantidad', 'Debe ingresar una cantidad.')
            ->add('cantidad', 'validRange', [
                'rule' => ['range', 1, 1000],
                'message' => 'La cantidad debe estar entre 1 y 1000.'
            ]);

        $validator
            ->scalar('aclaracion')
            ->maxLength('aclaracion', 500, 'La aclaración no debe superar los 500 caracteres.')
            ->allowEmptyString('aclaracion', 'Puede dejar este campo vacío si no tiene aclaraciones.');

        // Validación para la fecha de aplicación
        $validator
            ->date('fecha_aplicacion')
            ->requirePresence('fecha_aplicacion', 'create', 'El campo fecha de aplicación es obligatorio.')
            ->notEmptyDateTime('fecha_aplicacion', 'Debe ingresar una fecha de aplicación.')
            ->add('fecha_aplicacion', 'validFutureDate', [
                'rule' => function ($value, $context) {
                    $currentDate = date('Y-m-d');
                    return $value > $currentDate;
                },
                'message' => 'La fecha de aplicación debe ser mayor a la fecha actual.'
            ]);

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
        $rules->add($rules->existsIn(['producto_id'], 'Productos'), ['errorField' => 'producto_id']);

        return $rules;
    }
}
