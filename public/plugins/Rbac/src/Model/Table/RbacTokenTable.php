<?php
declare(strict_types=1);

namespace Rbac\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\I18n\DateTime;

/**
 * RbacToken Model
 *
 * @method \Rbac\Model\Entity\RbacToken newEmptyEntity()
 * @method \Rbac\Model\Entity\RbacToken newEntity(array $data, array $options = [])
 * @method array<\Rbac\Model\Entity\RbacToken> newEntities(array $data, array $options = [])
 * @method \Rbac\Model\Entity\RbacToken get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \Rbac\Model\Entity\RbacToken findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \Rbac\Model\Entity\RbacToken patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\Rbac\Model\Entity\RbacToken> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Rbac\Model\Entity\RbacToken|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \Rbac\Model\Entity\RbacToken saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\Rbac\Model\Entity\RbacToken>|\Cake\Datasource\ResultSetInterface<\Rbac\Model\Entity\RbacToken>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\Rbac\Model\Entity\RbacToken>|\Cake\Datasource\ResultSetInterface<\Rbac\Model\Entity\RbacToken> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\Rbac\Model\Entity\RbacToken>|\Cake\Datasource\ResultSetInterface<\Rbac\Model\Entity\RbacToken>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\Rbac\Model\Entity\RbacToken>|\Cake\Datasource\ResultSetInterface<\Rbac\Model\Entity\RbacToken> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RbacTokenTable extends Table
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

        $this->setTable('rbac_token');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('RbacUsuarios', [
            'foreignKey' => 'rbac_usuario_id',
            'joinType' => 'INNER',
            'className' => 'Rbac.RbacUsuarios',
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
            ->integer('rbac_usuario_id')
            ->notEmptyString('rbac_usuario_id');

        $validator
            ->scalar('token')
            ->maxLength('token', 500)
            ->requirePresence('token', 'create')
            ->notEmptyString('token');

        $validator
            ->integer('validez')
            ->requirePresence('validez', 'create')
            ->notEmptyString('validez');

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
        $rules->add($rules->existsIn(['rbac_usuario_id'], 'RbacUsuarios'), ['errorField' => 'rbac_usuario_id']);

        return $rules;
    }

    public function isValidToken($token)
    {
        $result = $this->find()->where(['token' => $token])->first();
        if ($result) {
            $fecha_actual   = DateTime::now();
            $fecha_creacion = $result->created;
            $intervalo = $fecha_actual->diff($fecha_creacion);
            $minutos_transcurridos = ($intervalo->days * 24 * 60) + ($intervalo->h * 60) + $intervalo->i;
            return $minutos_transcurridos <  $result['validez'];
        }
        return false;
    }

    public function getUserIdByToken($token)
    {
        $result = $this->find()->where(['token' => $token])->first();
        return $result ? $result->usuario_id : null;
    }

}
