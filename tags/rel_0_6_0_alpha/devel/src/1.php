<?php
// KitazDao using variants, class files
require_once "./env.php";



$kd = new KitazDao(SQLITE3_CONFIG);

$ndao = $kd->getDao("DNewsDao");
$ndto = new DNewsDto();

// insert



// update


// delete