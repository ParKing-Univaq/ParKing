<?php

require_once "autoloader.php";
require_once "Sessioni.php";

/**
 * Classe per la moderazione delle recensioni da parte dell'amministratore.
 * @package Controller
 */
class CModerazioneRecensioni
{
    /**
     * @var CModerazioneRecensioni|null Variabile di classe che mantiene l'istanza della classe.
     */
    private static ?CModerazioneRecensioni $instance = null;

    /**
     * Costruttore della classe.
     */
    private function __construct(){}

    /**
     * Restituisce l'istanza della classe.
     * @return CModerazioneRecensioni|null
     */
    public static function getInstance(): ?CModerazioneRecensioni{
        if(!isset(self::$instance)) {
            self::$instance = new CModerazioneRecensioni();
        }
        return self::$instance;
    }

    /**
     * Gestisce la visualizzazione di recensioni scritte in un dato intervallo di tempo. Verifica che l'amministratore sia loggato,
     * preleva i parametri di ricerca dalla view e reindirizza alla pagina dei risultati.
     * @return void
     */
    public function mostraRecensionibyDate(){
        $view = new VModerazioneRecensioni();
        $sessioni = new Sessioni();
        if(!$sessioni->isLogged()){
            $controller = CAccesso::getInstance();
            $controller->mostraLogin();
        }
        else {
            $date = $view->getDate();
            if ($date == false) {

                $recensioni = 'Inserisci i dati per la ricerca';
                $view->mostraRecensioni($recensioni);

            } else {

                $data1 = $date['datainizio'];
                $data2 = $date['datafine'];
                $sessioni->imposta_valore('datainizio', $data1);
                $sessioni->imposta_valore('datafine', $data2);

                $dbRecensione = FRecensione::getInstance();

                $recensioni = $dbRecensione->searchByData($data1, $data2);

                if ($recensioni != false) {
                    $view->mostraRecensioni($recensioni);
                } else {
                    $recensioni = 'Nessun risultato';
                    $view->mostraRecensioni($recensioni);
                }
            }
        }
    }

    //NON utilizzato
    public function dettagliRecensione(int $intIdRecensione){
        $dbRecensione = FRecensione::getInstance();
        return $dbRecensione->load($intIdRecensione);
    }

    /**
     * Gestisce l'eliminazione di una recensione da parte dell'amministratore. Preleva l'ID della recensione da eliminare e procede all'eliminazione,
     * reindirizzando alla pagina di conferma di operazione avvenuta.
     * @return void
     * @throws SmartyException
     */
    public function eliminaRecensione(): void {
        $view = new VModerazioneRecensioni();
        $intIdRecensione = $view->getIdRecensione();

        $dbRecensione= FRecensione::getInstance();
        $objRecensione = $dbRecensione->load($intIdRecensione);
        $dbRecensione->delete($objRecensione);

        self::conferma();
    }

    /**
     * Gestisce la visualizzazione della pagina di conferma operazione.
     * @return void
     * @throws SmartyException
     */
    public function conferma(){
        $view = new VModerazioneRecensioni();
        $view->conferma();
    }
}