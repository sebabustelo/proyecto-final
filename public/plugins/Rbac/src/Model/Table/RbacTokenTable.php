<?php

namespace Rbac\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\DateTime;

class RbacTokenTable extends Table
{

    public $useTable = 'rbac_token';

    public function isValidToken($token)
    {
        $result = $this->find()->where(['token' => $token])->first();
        if ($result) {
            $fecha_actual   = DateTime::now();
            $fecha_creacion = $result->created;
            $intervalo = $fecha_actual->diff($fecha_creacion);
            $minutos_transcurridos = ($intervalo->days * 24 * 60) + ($intervalo->h * 60) + $intervalo->i;
            return $minutos_transcurridos <  $result['validez'];
        }
        return false;
    }

    public function getUserIdByToken($token)
    {
        $result = $this->find()->where(['token' => $token])->first();
        return $result ? $result->usuario_id : null;
    }
}
