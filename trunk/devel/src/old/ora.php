<?php
$config = new \Doctrine\DBAL\Configuration();
//..
$connectionParams = array(
    'dbname' => '<SERVICE_NAME>',
    'user' => 'user',
    'password' => 'secret',
    'host' => 'localhost',
    'driver' => 'oci8',
    'port' => 1521,
    'charset' => 'AL32UTF8',
    'db_event_subscribers' => 'Doctrine\DBAL\Event\Listeners\OracleSessionInit',
    'service' => true
);
$conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);