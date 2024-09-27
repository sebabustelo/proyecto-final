<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Response;

/**
 * Localidades Controller
 *
 * @property \App\Model\Table\LocalidadesTable $Localidades
 */
class LocalidadesController extends AppController
{

    protected array $paginate = [
        'limit' => 10,
        'order' => [
            'Provincias.nombre' => 'desc',
            //'Localidades.nombre' => 'asc',
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
        $localidades = $this->Localidades->find()
            ->where($conditions['where'])
            ->contain($conditions['contain'])
            // ->orderBy($conditions['order'])
        ;
        $provincias = $this->Localidades->Provincias->find('list')->orderBy(['Provincias.nombre' => 'ASC'])->all();
        $this->set('provincias', $provincias);

        $this->set('filters', $this->getRequest()->getQuery());

        $this->set('localidades', $this->paginate($localidades));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $localidad = $this->Localidades->newEmptyEntity();
        if ($this->request->is('post')) {
            $localidad = $this->Localidades->patchEntity($localidad, $this->request->getData());

            if ($this->Localidades->save($localidad)) {
                $this->Flash->success(__('La localidad se guardo correctamente.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('La localidad no pudo ser guardada. Por favor, verifique los campos e intenete nuevamente.'));
        }
        $provincias = $this->Localidades->Provincias->find('list', limit: 200)->all();
        $this->set(compact('localidad', 'provincias'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Localidade id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $localidad = $this->Localidades->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $localidad = $this->Localidades->patchEntity($localidad, $this->request->getData());
            if ($this->Localidades->save($localidad)) {
                $this->Flash->success(__('La localidad se actualizo correctamente.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('La localidad no pudo ser guardada. Por favor, verifique los campos e intenete nuevamente.'));
        }
        $provincias = $this->Localidades->Provincias->find('list', limit: 200)->all();
        $this->set(compact('localidad', 'provincias'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Localidade id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $localidad = $this->Localidades->get($id);
        if ($this->Localidades->delete($localidad)) {
            $this->Flash->success(__('La localidad ha sido eliminada.'));
        } else {
            if ($localidad->getErrors()) {
                foreach ($localidad->getErrors() as $field => $errors) {
                    foreach ($errors as $error) {
                        $this->Flash->error(__($error));
                    }
                }
            } else {
                $this->Flash->error(__('No se pudo eliminar la localidad. Por favor, inténtalo de nuevo.'));
            }
        }

        return $this->redirect(['action' => 'index']);
    }

    public function localidades($provinciaId)
    {
        $this->viewBuilder()->disableAutoLayout();
        // $this->viewBuilder()->setLayout(null);
        $result = false;
        $localidades = $this->Localidades->find('all')
            ->where(['provincia_id' => $provinciaId])
            ->select(['id', 'nombre'])->all(); // Asegúrate de seleccionar los campos correctos

        $jsonData = json_encode($localidades, JSON_PRETTY_PRINT);

        $response = new Response();
        $response = $response->withType('application/json')->withStringBody($jsonData);
        return $response;
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
        $conditions['contain'] = ['Provincias'];
        $conditions['order'] = [];

        if (isset($data['provincia_id']) and !empty($data['provincia_id'])) {
            $conditions['where'][] = ['Localidades.provincia_id ' => $data['provincia_id']];
        }

        if (isset($data['nombre']) and !empty($data['nombre'])) {
            $conditions['where'][] = ['Localidades.nombre LIKE' => '%' . $data['nombre'] . '%'];
        }

        if (isset($data['activo'])) {
            $conditions['where'][] = ['Localidades.activo' => $data['activo']];
        } else {
            $conditions['where'][] = ['Localidades.activo' => 1];
        }

        $this->request->getSession()->write('previousUrl', $this->request->getRequestTarget());

        return $conditions;
    }
}
