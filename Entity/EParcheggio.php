<?php

require_once "autoloader.php";


/**
 * Classe per la rappresentazione dei parcheggi.
 * @uses EGestore Gestore del parcheggio.
 * @uses EPostoAuto Posto all'interno del parcheggio.
 * @uses EIndirizzo Locazione del parcheggio.
 * @uses EServizio Servizi offerti dal parcheggio.
 * @uses EImmagini Immagini del parcheggio.
 * @package Entity
 */
class EParcheggio
{
    /**
     * Metodo di classe che restituisce un array nel formato ["id del posto" => ["Tariffa del posto","oggetto PostoAuto","oggetto Parcheggio contenente il posto"]]
     * come risultato ai parametri di ricerca passati.
     * @param string $citta Città si cercano i parcheggi.
     * @param string $dataOraArrivo Stringa nel formato "yyyy-mm-dd h:i:s" corrispondente alla data di arrivo.
     * @param string $dataOraPartenza Stringa nel formato "yyyy-mm-dd h:i:s" corrispondente alla data di partenza.
     * @param string $taglia Taglia del veicolo che si vuole posteggiare.
     * @return bool|array false se non esiste alcun parcheggio che soddisfa i parametri, array contenente i risultati altrimenti.
     */
    public static function getRisultatoParcheggi (string $citta, string $dataOraArrivo, string $dataOraPartenza, string $taglia): bool|array {
        $dbParcheggio = FParcheggio::getInstance();
        $result = $dbParcheggio->searchByParams($citta,$dataOraArrivo,$dataOraPartenza,$taglia);

        if ($result){
            try {
                $arrivo = new DateTime($dataOraArrivo);
                $partenza = new DateTime($dataOraPartenza);
            } catch (Exception $e) {
                print_r($e->getMessage());
            }

            $durata = $partenza->diff($arrivo);

            if($durata->format('%a') > 0){
                $mezzoreSosta+= $durata->format('%a') * 24 * 2;
            }
            if($durata->format('%h') > 0){
                $mezzoreSosta+= $durata->format('%h') * 2;
            }
            
            if($durata->format('%i') >= 30){
                $mezzoreSosta+=1;
            }

            $risultato = array();
            foreach ($result as $idPosto=>$parcheggio){
                $posto = $parcheggio->getPostoByID($idPosto);
                $tariffaOraria = $posto->getTariffaBase();
                $costoTotale = round((($tariffaOraria->getTariffa() * 0.5 ) * $mezzoreSosta),2);
                $risultato[$idPosto] = array($costoTotale,$posto,$parcheggio);
            }

            return $risultato;

        } else return false;
    }

    /**
     * ID utilizzato nella base dati per l'identificazione del parcheggio.
     * @var int
     */
    public int $id_parcheggio;
    /**
     * Nome del parcheggio.
     * @var string
     */
    public string $nome_parcheggio;
    /**
     * Descrizione del parcheggio.
     * @var string
     */
    public string $descrizione;
    /**
     * Orario di apertura del parcheggio. Nel formato string "hh:mm"
     * o timestamp Unix (quando viene effettuato il caricamento dalla base dati).
     * @var int|string
     */
    public int|string $orario_apertura;
    /**
     * Orario di chiusura del parcheggio. Nel formato string "hh:mm"
     * o timestamp Unix (quando viene effettuato il caricamento dalla base dati).
     * @var int|string
     */
    public int|string $orario_chiusura;
    /**
     * Utente proprietario del parcheggio.
     * @var EGestore
     */
    public EGestore $_Proprietario;
    /**
     * Locazione del parcheggio.
     * @var EIndirizzo
     */
    public EIndirizzo $_Locazione;
    /**
     * Servizi offerti dal parcheggio.
     * @var array
     */
    public array $_Servizi = array();
    /**
     * Posti auto del parcheggio.
     * @var array
     */
    public array $_PostiAuto = array();
    /**
     * Immagini del parcheggio.
     * @var array
     */
    public array $_Immagini = array();
    /**
     * ID utilizzato nella base dati per gestire la relazione tra parcheggio e proprietario.
     * @var int
     */
    public int $id_proprietario;
    /**
     * ID utilizzato nella base dati per gestire la relazione tra parcheggio e indirizzo.
     * @var int
     */
    public int $id_locazione;


    /**
     *Costruttore della classe.
     */
    public function __construct() {
    }

    /**
     * Restituisce l'ID del parcheggio.
     * @return int ID del parcheggio.
     */
    public function getId(): int {
        return $this->id_parcheggio;
    }

    /**
     * Restituisce un array contenente i servizi offerti dal parcheggio.
     * @return array Array contenente i servizi.
     */
    public function getServizi(): array {
        return $this->_Servizi;
    }

    /**
     * Imposta la totalità dei servizi offerti dal parcheggio.
     * @param array $Servizi Array contenente i nuovi servizi offerti.
     */
    public function setServizi(array $Servizi): void {
        $this->_Servizi = $Servizi;
    }

