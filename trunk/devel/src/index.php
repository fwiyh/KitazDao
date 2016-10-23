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

//$_SESSION["SelectDatabase"]

$cSmarty->assign("selectDatabase", $_SESSION["SelectDatabase"]);

$cSmarty->display(SMARTY_TEMPLATE_DIR . URI_FILE_NAME . ".tpl");