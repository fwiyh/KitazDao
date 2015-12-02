<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "KitazDaoBase.class.php";

/**
 * KitazDao
 * @name KitazDao_OutputSelectQuery
 * @author keikitazawa
 */
class KitazDao_OutputSelectQuery extends KitazDaoBase {
	
	/*
	 * oracle11gにてBLOBをPDO::PARAM_LOBで返すと値が取得できないため、
	 * ストリームオブジェクトのみをそのまま引き渡すために
	 * まず全件取得してから、INTを数値に置き換える処理に変更
	 */
	/**
	 * SELECTの結果を連想配列で返す
	 * @param Object $stmt execute済みStatementオブジェクト
	 * @param Object $entity Entity（データ型取得のために利用する）
	 * @return multitype:
	 */
	public function getArray($stmt, $entity){
		
		// 実行SELECT文から取得されるcolumnを取得
		$columns = array();
		for ($i = 0; $i < $stmt->columnCount(); $i++){
			$cm = $stmt->getColumnMeta($i);
			$columns[] = $cm["name"];
			$colname = $cm["name"];
			// Entityから
			$stmt->bindColumn($colname, $$colname);
		}
		
		// Eintityから数値型の配列を取得する
//		$refClass = new ReflectionClass($entity);
//		$constants = $refClass->getConstants();
//		// 結果セット配列
//		$paramNameArr = array();
//		foreach($constants as $key => $val){
//			// 定数の最後が「_TYPE」のものを取得する
//			if ((strpos($key,"_TYPE") >= strlen($key) -5) && substr($key, 0, -5) != ""){
//				// 定数の値からPDOのデータ型を取得する
//				$column = strtolower(substr($key, 0, -5));
//				// 項目名, バインドさせる変数, データ型S
//				$stmt->bindColumn($column, $$column, $val);
//				$paramNameArr[] = $column;
//			}
//		}
		$retArr = array();
		while ($stmt->fetch(PDO::FETCH_BOUND)){
			$tmpArr = array();
			// パラメータすべての配列を作成して１レコードを作成する
			foreach ($columns as $pn){
				// 全小文字
				$tmpArr[$pn] = $$pn;
				// 全大文字
				$tmpArr[strtoupper($pn)] = $$pn;
			}
			$retArr[] = $tmpArr;
		}
		
		// 全件取得する
//		$retArr = $this->fetch($stmt, $paramNameArr);
		return $retArr;
	}
	
	/**
	 * bindColumnによるfetchと値取得
	 * @param type $stmt
	 * @param type $paramNameArr
	 * @return type
	 */
	public function fetch($stmt, $paramNameArr){
		$retArr = array();
		while ($row = $stmt->fetch(PDO::FETCH_BOUND)){
			$tmpArr = array();
			// パラメータすべての配列を作成して１レコードを作成する
			foreach ($paramNameArr as $pn){
				// 全小文字
				$tmpArr[$pn] = $$pn;
				// 全大文字
				$tmpArr[strtoupper($pn)] = $$pn;
			}
			$retArr[] = $tmpArr;
		}
		return $retArr;
	}
	
}