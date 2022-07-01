<?php

require_once "autoloader.php";
require_once "StartSmarty.php";

/**
 * Classe per la visualizzazione e recupero informazioni dalle pagine relative alla moderazione delle recensioni da parte dell'amministratore.
 * @package View
 */
class VModerazioneRecensioni
{
    /**
     * Oggetto _Smarty_ per la compilazione e visualizzazione dei template.
     * @var Smarty
     */
    private $smarty;

    /**
     * Costruttore di classe. Crea l'oggetto ed esegue la configurazione dell'attributo _$smarty_.
     */
    public function __construct()
    {
        $this->smarty = StartSmarty::configuration();
    }

    /**
     * Mostra la pagina relative alle recensioni. Assegna il parametro al template e mostra la pagina.
     * @param array|string $recensioni
     * @return void
     * @throws SmartyException
     */
    public function mostraRecensioni(array|string $recensioni){

        $this->smarty->assign('recensioni', $recensioni);
        $this->smarty->display('moderazionerecensioni.tpl');

    }

    /**
     * Restituisce una copia dell'array _$___POST_ se quest'ultimo ha i valori delle chiavi 'datainizio' e 'datafine', false altrimenti.
     * @return bool|array
     */
    public function getDate():bool|array{

        $date = false;
        if(isset($_POST['datainizio']) && isset($_POST['datafine'])){
            $date = $_POST;
        }

        return $date;

    }
    /**
     * Restituisce il valore associato alla chiave 'id_recensione' dell'array _$___POST_.
     * @return string
     */
    public function getIdRecensione(){

        $id_recensione = $_POST['id_recensione'];
        return $id_recensione;

    }

    /**
     * Mostra la pagina di conferma di operazione avvenuta.
     * @return void
     * @throws SmartyException
     */
    public function conferma(){
        $this->smarty->display("confermaoperazione.tpl");
    }


}