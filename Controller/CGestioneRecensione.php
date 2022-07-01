<?php

require_once "autoloader.php";
require_once "Sessioni.php";

/**
 * Classe per la gestione delle recensioni da parte del cliente.
 * @package Controller
 */
class CGestioneRecensione
{
    /**
     * @var CGestioneRecensione|null Variabile di classe che mantiene l'istanza della classe.
     */
    private static ?CGestioneRecensione $instance = null;

    /**
     * Costruttore della classe.
     */
    private function __construct(){}

    /**
     * Restituisce l'istanza della classe.
     * @return CGestioneRecensione|null
     */
    public static function getInstance(): ?CGestioneRecensione {
        if(!isset(self::$instance)) {
            self::$instance = new CGestioneRecensione();
        }
        return self::$instance;
    }


    /**
     * Gestisce la visualizzazione delle prenotazioni concluse alla data odierna.
     * Verifica che il cliente sia loggato e reindirizza alla pagina delle prenotazioni passate del cliente.
     * @return void
     */
    public function prenotazioniConcluse(){
        $sessione = new Sessioni();
        $intIdUser = $sessione->leggi_valore('id_utente');
       // $intIdUser = 404;
        $sessione = new Sessioni();
        if(!$sessione->isLogged()){
            $controller = CAccesso::getInstance();
            $controller->mostraLogin();
        }
        else {
            $dbPrenotazione = FPrenotazione::getInstance();

            $result = $dbPrenotazione->selectPrenotazioniConcluseByCliente($intIdUser);

            $view = new VGestioneRecensione();
            $view->prenotazioniConcluse($result);
        }
    }

    //NON utilizzato
    public function dettagliPrenotazione(int $intIdPrenotazione){
        $dbPrenotazione = FPrenotazione::getInstance();
        $result = $dbPrenotazione->load($intIdPrenotazione);
        return $result;
    }

    /**
     * Gestisce l'inserimento di una nuova recensione. Preleva dalla view le informazioni riguardo la nuova recensione
     * e le utilizza per registrare la nuova recensione.
     * @return void
     */
    public function inserimentoRecensione(){
        $view = new VGestioneRecensione();
        $arrDati = $view->getFormRecensione();
        $intValutazione = intval($arrDati[0]);
        $strDescrizione = $arrDati[1];
        $intIdPrenotazione = $arrDati[2];

        $sessione = new Sessioni();
        $intIdUser = $sessione->leggi_valore('id_utente');


        $objRecensione = new ERecensione();
        $objRecensione->setDataScrittura();

        $objRecensione->setDescrizione($strDescrizione);

        $dbPrenotazione = FPrenotazione::getInstance();
        $objPrenotazione = $dbPrenotazione->load($intIdPrenotazione);
        $objRecensione->setRiferimento($objPrenotazione);

        $dbCliente = FCliente::getInstance();
        $objCliente = $dbCliente->load($intIdUser);
        $objRecensione->setScrittore($objCliente);
        $objRecensione->setValutazione($intValutazione);
        $dbRecensione = FRecensione::getInstance();
        $dbRecensione->store($objRecensione);

        header('Location: /GestioneRecensione/conferma');
    }

    /**
     * Gestisce la visualizzazione di tutte le recensioni effettuate dal cliente.
     * Verifica che il cliente sia loggato e reindirizza alla pagina delle recensioni.
     * @return void
     */
    public function mostraRecensioni(){
        $dbRecensioni = FRecensione::getInstance();
        $sessione = new Sessioni();
        if(!$sessione->isLogged()){
            $controller = CAccesso::getInstance();
            $controller->mostraLogin();
        }
        else {
            $intIdUser = $sessione->leggi_valore('id_utente');

            $result = $dbRecensioni->searchByCliente($intIdUser);
            $view = new VGestioneRecensione();
            $view->mostraRecensioni($result);
        }

    }

    /**
     * Gestisce l'eliminazione di una recensione. Preleva l'ID della recensione da eliminare dalla view e ne effettua l'eliminazione,
     * reindirizzando alla pagina di conferma di operazione avvenuta.
     * @return void
     */
    public function eliminaRecensione(){
        $view = new VGestioneRecensione();
        $intIdRecensione = $view->getIdRecensione();
        $dbRecensione= FRecensione::getInstance();
        $objRecensione = $dbRecensione->load($intIdRecensione);
        $dbRecensione->delete($objRecensione);
        $view->conferma();
    }

    /**
     * Gestisce la visualizzazione della pagina di conferma operazione.
     * @return void
     */
    public function conferma(){
        $view = new VGestioneRecensione();
        $view->conferma();
    }
}