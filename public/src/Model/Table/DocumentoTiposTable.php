<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DocumentoTipos Model
 *
 * @property \App\Model\Table\CargosDocumentoTiposOriginalTable&\Cake\ORM\Association\HasMany $CargosDocumentoTiposOriginal
 * @property \App\Model\Table\ResolucionesTable&\Cake\ORM\Association\HasMany $Resoluciones
 * @property \App\Model\Table\CargosTable&\Cake\ORM\Association\BelongsToMany $Cargos
 *
 * @method \App\Model\Entity\DocumentoTipo newEmptyEntity()
 * @method \App\Model\Entity\DocumentoTipo newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\DocumentoTipo> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DocumentoTipo get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\DocumentoTipo findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\DocumentoTipo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\DocumentoTipo> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\DocumentoTipo|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\DocumentoTipo saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\DocumentoTipo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\DocumentoTipo>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\DocumentoTipo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\DocumentoTipo> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\DocumentoTipo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\DocumentoTipo>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\DocumentoTipo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\DocumentoTipo> deleteManyOrFail(iterable $entities, array $options = [])
 */
class DocumentoTiposTable extends Table
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

        $this->setTable('documento_tipos');
        $this->setDisplayField('full_name');
        $this->setPrimaryKey('id');

        $this->hasMany('CargosDocumentoTiposOriginal', [
            'foreignKey' => 'documento_tipo_id',
        ]);
        $this->hasMany('Resoluciones', [
            'foreignKey' => 'documento_tipo_id',
        ]);
        $this->hasMany('CargosDocumentoTipos', [
            'foreignKey' => 'documento_tipo_id',
        ]);
        $this->belongsToMany('Cargos', [
            'foreignKey' => 'documento_tipo_id',
            'targetForeignKey' => 'cargo_id',
            'joinTable' => 'cargos_documento_tipos',
            'saveStrategy' => 'replace'
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
            ->maxLength('codigo', 10, 'El código debe ser menor a 10 caracteres.')
            ->allowEmptyString('codigo')
            ->add('codigo', 'unique', ['rule' => 'validateUnique', 'provider' => 'table','message'=>'El código se encuentra en la base de datos, no pueden existir duplicadas']);

        $validator
            ->scalar('descripcion')
            ->maxLength('descripcion', 80, 'La descripción debe ser menor a 80 caracteres.')
            ->allowEmptyString('descripcion');

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
