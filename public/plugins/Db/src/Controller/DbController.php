<?php

namespace Db\Controller;

use Db\Controller\AppController;

use Cake\Core\Configure;
use Cake\Core\Exception;
use Cake\Event\EventInterface;
use Cake\Http\Exception\InternalErrorException;
use Cake\Routing\Router;
use Cake\Datasource\ConnectionManager;
use Cake\Http\CallbackStream;
use Cake\ORM\TableRegistry;

class DbController extends AppController
{

    public $logsDir = ROOT . DS . "logs"; // Directorio donde se guardaran el/los archivo/s de historial
    public $limiteArchivar = 3; // Cantidad mínima de registros requerida para poder archivar historial
    public $limiteSelect = 25000; // Límite máximo de registros a consultar en un SELECT



    public function index($exec = null)
    {
        $fileHistorial = 'ABMC.log'; // El nombre del historial vigente
        $verArchivado = false;


        // Si esta queriendo consultar un historial archivado, usará el nombre del archivo
        if (!is_null($exec) && substr($exec, 0, 11) == 'historial__') {
            $verArchivado = true;
            $tmp = explode('__', $exec);
            $fileHistorial = $tmp[1];
        }

        $clientIP = $this->getClientIP();

        if (isset($_SESSION['RbacUsuario']['usuario'])) {
            $usuario = $_SESSION['RbacUsuario']['usuario'];
        }

        // Si esta viniendo del formulario de queries, intentará ejecutarla
        if (isset($_POST["operacion"])) {
            $this->ejecutarQuery();
        }

        $filename = $this->logsDir . DS . $fileHistorial;
        $logs = array();
        $counter = 0;
        if (file_exists($filename)) {
            $file = fopen($filename, "r");
            while (!feof($file)) {
                $line = fgets($file);
                if (trim($line) != '') {
                    $auditoriaTmp = @unserialize($line);
                    if (!$auditoriaTmp) {
                        $this->Flash->error('Archivo no accesible o compatible');
                        return $this->redirect('/db/index');
                    }
                    $auditoriaTmp['id'] = $counter;
                    $auditoriaTmp['undoQuery'] = base64_decode($auditoriaTmp['undoQuery']);
                    if (!is_null($exec) && intval($exec) == $counter && $exec != 'archivar' && !$verArchivado) {
                        try {
                            $connection = ConnectionManager::get($auditoriaTmp['conector']);
                            $result = $connection->execute($auditoriaTmp['undoQuery'])->fetchAll('assoc');
                            $this->insertLog($clientIP, stripslashes($auditoriaTmp['undoQuery']), stripslashes($auditoriaTmp['query']), $usuario, $auditoriaTmp['conector']);
                            $this->Flash->success('Consulta ejecutada');
                            return $this->redirect('/db/index');
                        } catch (\Throwable $th) {
                            $this->Flash->error('Consulta NO ejecutada:' . $auditoriaTmp['undoQuery'] . '-' . $th);
                            return $this->redirect('/db/index');
                        }
                    }
                    $logs[] = $auditoriaTmp;
                    $counter++;
                }
            }
            fclose($file);
        }
        if ($exec == 'archivar' && $counter < $this->limiteArchivar) {
            $this->Flash->error('Debe haber al menos ' . $this->limiteArchivar . ' registros para poder archivar el historial');
            return $this->redirect('/db/index');
        }
        if ($exec == 'archivar' && $counter >= $this->limiteArchivar) {
            $newF = str_replace('.log', 'A' . date("Y-m-d_His") . '.log', $filename);
            if (rename($filename, $newF)) {
                $this->Flash->success('Historial archivado');
                return $this->redirect('/db/index');
            } else {
                $this->Flash->error('No pudo archivarse el historial');
                return $this->redirect('/db/index');
            }
        }

        // Trae todos los posibles archivados que existan para permitir su consulta
        $filesHistorial = glob($this->logsDir . DS . 'ABMCA*.log');

        $logs = array_reverse($logs); // Cambia el orden para que aparezcan los más nuevos arriba
        $this->set('listado', $logs);
        $this->set('verArchivado', $verArchivado);
        $this->set('filesHistorial', $filesHistorial);
        $this->set('fileHistorial', $fileHistorial);
        $this->set('conectores', ConnectionManager::configured());
    }

