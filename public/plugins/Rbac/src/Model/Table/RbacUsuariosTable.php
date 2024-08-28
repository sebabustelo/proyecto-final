<?php

namespace Rbac\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;


class RbacUsuariosTable extends Table
{  

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['usuario']));     

        return $rules;
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
            ->maxLength('usuario', 120, 'El usuarios debe ser menor a 120 caracteres.')
            ->requirePresence('usuario', 'create')
            ->notEmptyString('usuario', 'El usuario debe contener algún dato.')
            ->add(
                'usuario',
                [
                    'unique' => [
                        'rule' => 'validateUnique',
                        'provider' => 'table',
                        'message' => 'El usuario existe en la base de datos, no pueden existir usuarios duplicados.',
                    ],
                ]
            );

        $validator
            ->boolean('activo')
            ->notEmptyString('activo');
      
        $validator
            ->scalar('created_by')
            ->maxLength('created_by', 16, 'El campo debe ser menor a 16 caracteres.')
            ->allowEmptyString('created_by');

        $validator
            ->scalar('modified_by')
            ->maxLength('modified_by', 16, 'El campo debe ser menor a 16 caracteres.')
            ->allowEmptyString('modified_by');

        return $validator;
    }

    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('rbac_usuarios');
        $this->setDisplayField('full_name');
      

        $this->belongsTo(
            'RbacPerfiles',
            [
                'className'        => 'Rbac.RbacPerfiles',
                'foreignKey'       => 'perfil_id',  
                'propertyName' => 'rbac_perfil'              
            ]
        );
    }

    /**
     * @param string $usuario
     * @param int $password
     * @return boolean, TRUE si la autenticacion es correcta, FALSE en caso contrario.
     */
    public function autenticacion($usuario, $password)
    {        
        $usuario  = $this->find()->where(['usuario'=>$usuario,'password'=>$password])->first();
                  
        return (isset($usuario->id));
    }   
    
}
