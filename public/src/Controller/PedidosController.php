<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Categorias Controller
 *
 * @property \App\Model\Table\CategoriasTable $Categorias
 */
class PedidosController extends AppController
{

    // protected array $paginate = [
    //     'limit' => 10,
    //     'order' => [
    //         'Categorias.nombre' => 'asc',
    //     ],
    // ];

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function misPedidos()
    {
        // $conditions = $this->getConditions();
        // $categorias = $this->Categorias->find()
        //     ->where($conditions['where'])
        //     ->contain($conditions['contain']);

        // $this->set('filters', $this->getRequest()->getQuery());
        // $this->set('categorias', $this->paginate($categorias));
    }

    public function reserve($id = null)
    {
        $producto = $this->Pedidos->DetallesPedidos->Productos->find()
            ->where(['Productos.id' => $id])
            ->contain(['Categorias', 'ProductosArchivos'])
            ->first();

        if (!$producto) {
            $this->Flash->error(__('El producto no existe.'));
            return $this->redirect(['action' => 'index']);
        }
        //debug($producto);

        // Pasar el producto a la vista
        $this->set(compact('producto'));
    }


    /**
     * getCondition method
     *
     * @param string|null $data Data send by the Form .
     * @return array $conditions Conditions for search filters with $conditions['where'], $conditions['contain'] and $conditions['matching'] to find.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    private function getConditions()
    {
        $data = $this->getRequest()->getQuery();
        $conditions['where'] = [];
        $conditions['contain'] = [];

        if (isset($data['nombre']) and !empty($data['nombre'])) {
            $conditions['where'][] = ['Categorias.nombre LIKE' => '%' . $data['nombre'] . '%'];
        }

        if (isset($data['descripcion']) and !empty($data['descripcion'])) {
            $conditions['where'][] = ['Categorias.descripcion LIKE ' => '%' . $data['descripcion'] . '%'];
        }

        if (isset($data['activo'])) {
            $conditions['where'][] = ['Categorias.activo' => $data['activo']];
        } else {
            $conditions['where'][] = ['Categorias.activo' => 1];
        }

        $this->request->getSession()->write('previousUrl', $this->request->getRequestTarget());

        return $conditions;
    }
}
