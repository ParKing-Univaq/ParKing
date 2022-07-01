<?php

require_once "autoloader.php";
require_once "Sessioni.php";

/**
 * Classe per la gestione dei parcheggi da parte del gestore.
 * @package Controller
 */
class CGestioneParcheggi
{
    /**
     * @var CGestioneParcheggi|null Variabile di classe che mantiene l'istanza della classe.
     */
    private static ?CGestioneParcheggi $instance = null;

    /**
     * Costruttore della classe.
     */
    private function __construct(){}

    /**
     * Restituisce l'istanza della classe.
     * @return CGestioneRecensione|null
     */
    public static function getInstance(): ?CGestioneParcheggi{
        if(!isset(self::$instance)) {
            self::$instance = new CGestioneParcheggi();
        }
        return self::$instance;
    }

    /**
     * Consente la visualizzazione della pagina completa dei dettagli di uno specifico parcheggio di cui il gestore è proprietario.
     * @return void
     * @throws SmartyException
     */
    public function dettagliParcheggio(){

        $view = new VGestioneParcheggi();
        $intIdParcheggio = $view->getIdParcheggio();

        $dbParcheggio = FParcheggio::getInstance();
        $dbRecensioni = FRecensione::getInstance();
        $recensioni = $dbRecensioni->searchByParcheggio($intIdParcheggio);
        $parcheggio = $dbParcheggio->load($intIdParcheggio);


        $dbTaglie = FTaglia::getInstance();
        $taglie = $dbTaglie->getAllTaglie();

        $arrNumPostiTariffe = $parcheggio->getPostieTariffabyTaglia($taglie);

        $view->dettagliParcheggio($parcheggio,$recensioni, $arrNumPostiTariffe);
    }

    //NON utilizzato
    public function mostraPosti(int $intIdParcheggio){
        $dbPostoAuto = FPostoAuto::getInstance();
        $result = $dbPostoAuto->selectPostiByParcheggio($intIdParcheggio);
        return $result;
    }

    //NON utilizzato
    public function dettagliPostiAuto(int $intIdPostoAuto){
        $dbPostoAuto = FPostoAuto::getInstance();
        $posto = $dbPostoAuto->load($intIdPostoAuto);
        return $posto;
    }

    //NON utilizzato
    public function aggiungiPosto(string $strTaglia, float $floatTariffa, int $intIdParcheggio){
        $dbTaglia = FTaglia::getInstance();
        $objTaglia = $dbTaglia->load($strTaglia);
        $objTariffa = new ETariffa();
        $objTariffa->setTariffa($floatTariffa);

        $dbParcheggio = FParcheggio::getInstance();
        $objPacheggio = $dbParcheggio->load($intIdParcheggio);

        $objPostoAuto = new EPostoAuto();
        $objPostoAuto->setTaglia($objTaglia);
        $objPostoAuto->setTariffaBase($objTariffa);
        $dbPosto = FPostoAuto::getInstance();
        $dbPosto->store($objPostoAuto); //faccio lo store per assegnargli l'id
        $objPostoAuto = $dbPosto->load($objPostoAuto->getId()); //faccio la load per avere l'oggetto con le chiavi esterne

        $objPacheggio->addPosto($objPostoAuto);

        $dbParcheggio->update($objPacheggio);

    }

    //NON utilizzato
    public function modificaPrezzo(float $floatTariffa, int $intIdParcheggio, string $taglia ){
        $dbParcheggio = FParcheggio::getInstance();
        $parcheggio = $dbParcheggio->load($intIdParcheggio);

        $dbTaglia = FTaglia::getInstance();
        $tagliaObj = $dbTaglia->load($taglia);

        if($parcheggio->setTariffaByTaglia($tagliaObj,$floatTariffa)){
            $dbParcheggio->update($parcheggio);
            return true;
        } else return false;

    }

    //NON utilizzato
    public function rimuoviPosto(int $intIdPostoAuto){
        $dbPostoAuto = FPostoAuto::getInstance();
        $objPostoAuto= $dbPostoAuto->load($intIdPostoAuto);

        $dbPostoAuto->delete($objPostoAuto);

    }

