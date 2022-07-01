<?php

/**
 * Classe per la rappresentazione dei servizi offerti dal parcheggio.
 * @package Entity
 */
class EServizio
{
    /**
     * ID del servizio per l'identificazione nella base dati.
     * @var int
     */
    public int $id_servizio;
    /**
     * Nome del servizio.
     * @var string
     */
    public string $nome_servizio;
    /**
     * ID utilizzato nella base dati per gestire la relazione tra servizio e tariffa associata.
     * @var int
     */
    public int $id_costo;


    /**
     *COstruttore della classe.
     */
    public function __construct() {
    }

    /**
     * Restituisce l'ID del servizio.
     * @return int ID del servizio.
     */
    public function getIdServizio(): int {
        return $this->id_servizio;
    }

    /**
     *Imposta l'ID del servizio.
     * @param int $id_servizio Il nuovo ID del servizio.
     */
    public function setIdServizio(int $id_servizio): void {
        $this->id_servizio = $id_servizio;
    }

    /**
     * Restituisce il nome del servizio.
     * @return string Nome del servizio.
     */
    public function getNomeServizio(): string {
        return $this->nome_servizio;
    }

    /**
     * Imposta il nome del servizio.
     * @param string $nome_servizio Il nuovo nome.
     */
    public function setNomeServizio(string $nome_servizio): void {
        $this->nome_servizio = $nome_servizio;
    }

    /**
     * Restituisce l'ID della tariffa del servizio.
     * @return int ID della tariffa.
     */
    public function getIdCosto(): int {
        return $this->id_costo;
    }

    /**
     * Imposta l'ID della tariffa del servizio.
     * @param int $id_costo Il nuovo ID della tariffa.
     */
    public function setIdCosto(int $id_costo): void {
        $this->id_costo = $id_costo;
    }


}