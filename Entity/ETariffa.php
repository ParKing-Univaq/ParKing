<?php


/**
 *Classe per la rappresentazione delle tariffe.
 * @package Entity
 */
class ETariffa
{

    /**
     * ID della tariffa per l'identificazione nella base dati.
     * @var int
     */
    public int $id_tariffa;
    /**
     * Valore numerico della tariffa.
     * @var float
     */
    public float $tariffa;

    /**
     *Costruttore della classe.
     */
    public function __construct(){
    }

    /**
     * Restituisce l'ID associato alla tariffa.
     * @return int ID associato.
     *
     */
    public function getIdTariffa(): int
    {
        return $this->id_tariffa;
    }

    /**
     * Imposta l'ID associato alla tariffa.
     * @param int $id_tariffa ID da associare.
     */
    public function setIdTariffa(int $id_tariffa): void
    {
        $this->id_tariffa = $id_tariffa;
    }

    /**
     * Restituisce il valore numerico della tariffa.
     * @return float Valore numerico della tariffa.
     */
    public function getTariffa(): float
    {
        return $this->tariffa;
    }

    /**
     * Imposta un nuovo valore numerico della tariffa.
     * @param float $tariffa Valore numerico da impostare.
     */
    public function setTariffa(float $tariffa): void
    {
        $this->tariffa = $tariffa;
    }



}

