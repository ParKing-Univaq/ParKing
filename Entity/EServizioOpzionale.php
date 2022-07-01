<?php

require_once "autoloader.php";


/**
 *Classe per la rappresentazione dei servizi opzionali offerti dal parcheggio.
 * @uses ETariffa Tariffa del servizio opzionale.
 * @package Entity
 */
class EServizioOpzionale extends EServizio
{
    /**
     * Tariffa del servizio opzionale.
     * @var ETariffa
     */
    public ETariffa $_costo;
    /**
     * ID utilizzato nella base dati per gestire la relazione tra servizio opzionale e tariffa associata.
     * @var int
     */
    public int $id_costo;


    /**
     *Costruttore della classe.
     */
    public function __construct(){}

    /**
     * Restituisce la tariffa del servizio opzionale.
     * @return ETariffa Tariffa del servizio.
     */
    public function getCosto(): ETariffa
    {
        return $this->_costo;
    }

    /**
     * Imposta la tariffa del servizio opzionale.
     * @param ETariffa $costo La nuova tariffa.
     */
    public function setCosto(ETariffa $costo): void
    {
        $this->_costo = $costo;
    }

    /**
     * Restituisce l'ID della tariffa del servizio opzionale.
     * @return int ID della tariffa.
     */
    public function getIdCosto(): int
    {
        return $this->id_costo;
    }

    /**
     * Imposta l'ID della tariffa del servizio opzionale.
     * @param int $id_costo Il nuovo ID della tariffa.
     */
    public function setIdCosto(int $id_costo): void
    {
        $this->id_costo = $id_costo;
    }


}