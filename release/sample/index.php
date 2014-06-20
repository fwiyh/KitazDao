<?php
require_once '../KitazDao/kitazDao.class.php';
define("KD_DAO_PATH", "./dao");
define("KD_ENTITY_PATH", "./entity");

$pdo = new KitazDao();

$dao = $pdo->getComponent("MSectionDao");
$arr = $dao->selectWhereTest(" ");
var_dump($arr);

echo "<br>-01-<br>";

$arr = $dao->selectOrderByTest();
var_dump($arr);

echo "<br>-02-<br>";

$arr = $dao->selectSection(1);
var_dump($arr);

echo "<br>-03-<br>";

$dto = new MSectionDto();
$dto->setSecid(1);
$dto->setGname("(　´∀｀)");
$pdo->begintrans();
$arr = $dao->updateSection($dto);
$pdo->commit();

echo "<br>-04-<br>";

$dto = new MSectionDto();
$dto->setSecid(4);
$dto->setGname("てすと");
$dto->setSname("○○部");
$dto->setTel("000-0000-0000");
$dto->setFax("000-0000-0000");
$dto->setDir("/marumaru");
$dto->setEmail("a@a.com");
$pdo->begintrans();
$arr = $dao->insertSection($dto);
$pdo->commit();

echo "<br>-05-<br>";

$dto = new MSectionDto();
$dto->setSecid(4);
$pdo->begintrans();
$arr = $dao->deleteSection($dto);
$pdo->commit();

echo "<br>-06-<br>";

$dto = new MSectionDto();
$dto->setSecid(1);
$dto->setGname("G");
$pdo->begintrans();
$arr = $dao->updateSection($dto);
$pdo->commit();

echo "<br>-07-<br>";

$dto = new MSectionDto();
$dto->setSecid(100);
$dto->setGname("G2");
$pdo->begintrans();
$arr = $dao->modifyPkSection($dto ,0);
$pdo->commit();

echo "<br>-08-<br>";

$dto = new MSectionDto();
$dto->setSecid(0);
$dto->setGname("G");
$pdo->begintrans();
$arr = $dao->modifyPkSection($dto ,100);
$pdo->commit();
echo $arr;

echo "<br>-09-<br>";

$dao = $pdo->getComponent("DImageDao");
$arr = $dao->selectTargetImage(1);
var_dump($arr);

echo "<br>-10-<br>";

$arr = $dao->selectBySectionArray(2,null);
var_dump($arr);
// バイナリ出力
// header("Content-Type: ". $arr[0]["MIME"]);
// fpassthru($arr[0]["FILEDATA"]);

echo "<br>-11-<br>";

$dao = $pdo->getComponent("Table1Dao");
$dto = new Table1Dto();
// $dto->setAttribute(0);

$arr = $dao->selectSQLFile($dto);
var_dump($arr);

