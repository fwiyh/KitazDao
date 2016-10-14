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

$updt = Date("Y-m-d H:i:s", strtotime("now"));
$sid = 1;
$title = $_POST["title"];
// バイナリデータ
$fp = fopen($_FILES["img"]["tmp_name"], "rb");
$imgdat = fread($fp, filesize($_FILES["img"]["tmp_name"]));
fclose($fp);
//$imgdat = addslashes($imgdat);

$dto = new DSpeechDto();
$dto->setSid($sid);
$dao->deleteMedia($dto);

$dto = new DSpeechDto();
$dto->setUpdt($updt);
$dto->setSid($sid);
$dto->setTitle($title);
$dto->setMedia($imgdat);

//oci8はトランザクション内でなければバイナリは置けない
$kd->begintrans();
$dao->insertMedia($dto);
$kd->commit();

var_dump($_FILES["img"]);
echo "complete";




