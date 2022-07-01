<?php

require_once "autoloader.php";

/**
 * Classe per rappresentare utenti di tipo cliente.
 * @package Entity
 */
class ECliente extends EUtente
{
    /**
     *
     * @var int ID del cliente per l'identificazione nella base dati.
     */
    public int $id_cliente;

    /**
     * Costruttore della classe.
     */
    public function __construct(){
    }

    /**
     * Restituisce l'ID associato al cliente.
     * @return int ID associato.
     */
    public function getId(): int {
        return $this->id_cliente;
    }
    /**
     * Imposta l'ID associato al cliente.
     * @param int $id ID da associare.
     * @return void
     */
    public function setId(int $id): void {
        $this->id_cliente=$id;
    }

}