<?php
require_once "../../KitazDao/kitazDao.class.php";
require_once "../class/Smarty/Smarty.class.php";

define("DB_CONFIG_DIR", "..". DIRECTORY_SEPARATOR . "class" . DIRECTORY_SEPARATOR ."config". DIRECTORY_SEPARATOR);

define("MYSQL_CONFIG", DB_CONFIG_DIR ."KitazDao.mysql.config");
define("SQLSRV_CONFIG", DB_CONFIG_DIR ."KitazDao.sqlsrv.config");
define("ORA12C_CONFIG", DB_CONFIG_DIR ."KitazDao.ora12c.config");
define("PGSQL_CONFIG", DB_CONFIG_DIR ."KitazDao.pgsql.config");
define("ACCDB_CONFIG", DB_CONFIG_DIR ."KitazDao.accdb.config");
define("SQLITE3_CONFIG", DB_CONFIG_DIR ."KitazDao.sqlite3.config");

// アクセスファイルのファイルシステムパス
define("FILESYSTEM_CURRENT_DIRECTORY", __DIR__);
// URLパス
define("URI_CURRENT_DIRECTORY", $_SERVER['PHP_SELF']);
// file名
define("URI_FILE_NAME", pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME));
// 拡張子
define("URI_FILE_EXTENSION", pathinfo($_SERVER['PHP_SELF'], PATHINFO_EXTENSION));

// 選択DBを取得
$selectDatabase = "";
if (isset($_SESSION["SelectDatabase"])){
	$selectDatabase = $_SESSION["SelectDatabase"];
}
// dao定数 
if ($selectDatabase == "accdb"){
	define("KD_DAO_PATH", "../dao_mdb");
}else {
	define("KD_DAO_PATH", "../dao");
}
// dto定数
if ($selectDatabase == "olacle"){
	define("KD_ENTITY_PATH", "../dto_ora");
}else if ($selectDatabase == "sqlsvr"){
	define("KD_ENTITY_PATH", "../dto_sqlsrv");
}else {
	define("KD_ENTITY_PATH", "../dto");
}

// smarty定数
define("SMARTY_TEMPLATE_DIR", "../" . DIRECTORY_SEPARATOR . "class" .DIRECTORY_SEPARATOR . "templates" . DIRECTORY_SEPARATOR);

// smarty変数
$cSmarty = new Smarty();
$cSmarty->template_dir = "..". DIRECTORY_SEPARATOR . "class" . DIRECTORY_SEPARATOR ."templates". DIRECTORY_SEPARATOR;
$cSmarty->compile_dir = "..". DIRECTORY_SEPARATOR . "class" . DIRECTORY_SEPARATOR ."templates_c". DIRECTORY_SEPARATOR;