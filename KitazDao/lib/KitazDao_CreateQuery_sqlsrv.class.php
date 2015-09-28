<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "KitazDao_CreateQuery.class.php";

/**
 * KitazDao
 * @name KitazDao_CreateQuery_sqlsrv
 * @author keikitazawa
 */
class KitazDao_CreateQuery_sqlsrv extends KitazDao_CreateQuery {
	
	/**
	 * バインド
	 * @param Object $stmt ステートメントオブジェクト
	 * @param array $sqlPHArray プレースホルダーの値の配列
	 * @param array $bindValues 挿入値の配列
	 * @param array $pdoDataType 挿入値のでのPDOデータ型
	 * @return ステートメントオブジェクト
	 */
	public function bind($stmt, $sql){
		for ($i = 0,$max = count($this->bindValues); $i < $max; $i++){
			if (strpos($sql, $this->sqlPHArray[$i]) !== false){
				if ($this->pdoDataType[$i] != parent::KD_PARAM_SQLSRV_BINARY && $this->pdoDataType[$i] != parent::KD_PARAM_SQLSRV_TEXT){
					$stmt->bindParam($this->sqlPHArray[$i], $this->bindValues[$i], $this->pdoDataType[$i]);
				}else if ($this->pdoDataType[$i] == parent::KD_PARAM_SQLSRV_BINARY){
					$stmt->bindParam($this->sqlPHArray[$i], $this->bindValues[$i], parent::KD_PARAM_LOB, 0, PDO::SQLSRV_ENCODING_BINARY);
				}else {
					$stmt->bindParam($this->sqlPHArray[$i], $this->bindValues[$i], parent::KD_PARAM_LOB, 0, PDO::SQLSRV_ENCODING_UTF8);
				}
			}
		}
		return $stmt;
	}
}