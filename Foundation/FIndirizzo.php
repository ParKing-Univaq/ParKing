<?php

/**
 * Classe per gestire le operazioni sulla tabella "indirizzo" della base dati.
 * @package Foundation
 */
class FIndirizzo extends FDb
{
    /**
     *Costruttore della classe. Richiama il costruttore della superclasse _FDb_. Inizializza l'attributo $\_table con il nome della tabella, l'attributo $\_key con il nome della colonna che è chiave primaria per la tabella,
     * l'attributo $\_return\_class con il nome della classe _Entity_ associata alla classe _Foundation_ di cui crea le istanze e l'attributo $\_auto\_increment a true
     * se la chiave primaria si incrementa automaticamente, a false altrimenti.
     */
    protected function __construct() {
        parent::__construct();
        $this->_table='indirizzo';
        $this->_key='id_indirizzo';
        $this->_return_class='EIndirizzo';
        $this->_auto_increment=true;
    }
    public function store($object)
    {
        try {
            $this->_connection->beginTransaction();
            $id = parent::store($object);
            $this->_connection->commit();
            $this->close();
        } catch (PDOException $e) {
            echo "Impossibile effettuare la query al database:" . $e->getMessage() . "\n";
            $this->_connection->rollBack();
            return null;
        }
        $object->setId($id);
    }

    public function load($key) {
        try {
            $this->_connection->beginTransaction();
            $result = parent::load($key);
            $this->_connection->commit();
            $this->close();
            return $result;
        } catch (PDOException $e) {
            echo "Impossibile effettuare la query al database:" . $e->getMessage() . "\n";
            $this->_connection->rollBack();
            return null;
        }
    }

    public function update(object $object) {
        try {
            $this->_connection->beginTransaction();
            parent::update($object);
            $this->_connection->commit();
            $this->close();
        } catch (PDOException $e) {
            echo "Impossibile effettuare la query al database:" . $e->getMessage() . "\n";
            $this->_connection->rollBack();
            return null;
        }
    }

    public function delete($object) {
        try {
            $this->_connection->beginTransaction();
            parent::delete($object);
            $this->_connection->commit();
            $this->close();
        } catch (PDOException $e) {
            echo "Impossibile effettuare la query al database:" . $e->getMessage() . "\n";
            $this->_connection->rollBack();
            return null;
        }
    }
}