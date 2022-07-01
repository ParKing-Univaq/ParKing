<?php

require_once "autoloader.php";
/**
 * Classe per la gestione delle operazioni nella base dati.
 * @access public
 * @package Foundation
 */
class FDb {
    /**
     * @var Object che mantiene la singola istanza della classe
    */
    private static $instances = array();
    /**
    *@var PDO Variabile di connessione al database
     */
    protected $_connection;

    /**
     * @var false|PDOStatement Variabile contenente il risultato dell'ultima query
     */
    protected $_result;
    /**
     * @var string Variabile contenente il nome della tabella
     */
    protected $_table;
    /**
     * @var string Variabile contenente la chiave della tabella
     */
    protected $_key;
    /**
     * @var string Variabile contenente il tipo di classe da restituire
     */
    protected $_return_class;
    /**
     * @var boolean Variabile booleana per indicare se la tabella ha chiave incrementale o meno
     */
    protected $_auto_increment = false;

    /**
     * Costruttore. Inizializza la connessione verso la base dati e assegna all'attributo $_connection l'handle dell'oggetto PDO corrispondente
     */
    protected function __construct() {
        require 'config_db.php';

        $this->_connection = new PDO ($dsn,$user,$pass);
    }

    /**
     * Restituisce un'istanza della classe connessa alla base dati
     * @return Object
     */

    public static function getInstance() {

        $className=get_called_class();

        if( ! isset(self::$instances[$className]) ) {
            try {
                self::$instances[$className]= new $className;
            } catch (PDOException $e) {
                error_log($e);
                exit('Something bad happened');
            }
        }

        return self::$instances[$className];
    }
    

    /**
     * Effettua una query al database
     * @param string $query Query da effettuare.
     * @return boolean true se l'operazione è andata a buon fine.
     */
    public function query(string $query) {
        try {
            $stmt = $this->_connection->prepare($query);
            $stmt->execute();
            $this->_result = $stmt;

            return true;
        } catch (PDOException $e) {
            echo "Impossibile effettuare la query al database:" . $e->getMessage()."\n";
            return null;
        }

    }
    /**
     * Estrae dall'attributo $__result i risultati restituendoli in un array associativo.
     * @return array Array associativo dei risultati.
     */
    public function getResultAssoc() {

        $result = false;

        if( $this->_result->rowCount() > 0){

            $result = $this->_result->fetch(PDO::FETCH_ASSOC);

        }

        return $result;

    }
    /**
     * Estrae dall'attributo $__result i risultati restituendoli in un array con indici numerici.
     *
     * @return array Array dei risultati.
     */
    public function getResult() {
        $result = false;

        if( $this->_result->rowCount() > 0){

            $result = $this->_result->fetchAll(PDO::FETCH_NUM);

        }

        return $result;

    }
    /**
     * Estrae dall'attributo $__result il risultato in un oggetto della classe _Entity_ associata alla classe _Foundation_ chiamante.
     * @return Object Oggetto della classe _Entity_ associata.
     */
    public function getObject() {
        $result = false;

        if( $this->_result->rowCount() > 0){

            $result = $this->_result->fetchAll(PDO::FETCH_CLASS,$this->_return_class)[0];

        }

        return $result;

    }
    /**
     * Metodo che estrae dall'attributo $__result i risultati un array contenente oggetti della classe Entity associata alla classe Foundation chiamante.
     *
     * @return array Array contenente oggetti della classe Entity associata.
     */
    public function getObjectArray() {

        $result = false;

        if( $this->_result->rowCount() > 0){

            $result = $this->_result->fetchAll(PDO::FETCH_CLASS, $this->_return_class);

        }

        return $result;

    }

    /**
     * Effettua la chiusure della connessione al database.
     */
    public function close() {

        unset(self::$instances[get_called_class()]);

    }
    /**
     * Memorizza sul database lo stato di un oggetto
     *
     * @param object $object Oggetto da memorizzare.
     * @return boolean
     */
    public function store(object $object) {
        $i=0;
        $values='';
        $fields='';
        // scorre gli attributi dell'oggetto  e contruisce le chiavi->valore per la query
        foreach ($object as $key=>$value) {
            if (!($this->_auto_increment && $key == $this->_key) && !str_starts_with($key, '_') && $value!= null) { //vedere se inizia con _ significa vedere se è un'oggetto
                if ($i==0) {
                    $fields.='`'.$key.'`';
                    $values.='\''.$value.'\'';
                } else {
                    $fields.=', `'.$key.'`';
                    $values.=', \''.$value.'\'';
                }
                $i++;
            }
        }
        $fields=strtolower($fields);
        $query='INSERT INTO '.$this->_table.' ('.$fields.') VALUES ('.$values.')';
        $this->query("$query");
        // sincronizza id nel DB con l'id dell'istanza
        if ($this->_auto_increment) {
            $query='SELECT LAST_INSERT_ID() AS `id`';
            $this->query("$query");
            $result = $this->getResultAssoc();
            return $result['id'];
        } else {
            return null;
        }
    }

