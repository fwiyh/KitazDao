<?php

// セッション配列を取得
$sessionNames = $_POST["name"];
$sessionValues = $_POST["value"];

if (count($sessionNames) != count($sessionValues)){
    $returnInfo = array();
    $returnInfo["result"] = -1;
    $returnInfo["messaage"] = "パラメータ数不一致につき処理は行いません。";
    $returnInfo["data"] = null;
}









function commonReturnJson(){
    
}