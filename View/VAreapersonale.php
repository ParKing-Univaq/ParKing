<?php

require_once "autoloader.php";
require_once "StartSmarty.php";

/**
 * Classe per la visualizzazione e recupero informazioni dalle pagine relative all'area personale degli utenti.
 * @package View
 */
class VAreapersonale
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
     * Mostra la pagina dell'area personale dell'utente passato come parametro. Preleva le informazioni dall'oggetto, le assegna ai parametri del template
     * e mostra la pagina.
     * @param object $objUser
     * @return void
     * @throws SmartyException
     */
    public function mostraAreaPersonale(object $objUser){

        $nome=$objUser->getNome();
        $cognome=$objUser->getCognome();
        $user=$objUser->getUsername();
        $email=$objUser->getEmail();
        $img = $objUser->getImg();
        $pic64 = $img->getImage();
        $type = $img->getEstensione();
        $this->smarty->assign('errore','Vecchia password');
        $this->smarty->assign('nome', $nome);
        $this->smarty->assign('cognome', $cognome);
        $this->smarty->assign('user', $user);
        $this->smarty->assign('email', $email);
        $this->smarty->assign('type', $type);
        $this->smarty->assign('pic64', $pic64);
        $this->smarty->display('areapersonale.tpl');

    }

    /**
     * Restituisce il valore associato alla chiave 'email' dell'array _$___POST_
     * @return mixed
     */
    public function getEmail(){
        $email = $_POST['email'];
        return $email;
    }
    /**
     * Restituisce un array con i valori associati alle chiavi 'oldpassword' e 'newpassword' dell'array _$___POST_
     * @return mixed
     */
    public function getPassword(){
        $oldpassword = $_POST['oldpassword'];
        $newpassword = $_POST['newpassword'];
        $password = array($oldpassword, $newpassword);
        return $password;
    }

    /** Preleva le informazioni dall'oggetto, le assegna ai parametri del template, assegna il messaggio di errore e mostra la pagina.
     * @param object $objUser
     * @return void
     * @throws SmartyException
     */
    public function errorePassword(object $objUser){
        $nome=$objUser->getNome();
        $cognome=$objUser->getCognome();
        $user=$objUser->getUsername();
        $email=$objUser->getEmail();
        $img = $objUser->getImg();
        $pic64 = $img->getImage();
        $type = $img->getEstensione();
        $this->smarty->assign('errore','Errore vecchia password, riprova');
        $this->smarty->assign('nome', $nome);
        $this->smarty->assign('cognome', $cognome);
        $this->smarty->assign('user', $user);
        $this->smarty->assign('email', $email);
        $this->smarty->assign('type', $type);
        $this->smarty->assign('pic64', $pic64);
        $this->smarty->display('areapersonale.tpl');
    }

    /**
     * Restituisce un array contenente i dati associati alla chiave 'img' dell'array _$___FILES_
     * @return array
     */
    public function getImg(){
        $estensione = $_FILES['img']['type'];
        $nome = $_FILES['img']['name'];
        $file = $_FILES['img']['tmp_name'];
        $dimensione = $_FILES['img']['size'];
        $arrImg = array($nome,$estensione, $file, $dimensione);
        return $arrImg;
    }

}