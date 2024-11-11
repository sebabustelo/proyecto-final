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

        $data = $this->getRequest()->getQuery();

        if (isset($data['fecha_pedido']) && !empty($data['fecha_pedido'])) {
            // Separar las dos fechas basadas en el guion
            $fechas = explode(' - ', $data['fecha_pedido']);

            // Convertir las cadenas de fecha en objetos DateTime con hora de inicio y fin
            $fecha_inicio = DateTime::createFromFormat('d/m/Y H:i:s', $fechas[0] . ' 00:00:00');
            $fecha_fin = DateTime::createFromFormat('d/m/Y H:i:s', $fechas[1] . ' 23:59:59');

            // Verificar si las fechas fueron creadas correctamente
            if ($fecha_inicio && $fecha_fin) {
                // Agregar condiciones a la consulta
                $conditions['where'][] = ['Pedidos.fecha_pedido >= ' => $fecha_inicio->format('Y-m-d H:i:s')];
                $conditions['where'][] = ['Pedidos.fecha_pedido <= ' => $fecha_fin->format('Y-m-d H:i:s')];
            }
        } else {
            // Si no se proporciona fecha, establecer un rango por defecto (últimos 30 días)
            $fecha_inicio = new DateTime();
            $fecha_inicio->modify('-60 days')->setTime(0, 0, 0); // Establecer la hora a las 00:00:00

            $fecha_fin = new DateTime();
            $fecha_fin->setTime(23, 59, 59); // Establecer la hora a las 23:59:59

            // Redirigir a la misma acción con el rango de fechas por defecto
            return $this->redirect([
                'controller' => 'Informes',
                'action' => 'index',
                '?' => [
                    'fecha_pedido' => $fecha_inicio->format('d/m/Y') . ' - ' . $fecha_fin->format('d/m/Y')
                ]
            ]);
        }

        $rbacUsuariosTable = $this->fetchTable('Rbac.RbacUsuarios');

        $clientes = $rbacUsuariosTable->find('all')
            ->where([
                'RbacUsuarios.created >=' => $fecha_inicio,
                'RbacUsuarios.created <=' => $fecha_fin
            ])
            ->all();

        $this->set('clientes', $clientes);

        $pedidosTable = $this->fetchTable('Pedidos');

        $pedidosCantidad = $pedidosTable->find('all')
            ->where([
                'Pedidos.created >=' => $fecha_inicio,
                'Pedidos.created <=' => $fecha_fin
            ])
            ->count();

        $this->set('pedidosCantidad', $pedidosCantidad);

        $rango_fecha_inicio = $fecha_inicio;
        while ($rango_fecha_inicio <= $fecha_fin) {
            $mesesRango[] = [
                'mes' => (int)$rango_fecha_inicio->format('m'),  // El número del mes
                'anio' => $rango_fecha_inicio->format('Y')  // El año
            ];

            
            $rango_fecha_inicio = $rango_fecha_inicio->modify('first day of next month');
            
        }

        // Consulta para contar pedidos por mes
        $pedidosPorMes = $pedidosTable->find()
            ->select([
                'mes' => 'MONTH(Pedidos.created)',
                'anio' => 'YEAR(Pedidos.created)',
                'total_pedidos' => $pedidosTable->find()->func()->count('*')
            ])
            ->where([
                'Pedidos.created >=' => $fecha_inicio,
                'Pedidos.created <=' => $fecha_fin
            ])
            ->group(['anio', 'mes'])
            ->order(['anio' => 'ASC', 'mes' => 'ASC'])
            ->toArray();

        // Inicializamos el array de meses con los valores predeterminados en 0
        foreach ($mesesRango as &$mes) {
            $mes['total_pedidos'] = 0;  
        }

        // Llenamos el array de meses con los valores obtenidos de la consulta
        foreach ($pedidosPorMes as $pedido) {
            foreach ($mesesRango as &$mes) {
                if ($mes['mes'] == $pedido['mes'] && $mes['anio'] == $pedido['anio']) {
                    $mes['total_pedidos'] = $pedido['total_pedidos'];              
                }
            }
        }            
       
        $this->set('mesesRango', $mesesRango);  // Pasamos los datos al view
        


        $this->set('filters', $this->getRequest()->getQuery());
    }
}
