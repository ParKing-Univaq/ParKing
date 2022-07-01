<?php

require_once "autoloader.php";
require_once "StartSmarty.php";

/**
 * Classe per la visualizzazione e recupero informazioni dalle pagine relative alla gestione delle prenotazioni da parte del cliente.
 * @package View
 */
class VGestionePrenotazione
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
     * Mostra la pagina relative alle prenotazioni future di un cliente. Assegna il parametro al template e mostra la pagina.
     * @param array $prenotazioni
     * @return void
     * @throws SmartyException
     */
    public function prenotazioniFuture(array $prenotazioni){
        $this->smarty->assign('prenotazioni', $prenotazioni);
        $this->smarty->display("prenotazionifuture.tpl");
    }

    /**
     * Restituisce il valore associato alla chiave 'idprenotazione' dell'array _$__POST_.
     * @return string
     */
    public function getIdPrenotazione(){

        $id = $_POST['idprenotazione'];
        return $id;
    }

}