<?php
/**
 * KitazDao
 * @name egen.php
 * @author keikitazawa
 */

// パラメータ数チェック
if ($argc < 2){
	echo "command: egen.php csvfile tablename";
	exit();
}

$path = $argv[1];
$tbl = $argv[2];
$ent = getEntityName($path);

// ファイル存在チェック
if (!file_exists($path)){
	echo "file not found.";
	exit();
}

// csvとしてファイルを開く
$fo = fopen($path, "r");
if ($fo === false){
	echo "could not open file.";
	exit();
}

// 変数の初期化
$p = array();
$t = array();
$k = array();
$a = array();

// CSVファイルを取得する
while (($csv = fgetcsv($fo)) !== false) {
	$arr = array("", "STR", 0);
	switch (count($csv)){
		case 0:
			continue;
		case 1:
			$arr[0] = $csv[0];
			break;
		case 2:
			$arr[0] = $csv[0];
			$arr[1] = $csv[1];
			break;
		default:
			$arr[0] = $csv[0];
			$arr[1] = $csv[1];
			$arr[2] = $csv[2];
			break;
	}
	$p[] = "\tprivate $". $arr[0] .";";
	$t[] = "\tconst ". strtoupper($arr[0]) ."_TYPE = KitazDao::KD_PARAM_". strtoupper($arr[1]) .";";
	if ($arr[2] == 1){
		$k[] = strtoupper($arr[0]);
	}
	$a[] = getAccessor($arr[0]);
}
fclose($fo);

$retStr = getEntity($ent, $tbl, $p, $t, $k, $a);

file_put_contents($ent .".class.php", $retStr);


/*
 * functions
 */
function getEntityName($path){
	$ret = "";
	$pos = strrpos($path, DIRECTORY_SEPARATOR);
	if ($pos === false){
		$ret = ucfirst($path);
	}else {
		$ret = ucfirst(substr($path, $pos));
	}
	$pos = strrpos($ret, ".");
	if ($pos !== false){
		$ret = substr($path, 0, $pos);
	}
	return $ret;
}

function getAccessor($str){
	
	$mstr = ucfirst($str);
	
	$ret = 
	"\t/**\n".
	 "\t * getter/setter of $str\n".
	 "\t**/\n".
	 "\tpublic function get$mstr() {\n".
	 "\t\treturn \$this->$str;\n".
	 "\t}\n".
	 "\tpublic function set$mstr($$str) {\n".
	 "\t\t\$this->$str = $$str;\n".
	 "\t}\n";
	
	return $ret;
}

function getEntity($ent, $tbl, $p, $t, $k, $a){
	$clss = "<?php\n".
			"class $ent {\n".
			"\n".
			"\tconst TABLE = \"$tbl\";\n".
			"\n".
			implode("\n", $p).
			"\n".
			"\n".
			implode("\n", $t).
			"\n".
			"\n".
			"\tconst PRIMARY_KEY = \"". implode(",", $k) ."\";\n".
			"\n".
			implode("", $a).
			"}";
	return $clss;
}