    private function array2csv($data, $delimiter = ',', $enclosure = '"', $escape_char = "\\")
    {
        $f = fopen('php://memory', 'r+');
        foreach ($data as $item) {
            fputcsv($f, $item, $delimiter, $enclosure, $escape_char);
        }
        rewind($f);
        return stream_get_contents($f);
    }

    public function getClientIP()
    {
        if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
            return  $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else if (array_key_exists('REMOTE_ADDR', $_SERVER)) {
            return $_SERVER["REMOTE_ADDR"];
        } else if (array_key_exists('HTTP_CLIENT_IP', $_SERVER)) {
            return $_SERVER["HTTP_CLIENT_IP"];
        }
        return '';
    }


    private function insertLog($clientIP, $query, $undoQuery, $usuario, $conector = null)
    {
        if (is_null($clientIP)) {
            $clientIP = $this->getClientIP();
        }
        $filename = $this->logsDir . DS . 'ABMC.log';
        $fp = fopen($filename, 'a');
        if (isset($_POST["conector"])) {
            $conector = $_POST["conector"];
        }
        $logData = array('usuario' => $usuario, 'remote_address' => $clientIP, 'fecha' => date("Y-m-d H:i:s"), 'query' => addslashes($query), 'undoQuery' => base64_encode($undoQuery), 'conector' => $conector);
        fwrite($fp, serialize($logData) . PHP_EOL);
        fclose($fp);
    }

    private function ejecutarQuery()
    {
        $clientIP = $this->getClientIP();
        $usuario = $_SESSION['RbacUsuario']['usuario'];
        $connection = ConnectionManager::get($_POST["conector"]);
        $tabla = $_POST['tabla'];
        $patron = "/[a-zA-Z0-9\_]+/";
        switch ($_POST["operacion"]) {
            case "select":
                $resultado = $this->ejecutarSelect($tabla, $patron, $connection);
                break;
            case "update":
                $resultado = $this->ejecutarUpdate($tabla, $patron, $connection, $clientIP, $usuario);
                break;
            case "insert":
                $resultado = $this->ejecutarInsert($tabla, $patron, $connection, $clientIP, $usuario);
                break;
            case "delete":
                $resultado = $this->ejecutarDelete($tabla, $patron, $connection, $clientIP, $usuario);
                break;
        }
        if ($resultado[0] == 'error') {
            $this->Flash->error($resultado[1]);
        } else {
            $this->Flash->success($resultado[1]);
        }
        return $this->redirect('/db/index');
    }

