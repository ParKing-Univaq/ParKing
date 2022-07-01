<?php

require_once "autoloader.php";

/**
 *Classe per la rappresentazione degli utenti.
 * @uses ECliente Cliente che ha effettuato la prenotazione.
 * @uses EPostoAuto Posto auto che si è prenotato.
 * @uses EServizioOpzionale Servizio opzionale di cui il cliente vuole usufruire.
 * @package Entity
 */
class EPrenotazione
{

    /**
     * ID della prenotazione per l'identificazione nella base dati.
     * @var int
     */
    public int $id_prenotazione;
    /**
     * Data d'inizio della prenotazione.
     * @var DateTime|string
     */
    public DateTime|string $data_inizio;
    /**
     * Data del termine della prenotazione.
     * @var DateTime|string
     */
    public DateTime|string $data_fine;
    /**
     * Costo totale della prenotazione.
     * @var float
     */
    public float $totale;
    /**
     * Cliente che ha effettuato la prenotazione.
     * @var ECliente
     */
    public ECliente $_Utilizzatore;
    /**
     * Posto auto prenotato.
     * @var EPostoAuto
     */
    public EPostoAuto $_PostoAuto;
    /**
     * Servizi opzionali scelti dal cliente.
     * @var array
     */
    public array $_ServiziOpzionali = array();
    /**
     * ID utilizzato nella base dati per gestire la relazione tra prenotazione e cliente.
     * @var int
     */
    public int $id_utilizzatore;
    /**
     * ID utilizzato nella base dati per gestire la relazione tra prenotazione e posto auto.
     * @var int
     */
    public int $id_posto;


    /**
     *Costruttore della classe.
     */
    public function __construct() {
    }

    /**
     * Restituisce l'ID della prenotazione.
     * @return int ID della prenotazione.
     */
    public function getIdPrenotazione(): int {
        return $this->id_prenotazione;
    }

    /**
     * Imposta l'ID del cliente.
     * @param int $id_utilizzatore Nuovo ID del cliente.
     */
    public function setIdUtilizzatore(int $id_utilizzatore): void {
        $this->id_utilizzatore = $id_utilizzatore;
    }

    /**
     * Imposta l'ID del posto auto.
     * @param int $id_posto Nuovo ID del posto auto.
     */
    public function setIdPosto(int $id_posto): void {
        $this->id_posto = $id_posto;
    }

    /**
     * Restituisce l'array contenente tutti i servizi opzionali scelti.
     * @return array Array contenente tutti i servizi opzionali.
     */
    public function getServiziOpzionali(): array {
        return $this->_ServiziOpzionali;
    }

    /**
     * Imposta la totalità dei servizi opzionali scelti.
     * @param array $ServiziOpzionali Array dei nuovi servizi opzionali.
     */
    public function setServiziOpzionali(array $ServiziOpzionali): void {
        $this->_ServiziOpzionali = $ServiziOpzionali;
    }

    /**
     * Restituisce la data d'inizio prenotazione.
     * @return DateTime Data d'inizio prenotazione.
     */
    public function getDataInizio(): DateTime {
        return $this->data_inizio;
    }

    /**
     * Restituisce la data di termine prenotazione.
     * @return DateTime Data di termine prenotazione.
     */
    public function getDataFine(): DateTime {
        return $this->data_fine;
    }

    /**
     * Restituisce il cliente che ha effettuato la prenotazione.
     * @return ECliente Cliente che ha effettuato la prenotazione.
     */
    public function getUtilizzatore(): ECliente {
        return $this->_Utilizzatore;
    }

    /**
     * Restituisce il posto auto prenotato.
     * @return EPostoAuto Posto auto prenotato.
     */
    public function getPostoAuto(): EPostoAuto {
        return $this->_PostoAuto;
    }

    /**
     * Imposta l'ID della prenotazione.
     * @param int $id_prenotazione Il nuovo ID della prenotazione.
     */
    public function setIdPrenotazione(int $id_prenotazione): void {
        $this->id_prenotazione = $id_prenotazione;
    }

