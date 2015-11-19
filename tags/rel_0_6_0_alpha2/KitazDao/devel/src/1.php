<?php
// KitazDao using variants, class files
require_once "./env.php";

define("KD_DAO_PATH", "../dao");
define("KD_ENTITY_PATH", "../dto");

$kd = new KitazDao(MYSQL_CONFIG);

$ndao = $kd->getDao("DNewsDao");
$ndto = new DNewsDto();

// insert



// update


// delete