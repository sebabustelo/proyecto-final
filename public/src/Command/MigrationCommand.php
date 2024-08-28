<?php

declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use DirectoryIterator;
use Cake\Utility\Security;

/**
 * Migration command.
 */
class MigrationCommand extends Command
{
    /**
     * Hook method for defining this command's option parser.
     *
     * @see https://book.cakephp.org/4/en/console-commands/commands.html#defining-arguments-and-options
     * @param \Cake\Console\ConsoleOptionParser $parser The parser to be defined
     * @return \Cake\Console\ConsoleOptionParser The built parser.
     */
    public function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser = parent::buildOptionParser($parser);

        return $parser;
    }

    /**
     * Implement this method with your command's logic.
     *
     * @param \Cake\Console\Arguments $args The command arguments.
     * @param \Cake\Console\ConsoleIo $io The console io
     * @return int|null|void The exit code or null for success
     */
    public function execute(Arguments $args, ConsoleIo $io)
    {
        // Llama al modelo 'Users'
        $resolucionTable = \Cake\ORM\TableRegistry::getTableLocator()->get('Resoluciones');

        // Realiza una consulta `find` para obtener todos los usuarios
        // $resoluciones = $resolucionTable->find('all')->where(['upload_id is null'])->limit(15000)->all();

        // Subconsulta para encontrar todas las resoluciones que tienen un upload_id
        $subquery = $resolucionTable->find()
            ->innerJoinWith('Uploads')
            ->select(['Resoluciones.id']);

            //debug($subquery);die;

        // Consulta principal para encontrar resoluciones que no están en la subconsulta
        $query = $resolucionTable->find()
            ->where(function ($exp, $q) use ($subquery) {
                return $exp->notIn('Resoluciones.id', $subquery);
            })->limit(10000)->contain(['Uploads']);

        $resoluciones = $query->all();

        // Depurar el resultado
        
        //debug($resoluciones);
       // die;

        foreach ($resoluciones as $resolucion) {
            $id = $resolucion->id;
            $anio = $resolucion->anio;
            $name = $id;
            $source = ROOT . '/resoluciones/' . $anio . '/';

            $destination = ROOT . '/uploads/' . $anio . '/';

            $upload_id = $this->copyFile($source, $destination, $name);

            if ($upload_id) {
                $resolucion->uploads = array($upload_id);
                //debug($resolucion);die;
                $resolucionTable->save($resolucion);
            }
        }
        $io->out('Migracion de archivos completa.');
        return static::CODE_SUCCESS;
    }

    /**
     * Obtiene una lista de carpetas en un directorio utilizando DirectoryIterator.
     *
     * @param string $directoryPath La ruta completa del directorio.
     * @return array|false Una lista de carpetas en el directorio o false en caso de fallo.
     */
    public function getDirectoriesInDirectory($directoryPath)
    {
        // Verifica que el directorio exista
        if (!is_dir($directoryPath)) {
            return false;
        }

        $directories = [];
        $iterator = new DirectoryIterator($directoryPath);

        foreach ($iterator as $item) {
            if ($item->isDir() && !$item->isDot()) {
                $directories[] = $item->getFilename();
            }
        }

        return $directories;
    }

    /**
     * Copia un archivo de una ruta de origen a una ruta de destino.
     *
     * @param string $sourcePath La ruta completa del archivo de origen.
     * @param string $destinationPath La ruta completa del archivo de destino.
     * @param string $name Nombre del archivo a copiar.
     * @return bool True en caso de éxito, False en caso de fallo.
     */
    public function copyFile($sourcePath, $destinationPath, $name)
    {
        // Verifica que el archivo de origen exista
        if (file_exists($sourcePath . $name . '.tif')) {
            $nameFile = $name . '.tif';
        } elseif (file_exists($sourcePath . $name . '.pdf')) {
            $nameFile = $name . '.pdf';
        } else {
            return false;
        }

        // Verifica que el directorio de destino exista, y si no, intenta crearlo
        if (!is_dir($destinationPath)) {
            if (!mkdir($destinationPath, 0755, true)) {
                return false; // Falló la creación del directorio
            }
        }

        $tmp = explode('.', $nameFile);
        $extensionArchivo = strtolower(end($tmp));
        $hash_archivo = Security::hash($nameFile  . date("YmdHis"), 'sha1', true);
        $created = date('now');
        $hash_llave = hash('sha256', $hash_archivo . $created);
        $nombre_archivo = substr($hash_archivo, 4, strlen($hash_archivo) - 4);


        $nombreArchivoSinExtension = $tmp[0];
        # $size = $_FILES['attachments']['size'];

        $upload = [
            'nombre_archivo' => $nombre_archivo,
            'nombre_original' => $nombreArchivoSinExtension,
            'hash_archivo' => $hash_archivo,
            'extension_archivo' => $extensionArchivo,
            'hash_llave' => $hash_llave,
            'created_by' => '2907',
            'modified_by' => '2907'
        ];

        $uploadTable = \Cake\ORM\TableRegistry::getTableLocator()->get('Uploads');
        $entityUpload = $uploadTable->newEntity($upload);
        $uploadTable->save($entityUpload);

        if (copy($sourcePath . $nameFile, $destinationPath . $nombre_archivo . '.' . $extensionArchivo)) {
            return $entityUpload;
        }

        return false;
    }
}
