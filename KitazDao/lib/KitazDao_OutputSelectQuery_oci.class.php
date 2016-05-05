<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "KitazDao_OutputSelectQuery.class.php";

/**
 * KitazDao
 * @name KitazDao_OutputSelectQuery_oci
 * @author keikitazawa
 */
class KitazDao_OutputSelectQuery_oci extends KitazDao_OutputSelectQuery {
	
	/*
	 * oracle11gにてBLOBをPDO::PARAM_LOBで返すと値が取得できないため、
	 * ストリームオブジェクトのみをそのまま引き渡すために
	 * まず全件取得してから、INTを数値に置き換える処理に変更
	 */
    // lob型の扱い
    public function otherValue(&$row, $key, $v){
        // $vはストリーミングのID
        $b = "";
        // バッファオフ
        ob_end_clean();
        // バッファの取り込み
        ob_start();
        echo $v;
        $b = ob_get_contents();
        ob_end_clean();
        $row[strtolower($key)] = $b;
        $row[strtoupper($key)] = $b;
    }
}