<?php

require_once "autoloader.php";

/**
 *Classe per la rappresentazione dei posti auto del parcheggio.
 *@uses ETaglia taglia del posto auto.
 *@uses ETariffa tariffa del posto auto.
 * @package Entity
 */
class EPostoAuto
{
    /**
     * ID utilizzato nella base dati per identificare il posto auto.
     * @var int
     */
    public int $id_posto;
    /**
     * Taglia del posto auto.
     * @var ETaglia
     */
    public ETaglia $_Taglia;
    /**
     * Tariffa del posto auto.
     * @var ETariffa
     */
    public ETariffa $_TariffaBase;
    /**
     * ID utilizzato nella base dati per gestire la relazione tra posto auto e taglia.
     * @var string
     */
    public string $id_taglia;
    /**
     * ID utilizzato nella base dati per gestire la relazione tra posto auto e tariffa.
     * @var int
     */
    public int $id_tariffa_base;

    /**
     *Costruttore della classe
     */
    public function __construct() {
    }

    /**
     * Restituisce l'ID del posto auto.
     * @return int ID del posto auto.
     */
    public function getId(): int {
        return $this->id_posto;
    }

    /**
     * Restituisce la taglia del posto auto.
     * @return ETaglia Taglia del posto auto.
     */
    public function getTaglia(): ETaglia {
        return $this->_Taglia;
    }

    /**
     * Restituisce la tariffa del posto auto.
     * @return ETariffa Tariffa del posto auto.
     */
    public function getTariffaBase(): ETariffa {
        return $this->_TariffaBase;
    }

    /**
     * Restituisce l'ID della taglia del posto auto.
     * @return string ID della taglia del posto auto.
     */
    public function getIdTaglia(): string {
        return $this->id_taglia;
    }

    /**
     * Restituisce L'ID della taglia del posto auto.
     * @return int ID della tariffa del posto auto.
     */
    public function getIdTariffaBase(): int {
        return $this->id_tariffa_base;
    }


    /**
     * Imposta l'ID del posto auto.
     * @param int $id_posto Il nuovo ID.
     */
    public function setIdPosto(int $id_posto): void {
        $this->id_posto = $id_posto;
    }

    /**
     * Imposta la taglia del posto auto.
     * @param ETaglia $Taglia La nuova taglia.
     */
    public function setTaglia(ETaglia $Taglia): void {
        $this->_Taglia = $Taglia;
    }

    /**
     * Imposta la tariffa del posto auto.
     * @param ETariffa $TariffaBase La nuova tariffa.
     */
    public function setTariffaBase(ETariffa $TariffaBase): void {
        $this->_TariffaBase = $TariffaBase;
    }

}

