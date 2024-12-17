<?php
/**
 * ProductosArchivos Controller
 *
 * @property \App\Model\Table\ProductosArchivosTable $ProductosArchivos
 */

 namespace App\Controller;




class ProductosArchivosController extends AppController
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
        $query = $this->ProductosArchivos->find()
            ->contain(['Productos']);
        $productosArchivos = $this->paginate($query);
        $this->set(compact('productosArchivos'));
    }
    /**
     * View method
     *
     * @param string|null $id Productos Archivo id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $productosArchivo = $this->ProductosArchivos->get($id, contain: ['Productos']);
        $this->set(compact('productosArchivo'));
    }
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->autoRender = false; // No renderizar vista
        $productosArchivo = $this->ProductosArchivos->newEmptyEntity();
        //debug($this->request->getData());die;
        if ($this->request->is('post')) {
            $data = $this->request->getData(); // Obtener los datos enviados
            //debug($data);die;
            if (isset($data['imagenes'])) {
                // Obtener el archivo desde el formulario
                $files = $data['imagenes']; // 'imagenes' es el nombre del input file
                $uploadPath = WWW_ROOT . 'img/productos/'; // Ruta donde se guardará el archivo
                //$fileName = $files->getClientFilename(); // Obtener el nombre del archivo
                // Mover el archivo a la carpeta correspondiente
                // $filePath = $uploadPath . $fileName;
                $result = $this->Upload->uploadMultiple($files, WWW_ROOT . 'img/productos/');
                //debug($filePath);die;
                if ($result['status']) {
                    foreach ($result['files'] as $file) {
                        $upload = $this->ProductosArchivos->newEmptyEntity();
                        $upload->file_name = $file['file_name'];
                        $upload->file_extension = $file['file_extension'];
                        $upload->file_size = $file['file_size'];
                        $upload->file_path = $file['file_path'];
                        $upload->producto_id = $data['producto_id'];
                        //if($principal){
                        $upload->es_principal = 0;
                        //  $principal = false;
                        //}
                        if ($this->ProductosArchivos->save($upload)) {
                            $response = [
                                'initialPreview' => ['<img src="/img/productos/' .  $upload->file_name . '" class="file-preview-image kv-preview-data" alt="' . $upload->file_name . '">'],
                                'initialPreviewConfig' => [[
                                    'caption' =>  $upload->file_name,
                                    'size' =>  $upload->file_size,
                                    'url' => '/ProductosArchivos/delete/' . $productosArchivo->id, // URL para eliminar el archivo
                                    'key' => $productosArchivo->id // ID del archivo en la base de datos
                                ]],
                                'append' => true
                            ];
                            echo json_encode($response);
                            return;
                        } else {
                            echo json_encode(['error' => 'El archivo no pudo ser guardado en la base de datos.']);
                            return;
                        }
                    }
                } else {
                    echo json_encode(['error' => 'Error al mover el archivo.']);
                    return;
                }
            } else {
                //echo json_encode(['error' => 'No ahi ningun archivo para subir.','append' => true]);
                echo json_encode(['append' => true]);
                return;
            }
        }
        echo json_encode(['error' => 'No se recibieron datos.']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Productos Archivo id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    // public function delete($id = null)
    // {
    //     $this->request->allowMethod(['post', 'delete']);
    //     $productosArchivo = $this->ProductosArchivos->get($id);
    //     if ($this->ProductosArchivos->delete($productosArchivo)) {
    //         $this->Flash->success(__('The productos archivo has been deleted.'));
    //     } else {
    //         $this->Flash->error(__('The productos archivo could not be deleted. Please, try again.'));
    //     }
    //     return json_encode([
    //         'delete' => true
    //     ]);
    //     //return $this->redirect(['action' => 'index']);
    // }
}
