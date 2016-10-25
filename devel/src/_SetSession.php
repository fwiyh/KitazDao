<?php
require_once "./env.php";

// セッション配列を取得
$name = $_POST["name"];
$value = $_POST["value"];
$_SESSION[$name] = $value;

$ret = array();
$ret["result"] = 0;
$ret["message"] = "";
$ret["data"] = "";

header("Content-Type: application/json; charset=UTF-8");
header("X-Content-Type-Options: nosniff");
echo json_encode($ret);
