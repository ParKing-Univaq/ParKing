<?php

require_once "autoloader.php";

/**
 * Classe per rappresentare le risposte del gestore alle recensioni nel suo parcheggio.
 * @package Entity
 */
class ERisposta
{
    /**
     * ID della risposta per l'identificazione nella base dati.
     * @var int
     */
    public int $id_risposta;
    /**
     * Testo della risposta.
     * @var string
     */
    public string $descrizione;
    /**
     * Scrittore della risposta.
     * @var EGestore
     */
    public EGestore $_Scrittore;
    /**
     * Recensione di riferimento.
     * @var ERecensione
     */
    public ERecensione $_Riferimento;
    /**
     * Data di scrittura della recensione.
     * @var DateTime|string
     */
    public DateTime|string $data_scrittura;
    /**
     * ID utilizzato nella base dati per gestire la relazione tra risposta e scrittore.
     * @var int
     */
    public int $id_gestore;
    /**
     * ID utilizzato nella base dati per gestire la relazione tra prenotazione e recensione.
     * @var int
     */
    public int $id_recensione;

    /**
     *Costruttore della classe.
     */
    public function __construct()
    {}

    /**
     * Restituisce la data di scrittura della risposta.
     * @return DateTime|string Data di scrittura.
     */
    public function getDataScrittura(): DateTime|string
    {
        return $this->data_scrittura;
    }

    /**
     * Imposta la data di scrittura al momento attuale.
     */
    public function setDataScrittura(): void
    {
        $dataCorrente =  new DateTime();
        $this->data_scrittura = $dataCorrente;
    }


    /**
     * Restituisce l'ID dello scrittore della risposta.
     * @return int ID dello scrittore.
     */
    public function getIdGestore(): int
    {
        return $this->id_gestore;
    }

    /**
     * Imposta l'ID dello scrittore della risposta.
     * @param int $id_gestore Il nuovo ID dello scrittore.
     */
    public function setIdGestore(int $id_gestore): void
    {
        $this->id_gestore = $id_gestore;
    }

    /**
     * Restituisce l'ID del riferimento della recensione.
     * @return int ID della recensione di riferimento.
     */
    public function getIdRecensione(): int
    {
        return $this->id_recensione;
    }


    /**
     * Imposta l'ID del riferimento della recensione.
     * @param int $id_recensione Il nuovo ID della recensione.
     */
    public function setIdRecensione(int $id_recensione): void
    {
        $this->id_recensione = $id_recensione;
    }

    /**
     * Restituisce l'utente scrittore della risposta.
     * @return EGestore Scrittore della ristosta.
     */
    public function getScrittore(): EGestore
    {
        return $this->_Scrittore;
    }

    /**
     * Imposta l'utente scrittore della risposta.
     * @param EGestore $Scrittore Il nuovo utente scrittore.
     */
    public function setScrittore(EGestore $Scrittore): void
    {
        $this->_Scrittore = $Scrittore;
    }

    /** Imposta l'ID della risposta.
     * @param int $id Il nuovo ID.
     */
    public function setIdRisposta(int $id): void
    {
        $this->id_risposta = $id;
    }

    /**
     * Restituisce l'ID della risposta.
     * @return int ID della risposta.
     */
    public function getIdRisposta(): int
    {
        return $this->id_risposta;
    }

    /**
     * Restituisce il testo della risposta.
     * @return string Il testo della risposta.
     */
    public function getDescrizione(): string
    {
        return $this->descrizione;
    }

    /**
     * Imposta il testo della risposta dopo averne fatto un controllo sulla lunghezza.
     * @param string $descrizione Il nuovo testo.
     * @return bool false se il testo supera i 380 caratteri, true se l'operazione è andata a buon fine.
     */
    public function setDescrizione(string $descrizione): bool
    {
        if (strlen($descrizione) < 380) {
            $this->descrizione = $descrizione;
            return true;
        } else {
            return false;
        }
    }

    /**
     * Restituisce la recensione di riferimento della risposta.
     * @return ERecensione Recensione di riferimento.
     */
    public function getRiferimento(): ERecensione
    {
        return $this->_Riferimento;
    }

    /**
     * Imposta la recensione di riferimento della risposta.
     * @param ERecensione $Riferimento Il nuovo riferimento.
     */
    public function setRiferimento(ERecensione $Riferimento): void
    {
        $this->_Riferimento = $Riferimento;
    }


}