    /**
     * Restituisce l'orario di apertura del parcheggio.
     * @return string Orario di apertura del parcheggio.
     */
    public function getOrarioApertura(): string {
        return $this->orario_apertura;
    }

    /**
     * Restituisce l'orario di chiusura del parcheggio.
     * @return string Orario di chiusura del parcheggio.
     */
    public function getOrarioChiusura(): string {
        return $this->orario_chiusura;
    }

    /**
     * Restituisce il nome del parcheggio.
     * @return string Nome del parcheggio.
     */
    public function getNomeParcheggio(): string {
        return $this->nome_parcheggio;
    }

    /**
     * Restituisce il numero di posti presenti nel parcheggio.
     * @return int Numero di posti.
     */
    public function getNumeroPosti(): int {
        return count($this->_PostiAuto);
    }

    /**
     * Restituisce l'utente proprietario del parcheggio.
     * @return EGestore Gestore del parcheggio.
     */
    public function getGestore(): EGestore {
        return $this->_Proprietario;
    }

    /**
     * Restituisce l'indirizzo del parcheggio.
     * @return EIndirizzo Indirizzo del parcheggio.
     */
    public function getIndirizzo(): EIndirizzo {
        return $this->_Locazione;
    }

    /**
     * Restituisce un array contenente i posti del parcheggio.
     * @return array Array contenente i posti.
     */
    public function getPosti(): array {
        return $this->_PostiAuto;
    }

    /**
     * Restituisce un array contenente le immagini del parcheggio.
     * @return array Array contenente le immagini.
     */
    public function getImmagini(): array {
        return $this->_Immagini;
    }

    /**
     * Imposta l'ID del parcheggio.
     * @param int $id Il nuovo ID.
     * @return void
     */
    public function setId(int $id): void {
        $this->id_parcheggio = $id;
    }

    /**
     * Imposta il nome del parcheggio.
     * @param string $nome Il nuovo nome.
     * @return void
     */
    public function setNomeParcheggio(string $nome): void {
        $this->nome_parcheggio = $nome;
    }


    /**
     * Imposta il proprietario del parcheggio.
     * @param EGestore $gestore Il nuovo proprietario.
     * @return void
     */
    public function setProprietario(EGestore $gestore): void {
        $this->_Proprietario = $gestore;
    }

    /**
     * Imposta l'indirizzo del parcheggio.
     * @param EIndirizzo $i Il nuovo indirizzo.
     * @return void
     */
    public function setIndirizzo(EIndirizzo $i): void {
        $this->_Locazione = $i;
    }

    /**
     * Metodo per aggiungere un posto al parcheggio.
     * @param EPostoAuto $p Il posto da aggiungere.
     * @return void
     */
    public function addPosto(EPostoAuto $p): void {
        $this->_PostiAuto[] = $p;
    }

    /**
     * Metodo per rimuovere uno specifico posto dal parcheggio.
     * @param EPostoAuto $p Il posto da rimuovere.
     * @return string "Rimosso" se la rimozione è andata a buon fine, "Fallito" altrimenti.
     */
    public function rimuoviPosto(EPostoAuto $p): string {
        $flag = 0;

        foreach ($this->_PostiAuto as $k => $v) {
            if ($v->getId() == $p->getId()) {
                unset($this->_PostiAuto[$k]);
                $flag = 1;
            }
        }
        if ($flag == 1) {
            return 'Rimosso';
        } else {
            return 'Fallito';
        }

    }

    /**
     * Imposta l'orario di apertura del parcheggio.
     * Prende un orario in formato "hh:mm", lo trasforma in timestamp Unix e lo imposta.
     * @param string $orarioApertura Nuovo orario di apertura in formato "hh:mm".
     * @return void
     */
    public function setOrarioApertura(string $orarioApertura): void {
        $this->orario_apertura = strtotime($strora);
    }

    /**
     * Imposta l'orario di apertura del parcheggio.
     * @param string $orarioApertura Nuovo orario di apertura in formato "hh:mm".
     * @return void
     */
    public function setStringOrarioApertura(string $orarioApertura): void {
        $this->orario_apertura = $orarioApertura;
    }

    /**
     * Imposta l'orario di chiusura del parcheggio.
     * Prende un orario in formato "hh:mm", lo trasforma in timestamp Unix e lo imposta.
     * @param string $orarioChiusura Nuovo orario di chiusura in formato "hh:mm".
     * @return void
     */
    public function setOrarioChiusura(string $orarioChiusura): void {
        $this->orario_chiusura = strtotime($orarioChiusura);
    }

    /**
     * Imposta l'orario di chiusura del parcheggio.
     * @param string $orarioChiusura Nuovo orario di chiusura in formato "hh:mm".
     * @return void
     */
    public function setStringOrarioChiusura(string $orarioChiusura): void {
        $this->orario_chiusura = $orarioChiusura;
    }

    /**
     * Restituisce l'ID del proprietario del parcheggio.
     * @return int ID del proprietario.
     */
    public function getIdProprietario(): int {
        return $this->id_proprietario;
    }

