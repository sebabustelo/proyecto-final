<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Consultas Model
 *
 * @method \App\Model\Entity\Consulta newEmptyEntity()
 * @method \App\Model\Entity\Consulta newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Consulta> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Consulta get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Consulta findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Consulta patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Consulta> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Consulta|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Consulta saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Consulta>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Consulta>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Consulta>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Consulta> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Consulta>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Consulta>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Consulta>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Consulta> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ConsultasTable extends Table
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

        $this->setTable('consultas');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('UsuarioConsultas', [
            'className' => 'Rbac.RbacUsuarios',
            'foreignKey' => 'usuario_consulta_id',
        ]);

        $this->belongsTo('UsuarioRespuestas', [
            'className' => 'Rbac.RbacUsuarios',
            'foreignKey' => 'usuario_respuesta_id',
        ]);

        $this->belongsTo('ConsultasEstados', [
            'foreignKey' => 'consulta_estado_id',
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
            ->integer('usuario_consulta_id')
            ->allowEmptyString('usuario_consulta_id');

        $validator
            ->integer('usuario_respuesta_id')
            ->allowEmptyString('usuario_respuesta_id');

        $validator
            ->scalar('motivo')
            ->requirePresence('motivo', 'create')
            ->notEmptyString('motivo');

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
        //$rules->add($rules->existsIn(['usuario_consulta_id'], 'UsuarioConsulta'), ['errorField' => 'usuario_consulta_id']);
        //$rules->add($rules->existsIn(['usuario_respuesta_id'], 'UsuarioRespuesta'), ['errorField' => 'usuario_respuesta_id']);

        return $rules;
    }
}
