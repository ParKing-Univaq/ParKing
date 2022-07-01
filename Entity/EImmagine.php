<?php

/**
 * Classe per la gestione dei file di tipo immagine.
 * @package Entity
 */
class EImmagine
{
    /**
     * ID dell'immagine per l'identificazione nella base dati.
     * @var int
     */
    public int $id_img;
    /**
     * Nome dell'immagine.
     * @var string
     */
    public string $nome;
    /**
     * Estensione dell'immagine.
     * @var string
     */
    public string $estensione;
    /**
     * Dimensione dell'immagine in KB.
     * @var int
     */
    public int $dimensione;
    /**
     * File dell'immagine.
     * @var string
     */
    public string $image;

    /**
     *Costruttore della classe.
     */
    public function __construct() {}

    /**
     * Imposta l'ID dell'immagine.
     * @param int $id_img Il nuovo ID.
     */
    public function setIdImg(int $id_img): void {
        $this->id_img = $id_img;
    }

    /**
     * Restituisce l'ID dell'immagine.
     * @return int ID associato all'immagine.
     */
    public function getIdImg(): int {
        return $this->id_img;
    }

    /**
     * Restituisce il nome dell'immagine.
     * @return string Nome dell'immagine.
     */
    public function getNome(): string {
        return $this->nome;
    }

    /**
     * Imposta il nome dell'immagine.
     * @param string $nome Il nuovo nome.
     */
    public function setNome(string $nome): void {
        $this->nome = $nome;
    }

    /**
     * Restituisce l'estensione dell'immagine.
     * @return string Estensione dell'immagine
     */
    public function getEstensione(): string {
        return $this->estensione;
    }

    /**
     * Imposta l'estensione dell'immagine.
     * @param string $estensione La nuova estensione.
     */
    public function setEstensione(string $estensione): void {
        $this->estensione = $estensione;
    }

    /**
     * Restituisce la dimensione in KB dell'immagine.
     * @return int La dimensione in KB.
     */
    public function getDimensione(): int {
        return $this->dimensione;
    }

    /**
     * Imposta la dimensione dell'immagine.
     * @param int $dimensione La nuova dimensione.
     */
    public function setDimensione(int $dimensione): void {
        $this->dimensione = $dimensione;
    }

    /**
     * Restituisce il file dell'immagine.
     * @return string Il file.
     */
    public function getImage(): string {
        return $this->image;
    }

    /**
     * Imposta il file dell'immagine.
     * @param string $image Il nuovo file.
     */
    public function setImage(string $image): void {
        $this->image = $image;
    }



}