    //NON utilizzato
    public function mostraRecensioni(int $intIdParcheggio):array
    {
         $dbRecensione = FRecensione::getInstance();
         $result = $dbRecensione->searchByParcheggio($intIdParcheggio);
         return $result;
    }

    //NON utilizzato
    public function scriviRisposta():void{

        //int $intIdRecensione, int $intIdGestore, string $strDescrizione

        $dbRecensione = FRecensione::getInstance();
        $objrecensione = $dbRecensione->load($intIdRecensione);

        $dbGestore = FGestore::getInstance();
        $objGestore = $dbGestore->load($intIdGestore);

        $objrisposta = new ERisposta();
        $objrisposta->setDataScrittura();
        $objrisposta->setDescrizione($strDescrizione);
        $objrisposta->setScrittore($objGestore);
        $objrisposta->setRiferimento($objrecensione);

        $dbRiposta = FRisposta::getInstance();
        $dbRiposta->store($objrisposta);

    }

    /**
     * Consente di visualizzare l'area personale del gestore.
     * @return void
     */
    public function mostraAreaPersonale(): void {

        $sessione = new Sessioni();
        $intIdGestore = $sessione->leggi_valore('id_utente');

        $dbParcheggio = FParcheggio::getInstance();
        $view = new VGestioneParcheggi();

        $parcheggi = $dbParcheggio->selectParcheggioByGestore($intIdGestore);

        if ($parcheggi != false){
            $gestore = $parcheggi[0]->getGestore();
            $view->mostraPannelloGestione($gestore,$parcheggi);
        } else {
            $dbGestore = FGestore::getInstance();
            $gestore = $dbGestore->load($intIdGestore);
            $view->mostraPannelloGestione($gestore,'Non ci sono parcheggi disponibili, contattare i responsabili per inserire di un parcheggio');
        }
    }

    /**
     * Consente di aggiungere un servizio a quelli offerti dal parcheggio prelevando dalla view le informazioni necessarie e le utilizza per aggiornare il parcheggio.
     * @return void
     */
    public function addServizio(){
        $sessione = new Sessioni();
        $id_parcheggio = $sessione->leggi_valore('id_parcheggio');
        $view = new VGestioneParcheggi();
        $paramservizio = $view->getServizio();

        if($paramservizio[1]!='on'){
            $servizio = new EServizio();
            $servizio->setNomeServizio($paramservizio[0]);
            $dbs = FServizioIncluso::getInstance();
            $dbs->store($servizio);
        }else{
            $servizio = new EServizioOpzionale();
            $servizio->setNomeServizio($paramservizio[0]);
            $tar = new ETariffa();
            $tar->setTariffa($paramservizio[2]);
            $servizio->setCosto($tar);
            $dbso = FServizioOpzionale::getInstance();
            $dbso->store($servizio);
        }

        $dbPark = FParcheggio::getInstance();
        $objPark = $dbPark->load($id_parcheggio);
        $objPark->addServizio($servizio);

        $dbPark->update($objPark);

        header('Location: /GestioneParcheggi/dettagliParcheggio');


    }

    /**
     * Consente di rimuovere un servizio da quelli offerti dal parcheggio prelevando dalla view l'ID del servizio e utilizzandolo per aggiornare il parcheggio.
     * @return void
     */
    public function rimuoviServizio(){
        $sessione = new Sessioni();
        $id_parcheggio = $sessione->leggi_valore('id_parcheggio');

        $view = new VGestioneParcheggi();
        $id_servizio = $view->getOptionServizio();


        $dbPark = FParcheggio::getInstance();
        $objPark = $dbPark->load($id_parcheggio);
        $objPark->rimuoviServizio($id_servizio);

        $dbPark->update($objPark);

        header('Location: /GestioneParcheggi/dettagliParcheggio');

    }

