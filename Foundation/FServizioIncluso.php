<?php

require_once "autoloader.php";
/**
 * Classe per gestire le operazioni sulla tabella "servizioincluso" della base dati.
 * @package Foundation
 */
class FServizioIncluso extends FServizio
{
    /**
     *Costruttore della classe. Richiama il costruttore della superclasse _FDb_. Inizializza l'attributo $\_table con il nome della tabella, l'attributo $\_key con il nome della colonna che è chiave primaria per la tabella,
     * l'attributo $\_return\_class con il nome della classe _Entity_ associata alla classe _Foundation_ di cui crea le istanze e l'attributo $\_auto\_increment a true
     * se la chiave primaria si incrementa automaticamente, a false altrimenti.
     */
    protected function __construct() {
        parent::__construct();
        $this->_table = 'servizioincluso';
        $this->_key = 'id_servizio';
        $this->_auto_increment = false;
        $this->_return_class = 'EServizio';
    }
    public function store($object)
    {
        try {
            $this->_connection->beginTransaction();
            parent::store($object);
            $this->_connection->commit();
            $this->close();
        } catch (PDOException $e) {
            echo "Impossibile effettuare l'operazione:" . $e->getMessage()."\n";
            $this->_connection->rollBack();
            return null;
        }
    }
    public function delete($object)
    {
        try {
            $this->_connection->beginTransaction();
            parent::delete($object);
            $this->_connection->commit();
            $this->close();
        } catch (PDOException $e) {
            echo "Impossibile effettuare l'operazione:" . $e->getMessage()."\n";
            $this->_connection->rollBack();
            return null;
        }
    }
    public function update(object $object)
    {
        try {
            $this->_connection->beginTransaction();

            parent::update($object);

            $this->_connection->commit();
            $this->close();
        } catch (PDOException $e) {
            echo "Impossibile effettuare l'operazione:" . $e->getMessage()."\n";
            $this->_connection->rollBack();
            return null;
        }
    }
    public function load($key)
    {
        try {
            $this->_connection->beginTransaction();
            $result = parent::load($key);
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