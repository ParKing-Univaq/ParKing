<?php

require_once "autoloader.php";

/**
 * Classe per gestire le operazioni sulla tabella "postoauto" della base dati.
 * @package Foundation
 */
class FPostoAuto extends FDb{

    /**
     *Costruttore della classe. Richiama il costruttore della superclasse _FDb_. Inizializza l'attributo $\_table con il nome della tabella, l'attributo $\_key con il nome della colonna che è chiave primaria per la tabella,
     * l'attributo $\_return\_class con il nome della classe _Entity_ associata alla classe _Foundation_ di cui crea le istanze e l'attributo $\_auto\_increment a true
     * se la chiave primaria si incrementa automaticamente, a false altrimenti.
     */
    protected function __construct() {
        parent::__construct();
        $this->_table = 'postoauto';
        $this->_key = 'id_posto';
        $this->_auto_increment = true;
        $this->_return_class = 'EPostoAuto';
    }

    public function store($object){
        try {
            $this->_connection->beginTransaction();
            $tariffa = $object->getTariffaBase();
            $DB = FTariffa::getInstance();
            $DB->store($tariffa);

            $id_tar = $tariffa->getIdTariffa();
            $id_tag = $object->getTaglia()->getIdTaglia();
            $query = "INSERT INTO postoauto (id_taglia,id_tariffa_base) VALUES ('$id_tag', $id_tar)";
            $this->query("$query");

            $query = 'SELECT LAST_INSERT_ID() AS `id`';
            $this->query("$query");
            $result = $this->getResultAssoc();
            $id = $result['id'];

            $object->setIdPosto($id);

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

            $dbtag = FTaglia::getInstance();
            $tag = $dbtag->load($result->getIdTaglia());
            $result->setTaglia($tag);

            $dbtar = FTariffa::getInstance();
            $tar = $dbtar->load($result->getIdTariffaBase());
            $result->setTariffaBase($tar);

            $this->_connection->commit();
            $this->close();
            return $result;
        }
        catch (PDOException $e) {
            echo "Impossibile effettuare l'operazione:" . $e->getMessage()."\n";
            $this->_connection->rollBack();
            return null;
        }
    }
    public function update(object $object){
        try {
            $this->_connection->beginTransaction();
            $tariffa = $object->getTariffaBase();

            parent::update($object);

            $db = FTariffa::getInstance();
            $db->update($tariffa);

            $this->_connection->commit();
            $this->close();
        }
        catch (PDOException $e) {
            echo "Impossibile effettuare l'operazione:" . $e->getMessage()."\n";
            $this->_connection->rollBack();
            return null;
        }
    }

    public function delete($object)
    {
        try {
            $this->_connection->beginTransaction();
            $tar = $object->getIdTariffaBase();

            parent::delete($object);

            $query = "DELETE FROM `tariffa` WHERE `id_tariffa` = $tar";
            $this->query($query);

            $this->_connection->commit();
            $this->close();
        }catch (PDOException $e) {
                echo "Impossibile effettuare l'operazione:" . $e->getMessage()."\n";
                $this->_connection->rollBack();
                return null;
            }
        }

    /**
     * Restituisce un array contenente i posti di uno specifico parcheggio.
     * @param int $idParcheggio ID del parcheggio contenente i posti.
     * @return array Array di oggetti _EPostoAuto_
     */
    public function selectPostiByParcheggio(int $idParcheggio){
        $query = "SELECT id_posto FROM postiparcheggio WHERE id_parcheggio = $idParcheggio";
        $this->query($query);
        $ariIdPosto = $this->getResult();
        $arrPosti = array();
        foreach ($ariIdPosto as $k=>$id){
            $arrPosti[] = $this->load($id[0]);
        }
        return $arrPosti;
    }


    /**
     * Restituisce un array di posti liberi in un dato intervallo di tempo in un parcheggio.
     * @param int $id_parcheggio ID del parcheggio.
     * @param string $dataArr Data d'inizio intervallo.
     * @param string $dataPar Data di fine intervallo.
     * @return bool|array Array di oggetti _EPostoAuto_ risultanti, false se nessun posto è libero.
     */
    public function loadPostiLiberiParcheggio(int $id_parcheggio, string $dataArr, string $dataPar): bool|array {

        $query = "SELECT postoauto.id_posto, id_taglia, id_tariffa_base 
                        FROM postoauto
                        INNER JOIN postiparcheggio p on postoauto.id_posto = p.id_posto
                        INNER JOIN prenotazione p2 on postoauto.id_posto = p2.id_posto
                        WHERE id_parcheggio = '$id_parcheggio'
                        AND ('$dataArr' NOT BETWEEN data_inizio AND data_fine)
                        AND ('$dataPar' NOT BETWEEN data_inizio AND data_fine)
                        AND (data_fine NOT BETWEEN '$dataArr' AND '$dataPar')
                        AND (data_inizio NOT BETWEEN '$dataArr' AND '$dataPar')";
        $this->query($query);
        return $this->getObjectArray();
    }

    /**
     * Restituisce il numero di posti totali memorizzati nella base dati.
     * @return mixed|null
     */
    public function getTotale(){
        try {
            $this->_connection->beginTransaction();
            $query = "SELECT COUNT(id_posto) AS num FROM postoauto";
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