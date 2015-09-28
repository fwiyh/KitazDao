<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "KitazDaoException.class.php";
/**
 * KitazDao
 * @name KitazDaoBase
 * @author keikitazawa
 */
class KitazDaoBase {
	/**
	 * メソッド種別(Insert)
	 * @var Integer
	 */
	const KD_STMT_INSERT = 1;
	/**
	 * メソッド種別(Update)
	 * @var Integer
	 */
	const KD_STMT_UPDATE = 2;
	/**
	 * メソッド種別(Delete)
	 * @var Integer
	 */
	const KD_STMT_DELETE = 3;
	/**
	 * メソッド種別(Select)
	 * @var Integer
	 */
	const KD_STMT_SELECT = 4;
	
	/**
	 * 変数種別 PDO null
	 * @var Integer
	 */
	const KD_PARAM_NULL = PDO::PARAM_NULL;
	/**
	 * 変数種別 PDO Integer
	 * @var unknown
	 */
	const KD_PARAM_INT = PDO::PARAM_INT;
	/**
	 * 変数種別 PDO String
	 * @var Integer
	 */
	const KD_PARAM_STR = PDO::PARAM_STR;
	/**
	 * 変数種別 PDO LOB
	 * @var Integer
	 */
	const KD_PARAM_LOB = PDO::PARAM_LOB;
	/**
	 * 変数種別 PDO STMT(Recordset Type)
	 * @var Integer
	 */
	const KD_PARAM_STMT = PDO::PARAM_STMT;
	/**
	 * 変数種別 PDO Boolean
	 * @var Integer
	 */
	const KD_PARAM_BOOL = PDO::PARAM_BOOL;
	// 
	/**
	 * 変数種別 PDOプロシージャ
	 * @var Integer -2147483648
	 */
	const KD_PARAM_IO = PDO::PARAM_INPUT_OUTPUT;
	
	/**
	 * 変数種別 KD OCI_CLOB 16+PARAM_STR
	 * @var Integer
	 */
	const KD_PARAM_OCI_CLOB = 18;
	/**
	 * 変数種別 KD OCI_BLOB 16+PARAM_LOB
	 * @var Integer
	 */
	const KD_PARAM_OCI_BLOB = 19;
	
	/**
	 * 変数種別 KD_PARAM_SQLSRV_TEXT 32+PARAM_STR
	 * @var Integer
	 */
	const KD_PARAM_SQLSRV_TEXT = 34;
	/**
	 * 変数種別 KD_PARAM_SQLSRV_BINARY 32+PARAM_LOB
	 * @var Integer
	 */
	const KD_PARAM_SQLSRV_BINARY = 35;
	
	/**
	 * カンマ区切りの数値文字列からfloat型配列を返す
	 * @param unknown $str
	 * @return multitype:
	 */
	protected function getNumArray($str){
		$ret = array();
		$arr = explode(",", $str);
		foreach ($arr as $r){
			if (is_numeric($r)){
				$ret[] = (double)$r;
			}else {
				$ret[] = (string)$r;
			}
		}
	}
}