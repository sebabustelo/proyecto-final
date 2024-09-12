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
        debug($_FILES);
        debug($files);die;
        foreach ($files as $file) {
            if ($file['error'] != 0) {
                return ['status' => false, 'error' => 'Error uploading one or more files'];
            }

            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            if (!in_array($extension, $this->allowedExtensions)) {
                return ['status' => false, 'error' => 'Invalid file type'];
            }

            $newFileName = time() . '_' . $file['name'];
            $filePath = $destination . $newFileName;

            if (move_uploaded_file($file['tmp_name'], $filePath)) {
                $uploadedFiles[] = [
                    'file_name' => $newFileName,
                    'file_extension' => $extension,
                    'file_size' => $file['size'],
                    'file_path' => $filePath
                ];
            } else {
                return ['status' => false, 'error' => 'Unable to save one or more files'];
            }
        }

        return ['status' => true, 'files' => $uploadedFiles];
    }
}
