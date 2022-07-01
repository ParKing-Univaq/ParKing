<?php

require_once "autoloader.php";
require_once "Sessioni.php";

/**
 * Classe per la gestione delle operazioni all'interno dell'area personale dell'utente.
 * @package Controller
 */
class CAreapersonale
{
    /**
     * @var CAreapersonale|null Variabile di classe che mantiene l'istanza della classe.
     */
    private static ?CAreapersonale $instance = null;

    /**
     * Costruttore della classe.
     */
    private function __construct(){}

    /**
     * Restituisce l'istanza della classe.
     * @return CAreapersonale|null
     */
    public static function getInstance(): ?CAreapersonale{
        if(!isset(self::$instance)) {
            self::$instance = new CAreapersonale();
        }
        return self::$instance;
    }


    /**
     * Gestisce la modifica della password di accesso del cliente. Preleva la vecchia e la nuova password dalla view, verifica la correttezza della vecchia e procede alla modifica.
     * @return false|void false se la vecchia password inserita non è corretta o se la procedura non è andata a buon fine.
     */
    public function modificaPassword(){
        $view = new VAreapersonale();
        $sessione = new Sessioni();
        $intIdUser = $sessione->leggi_valore('id_utente');
        $arrPassword = $view->getPassword();
        $dbUser = FCliente::getInstance();
        $user = $dbUser->load($intIdUser);
        if(md5($arrPassword[0])==$user->getPassword()) {
            $bool = $user->setPassword($arrPassword[1]);
            if ($bool) {
                $dbUser->update($user);
                header('Location: /Areapersonale/mostraAreaPersonale');

            } else {

                $view->errorePassword($user);
            }
        }else{
            $view->errorePassword($user);
            return false;
        }
    }

    /**
     * Gestisce la modifica dell'email del cliente. Preleva la nuova email dalla view e procede alla modifica.
     * @return void
     */
    public function modificaEmail(){
        $view = new VAreapersonale();
        $sessione = new Sessioni();

        $intIdUser = $sessione->leggi_valore('id_utente');
        $strEmail = $view->getEmail();
        $dbUser = FCliente::getInstance();
        $objUser = $dbUser->load($intIdUser);
        $objUser->setEmail($strEmail);
        $dbUser->update($objUser);

        header('Location: /Areapersonale/mostraAreaPersonale');
    }

    /**
     * Gestisce la modifica dell'immagine del cliente. Preleva la nuova immagine dalla view e procede alla modifica.
     * @return void
     */
    public function modificaImmagineProfilo(){
        $view = new VAreapersonale();
        $sessione = new Sessioni();
        $intIdUser = $sessione->leggi_valore('id_utente');
        $arrImg = $view->getImg();

        $dbUser = FCliente::getInstance();
        $objUser = $dbUser->load($intIdUser);

        $img = $objUser->getImg();

        $img->setNome($arrImg[0]);
        $img->setEstensione($arrImg[1]);
        $img->setImage(file_get_contents($arrImg[2]));
        $img->setDimensione($arrImg[3]);

        $dbImg = FImmagine::getInstance();
        $dbImg->update($img);

        header('Location: /Areapersonale/mostraAreaPersonale');

    }

    /**
     * Gestisce la visualizzazione dell'area personale degli utenti in base al tipo di utente. Se nessun utente è loggato reindirizza al login.
     * @return void
     */
    public function mostraAreaPersonale(){
        $accesso = new Sessioni();

        if(!$accesso->isLogged()){
            $accesso->imposta_valore("previous_page","/Areapersonale/mostraAreaPersonale");
            $controller = CAccesso::getInstance();
            $controller->mostraLogin();
        }else{
            if ($accesso->leggi_valore('tipo_utente') == 'ECliente') {
                $accesso->cancella_valore("previous_page");
                $dbUser = FCliente::getInstance();
                $objUser = $dbUser->load($accesso->leggi_valore('id_utente'));
                $view = new VAreapersonale();
                $view->mostraAreaPersonale($objUser);
            }
            if ($accesso->leggi_valore('tipo_utente') == 'EGestore') {
                $accesso->cancella_valore("previous_page");
                $controller = CGestioneParcheggi::getInstance();
                    $controller->mostraAreaPersonale();
            }
            if ($accesso->leggi_valore('tipo_utente') == 'EAmministratore') {
                $accesso->cancella_valore("previous_page");
                $controller = CModerazioneRecensioni::getInstance();
                $controller->mostraRecensionibyDate();
            }
        }
    }

    /**
     * Effettua il logout dell'utente eliminando dalla sessione le variabili deputate al mantenimento dell'autenticazione.
     * @return void
     */
    public function logout(){
        $sessioni = new Sessioni();
        $sessioni->distruggi();

        header('Location: /Areapersonale/mostraAreaPersonale');
    }
}