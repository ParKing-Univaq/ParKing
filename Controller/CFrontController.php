<?php

require_once 'autoloader.php';
require_once 'StartSmarty.php';
/**
 * Classe per controllare l'esecuzione delle richieste effettuate al server.
 * @package Controller
 */
class CFrontController
{
    /**
     * Avvia la funzione del _Controller_ appropriato a evadere la richiesta contenuta nel path.
     * @param $path
     * @return void
     */
    public function run ($path)
    {

        if($path !='/') {
            $resource = explode('/', $path);

            array_shift($resource);

            $controller = "C" . $resource[0];
            $dir = 'Controller';
            $eledir = scandir($dir);

            if (in_array($controller . ".php", $eledir)) {
                if (isset($resource[1])) {
                    $objController = $controller::getInstance();
                    $function = $resource[1];
                    if (method_exists($objController, $function)) {
                         $objController->$function();
                    }
                }
            }
        }else {
            $controller = CRicerca::getInstance();
            $controller->mostraPaginaDiRicerca();
        }

    }
}