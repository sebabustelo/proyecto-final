<?php
// src/Model/Behavior/AuditBehavior.php
namespace App\Model\Behavior;

use ArrayObject;
use Cake\Event\Event;
use Cake\ORM\Behavior;
use Cake\Datasource\EntityInterface;
use Cake\Routing\Router;

class AuditBehavior extends Behavior
{
    // protected $_defaultConfig = [];

    public function beforeSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        // Accede al id del usuario autenticado desde la sesión
        $session = Router::getRequest()->getSession();
        $userId = $session->read('RbacUsuario.id');

        // Si es un nuevo registro, asigna el created_by
        if ($entity->isNew() && $userId) {
            $entity->set('created_by', $userId);
        }

        // En cualquier actualización o creación, asigna el modified_by
        if ($userId) {
            $entity->set('modified_by', $userId);
        }

    }
}
