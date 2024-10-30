<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Mailer\Mailer;
use Cake\Mailer\Exception\MissingActionException;
use Cake\Datasource\Exception\RecordNotFoundException;

/**
 * Consultas Controller
 *
 * @property \App\Model\Table\ConsultasTable $Consultas
 */
class ConsultasController extends AppController
{
    protected array $paginate = [
        'limit' => 10,
        'order' => [
            'Consultas.created' => 'asc',
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
        $consultas = $this->Consultas->find()
            ->where($conditions['where'])
            ->contain($conditions['contain']);

        $this->set('filters', $this->getRequest()->getQuery());
        $this->set('consultas', $this->paginate($consultas));
        $this->set('estados', $this->Consultas->ConsultasEstados->find('all')->all());
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        $consulta = $this->Consultas->newEmptyEntity();

        if ($this->request->is('post')) {
            $estadoPendiente = $this->Consultas->ConsultasEstados->find('all')
                ->where(['ConsultasEstados.nombre' => 'PENDIENTE'])
                ->first();

            if ($estadoPendiente) {
                $consulta->consulta_estado_id = $estadoPendiente->id;
            }


            $consulta = $this->Consultas->patchEntity($consulta, $this->request->getData());
            // debug($consulta);die;
            if ($this->Consultas->save($consulta)) {
                $this->Flash->success(__('Su consulta fue enviada correctamente, le responderemos a la brevedad.'));

                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('La consulta no pudo ser enviada. Por favor intenete nuevamente.'));
        }
        $this->set(compact('consulta'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Consulta id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function response($id = null)
    {
        $consulta = $this->Consultas->get($id, contain: ['UsuarioConsultas']);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $this->Consultas->getConnection()->begin();

            $consulta->usuario_respuesta_id = $_SESSION['RbacUsuario']['id'];
            $consulta = $this->Consultas->patchEntity($consulta, $this->request->getData());

            $estadoRespondido = $this->Consultas->ConsultasEstados->find('all')
                ->where(['ConsultasEstados.nombre' => 'RESPONDIDO'])
                ->first();

            if ($estadoRespondido) {
                $consulta->consulta_estado_id = $estadoRespondido->id;
            }

            if ($this->Consultas->save($consulta)) {

                $datos               = array();
                $datos['subject']    = 'IPMAGNA - Respuesta a su consulta';
                $datos['motivo']        = $consulta->motivo;
                $datos['respuesta']        = $consulta->respuesta;
                $datos['aplicacion'] = "IPMAGNA";
                $datos['template']   = 'consulta';
                $datos['email']      = $consulta->usuario_consulta->usuario;

                if ($this->sendEmail($datos)) {
                    $this->Consultas->getConnection()->commit();
                    $this->Flash->success('Se ha enviado la respuesta al cliente ' . $consulta->usuario_consulta->usuario);
                } else {
                    $this->Consultas->getConnection()->rollback();
                    $this->Flash->error('No se pudo enviar el email al cliente');
                }

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Consultas->getConnection()->rollback();
                $this->Flash->error('No se pudo guardar e enviar la respuesta');
            }
        }
        $this->set(compact('consulta'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Consulta id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        try {
            $consulta = $this->Consultas->get($id, contain: ['UsuarioConsultas', 'UsuarioRespuestas', 'ConsultasEstados']);
            // Establece la cabecera de respuesta 200
            $this->response = $this->response->withStatus(200);

            // Asigna la consulta a la vista
            $this->set(compact('consulta'));
            $this->render('view');
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('La consulta no existe.'));
            return $this->redirect(['action' => 'index']);
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Consulta id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $consulta = $this->Consultas->get($id);
        if ($this->Consultas->delete($consulta)) {
            $this->Flash->success(__('La consulta fue eliminada correctamente.'));
        } else {
            $this->Flash->error(__('La consulta no puedo ser eliminada. Por favor intente nuevamente.'));
        }

        return $this->redirect(['action' => 'index']);
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
        $conditions['contain'] = ['UsuarioConsultas', 'UsuarioRespuestas', 'ConsultasEstados'];

        if (isset($data['motivo']) and !empty($data['motivo'])) {
            $conditions['where'][] = ['Consultas.motivo LIKE' => '%' . $data['motivo'] . '%'];
        }

        if (isset($data['descripcion']) and !empty($data['descripcion'])) {
            $conditions['where'][] = ['Consultas.motivo LIKE ' => '%' . $data['descripcion'] . '%'];
        }

        if (isset($data['consulta_estado_id']) and !empty($data['consulta_estado_id'])) {
            $conditions['where'][] = ['Consultas.consulta_estado_id ' => $data['consulta_estado_id']];
        }


        $this->request->getSession()->write('previousUrl', $this->request->getRequestTarget());

        return $conditions;
    }

    private function sendEmail($datos, Mailer $mailer = null)
    {
        $mailer = $mailer ?: new Mailer('default'); // Usa el Mailer inyectado o crea uno nuevo
        try {
            $mailer->setFrom(['ipmagna-noreply@gmail.com' => 'IPMAGNA'])
                ->setTo($datos['email'])
                ->setSubject($datos['subject'])
                ->setEmailFormat('html')
                ->setViewVars(['motivo' => @$datos['motivo'], 'respuesta' => @$datos['respuesta']])
                ->viewBuilder()
                ->setTemplate($datos['template'])
                ->setPlugin('AdminLTE');

            $mailer->deliver();

            return true;
        } catch (MissingActionException $e) {
            $this->Flash->error('Error en el envío: ' . $e->getMessage());
            return false;
        } catch (\Exception $e) {
            $this->Flash->error('Se produjo un error inesperado: ' . $e->getMessage());
            return false;
        }
    }

}
