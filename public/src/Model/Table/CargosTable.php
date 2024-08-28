<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Cargos Model
 *
 * @property \App\Model\Table\CargosDocumentoTiposOriginalTable&\Cake\ORM\Association\HasMany $CargosDocumentoTiposOriginal
 * @property \App\Model\Table\DocumentoTiposTable&\Cake\ORM\Association\BelongsToMany $DocumentoTipos
 * @property \App\Model\Table\FuncionariosTable&\Cake\ORM\Association\BelongsToMany $Funcionarios
 *
 * @method \App\Model\Entity\Cargo newEmptyEntity()
 * @method \App\Model\Entity\Cargo newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Cargo> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Cargo get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Cargo findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Cargo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Cargo> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Cargo|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Cargo saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Cargo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Cargo>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Cargo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Cargo> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Cargo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Cargo>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Cargo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Cargo> deleteManyOrFail(iterable $entities, array $options = [])
 */
class CargosTable extends Table
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

        $this->setTable('cargos');
        $this->setDisplayField('full_name');
        $this->setPrimaryKey('id');

        $this->hasMany('CargosDocumentoTiposOriginal', [
            'foreignKey' => 'cargo_id',
        ]);
        $this->hasMany('CargosDocumentoTipos', [
            'foreignKey' => 'cargo_id',
        ]);
        $this->hasMany('CargosFuncionarios', [
            'foreignKey' => 'cargo_id',
        ]);
        $this->belongsToMany('DocumentoTipos', [
            'foreignKey' => 'cargo_id',
            'targetForeignKey' => 'documento_tipo_id',
            'joinTable' => 'cargos_documento_tipos',
            'saveStrategy' => 'replace',
            'sort' => 'descripcion',
            'dependent' => false
        ]);
        $this->belongsToMany('Funcionarios', [
            'foreignKey' => 'cargo_id',
            'targetForeignKey' => 'funcionario_id',
            'joinTable' => 'cargos_funcionarios',
            'through' => 'CargosFuncionarios',
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
            ->scalar('codigo')
            ->requirePresence('codigo', 'create')
            ->notEmptyString('codigo', 'El código debe contener información .')
            ->maxLength('codigo', 10, 'El código debe ser menor a 10 caracteres.')
            ->requirePresence('codigo', 'create')
            ->add(
                'codigo',
                [
                    // 'maxLength' => [
                    //     'rule' => ['maxLength', 20],
                    //     'message' => 'El código no puede ser mayor a 20 caracteres.',
                    // ],
                    'unique' => [
                        'rule' => 'validateUnique',
                        'provider' => 'table',
                        'message' => 'El código existe en la base de datos, no pueden existir códigos duplicadas.',
                    ],
                ]
            );

        $validator
            ->scalar('descripcion')
            ->maxLength('descripcion', 255, 'La descripción debe ser menor a 255 caracteres.')
            ->requirePresence('descripcion', 'create')
            ->notEmptyString('descripcion', 'La descripción debe contener información .');

        $validator
            ->boolean('activo')
            ->notEmptyString('activo');

        $validator
            ->dateTime('fecha_baja')
            ->allowEmptyDateTime('fecha_baja');

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
        $rules->add($rules->isUnique(['codigo'], ['allowMultipleNulls' => true]), ['errorField' => 'codigo']);

        return $rules;
    }
}
