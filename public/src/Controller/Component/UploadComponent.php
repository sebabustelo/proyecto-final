<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Filesystem\File;

class UploadComponent extends Component
{
    public $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];

    public function upload($file, $destination)
    {
        $uploadedFiles = [];

        if ($file->getError() != 0) {
            return ['status' => false, 'error' => 'Error uploading one or more files'];
        }

        $extension = strtolower(pathinfo($file->getClientFilename(), PATHINFO_EXTENSION));
        if (!in_array($extension, $this->allowedExtensions)) {
            return ['status' => false, 'error' => 'Invalid file type'];
        }

        $newFileName = time() . '_' . $file->getClientFilename();
        $filePath = $destination . $newFileName;

        try {
            $file->moveTo($filePath);
            $uploadedFiles = [
                'file_name' => $newFileName,
                'file_extension' => $extension,
                'file_size' => $file->getSize(),
                'file_path' => $filePath
            ];
        } catch (\Exception $e) {
            return ['status' => false, 'error' => 'No se pudo guardar el archivo'];
        }

        return ['status' => true, 'file' => $uploadedFiles];
    }

    public function uploadMultiple($files, $destination)
    {
        $uploadedFiles = [];
        if (is_null($files)) {
            $files = [];
        }

        foreach ($files as $file) {

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
