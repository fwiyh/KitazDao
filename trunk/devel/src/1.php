<?php
// KitazDao using variants, class files
require_once "./env.php";
define("KD_DEBUG_SQL_OUTPUT_PATH", "F:\\My Documents\\Projects\\src\\KitazDao\\devel\\src\\1.php.txt");

define("KD_DAO_PATH", "../dao");
define("KD_ENTITY_PATH", "../dto");

$kd = new KitazDao(SQLITE3_CONFIG);
//$kd = new KitazDao(MYSQL_CONFIG);
//$kd = new KitazDao(PGSQL_CONFIG);

$ndao = $kd->getDao("DNewsDao");
$ndto = new DNewsDto();

$r = $ndao->selectSQLStmt("");
var_dump($r);
$r = $ndao->selectSQLStmt(1);
var_dump($r);

exit();

$r = $ndao->getNews(2);
echo "getNews<br>";
var_dump($r);
echo "<br>";

$r = $ndao->selectEveningNews(1);
echo "selectEveningNews<br>";
var_dump($r);
echo "<br>";

$r = $ndao->selectPaperNews(1);
echo "selectPaperNews<br>";
var_dump($r);
echo "<br>";

$r = $ndao->selectPaperNewsOrder(0, 1);
echo "selectPaperNewsOrder<br>";
var_dump($r);
echo "<br>";

$r = $ndao->selectNullPubDate(null);
echo "selectNullPubDate<br>";
var_dump($r);
echo "<br>";
