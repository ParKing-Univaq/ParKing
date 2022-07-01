<?php

require_once 'autoloader.php';
require_once 'StartSmarty.php';


    $fcontroller = new CFrontController();
    $fcontroller->run($_SERVER['REQUEST_URI']);

?>
