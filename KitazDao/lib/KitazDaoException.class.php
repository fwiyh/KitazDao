<?php
/**
 * KitazDao
 * @name KitazDaoException
 * @author keikitazawa
 * @since 0.3.0
 */
class KitazDaoException extends Exception {
	
	/**
	 * エラーメッセージ集
	 */
	private $msgUnknown = "CATCH TO UNDEFINED MESSAGE.";
	// for KitazDao
	private $msg1 = "not found config file.";
	private $msg2 = "no define parameter in config file.";
	private $msg3 = "can not connect database.";
	private $msg4 = "not found Dao class.";
	private $msg5 = "can not get Entity name in Dao.";
	private $msg6 = "not found Entity class.";
	private $msg7 = "not be defined method in Dao.";
	private $msg8 = "occur PDO Exception.";
	private $msg9 = "occur Exception in Preparing Query.";
	
	public function __construct($msgId, $message = null, $e = null){
		
		$msg = $this->getCustomMessage($msgId);
		if ($message != null){
			$msg = $msg ." following message is :". $message;
		}
		
		parent::__construct($msg, $msgId, $e);
	}
	
	// private
	/**
	 * メッセージIDから変数になっているエラー文字列を取得
	 * @param Integer $msgId メッセージId
	 * @return String カスタムエラーメッセージ文字列
	 */
	 private function getCustomMessage($msgId){
		try {
			return $this->{"msg".$msgId};
		}catch (Exception $e){
			return $this->msgUnknown;
		}
	 }
}