    /**
     * Consente di modificare la descrizione del parcheggio prelevando dalla view la nuova descrizione e utilizzandola per aggiornare il parcheggio.
     * @return void
     */
    public function modificaDescrizione(){
        $sessione = new Sessioni();
        $id_parcheggio = $sessione->leggi_valore('id_parcheggio');

        $view = new VGestioneParcheggi();
        $strdescr = $view->getNuovaDescrizione();

        $dbPark = FParcheggio::getInstance();
        $objPark = $dbPark->load($id_parcheggio);
        $objPark->setDescrizione($strdescr);

        $dbPark->update($objPark);

        header('Location: /GestioneParcheggi/dettagliParcheggio');

    }

    /**
     *  Gestisce la modifica della tariffa a tutti i posti di una specifica taglia. Preleva dalla view i parametri, taglia dei posti da modifica e nuova tariffa,
     *  e li utilizza per aggiornare il parcheggio.
     * @return void
     */
    public function modificaTariffa(){
        $sessione = new Sessioni();
        $id_parcheggio = $sessione->leggi_valore('id_parcheggio');

        $view = new VGestioneParcheggi();
        $arrTariffe = $view->getNuoveTariffe(); // ho (taglia, tariffa)

        $dbPark = FParcheggio::getInstance();
        $objPark = $dbPark->load($id_parcheggio);
        $objPark->setTariffaByTaglia($arrTariffe);

        $dbPark->update($objPark);

        header('Location: /GestioneParcheggi/dettagliParcheggio');

    }

    /**
     * Gestisce l'inserimento di una nuova immagine del parcheggio. Preleva l'immagine dalla view e aggiorna il parcheggio.
     * @return void
     */
    public function addImmagine(){
        $sessione = new Sessioni();
        $id_parcheggio = $sessione->leggi_valore('id_parcheggio');

        $view = new VGestioneParcheggi();

        $arrImg = $view->getImg();

        $dbPark = FParcheggio::getInstance();
        $objPark = $dbPark->load($id_parcheggio);

        $objImg = new EImmagine();
        $objImg->setNome($arrImg[0]);
        $objImg->setEstensione($arrImg[1]);
        $objImg->setImage(file_get_contents($arrImg[2]));
        $objImg->setDimensione($arrImg[3]);
        $dbImg = FImmagine::getInstance();
        $dbImg->store($objImg);

        $objPark->addImmagine($objImg);
        $dbPark->update($objPark);

        header('Location: /GestioneParcheggi/dettagliParcheggio');
    }

    /**
     * Gestisce la rimozione di una immagine del parcheggio. Preleva le informazioni sull'immagine da rimuovere dalla view e aggiorna il parcheggio.
     * @return void
     */
    public function rimuoviImmagine(){
        $sessione = new Sessioni();
        $id_parcheggio = $sessione->leggi_valore('id_parcheggio');
        $view = new VGestioneParcheggi();
        $id_img = $view->getIdImg();


        $dbPark = FParcheggio::getInstance();
        $objPark = $dbPark->load($id_parcheggio);
        $objPark->rimuoviImmagine($id_img);
        $dbPark->update($objPark);

        header('Location: /GestioneParcheggi/dettagliParcheggio');

    }

    /**
     * Gestisce la risposta alle recensioni da parte del gestore. Preleva la risposta dalla view e la registra,
     * reindirizzando alla pagina di conferma di operazione avvenuta.
     * @return void
     */
    public function rispondi(){
        $sessione = new Sessioni();
        $id_gestore = $sessione->leggi_valore('id_utente');

        $dbGestore = FGestore::getInstance();
        $objGestore = $dbGestore->load($id_gestore);

        $view = new VGestioneParcheggi();
        $arrParams = $view->getRisposta();

        $dbRec = FRecensione::getInstance();
        $objRec = $dbRec->load($arrParams[1]);
        $objRisp = new ERisposta();
        $objRisp->setScrittore($objGestore);
        $objRisp->setRiferimento($objRec);
        $objRisp->setDataScrittura();
        $objRisp->setDescrizione($arrParams[0]);

        $dbRisp = FRisposta::getInstance();
        $dbRisp->store($objRisp);

        self::conferma();

    }

    /**
     * Gestisce la visualizzazione della pagina di conferma operazione.
     * @return void
     */
    public function conferma(){
        $view = new VGestioneParcheggi();
        $view->conferma();
    }
}