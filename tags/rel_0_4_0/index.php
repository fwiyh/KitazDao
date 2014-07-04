<?php
// KitazDao using variants, class files
require_once './KitazDao/kitazDao.class.php';
define("KD_DAO_PATH", "./dao");
define("KD_ENTITY_PATH", "./entity");

// PDO宣言
$pdo = new KitazDao();

$dao = $pdo->getDao("MSectionDao");
$arr = $dao->selectWhereTest("111");
var_dump($arr);

echo "<br>--2-<br>";

$arr = $dao->selectOrderByTest();
var_dump($arr);

echo "<br>--1-<br>";

$arr = $dao->selectSection(1);
var_dump($arr);

echo "<br>-0-<br>";
$pdo->begintrans();

$dto = new MSectionDto();
$dto->setSecid(1);
$dto->setGname("(　´∀｀)");
$arr = $dao->updateSection($dto);

echo "<br>-1-<br>";

$dto = new MSectionDto();
$dto->setSecid(4);
$dto->setGname("資源エネルギー庁");
$dto->setSname("総務課");
$dto->setTel("000-0000-0000");
$dto->setFax("000-0000-0000");
$dto->setDir("/enecho");
$dto->setEmail("a@a.com");
$arr = $dao->insertSection($dto);

$arr = $dao->selectSection(4);
var_dump($arr);

echo "<br>-2-<br>";

$dto = new MSectionDto();
$dto->setSecid(4);
$arr = $dao->deleteSection($dto);

echo "<br>-3-<br>";

$dto = new MSectionDto();
$dto->setSecid(1);
$dto->setGname("G");
$arr = $dao->updateSection($dto);

echo "<br>-4-<br>";

$dto = new MSectionDto();
$dto->setSecid(100);
$dto->setGname("G2");
$arr = $dao->modifyPkSection($dto ,0);

echo "<br>-5-<br>";

$dto = new MSectionDto();
$dto->setSecid(0);
$dto->setGname("G");
$arr = $dao->modifyPkSection($dto ,100);
echo $arr;

$pdo->commit();

echo "<br>-6-<br>";

$dao = $pdo->getDao("DImageDao");
$arr = $dao->selectTargetImage(1);
var_dump($arr);

echo "<br>-7-<br>";

$arr = $dao->selectBySectionArray(2,null);
var_dump($arr);
// バイナリ出力
// header("Content-Type: ". $arr[0]["MIME"]);
// fpassthru($arr[0]["FILEDATA"]);

echo "<br>-8-<br>";

$dao = $pdo->getDao("Table1Dao");
$dto = new Table1Dto();
// $dto->setAttribute(0);
$dto->setTname("null");
$arr = $dao->selectSQLFile($dto);
var_dump($arr);




unset($pdo);
