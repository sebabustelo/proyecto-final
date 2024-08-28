<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Funcionarios Model
 *
 * @property \App\Model\Table\AutorizaFirmantesTable&\Cake\ORM\Association\HasMany $AutorizaFirmantes
 * @property \App\Model\Table\CargosTable&\Cake\ORM\Association\BelongsToMany $Cargos
 *
 * @method \App\Model\Entity\Funcionario newEmptyEntity()
 * @method \App\Model\Entity\Funcionario newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Funcionario> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Funcionario get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Funcionario findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Funcionario patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Funcionario> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Funcionario|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Funcionario saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Funcionario>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Funcionario>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Funcionario>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Funcionario> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Funcionario>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Funcionario>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Funcionario>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Funcionario> deleteManyOrFail(iterable $entities, array $options = [])
 */
class FuncionariosTable extends Table
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

        $this->setTable('funcionarios');
        $this->setDisplayField('full_name');
        $this->setPrimaryKey('id');

        $this->hasMany('AutorizaFirmantes', [
            'foreignKey' => 'funcionario_id',
        ]);
        $this->hasMany('CargosFuncionarios', [
            'foreignKey' => 'funcionario_id',
            //'saveStrategy' => 'replace'
        ]);
        $this->hasMany('Resoluciones', [
            'foreignKey' => 'cargo_firmante',
        ]);
        $this->belongsToMany('Cargos', [
            'foreignKey' => 'funcionario_id',
            'targetForeignKey' => 'cargo_id',
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
            ->scalar('nombre')
            ->maxLength('nombre', 80, 'El nombre debe ser menor a 80 caracteres.')
            ->notEmptyString('nombre', 'El nombre debe contener información .');

        $validator
            ->scalar('apellido')
            ->maxLength('apellido', 80, 'El apellido debe ser menor a 80 caracteres.')
            ->notEmptyString('nombre', 'El apellido debe contener información .');

        $validator
            ->dateTime('fecha_baja')
            ->allowEmptyDateTime('fecha_baja');

        $validator
            ->boolean('activo')
            ->notEmptyString('activo');


        return $validator;
    }
}
