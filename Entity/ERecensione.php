<?php

require_once "autoloader.php";

/**
 * Classe per rappresentare le recensioni.
 * @uses ECliente Lo scrittore della recensione.
 * @uses EPrenotazione Prenotazione di riferimento.
 * @package Entity
 */
class ERecensione
{

    /**
     * ID della recensione per l'identificazione nella base dati.
     * @var int
     */
    public int $id_recensione;
    /**
     * Valutazione numerica.
     * @var int
     */
    public int $valutazione;
    /**
     * Testo della recensione.
     * @var string
     */
    public string $descrizione;
    /**
     * Scrittore della recensione.
     * @var ECliente
     */
    public ECliente $_Scrittore;
    /**
     * Prenotazione di riferimento.
     * @var EPrenotazione
     */
    public EPrenotazione $_Riferimento;
    /**
     * Data di scrittura della recensione.
     * @var DateTime|string
     */
    public DateTime|string $data_scrittura;
    /**
     * ID utilizzato nella base dati per gestire la relazione tra recensione e scrittore.
     * @var int
     */
    public int $id_scrittore;
    /**
     * ID utilizzato nella base dati per gestire la relazione tra prenotazione e recensione.
     * @var int
     */
    public int $id_riferimento;

    /**
     *Costruttore della classe.
     */
    public function __construct() {
    }

    /** Imposta l'ID della recensione.
     * @param int $id_recensione Il nuovo ID.
     */
    public function setIdRecensione(int $id_recensione): void {
        $this->id_recensione = $id_recensione;
    }


    /**
     * Restituisce l'ID della recensione.
     * @return int ID della recensione.
     */
    public function getIdRecensione(): int {
        return $this->id_recensione;
    }

    /**
     * Restituisce la valutazione numerica della recensione.
     * @return int La valutazione numerica.
     */
    public function getValutazione(): int {
        return $this->valutazione;
    }

    /**
     * Imposta la valutazione numerica della recensione.
     * @param int $valutazione La nuova valutazione numerica.
     */
    public function setValutazione(int $valutazione): void {
        $this->valutazione = $valutazione;
    }

    /**
     * Restituisce il testo della recensione.
     * @return string Testo della recensione.
     */
    public function getDescrizione(): string {
        return $this->descrizione;
    }

    /**
     * Imposta il testo della recensione dopo averne fatto un controllo sulla lunghezza.
     * @param string $descrizione Il nuovo testo.
     * @return bool false se il testo supera i 380 caratteri, true se l'operazione è andata a buon fine.
     */
    public function setDescrizione(string $descrizione): bool {
        if (strlen($descrizione) < 380) {
            $this->descrizione = $descrizione;
            return true;
        } else {
            return false;
        }
    }

    /**
     * Restituisce l'utente scrittore della recensione.
     * @return ECliente Scrittore della recensione.
     */
    public function getScrittore(): ECliente {
        return $this->_Scrittore;
    }

    /**
     * Imposta l'utente scrittore della recensione.
     * @param ECliente $_Scrittore Il nuovo utente scrittore.
     */
    public function setScrittore(ECliente $_Scrittore): void {
        $this->_Scrittore = $_Scrittore;
    }

    /**
     * Restituisce la prenotazione di riferimento della recensione.
     * @return EPrenotazione Prenotazione di riferimento.
     */
    public function getRiferimento(): EPrenotazione {
        return $this->_Riferimento;
    }

    /**
     * Imposta la prenotazione di riferimento della recensione.
     * @param EPrenotazione $_Riferimento Il nuovo riferimento.
     */
    public function setRiferimento(EPrenotazione $_Riferimento): void {
        $this->_Riferimento = $_Riferimento;
    }

    /**
     * Restituisce la data di scrittura della recensione.
     * @return DateTime|string La data di scrittura.
     */
    public function getDataScrittura(): DateTime|string {
        return $this->data_scrittura;
    }

    /**
     * Imposta la data di scrittura al momento attuale.
     */
    public function setDataScrittura(): void {
        $dataCorrente = new DateTime();
        $this->data_scrittura = $dataCorrente;
    }

    /**
     * Restituisce l'ID dello scrittore della recensione.
     * @return int ID dello scrittore.
     */
    public function getIdScrittore(): int {
        return $this->id_scrittore;
    }

    /**
     * Restituisce l'ID del riferimento della recensione.
     * @return int ID della prenotazione di riferimento.
     */
    public function getIdRiferimento(): int {
        return $this->id_riferimento;
    }

    /**
     * Imposta l'ID dello scrittore della recensione.
     * @param int $id_scrittore Il nuovo ID dello scrittore.
     */
    public function setIdScrittore(int $id_scrittore): void {
        $this->id_scrittore = $id_scrittore;
    }

    /**
     * Imposta l'ID del riferimento della recensione.
     * @param int $id_riferimento Il nuovo ID della prenotazione.
     */
    public function setIdRiferimento(int $id_riferimento): void {
        $this->id_riferimento = $id_riferimento;
    }


}