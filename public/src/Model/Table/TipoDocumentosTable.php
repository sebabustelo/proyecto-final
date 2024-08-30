<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TipoDocumentos Model
 *
 * @property \App\Model\Table\RbacUsuariosTable&\Cake\ORM\Association\HasMany $RbacUsuarios
 *
 * @method \App\Model\Entity\TipoDocumento newEmptyEntity()
 * @method \App\Model\Entity\TipoDocumento newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\TipoDocumento> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TipoDocumento get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\TipoDocumento findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\TipoDocumento patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\TipoDocumento> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\TipoDocumento|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\TipoDocumento saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\TipoDocumento>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\TipoDocumento>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\TipoDocumento>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\TipoDocumento> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\TipoDocumento>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\TipoDocumento>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\TipoDocumento>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\TipoDocumento> deleteManyOrFail(iterable $entities, array $options = [])
 */
class TipoDocumentosTable extends Table
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

        $this->setTable('tipo_documentos');
        $this->setDisplayField('descripcion');
        $this->setPrimaryKey('id');

        $this->hasMany('RbacUsuarios', [
            'foreignKey' => 'tipo_documento_id',
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
            ->scalar('descripcion')
            ->maxLength('descripcion', 100)
            ->requirePresence('descripcion', 'create')
            ->notEmptyString('descripcion');

        return $validator;
    }
}
