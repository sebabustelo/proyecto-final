<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\DateTime;

/**
 * Informes Controller
 *
 * @property \App\Model\Table\InformesTable $Informes
 */
class InformesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {

        // // Últimos Registros de Clientes en el mes
        // if (isset($data['fecha_pedido']) && !empty($data['fecha_pedido'])) {
        //     // Separar las dos fechas basadas en el guion
        //     $fechas = explode(' - ', $data['fecha_pedido']);

        //     // Convertir las cadenas de fecha en objetos DateTime con hora de inicio y fin
        //     $fecha_inicio = DateTime::createFromFormat('d/m/Y H:i:s', $fechas[0] . ' 00:00:00');
        //     $fecha_fin = DateTime::createFromFormat('d/m/Y H:i:s', $fechas[1] . ' 23:59:59');

        //     // Verificar si las fechas fueron creadas correctamente
        //     if ($fecha_inicio && $fecha_fin) {
        //         // Agregar condiciones a la consulta
        //         $conditions['where'][] = ['Pedidos.fecha_pedido >= ' => $fecha_inicio->format('Y-m-d H:i:s')];
        //         $conditions['where'][] = ['Pedidos.fecha_pedido <= ' => $fecha_fin->format('Y-m-d H:i:s')];
        //     }
        // }
        $inicioMes = new \DateTime('first day of this month');
        $inicioMes->setTime(0, 0, 0); // Establecer la hora a las 00:00:00

        $finMes = new \DateTime('last day of this month');
        $finMes->setTime(23, 59, 59); // Establecer la hora a las 23:59:59

        $rbacUsuariosTable = $this->fetchTable('Rbac.RbacUsuarios');

        $clientes = $rbacUsuariosTable->find('all')
            ->where([
                'RbacUsuarios.created >=' => $inicioMes->format('Y-m-d H:i:s'),
                'RbacUsuarios.created <=' => $finMes->format('Y-m-d H:i:s')
            ])
            ->all();

        $this->set('clientes', $clientes);
    }
}
