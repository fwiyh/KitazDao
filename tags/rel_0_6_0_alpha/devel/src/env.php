<?php
require_once "../../KitazDao/kitazDao.class.php";

define("KD_DAO_PATH", "../dao");
define("KD_ENTITY_PATH", "../dto");

$env_confdir = substr(__DIR__, 0, strrpos(__DIR__, DIRECTORY_SEPARATOR)) . DIRECTORY_SEPARATOR . "conf". DIRECTORY_SEPARATOR;
define("MYSQL_CONFIG", $env_confdir ."KitazDao.mysql.config");
define("SQLSRV_CONFIG", $env_confdir ."KitazDao.sqlsrv.config");
define("ORA12C_CONFIG", $env_confdir ."KitazDao.ora12c.config");
define("PGSQL_CONFIG", $env_confdir ."KitazDao.pgsql.config");
define("ACCDB_CONFIG", $env_confdir ."KitazDao.accdb.config");
define("SQLITE3_CONFIG", $env_confdir ."KitazDao.sqlite3.config");
