<?php
// KitazDao using variants, class files
require_once "./env.php";
define("KD_DEBUG_SQL_OUTPUT_PATH", "1.php.txt");

define("KD_DAO_PATH", "../dao");
//define("KD_ENTITY_PATH", "../dto");
define("KD_ENTITY_PATH", "../dto_ora");

//$kd = new KitazDao(SQLITE3_CONFIG);
//$kd = new KitazDao(MYSQL_CONFIG);
//$kd = new KitazDao(PGSQL_CONFIG);
$kd = new KitazDao(ORA12C_CONFIG);

$dao = $kd->getDao("DSpeechDao");
$ret = $dao->getMedia(1);

header("Content-Type: image/jpeg");
echo $ret[0]["media"];
exit;