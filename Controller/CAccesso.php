<?php

require_once "autoloader.php";
require_once "Sessioni.php";

/**
 * Classe per l'autenticazione e la registrazione dell'utente.
 * @package Controller
 */
class CAccesso
{
    /**
     * @var CAccesso|null Variabile di classe che mantiene l'istanza della classe.
     */
    public static ?CAccesso $instance = null;

    /**
     * Costruttore della classe.
     */
    private function __construct()
    {
    }

    /**
     * Restituisce l'istanza della classe.
     * @return CAccesso|null
     */
    public static function getInstance(): ?CAccesso
    {
        if (!isset(self::$instance)) {
            self::$instance = new CAccesso();
        }
        return self::$instance;
    }


    /**
     * Gestisce il login dell'utente. Preleva le credenziali di accesso dalla view, le verifica, se l'utente esiste e le credenziali sono corrette,
     * dopo aver messo in sessione le informazioni riguardo l'utente, reindirizza alla pagina precedentemente visitata al login.
     * Se le credenziali sono errate reindirizza alla di login che mostra l'errore di autenticazione.
     * @return void
     */
    public function login()
    {
        $view = new VAccesso();
        $arrParametri = $view->getLogin();
        $dbUtente = FUtente::getInstance();
        $utente = $dbUtente->loadLogin($arrParametri[0], $arrParametri[1]);

        if ($utente != null) {
            $sessione = new Sessioni();
            $sessione->imposta_valore("id_utente", $utente->getId());
            $sessione->imposta_valore("tipo_utente", get_class($utente));
            $previousPage = $sessione->leggi_valore("previous_page");
            header("Location: $previousPage");
        } else {
            header('Location: /Accesso/erroreLogin');
        }
    }

    /**
     * Effettua il logout dell'utente eliminando dalla sessione le variabili deputate al mantenimento dell'autenticazione.
     * @return void
     */
    public function logout()
    {
        $sessione->distruggi();
    }

    /**
     * Verifica se l'utente ha effettuato il login.
     * @return mixed
     */
    public function isLogged()
    {
        $result = $sessione->isLogged();
        return $result;
    }

    /**
     * Gestisce la registrazione del cliente. Preleva i parametri dalla view, crea l'oggetto _ECliente_ impostando gli attributi con i parametri prelevati,
     * lo memorizza nella base dati e imposta le variabili di sessione per loggare l'utente appena creato.
     * @return void
     */
    public function registrazioneCliente()
    {
        $view = new VAccesso();
        $parametri = $view->getRegistrazione();
        $arrParams = $parametri[0];
        $arrImg = $parametri[1];

        $dbCliente = FCliente::getInstance();
        $cliente = new ECliente();
        $cliente->setNome($arrParams[0]);
        $cliente->setCognome($arrParams[1]);
        $cliente->setUsername($arrParams[2]);
        $cliente->setPassword($arrParams[4]);
        $cliente->setEmail($arrParams[3]);

        $objImg = new EImmagine();
        $objImg->setNome($arrImg[0]);
        $objImg->setEstensione($arrImg[1]);
        $objImg->setImage(file_get_contents($arrImg[2]));
        $objImg->setDimensione($arrImg[3]);
        $dbImg = FImmagine::getInstance();
        $dbImg->store($objImg);

        $cliente->setImg($objImg);

        $dbCliente->store($cliente);

        $sessione = new Sessioni();
        $sessione->imposta_valore("id_utente", $cliente->getId());
        $sessione->imposta_valore("tipo_utente", get_class($cliente));

        header('Location: /Areapersonale/mostraAreaPersonale');
    }

    /**
     * Gestisce la registrazione del cliente. Preleva i parametri dalla view _VAccesso_, crea l'oggetto _EGestore_ impostando gli attributi con i parametri prelevati,
     * lo memorizza nella base dati e imposta le variabili di sessione per loggare l'utente appena creato.
     * @return void
     */
    public function registrazioneGestore()
    {
        $view = new VAccesso();
        $parametri = $view->getRegistrazione();

        $arrParams = $parametri[0];
        $arrImg = $parametri[1];

        $dbGestore = FGestore::getInstance();
        $gestore = new EGestore();
        $gestore->setNome($arrParams[0]);
        $gestore->setCognome($arrParams[1]);
        $gestore->setUsername($arrParams[2]);
        $gestore->setPassword($arrParams[4]);
        $gestore->setEmail($arrParams[3]);

        $objImg = new EImmagine();
        $objImg->setNome($arrImg[0]);
        $objImg->setEstensione($arrImg[1]);
        $objImg->setImage(file_get_contents($arrImg[2]));
        $objImg->setDimensione($arrImg[3]);
        $dbImg = FImmagine::getInstance();
        $dbImg->store($objImg);

        $gestore->setImg($objImg);
        $dbGestore->store($gestore);

        $sessione = new Sessioni();
        $sessione->imposta_valore("id_utente", $gestore->getId());
        $sessione->imposta_valore("tipo_utente", get_class($gestore));

        self::conferma();
    }

    /**
     * Gestisce la visualizzazione della pagina di login e imposta nella sessione il path della pagina precedente.
     * @return void
     */
    public function mostraLogin(): void {
        $sessione = new Sessioni();
        $previousPage = $sessione->leggi_valore("previous_page");
        if (isset($_SERVER['HTTP_REFERER']) && $previousPage != "/Areapersonale/mostraAreaPersonale") {
            $previousPage = $_SERVER['HTTP_REFERER'];
            $sessione->imposta_valore('previous_page', $previousPage);
        }
        $view = new VAccesso();
        $view->mostraLogin();
    }

    /**
     * Gestisce la visualizzazione della pagina di registrazione per il gestore.
     * @return void
     */
    public function mostraRegistrazioneGestore(): void {
        $view = new VAccesso();
        $view->mostraRegistrazioneGestore();
    }

    /**
     * Gestisce la visualizzazione della pagina di login con errore di autenticazione.
     * @return void
     */
    public function erroreLogin(): void {
        $view = new VAccesso();
        $view->erroreLogin();
    }

    /**
     * Gestisce la visualizzazione della pagina di conferma operazione.
     * @return void
     */
    public function conferma(): void {
        $view = new VAccesso();
        $view->conferma();
    }
}
