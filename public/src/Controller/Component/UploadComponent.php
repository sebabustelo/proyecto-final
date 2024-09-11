<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Utility\Security;
use ZipArchive;

class UploadComponent extends Component
{

    private $Controller = NULL;

    public function initialize(array $settings): void
    {
        $this->Upload  =    TableRegistry::getTableLocator()->get('Uploads');
        $this->Controller = $this->_registry->getController();
    }

    public function upload($settings = [])
    {
        // Configuración predeterminada      
        $defaultSettings = [
            'allowedExtensions' => ['pdf', 'tif'],
            'maxSize' => 5 * 1024 * 1024, // 1 MB en bytes
            'folder' => '',
            'field' => 'attachments'
        ];

        // Combinar configuración predeterminada con la personalizada
        $settings = array_merge($defaultSettings, $settings);

        $field =  $this->getController()->getRequest()->getData($settings['field']);

        if ($field->getClientFilename()) {
            //es un solo archivo
            $attachment[] =  $field;
        } else {
            $attachment =  $field;
        }

        // Verificar si hay error en la subida del archivo
        foreach ($attachment as $k => $error) {
            if ($error->getError()  !== UPLOAD_ERR_OK) {
                $this->getController()->Flash->error('Error de configuración del servidor para la subida de archivos, por favor intente con uno de menor tamaño y/o contacte a soporte');
                return;
            }
        }


        // Generar directorios de guardado
        $output_dir = ROOT . DS . "webroot" . DS . "img" . DS . "productos" . DS . $settings['folder'];

        if (!file_exists($output_dir)) {
            if (!mkdir($output_dir, 0755, true)) {
                $this->getController()->Flash->error('No se pudo crear el directorio de destino para la subida del archivo.');
                return null;
            }
        }

        $uploads = [];
        foreach ($attachment as $k => $file) {

            $nombre_fichero = $file->getStream()->getMetadata('uri');
            //$nombre_fichero = $file[$]["tmp_name"];

            $tmp = explode('.', $file->getClientFilename());
            $extensionArchivo = strtolower(end($tmp));

            $hash_archivo = Security::hash($nombre_fichero  . date("YmdHis"), 'sha1', true);

            $created = date('now');
            $hash_llave = hash('sha256', $hash_archivo . $created);

            $nombre_archivo = substr($hash_archivo, 4, strlen($hash_archivo) - 4);

            // Tomar datos de usuario
            $session = $this->getController()->getRequest()->getSession();
            $usuario = $session->read('RbacUsuario');

            $nombreArchivoSinExtension = pathinfo($file->getClientFilename(), PATHINFO_FILENAME);
            $size = $file->getSize();

            // Verificar la extensión y el tamaño del archivo
            if (in_array($extensionArchivo, $settings['allowedExtensions']) && $size <= $settings['maxSize']) {

                if (move_uploaded_file($nombre_fichero, $output_dir . DS . $nombre_archivo . '.' . $extensionArchivo)) {
                    $upload = [
                        'nombre_archivo' => $nombre_archivo,
                        'nombre_original' => $nombreArchivoSinExtension,
                        'hash_archivo' => $hash_archivo,
                        'extension_archivo' => $extensionArchivo,
                        'hash_llave' => $hash_llave,
                        'kit_cirugia_id'   => $settings['producto_id'],
                        'es_principal'  => $settings['principal']
                    ];

                    $entityUpload = $this->Upload->newEntity($upload);

                    $this->Upload->save($entityUpload);
                    $uploads[] =  $entityUpload->id;
                    //return $entityUpload->id;
                } else {
                    $error[] = 'Error al mover el archivo subido.';                    
                }
            } else {
                if (!in_array($extensionArchivo, $settings['allowedExtensions'])) {
                    $this->getController()->Flash->error('La extensión del archivo no está permitida. Las extensiones permitidas son: ' . implode(', ', $settings['allowedExtensions']));
                } else {
                    $this->getController()->Flash->error('El archivo es demasiado grande. Debe ser menor a ' . ($settings['maxSize'] / (1024 * 1024)) . ' MB.');
                }
                // return null;
                $error[] = 'Error al mover el archivo subido.';
            }
        }
        //debug($uploads);
        return $uploads;
    }

