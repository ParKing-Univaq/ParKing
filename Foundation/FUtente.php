<?php

require_once "autoloader.php";

/**
 * Classe per gestire le operazioni sulla tabella "utente" della base dati.
 * @package Foundation
 */
class FUtente extends FDb
{
    /**
     *Costruttore della classe. Richiama il costruttore della superclasse _FDb_. Inizializza l'attributo $\_auto\_increment a true
     * se la chiave primaria si incrementa automaticamente, a false altrimenti.
     */
    protected function __construct() {
        parent::__construct();
        $this->_auto_increment=true;
    }

    public function store($object)
    {
        try {
            $this->_connection->beginTransaction();
            $DbImg = FImmagine::getInstance();
            $DbImg->store($object->getImg());
            $className = get_class($object);
            $className = strtolower($className);
            $className = substr($className, 1);

            if ($className == 'amministratore') {
                $query = "INSERT INTO utente (is_gestore,is_cliente, is_amministratore) VALUES ('F','F','T')";
            }
            if ($className == 'gestore') {
                $query = "INSERT INTO utente (is_gestore,is_cliente, is_amministratore) VALUES ('T','F','F')";
            }
            if ($className == 'cliente') {
                $query = "INSERT INTO utente(is_gestore,is_cliente, is_amministratore) VALUES ('F','T','F')";
            }

            $this->query("$query");


            $query='SELECT LAST_INSERT_ID() AS `id`';
            $this->query("$query");
            $result = $this->getResultAssoc();
            $id=$result['id'];

            $object->setId($id);

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
            $arrayObject=get_object_vars($object);
            $DbImg = FImmagine::getInstance();
            $DbImg->delete($object->getImg());
            parent::delete($object);
            $query='DELETE ' .
                'FROM utente ' .
                'WHERE `id_utente` = \''.$arrayObject[$this->_key].'\'';
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
            $DbImg = FImmagine::getInstance();
            $resultImg = $DbImg->load($result->getIdImg());
            $result->setImg($resultImg);
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
     * Restituisce l'oggetto di una delle sottoclassi di _EUtente_ appropriata, in base alle sue credenziali di accesso.
     * @param string $email Email di accesso dell'utente.
     * @param string $password Password di accesso dell'utente.
     * @return null null se non esiste un utente associato alle credenziali.
     */
    public function loadLogin(string $email, string $password){
            $password = md5($password);

            $query = "SELECT id_cliente AS id FROM cliente WHERE email='$email'AND password='$password'";
            $this->query($query);

            $idc=$this->getResultAssoc();

        if($idc!= null){
            $dbCliente = FCliente::getInstance();
            return $dbCliente->load($idc["id"]);
        }else {
            $query = "SELECT id_gestore AS id FROM gestore WHERE email='$email'AND password='$password'";
            $this->query($query);

            $idg = $this->getResultAssoc();
            if ($idg != null) {
                $dbGestore = FGestore::getInstance();
                return $dbGestore->load($idg["id"]);

            } else {
                $query = "SELECT id_amministratore AS id FROM amministratore WHERE email='$email'AND password='$password'";
                $this->query($query);

                $ida = $this->getResultAssoc();

                if ($ida != null) {
                    $dbAmministratore = FAmministratore::getInstance();
                    return $dbAmministratore->load($ida["id"]);
                }
                return null;
            }
        }
    }
}