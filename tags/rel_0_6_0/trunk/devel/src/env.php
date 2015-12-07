<?php
require_once "../../KitazDao/kitazDao.class.php";

define("DB_CONFIG_DIR", "..". DIRECTORY_SEPARATOR ."config". DIRECTORY_SEPARATOR);

define("MYSQL_CONFIG", DB_CONFIG_DIR ."KitazDao.mysql.config");
define("SQLSRV_CONFIG", DB_CONFIG_DIR ."KitazDao.sqlsrv.config");
define("ORA12C_CONFIG", DB_CONFIG_DIR ."KitazDao.ora12c.config");
define("PGSQL_CONFIG", DB_CONFIG_DIR ."KitazDao.pgsql.config");
define("ACCDB_CONFIG", DB_CONFIG_DIR ."KitazDao.accdb.config");
define("SQLITE3_CONFIG", DB_CONFIG_DIR ."KitazDao.sqlite3.config");
