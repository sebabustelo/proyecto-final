<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Proveedores Model
 *
 * @method \App\Model\Entity\Proveedore newEmptyEntity()
 * @method \App\Model\Entity\Proveedore newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Proveedore> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Proveedore get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Proveedore findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Proveedore patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Proveedore> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Proveedore|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Proveedore saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Proveedore>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Proveedore>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Proveedore>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Proveedore> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Proveedore>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Proveedore>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Proveedore>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Proveedore> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProveedoresTable extends Table
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

        $this->setTable('proveedores');
        $this->setDisplayField('nombre');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->scalar('direccion')
            ->maxLength('direccion', 255)
            ->allowEmptyString('direccion');

        $validator
            ->scalar('telefono')
            ->maxLength('telefono', 20)
            ->allowEmptyString('telefono');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email');

        $validator
            ->scalar('cuit')
            ->maxLength('cuit', 20)
            ->requirePresence('cuit', 'create')
            ->notEmptyString('cuit');

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
}
