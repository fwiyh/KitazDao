<?php
require_once "../../KitazDao/kitazDao.class.php";

define("DB_CONFIG_DIR", "..". DIRECTORY_SEPARATOR ."config". DIRECTORY_SEPARATOR);

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

// dao定数 
if ($_SESSION["SelectDatabase"] == "accdb"){
	define("KD_DAO_PATH", "../dao_mdb");
}else {
	define("KD_DAO_PATH", "../dao");
}
// dto定数
if ($_SESSION["SelectDatabase"] == "olacle"){
	define("KD_ENTITY_PATH", "../dto_ora");
}else if ($_SESSION["SelectDatabase"] == "sqlsvr"){
	define("KD_ENTITY_PATH", "../dto_sqlsrv");
}else {
	define("KD_ENTITY_PATH", "../dto");
}

