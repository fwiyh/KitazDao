<?php
require_once '../KitazDao/kitazDao.class.php';
define("KD_DAO_PATH", "./dao");
define("KD_ENTITY_PATH", "./entity");

// echo PDO::PARAM_STMT ."<br>";

$pdo = new KitazDao("MSectionDao");
$arr = $pdo->selectWhereTest(" ");
var_dump($arr);

echo "<br>--2-<br>";

$arr = $pdo->selectOrderByTest();
var_dump($arr);

echo "<br>--1-<br>";

$arr = $pdo->selectSection(1);
var_dump($arr);

echo "<br>-0-<br>";

$dto = new MSectionDto();
$dto->setSecid(1);
$dto->setGname("(　´∀｀)");
$pdo->begintrans();
$arr = $pdo->updateSection($dto);
$pdo->commit();

echo "<br>-1-<br>";

$dto = new MSectionDto();
$dto->setSecid(4);
$dto->setGname("てすと");
$dto->setSname("○○部");
$dto->setTel("000-0000-0000");
$dto->setFax("000-0000-0000");
$dto->setDir("/marumaru");
$dto->setEmail("a@a.com");
$pdo->begintrans();
$arr = $pdo->insertSection($dto);
$pdo->commit();

echo "<br>-2-<br>";

$dto = new MSectionDto();
$dto->setSecid(4);
$pdo->begintrans();
$arr = $pdo->deleteSection($dto);
$pdo->commit();

echo "<br>-3-<br>";

$dto = new MSectionDto();
$dto->setSecid(1);
$dto->setGname("G");
$pdo->begintrans();
$arr = $pdo->updateSection($dto);
$pdo->commit();

echo "<br>-4-<br>";

$dto = new MSectionDto();
$dto->setSecid(100);
$dto->setGname("G2");
$pdo->begintrans();
$arr = $pdo->modifyPkSection($dto ,0);
$pdo->commit();

echo "<br>-5-<br>";

$dto = new MSectionDto();
$dto->setSecid(0);
$dto->setGname("G");
$pdo->begintrans();
$arr = $pdo->modifyPkSection($dto ,100);
$pdo->commit();
echo $arr;

echo "<br>-6-<br>";

$pdo = new KitazDao("DImageDao");
$arr = $pdo->selectTargetImage(1);
var_dump($arr);

echo "<br>-7-<br>";

$arr = $pdo->selectBySectionArray(2,null);
var_dump($arr);
// バイナリ出力
// header("Content-Type: ". $arr[0]["MIME"]);
// fpassthru($arr[0]["FILEDATA"]);

echo "<br>-8-<br>";

$dao = new KitazDao("Table1Dao");
$dto = new Table1Dto();
// $dto->setAttribute(0);

$arr = $dao->selectSQLFile($dto);
var_dump($arr);

