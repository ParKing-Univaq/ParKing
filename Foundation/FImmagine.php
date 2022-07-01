<?php

/**
 * Classe per gestire le operazioni sulla tabella "immagini" della base dati.
 * @package Foundation
 */
class FImmagine extends FDb
{
    /**
     *Costruttore della classe. Richiama il costruttore della superclasse _FDb_. Inizializza l'attributo $\_table con il nome della tabella, l'attributo $\_key con il nome della colonna che è chiave primaria per la tabella,
     * l'attributo $\_return\_class con il nome della classe _Entity_ associata alla classe _Foundation_ di cui crea le istanze e l'attributo $\_auto\_increment a true
     * se la chiave primaria si incrementa automaticamente, a false altrimenti.
     */
    protected function __construct() {
        parent::__construct();
        $this->_table='immagini';
        $this->_key='id_img';
        $this->_return_class='EImmagine';
        $this->_auto_increment=true;
    }

    public function store($object): bool {
       try {
           $nome = $object->getNome();
           $estensione = $object->getEstensione();
           $dimensione = $object->getDimensione();
           $fileContent = $object->getImage();
           $fileb64 = base64_encode($fileContent);
           $query = "INSERT INTO immagini (nome, estensione, dimensione, image) VALUES('$nome','$estensione', '$dimensione',  '$fileb64')";
           $this->query($query);

           $query = 'SELECT LAST_INSERT_ID() AS `id`';
           $this->query("$query");
           $result = $this->getResultAssoc();
           $id = $result['id'];
           $object->setIdImg($id);
           return true;
       } catch (PDOException $e){
           echo "Impossibile effettuare l'operazione:" . $e->getMessage()."\n";
           return false;
       }
    }

    public function load($key): object|bool|null {
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

    public function update(object $object): bool {
        try {
            $id = $object->getIdImg();
            $nome = $object->getNome();
            $estensione = $object->getEstensione();
            $dimensione = $object->getDimensione();
            $fileContent = $object->getImage();
            $fileb64 = base64_encode($fileContent);
            $query = "UPDATE immagini SET nome='$nome', estensione='$estensione', dimensione='$dimensione', image='$fileb64' WHERE id_img = '$id'";
            $this->query($query);

            return true;
        } catch (PDOException $e){
            echo "Impossibile effettuare l'operazione:" . $e->getMessage()."\n";
            return false;
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

    /*private function ridimensionaImmagine()
    {
        $file = $this->getFile();
        $estensione = $this->getEstensione();
        //set $percent value <1 for shrinking and $percent value >1 for expanding
        $per = 0.3;
        //Check Content type
        header('Content-Type: image/jpeg');
        //Generate new size parameters
        if ($estensione == "image/jpeg" || $estensione == "image/jpg") {
            list($width, $height) = getimagesize($file);
            $new_w = 488;
            $new_h = 600;
            // Load image
            $output = imagecreatetruecolor($new_w, $new_h);
            $source = imagecreatefromjpeg($file);
            // Resize the source image to new size
            imagecopyresized($output, $source, 0, 0, 0, 0, $new_w, $new_h, $width, $height);
            //Display Output
            return imagejpeg($output);
        }
        if ($estensione == "image/png") {
            list($width, $height) = getimagesize($file);
            $new_w = 488;
            $new_h = 600;
            // Load image
            $output = imagecreatetruecolor($new_w, $new_h);
            $source = imagecreatefrompng($file);
            // Resize the source image to new size
            imagecopyresized($output, $source, 0, 0, 0, 0, $new_w, $new_h, $width, $height);
            //Display Output
            return imagejpeg($output);
        }
        if ($estensione == "image/gif") {
            list($width, $height) = getimagesize($file);
            $new_w = 488;
            $new_h = 600;
            // Load image
            $output = imagecreatetruecolor($new_w, $new_h);
            $source = imagecreatefromgif($file);
            // Resize the source image to new size
            imagecopyresized($output, $source, 0, 0, 0, 0, $new_w, $new_h, $width, $height);
            //Display Output
            return imagegif($output);
        }
    }*/

}