    public function uploadEncrypt($settings = [])
    {
        // Configuración predeterminada      
        $defaultSettings = [
            'allowedExtensions' => ['pdf', 'tif'],
            'maxSize' => 5 * 1024 * 1024, // 1 MB en bytes
            'folder' => ''
        ];

        // Combinar configuración predeterminada con la personalizada
        $settings = array_merge($defaultSettings, $settings);

        // Verificar si hay error en la subida del archivo
        if (isset($_FILES['attachments']['error']) && ($_FILES['attachments']['error'] || !$_FILES['attachments']['tmp_name'])) {
            $this->getController()->Flash->error('Error de configuración del servidor para la subida de archivos, por favor intente con uno de menor tamaño y/o contacte a soporte');
            return $this->getController()->redirect($this->getController()->referer());
        }

        // Generar directorios de guardado
        $output_dir = ROOT . DS . "uploads" . DS . $settings['folder'];
        if (!file_exists($output_dir)) {
            if (!mkdir($output_dir, 0755, true)) {
                $this->getController()->Flash->error('No se pudo crear el directorio de destino para la subida del archivo.');
                return null;
            }
        }

        $nombre_fichero = $_FILES["attachments"]["tmp_name"];
        $nombre_archivo = strtolower(pathinfo($_FILES["attachments"]["name"], PATHINFO_FILENAME));
        $extensionArchivo = strtolower(pathinfo($_FILES["attachments"]["name"], PATHINFO_EXTENSION));
        $size = $_FILES['attachments']['size'];

        $hash_archivo = Security::hash($nombre_fichero . date("YmdHis"), 'sha1', true);
        $created = date('Y-m-d H:i:s'); // Use a proper datetime format
        $hash_llave = hash('sha256', $hash_archivo . $created);

        // Tomar datos de usuario
        $session = $this->getController()->getRequest()->getSession();
        $usuario = $session->read('RbacUsuario');
        // Verificar la extensión y el tamaño del archivo
        if (in_array($extensionArchivo, $settings['allowedExtensions']) && $size <= $settings['maxSize']) {

            // Leer el contenido del archivo
            $fileContent = file_get_contents($nombre_fichero);

            // Cifrar el archivo con openssl
            $key = substr(hash('sha256', $hash_llave, true), 0, 32); // Derivar una clave de 32 bytes
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc')); // Generar un vector de inicialización
            $cipherText = openssl_encrypt($fileContent, 'aes-256-cbc', $key, 0, $iv);
            $cipherText = $iv . $cipherText; // Prepend the IV for decryption later

            // Añadir un mensaje de aviso al inicio del archivo cifrado
            $warningMessage = "Este archivo está encriptado. No puede ser abierto directamente.\n";
            $cipherText = $warningMessage . $cipherText;

            // Guardar el archivo cifrado
            $filePath = $output_dir . DS . $hash_archivo;
            if (file_put_contents($filePath, $cipherText)) {
                // Borrar el archivo temporal después de moverlo
                unlink($nombre_fichero);

                //if (move_uploaded_file($_FILES["attachments"]["tmp_name"], $output_dir . DS . $nombre_archivo . '.' . $extensionArchivo)) {
                $upload = [
                    'nombre_archivo' => $hash_archivo,
                    'nombre_original' => $nombre_archivo,
                    'hash_archivo' => $hash_archivo,
                    'extension_archivo' => $extensionArchivo,
                    'hash_llave' => $hash_llave,
                    'created_by' => $usuario['id'],
                    'modified_by' => $usuario['id']
                ];

                $entityUpload = $this->Upload->newEntity($upload);
                $this->Upload->save($entityUpload);
                return $entityUpload->id;
            } else {
                $this->getController()->Flash->error('Error al mover el archivo subido.');
                return null;
            }
        } else {
            if (!in_array($extensionArchivo, $settings['allowedExtensions'])) {
                $this->getController()->Flash->error('La extensión del archivo no está permitida. Las extensiones permitidas son: ' . implode(', ', $settings['allowedExtensions']));
            } else {
                $this->getController()->Flash->error('El archivo es demasiado grande. Debe ser menor a ' . ($settings['maxSize'] / (1024 * 1024)) . ' MB.');
            }
            return null;
        }
    }

    public function delete($settings, $id)
    {
        if (!$id) {
            $this->getController()->Flash->error('No se encuentra el archivo a eliminar.');
            return false;
        }

        $upload = $this->Upload->findById($id)->first();

        if ($upload == null) {
            $this->getController()->Flash->error('No se encuentra el archivo asociado a eliminar.');
            return false;
        }

        $extension_archivo = $upload->extension_archivo;
        $nombre_archivo = $upload->nombre_archivo;
        try {
            $this->Upload->delete($upload);
            //$this->getController()->Flash->error('Datos del archivo asociado anteriormente eliminados.');
            return true;
        } catch (\Exception $e) {
            //$this->getController()->Flash->error('No tenia datos asociados');
        }

        // Configuración predeterminada      
        $defaultSettings = [
            'allowedExtensions' => ['pdf'],
            'maxSize' => 5 * 1024 * 1024, // 1 MB en bytes
            'folder' => ''
        ];

        // Combinar configuración predeterminada con la personalizada
        $settings = array_merge($defaultSettings, $settings);

        $output_dir = ROOT . DS . "uploads" . DS . $settings['folder'] . '/';

        //borro fisicamente

        if (file_exists($output_dir . $nombre_archivo . '.' . $extension_archivo)) {
            if (unlink($output_dir . $nombre_archivo . '.' . $extension_archivo)) {
                //$this->getController()->Flash->error('Arhivo asociado anteriormente eliminado.');               
                return true;
            } else {
                return false;
            }
        }
    }

