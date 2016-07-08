<?php
// KitazDao using variants, class files
require_once "./env.php";
define("KD_DEBUG_SQL_OUTPUT_PATH", "1.php.txt");

define("KD_DAO_PATH", "../dao");
define("KD_ENTITY_PATH", "../dto");

//$kd = new KitazDao(SQLITE3_CONFIG);
//$kd = new KitazDao(MYSQL_CONFIG);
$kd = new KitazDao(PGSQL_CONFIG);

$dao = $kd->getDao("DSpeachDao");

$updt = Date("Y-m-d H:i:s", strtotime("now"));
$sid = 1;
$title = $_POST["title"];
// バイナリデータ
$fp = fopen($_FILES["img"]["tmp_name"], "rb");
$imgdat = fread($fp, filesize($_FILES["img"]["tmp_name"]));
fclose($fp);
//$imgdat = addslashes($imgdat);

$dto = new DSpeachDto();
$dto->setSid($sid);
$dao->deleteMedia($dto);

$dto = new DSpeachDto();
$dto->setUpdt($updt);
$dto->setSid($sid);
$dto->setTitle($title);
$dto->setMedia($imgdat);

$dao->insertMedia($dto);

echo "complete";




