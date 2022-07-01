<?php
require('Smarty/libs/Smarty.class.php');

/**
 * Classe per la creazione e configurazione di oggetti di tipo _Smarty_.
 */
class StartSmarty{
    /**
     * Funzione di classe. Crea l'oggetto e lo configura.
     * @return Smarty
     */
    static function configuration(): Smarty {
        $smarty=new Smarty();
        $smarty->template_dir='www/';
        $smarty->compile_dir='Smarty/templates_c/';
        $smarty->config_dir='Smarty/configs/';
        $smarty->cache_dir='Smarty/cache/';
        return $smarty;
    }
}