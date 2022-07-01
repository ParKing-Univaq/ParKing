<?php

require_once "autoloader.php";

/**
 * Classe per gestire le operazioni sulla tabella "risposta" della base dati.
 * @package Foundation
 */
class FRisposta extends FDb
{
    /**
     *Costruttore della classe. Richiama il costruttore della superclasse _FDb_. Inizializza l'attributo $\_table con il nome della tabella, l'attributo $\_key con il nome della colonna che è chiave primaria per la tabella,
     * l'attributo $\_return\_class con il nome della classe _Entity_ associata alla classe _Foundation_ di cui crea le istanze e l'attributo $\_auto\_increment a true
     * se la chiave primaria si incrementa automaticamente, a false altrimenti.
     */
    protected function __construct() {
        parent::__construct();
        $this->_table='risposta';
        $this->_key='id_risposta';
        $this->_return_class='ERisposta';
        $this->_auto_increment = true;
    }

    public function store($object) {
        try {
            $this->_connection->beginTransaction();
            $idScrittore = $object->getScrittore()->getId();
            $idRiferimento = $object->getRiferimento()->getIdRecensione();

            $data_scrittura = $object->getDataScrittura();
            $strDataScrittura = $data_scrittura->format('Y-m-d H:i:s');

            $descrizione = $object->getDescrizione();

            $query = "INSERT INTO risposta (descrizione,id_gestore,id_recensione,data_scrittura) VALUES ('$descrizione',$idScrittore, $idRiferimento,'$strDataScrittura')";
            $this->query($query);

            $query = 'SELECT LAST_INSERT_ID() AS `id`';
            $this->query($query);
            $result = $this->getResultAssoc();
            $id = $result['id'];
            $object->setIdRisposta($id);
            $this->_connection->commit();
            $this->close();
        } catch (PDOException $e) {
            echo "Impossibile effettuare l'operazione:" . $e->getMessage()."\n";
            $this->_connection->rollBack();
            return null;
        }

    }

    public function load($key) {
    try {
        $this->_connection->beginTransaction();
        $result = parent::load($key);

        $this->convertDateTimeAttr($result);

        $idScrittore = $result->getIdGestore();
        $dbScr = FGestore::getInstance();
        $scrittore = $dbScr->load($idScrittore);
        $result->setScrittore($scrittore);

        $idRiferimento = $result->getIdRecensione();
        $dbR = FRecensione::getInstance();
        $riferimento = $dbR->load($idRiferimento);
        $result->setRiferimento($riferimento);

        $this->_connection->commit();
        $this->close();
        return $result;
        } catch (PDOException $e) {
            echo "Impossibile effettuare l'operazione:" . $e->getMessage()."\n";
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
            echo "Impossibile effettuare l'operazione:" . $e->getMessage()."\n";
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
            echo "Impossibile effettuare l'operazione:" . $e->getMessage()."\n";
            $this->_connection->rollBack();
            return null;
        }
    }
}