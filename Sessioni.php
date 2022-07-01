<?php

/**
 * Classe per la gestione delle sessioni.
 */
class Sessioni
{
    /**
     * Costruttore della classe. Imposta la durata del cookie a 20 minuti e avvia la sessione.
     */
    public function __construct()
    {
        session_set_cookie_params(20*60);
        session_start();
    }

    /**
     * Imposta con i parametri passati il valore associato alla chiave dell'array _$___SESSION_.
     * @param $chiave mixed Chiave a cui assegnare il valore.
     * @param $valore mixed Valore da assegnare.
     * @return void
     */
    public function imposta_valore($chiave, $valore): void {
        $_SESSION[$chiave] = $valore;
    }

    /**
     * Elimina il valore associato alla chiave passata come parametro dall'array _$___SESSION.
     * @param $chiave mixed Chiave da cui eliminare il valore.
     * @return void
     */
    public function cancella_valore($chiave): void {
        unset($_SESSION[$chiave]);
    }

    /**
     * Legge il valore associato alla chiave passata come parametro dall'array _$___SESSION.
     * @param $chiave mixed Chiave di cui legge il valore associato.
     * @return false|mixed false se non è impostato, il valore altrimenti.
     */
    public function leggi_valore($chiave)
    {
        $value = false;
        if (isset($_SESSION[$chiave])) {
            $value = $_SESSION[$chiave];
        }
        return $value;
    }

    /**
     * Distrugge la sessione dopo aver liberato tutte le variabili della sessione.
     * @return void
     */
    public function distruggi(): void {
        session_unset();
        session_destroy();
    }

    /**
     * Imposta il valore della chiave 'searchParams' dell'array _$___SESSION_ con una copia dell'array _$___POST_ se quest'ultimo contiene almeno un elemento.
     * @return void
     */
    public function setSearchParamsPost(): void {
        if(count($_POST)) {
            $_SESSION['searchParams'] = $_POST;
        }
    }

    /**
     * Imposta il valore successivo dell'array, il cui nome è passato come parametro, interno all'array _$___SESSION_.
     * @param string $arrayName Nome dell'array.
     * @param mixed $value Valore da impostare.
     * @return void
     */
    public function setArrayValue(string $arrayName, mixed $value): void {
        $_SESSION[$arrayName][] = $value;
    }

    /**
     * Verifica se il cookie di sessione e il valore associato alla chiave 'id_utente' dell'array _$___SESSION_ sono impostati.
     * @return bool true
     */
    public function isLogged(): bool {
        $identificato = false;
        if (isset($_COOKIE['PHPSESSID']) && isset($_SESSION['id_utente'])) {
            $identificato = true;
        }
        return $identificato;
    }

}