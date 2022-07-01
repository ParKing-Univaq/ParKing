<?php
require_once 'autoloader.php';
require_once 'Sessioni.php';

/**
 * Classe per la ricerca di posti ed effettuazione di prenotazioni da parte degli utenti.
 * @package Controller
 */
class CRicerca
{
    /**
     * @var CRicerca|null Variabile di classe che mantiene l'istanza della classe.
     */
    private static ?CRicerca $instance = null;

    /**
     * Costruttore di classe.
     */
    private function __construct(){}

    /**
     * Restituisce l'istanza della classe.
     * @return CRicerca|null
     */
    public static function getInstance(): ?CRicerca {
        if(!isset(self::$instance)) {
            self::$instance = new CRicerca();
        }
        return self::$instance;
    }

    /**
     * Gestisce la ricerca dei parcheggi. Rimuove le informazioni relative a servizi opzionali scelti in una possibile precedente ricerca,
     * preleva i parametri di ricerca, se sono stati inseriti dall'utente, dalla view, altrimenti li preleva dalla sessione, se non presenti in sessione reindirizza alla homepage.
     * Passa tali parametri alla classe _EParcheggio_ che effettua la ricerca, ottenuti i risultati reindirizza alla pagina dei risultati.
     * Se i parametri recuperati non sono validi reindirizza alla homepage.
     * @return void
     * @throws SmartyException
     */
    public function cercaParcheggio(): void {
        $sessione = new Sessioni();
        $sessione->cancella_valore("id_servizi_opz");
        $dbTaglie = FTaglia::getInstance();
        $taglie = $dbTaglie->getAllTaglie();
        $view = new VRicerca();

        $paramsRicerca = $view->getArrayPost();

        if ($paramsRicerca){
            $oldParams = $paramsRicerca;

            $paramsRicerca['dataoraarrivo'] = $paramsRicerca['dataarrivo'].' '.$paramsRicerca['oraarrivo'];
            $paramsRicerca['dataorapartenza'] = $paramsRicerca['datapartenza'].' '.$paramsRicerca['orapartenza'];

            $arrRisultati = EParcheggio::getRisultatoParcheggi($paramsRicerca['citta'],$paramsRicerca['dataorapartenza'],$paramsRicerca['dataoraarrivo'],$paramsRicerca['taglia']);
            $sessione->setSearchParamsPost();
            $view->mostraRisultati($arrRisultati,$oldParams,$taglie);
        }else {
            $oldParams = $sessione->leggi_valore("searchParams");
            if ($oldParams) {
                $oldParams['dataoraarrivo'] = $oldParams['dataarrivo'] . ' ' . $oldParams['oraarrivo'];
                $oldParams['dataorapartenza'] = $oldParams['datapartenza'] . ' ' . $oldParams['orapartenza'];

                $arrRisultati = EParcheggio::getRisultatoParcheggi($oldParams['citta'],$oldParams['dataorapartenza'],$oldParams['dataoraarrivo'],$oldParams['taglia']);
                $view->mostraRisultati($arrRisultati,$oldParams,$taglie);
            } else header("Location: /");
        }


    }


    /**
     * Gestisce la visualizzazione dei dettagli del parcheggio selezionato in seguito alla ricerca. Preleva i parametri del parcheggio da visualizzare dalla view,
     * se sono validi, li mette in sessione, recupera i parametri di ricerca dalla sessione, recupera dalla base dati il parcheggio, lo mette in sessione, recupera le recensioni
     * relative al parcheggio dalla base dati e infine reindirizza alla pagina di dettaglio del parcheggio. Se i dati iniziali prelevati dalla view non risultano validi
     * reindirizza alla homepage.
     * @return void
     * @throws SmartyException
     */
    public function selezionaParcheggio(): void {
        $view = new VRicerca();
        $sessione = new Sessioni();

        $idParcheggio = $view->getPostValue('id_parcheggio');
        $idPosto = $view->getPostValue('id_posto');
        $costoTotale = $view->getPostValue('costo_totale');
        if ($idParcheggio && $idPosto && $costoTotale){
            $sessione->imposta_valore('id_parcheggio', $idParcheggio);
            $sessione->imposta_valore('costo_totale', $costoTotale);
            $sessione->imposta_valore('id_posto', $idPosto);

            $paramsRicerca = $sessione->leggi_valore('searchParams');
            $paramsRicerca['dataoraarrivo'] = $paramsRicerca['dataarrivo'] . ' ' . $paramsRicerca['oraarrivo'];
            $paramsRicerca['dataorapartenza'] = $paramsRicerca['datapartenza'] . ' ' . $paramsRicerca['orapartenza'];


            $dbParcheggio = FParcheggio::getInstance();
            $dbRecensioni = FRecensione::getInstance();

            $parcheggio = $dbParcheggio->load($idParcheggio);
            $sessione->imposta_valore("parcheggio", serialize($parcheggio));
            $recensioni = $dbRecensioni->searchByParcheggio($idParcheggio);

            $view->mostraDettaglioParcheggio($parcheggio, $recensioni, $paramsRicerca);
        } else header("Location: /");
    }


