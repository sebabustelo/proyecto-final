<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Uploads Model
 *
 * @method \App\Model\Entity\Upload newEmptyEntity()
 * @method \App\Model\Entity\Upload newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Upload> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Upload get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Upload findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Upload patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Upload> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Upload|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Upload saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Upload>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Upload>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Upload>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Upload> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Upload>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Upload>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Upload>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Upload> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UploadsTable extends Table
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

        $this->setTable('uploads');
        $this->setDisplayField('nombre_archivo');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
       
        $this->belongsTo('Productos', [
            'foreignKey' => 'kit_cirugia_id',
            'joinType' => 'INNER'
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
            ->scalar('nombre_archivo')
            ->maxLength('nombre_archivo', 65)
            ->requirePresence('nombre_archivo', 'create')
            ->notEmptyString('nombre_archivo');

        $validator
            ->scalar('nombre_original')
            ->maxLength('nombre_original', 64)
            ->requirePresence('nombre_original', 'create')
            ->notEmptyString('nombre_original');

        $validator
            ->scalar('hash_archivo')
            ->maxLength('hash_archivo', 64)
            ->requirePresence('hash_archivo', 'create')
            ->notEmptyString('hash_archivo');

        $validator
            ->scalar('extension_archivo')
            ->maxLength('extension_archivo', 10)
            ->requirePresence('extension_archivo', 'create')
            ->notEmptyString('extension_archivo');

        $validator
            ->scalar('hash_llave')
            ->maxLength('hash_llave', 64)
            ->requirePresence('hash_llave', 'create')
            ->notEmptyString('hash_llave');

        return $validator;
    }
}
