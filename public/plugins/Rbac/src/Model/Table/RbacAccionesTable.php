<?php

namespace Rbac\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\EventInterface;
use Cake\ORM\Exception\PersistenceFailedException;
use Cake\Datasource\Exception\RecordNotFoundException;

/**
 * RbacAcciones Model
 *
 * @property \App\Model\Table\RbacPerfilesTable|\Cake\ORM\Association\BelongsToMany $RbacPerfiles
 *
 * @method \App\Model\Entity\RbacAccion get($primaryKey, $options = [])
 * @method \App\Model\Entity\RbacAccion newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\RbacAccion[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RbacAccion|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RbacAccion|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RbacAccion patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RbacAccion[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\RbacAccion findOrCreate($search, callable $callback = null, $options = [])
 */
class RbacAccionesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('rbac_acciones');
        $this->setDisplayField('action');
        $this->setPrimaryKey('id');
        $this->setEntityClass('Rbac\Model\Entity\RbacAccion');


        // $this->belongsToMany('RbacPerfiles', [
        //     'className'        => 'Rbac.RbacPerfiles',
        //     'foreignKey'       => 'rbac_accion_id',
        //     'targetForeignKey' => 'rbac_perfil_id',
        //     'joinTable'        => 'rbac_acciones_rbac_perfiles',
        // ]);

        $this->hasMany('RbacPerfiles', [
            'className'        => 'Rbac.RbacPerfiles',
            'foreignKey' => 'accion_default_id',
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
            ->integer('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('plugin')
            ->maxLength('plugin', 100)
            ->allowEmptyString('plugin');


        $validator
            ->scalar('controller')
            ->maxLength('controller', 100)
            ->requirePresence('controller', 'create')
            ->notEmptyString('controller');

        $validator
            ->scalar('action')
            ->maxLength('action', 100)
            ->allowEmptyString('action');;

        return $validator;
    }

    public function beforeDelete(EventInterface $event, $entity, $options)
    {
        // Verificar si existen registros en rbac_perfiles que referencian a esta acción
        $perfilesRelacinados = $this->RbacPerfiles->find()
            ->where(['accion_default_id' => $entity->id])
            ->count();

        // Si existen referencias, cancelar la eliminación
        if ($perfilesRelacinados > 0) {
            $event->stopPropagation();
            throw new PersistenceFailedException($entity, __('No se puede eliminar la acción, ya que está asociada a perfiles.'));
        }
    }


    /**
     * Verifica los permisos ,si  tiene permiso para leer la accion devuelve verdadero en caso contrario retorna false
     * @param string $controlador
     * @param string $accion
     * @return boolean
     */
    public function isPublicAction($controlador, $accion)
    {
        $isPublicAction = $this->find()->where(['controller' => $controlador, 'action' => $accion, 'publico' => '1'])->count();
        return $isPublicAction > 0;
    }
}
