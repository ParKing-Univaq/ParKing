<?php

/**
 *Classe per la rappresentazione degli utenti.
 * @uses EImmagine Immagine profilo dell'utente.
 * @package Entity
 */
class EUtente
{
    /**
     * Nome dell'utente.
     * @var string
     */
    public string $nome;
    /**
     * Cognome dell'utente.
     * @var string
     */
    public string $cognome;
    /**
     * Email dell'utente.
     * @var string
     */
    public string $email;
    /**
     * Username dell'utente.
     * @var string
     */
    public string $username;
    /**
     * Hash MD5 della password dell'utente.
     * @var string
     */
    public string $password;
    /**
     * Immagine del profilo dell'utente.
     * @var EImmagine
     */
    public EImmagine $_img;
    /**
     * ID utilizzato nella base dati per gestire la relazione tra immagine profilo e utente.
     * @var int
     */
    public int $id_img;


    /**
     *Costruttore della classe.
     */
    public function __construct() {
    }

    /**
     * Restituisce l'ID dell'immagine profilo.
     * @return int ID dell'immagine profilo.
     */
    public function getIdImg(): int {
        return $this->id_img;
    }

    /**
     * Restituisce il nome dell'utente.
     * @return string Il nome dell'utente.
     */
    public function getNome(): string {
        return $this->nome;
    }

    /**
     * Restituisce il cognome dell'utente.
     * @return string Il cognome dell'utente.
     */
    public function getCognome(): string {
        return $this->cognome;
    }

    /**
     * Restituisce l'email dell'utente.
     * @return string L'email dell'utente.
     */
    public function getEmail(): string {
        return $this->email;
    }

    /**
     * Restituisce la username dell'utente.
     * @return string La username dell'utente.
     */
    public function getUsername(): string {
        return $this->username;
    }

    /**
     * Restituisce l'hash MD5 della password dell'utente.
     * @return string L'hash MD5 della password.
     */
    public function getPassword(): string {
        return $this->password;
    }
    /**
     * Restituisce l'immagine profilo dell'utente.
     * @return EImmagine L'immagine profilo.
     */
    public function getImg(): EImmagine {
        return $this->_img;
    }
    /**
     * Imposta il nome dell'utente.
     * @param string $nome Il nuovo nome.
     */
    public function setNome(string $nome): void {
        $this->nome = $nome;
    }

    /**
     * Imposta il cognome dell'utente.
     * @param string $cognome Il nuovo cognome.
     */
    public function setCognome(string $cognome): void {
        $this->cognome = $cognome;
    }

    /**
     * Imposta l'email dell'utente.
     * @param string $email La nuova email.
     */
    public function setEmail(string $email): void {
        $this->email = $email;

    }

    /**
     * Imposta la username dell'utente.
     * @param string $username La nuova username.
     */
    public function setUsername(string $username): void {
        $this->username = $username;
    }


    /**
     * Imposta la password dell'utente.
     * Effettua un controllo sul formato della password fornita come parametro e ne imposta l'hash MD5 come attributo $password.
     * Il formato da rispettare è: lunghezza di almeno 8 caratteri,
     * almeno un numero da 0 a 9 e almeno un carattere speciale [caratteri speciali: '!','#','$','%','&','?']
     *
     * @param string $password La nuova password.
     * @return bool true se la stringa è risultata conforme al formato e si è proceduto all'assegnazione del nuovo valore, false altrimenti.
     */
    public function setPassword(string $password): bool {
        if (preg_match("^.*(?=.{8,})(?=.*[a-zA-Z])(?=.*\d)(?=.*[!#$%&? \"]).*$^", $password)) {
            $this->password = md5($password);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Imposta l'immagine profilo dell'utente. All'assegnazione viene fatto seguire l'aggiornamento dell'ID associata all'immagine.
     * @param EImmagine $img Oggetto rappresentante l'immagine profilo.
     */
    public function setImg(EImmagine $img): void {
        $this->_img = $img;
        $this->id_img = $img->getIdImg();
    }

}