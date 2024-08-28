<?php

namespace App\Controller;

use Cake\I18n\DateTime;
use Cake\ORM\Query\SelectQuery;
use Cake\Http\Response;
use Cake\Utility\Inflector;

/**
 * Resoluciones Controller
 *
 * @property \App\Model\Table\ResolucionesTable $Resoluciones
 */
class ResolucionesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Upload');
    }

    public function _null()
    {
    }

    /**
     * Busqueda method [carga_publica]
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function busqueda()
    {
        $this->viewBuilder()->setTheme('');
        $this->viewBuilder()->setLayout('public');
        $conditions = $this->getConditions($this->getRequest()->getQuery());

        $resoluciones = $this->Resoluciones->find()
            ->where($conditions['where'])
            ->contain($conditions['contain'])
            ->order('DocumentoTipos.descripcion');

        $this->set('resolucionesContador', $resoluciones->count());

        if (isset($conditions['matching'])) {
            foreach ($conditions['matching'] as $k => $matching) {
                $resoluciones->matching(
                    $matching
                );
            }
        }

        if (count($conditions['where'])) {
            $this->set('resoluciones', $this->paginate($resoluciones));
        }

        $this->set('filters', $this->getRequest()->getQuery());

        $documentoTipos = $this->Resoluciones->DocumentoTipos->find('list')->order('codigo')->all();
        $this->set('documentoTipos', $documentoTipos);

        $areas = $this->Resoluciones->Areas->find('list')->select(['id', 'descripcion'])->order('codigo')->all();
        $this->set('areas', $areas);

        $organismos = $this->Resoluciones->Organismos->find('list')->select(['id', 'descripcion'])->order('descripcion')->all();
        $this->set('organismos', $organismos);

        $funcionarios = $this->fetchTable('Funcionarios');
        $funcionarios = $funcionarios->find('list')->order('apellido')->all();
        $this->set('funcionarios', $funcionarios);

        $palabrasClaves = $this->Resoluciones->PalabrasClave->find('list')->select(['id', 'descripcion'])->order('descripcion')->all();
        $this->set('palabrasClaves', $palabrasClaves);

        $cargos = $this->Resoluciones->CargosFuncionarios->Cargos->find('list')->order('descripcion')->all();
        $this->set('cargos', $cargos);

        $palabras_claves = $this->Resoluciones->PalabrasClave->find('list')->order('palabra')->all();
        $this->set('palabras_claves', $palabras_claves);

        $rbacUsuarios = $this->Resoluciones->RbacUsuarios->find('list')->order('usuario')->all();
        $this->set('rbacUsuarios', $rbacUsuarios);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $conditions = $this->getConditions($this->getRequest()->getQuery());
        // debug($conditions);die;
        $resoluciones = $this->Resoluciones->find()
            ->where($conditions['where'])
            ->contain($conditions['contain'])
            ->order($conditions['order']);

        $this->set('resolucionesContador', $resoluciones->count());

        if (isset($conditions['matching'])) {
            foreach ($conditions['matching'] as $k => $matching) {
                $resoluciones->matching(
                    $matching
                );
            }
        }

        if (count($conditions['where'])) {
            $this->set('resoluciones', $this->paginate($resoluciones));
        }

        $this->set('filters', $this->getRequest()->getQuery());

        $documentoTipos = $this->Resoluciones->DocumentoTipos->find('list')->order('codigo')->all();
        $this->set('documentoTipos', $documentoTipos);

        $areas = $this->Resoluciones->Areas->find('list')->select(['id', 'descripcion'])->order('codigo')->all();
        $this->set('areas', $areas);

        $organismos = $this->Resoluciones->Organismos->find('list')->select(['id', 'descripcion'])->order('descripcion')->all();
        $this->set('organismos', $organismos);

        $funcionarios = $this->fetchTable('Funcionarios');
        $funcionarios = $funcionarios->find('list')->order('apellido')->all();
        $this->set('funcionarios', $funcionarios);

        $palabrasClaves = $this->Resoluciones->PalabrasClave->find('list')->select(['id', 'descripcion'])->order('descripcion')->all();
        $this->set('palabrasClaves', $palabrasClaves);

        $cargos = $this->Resoluciones->CargosFuncionarios->Cargos->find('list')->order('descripcion')->all();
        $this->set('cargos', $cargos);

        $palabras_claves = $this->Resoluciones->PalabrasClave->find('list')->order('palabra')->all();
        $this->set('palabras_claves', $palabras_claves);

        $rbacUsuarios = $this->Resoluciones->RbacUsuarios->find('list')->order('usuario')->all();
        $this->set('rbacUsuarios', $rbacUsuarios);
    }

    /**
     * getCondition method
     *
     * @param string|null $data Data send by the Form .
     * @return array $conditions Conditions for search filters with $conditions['where'], $conditions['contain'] and $conditions['matching'] to find.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    private function getConditions($data)
    {
        $conditions['where'] = [];

        if (isset($data['sort'])) {

            $field_sort = explode('.', $data['sort']);

            if (count($field_sort) > 1) {
                // Pluralizar la primera palabra
                $field_sort[0] = Inflector::pluralize($field_sort[0]);
                $field_sort[0] = Inflector::camelize($field_sort[0]);
                if (!isset($data['direction'])) {
                    $direction = 'asc';
                } else {
                    $direction = $data['direction'];
                }
                $order = $field_sort[0] . "." . $field_sort[1] . " " . $direction;
            } else {
                $order = $data['sort'] . " " . $data['direction'];
            }
            $conditions['order'] = $order;
        } else {
            $conditions['order'] = 'DocumentoTipos.descripcion asc';
            $this->paginate();
        }

        $conditions['contain'] =     ['PalabrasClave',   'Areas', 'CargosFuncionarios.Funcionarios', 'CargosFuncionarios.Cargos', 'DocumentoTipos', 'Uploads'];

        if (isset($data['documento_tipos']['_ids'])) {
            $conditions['where'][] = ['Resoluciones.documento_tipo_id IN' => $data['documento_tipos']['_ids']];
        }
        if (isset($data['organismos']['_ids'])) {
            $conditions['contain'][] = ['DocumentoTipos'];
            $conditions['where'][] = ['Resoluciones.organismo_id IN' => $data['organismos']['_ids']];
        }

        if (isset($data['areas']['_ids'])) {
            $conditions['where'][] = ['Resoluciones.area_id IN' => $data['areas']['_ids']];
        }
        if (isset($data['descripcion']) and !empty($data['descripcion'])) {
            $conditions['where'][] = ['Resoluciones.descripcion LIKE ' => '%' . $data['descripcion'] . '%'];
        }
        if (isset($data['numero']) and !empty($data['numero'])) {
            $conditions['where'][] = ['Resoluciones.numero' => $data['numero']];
        }
        if (isset($data['anio']) and !empty($data['anio']['_ids'])) {
            $conditions['where'][] = ['Resoluciones.anio IN' => $data['anio']['_ids']];
        }
        if (isset($data['proyecto']) and !empty($data['proyecto'])) {
            $conditions['where'][] = ['Resoluciones.proyecto LIKE' => '%' . $data['proyecto'] . '%'];
        }
        if (isset($data['titulo']) and !empty($data['titulo'])) {
            $conditions['where'][] = ['Resoluciones.titulo LIKE' => '%' . $data['titulo'] . '%'];
        }
        if (isset($data['expediente']) and !empty($data['expediente'])) {
            $conditions['where'][] = ['Resoluciones.expediente LIKE' => '%' . $data['expediente'] . '%'];
        }
        if (isset($data['firmantes']['_ids'])) {
            $conditions['where'][] = ['Resoluciones.cargo_firmante IN' => $data['firmantes']['_ids']];
        }
        if (isset($data['titulo']) and !empty($data['titulo'])) {
            $conditions['where'][] = ['Resoluciones.titulo LIKE' => '%' . $data['titulo'] . '%'];
        }
        if (isset($data['rbac_usuarios']['_ids']) and !empty($data['rbac_usuarios']['_ids'])) {
            $conditions['where'][] = ['Resoluciones.created_by IN' =>  $data['rbac_usuarios']['_ids']];
        }
        if (isset($data['palabras_claves']['_ids'])) {
            // $conditions['contain'] = ['PalabrasClave', 'DocumentoTipos', 'Areas'];
            $conditions['where'][] = ['PalabrasClave.id IN ' => $data['palabras_claves']['_ids']];
            $conditions['matching'][] = 'PalabrasClave';
        }
        if (isset($data['cargos']['_ids'])) {
            $conditions['where'][] = ['Cargos.id IN ' => $data['cargos']['_ids']];
        }
        if (isset($data['fecha_firma']) and !empty($data['fecha_firma'])) {
            // Separar las dos fechas basadas en el guion
            $fechas = explode(' - ', $data['fecha_firma']);
            // Convertir las cadenas de fecha en objetos DateTime
            $fecha_inicio = DateTime::createFromFormat('d/m/Y', $fechas[0]);
            $fecha_fin = DateTime::createFromFormat('d/m/Y', $fechas[1]);
            $conditions['where'][] = ['Resoluciones.fecha >= ' => $fecha_inicio];
            $conditions['where'][] = ['Resoluciones.fecha <= ' => $fecha_fin];
        }
        if (strpos($this->request->getRequestTarget(), "resoluciones/index"))
            $this->request->getSession()->write('previousUrl', $this->request->getRequestTarget());


        return $conditions;
    }

    /**
     * View method
     *
     * @param string|null $id Resolucione id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $resolucion = $this->Resoluciones->get($id, contain: [
            'DocumentoTipos', 'Areas', 'Organismos', 'PalabrasClave', 'Uploads',
            'PalabrasClave', 'DocumentoTipos', 'CargosFuncionarios.Funcionarios', 'CargosFuncionarios.Cargos',
            'ResolucionRelacionadasModificadora.ResolucionModificadora.Areas',  'ResolucionRelacionadasModificadora.ResolucionModificadora.DocumentoTipos',
            'ResolucionRelacionadasModificada.ResolucionModificada.Areas', 'ResolucionRelacionadasModificada.ResolucionModificada.DocumentoTipos', 'CargosFuncionarios.Funcionarios'
        ]);

        $this->set(compact('resolucion'));
    }

    /**
     * ViewPublic method [carga_publica]
     *
     * @param string|null $id Resolucione id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function viewPublic($id = null)
    {
        $this->viewBuilder()->setTheme('');
        $this->viewBuilder()->setLayout('public');
        $resolucion = $this->Resoluciones->get($id, contain: [
            'DocumentoTipos', 'Areas', 'Organismos', 'PalabrasClave', 'Uploads',
            'PalabrasClave', 'DocumentoTipos', 'CargosFuncionarios.Funcionarios', 'CargosFuncionarios.Cargos',
            'ResolucionRelacionadasModificadora.ResolucionModificadora.Areas',  'ResolucionRelacionadasModificadora.ResolucionModificadora.DocumentoTipos',
            'ResolucionRelacionadasModificada.ResolucionModificada.Areas', 'ResolucionRelacionadasModificada.ResolucionModificada.DocumentoTipos', 'CargosFuncionarios.Funcionarios'
        ]);

        // $resolucion = $this->Resoluciones->get($id, contain: ['DocumentoTipos', 'PalabrasClave', 'Areas']);
        $this->set(compact('resolucion'));
        //  $this->render("view");
    }

    /**
     * Add method
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $resolucion = $this->Resoluciones->newEmptyEntity();

        $documentoTipos = $this->Resoluciones->DocumentoTipos->find('list')->order('codigo')->all();
        $this->set('documentoTipos', $documentoTipos);

        $areas = $this->Resoluciones->Areas->find('list')->select(['id', 'codigo'])->order('codigo')->all();
        $this->set('areas', $areas);

        $organismos = $this->Resoluciones->Organismos->find('list')->select(['id', 'descripcion'])->order('descripcion')->all();
        $this->set('organismos', $organismos);

        $palabrasClaves = $this->Resoluciones->PalabrasClave->find('list')->select(['id', 'palabra'])->order('palabra')->all();
        $this->set('palabrasClaves', $palabrasClaves);

        $this->set(compact('resolucion', 'documentoTipos', 'palabrasClaves', 'areas', 'organismos'));

        if ($this->request->is('post')) {

            $data = $this->request->getData();

            // Procesa la subida del archivos
            //$file = $this->request->getData('attachments');
            $file = $_FILES['attachments'];
            $uploadPath = '../uploads' . DS;

            // Verificar si se ha subido un archivo y su tamaño
            if ($file && $file['error'] != UPLOAD_ERR_NO_FILE) {
                // Verificar si hubo algún error al subir el archivo
                foreach ($file['error'] as $k => $error) {
                    if ($error  !== UPLOAD_ERR_OK) {
                        $this->Flash->error(__('Error al subir el archivo. Por favor, intente nuevamente.'));
                        return;
                    }
                }

                // Verificar el tamaño del archivo (5 MB en bytes)
                $tamañoMaximo = 5 * 1024 * 1024;
                foreach ($file['size'] as $k => $size) {
                    if ($size > $tamañoMaximo) {
                        $this->Flash->error(__('El archivo es demasiado grande. Debe ser menor a 5 MB.'));
                        return;
                    }
                }

                $settings = [
                    'allowedExtensions' => ['pdf'],
                    'maxSize' => 5 * 1024 * 1024, // 1 MB en bytes
                    'folder' => date('Y')
                ];
                // Asignar el ID de la subida
                $data['uploads'] = $this->Upload->upload($settings);
            }

            if (!isset($data['resolucion_relacionadas_modificada'])) {
                $data['resolucion_relacionadas_modificada'] = [];
            }
            if (!isset($data['resolucion_relacionadas_modificadora'])) {
                $data['resolucion_relacionadas_modificadora'] = [];
            }

            // Parchar la entidad con los datos del formulario
            $resolucion = $this->Resoluciones->patchEntity($resolucion, $data, [
                'associated' => ['ResolucionRelacionadasModificada', 'ResolucionRelacionadasModificadora', 'PalabrasClave', 'Uploads']
            ]);

            $resolucion['uploads'] = $data['uploads'];

            // Guardar la entidad solo si el archivo se ha subido correctamente
            if ($this->Resoluciones->save($resolucion)) {

                $this->Flash->success(__('La resolución se guardó exitosamente.'));
                $previousUrl = $this->request->getSession()->read('previousUrl');
                return $this->redirect($previousUrl);
            } else {
                $this->Flash->error(__('La resolución no se guardó. Por favor, verifique los campos e intente nuevamente.'));
            }
        }

        // $funcionarios = $this->buscarFuncionariosPorDocumentoTipo($resolucion['documento_tipo_id'], 1);
        // $this->set('funcionarios', $funcionarios);

    }


    public function buscarFuncionariosPorDocumentoTipo($documentoTipo = 0, $flag = 0)
    {
        $cargos = [];
        $funcionariosList = [];
        $cargosFuncionarios = $this->Resoluciones->DocumentoTipos->find('all')->select('id')->where(['id' => $documentoTipo])
            ->contain(['Cargos' => function (SelectQuery $query) {
                return $query->select(['id']);
            }])->first();

        foreach ($cargosFuncionarios['cargos'] as $k => $cargo) {
            $cargos[] = $cargo['id'];
        }

        $funcionarios = $this->fetchTable('CargosFuncionarios');
        if (isset($cargos) and count($cargos) > 0) {

            $funcionarios = $funcionarios->find('all')->where(['cargo_id IN' => $cargos])->contain(['Funcionarios', 'Cargos'])->order('Funcionarios.apellido')->all();
        }

        foreach ($funcionarios as $k => $f) {

            if (isset($f['cargo']) and !is_null($f['cargo'])) {
                $cargo_descripcion =  $f['cargo']['full_name'];

                $nombramiento = "";
                if (isset($f['nombramiento']) and !is_null($f['nombramiento'])) {
                    $nombramiento = "(" . $cargo_descripcion . " ----" . $f['nombramiento'] . ")";
                } else {
                    $nombramiento = "(" . $cargo_descripcion . ")";
                }
            }

            $funcionariosList[$k]['id'] = $f['id'];
            $funcionariosList[$k]['full_name'] = $f['funcionario']['apellido'] . ", " . $f['funcionario']['nombre'] . $nombramiento;
        }

        if ($flag == 1) {
            return $funcionariosList;
        } else {

            $jsonData = json_encode($funcionariosList);
            // Crea una nueva instancia de Response y establece el cuerpo de la respuesta como datos JSON
            $response = new Response();
            $response = $response->withType('application/json')->withStringBody($jsonData);

            // Devuelve la respuesta para ser enviada de vuelta al cliente
            return $response;
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Resolucione id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $resolucion = $this->Resoluciones->get($id, contain: [
            'DocumentoTipos', 'Uploads',
            'PalabrasClave', 'DocumentoTipos', 'CargosFuncionarios.Funcionarios', 'CargosFuncionarios.Cargos',
            'ResolucionRelacionadasModificadora.ResolucionModificadora.Areas',  'ResolucionRelacionadasModificadora.ResolucionModificadora.DocumentoTipos',
            'ResolucionRelacionadasModificada.ResolucionModificada.Areas', 'ResolucionRelacionadasModificada.ResolucionModificada.DocumentoTipos', 'CargosFuncionarios.Funcionarios'
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $data =  $this->request->getData();
            $file = $this->request->getData('attachments');

            $settings = [
                'allowedExtensions' => ['pdf'],
                'maxSize' => 5 * 1024 * 1024, // 1 MB en bytes
                'folder' => $resolucion->fecha->format('Y')
            ];

            //debug($data);die;

            $fileDelete = $this->request->getData('delete');
            if (!is_null($fileDelete) and count($fileDelete) > 0) {

                foreach ($fileDelete as $k => $delete) {
                    if (!empty($delete)) {
                        //eliminar la fila de la tabla uploads_resoluciones y la fila de la tabla uploads
                        //eliminar el archivo de la carpeta uploads
                        $upload = $this->Resoluciones->Uploads->findById($delete)->first();
                        @unlink(ROOT . DS . "uploads" . DS . $settings['folder'] . DS . $upload->nombre_archivo);
                        $this->Upload->delete($settings, $delete);
                    }
                }
            }

            if ($file[0] && $file[0]->getError() != UPLOAD_ERR_NO_FILE) {

                ////////////////
                // Verificar si hubo algún error al subir el archivo
                // foreach ($file['error'] as $k => $error) {
                //     if ($error  !== UPLOAD_ERR_OK) {
                //         $this->Flash->error(__('Error al subir el archivo. Por favor, intente nuevamente.'));
                //         return;
                //     }
                // }

                // Verificar el tamaño del archivo (5 MB en bytes)
                // $tamañoMaximo = 5 * 1024 * 1024;
                // foreach ($file['size'] as $k => $size) {
                //     if ($size > $tamañoMaximo) {
                //         $this->Flash->error(__('El archivo es demasiado grande. Debe ser menor a 5 MB.'));
                //         return;
                //     }
                // }

                // Asignar el/los ID/s de la subida
                $data['uploads']['_ids'] = $this->Upload->upload($settings);


                //////////////
                // $uploadsId = $this->Upload->upload($settings);
                // if ($uploadsId === null) {
                //     return $this->redirect(['action' => 'edit', $id]);
                // }
                // $data['uploads'] = $uploadsId;
            }

            if (!isset($data['resolucion_relacionadas_modificada'])) {
                $data['resolucion_relacionadas_modificada'] = [];
            }
            if (!isset($data['resolucion_relacionadas_modificadora'])) {
                $data['resolucion_relacionadas_modificadora'] = [];
            }

            $resolucion = $this->Resoluciones->patchEntity($resolucion,  $data, [
                'associated' => ['Uploads', 'ResolucionRelacionadasModificada', 'ResolucionRelacionadasModificadora', 'PalabrasClave']
            ]);

            if ($this->Resoluciones->save($resolucion)) {
                $this->Flash->success(__('El Registro se actualizo exitosamente.'));
                $previousUrl = $this->request->getSession()->read('previousUrl');
                return $this->redirect($previousUrl);
                #return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('No se pudo guardar el Registro.'));
            }
        }

        $documentoTipos = $this->Resoluciones->DocumentoTipos->find('list')->order('codigo')->all();

        $funcionarios = $this->buscarFuncionariosPorDocumentoTipo($resolucion['documento_tipo_id'], 1);
        $this->set('funcionarios', $funcionarios);

        $palabrasClaves = $this->Resoluciones->PalabrasClave->find('list')->all();
        $this->set(compact('resolucion', 'documentoTipos', 'palabrasClaves'));


        $areas = $this->Resoluciones->Areas->find('list')->select(['id', 'codigo'])->order('codigo')->all();
        $this->set('areas', $areas);

        $organismos = $this->Resoluciones->Organismos->find('list')->select(['id', 'descripcion'])->order('descripcion')->all();
        $this->set('organismos', $organismos);

        $palabrasClaves = $this->Resoluciones->PalabrasClave->find('list')->select(['id', 'palabra'])->order('palabra')->all();
        $this->set('palabrasClaves', $palabrasClaves);
    }

    // Si recibe el id solo busca la resoluciones y los archivos asociados en uploads, si tiene uno descargo el archivo, si tiene mas de uno descargo un zip
    // y si viene el id y el uploadId descargo el archivo solo sin zipear.
    public function descargarArchivo($id = null, $uploadId = null)
    {
        if (is_null($uploadId)) {
            $resolucion = $this->Resoluciones->findById($id)->contain(['Uploads'])->first();
        } else {
            $resolucion = $this->Resoluciones->find()->where(['Uploads.id' => $uploadId])->matching('Uploads')->first();
            $resolucion['uploads'] = $resolucion->_matchingData;
        }

        if (isset($resolucion->uploads) and count($resolucion->uploads) > 0) {

            $fecha = (isset($resolucion->anio) and (!is_null($resolucion->anio))) ? $resolucion->anio : '';
            $settings = [
                'allowedExtensions' => ['pdf'],
                'maxSize' => 1 * 1024 * 1024, // 1 MB en bytes
                'folder' => $fecha
            ];

            if (isset($resolucion->uploads['Uploads']['id']) or (count($resolucion->uploads) == 1)) {
                if (isset($resolucion->uploads['Uploads']['id'])) {
                    $this->Upload->descargar($resolucion->uploads['Uploads']['id'], $settings);
                } else {
                    //viene desde el listado pero tiene un solo archivo, no hace falta zip
                    $this->Upload->descargar($resolucion->uploads[0]['id'], $settings);
                }
            } else {
                $uploadsIds = [];
                foreach ($resolucion->uploads as $k => $upload) {
                    $uploadsIds[] = $upload->id;
                }
                //descargar zip, varios archivos
                $this->Upload->descargarZip($uploadsIds, $settings);
                die;
            }
        }
        if (is_null($id)) {
            if ($this->request->getSession()->check('previousUrl') && !empty($this->request->getSession()->check('previousUrl'))) {
                $url = $this->request->getSession()->read('previousUrl');
            } else {
                $url = '/resoluciones/index';
            }
            return $this->redirect($url);
        } else {
            return $this->redirect(['controller' => 'Resoluciones', 'action' => 'edit', $id]);
        }
    }

    // Si recibe el id solo busca la resoluciones y los archivos asociados en uploads, si tiene uno descargo el archivo, si tiene mas de uno descargo un zip
    // y si viene el id y el uploadId descargo el archivo solo sin zipear.
    public function descargarArchivoPublico($id = null, $uploadId = null)
    {
        if (is_null($uploadId)) {
            $resolucion = $this->Resoluciones->findById($id)->contain(['Uploads'])->first();
        } else {
            $resolucion = $this->Resoluciones->find()->where(['Uploads.id' => $uploadId])->matching('Uploads')->first();
            $resolucion['uploads'] = $resolucion->_matchingData;
        }

        if (isset($resolucion->uploads) and count($resolucion->uploads) > 0) {

            $fecha = (isset($resolucion->anio) and (!is_null($resolucion->anio))) ? $resolucion->anio : '';
            $settings = [
                'allowedExtensions' => ['pdf'],
                'maxSize' => 1 * 1024 * 1024, // 1 MB en bytes
                'folder' => $fecha
            ];

            if (isset($resolucion->uploads['Uploads']['id']) or (count($resolucion->uploads) == 1)) {
                if (isset($resolucion->uploads['Uploads']['id'])) {
                    $this->Upload->descargar($resolucion->uploads['Uploads']['id'], $settings);
                } else {
                    //viene desde el listado pero tiene un solo archivo, no hace falta zip
                    $this->Upload->descargar($resolucion->uploads[0]['id'], $settings);
                }
            } else {
                $uploadsIds = [];
                foreach ($resolucion->uploads as $k => $upload) {
                    $uploadsIds[] = $upload->id;
                }
                //descargar zip, varios archivos
                $this->Upload->descargarZip($uploadsIds, $settings);
                die;
            }
        }
        if (is_null($id)) {
            if ($this->request->getSession()->check('previousUrl') && !empty($this->request->getSession()->check('previousUrl'))) {
                $url = $this->request->getSession()->read('previousUrl');
            } else {
                $url = '/resoluciones/index';
            }
            return $this->redirect($url);
        } else {
            return $this->redirect(['controller' => 'Resoluciones', 'action' => 'edit', $id]);
        }
    }

    public function buscarResolucionAsociada($id = null)
    {
        $conditions = $this->getConditions($this->getRequest()->getQuery());
        $data = $this->getRequest()->getQuery();

        if (isset($data['id']) && !empty($data['id'])) {
            $conditions['where'][] = ['Resoluciones.id <>' => $data['id']];
            $this->set('id', $data['id']);
        } elseif (isset($id) && !empty($id)) {
            $conditions['where'][] = ['Resoluciones.id <>' => $id];
            $this->set('id', $id);
        }

        $resoluciones = $this->Resoluciones->find()
            ->where($conditions['where'])
            ->contain($conditions['contain'])
            ->order($conditions['order']);

        if (isset($conditions['matching'])) {
            foreach ($conditions['matching'] as $k => $matching) {
                $resoluciones->matching(
                    $matching
                );
            }
        }

        $this->set('filters', $this->getRequest()->getQuery());

        $documentoTipos = $this->Resoluciones->DocumentoTipos->find('list')->order('codigo')->all();
        $this->set('documentoTipos', $documentoTipos);

        $areas = $this->Resoluciones->Areas->find('list')->select(['id', 'descripcion'])->order('codigo')->all();
        $this->set('areas', $areas);

        $organismos = $this->Resoluciones->Organismos->find('list')->select(['id', 'descripcion'])->order('descripcion')->all();
        $this->set('organismos', $organismos);

        $funcionarios = $this->fetchTable('Funcionarios');
        $funcionarios = $funcionarios->find('list')->order('apellido')->all();
        $this->set('funcionarios', $funcionarios);

        $palabrasClaves = $this->Resoluciones->PalabrasClave->find('list')->select(['id', 'descripcion'])->order('descripcion')->all();
        $this->set('palabrasClaves', $palabrasClaves);

        $cargos = $this->Resoluciones->CargosFuncionarios->Cargos->find('list')->select(['id', 'descripcion'])->order('descripcion')->all();
        $this->set('cargos', $cargos);

        $palabras_claves = $this->Resoluciones->PalabrasClave->find('list')->order('palabra')->all();
        $this->set('palabras_claves', $palabras_claves);

        $this->paginate = [
            // 'limit' => 6,
            'order' => [
                'Resoluciones.documento_tipo_id' => 'asc', 'fecha'
            ],
        ];

        if (count($conditions['where']) > 1) {
            $this->set('resoluciones', $this->paginate($resoluciones));
            $this->render('/element/resoluciones/listadoResoluciones');
        } else {
            $this->render('/Resoluciones/buscarResolucionAsociada');
        }
    }

    public function exportar()
    {
        $this->viewBuilder()->setTheme('');
        $this->viewBuilder()->setLayout('informe_excel');
        $conditions = $this->getConditions($this->getRequest()->getQuery());


        $resoluciones = $this->Resoluciones->find()
            ->where($conditions['where'])
            ->contain($conditions['contain'])
            ->order('DocumentoTipos.descripcion');


        $this->set('resoluciones', $resoluciones->all());
    }

    /**
     * Delete method
     *
     * @param string|null $id Resolucione id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $resolucione = $this->Resoluciones->get($id);
        if ($this->Resoluciones->delete($resolucione)) {
            $this->Flash->success(__('El registro se elimino correctamente.'));
        } else {
            $this->Flash->error(__('El registro no pudo ser eliminado.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
