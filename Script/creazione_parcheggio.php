<?php
require "autoloader.php";

$db = FParcheggio::getInstance();
$dbGestore = FGestore::getInstance();
$dbIndirizzo = FIndirizzo::getInstance();
$dbPosto = FPostoAuto::getInstance();
$dbImmagine = FImmagine::getInstance();

$dbTaglia = FTaglia::getInstance();
$dbTariffa = FTariffa::getInstance();

$tariffa = new ETariffa();
$tariffa->setTariffa(10);
//$dbTariffa->store($tariffa);
//$idTariffa= $tariffa->getIdTariffa();

$tagliaF = $dbTaglia->load('Furgone');
$tagliaA = $dbTaglia->load('Auto');
$tagliaM = $dbTaglia->load('Moto');

//$tariffa= $dbTariffa->load($idTariffa);

$pa = new EPostoAuto();
$pa->setTaglia($tagliaF);
$pa->setTariffaBase($tariffa);

$pb= new EPostoAuto();
$pb->setTaglia($tagliaA);
$pb->setTariffaBase($tariffa);

$pc = new EPostoAuto();
$pc->setTaglia($tagliaM);
$pc->setTariffaBase($tariffa);
//$dbPosto->store($pa);

$da = "08:00";
$d = "19:00";

$g = $dbGestore->load(420);

$i = new EIndirizzo();
$i->setCAP('65123');
$i->setCitta('Torino');
$i->setNumeroCivico(19);
$i->setProvincia('To');
$i->setVia('lunga');



$park = new EParcheggio();
$park->setGestore($g);
$park->setIndirizzo($i);
$park->setNomeParcheggio('ParcheggioTorino1');
$park->setOrarioApertura($da);
$park->setOrarioChiusura($d);
$park->addPosto($pa);
$park->addPosto($pb);
$park->addPosto($pc);
$park->setDescrizione('Parcheggio a Torino coperto zona centrale con sicurezza');

$db->store($park);


