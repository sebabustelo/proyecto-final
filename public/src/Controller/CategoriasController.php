<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Http\Exception\MethodNotAllowedException;

/**
 * Categorias Controller
 *
 * @property \App\Model\Table\CategoriasTable $Categorias
 */
class CategoriasController extends AppController
{

    protected array $paginate = [
        'limit' => 10,
        'order' => [
            'Categorias.nombre' => 'asc',
        ],
    ];

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $conditions = $this->getConditions();
        $categorias = $this->Categorias->find()
            ->where($conditions['where'])
            ->contain($conditions['contain']);

        $this->set('filters', $this->getRequest()->getQuery());
        $this->set('categorias', $this->paginate($categorias));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $categoria = $this->Categorias->newEmptyEntity();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $categoria = $this->Categorias->patchEntity($categoria, $this->request->getData());
            if ($this->Categorias->save($categoria)) {
                $this->Flash->success(__('La categoría se guardo correctamente.'));

                return $this->redirect('/Categorias/index');
            }
            $this->Flash->error(__('La categoría no pudo ser guardada. Por favor, verifique los campos e intenete nuevamente.'));
        }
        $this->set(compact('categoria'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Categoria id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        try {
            $categoria = $this->Categorias->get($id, contain: []);

            if ($this->request->is(['patch', 'post', 'put'])) {

                $categoria = $this->Categorias->patchEntity($categoria, $this->request->getData());

                if ($this->Categorias->save($categoria)) {
                    $this->Flash->success(__('La categoría se actualizo correctamente.'));
                    return $this->redirect('/Categorias/index');
                }
                $this->Flash->error(__('La categoría no pudo ser guardada.'));
                if ($categoria->getErrors()) {
                    foreach ($categoria->getErrors() as $field => $errors) {
                        foreach ($errors as $error) {
                            $this->Flash->error(__($error));
                        }
                    }
                }
            }
            $this->set(compact('categoria'));
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('La categoría no existe.'));
            return $this->redirect(['action' => 'index']);
        } catch (\Exception $e) {
            $this->Flash->error(__('La categoría no es válida.'));
            return $this->redirect(['action' => 'index']);
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Categoria id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        try {
            $this->request->allowMethod(['post', 'delete']);
            $categoria = $this->Categorias->get($id);

            if ($this->Categorias->delete($categoria)) {
                $this->Flash->success(__('La categoría ha sido eliminada.'));
            } else {
                //$this->Flash->error(__('No se pudo eliminar la categoría.'));
                if ($categoria->getErrors()) {
                    foreach ($categoria->getErrors() as $field => $errors) {
                        foreach ($errors as $error) {
                            $this->Flash->error(__($error));
                        }
                    }
                }
            }
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('La categoría no existe.'));
        } catch (MethodNotAllowedException $e) {
            $this->Flash->error(__('Método HTTP no permitido.'));
        } catch (\InvalidArgumentException $e) {
            $this->Flash->error('La categoría no es válido.');
            return $this->redirect(['action' => 'index']);
        }

        return $this->redirect('/Categorias/index');
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
