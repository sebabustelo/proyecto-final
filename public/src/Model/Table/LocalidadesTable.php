<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Localidades Model
 *
 * @method \App\Model\Entity\Localidade newEmptyEntity()
 * @method \App\Model\Entity\Localidade newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Localidade> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Localidade get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Localidade findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Localidade patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Localidade> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Localidade|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Localidade saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Localidade>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Localidade>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Localidade>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Localidade> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Localidade>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Localidade>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Localidade>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Localidade> deleteManyOrFail(iterable $entities, array $options = [])
 */
class LocalidadesTable extends Table
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

        $this->setTable('localidades');
        $this->setDisplayField('nombre');
        $this->setPrimaryKey('id');

        $this->belongsTo('Provincias', [
            'foreignKey' => 'provincia_id',
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
            ->integer('provincia_id')
            ->requirePresence('provincia_id', 'create')
            ->notEmptyString('provincia_id','Este campo no puede quedar vacío.');

        $validator
            ->scalar('nombre')
            ->maxLength('nombre', 255)
            ->requirePresence('nombre', 'create')
            ->notEmptyString('nombre','Este campo no puede quedar vacío.');

        return $validator;
    }
}
