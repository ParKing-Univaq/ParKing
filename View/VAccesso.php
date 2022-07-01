<?php

require_once "autoloader.php";
require_once "StartSmarty.php";

/**
 * Classe per la visualizzazione e recupero informazioni dalle pagine relative all'accesso e registrazione degli utenti.
 * @package View
 */
class VAccesso
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
     * Assegna i valori ai parametri all'interno del template e mostra la pagina di login.
     * @return void
     * @throws SmartyException
     */
    public function mostraLogin(){
        $this->smarty->assign('errore','');
        $this->smarty->display('login.tpl');
    }

    /**
     * Assegna i valori ai parametri all'interno del template e mostra la pagina di login.
     * @return void
     * @throws SmartyException
     */
    public function erroreLogin(){
        $this->smarty->assign('errore','Errore! Riprova il login');
        $this->smarty->display('login.tpl');
    }

    /**
     * Restituisce un array contenente i parametri prelevati dal form di login.
     * @return array
     */
    public function getLogin(){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $parametri = array($email, $password);
        return $parametri;
    }

    /**
     * Restituisce un array contenente i parametri prelevati dal form di registrazione.
     * @return array[]
     */
    public function getRegistrazione(){
        $nome = $_POST['nome'];
        $cognome = $_POST['cognome'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $estensione = $_FILES['img']['type'];
        $nomeimg = $_FILES['img']['name'];
        $file = $_FILES['img']['tmp_name'];
        $dimensione = $_FILES['img']['size'];

        $arrImg = array($nomeimg,$estensione, $file, $dimensione);
        $arrParametri = array($nome, $cognome, $username, $email, $password);
        $parametri = array($arrParametri, $arrImg);
        return $parametri;
    }

    /**
     * Mostra la pagina di registrazione del gestore.
     * @return void
     * @throws SmartyException
     */
    public function mostraRegistrazioneGestore(): void {
        $this->smarty->display('registrazionegestore.tpl');
    }

    /**
     * Mostra la pagina di conferma di operazione avvenuta.
     * @return void
     * @throws SmartyException
     */
    public function conferma(): void {
        $this->smarty->display('confermaoperazione.tpl');
    }

}