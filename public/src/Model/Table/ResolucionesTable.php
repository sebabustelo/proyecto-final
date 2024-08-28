<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Resoluciones Model
 *
 * @property \App\Model\Table\DocumentoTiposTable&\Cake\ORM\Association\BelongsTo $DocumentoTipos
 * @property \App\Model\Table\AreasTable&\Cake\ORM\Association\BelongsTo $Areas
 * @property \App\Model\Table\PalabrasClaveTable&\Cake\ORM\Association\BelongsToMany $PalabrasClave
 *
 * @method \App\Model\Entity\Resolucione newEmptyEntity()
 * @method \App\Model\Entity\Resolucione newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Resolucione> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Resolucione get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Resolucione findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Resolucione patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Resolucione> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Resolucione|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Resolucione saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Resolucione>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Resolucione>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Resolucione>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Resolucione> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Resolucione>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Resolucione>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Resolucione>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Resolucione> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ResolucionesTable extends Table
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

        $this->setEntityClass('Resolucion');

        $this->setTable('resoluciones');
        $this->setDisplayField('titulo');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        // $this->belongsTo('Uploads', [
        //     'foreignKey' => 'upload_id',
        //     //'joinType' => 'INNER'
        // ]);
        $this->belongsToMany('Uploads', [
            'foreignKey' => 'resolucion_id',
            'targetForeignKey' => 'upload_id',
            'joinTable' => 'uploads_resoluciones',
            'saveStrategy' => 'append'
        ]);

        $this->belongsTo('DocumentoTipos', [
            'foreignKey' => 'documento_tipo_id',
            //'joinType' => 'INNER'
        ]);
        $this->belongsTo('Areas', [
            'foreignKey' => 'area_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Organismos', [
            'foreignKey' => 'organismo_id',

            // 'bindingKey' => 'id'
        ]);
        $this->belongsTo('CargosFuncionarios', [
            'foreignKey' => 'cargo_firmante',
            //'joinType' => 'INNER'
        ]);
        $this->belongsTo('RbacUsuarios', [
            'className' => 'Rbac.RbacUsuarios',
            'foreignKey' => 'created_by',
        ]);


        $this->belongsToMany('PalabrasClave', [
            'foreignKey' => 'resolucion_id',
            'targetForeignKey' => 'palabra',
            'joinTable' => 'resoluciones_palabras_clave',
        ]);

        $this->hasMany('ResolucionRelacionadasModificadora', [
            'className' => 'ResolucionRelacionadas',
            'foreignKey' => 'resolucion_modificadora_id',
            'saveStrategy' => 'replace'
        ]);
        $this->hasMany('ResolucionRelacionadasModificada', [
            'className' => 'ResolucionRelacionadas',
            'foreignKey' => 'resolucion_modificada_id',
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
            //->nonNegativeInteger('numero')
            ->allowEmptyString('numero');

        $validator
            ->allowEmptyString('anio');

        $validator
            ->allowEmptyString('documento_tipo_id');

        $validator
            ->date('fecha')
            ->allowEmptyDate('fecha');

        $validator
            ->scalar('titulo')
            ->maxLength('titulo', 255)
            ->allowEmptyString('titulo');

        // $validator
        //     ->scalar('areasadfas')
        //     ->maxLength('areasadfas', 10)
        //     ->allowEmptyString('areasadfas');
      

        $validator
            ->nonNegativeInteger('cargo_firmante')
            ->allowEmptyString('cargo_firmante');

        $validator
            ->nonNegativeInteger('cargo_interino')
            ->allowEmptyString('cargo_interino');

        $validator
            ->boolean('modifica_complementa')
            ->notEmptyString('modifica_complementa');

        $validator
            ->dateTime('fecha_baja')
            ->allowEmptyDateTime('fecha_baja');

        $validator
            ->scalar('created_by')
            ->maxLength('created_by', 16)
            ->allowEmptyString('created_by');

        $validator
            ->scalar('modified_by')
            ->maxLength('modified_by', 16)
            ->allowEmptyString('modified_by');

        $validator
            ->scalar('expediente')
            ->maxLength('expediente', 120)
            ->allowEmptyString('expediente');

        $validator
            ->scalar('proyecto')
            ->maxLength('proyecto', 120)
            ->allowEmptyString('proyecto');

        $validator
            ->scalar('nro_organismo')
            ->maxLength('nro_organismo', 45)
            ->allowEmptyString('nro_organismo');

        $validator
            ->nonNegativeInteger('area_id')
            ->allowEmptyString('area_id');

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
        $rules->add($rules->existsIn('documento_tipo_id', 'DocumentoTipos'), ['errorField' => 'documento_tipo_id']);
        $rules->add($rules->existsIn('area_id', 'Areas'), ['errorField' => 'area_id']);

        return $rules;
    }
}
