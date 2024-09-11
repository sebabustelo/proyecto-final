<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Productos Controller
 *
 * @property \App\Model\Table\ProductosTable $Productos
 */
class ProductosController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Upload');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Productos->find()
            ->contain(['Categorias', 'Proveedores','Uploads']);
        $productos = $this->paginate($query);

        $this->set(compact('productos'));
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function catalogoCliente()
    {
        $query = $this->Productos->find()
            ->contain(['Categorias', 'Proveedores']);
        $productos = $this->paginate($query);

        $this->set(compact('productos'));
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $producto = $this->Productos->newEmptyEntity();
        if ($this->request->is('post')) {
           
            $producto = $this->Productos->patchEntity($producto,$this->request->getData());
          
           
            if ($this->Productos->save($producto)) {

                $data = $this->request->getData();
                $file = $_FILES['imagen-principal'];
                // Verificar si se ha subido un archivo y su tamaño
                if ($file && $file['error'] != UPLOAD_ERR_NO_FILE) {
                    // Verificar si hubo algún error al subir el archivo
                    //foreach ($file['error'] as $k => $error) {
                    if ($file['error']   !== UPLOAD_ERR_OK) {
                        $this->Flash->error(__('Error al subir el archivo. Por favor, intente nuevamente.'));
                        return;
                    }
                    // }
    
                    // Verificar el tamaño del archivo (1.5 MB en bytes)
                    $tamañoMaximo = 1.5 * 1024 * 1024;
                    //foreach ($file['size'] as $k => $size) {
                    if ($file['size'] > $tamañoMaximo) {
                        $this->Flash->error(__('El archivo es demasiado grande. Debe ser menor a 5 MB.'));
                        return;
                    }
                    //}
    
                    $settings = [
                        'allowedExtensions' => ['gif', 'jpg', 'png'],
                        'maxSize' => 5 * 1024 * 1024, 
                        'field' => 'imagen-principal',
                        'producto_id' => $producto->id,
                        'principal' => true
                        //'folder' => date('Y')
                    ];
                    // Asignar el ID de la subida
                    $data['uploads'] = $this->Upload->upload($settings);
                }

                $this->Flash->success(__('El kit se guardo correctamente.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('El kit no pudo ser guardado. Por favor, verifique los campos e intenete nuevamente.'));
        }
        $categorias = $this->Productos->Categorias->find('list', limit: 200)->all();
        $proveedores = $this->Productos->Proveedores->find('list', limit: 200)->all();
        $this->set(compact('producto', 'categorias', 'proveedores'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Producto id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $producto = $this->Productos->get($id, contain: ['Uploads']);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $producto = $this->Productos->patchEntity($producto, $this->request->getData());
            if ($this->Productos->save($producto)) {
                $this->Flash->success(__('The producto has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The producto could not be saved. Please, try again.'));
        }
        $categorias = $this->Productos->Categorias->find('list', limit: 200)->all();
        $proveedores = $this->Productos->Proveedores->find('list', limit: 200)->all();
        $this->set(compact('producto', 'categorias', 'proveedores'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Producto id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $producto = $this->Productos->get($id);
        if ($this->Productos->delete($producto)) {
            $this->Flash->success(__('The producto has been deleted.'));
        } else {
            $this->Flash->error(__('The producto could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
