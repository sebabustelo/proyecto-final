<?php

namespace Rbac\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;


class RbacPerfilesTable extends Table
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

        $this->setTable('rbac_perfiles');
        $this->setEntityClass('Rbac\Model\Entity\RbacPerfil');
        $this->setDisplayField('descripcion');
        $this->setPrimaryKey('id');

        $this->belongsToMany(
            'RbacAcciones',
            [
                'className' => 'Rbac.RbacAcciones',
                'joinTable' => 'rbac_acciones_rbac_perfiles',
                'foreignKey' => 'rbac_perfil_id',
                'targetForeignKey' => 'rbac_accion_id',
            ]
        );

        $this->hasMany(
            'RbacUsuarios',
            [
                'className' => 'Rbac.RbacUsuarios',
                'foreignKey' => 'perfil_id',
            ]
        );
        $this->belongsTo(
            'RbacAccionDefault',
            [
                'className'        => 'Rbac.RbacAcciones',
                'foreignKey'       => 'accion_default_id',
                'propertyName' => 'accion_default'
            ]
        );
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
            ->scalar('descripcion')
            ->maxLength('descripcion', 100)
            ->requirePresence('descripcion', 'create')
            ->notEmptyString('descripcion')
            ->add('descripcion', 'unique', ['rule' => 'validateUnique', 'provider' => 'table'])
            ->add('descripcion', 'noEmpty', [
                'rule' => function ($value, $context) {
                        return preg_match('/^\s|\s$/', $value) && preg_match("/^[a-zA-ZÁÉÍÓÚáéíóúñÑ' ]+$/u", $value)?false:true;
                },
                'message' => 'La descripción es obligatorio y no puede tener espacios en blanco al principio y/o final de la cadena.',
            ]);


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
        $rules->add($rules->isUnique(['descripcion']));
        //   $rules->add($rules->existsIn(['permiso_virtual_host_id'], 'PermisosVirtualHosts'));
        $rules->add($rules->existsIn(['accion_default_id'], 'RbacAcciones'));

        return $rules;
    }
}
