<?php

require_once "autoloader.php";


/**
 * Classe per gestire le operazioni sulla tabella "amministratore" della base dati.
 * @package Foundation
 */
class FAmministratore extends FUtente
{
    /**
     *Costruttore della classe. Richiama il costruttore della superclasse _FDb_. Inizializza l'attributo $\_table con il nome della tabella, l'attributo $\_key con il nome della colonna che è chiave primaria per la tabella,
     * l'attributo $\_return\_class con il nome della classe _Entity_ associata alla classe _Foundation_ di cui crea le istanze e l'attributo $\_auto\_increment a true
     * se la chiave primaria si incrementa automaticamente, a false altrimenti.
     */
    protected function __construct() {
        parent::__construct();
        $this->_table='amministratore';
        $this->_key='id_amministratore';
        $this->_return_class='EAmministratore';
        $this->_auto_increment = false;
    }

}