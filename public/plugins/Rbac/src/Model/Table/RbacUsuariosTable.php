<?php

namespace Rbac\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;


class RbacUsuariosTable extends Table
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

        $this->setTable('rbac_usuarios');
        $this->setDisplayField('full_name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo(
            'RbacPerfiles',
            [
                'className'        => 'Rbac.RbacPerfiles',
                'foreignKey'       => 'perfil_id',
                'propertyName' => 'rbac_perfil'
            ]
        );
        $this->belongsTo('TipoDocumentos', [
            'foreignKey' => 'tipo_documento_id',
        ]);
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
        $rules->add($rules->isUnique(['usuario']), ['errorField' => 'usuario']);
        $rules->add($rules->existsIn(['perfil_id'], 'RbacPerfiles'), ['errorField' => 'perfil_id']);
        $rules->add($rules->existsIn(['tipo_documento_id'], 'TipoDocumentos'), ['errorField' => 'tipo_documento_id']);

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
            ->email('usuario', false, 'El campo usuario debe ser una dirección de correo válida.')
            ->maxLength('usuario', 120, 'El usuarios debe ser menor a 120 caracteres.')
            ->requirePresence('usuario', 'create')
            ->notEmptyString('usuario', 'El campo usuario no puede estar vacío.')
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

    public function validationPassword(Validator $validator): Validator
    {
        $validator
            ->notEmptyString('password', 'El password es obligatorio.')
            ->minLength('password', 6, 'El campo debe tener al menos 6 caracteres.')
            ->add('password', 'complexity', [
                'rule' => function ($value, $context) {
                    return (bool)preg_match('/^(?=.*[A-Z])(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/', $value);
                },
                'message' => 'El password debe contener al menos una mayúscula y un carácter especial.',
            ])
            ->add('password', 'match', [
                'rule' => ['compareWith', 'password_confirm'],
                'message' => 'El password y la confirmación no coinciden.',
            ])
            ->notEmptyString('password_confirm', 'La confirmación del password es obligatoria.');

        return $validator;
    }




    /**
     * @param string $usuario
     * @param int $password
     * @return boolean, TRUE si la autenticacion es correcta, FALSE en caso contrario.
     */
    public function autenticacion($usuario, $password)
    {

        $usuario  = $this->find()->where(['usuario' => $usuario, 'password' => $password])->first();

        return (isset($usuario->id));
    }
}
