<?php
require_once "autoloader.php";

/**
 * Classe per gestire le operazioni sulla tabella "servizio" della base dati.
 * @package Foundation
 */
class FServizio extends FDb
{
    /**
     *Costruttore della classe. Richiama il costruttore della superclasse _FDb_. Inizializza l'attributo $\_auto\_increment a true
     * se la chiave primaria si incrementa automaticamente, a false altrimenti.
     */
    protected function __construct() {
        parent::__construct();
        $this->_auto_increment = true;
    }
    public function store($object)
    {
        $className = get_class($object);
        $className = strtolower($className);
        $className = substr($className, 1);

        if ($className == 'servizio') {
            $query = "INSERT INTO servizio (is_incluso,is_opzionale) VALUES ('T','F')";
        }
        if ($className == 'servizioopzionale') {
            $query = "INSERT INTO servizio (is_incluso,is_opzionale) VALUES ('F','T')";
        }

        $this->query("$query");

        $query='SELECT LAST_INSERT_ID() AS `id_servizio`';
        $this->query("$query");
        $result = $this->getResultAssoc();
        $id_servizio = $result['id_servizio'];
        $object->setIdServizio($id_servizio);

        parent::store($object);
    }

    public function delete($object)
    {
        $id = $object->getIdServizio();
        $query = "DELETE FROM servizio WHERE id_servizio = $id";
        $this->query("$query");
        parent::delete($object);

    }
}