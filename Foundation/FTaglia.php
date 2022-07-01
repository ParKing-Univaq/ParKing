<?php

/**
 * Classe per gestire le operazioni sulla tabella "taglia" della base dati.
 * @package Foundation
 */
class FTaglia extends FDb
{
    /**
     *Costruttore della classe. Richiama il costruttore della superclasse _FDb_. Inizializza l'attributo $__table con il nome della tabella, l'attributo $\_key con il nome della colonna che è chiave primaria per la tabella,
     * l'attributo $__return_class con il nome della classe _Entity_ associata alla classe _Foundation_ di cui crea le istanze e l'attributo $\_auto\_increment a true
     * se la chiave primaria si incrementa automaticamente, a false altrimenti.
     */
    protected function __construct() {
        parent::__construct();
        $this->_table='taglia';
        $this->_key='id_taglia';
        $this->_return_class='ETaglia';
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

    /**
     * Restituisce un array contenente tutti gli ID delle taglie memorizzate nella base dati.
     * @return array|null Array di ID delle taglie.
     */
    public function getAllTaglie(){
        try {
            $this->_connection->beginTransaction();
            $query = "SELECT id_taglia FROM taglia";
            $this->query($query);
            $result = $this->getResult();
            $arrTaglie = array();
            foreach ($result as $key=>$value){
                array_push($arrTaglie, $value[0]);
            }
            $this->_connection->commit();
            $this->close();
            return $arrTaglie;
        } catch (PDOException $e) {
            echo "Impossibile effettuare l'operazione:" . $e->getMessage()."\n";
            $this->_connection->rollBack();
            return null;
        }
    }


}