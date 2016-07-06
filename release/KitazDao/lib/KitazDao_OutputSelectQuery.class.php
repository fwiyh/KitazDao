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
		$ret = array();
		$pdoTypeArray = array();
        
        $pdoTypeArray = $this->getDataType($entity);
        $ret = $this->getValues($stmt, $pdoTypeArray);
        
        return $ret;
    }
    
    public function getDataType($entity){
		// Entityから数値型の配列を取得する
		$refClass = new ReflectionClass($entity);
		$constants = $refClass->getConstants();
		foreach($constants as $key => $val){
			// 定数の最後が「_TYPE」のものを取得する
			if ((strpos($key,"_TYPE") >= strlen($key) -5) && substr($key, 0, -5) != ""){
				// 定数の値からPDOのデータ型を取得する
				$column = strtolower(substr($key, 0, -5));
				$pdoTypeArray[$column] = $val;
			}
		}
        return $pdoTypeArray;
    }
	
    public function getValues($stmt, $pdoTypeArray){
		// 全件取得する
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			// 各行でPDOのINTになっているものだけfloat変換して置き換える
			foreach($row as $key => $v){
				// 整数型扱いのものはピリオドの有無で整数・浮動小数に変更
				switch ($pdoTypeArray[strtolower($key)]){
					case parent::KD_PARAM_INT:
						$row[strtolower($key)] = floatval($v);
						$row[strtoupper($key)] = floatval($v);
						break;
					// ブール型はキャストで変更
					case KitazDao::KD_PARAM_BOOL :
						$row[strtolower($key)] = (bool)$v;
						$row[strtoupper($key)] = (bool)$v;
						break;
					// null型はnullを入れておく
					case KitazDao::KD_PARAM_NULL :
						$row[strtolower($key)] = null;
						$row[strtoupper($key)] = null;
						break;
                    case KitazDao::KD_PARAM_STR :
                        $row[strtolower($key)] = (string)$v;
						$row[strtoupper($key)] = (string)$v;
                        break;
					default:
                        // 数値・文字列・ブール・nullでない場合をdb毎に切り替える
						$this->otherValue($row, $key, $v);
						break;
				}
			}
			$ret[] = $row;
		}
		return $ret;
	}
	
    // 特に何もない場合
    public function otherValue(&$row, $key, $v){
        $row[strtolower($key)] = $v;
        $row[strtoupper($key)] = $v;
    }
}