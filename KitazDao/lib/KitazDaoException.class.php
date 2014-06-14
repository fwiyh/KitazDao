<?php
/**
 * KitazDao
 * @name KitazDaoException
 * @author keikitazawa
 * @since 0.3.0
 */
// ----------------------------------------------------------------------------
// The MIT License (MIT)
//
// Copyright (c) 2014 keikitazawa
//
// Permission is hereby granted, free of charge, to any person obtaining a copy
// of this software and associated documentation files (the "Software"), to deal
// in the Software without restriction, including without limitation the rights
// to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
// copies of the Software, and to permit persons to whom the Software is
// furnished to do so, subject to the following conditions:
//
// The above copyright notice and this permission notice shall be included in
// all copies or substantial portions of the Software.
//
// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
// IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
// FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
// AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
// LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
// OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
// THE SOFTWARE.

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
	
	public function __construct($msgId, $message = null, Exception $e = null){
		
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
			return $msgUnknown;
		}
	 }
}