    /**
     * Carica in un oggetto lo stato dal database
     *
     * @param int $key ID dell'oggetto da caricare.
     * @return boolean
     */
    public function load($key) {
        $query='SELECT * ' .
            'FROM `'.$this->_table.'` ' .
            'WHERE `'.$this->_key.'` = \''.$key.'\'';
        $this->query($query);

        return $this->getObject();
    }
    /**
     * Cancella dal database lo stato di un oggetto
     *
     * @param object $object Oggetto da cancellare.
     * @return boolean
     */
    public function delete(object $object) {
        $arrayObject = get_object_vars($object);
        $arrayObject = array_change_key_case($arrayObject,CASE_LOWER);
        $query='DELETE ' .
            'FROM `'.$this->_table.'` ' .
            'WHERE `'.$this->_key.'` = \''.$arrayObject[$this->_key].'\'';
        unset($object);
        return $this->query($query);
    }
    /**
     * Aggiorna sul database lo stato di un oggetto
     *
     * @param object $object Oggetto da aggiornare.
     * @return boolean
     */
    public function update(object $object) {
        $i=0;
        $fields='';
        foreach ($object as $key=>$value) {
            if (!($key == $this->_key) && !str_starts_with($key, '_') && $value!= null) {
                if ($i==0) {
                    $fields.='`'.$key.'` = \''.$value.'\'';
                } else {
                    $fields.=', `'.$key.'` = \''.$value.'\'';
                }
                $i++;
            }
        }
        $arrayObject=get_object_vars($object);
        $arrayObject=array_change_key_case($arrayObject,CASE_LOWER);
        $query='UPDATE `'.$this->_table.'` SET '.$fields.' WHERE `'.$this->_key.'` = \''.$arrayObject[$this->_key].'\'';
        return $this->query($query);
    }
    /**
     * Effettua una ricerca sul database utilizzando i parametri passati.
     *
     * @param array $parametri Array nel formato [["nome della colonna","operatore","variabile da comparare"] ,["nome della colonna","operatore","variabile da comparare"], ...]
     * @param string $ordinamento Nome della colonna per il quale si vuole ordinare la ricerca.
     * @param string $limit Numero massimo di risultati da estrarre.
     * @return array|false Array contenente come risultati oggetti della classe Entity associata alla classe Foundation richiamante il metodo, false se non c'è alcun risultato.
     *
     */
    function search(array $parametri = array(), string $ordinamento = '', string $limit = '')
    {
        $filtro='';
        for ($i=0; $i<count($parametri); $i++)
        {
            if ($i>0) $filtro .= ' AND';
            $filtro .= ' `'.$parametri[$i][0].'` '.$parametri[$i][1].' \''.$parametri[$i][2].'\'';// nome colonna, operatore, variabile: nome = 'Matteo'
        }
        $query='SELECT * ' .
            'FROM `'.$this->_table.'` ';
        if ($filtro != '')
            $query.='WHERE '.$filtro.' ';
        if ($ordinamento!='')
            $query.='ORDER BY '.$ordinamento.' ';
        if ($limit != '')
            $query.='LIMIT '.$limit.' ';
        $this->query($query);

        return $this->getObjectArray();
    }


    /**
     * Imposta gli attributi "data" degli oggetti passati come parametro a oggetti di tipo _DateTIme_.
     * @param object $object Oggetto del quale si vogliono convertire gli attributi.
     * @return void
     */
    public function convertDateTimeAttr(object $object){
        foreach ($object as $attr=>$value){
            if (str_starts_with($attr,'data')){
                try {
                    $value = new DateTime($value);
                } catch (Exception $e) {
                    print($e->getMessage());
                }
            }
        }
    }

}

?>


