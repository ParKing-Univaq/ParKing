<?php

require_once "autoloader.php";
require_once "StartSmarty.php";

/**
 * Classe per la visualizzazione e recupero informazioni dalle pagine relative alla ricerca e prenotazione di posti.
 * @package View
 */
class VRicerca
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
     * Mostra la pagina iniziale di ricerca. Assegna i parametri al template e mostra la pagina.
     * @param array $taglie
     * @param int $numParcheggi
     * @param int $numPosti
     * @param int $numClienti
     * @param int $numPrenotazioni
     * @return void
     * @throws SmartyException
     */
    public function mostraPaginaDiRicerca(array $taglie, int $numParcheggi, int $numPosti, int $numClienti, int $numPrenotazioni): void {
        $this->smarty->assign('taglie',$taglie);
        $this->smarty->assign('park',$numParcheggi);
        $this->smarty->assign('posti',$numPosti);
        $this->smarty->assign('clienti',$numClienti);
        $this->smarty->assign('pre',$numPrenotazioni);
        $this->smarty->display('index.tpl');
    }


    /**
     * Mostra la pagina dei risultati. Assegna i parametri al template e mostra la pagina.
     * @param array|bool $risultati
     * @param array|null $params
     * @param array $taglie
     * @return void
     * @throws SmartyException
     */
    public function mostraRisultati(array|bool $risultati, ?array $params, array $taglie): void {

        $this->smarty->assign('risultati',$risultati);
        $this->smarty->assign('parametri_ricerca',$params);
        $this->smarty->assign('taglie',$taglie);

        $this->smarty->display('risultati.tpl');
    }

    /**
     * Mostra la pagina del dettaglio del parcheggio. Assegna i parametri al template e mostra la pagina.
     * @param EParcheggio $parcheggio
     * @param array|bool $recensioni
     * @param array $params
     * @return void
     * @throws SmartyException
     */
    public function mostraDettaglioParcheggio(EParcheggio $parcheggio, array|bool $recensioni, array $params): void {

        $this->smarty->assign("parcheggio",$parcheggio);
        $this->smarty->assign("recensioni",$recensioni);
        $this->smarty->assign("parametri_ricerca",$params);

        $this->smarty->display('dettagliparcheggio.tpl');
    }

    /**
     * Mostra la pagina del riepilogo della prenotazione. Assegna i parametri al template e mostra la pagina.
     * @param array $infoPrenotazione
     * @param EParcheggio $parcheggio
     * @param EPostoAuto $posto
     * @param bool|array $serviziOpz
     * @param float $costoTotale
     * @param bool|int $idUtente
     * @param bool|string $tipoUtente
     * @return void
     * @throws SmartyException
     */
    public function mostraRiepilogoPrenotazione(array $infoPrenotazione, EParcheggio $parcheggio, EPostoAuto $posto, bool|array $serviziOpz, float $costoTotale, bool|int $idUtente, bool|string $tipoUtente): void {
        $this->smarty->assign('parcheggio',$parcheggio);
        $this->smarty->assign('posto',$posto);
        $this->smarty->assign('info_prenotazione',$infoPrenotazione);
        $this->smarty->assign('servizi_opz',$serviziOpz);
        $this->smarty->assign('costo_totale',$costoTotale);
        $this->smarty->assign('id_utente',$idUtente);
        $this->smarty->assign('tipo_utente',$tipoUtente);

        $this->smarty->display('riepilogoprenotazione.tpl');
    }

    /**
     * Mostra la pagina di conferma di operazione avvenuta.
     * @return void
     * @throws SmartyException
     */
    public function confermaOperazione(): void {
        $this->smarty->display('confermaoperazione.tpl');
    }

    /**
     * Restituisce una copia dell'array _$___POST_ se questo ha almeno una chiave con valore assegnato, false altrimenti.
     * @return array|bool
     */
    public function getArrayPost(): array|bool {
        $parametri = false;
        if (count($_POST)){
            $parametri = $_POST;
        }
        return $parametri;
    }

    /**
     * Restituisce il valore assegnato alla chiave passata come parametro dell'array _$___POST_, se assegnato, altrimenti false.
     * @param string $key
     * @return string|bool
     */
    public function getPostValue(string $key): string|bool {
        $value = false;
        if (isset($_POST[$key])) {
            $value = $_POST[$key];
        }
        return $value;
    }

}