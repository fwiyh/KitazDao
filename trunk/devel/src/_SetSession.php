<?php
require_once "./env.php";

// セッション配列を取得
$name = $_POST["name"];
$value = $_POST["value"];
$_SESSION[$name] = $value;

$ret["result"] = 0;
$ret["message"] = "";
$ret["data"] = "";

header("Content-type: application/json");
echo json_encode($ret);
