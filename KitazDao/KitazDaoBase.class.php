<?php
/**
 * KitazDao
 * @name KitazDaoBase
 * @author keikitazawa
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

 class KitazDaoBase {
	/**
	 * Exceptionメッセージの格納場所
	 * @var メッセージ文字列の配列
	 */
	private $messages = array();
	
	/**
	 * エラーメッセージ集
	 */
	private $msgUnknown = "未設定のエラー";
	private $msg1 = "データベース接続に失敗しました。";
	private $msg2 = "SQL実行エラー。SQL文が作成されていない、キーが重複しているなどの問題があります。";
	private $msg3 = "クエリ種別判定エラー。";
	private $msg4 = "指定されたDaoにメソッドがありません。";
	private $msg5 = "Daoのパスが正しくないか、Daoクラスが存在しません。";
	private $msg6 = "Entityのパスが正しくないか、Entityクラスが存在しません。";
	private $msg7 = "DaoにBEANの指定がありません。";
	private $msg8 = "第1パラメータに実行で必要になるEntityが渡されていません。";
	private $msg9 = "SQL実行時にエラーが発生しました。";
	
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
	 * PDOExcetionによるエラーメッセージの作成～取得
	 * @param PDOException $e PDO例外オブジェクト
	 * @param Integer $msgId メッセージID 
	 * @return string エラー文字列
	 */
	protected function getExceptionMessage($e, $msgId){
		try {
			return "KitazDao catch PDOException:[". $e->getCode() ."]". $e->getMessage() ."<br />". $this->getMessage($msgId);
		} catch (Exception $ex){
			echo "KitazDaoBase(getExceptionMessage) catch Exception:[". $ex->getCode() ."]". $ex->getMessage();
		}
	}
	/**
	 * PDOException以外のカスタムエラーを返す
	 * @param Integer $msgId メッセージID
	 * @return string エラーメッセージ
	 */
	protected function getCustomExceptionMessage($msgId){
		return "KitazDao catch CustomException:[". $msgId ."]". $this->getMessage($msgId);
	}
	/**
	 * PDOエラー用
	 * @param PDOException $e
	 * @param unknown $msgId
	 * @return string
	 */
	protected function getPDOErrorInfoMessage($pdo){
		try {
			$pi = $pdo->errorInfo();
			return "KitazDao catch Expected Exception:[". $pi[0] ."]". $pi[1] ."<br />". $pi[2]."<br />";
		} catch (Exception $ex){
			echo "KitazDaoBase(getPDOErrorInfoMessage) catch Exception:[". $ex->getCode() ."]". $ex->getMessage();
		}
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