    /**
     * Restituisce l'ID della locazione del parcheggio.
     * @return int ID della locazione.
     */
    public function getIdLocazione(): int {
        return $this->id_locazione;
    }

    /**
     * Imposta la totalità dei posti del parcheggio.
     * @param array $PostiAuto Array contenente i nuovi posti.
     */
    public function setPostiAuto(array $PostiAuto): void {
        $this->_PostiAuto = $PostiAuto;
    }

    /**
     * Metodo per aggiungere un servizio a quelli offerti dal parcheggio.
     * @param EServizio $s Servizio da aggiungere.
     * @return void
     */
    public function addServizio(EServizio $s): void {

        $this->_Servizi[] = $s;

    }

    /**
     * Metodo per rimuovere un servizio da quelli offerti dal parcheggio.
     * @param int $id_servizo ID del servizio da rimuovere.
     * @return void
     */
    public function rimuoviServizio(int $id_servizo): void {

        foreach ($this->_Servizi as $k => $v) {
            if ($v->getIdServizio() == $id_servizo) {
                unset($this->_Servizi[$k]);
            }
        }

    }

    /**
     * Imposta la totalità delle immagini del parcheggio.
     * @param array $Immagini Array contenente le nuove immagini.
     * @return void
     */
    public function setImmagini(array $Immagini): void {
        $this->_Immagini = $Immagini;
    }

    /**
     * Metodo per aggiungere un immagine del parcheggio.
     * @param EImmagine $img Immagine da aggiungere.
     * @return void
     */
    public function addImmagine(EImmagine $img): void {
        $this->_Immagini[] = $img;
    }

    /**
     * Metodo per rimuovere un immagine del parcheggio.
     * @param int $id_img ID dell'immagine da rimuovere.
     * @return void
     */
    public function rimuoviImmagine(int $id_img): void {

        foreach ($this->_Immagini as $k => $v) {
            if ($v->getIdImg() == $id_img) {
                unset($this->_Immagini[$k]);
            }
        }
    }

    /**
     * Restituisce la descrizione del parcheggio.
     * @return string La descrizione del parcheggio.
     */
    public function getDescrizione(): string {
        return $this->descrizione;
    }

    /**
     * Imposta la descrizione del parcheggio.
     * @param string $descrizione La nuova descrizione.
     */
    public function setDescrizione(string $descrizione): void {
        $this->descrizione = $descrizione;
    }

    /**
     * Imposta la tariffa per tipologia di posti.
     * @param array $tagliatariffa Array associativo nel formato [ID della taglia => valore della tariffa]
     * @return bool True se almeno una tipologia di posto ha avuto modificato il valore della tariffa, false altrimenti.
     */
    public function setTariffaByTaglia(array $tagliatariffa): bool {
        $i = 0;

        foreach ($tagliatariffa as $taglia => $tariffa) {

            $idTaglia = $taglia;

            foreach ($this->_PostiAuto as $posto) {
                if ($posto->getTaglia()->getIdTaglia() == $idTaglia) {
                    $posto->getTariffaBase()->setTariffa($tariffa);
                    $i++;
                }
            }
        }
        if ($i > 0) return true;
        else return false;
    }

    /**
     * Restituisce un array associativo con numero di posti e valore numerico della tariffa in base alle taglie.
     * @param array $taglie Array degli identificativi delle taglie di cui si vogliono ottenere informazioni.
     * @return array Array associativo nel formato [ID della taglia => [numero di posti di quella taglia => valore numerico della tariffa per quella taglia]]
     */
    public function getPostieTariffabyTaglia(array $taglie): array {
        $params = array();
        foreach ($taglie as $taglia) {
            $result = 0;
            $tariffa = 0;
            foreach ($this->_PostiAuto as $posto) {
                if ($taglia == $posto->getTaglia()->getIdTaglia()) {
                    $result = $result + 1;
                    $tariffa = $posto->getTariffaBase()->getTariffa();
                }
            }
            $params[$taglia] = array($result, $tariffa);
        }
        return $params;
    }


    /**
     * Metodo per convertire gli attributi orario_apertura e orario_chiusura da tipo DateTime a tipo string.
     * @return void
     */
    public function convertTimeAttr(): void {
        foreach ($this as $attr=>$value){
            if (str_starts_with($attr,'orario')){
                try {
                    $functionName ="setString".str_replace(array("orario_apertura","orario_chiusura"),array("OrarioApertura","OrarioChiusura"),$attr);
                    $this->$functionName(date("H:i",$value));
                } catch (Exception $e) {
                    print($e->getMessage());
                }
            }
        }
    }

    /**
     * Restituisce l'oggetto EPostoAuto appartenente al parcheggio e corrispondente all'ID passato come parametro.
     * @param int $id ID del posto che si vuole ottenere.
     * @return false|mixed false se il posto non esiste, l'oggetto EPostoAuto altrimenti.
     */
    public function getPostoByID(int $id): mixed {
        foreach ($this->_PostiAuto as $posto){
            $idPosto = $posto->getId();
            if ($idPosto == $id) return $posto;
        }
        return false;
    }

}
