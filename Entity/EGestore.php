<?php

require_once "autoloader.php";

/**
 * Classe per rappresentare utenti di tipo gestore.
 * @package Entity
 */
class EGestore extends EUtente
{
    /**
     * @var int ID del gestore per l'identificazione nella base dati.
     */
    public int $id_gestore;

    /**
     * Costruttore della classe.
     */
    public function __construct(){
    }

    /**
     * Restituisce l'ID associato al gestore.
     * @return int ID associato.
     */
    public function getId(){
        return $this->id_gestore;
    }
    /**
     * Imposta l'ID associato al gestore.
     * @param int $id ID da associare.
     * @return void
     */
    public function setId(int $id): void {
        $this->id_gestore=$id;
    }

}