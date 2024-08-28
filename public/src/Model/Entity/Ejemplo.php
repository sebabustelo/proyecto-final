<?php
namespace src\Model\Entity;

use Cake\ORM\Entity;

class Ejemplo extends Entity
{

    protected array $_accessible = [
        'titulo' => true,
        'descripcion' => true
    ];
}
