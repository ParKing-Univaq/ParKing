<?php

require_once "autoloader.php";
/**
 * Classe per gestire le operazioni sulla tabella "parcheggio" della base dati.
 * @package Foundation
 */
class FParcheggio extends FDb
{
    /**
     *Costruttore della classe. Richiama il costruttore della superclasse _FDb_. Inizializza l'attributo $\_table con il nome della tabella, l'attributo $\_key con il nome della colonna che è chiave primaria per la tabella,
     * l'attributo $\_return\_class con il nome della classe _Entity_ associata alla classe _Foundation_ di cui crea le istanze e l'attributo $\_auto\_increment a true
     * se la chiave primaria si incrementa automaticamente, a false altrimenti.
     */
    protected function __construct() {
        parent::__construct();
        $this->_table='parcheggio';
        $this->_key='id_parcheggio';
        $this->_return_class='EParcheggio';
        $this->_auto_increment=true;
    }

    public function store($object) {
        try {
            $this->_connection->beginTransaction();
            $i=FIndirizzo::getInstance();
            $i->store($object->getIndirizzo());

            $orario_apertura = $object->getOrarioApertura();
            $orario_chiusura = $object->getOrarioChiusura();

            $id_proprietario = $object->getGestore()->getId() ;
            $id_locazione =  $object->getIndirizzo()->getId() ;
            $nome = $object->getNomeParcheggio();

            $descrizione = $object->getDescrizione();

            $query = "INSERT INTO parcheggio (nome_parcheggio,id_proprietario,id_locazione,orario_apertura,orario_chiusura,descrizione) VALUES ('$nome', $id_proprietario, $id_locazione,$orario_apertura,$orario_chiusura,'$descrizione')";
            $this->query("$query");

            $query = 'SELECT LAST_INSERT_ID() AS `id`';
            $this->query("$query");
            $result = $this->getResultAssoc();
            $id = $result['id'];
            $object->setId($id);

            foreach ($object->getPosti() as $k) {

                $DB = FPostoAuto::getInstance();
                $DB->store($k);

                $idpa = $k->getId();
                $idp = $object->getId();
                $query = "INSERT INTO postiparcheggio (id_posto, id_parcheggio) VALUES ($idpa,$idp)";
                $this->query($query);
            }

            foreach ($object->getServizi() as $k) {

                $className = get_class($k);
                $className = strtolower($className);
                $className = substr($className, 1);

                if ($className == 'servizio') {
                    $DB = FServizioIncluso::getInstance();
                    $DB->store($k);
                }
                if ($className == 'servizioopzionale') {
                    $DB = FServizioOpzionale::getInstance();
                    $DB->store($k);
                }
                $ids = $k->getIdServizio();
                $idp = $object->getId();
                $query = "INSERT INTO parcheggioservizi (id_servizio,id_parcheggio) VALUES ($ids,$idp)";
                $this->query($query);
            }

            $DbImg = FImmagine::getInstance();

            foreach ($object->getImmagini() as $img){

                $DbImg->store($img);
                $idImg = $img->getIdImg();
                $query = "INSERT INTO immaginiparcheggio (id_img,id_parcheggio) VALUES ($idImg,$idp)";
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



    public function delete($object)
    {
        try {
            $this->_connection->beginTransaction();
            $id = $object->getId();
            $loc = $object->getIdLocazione();
            $posti = $object->getPosti();
            $arrs = $object->getServizi();

            $query = "DELETE FROM postiparcheggio WHERE id_parcheggio = $id";
            $this->query($query);
            $query = "DELETE FROM parcheggioservizi WHERE id_parcheggio = $id";
            $this->query($query);
            $query = "DELETE FROM immaginiparcheggio WHERE id_parcheggio = $id";
            $this->query($query);
            parent::delete($object);

            $p = FPostoAuto::getInstance();
            foreach ($posti as $k){
                $p->delete($k);
            }

            //$dbloc = FIndirizzo::getInstance();
            //$dbloc->delete($loc);
            $query = "DELETE FROM `indirizzo` WHERE `id_indirizzo` = $loc";
            $this->query($query);

            $dbSI = FServizioIncluso::getInstance();
            $dbSO = FServizioOpzionale::getInstance();

            foreach ($arrs as $k => $v) {
                $id = $v->getIdServizio();

                $query = "SELECT is_opzionale FROM servizio WHERE id_servizio=$id";

                $this->query($query);
                $res = $this->_result->fetch();
                if ($res[0] == 'F') {
                    $dbSI->delete($v);
                } else {
                    $dbSO->delete($v);
                }
            }

            $dbImg = FImmagine::getInstance();
            foreach ($immagini as $img) {
                $dbImg->delete($img);
            }

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
            $loc = $object->getIndirizzo();
            $posti = $object->getPosti();
            $servizi = $object->getServizi();
            $immagini = $object->getImmagini();
            $object->setOrarioApertura($object->getOrarioApertura());
            $object->setOrarioChiusura($object->getOrarioChiusura());

            parent::update($object);

            $dbl = FIndirizzo::getInstance();
            $dbl->update($loc);
            $dbPA = FPostoAuto::getInstance();

            $idp = $object->getId();

            $query = "SELECT id_posto FROM postiparcheggio WHERE id_parcheggio=$idp";
            $this->query($query);
            $arrIdPostigrezzo = $this->getResult();
            $arrIdPosti = array();
            foreach ($arrIdPostigrezzo as $k=>$value){
               array_push($arrIdPosti, $value[0]);
            }

            foreach ($posti as $posto) {
                $dbPA->update($posto);
                if(!in_array($posto->getId(), $arrIdPosti)){
                    $idposto = $posto->getId();
                    $query = "INSERT INTO postiparcheggio (id_posto, id_parcheggio) VALUES ($idposto,$idp)";
                    $this->query($query);
                }
            }
            foreach ($servizi as $servizio) {
                if (!($servizio instanceof EServizioOpzionale)) {
                    $db = FServizioIncluso::getInstance();
                    $db->update($servizio);
                } else {
                    $db = FServizioOpzionale::getInstance();
                    $db->update($servizio);
                }
            }
            $query = "SELECT id_servizio FROM parcheggioservizi WHERE id_parcheggio=$idp";
            $this->query($query);
            $arrIdSgrezzo = $this->getResult();
            $arrIdS = array();
            foreach ($arrIdSgrezzo as $k=>$value){
                array_push($arrIdS, $value[0]);
            }
            $arrIdserviziParcheggio = array(); //prendo gli id dei servizi che l'oggetto possiede
            foreach ($servizi as $servizio){
                $arrIdserviziParcheggio[] = $servizio->getIdServizio();
            }
            foreach ($arrIdS as $id_servizio){  // elimino dalla tabella gli id che il parcheggio non possiede più, se sono stati eliminati
                if(!in_array($id_servizio, $arrIdserviziParcheggio)){
                    $query = "DELETE FROM parcheggioservizi WHERE id_servizio = $id_servizio";
                    $this->query($query);

                }
            }

            foreach ($servizi as $servizio) {
                if(!in_array($servizio->getIdServizio(), $arrIdS)){
                    $ids = $servizio->getIdServizio();
                    $query = "INSERT INTO parcheggioservizi (id_servizio, id_parcheggio) VALUES ($ids,$idp)";
                    $this->query($query);
                }
            }

            $query = "SELECT id_img FROM immaginiparcheggio WHERE id_parcheggio=$idp";
            $this->query($query);
            $arrIdImggrezzo = $this->getResult();
            $arrIdImg = array(); //array degli id sulla tabella
            foreach ($arrIdImggrezzo as $k=>$value){
                array_push($arrIdImg, $value[0]);
            }

            foreach ($immagini as $immagine) {
                if(!in_array($immagine->getIdImg(), $arrIdImg)){
                    $idimg = $immagine->getIdImg();
                    $query = "INSERT INTO immaginiparcheggio (id_img, id_parcheggio) VALUES ($idimg,$idp)";
                    $this->query($query);
                }
            }
            $arrIdimgParcheggio = array(); //prendo gli id delle img che l'oggetto possiede
            foreach ($immagini as $immagine){
                $arrIdimgParcheggio[] = $immagine->getIdImg();
            }
            $query = "SELECT id_img FROM immaginiparcheggio WHERE id_parcheggio=$idp";
            $this->query($query);
            $arrIdImggrezzo = $this->getResult();
            $arrIdImg = array(); //array degli id sulla tabella
            foreach ($arrIdImggrezzo as $k=>$value){
                array_push($arrIdImg, $value[0]);
            }

            foreach ($arrIdImg as $id_img){  // elimino dalla tabella gli id che il parcheggio non possiede più, se sono stati eliminati
                if(!in_array($id_img, $arrIdimgParcheggio)){

                    $query = "DELETE FROM immaginiparcheggio WHERE id_img = $id_img";
                    $this->query($query);
                }
            }


            parent::update($object);

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
            $id = $result->getId();

            $dbGestore = FGestore::getInstance();
            $proprietario = $dbGestore->load($result->getIdProprietario());
            $result->setProprietario($proprietario);

            $dbIndirizzo = FIndirizzo::getInstance();
            $indirizzo = $dbIndirizzo->load($result->getIdLocazione());
            $result->setIndirizzo($indirizzo);

            $query = "SELECT id_posto FROM postiparcheggio WHERE id_parcheggio = $id";
            $this->query($query);
            $arrs = $this->getResult();
            $dbPA = FPostoAuto::getInstance();
            foreach ($arrs as $p=>$k) {

                $posto = $dbPA->load($k[0]);
                $result->addPosto($posto);

            }
            $dbserI = FServizioIncluso::getInstance();
            $dbserO = FServizioOpzionale::getInstance();

            $query = "SELECT id_servizio FROM parcheggioservizi WHERE id_parcheggio = $id";
            $this->query($query);
            $arrs = $this->getResult();
            foreach ($arrs as $k => $v) {

                $query = "SELECT is_opzionale FROM servizio WHERE id_servizio=$v[0]";
                $this->query($query);
                $res = $this->_result->fetch();
                if ($res[0] == 'F') {
                    $s = $dbserI->load($v[0]);
                } else {
                    $s = $dbserO->load($v[0]);
                }
                $result->addServizio($s);
            }

            $query = "SELECT id_img FROM immaginiparcheggio WHERE id_parcheggio = $id";
            $this->query($query);

            $dbImg = FImmagine::getInstance();

            $arrIdImggrezzo = $this->getResult();
            $arrIdImg = array();
            foreach ($arrIdImggrezzo as $k=>$value){
                array_push($arrIdImg, $value[0]);
            }

            foreach ($arrIdImg as $key=>$value) {
                $img = $dbImg->load(intval($value));
                $result->addImmagine($img);
            }
            $result->convertTimeAttr();
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
     * Restituisce un array contenente i parcheggi dei quali è proprietario il gestore con l'ID che viene fornito come parametro.
     * @param int $idGestore ID proprietario dei parcheggi.
     * @return array|bool Array di oggetti _EParcheggio_ posseduti.
     */
    public function selectParcheggioByGestore(int $idGestore):array|bool{
        $query = "SELECT id_parcheggio FROM parcheggio WHERE id_proprietario = $idGestore";

        $this->query($query);
        $arrIdParcheggio = $this->getResult();
        if($arrIdParcheggio != false) {
            $arrParcheggio = array();
            foreach ($arrIdParcheggio as $k => $id) {
                array_push($arrParcheggio, self::load($id[0]));
            }
            return $arrParcheggio;
        }
        else{
            return false;
        }
    }

    /**
     * Effettua una ricerca sulla base dati secondo i parametri forniti e restituisce un array di risultati.
     * @param string $citta Città nella quale cercare il parcheggio.
     * @param string $dataArr Data d'inizio posteggio.
     * @param string $dataPar Data di fine posteggio.
     * @param string $taglia Taglia del veicolo da posteggiare.
     * @return bool|array Array di risultati nel formato ["id del posto"=>"oggetto EParcheggio che contiene quel posto"].
     */
    public function searchByParams(string $citta, string $dataArr, string $dataPar, string $taglia): bool|array {

         $query = "SELECT DISTINCT parcheggio.id_parcheggio,p2.id_posto,MIN(tariffa) as tariffaMinima
                     FROM parcheggio
                     INNER JOIN postiparcheggio p on parcheggio.id_parcheggio = p.id_parcheggio
                     INNER JOIN postoauto p2 on p.id_posto = p2.id_posto
                     LEFT OUTER JOIN prenotazione p3 on p2.id_posto = p3.id_posto
                     INNER JOIN indirizzo i on parcheggio.id_locazione = i.id_indirizzo
                     INNER JOIN tariffa t on p2.id_tariffa_base = t.id_tariffa
                     WHERE citta = :citta AND id_taglia = :taglia
                     AND ((:dataArr NOT BETWEEN data_inizio AND data_fine)
                     AND (:dataPar NOT BETWEEN data_inizio AND data_fine)
                     AND (data_fine NOT BETWEEN :dataArr AND :dataPar)
                     AND (data_inizio NOT BETWEEN :dataArr AND :dataPar)
                           OR (data_inizio IS NULL AND data_fine IS NULL))
                     GROUP BY parcheggio.id_parcheggio
                     ORDER BY MIN(tariffa)";
         try {
             $stmt = $this->_connection->prepare($query);
             $res = array('citta' => $citta, 'taglia'=>$taglia, 'dataArr'=>$dataArr, 'dataPar'=>$dataPar);
             $stmt->execute($res);
             $this->_result = $stmt;

             $result = $this->getResult();

             if($result) {
                 $arrayResult = array();
                 $dbParcheggio = FParcheggio::getInstance();
                 foreach ($result as $key => $value) {
                     $id_parcheggio = $value[0];
                     $id_posto = $value[1];
                     $parcheggio = $dbParcheggio->load($id_parcheggio);
                     $arrayResult[$id_posto] = $parcheggio;
                 }
                 return $arrayResult;
             } else return false;

         } catch (PDOException $e) {
             echo "Impossibile effettuare la query al database: " . $e->getMessage()."\n";
             return false;
         }
    }


    /**
     * Restituisce il numero di parcheggi totali memorizzati nella base dati.
     * @return mixed|null
     */
    public function getTotale(){
        try {
            $this->_connection->beginTransaction();
            $query = "SELECT COUNT(id_parcheggio) AS num FROM parcheggio";
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