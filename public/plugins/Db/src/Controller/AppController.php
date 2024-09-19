<?php
namespace Db\Controller;

use App\Controller\AppController as BaseController;
use Cake\Event\EventInterface;

class AppController extends BaseController
{
  
    public function initialize():void
    {
        parent::initialize();
        $this->loadComponent('Flash');
    }
    function beforeFilter(EventInterface $event) {
        parent::beforeFilter($event);
    }
    
}
