<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Filesystem\File;

class UploadComponent extends Component
{
    public $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    public function upload($file, $destination)
    {
        if ($file['error'] != 0) {
            return ['status' => false, 'error' => 'Error uploading file'];
        }

        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, $this->allowedExtensions)) {
            return ['status' => false, 'error' => 'Invalid file type'];
        }

        $newFileName = time() . '_' . $file['name'];
        $filePath = $destination . $newFileName;

        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            return ['status' => true, 'file_path' => $filePath];
        }

        return ['status' => false, 'error' => 'Unable to save file'];
    }

    public function uploadMultiple($files, $destination)
    {
        $uploadedFiles = [];

        foreach ($files as $file) {
           
            //debug($file->getError());die;
            if ($file->getError() != 0) {
                return ['status' => false, 'error' => 'Error uploading one or more files'];
            }

            $extension = strtolower(pathinfo($file->getClientFilename(), PATHINFO_EXTENSION));
            if (!in_array($extension, $this->allowedExtensions)) {
                return ['status' => false, 'error' => 'Invalid file type'];
            }

            $newFileName = time() . '_' . $file->getClientFilename();
            $filePath = $destination . $newFileName;

            // Mueve el archivo al destino deseado
            try {
                $file->moveTo($filePath);
                $uploadedFiles[] = [
                    'file_name' => $newFileName,
                    'file_extension' => $extension,
                    'file_size' => $file->getSize(),
                    'file_path' => $filePath
                ];
            } catch (\Exception $e) {
                return ['status' => false, 'error' => 'Unable to save one or more files'];
            }
        }

        return ['status' => true, 'files' => $uploadedFiles];
    }
}
