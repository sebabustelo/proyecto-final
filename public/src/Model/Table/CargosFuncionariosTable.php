<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CargosFuncionarios Model
 *
 * @property \App\Model\Table\CargosTable&\Cake\ORM\Association\BelongsTo $Cargos
 * @property \App\Model\Table\FuncionariosTable&\Cake\ORM\Association\BelongsTo $Funcionarios
 *
 * @method \App\Model\Entity\CargosFuncionario newEmptyEntity()
 * @method \App\Model\Entity\CargosFuncionario newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\CargosFuncionario> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CargosFuncionario get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\CargosFuncionario findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\CargosFuncionario patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\CargosFuncionario> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CargosFuncionario|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\CargosFuncionario saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\CargosFuncionario>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CargosFuncionario>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CargosFuncionario>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CargosFuncionario> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CargosFuncionario>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CargosFuncionario>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CargosFuncionario>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CargosFuncionario> deleteManyOrFail(iterable $entities, array $options = [])
 */
class CargosFuncionariosTable extends Table
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

        $this->setTable('cargos_funcionarios');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Cargos', [
            'foreignKey' => 'cargo_id',
            //'joinType' => 'INNER',
        ]);
        $this->belongsTo('Funcionarios', [
            'foreignKey' => 'funcionario_id',
            //'joinType' => 'INNER',
        ]);
        $this->hasMany('Resoluciones', [
            'foreignKey' => 'cargo_firmante',
            //'joinType' => 'INNER'
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
        // $validator
        //     ->notEmptyString('cargo_id');

        // $validator
        //     ->nonNegativeInteger('funcionario_id')
        //     ->notEmptyString('funcionario_id');

        // $validator
        //     ->boolean('es_firmante')
        //     ->notEmptyString('es_firmante');

        // $validator
        //     ->boolean('es_interino')
        //     ->notEmptyString('es_interino');

        // $validator
        //     ->boolean('activo')
        //     ->notEmptyString('activo');

        // $validator
        //     ->dateTime('fecha_baja')
        //     ->allowEmptyDateTime('fecha_baja');

        // $validator
        //     ->date('nombramiento')
        //     ->allowEmptyDate('nombramiento');

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
        $rules->add($rules->existsIn('cargo_id', 'Cargos'), ['errorField' => 'cargo_id']);
        $rules->add($rules->existsIn('funcionario_id', 'Funcionarios'), ['errorField' => 'funcionario_id']);

        return $rules;
    }
}
