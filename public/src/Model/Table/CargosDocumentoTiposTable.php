<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CargosDocumentoTipos Model
 *
 * @property \App\Model\Table\CargosTable&\Cake\ORM\Association\BelongsTo $Cargos
 * @property \App\Model\Table\DocumentoTiposTable&\Cake\ORM\Association\BelongsTo $DocumentoTipos
 *
 * @method \App\Model\Entity\CargosDocumentoTipo newEmptyEntity()
 * @method \App\Model\Entity\CargosDocumentoTipo newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\CargosDocumentoTipo> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CargosDocumentoTipo get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\CargosDocumentoTipo findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\CargosDocumentoTipo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\CargosDocumentoTipo> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CargosDocumentoTipo|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\CargosDocumentoTipo saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\CargosDocumentoTipo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CargosDocumentoTipo>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CargosDocumentoTipo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CargosDocumentoTipo> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CargosDocumentoTipo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CargosDocumentoTipo>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CargosDocumentoTipo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CargosDocumentoTipo> deleteManyOrFail(iterable $entities, array $options = [])
 */
class CargosDocumentoTiposTable extends Table
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

        $this->setTable('cargos_documento_tipos');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Cargos', [
            'foreignKey' => 'cargo_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('DocumentoTipos', [
            'foreignKey' => 'documento_tipo_id',
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
            ->notEmptyString('cargo_id');

        $validator
            ->allowEmptyString('documento_tipo_id');

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
        $rules->add($rules->existsIn('cargo_id', 'Cargos'), ['errorField' => 'cargo_id']);
        $rules->add($rules->existsIn('documento_tipo_id', 'DocumentoTipos'), ['errorField' => 'documento_tipo_id']);

        return $rules;
    }
}
