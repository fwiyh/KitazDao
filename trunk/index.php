<?php
// KitazDao using variants, class files
require_once './KitazDao/kitazDao.class.php';
define("KD_DAO_PATH", "./dao");
define("KD_ENTITY_PATH", "./entity");

// echo PDO::PARAM_STMT ."<br>";

$pdo = new KitazDao("MSectionDao");
// $arr = $pdo->selectWhereTest(" ");
// var_dump($arr);

// $dto = new MSectionDto();
// echo get_class($dto);
// $test = "";
// if (!@get_class($test)){
// 	echo "test!";
// }else {
// 	echo get_class($test);
// }

// var_dump($arr);
// exit();
$arr = $pdo->selectOrderByTest();
var_dump($arr);

$arr = $pdo->selectSection(1);
var_dump($arr);

$dto = new MSectionDto();
$dto->setSecid(1);
$dto->setGname("(　´∀｀)");
$pdo->begintrans();
$arr = $pdo->updateSection($dto);
$pdo->commit();

echo "<br>-1-<br>";

$dto = new MSectionDto();
$dto->setSecid(4);
$dto->setGname("資源エネルギー庁");
$dto->setSname("総務課");
$dto->setTel("000-0000-0000");
$dto->setFax("000-0000-0000");
$dto->setDir("/enecho");
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

// echo $arr;
// $pdo = new PDO("oci:dbname=//localhost/TESTDB","testdb","testdb");
// $sql = "insert into m_section(secid,gname,sname,tel,fax,email,dir) values(:SECID,:GNAME,:SNAME,:TEL,:FAX,:EMAIL,:DIR)";
// $stmt = $pdo->prepare($sql);
// $stmt->bindValue(":SECID", 20, PDO::PARAM_INT);
// $stmt->bindValue(":GNAME", "グループ２", PDO::PARAM_STR);
// $stmt->bindValue(":SNAME", "セクション３", PDO::PARAM_STR);
// $stmt->bindValue(":TEL", "000-000-0000", PDO::PARAM_STR);
// $stmt->bindValue(":FAX", "000-000-0000", PDO::PARAM_STR);
// $email = "a@a.com";
// $stmt->bindValue(":EMAIL", $email, PDO::PARAM_STR);
// $stmt->bindValue(":DIR", "grp2sec3", PDO::PARAM_STR);
// $ret = $stmt->execute();
// echo $ret;
