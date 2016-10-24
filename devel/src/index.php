<?php
// KitazDao using variants, class files
require_once "./env.php";
//define("KD_DEBUG_SQL_OUTPUT_PATH", "1.php.txt");

//$kd = new KitazDao(MYSQL_CONFIG);
//$kd = new KitazDao(SQLSRV_CONFIG);
//$kd = new KitazDao(ORA12C_CONFIG);
//$kd = new KitazDao(PGSQL_CONFIG);
//$kd = new KitazDao(ACCDB_CONFIG);
//$kd = new KitazDao(SQLITE3_CONFIG);

$cSmarty->assign("selectDatabase", $selectDatabase);

$drivers = array();
$drivers[""] = "";
$drivers["mdb"] = "mdb";
$drivers["mysql"] = "mysql";
$drivers["oci"] = "ora12c";
$drivers["pgsql"] = "pgsql";
$drivers["sqlite3"] = "sqlite3";
$drivers["sqlsrv"] = "sqlsrv";
$cSmarty->assign("selectableDatabase", $drivers);

$cSmarty->display(SMARTY_TEMPLATE_DIR . URI_FILE_NAME . ".tpl");