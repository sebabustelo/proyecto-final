<?php

namespace Rbac\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

/**
 * RbacUsuarios Model
 *
 * @method \App\Model\Entity\RbacUsuario newEmptyEntity()
 * @method \App\Model\Entity\RbacUsuario newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\RbacUsuario> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RbacUsuario get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\RbacUsuario findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\RbacUsuario patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\RbacUsuario> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\RbacUsuario|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\RbacUsuario saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\Rbac\Model\Entity\RbacUsuario>|\Cake\Datasource\ResultSetInterface<\Rbac\Model\Entity\RbacUsuario>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\Rbac\Model\Entity\RbacUsuario>|\Cake\Datasource\ResultSetInterface<\Rbac\Model\Entity\RbacUsuario> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\Rbac\Model\Entity\RbacUsuario>|\Cake\Datasource\ResultSetInterface<\Rbac\Model\Entity\RbacUsuario>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\Rbac\Model\Entity\RbacUsuario>|\Cake\Datasource\ResultSetInterface<\Rbac\Model\Entity\RbacUsuario> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
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

        $this->belongsTo(
            'Direcciones',
            [
                'className'        => 'Rbac.Direcciones',
                'foreignKey' => 'direccion_id',
                'propertyName' => 'direccion'
            ]
        );
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
            ->maxLength('usuario', 20, 'El usuarios debe ser menor a 15 caracteres.')
            ->requirePresence('usuario', 'create')
            ->notEmptyString('usuario', 'El campo usuario no puede estar vacío.')
            ->add(
                'usuario',
                [
                    'unique' => [
                        'rule' => 'validateUnique',
                        'provider' => 'table',
                        'message' => 'El usuario existe en la base de datos, no pueden existir duplicados.',
                    ],
                ]
            )
            ->add('usuario', 'noSpaces', [
                'rule' => function ($value, $context) {
                    return strpos($value, ' ') === false;
                },
                'message' => 'El usuario no puede contener solo espacios en blanco.',
            ]);

        $validator
            ->email('email', false, 'El campo usuario debe ser una dirección de correo válida.')
            ->maxLength('email', 50, 'El usuarios debe ser menor a 15 caracteres.')
            ->requirePresence('email', 'create')
            ->notEmptyString('email', 'El campo usuario no puede estar vacío.')
            ->add(
                'email',
                [
                    'unique' => [
                        'rule' => 'validateUnique',
                        'provider' => 'table',
                        'message' => 'El email ingresado ya está registrado en nuestro sistema.',
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

        $validator
            ->add('nombre', 'requiredIfTipoClienteParticular', [
                'rule' => function ($value, $context) {
                    //Si es particular, debo validar
                    if ($context['data']['tipo_cliente'] == 'particular') {
                        return !empty(trim($context['data']['nombre']));
                    } else {
                        return true;
                    }
                },
                'message' => 'El nombre es obligatorio y no puede tener solo espacios en blanco.',
            ]);

        $validator
            ->add('apellido', 'requiredIfTipoClienteParticular', [
                'rule' => function ($value, $context) {
                    //Si es particular, debo validar
                    if ($context['data']['tipo_cliente'] == 'particular') {
                        return !empty(trim($context['data']['apellido']));
                    } else {
                        return true;
                    }
                },
                'message' => 'El apellido es obligatorio y no puede tener solo espacios en blanco. .',
            ]);


        $validator
            ->add('documento', 'uniqueCombo', [
                'rule' => function ($value, $context) {
                    if (!isset($context['data']['id'])) {

                        $tipo_documento_id = $context['data']['tipo_documento_id'];
                        $documento = $context['data']['documento'];

                        // Busca si ya existe un usuario con esa combinación de tipo_documento_id y documento
                        $existingUser = $this->find()
                            ->where(['tipo_documento_id' => $tipo_documento_id, 'documento' => $documento])
                            ->first();

                        return empty($existingUser); // Retorna verdadero si no existe, lo que significa que la validación pasa
                    } else {
                        return true;
                    }
                },
                'message' => 'Este documento ya ha sido registrado.'
            ]);


        $validator
            ->add('razon_social', 'requiredIfTipoClienteObraSocial', [
                'rule' => function ($value, $context) {
                    if ($context['data']['razon_social'] == 'obra_social') {
                        return !empty(trim($context['data']['obra_social']));
                    } else {
                        return true;
                    }
                },
                'message' => 'La razón social es obligatoria y no puede tener solo espacios en blanco.',
            ]);

        return $validator;
    }

    /**
     * Valida que el CUIT tenga un formato correcto y que pase la verificación del dígito verificador.
     *
     * @param string $cuit El CUIT a validar.
     * @return bool True si el CUIT es válido, False en caso contrario.
     */
    public function validarDocumento($documento): bool
    {
        return preg_match('/^[a-zA-Z0-9]*$/', $documento);
    }

    public function validationPassword(Validator $validator): Validator
    {
        $validator
            ->notEmptyString('password', 'El password es obligatorio.')
            ->minLength('password', 6, 'El campo debe tener al menos 6 caracteres.')
            ->add('password', 'complexity', [
                'rule' => function ($value, $context) {
                    return (bool)preg_match('/^(?=.*[A-Z])(?=.*[!@#$%^&*()_+\-=\[\]{};\'":\\|,.<>\/?`~\s]).{6,}$/', $value);
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
        $usuario  = $this->find()->where([
            'OR' => [
                'usuario' => $usuario,
                'email' => $usuario
            ],
            'password' => $password
        ])->first();


        return (isset($usuario->id));
    }
}
