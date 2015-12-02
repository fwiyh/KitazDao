<?php
// KitazDao using variants, class files
require_once "./env.php";
define("KD_DEBUG_SQL_OUTPUT_PATH", "F:\\My Documents\\Projects\\src\\KitazDao\\devel\\src\\1.php.txt");

define("KD_DAO_PATH", "../dao");
define("KD_ENTITY_PATH", "../dto");

$ndao = $kd->getDao("DNewsDao");
$ndto = new DNewsDto();

// insert
$nid = 3;
$ndto->setUpdt(Date("Y-m-d H:i:s"));
$ndto->setNid($nid);
$ndto->setTitle("3件目のニュース");
$ndto->setPubdt(Date("Y-m-d 00:00:00"));
$ndto->setPid(3);
$ndto->setIsmorning(0);
$ndto->setPages("12");
$ndto->setAuthor("AAAA0000");
//$ndao->insertNews($ndto);

// update


// delete

$ndao->getMaxId();