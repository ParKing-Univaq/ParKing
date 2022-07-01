<?php

require_once "autoloader.php";

/**
 * Classe per gestire le operazioni sulla tabella "cliente" della base dati.
 * @package Foundation
 */
class FCliente extends FUtente
{
    /**
     *Costruttore della classe. Richiama il costruttore della superclasse _FDb_. Inizializza l'attributo $\_table con il nome della tabella, l'attributo $\_key con il nome della colonna che è chiave primaria per la tabella,
     * l'attributo $\_return\_class con il nome della classe _Entity_ associata alla classe _Foundation_ di cui crea le istanze e l'attributo $\_auto\_increment a true
     * se la chiave primaria si incrementa automaticamente, a false altrimenti.
     */
    protected function __construct()
    {
        parent::__construct();
        $this->_table = 'cliente';
        $this->_key = 'id_cliente';
        $this->_return_class = 'ECliente';
        $this->_auto_increment=false;
    }

    /**
     * Restituisce il numero totale di clienti memorizzati nella base dati.
     * @return mixed|null
     */
    public function getTotale(){
        try {
            $this->_connection->beginTransaction();
            $query = "SELECT COUNT(id_cliente) AS num FROM cliente";
            $this->query($query);
            $assoc = $this->getResultAssoc();
            $result = $assoc['num'];
            $this->_connection->commit();
            $this->close();
            return $result;
        } catch (PDOException $e) {
            echo "Impossibile effettuare l'operazione:" . $e->getMessage()."\n";
            $this->_connection->rollBack();
            return null;
        }

    }

}