<?php

require_once "autoloader.php";
require_once "Sessioni.php";

/**
 * Classe per la gestione delle prenotazioni da parte del cliente.
 * @package Controller
 */
class CGestionePrenotazione
{
    /**
     * @var CGestionePrenotazione|null Variabile di classe che mantiene l'istanza della classe.
     */
    private static ?CGestionePrenotazione $instance = null;

    /**
     * Costruttore della classe.
     */
    private function __construct(){}

    /**
     * Restituisce l'istanza della classe.
     * @return CGestionePrenotazione|null
     */
    public static function getInstance(): ?CGestionePrenotazione{
        if(!isset(self::$instance)) {
            self::$instance = new CGestionePrenotazione();
        }
        return self::$instance;
    }

    //NON utilizzato
    public function dettagliParcheggio(int $intIdParcheggio){
        $dbParcheggio = FParcheggio::getInstance();
        $arrParamSearch = array(array("id_parcheggio","=","$intIdParcheggio"));
        $result = $dbParcheggio->search($arrParamSearch);
        return $result;
    }

    //NON utilizzato
    public function mostraPostiAuto(int $intIdParcheggio){
        $dbPostoAuto = FPostoAuto::getInstance();
        if(!$sessione->isLogged()){
            $controller = CAccesso::getInstance();
            $controller->mostraLogin();
        }
        else {
            $result = $dbPostoAuto->selectPostiByParcheggio($intIdParcheggio);
            return $result;
        }
    }

    /**
     * Gestisce la visualizzazione delle prenotazioni future alla data odierna.
     * Verifica che il cliente sia loggato e reindirizza alla pagina delle prenotazioni future del cliente.
     * @return void
     */
    public function mostraPrenotazioniFuture(){
        $dbPrenotazioni = FPrenotazione::getInstance();
        $sessione = new Sessioni();
        if(!$sessione->isLogged()){
            $controller = CAccesso::getInstance();
            $controller->mostraLogin();
        }
        else {
            $intIdUser = $sessione->leggi_valore('id_utente');

            $result = $dbPrenotazioni->selectPrenotazioniFutureByCliente($intIdUser);

            $view = new VGestionePrenotazione();
            $view->prenotazioniFuture($result);
        }

    }

    /**
     * Gestisce l'eliminazione di una prenotazione futura. Preleva l'ID della prenotazione da eliminare dalla view e ne effettua l'eliminazione,
     * reindirizzando alla pagina di conferma di operazione avvenuta.
     * @return void
     */
    public function eliminaPrenotazione(){

        $view = new VGestionePrenotazione();
        $intIdPrenotazione = $view->getIdPrenotazione();

        $dbPrenotazione = FPrenotazione::getInstance();
        $objPrenotazione = $dbPrenotazione->load($intIdPrenotazione);
        $dbPrenotazione->delete($objPrenotazione);

        self::conferma();
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