<?php
require_once "./env.php";

// セッション配列を取得
$name = $_POST["name"];
unset($_SESSION[$name]);

$ret["result"] = 0;
$ret["message"] = "";
$ret["data"] = "";

header("Content-type: application/json");
echo json_encode($ret);
