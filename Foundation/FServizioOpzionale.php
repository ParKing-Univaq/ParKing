<?php

require_once "autoloader.php";

/**
 * Classe per gestire le operazioni sulla tabella "servizioopzionale" della base dati.
 * @package Foundation
 */
class FServizioOpzionale extends FServizio
{
    /**
     *Costruttore della classe. Richiama il costruttore della superclasse _FDb_. Inizializza l'attributo $\_table con il nome della tabella, l'attributo $\_key con il nome della colonna che è chiave primaria per la tabella,
     * l'attributo $\_return\_class con il nome della classe _Entity_ associata alla classe _Foundation_ di cui crea le istanze e l'attributo $\_auto\_increment a true
     * se la chiave primaria si incrementa automaticamente, a false altrimenti.
     */
    protected function __construct() {
        parent::__construct();
        $this->_table = 'servizioopzionale';
        $this->_key = 'id_servizio';
        $this->_auto_increment = false;
        $this->_return_class = 'EServizioOpzionale';
    }

    public function store($object)
    {
        try {
            $this->_connection->beginTransaction();
            $tariffa = $object->getCosto();
            $DB = FTariffa::getInstance();
            $DB->store($tariffa);
            parent::store($object);
            $id_tar = $tariffa->getIdTariffa();
            $id_ser = $object->getIdServizio();
            $query = "UPDATE servizioopzionale SET id_costo = $id_tar WHERE id_servizio = $id_ser";
            $this->query("$query");
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
            $idCosto = $result->getIdCosto();
            $dbTariffa = FTariffa::getInstance();
            $tariffa = $dbTariffa->load($idCosto);
            $result->setCosto($tariffa);
            $this->_connection->commit();
            $this->close();
            return $result;
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
            $tariffa = $object->getIdCosto();
            parent::delete($object);
            $query = "DELETE FROM `tariffa` WHERE `id_tariffa` = $tariffa";
            $this->query($query);
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
            $tariffa = $object->getCosto();
            $dbT = FTariffa::getInstance();
            parent::update($object);
            $dbT->update($tariffa);
            $this->_connection->commit();
            $this->close();
        } catch (PDOException $e) {
            echo "Impossibile effettuare l'operazione:" . $e->getMessage()."\n";
            $this->_connection->rollBack();
            return null;
        }
    }

}