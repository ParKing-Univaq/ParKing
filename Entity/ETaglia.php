<?php

/**
 * CLasse per la rappresentazione delle taglie dei posti.
 * @package Entity
 */
class ETaglia
{
    /**
     * @var string Nome identificativo della taglia.
     */
    public string $id_taglia;
    /**
     * @var string Dimensioni della taglia nel formato "[lunghezza]x[larghezza]x[altezza]".
     */
    public string $dimensioni;

    /**
     * Costruttore della classe.
     */
    public function __construct(){}


    /**
     * Restituisce il nome identificativo alla taglia.
     * @return string Il nome identificativo alla taglia.
     */
    public function getIdTaglia(): string
    {
        return $this->id_taglia;
    }


    /**
     * Restituisce le dimensioni associate alla taglia nel formato "[lunghezza]x[larghezza]x[altezza]".
     * @return string Le dimensioni associate alla taglia.
     */
    public function getDimensioni(): string {
        return $this->dimensioni;
    }


}