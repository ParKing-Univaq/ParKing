<?php

require_once "autoloader.php";

/**
 * Classe per rappresentare utenti di tipo amministratore.
 * @package Entity
 */
class EAmministratore extends EUtente
{
    /**
     * ID dell'amministratore per l'identificazione nella base dati.
     * @var int
     */
    public int $id_amministratore;

    /**
     * Costruttore della classe.
     */
    public function __construct(){
    }

    /**
     * Restituisce l'ID associato all'amministratore.
     * @return int ID associato.
     */
    public function getId(): int {
        return $this->id_amministratore;

    }

    /**
     * Imposta l'ID associato all'amministratore.
     * @param int $id ID da associare.
     * @return void
     */
    public function setId(int $id): void {
        $this->id_amministratore=$id;
    }

}