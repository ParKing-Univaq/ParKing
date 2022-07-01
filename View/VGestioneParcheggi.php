<?php

require_once "autoloader.php";
require_once "StartSmarty.php";

/**
 * Classe per la visualizzazione e recupero informazioni dalle pagine relative alla gestione dei parcheggi da parte del gestore.
 * @package View
 */
class VGestioneParcheggi
{
    /**
     * Oggetto _Smarty_ per la compilazione e visualizzazione dei template.
     * @var Smarty
     */
    private Smarty $smarty;

    /**
     * Costruttore di classe. Crea l'oggetto ed esegue la configurazione dell'attributo _$smarty_.
     */
    public function __construct()
    {
        $this->smarty = StartSmarty::configuration();
    }

    /**
     * Mostra il pannello di gestione dei parcheggi del gestore forniti come parametro. Preleva le informazioni dagli oggetti,
     * le assegna ai parametri del template e mostra la pagina.
     * @param EGestore $gestore
     * @param array|string $parcheggi
     * @return void
     * @throws SmartyException
     */
    public function mostraPannelloGestione(EGestore $gestore, array|string $parcheggi): void {

            $nome = $gestore->getNome();
            $cognome = $gestore->getCognome();
            $user = $gestore->getUsername();
            $email = $gestore->getEmail();
            $img = $gestore->getImg();
            $pic64 = $img->getImage();
            $type = $img->getEstensione();
            $this->smarty->assign('nome', $nome);
            $this->smarty->assign('cognome', $cognome);
            $this->smarty->assign('user', $user);
            $this->smarty->assign('email', $email);
            $this->smarty->assign('type', $type);
            $this->smarty->assign('pic64', $pic64);
            $this->smarty->assign('parcheggi', $parcheggi);
            $this->smarty->display('areapersonalegestore.tpl');
    }

    /**
     * Restituisce e memorizza nella sessione, se esiste, il valore associato alla chiave 'idparcheggio' dell'array _$___POST_. Se non esiste lo recupera dalla sessione.
     * @return false|mixed
     */
    public function getIdParcheggio(){
        $sessione = new Sessioni();
        if (isset($_POST['idparcheggio'])){
            $id = $_POST['idparcheggio'];
            $sessione->imposta_valore('id_parcheggio', $id);
        }else{
            $id = $sessione->leggi_valore('id_parcheggio');
        }
        return $id;
    }

    /**
     * Mostra la pagina del dettaglio di uno specifico parcheggio. Assegna ai parametri del template le informazioni fornite come parametri e mostra la pagina.
     * @param EParcheggio $parcheggio
     * @param array|bool $recensioni
     * @param array $tagliepostitariffe
     * @return void
     * @throws SmartyException
     */
    public function dettagliParcheggio(EParcheggio $parcheggio,array|bool $recensioni ,array $tagliepostitariffe){

        $this->smarty->assign('params',$tagliepostitariffe);
        $this->smarty->assign('parcheggio', $parcheggio);
        $this->smarty->assign('recensioni', $recensioni);

        $this->smarty->display('dettagliparcheggiogestore.tpl');
    }

    /**
     * Restituisce in un array i valori associati alle chiavi 'nome_servizio','is_opzionale' e 'costo' dell'array _$___POST_.
     * @return array
     */
    public function getServizio(){
        $nome_servizio =$_POST['nome_servizio'];
        if (isset($_POST['is_opzionale'])){
            $is_opzionale =$_POST['is_opzionale'];
            $costo =$_POST['costo'];
        }else {
            $is_opzionale ='off';
            $costo = null;
        }
        $arrParams = array($nome_servizio, $is_opzionale, $costo);
        return $arrParams;
    }

    /**
     * Restituisce il valore associato alla chiave 'servizi_rimossi' dell'array _$___POST_.
     * @return string
     */
    public function getOptionServizio(){

        $id_servizio = $_POST['servizi_rimossi'];
        return $id_servizio;

    }
    /**
     * Restituisce il valore associato alla chiave 'descrizione' dell'array _$___POST_.
     * @return string
     */
    public function getNuovaDescrizione(){

        $strdescr = $_POST['descrizione'];
        return $strdescr;
    }

    /**
     * Restituisce l'array _$___POST_.
     * @return array
     */
    public function getNuoveTariffe(){
        $nuoveTariffe =  $_POST;
        return $nuoveTariffe;
    }

    /**
     * Restituisce un array contenente i dati associati alla chiave 'img' dell'array _$___FILES_
     * @return array
     */
    public function getImg(){
        $estensione = $_FILES['img']['type'];
        $nome = $_FILES['img']['name'];
        $file = $_FILES['img']['tmp_name'];
        $dimensione = $_FILES['img']['size'];
        $arrImg = array($nome,$estensione, $file, $dimensione);
        return $arrImg;
    }

    /**
     * Restituisce il valore associato alla chiave 'id_img' dell'array _$___POST_.
     * @return string
     */
    public function getIdImg(){

        $id_img = $_POST['id_img'];
        return $id_img;

    }

    /**
     * Mostra la pagina di conferma di operazione avvenuta.
     * @return void
     * @throws SmartyException
     */
    public function conferma(){
        $this->smarty->display("confermaoperazione.tpl");
    }

    /**
     * Restituisce un array contenente i dati associati alle chiavi 'risposta' e 'id_recensione' dell'array _$___FILES_
     * @return array
     */
    public function getRisposta()
    {

        $strrisposta = $_POST['risposta'];
        $id_recensione = $_POST['id_recensione'];
        $arrParams = array($strrisposta, $id_recensione);
        return $arrParams;
    }

}