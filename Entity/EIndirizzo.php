<?php

/**
 *Classe per la rappresentazione degli indirizzi.
 * @package Entity
 */
class EIndirizzo
{

    /**
     * ID dell'indirizzo per l'identificazione nella base dati.
     * @var int
     */
    public int $id_indirizzo;
    /**
     * Provincia dell'indirizzo.
     * @var string
     */
    public string $provincia;
    /**
     * Città dell'indirizzo.
     * @var string
     */
    public string $citta;
    /**
     * Via dell'indirizzo.
     * @var string
     */
    public string $via;
    /**
     * CAP dell'indirizzo.
     * @var int
     */
    public int $cap;
    /**
     * Numero civico dell'indirizzo.
     * @var string
     */
    public string $num_civico;


    /**
     *Costruttore della classe.
     */
    public function __construct(){}

    /**
     * Metodo che restituisce l'ID dell'indirizzo.
     * @return int ID associato all'indirizzo.
     */
    public function getId(): int {
        return $this->id_indirizzo;
    }

    /**
     * Restituisce la città dell'indirizzo.
     * @return string Città dell'indirizzo.
     */
    public function getCitta(): string {
        return $this->citta;
    }

    /**
     * Restituisce la provincia dell'indirizzo.
     * @return string Provincia dell'indirizzo.
     */
    public function getProvincia(): string {
        return $this->provincia;
    }

    /**
     * Restituisce la via dell'indirizzo.
     * @return string Via dell'indirizzo.
     */
    public function getVia(): string {
        return $this->via;
    }

    /**
     * Restituisce il numero civico dell'indirizzo.
     * @return string Numero civico dell'indirizzo.
     */
    public function getNumeroCivico(): string {
        return $this->num_civico;
    }

    /**
     * Restituisce il CAP dell'indirizzo.
     * @return int CAP dell'indirizzo.
     */
    public function getCAP(): int {
        return $this->cap;
    }

    /**
     * Imposta l'ID dell'indirizzo.
     * @param int $id Il nuovo ID.
     * @return void
     */
    public function setId(int $id): void {
        $this->id_indirizzo=$id;
    }

    /**
     * Imposta la provincia dell'indirizzo.
     * @param string $provincia La nuova provincia.
     * @return void
     */
    public function setProvincia(string $provincia): void {
        $this->provincia = $provincia;
    }

    /**
     * Imposta la città dell'indirizzo.
     * @param string $citta La nuova città.
     * @return void
     */
    public function setCitta(string $citta): void {
        $this->citta = $citta;
    }

    /**
     * Imposta la via dell'indirizzo.
     * @param string $via La nuova via.
     * @return void
     */
    public function setVia(string $via): void {
        $this->via = $via;
    }

    /**
     * Imposta il numero civico dell'indirizzo.
     * @param string $num Il nuovo numero civico.
     * @return void
     */
    public function setNumeroCivico(string $num): void {
        $this->num_civico = $num;
    }

    /**
     * Imposta il CAP dell'indirizzo.
     * @param int $cap Il nuovo CAP.
     * @return void
     */
    public function setCAP(int $cap): void {
        $this->cap = $cap;
    }
}
