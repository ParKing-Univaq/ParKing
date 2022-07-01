<?php

require_once "autoloader.php";

/**
 * Classe per gestire le operazioni sulla tabella "recensione" della base dati.
 * @package Foundation
 */
class FRecensione extends FDb
{
    /**
     *Costruttore della classe. Richiama il costruttore della superclasse _FDb_. Inizializza l'attributo $\_table con il nome della tabella, l'attributo $\_key con il nome della colonna che è chiave primaria per la tabella,
     * l'attributo $\_return\_class con il nome della classe _Entity_ associata alla classe _Foundation_ di cui crea le istanze e l'attributo $\_auto\_increment a true
     * se la chiave primaria si incrementa automaticamente, a false altrimenti.
     */
    protected function __construct() {
        parent::__construct();
        $this->_table='recensione';
        $this->_key='id_recensione';
        $this->_return_class='ERecensione';
        $this->_auto_increment = true;
    }

    public function store($object) {
        try {
            $this->_connection->beginTransaction();
            $idScrittore = $object->getScrittore()->getId();
            $idRiferimento = $object->getRiferimento()->getIdPrenotazione();

            $valutazione = $object->getValutazione();
            $descrizione = $object->getDescrizione();
            $data_scrittura = $object->getDataScrittura();
            $strDataScrittura = $data_scrittura->format('Y-m-d H:i:s');

            $query = "INSERT INTO recensione (valutazione,descrizione,id_scrittore,id_riferimento,data_scrittura) VALUES ($valutazione,'$descrizione',$idScrittore, $idRiferimento, '$strDataScrittura')";
            $this->query($query);

            $query = 'SELECT LAST_INSERT_ID() AS `id`';
            $this->query($query);
            $result = $this->getResultAssoc();
            $id = $result['id'];
            $object->setIdRecensione($id);
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
            $idScrittore = $result->getIdScrittore();
            $dbScr = FCliente::getInstance();
            $scrittore = $dbScr->load($idScrittore);
            $result->setScrittore($scrittore);


            $idRiferimento = $result->getIdRiferimento();
            $dbPrn = FPrenotazione::getInstance();
            $riferimento = $dbPrn->load($idRiferimento);
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
            $idRecensione = $object->getIdRecensione();
            $query = "DELETE FROM `risposta` WHERE `id_recensione` = '$idRecensione'";
            $this->query($query);
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

    /**
     * Restituisce un array associativo contenente informazioni sulle recensioni di ogni parcheggio scritte in uno specifico intervallo di date.
     * @param string $data1 Data d'inizio intervallo.
     * @param string $data2 Data di fine intervallo
     * @return bool|array Array nel formato ["nome del parcheggio","oggetto _ERecensione_"]
     */
    public function searchByData(string $data1, string $data2): bool|array {

        $query = "SELECT id_recensione, nome_parcheggio FROM recensione AS r INNER JOIN prenotazione AS p ON r.id_riferimento=p.id_prenotazione INNER JOIN postiparcheggio AS p1 ON p.id_posto = p1.id_posto INNER JOIN parcheggio AS p2 ON p1.id_parcheggio = p2.id_parcheggio WHERE r.data_scrittura BETWEEN '$data1' AND '$data2'";
        $this->query($query);
        $arrRecensioni = array();
        $result = $this->getResult();
        if($result) {
            foreach ($result as $k => $valore) {
                $arrRecensioni[] = array($valore[1], self::load($valore[0]));
            }
            return $arrRecensioni;
        }else{
            return false;
        }
    }

    /**
     * Restituisce un array contenente tutte le recensioni relative a un determinato parcheggio.
     * @param int $idParcheggio ID del parcheggio.
     * @return array|bool Array associativo
     */
    public function searchByParcheggio(int $idParcheggio):array|bool{
        $query = "SELECT DISTINCT max(id_recensione),id_scrittore
                    FROM recensione AS r
                    INNER JOIN prenotazione AS p1 ON r.id_riferimento=p1.id_prenotazione
                    INNER JOIN postiparcheggio AS p2 ON p1.id_posto=p2.id_posto
                    WHERE p2.id_parcheggio=$idParcheggio
                    GROUP BY id_scrittore";
        $this->query($query);
        $arrRecensioni = false;
        $result = $this->getResult();
        if ($result) {
            foreach ($result as $key => $value) {
                $arrRecensioni[] = self::load($value[0]);
            }
        }
        return $arrRecensioni;
    }

    /**
     * Restituisce un array contenente tutte le recensioni relative a un determinato cliente.
     * @param int $idCliente ID del cliente.
     * @return array Array associativo nel formato ["nome del parcheggio" => "recensione"]
     */
    public function searchByCliente(int $idCliente):array{
        $query = "SELECT id_recensione, nome_parcheggio FROM recensione AS r INNER JOIN prenotazione AS p ON r.id_riferimento=p.id_prenotazione INNER JOIN postiparcheggio AS p1 ON p.id_posto = p1.id_posto INNER JOIN parcheggio AS p2 ON p1.id_parcheggio = p2.id_parcheggio WHERE r.id_scrittore=$idCliente";
        $this->query($query);
        $arrRecensioni = array();
        $result = $this->getResult();
        foreach ($result as $k=>$valore){
            $arrRecensioni[$valore[1]] = self::load($valore[0]);
        }
        return $arrRecensioni;
    }
}