<?php
require_once dirname(__FILE__) .'/KitazDao_GetDataType.class.php';
require_once dirname(__FILE__) .'/KitazDao_GetObject.class.php';
require_once __DIR__ .'/KitazDao_OutputSelectQuery.class.php';
require_once __DIR__ .'/KitazDaoBase.class.php';

/**
 * KitazDao
 * @name KitazDao
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

class KitazDao extends KitazDaoBase {
	
	/**
	 * PDOオブジェクト
	 * @var PDOクラス
	 */
	private $pdo;
	/**
	 * DB種別
	 * @var DB種別文字列
	 *  mysql/sqlite2/sqlite/pgsql/oci/dblib/sqlsrv
	 */
	private $dbType;
	/**
	 * 処理対象になるDao
	 * @var class
	 */
	private $loadDao;
	/**
	 * 処理対象のEntity
	 * @var class
	 */
	private $loadEntity;
	
	/**
	 * construct DB接続してデータベース種別と対象のDaoを取得する
	 * @param String $className Daoクラス名
	 * @return boolean falseは接続失敗
	 */
	public function __construct($className){
		// 設定ファイルを読み込む
		$iniArr = parse_ini_file(substr(__DIR__, 0, strrpos(__DIR__, DIRECTORY_SEPARATOR)) ."/KitazDao.config", true);
		// 設定ファイルからDSN文字列作成
		$dsn = $iniArr["DBSetting"]["dsn"];
		$username = $iniArr["DBSetting"]["user"];
		$passwd = $iniArr["DBSetting"]["password"];
		$opStr = $iniArr["DBSetting"]["option"];
		
		// PDO接続オプションの配列作成
		$opArr = explode(",", $opStr);
		$options = array();
		foreach ($opArr as $a){
			$opElm = explode("=>", $a);
			$options[$opElm[0]] = $opElm[1];
		}
		
		// DB接続
		if (!$this->connect($dsn, $username, $passwd, $options)){
			return false;
		}
		
		// DSN文字列からデータベース種別を判別
		$this->dbType = substr($dsn, 0, strpos($dsn, ":"));
		
		//# Dao/Entityクラス取得
		$getObject = new KitazDao_GetObject();
		// Daoクラスの取得
		$this->loadDao = $getObject->getDaoClass($className);
		if ($this->loadDao === false){
			unset($getObject);
			$this->pdo = null;
			return false;
		}
		// Daoに定義されているEntity名を取得する
		$entityName = $getObject->getEntityNameByDao($this->loadDao);
		if ($entityName === false){
			unset($getObject);
			$this->pdo = null;
			return false;
		}
		// Entityを取得
		$this->loadEntity = $getObject->getEntityClass($entityName);
		if ($this->loadEntity === false){
			unset($getObject);
			$this->pdo = null;
			return false;
		}
		unset($getObject);
	}
	/**
	 * destructマジックメソッド
	 * PDO変数にnullを代入してデータベース接続を解除する
	 */
	public function __destruct(){
		$this->pdo = null;
	}
	/**
	 * アクセス不能メソッドへのアクセス
	 * 　メソッド実行時にカスタムエラーを出力する
	 * @param String $name メソッド名
	 * @param array $arguments パラメータの配列
	 */
	public function __call($name, $arguments){
		
		// dao設定メソッドとしてアクセスする
		if (array_search($name, get_class_methods(get_class($this->loadDao))) === false){
			echo parent::getCustomExceptionMessage(4);
			return false;
		}
		// クエリの実行
		return $this->executeMethod($name, $arguments);
	}

	/**
	 * トランザクションの開始
	 * @return mixed
	 */
	public function begintrans(){
		$this->pdo->beginTransaction();
	}
	/**
	 * コミット＆自動コミットをオン
	 * @return mixed
	 */
	public function commit(){
		$this->pdo->commit();
	}
	/**
	 * ロールバック＆自動コミットをオン
	 * @return mixed
	 */
	public function rollback(){
		$this->pdo->rollBack();
	}
	
	//# private methods
	/**
	 * DB接続処理
	 * @param String $dsn PDOで使うDSN
	 * @param String $username DBのユーザー名
	 * @param String $passwd DBのパスワード
	 * @param array $options PDOで指定できるドライバオプション(ない場合は空の配列)
	 * @return DB接続成否
	 */
	private function connect($dsn, $username, $passwd, $options = array()){
		try {
			$this->pdo = new PDO($dsn, $username, $passwd, $options);
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e){
			echo parent::getExceptionMessage($e, 1);
			return false;
		}
		return true;
	}
	
	/**
	 * constructで取得したクラスのメソッドを実行
	 * @param String $methodName 実行関数名
	 * @param array $arguments 実行される関数のパラメータが格納された配列
	 * @return array 処理結果の連想配列 例）array[0]["secid"]
	 */
	private function executeMethod($methodName, $arguments){
		// DB拡張があればそれを取り込む
		$extClassName = "KitazDao_CreateQuery_" . strtolower($this->dbType);
		$extFilePath = dirname(__FILE__) ."/". $extClassName .".class.php";
		if (file_exists($extFilePath)){
			require_once $extFilePath;
		}else {
			require_once dirname(__FILE__) ."/KitazDao_CreateQuery.class.php";
			$extClassName = "KitazDao_CreateQuery";
		}
		
		// クエリ作成オブジェクトの作成
		$stmt = false;
		
		$createQuery = new $extClassName($this->pdo, $this->loadDao, $this->loadEntity);
		
		// メソッド名からSQL種別を取得してSQL文字列を作成する
		$queryType = KitazDao_GetDataType::getQueryType(get_class($this->loadDao), $methodName);
		$stmt = $createQuery->buildStatement($queryType, $methodName, $arguments);
		unset($createQuery);
		$ret = "";
		// SQL文の実行
		try {
			// no output warning for INSERT/UPDATE from OCI-CLOB
			$ret = @$stmt->execute();
		} catch (PDOException $e){
			echo parent::getExceptionMessage($e, 2);
			return false;
		} catch (Exception $e){
			echo parent::getExceptionMessage($e, 2);
			return false;
		}
		// falseの場合は実行時エラー
		if (empty($ret)){
			echo parent::getCustomExceptionMessage(9);
			return false;
		}
		// select文は全配列を返す
		if ($queryType == parent::KD_STMT_SELECT){
			// PDOのINT/BOOL/NULL指定を行う
			$outputSelectQuery = new KitazDao_OutputSelectQuery();
			return $outputSelectQuery->getArray($stmt, $this->loadEntity);
		}else {
			return $ret;
		}
	}

}
?>