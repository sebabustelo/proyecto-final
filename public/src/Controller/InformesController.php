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
            $fecha_inicio = $fecha_inicio->modify('-2 months')->setTime(0, 0, 0); // Establecer la hora a las 00:00:00

            $fecha_fin = new DateTime();
            $fecha_fin = $fecha_fin->setTime(23, 59, 59); // Establecer la hora a las 23:59:59

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
            ->orderBy(['created DESC'])
            ->all();

        $this->set('clientes', $clientes);

        $pedidosTable = $this->fetchTable('Pedidos');

        $pedidosCantidad = $pedidosTable->find('all')
            ->where([
                'Pedidos.fecha_pedido >=' => $fecha_inicio,
                'Pedidos.fecha_pedido <=' => $fecha_fin
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
                'mes' => 'MONTH(Pedidos.fecha_pedido)',
                'anio' => 'YEAR(Pedidos.fecha_pedido)',
                'total_pedidos' => $pedidosTable->find()->func()->count('*'),
            ])
            ->where([
                'Pedidos.fecha_pedido >=' => $fecha_inicio,
                'Pedidos.fecha_pedido <=' => $fecha_fin
            ])
            ->groupBy(['anio', 'mes'])
            ->orderBy(['anio' => 'ASC', 'mes' => 'ASC'])
            ->toArray();

        $ventasPorMes = $pedidosTable->find()
            ->select([
                'mes' => 'MONTH(Pedidos.fecha_pedido)',
                'anio' => 'YEAR(Pedidos.fecha_pedido)',
                'total_ventas' => $pedidosTable->find()->func()->count('*'),
            ])
            ->where([
                'Pedidos.fecha_pedido >=' => $fecha_inicio,
                'Pedidos.fecha_pedido <=' => $fecha_fin,
                'Pedidos.estado_id' => '5'
            ])
            ->groupBy(['anio', 'mes'])
            ->orderBy(['anio' => 'ASC', 'mes' => 'ASC'])
            ->toArray();

        // Inicializamos el array de meses con los valores predeterminados en 0
        foreach ($mesesRango as &$mes) {
            $mes['total_pedidos'] = 0;
            $mes['total_ventas'] = 0;
        }

        // Llenamos el array de meses con los valores obtenidos de la consulta
        foreach ($pedidosPorMes as $pedido) {
            foreach ($mesesRango as &$mes) {
                if ($mes['mes'] == $pedido['mes'] && $mes['anio'] == $pedido['anio']) {
                    $mes['total_pedidos'] = $pedido['total_pedidos'];
                }
            }
        }

        foreach ($ventasPorMes as $pedido) {
            foreach ($mesesRango as &$mes) {
                if ($mes['mes'] == $pedido['mes'] && $mes['anio'] == $pedido['anio']) {
                    $mes['total_ventas'] = $pedido['total_ventas'];
                }
            }
        }


        $this->set('mesesRango', $mesesRango);  // Pasamos los datos al view

        //calcular monto total en el periododo consultado

        $pedidos =  $pedidosTable->find()
            ->where([
                'Pedidos.fecha_pedido >=' => $fecha_inicio,
                'Pedidos.fecha_pedido <=' => $fecha_fin
            ])
            ->contain([
                'PedidosEstados',
                'DetallesPedidos' => [
                    'Productos' => [
                        'ProductosPrecios' => function ($q) use ($fecha_inicio, $fecha_fin) {
                            return $q->where([
                                'fecha_desde <=' => $fecha_fin,
                                'fecha_hasta IS' => null // Incluir precios sin fecha de fin

                            ]);
                        }
                    ]
                ]
            ])
            ->orderBy(['fecha_pedido desc'])
            ->limit(10)
            ->all();



        $ventas =  $pedidosTable->find()
            ->where([
                'Pedidos.fecha_pedido >=' => $fecha_inicio,
                'Pedidos.fecha_pedido <=' => $fecha_fin,
                'Pedidos.estado_id' => '5'
            ])
            ->contain([
                'PedidosEstados',
                'DetallesPedidos' => [
                    'Productos' => [
                        'ProductosPrecios' => function ($q) use ($fecha_inicio, $fecha_fin) {
                            return $q->where([
                                'fecha_desde <=' => $fecha_fin,
                                'fecha_hasta IS' => null // Incluir precios sin fecha de fin

                            ]);
                        }
                    ]
                ]
            ])
            ->orderBy(['fecha_pedido desc'])
            ->all();

        $total = 0;

        foreach ($ventas as $pedido) {
            foreach ($pedido->detalles_pedidos as $detalle) {
                foreach ($detalle->producto->productos_precios as $precio) {
                    // Asegúrate de que el precio esté dentro del rango de fechas
                    if ($precio->fecha_desde <= $fecha_fin && ($precio->fecha_hasta >= $fecha_inicio || $precio->fecha_hasta === null)) {
                        $total += $precio->precio; // Sumar el precio del producto en el periodo
                    }
                }
            }
        }


        $this->set('pedidos', $pedidos);
        $this->set('ventas', $ventas);
        $this->set('total', $total);
        $this->set('filters', $this->getRequest()->getQuery());
    }
}