    private function ejecutarSelect($tabla, $patron, $connection)
    {
        $desdeId = intval($_POST["desdeID"]);
        $limit = intval($_POST["limite"]);
        $query = "SELECT * from $tabla WHERE id>=$desdeId LIMIT $limit";

        if (!preg_match($patron, $tabla) || $desdeId < 1 || $limit < 1 || $limit > $this->limiteSelect) {
            return array('error', 'Consulta inválida. Verifique valores ingresados y que no se supere el límite de ' . $this->limiteSelect . ' registros');
        }
        try {
            $results = $connection->execute($query)->fetchAll('assoc');
        } catch (\Throwable $th) {
            return array('error', 'Consulta NO ejecutada -' . $th);
        }
        switch ($_POST['formato']) {
            case "pretty":
                $resultado = stripslashes(json_encode($results, JSON_PRETTY_PRINT));
                $extension = '.json';
                break;
            case "csv":
                $resultado = $this->array2csv($results);
                $extension = '.csv';
                break;
            case "sql":
                $resultado = "";
                $extension = '.sql';
                foreach ($results as $registro) {
                    $insertFields = '';
                    $insertValues = '';
                    foreach ($registro as $field => $value) {
                        if ($insertFields != '') {
                            $insertFields .= ', ';
                        }
                        if ($insertValues != '') {
                            $insertValues .= ', ';
                        }
                        $insertFields .= $field;
                        if (is_null($value)) {
                            $value = '';
                        }
                        $insertValues .= '\'' . str_replace("'", "\'", str_replace("\r\n", "\\r\\n", $value)) . '\'';
                    }
                    if ($resultado != "") {
                        $resultado .= ",\n";
                    }
                    $resultado .= 'INSERT INTO ' . $tabla . ' (' . $insertFields . ') VALUES (' . $insertValues . ')';
                }
                break;
            default:
                $resultado = stripslashes(json_encode($results));
                $extension = '.json';
                break;
        }
        header('Content-Description: File');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=SELECT-' . $tabla . '-desde ID_' . $desdeId . '-Limite_' . $limit . $extension);
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . strlen($resultado));
        ob_clean();
        flush();
        echo $resultado;
        exit;
    }
    private function ejecutarUpdate($tabla, $patron, $connection, $clientIP, $usuario)
    {
        $id2Update = intval($_POST['Id2Update']);
        $camposUpdate = explode(',,', str_replace(' ', '', $_POST['camposUpdate']));
        $valores = explode(',,', $_POST['valoresUpdate']);
        if (count($camposUpdate) != count($valores) || !preg_match($patron, $tabla) || $id2Update < 1) {
            return array('error', 'Consulta NO ejecutada, asegurese de ingresar correctamente nombres y valores de los campos');
        }
        $stringUpdate = '';
        foreach ($camposUpdate as $x => $campoNombre) {
            if (!preg_match($patron, $campoNombre)) {
                echo 'Nombre de campo inválido: ' . $campoNombre;
                die;
            }
            if ($stringUpdate != '') {
                $stringUpdate .= ', ';
            }
            $stringUpdate .= $campoNombre . '=' . '\'' . addslashes($valores[$x]) . '\'';
            $Fields[] = $campoNombre;
            $Values[] = '\'' . addslashes($valores[$x]) . '\'';
        }
        $stringFields = implode(',', $Fields);
        // Trae el registro para generar el UNDO query
        $query = 'SELECT ' . $stringFields . ' FROM ' . $tabla . ' WHERE ID=' . $id2Update . ' LIMIT 1';
        try {
            $result = $connection->execute($query)->fetchAll('assoc');
        } catch (\Throwable $th) {
            return array('error', 'Consulta NO ejecutada, verifique haber escrito correctamente la consulta. - ' . $th);
        }
        $stringUndo = '';
        if (empty($result)) {
            return array('error', 'Consulta NO ejecutada, el ID de registro a actualizar no fue encontrado');
        }
        foreach ($result[0] as $campoName => $campoVal) {
            if ($stringUndo != '') {
                $stringUndo .= ',';
            }
            $stringUndo .= $campoName . '=' . '\'' . $campoVal . '\'';
            $undoFields[] = $campoName;
            $undoVals[] = $campoVal;
        }
        $imploFields = implode(',,', $undoFields);
        $imploValues = implode(',,', $undoVals);
        $undoQuery = 'UPDATE ' . $tabla . ' SET ' . $stringUndo . ' WHERE ID=' . $id2Update . ' LIMIT 1;';
        $query = 'UPDATE ' . $tabla . ' SET ' . $stringUpdate . ' WHERE ID=' . $id2Update . ' LIMIT 1';
        try {
            $results = $connection->execute($query)->fetchAll('assoc');
            //$detalle=$usuario.' ejecutó: '.$query;
            $this->insertLog($clientIP, stripslashes($query), stripslashes($undoQuery), $usuario);
            return array('success', 'Consulta ejecutada: ' . $query);
        } catch (\Throwable $th) {
            return array('error', 'Consulta NO ejecutada, verifique la consulta y vuelva a intentarlo.' . $th);
        }
    }


    private function ejecutarInsert($tabla, $patron, $connection, $clientIP, $usuario)
    {
        $camposInsert = explode(',,', str_replace(' ', '', $_POST['camposInsert']));
        $valores = explode(',,', $_POST['valoresInsert']);
        if (count($camposInsert) != count($valores) || !preg_match($patron, $tabla)) {
            return array('error', 'Consulta NO ejecutada, asegurese de ingresar correctamente nombres y valores de los campos');
        }
        foreach ($camposInsert as $x => $campoNombre) {
            if (!preg_match($patron, $campoNombre)) {
                echo 'Nombre de campo inválido: ' . $camposInsert;
                die;
            }
            $Fields[] = $campoNombre;
            $Values[] = '\'' . addslashes($valores[$x]) . '\'';
            if ($campoNombre == 'id') {
                $lastid = $valores[$x];
            }
        }
        $query = 'INSERT INTO ' . $tabla . ' (' . implode(', ', $Fields) . ') VALUES (' . implode(', ', $Values) . ')';
        try {
            $results = $connection->execute($query)->fetchAll('assoc');
            $results2 = $connection->execute('SELECT LAST_INSERT_ID();')->fetchAll('assoc');
            $lastInsertId = $results2[0]['LAST_INSERT_ID()'];
            if ($lastInsertId == 0 && isset($lastid)) {
                $lastInsertId = $lastid;
            }
            $undoQuery = 'DELETE FROM ' . $tabla . ' WHERE ID=' . $lastInsertId . ' LIMIT 1';
            //$detalle=$usuario.' ejecutó: '.$query;
            $this->insertLog($clientIP, stripslashes($query), stripslashes($undoQuery), $usuario);
            return array('success', 'Consulta ejecutada: ' . stripslashes($query));
        } catch (\Throwable $th) {
            return array('error', 'Consulta NO ejecutada, verifique la consulta y que, de existir registro ID, el mismo ya no exista en la tabla. - ' . $th);
        }
    }

    private function ejecutarDelete($tabla, $patron, $connection, $clientIP, $usuario)
    {
        $id2Delete = intval($_POST['id2Delete']);

        if ($id2Delete < 1 || !preg_match($patron, $tabla)) {
            return array('error', 'Consulta NO ejecutada, asegurese de ingresar correctamente nombre de la tabla y ID a eliminar');
        }
        // Trae el registro que seria eliminado
        $query = 'SELECT * FROM ' . $tabla . ' WHERE ID=' . $id2Delete . ' LIMIT 1';
        try {
            $result = $connection->execute($query)->fetchAll('assoc');
        } catch (\Throwable $th) {
            return array('error', 'Compruebe la consulta y vuelva a intentar -' . $th);
        }
        if (empty($result)) {
            return array('error', 'Consulta NO ejecutada, no se encontró ningún registro con ese ID');
        }
        foreach ($result[0] as $campoNombre => $campoValor) {
            $undoFieldNames[] = $campoNombre;
            $undoFieldValues[] = '\'' . $campoValor . '\'';
        }
        $undoQuery = 'INSERT INTO ' . $tabla . ' (' . implode(', ', $undoFieldNames) . ') VALUES (' . implode(', ', $undoFieldValues) . ')';
        $query = 'DELETE FROM ' . $tabla . ' WHERE ID=' . $id2Delete;
        $result = $connection->execute($query)->fetchAll('assoc');
        //$detalle=$usuario.' ejecutó: '.$query;
        $this->insertLog($clientIP, stripslashes($query), stripslashes($undoQuery), $usuario);
        return array('success', 'Registro eliminado');
    }
}