    /**
     * Imposta il cliente che ha effettuato la prenotazione.
     * @param ECliente $Utilizzatore Il cliente che ha effettuato la prenotazione.
     */
    public function setUtilizzatore(ECliente $Utilizzatore): void {
        $this->_Utilizzatore = $Utilizzatore;
    }


    /**
     * Imposta la data d'inizio della prenotazione.
     * @param DateTime $dataInizio La nuova data d'inizio.
     */
    public function setDataInizio(DateTime $dataInizio): void {

        $this->data_inizio = $dataInizio;

    }


    /**
     * Imposta la data di termine della prenotazione.
     * @param DateTime $dataFine La nuova data di termine.
     */
    public function setDataFine(DateTime $dataFine): void {
        $this->data_fine = $dataFine;
    }

    /**
     * Imposta il posto auto prenotato.
     * @param EPostoAuto $Posto Il nuovo posto auto.
     */
    public function setPostoAuto(EPostoAuto $Posto): void {
        $this->_PostoAuto = $Posto;
    }

    /**
     * Restituisce l'ID del cliente che ha effettuato la prenotazione.
     * @return int ID del cliente.
     */
    public function getIdUtilizzatore(): int {
        return $this->id_utilizzatore;
    }

    /**
     * Restituisce l'ID del posto auto prenotato.
     * @return int ID del posto auto.
     */
    public function getIdPosto(): int {
        return $this->id_posto;
    }

    /**
     * Metodo per aggiungere un servizio a quelli scelti.
     * @param EServizioOpzionale $s Il servizio da aggiungere.
     * @return void
     */
    public function addServizio(EServizioOpzionale $s): void {

        $this->_ServiziOpzionali[] = $s;

    }

    /**
     * Metodo che calcola il costo totale in base alla tariffa del posto auto ed ai servizi opzionali scelti.
     * @return void
     */
    public function setTotale(): void {

        $ore1 = 0;
        $ore2 = 0;
        $durata = $this->data_fine->diff($this->data_inizio);

        if($durata->format('%a') > 0){
            $ore1 = $durata->format('%a')*24;
        }
        if($durata->format('%h') > 0){
            $ore2 = $durata->format('%h');
        }
        $oreSosta = $ore1 + $ore2;

        $this->totale = $this->_PostoAuto->getTariffaBase()->getTariffa() * $oreSosta;

        foreach ($this->_ServiziOpzionali as $servizi) {
            $this->totale += $servizi->getCosto()->getTariffa();
        }
    }

    /**
     * Restituisce il costo totale della prenotazione.
     * @return float Costo totale.
     */
    public function getTotale(): float {
        return $this->totale;
    }

    /**
     *
     * Metodo che crea la prenotazione in base ai parametri passati e ne effettua il caricamento nella base dati.
     * @param int $idUtilizzatore ID del cliente.
     * @param DateTime $arrivo Data di inizio prenotazione.
     * @param DateTime $partenza Data di fine prenotazione.
     * @param int $idPosto ID del posto prenotato.
     * @param array|bool $idServiziOpzionali Array contenente gli ID dei servizi opzionali scelti, può essere false se non ne è stato scelto alcuno.
     * @return void
     */
    public function submitPrenotazione(int $idUtilizzatore, DateTime $arrivo, DateTime $partenza, int $idPosto, array|bool $idServiziOpzionali): void {
        $this->id_utilizzatore = $idUtilizzatore;
        $this->data_inizio = $arrivo;
        $this->data_fine = $partenza;
        $this->id_posto = $idPosto;

        $dbPosto = FPostoAuto::getInstance();
        $this->_PostoAuto = $dbPosto->load($this->id_posto);

        $dbUtilizzatore = FCliente::getInstance();
        $this->_Utilizzatore = $dbUtilizzatore->load($this->id_utilizzatore);

        if ($idServiziOpzionali) {
            $dbServizi = FServizioOpzionale::getInstance();
            foreach ($idServiziOpzionali as $id) {
                $this->_ServiziOpzionali[] = $dbServizi->load($id);
            }
        }
        $this->setTotale();
        $dbPrenotazione = FPrenotazione::getInstance();

        $dbPrenotazione->store($this);
    }


}