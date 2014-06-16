<?php
// KitazDao using variants, class files
require_once __DIR__ . DIRECTORY_SEPARATOR ."KitazDao". DIRECTORY_SEPARATOR ."kitazDao.class.php";
define("KD_DAO_PATH", __DIR__ . DIRECTORY_SEPARATOR ."dao");
define("KD_ENTITY_PATH", __DIR__ . DIRECTORY_SEPARATOR ."entity");

// ファイルアップロード用
$file = @$_FILES['img'];
$alt = @$_POST['alt'];

// ファイル削除用
$delId = @$_POST['iid'];

// upload処理
if (isset($file)){
	$mime = $file['type'];
	$path = $file['tmp_name'];
	$pathInfo = pathinfo($path);
	$fileName = $pathInfo["basename"];
	$size = $file['size'];
	$error = $file['error'];
	$imgInfo = getimagesize($path);
// 	echo $imgInfo[0] . "/". $imgInfo[1];
	$fileImg = file_get_contents($path);

	$kd = new KitazDao("Table1Dao");
	$dto = new Table1Dto();
	
	$kd->begintrans();
	$maxArr = $kd->getMaxTid();
	$maxTid = 0;
	if ($maxArr[0]["mtid"] !== null){
		$maxTid = $maxArr[0]["mtid"] +1;
	}
	$dto->setTid($maxTid);
	$dto->setTname($fileName);
	$dto->setAttribute(0);
	$dto->setTcomment($alt ."\n". $imgInfo[0] ."/". $imgInfo[1]);
	$dto->setTimage($fileImg);
	$kd->insertTable($dto);
	$kd->commit();

// 	$kd->begintrans();
// 	$maxTid = 2;
// 	$dto->setTid($maxTid);
// 	$dto->setTname($fileName);
// 	$dto->setAttribute(2);
// 	$dto->setTcomment($alt ."\n". $imgInfo[0] ."/". $imgInfo[1]);
// 	$dto->setTimage($fileImg);
// 	$kd->updateTable($dto);
// 	$kd->commit();

	$maxArr = $kd->getMaxTid();
	$retArr = $kd->seletTable($maxTid);
	foreach($retArr as $val){
		echo $val["updatedt"] . "<br>";
		echo $val["attribute"] . "<br>";
		echo $val["tid"] . "<br>";
		echo $val["tname"] . "<br>";
		echo  mb_convert_encoding(stream_get_contents($val["tcomment"]), "utf8", "auto") . "<br>";
		echo $val["timage"] . "<br>";
		echo "<br>";
	}
	
// 	$kd->begintrans();
// 	$dto->setTid(3);
// 	$kd->deleteTable($dto);
// 	$kd->commit();
	
	
}

// 削除用
if (isset($delId)){
	
	
}

?>