    public function detectFileMimeType($filename = '')
    {
        if (!file_exists($filename)) {
            return 'application/octet-stream';
        }

        // Usar mime_content_type si está disponible
        if (function_exists('mime_content_type')) {
            return mime_content_type($filename);
        }

        // Mapas de tipo MIME
        $mime_types = [
            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        ];

        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (array_key_exists($ext, $mime_types)) {
            return $mime_types[$ext];
        }

        // Usar finfo_open si está disponible
        if (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimetype = finfo_file($finfo, $filename);
            finfo_close($finfo);
            return $mimetype;
        }

        return 'application/octet-stream';
    }

    public function descargar($id, $settings = [])
    {
        if (!$id) {
            $this->getController()->Flash->error('No se encuentra el archivo asociado a descargar.');
        }

        $upload = $this->Upload->findById($id)->first();



        if (empty($upload)) {
            $this->getController()->Flash->error('No se encuentra el archivo a descargar.');
            return false;
        }

        $hash_llave = $upload->hash_llave;

        $this->getController()->viewBuilder()->setLayout(null);



        if (!empty($hash_llave) && strlen(trim($hash_llave)) == 64) {
            $hash_archivo = $upload->hash_archivo;
            $nombre_original = $upload->nombre_original;
            $extension_archivo = $upload->extension_archivo;
            $nombre_archivo = substr($hash_archivo, 4);

            // Configuración predeterminada      
            $defaultSettings = [
                'allowedExtensions' => ['pdf'],
                'maxSize' => 5 * 1024 * 1024, // 1 MB en bytes
                'folder' => ''
            ];

            // Combinar configuración predeterminada con la personalizada
            $settings = array_merge($defaultSettings, $settings);

            $filename = ROOT . DS . "uploads" . DS . $settings['folder'] . DS . $nombre_archivo . '.' . $extension_archivo;

            if (file_exists($filename)) {
                $mime = $this->detectFileMimeType($filename);
                $fileNameOriginal = $nombre_original . '.' . $extension_archivo;
                header('Content-Disposition: attachment; filename="' . $fileNameOriginal . '"' . " ;Content-type: " . $mime);
                ob_clean();
                readfile($filename);
            } else {
                $this->getController()->Flash->error('No se encuentra el archivo a descargar.');
                return false;
            }
        } else {
            $this->getController()->Flash->error('No se pudo descargar el archivo.');
            return $this->getController()->redirect($this->getController()->referer());
        }

        return $upload->nombre_original . '.' . $upload->extension_archivo;
    }

    public function descargarZip($ids, $settings = [])
    {

        if (!$ids) {
            $this->getController()->Flash->error('No se encuentra el archivo asociado a descargar.');
        }

        $uploads = $this->Upload->find('all')->where(['id IN' => $ids])->all();

        if (count($uploads) == 0) {
            $this->getController()->Flash->error('No se encuentra el archivo a descargar.');
            return false;
        }

        $zipFileName =  ROOT . DS . "uploads" . DS . '/archivos.zip';
        $zip = new ZipArchive();

        if ($zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($uploads as $k => $upload) {
                # code...
                $hash_llave = $upload->hash_llave;

                $this->getController()->viewBuilder()->setLayout(null);

                if (!empty($hash_llave) && strlen(trim($hash_llave)) == 64) {
                    $hash_archivo = $upload->hash_archivo;
                    $nombre_original = $upload->nombre_original;
                    $extension_archivo = $upload->extension_archivo;
                    $nombre_archivo = substr($hash_archivo, 4);

                    // Configuración predeterminada      
                    $defaultSettings = [
                        'allowedExtensions' => ['pdf'],
                        'maxSize' => 5 * 1024 * 1024, // 1 MB en bytes
                        'folder' => ''
                    ];

                    // Combinar configuración predeterminada con la personalizada
                    $settings = array_merge($defaultSettings, $settings);

                    $filename = ROOT . DS . "uploads" . DS . $settings['folder'] . DS . $nombre_archivo . '.' . $extension_archivo;

                    if (file_exists($filename)) {


                        // $mime = $this->detectFileMimeType($filename);
                        $fileNameOriginal = $nombre_original . '.' . $extension_archivo;
                        // header('Content-Disposition: attachment; filename="' . $fileNameOriginal . '"' . " ;Content-type: " . $mime);
                        // ob_clean();
                        // readfile($filename);
                        $zip->addFile($filename, basename($fileNameOriginal));
                    } else {
                        $this->getController()->Flash->error('No se encuentra el archivo a descargar.');
                        return false;
                    }
                } else {
                    $this->getController()->Flash->error('No se pudo descargar el archivo.');
                    return $this->getController()->redirect($this->getController()->referer());
                }
            }
            $zip->close();
        } else {
            echo "No se pudo crear el archivo ZIP.";
            exit;
        }

        // Comprobar si el archivo existe
        if (file_exists($zipFileName)) {
            // Establecer los encabezados para la descarga del archivo
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="' . basename($zipFileName) . '"');
            header('Content-Length: ' . filesize($zipFileName));

            // Enviar el contenido del archivo ZIP al navegador
            readfile($zipFileName);

            // Eliminar el archivo ZIP del servidor después de la descarga (opcional)
            unlink($zipFileName);
        } else {
            echo "El archivo ZIP no existe.";
        }
    }

