<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Pedidos Model
 *
 * @property \App\Model\Table\RbacUsuariosTable&\Cake\ORM\Association\BelongsTo $RbacUsuarios
 * @property \App\Model\Table\PedidosEstadosTable&\Cake\ORM\Association\BelongsTo $PedidosEstados
 * @property \App\Model\Table\DetallesPedidosTable&\Cake\ORM\Association\HasMany $DetallesPedidos
 * @property \App\Model\Table\OrdenesMedicasTable&\Cake\ORM\Association\HasMany $OrdenesMedicas
 *
 * @method \App\Model\Entity\Pedido newEmptyEntity()
 * @method \App\Model\Entity\Pedido newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Pedido> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Pedido get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Pedido findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Pedido patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Pedido> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Pedido|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Pedido saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Pedido>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Pedido>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Pedido>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Pedido> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Pedido>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Pedido>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Pedido>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Pedido> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PedidosTable extends Table
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

        $this->setTable('pedidos');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('RbacUsuarios', [
            'className'        => 'Rbac.RbacUsuarios',
            'foreignKey' => 'cliente_id',
             'propertyName' => 'cliente',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('PedidosEstados', [
            'foreignKey' => 'estado_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('DetallesPedidos', [
            'foreignKey' => 'pedido_id',
        ]);
        $this->hasMany('OrdenesMedicas', [
            'foreignKey' => 'pedido_id',
        ]);
        $this->belongsTo(
            'Direcciones',
            [
                'className'        => 'Rbac.Direcciones',
                'foreignKey' => 'direccion_id',
                'propertyName' => 'direccion'
            ]
        );
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
            ->integer('cliente_id')
            ->notEmptyString('cliente_id','El cliente_id es obligatorio');

        $validator
            ->integer('estado_id')
            ->notEmptyString('estado_id');

        $validator
            ->dateTime('fecha_pedido')
            ->requirePresence('fecha_pedido', 'create')
            ->notEmptyDateTime('fecha_pedido');

        $validator
            ->scalar('comentario')
            ->maxLength('comentario', 500, 'El comentario no debe superar los 500 caracteres.')
            ->allowEmptyString('comentario', 'Puede dejar este campo vacío si no tiene un comentario.');

        $validator
            ->date('fecha_intervencion')
            ->requirePresence('fecha_intervencion', 'create', 'El campo fecha de intervención es obligatoria.')
            ->notEmptyDateTime('fecha_intervencion', 'Debe ingresar una fecha de intervención.')
            ->add('fecha_intervención', 'validFutureDate', [
                'rule' => function ($value, $context) {
                    $currentDate = date('Y-m-d');
                    return $value > $currentDate;
                },
                'message' => 'La fecha de intervención debe ser mayor a la fecha actual.'
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
        $rules->add($rules->existsIn(['cliente_id'], 'RbacUsuarios'), ['errorField' => 'cliente_id']);
        $rules->add($rules->existsIn(['estado_id'], 'PedidosEstados'), ['errorField' => 'estado_id']);

        return $rules;
    }
}
