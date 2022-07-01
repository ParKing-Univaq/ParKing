<?php

require_once "autoloader.php";
require_once "StartSmarty.php";

/**
 * Classe per la visualizzazione e recupero informazioni dalle pagine relative alla gestione delle recensioni da parte del cliente.
 * @package View
 */
class VGestioneRecensione
{
    /**
     * Oggetto _Smarty_ per la compilazione e visualizzazione dei template.
     * @var Smarty
     */
    private Smarty $smarty;

    /**
     * Costruttore di classe. Crea l'oggetto ed esegue la configurazione dell'attributo _$smarty_.
     */
    public function __construct()
    {
        $this->smarty = StartSmarty::configuration();
    }

    /**
     * Mostra la pagina relative alle prenotazioni concluse di un cliente. Assegna il parametro al template e mostra la pagina.
     * @param array $prenotazioni
     * @return void
     * @throws SmartyException
     */
    public function prenotazioniConcluse(array $prenotazioni){
        $this->smarty->assign('prenotazioni', $prenotazioni);
        $this->smarty->display("prenotazioniconcluse.tpl");

    }

    /**
     * Restituisce in un array i valori associati alle chiavi 'valutazione','descrizione' e 'idprenotazione' dell'array _$___POST_.
     * @return array
     */
    public function getFormRecensione(){
        $valutazione = $_POST['valutazione'];
        $descrizione = $_POST['descrizione'];
        $idprenotazione = $_POST['idprenotazione'];

        $parametri = array($valutazione, $descrizione, $idprenotazione);
        return $parametri;
    }

    /**
     * Mostra la pagina di conferma di operazione avvenuta.
     * @return void
     * @throws SmartyException
     */
    public function conferma(){
        $this->smarty->display("confermaoperazione.tpl");
    }

    /**
     * Mostra la pagina relative alle recensioni effettuate da un cliente. Assegna il parametro al template e mostra la pagina.
     * @param array $recensioni
     * @return void
     * @throws SmartyException
     */
    public function mostraRecensioni(array $recensioni){
        $this->smarty->assign('recensioni', $recensioni);
        $this->smarty->display("recensionicliente.tpl");
    }

    /**
     * Restituisce il valore associato alla chiave 'idrecensione' dell'array _$___POST_.
     * @return string
     */
    public function getIdRecensione(){
        $id = $_POST['idrecensione'];
        return $id;
    }

}