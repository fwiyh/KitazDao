<?php
class KitazDaoException extends Exception {
	
	/**
	 * エラーメッセージ集
	 */
	private $msgUnknown = "CATCH TO UNDEFINED MESSAGE.";
	// for KitazDao
	private $msg1001 = "not found config file.";
	private $msg1002 = "no define parameter in config file.";
	private $msg1003 = "can not connect database.";
	private $msg1004 = "not found Dao class.";
	private $msg1005 = "can not get Entity name in Dao.";
	private $msg1006 = "not found Entity class.";
	private $msg1007 = "not be defined method in Dao.";
	private $msg1008 = "occur PDO Exception.";
	private $msg1009 = "occur Exception in Building Query.";
	// for CreateQuery
	private $msg1101 = "";
	private $msg1102 = "";
	private $msg1103 = "";
	
	public function __construct($eid, $message = null, Exception $e = null){
		
		
		
		parent::__construct($message, $code, $e);
	}
	
	// private
	/**
	 * メッセージIDから変数になっているエラー文字列を取得
	 * @param Integer $msgId メッセージId
	 * @return String カスタムエラーメッセージ文字列
	 */
	 private function getMessage($msgId){
		try {
			return $this->{"msg".$msgId};
		}catch (Exception $e){
			return $msgUnknown;
		}
	 }
}