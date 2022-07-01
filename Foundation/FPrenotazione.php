<?php

require_once "autoloader.php";

/**
 * Classe per gestire le operazioni sulla tabella "prenotazione" della base dati.
 * @package Foundation
 */
class FPrenotazione extends FDb
{
    /**
     *Costruttore della classe. Richiama il costruttore della superclasse _FDb_. Inizializza l'attributo $\_table con il nome della tabella, l'attributo $\_key con il nome della colonna che è chiave primaria per la tabella,
     * l'attributo $\_return\_class con il nome della classe _Entity_ associata alla classe _Foundation_ di cui crea le istanze e l'attributo $\_auto\_increment a true
     * se la chiave primaria si incrementa automaticamente, a false altrimenti.
     */
    protected function __construct() {
        parent::__construct();
        $this->_table='prenotazione';
        $this->_key='id_prenotazione';
        $this->_return_class='EPrenotazione';
        $this->_auto_increment=true;
    }
    public function store($object)
    {
        try {
            $this->_connection->beginTransaction();
            $idcliente = $object->getUtilizzatore()->getId();
            $idp = $object->getPostoAuto()->getId();
            $dataInizio = $object->getDataInizio();
            $dataFine = $object->getDataFine();
            $strDataInizio = $dataInizio->format('Y-m-d H:i:s');
            $strDataFine = $dataFine->format('Y-m-d H:i:s');
            $object->getTotale();
            $fltotale = $object->totale;
            $query = "INSERT INTO prenotazione (id_utilizzatore,id_posto,data_inizio,data_fine,totale) VALUES ($idcliente, $idp,'$strDataInizio','$strDataFine', $fltotale)";
            $this->query("$query");

            $query = 'SELECT LAST_INSERT_ID() AS `id`';
            $this->query("$query");
            $result = $this->getResultAssoc();
            $id = $result['id'];
            $object->setIdPrenotazione($id);

            foreach ($object->getServiziOpzionali() as $k) {
                /*
                $className = get_class($k);
                $className = strtolower($className);
                $className = substr($className, 1);

                if ($className == 'servizioopzionale') {
                    $DB = FServizioOpzionale::getInstance();
                    $DB->store($k);
                }*/
                $ids = $k->getIdServizio();
                $idp = $object->getIdPrenotazione();
                $query = "INSERT INTO prenotazioneservizi (id_servizio,id_prenotazione) VALUES ($ids,$idp)";
                $this->query($query);
            }

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
            $dbScr = FCliente::getInstance();
            $idcli = $result->getIdUtilizzatore();
            $cliente = $dbScr->load($idcli);
            $dbp = FPostoAuto::getInstance();
            $idposto = $result->getIdPosto();
            $posto = $dbp->load($idposto);
            $result->setUtilizzatore($cliente);
            $result->setPostoAuto($posto);

            $idprenotazione = $result->getIdPrenotazione();

            $dbser = FServizioOpzionale::getInstance();
            $query = "SELECT id_servizio FROM prenotazioneservizi WHERE id_prenotazione = $idprenotazione";
            $this->query($query);

            $servizi = $this->getResult();

            foreach ($servizi as $servizio=>$idservizio){
                $result->addServizio($dbser->load($idservizio[0]));
            }

            $this->_connection->commit();
            $this->close();
            return $result;
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
    public function delete($object) {
        try {
            $this->_connection->beginTransaction();
            $idPrenotazione = $object->getIdPrenotazione();
            $query= "DELETE FROM prenotazioneservizi WHERE id_prenotazione = $idPrenotazione";
            $this->query($query);
            parent::delete($object);

            $this->_connection->commit();
            $this->close();
        } catch (PDOException $e) {
            echo "Impossibile effettuare l'operazione:" . $e->getMessage() . "\n";
            $this->_connection->rollBack();
            return null;
        }
    }

    /**
     * Restituisce le prenotazioni concluse alla data odierna di uno specifico cliente.
     * @param int $idCliente ID del cliente.
     * @return array Array associativo nel formato ["Nome del parcheggio" => "oggetti _EPrenotazione_ che rappresentano le prenotazioni in quel parcheggio"]
     */
    public function selectPrenotazioniConcluseByCliente(int $idCliente)
    {
        $dataCorrente =  new DateTime();
        $strDataCorrente= $dataCorrente->format('Y-m-d H:i:s');

        $query = "SELECT id_prenotazione, nome_parcheggio
                    FROM prenotazione AS p 
                        INNER JOIN postiparcheggio AS p1 ON p.id_posto = p1.id_posto 
                        INNER JOIN parcheggio AS p2 ON p1.id_parcheggio = p2.id_parcheggio 
                    WHERE id_utilizzatore = $idCliente AND data_fine < NOW()";
        $this->query($query);

        $arrPrenotazioni = array();
        $result = $this->getResult();


        foreach ($result as $k=>$valore){
            $arrPrenotazioni[$valore[1]][] = self::load($valore[0]);
        }

        return $arrPrenotazioni;

    }

    /**
     * Restituisce le prenotazioni future alla data odierna di uno specifico cliente.
     * @param int $idCliente ID del cliente.
     * @return array Array associativo nel formato ["Nome del parcheggio" => "oggetti _EPrenotazione_ che rappresentano le prenotazioni in quel parcheggio"]
     */
    public function selectPrenotazioniFutureByCliente(int $idCliente)
    {
        $dataCorrente =  new DateTime();
        $strDataCorrente = $dataCorrente->format('Y-m-d H:i:s');

        $query = "SELECT DISTINCT id_prenotazione, nome_parcheggio 
                    FROM prenotazione AS p 
                        INNER JOIN postiparcheggio AS p1 ON p.id_posto = p1.id_posto 
                        INNER JOIN parcheggio AS p2 ON p1.id_parcheggio = p2.id_parcheggio 
                    WHERE id_utilizzatore = $idCliente AND data_inizio > '$strDataCorrente'";
        $this->query($query);

        $arrPrenotazioni = array();
        $result = $this->getResult();

        foreach ($result as $k=>$valore){
            $arrPrenotazioni[$valore[1]][] = self::load($valore[0]);
        }

        return $arrPrenotazioni;

    }


    /**
     * Restituisce il numero totale delle prenotazioni memorizzate sulla base dati.
     * @return mixed|null
     */
    public function getTotale(){
        try {
            $this->_connection->beginTransaction();
            $query = "SELECT COUNT(id_prenotazione) AS num FROM prenotazione";
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