    /**
     * Gestisce la visualizzazione del riepilogo della prenotazione. Preleva i minimi dati necessari dalla sessione, se sono validi prosegue
     * nel recuperare le informazioni sull'utente dalla sessione, recupera il posto da prenotare dalla base dati, e recupera le informazioni
     * sui servizi opzionali, se fornite dalla view, o dalla sessione. Infine reindirizza alla pagina del riepilogo.
     * Se il primo controllo sui minimi dati ha esito negativo reindirizza alla homepage.
     * @return void
     * @throws SmartyException
     */
    public function riepilogoPrenotazione(): void {
        $sessione = new Sessioni();

        $view = new VRicerca();

        $infoPrenotazione = $sessione->leggi_valore("searchParams");
        $parcheggio = unserialize($sessione->leggi_valore("parcheggio"));
        $idPosto = $sessione->leggi_valore("id_posto");
        $costoTotale = $sessione->leggi_valore("costo_totale");

        if ($infoPrenotazione && $parcheggio && $idPosto) {
            $idUtente = $sessione->leggi_valore("id_utente");
            $tipoUtente = $sessione->leggi_valore("tipo_utente");

            $posto = $parcheggio->getPostoByID($idPosto);
            $dbSO = FServizioOpzionale::getInstance();
            $id_servizi_opz = $view->getArrayPost();
            if ($id_servizi_opz) {
                foreach ($id_servizi_opz as $id_servizio => $value) {
                    if ($value == 'on') {
                        $sessione->setArrayValue('id_servizi_opz', $id_servizio);
                        $servizio = $dbSO->load($id_servizio);
                        $serviziOpz[] = $servizio;
                        $costoTotale += $servizio->getCosto()->getTariffa();
                    }
                }
            } else {
                $id_servizi_opz = $sessione->leggi_valore('id_servizi_opz');
                if ($id_servizi_opz) {
                    foreach ($id_servizi_opz as $id_servizio) {
                        $servizio = $dbSO->load($id_servizio);
                        $serviziOpz[] = $servizio;
                        $costoTotale += $servizio->getCosto()->getTariffa();
                    }
                } else $serviziOpz = false;
            }

            $view->mostraRiepilogoPrenotazione($infoPrenotazione, $parcheggio, $posto, $serviziOpz, $costoTotale, $idUtente, $tipoUtente);
        } else header("Location: /");
    }

    /**
     * Gestisce l'effettuazione della prenotazione. Preleva i minimi dati necessari dalla sessione, se sono validi prosegue
     * nel recuperare le altre informazioni dalla sessione, crea l'oggetto _EPrenotazione_ e richiama il suo metodo per effettuare
     * la registrazione della prenotazione. Infine reindirizza alla pagina di conferma di operazione avvenuta.
     * Se il primo controllo sui minimi dati ha esito negativo reindirizza alla homepage.
     * @return void
     * @throws SmartyException
     */
    public function confermaPrenotazione(): void {
        $sessione = new Sessioni();
        $view = new VRicerca();

        $infoPrenotazione = $sessione->leggi_valore("searchParams");
        $idPosto = $sessione->leggi_valore("id_posto");
        $idUtilizzatore = $sessione->leggi_valore("id_utente");

        if ($infoPrenotazione && $idPosto && $idUtilizzatore) {
            try {
                $dataOraArrivo = new DateTime($infoPrenotazione['dataarrivo'] . ' ' . $infoPrenotazione['oraarrivo']);
                $dataOraPartenza = new DateTime($infoPrenotazione['datapartenza'] . ' ' . $infoPrenotazione['orapartenza']);
            } catch (Exception $e) {
                print_r($e->getMessage());
            }

            $idServiziOpz = $sessione->leggi_valore('id_servizi_opz');

            $prenotazione = new EPrenotazione();
            $prenotazione->submitPrenotazione($idUtilizzatore, $dataOraArrivo, $dataOraPartenza, $idPosto, $idServiziOpz);
            $view->confermaOperazione();
        } else header("Location: /");
    }

    /**
     * Gestisce la visualizzazione della pagina iniziale di ricerca. Preleva le informazioni necessarie dalla base dati e reindirizza alla pagina iniziale
     * di ricerca richiamando il metodo della view designata.
     * @return void
     * @throws SmartyException
     */
    public function mostraPaginaDiRicerca(): void {
        $dbTaglie = FTaglia::getInstance();
        $taglie = $dbTaglie->getAllTaglie();
        $dbParcheggio = FParcheggio::getInstance();
        $numParcheggi = $dbParcheggio->getTotale();
        $dbParcheggio = FPostoAuto::getInstance();
        $numPosti = $dbParcheggio->getTotale();
        $dbParcheggio = FCliente::getInstance();
        $numClienti = $dbParcheggio->getTotale();
        $dbParcheggio = FPrenotazione::getInstance();
        $numPrenotazioni = $dbParcheggio->getTotale();

        $view = new VRicerca();
        $view->mostraPaginaDiRicerca($taglie, $numParcheggi,$numPosti,$numClienti, $numPrenotazioni);
    }


}