    public function descargarEncrypt($id, $settings = [])
    {
        if (!$id) {
            $this->getController()->Flash->error('No se encuentra el archivo asociado a descargar.');
            return $this->getController()->redirect($this->getController()->referer());
        }

        $upload = $this->Upload->findById($id)->first();


        if (empty($upload)) {
            $this->getController()->Flash->error('No se encuentra el archivo a descargar.');
            return $this->getController()->redirect($this->getController()->referer());
        }

        $hash_llave = $upload->hash_llave;
        $this->getController()->viewBuilder()->setLayout(null);

        if (!empty($hash_llave) && strlen(trim($hash_llave)) == 64) {
            $hash_archivo = $upload->hash_archivo;
            $nombre_original = $upload->nombre_original;
            $extension_archivo = $upload->extension_archivo;
            $nombre_archivo = $hash_archivo;

            $filename = ROOT . DS . "uploads" . DS . $settings['folder'] . DS . $nombre_archivo;

            if (file_exists($filename)) {
                // Leer el contenido del archivo cifrado
                $cipherText = file_get_contents($filename);


                // Comprobar y eliminar el mensaje de aviso
                $warningMessage = "Este archivo está encriptado. No puede ser abierto directamente.\n";
                if (strpos($cipherText, $warningMessage) === 0) {
                    $cipherText = substr($cipherText, strlen($warningMessage));
                } else {
                    $this->getController()->Flash->error('El archivo no parece estar encriptado correctamente.');
                    return $this->getController()->redirect($this->getController()->referer());
                }

                // Obtener el IV y el texto cifrado
                $ivLength = openssl_cipher_iv_length('aes-256-cbc');
                $iv = substr($cipherText, 0, $ivLength);
                $cipherText = substr($cipherText, $ivLength);

                // Derivar la clave de 32 bytes
                $key = substr(hash('sha256', $hash_llave, true), 0, 32);

                // Descifrar el archivo
                $fileContent = openssl_decrypt($cipherText, 'aes-256-cbc', $key, 0, $iv);

                if ($fileContent === false) {
                    $this->getController()->Flash->error('No se pudo descifrar el archivo.');
                    return $this->getController()->redirect($this->getController()->referer());
                }

                $fileNameOriginal = $nombre_original . '.' . $extension_archivo;
                $mime = $this->detectFileMimeType($filename);

                // Guardar un log de la descarga
                $session = $this->getController()->getRequest()->getSession();
                $usuario = $session->read('RbacUsuario');
                // $logData = [
                //     'file_id' => $id,
                //     'user_id' => $usuario['id'],
                //     'downloaded_at' => date('Y-m-d H:i:s')
                // ];
                // $logEntity = $this->DownloadLogs->newEntity($logData);
                // $this->DownloadLogs->save($logEntity);

                // Enviar el archivo al cliente
                header('Content-Disposition: attachment; filename="' . $fileNameOriginal . '"');
                header('Content-Type: ' . $mime);
                header('Content-Length: ' . strlen($fileContent));
                ob_clean();
                flush();
                echo $fileContent;
                exit();
            } else {
                $this->getController()->Flash->error('No se encuentra el archivo a descargar.');
                return $this->getController()->redirect($this->getController()->referer());
            }
        } else {
            $this->getController()->Flash->error('No se pudo descargar el archivo.');
            return $this->getController()->redirect($this->getController()->referer());
        }
    }
}
