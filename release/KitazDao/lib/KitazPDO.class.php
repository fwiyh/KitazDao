<?php
/**
 * KitazDao
 * @name KitazPDO
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

class KitazPDO  {
	
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
	 * construct DB接続してデータベース種別と対象のDaoを取得する
	 * @param String $className Daoクラス名
	 * @param String $cfgName 設定ファイル名
	 * @return boolean falseは接続失敗
	 */
	public function __construct($cfgName = "KitazDao.config"){
		// 設定ファイルからDSN情報を取得
		$dsnArr = array();
		$dsnArr = $this->getConfig($cfgName);
		
		// DB接続
		if (!$this->connect($dsnArr)){
			throw new KitazDaoException(3);
		}
		
		// DSN文字列からデータベース種別を判別
		$this->dbType = substr($dsnArr["dsn"], 0, strpos($dsnArr["dsn"], ":"));
	}
	/**
	 * PDOオブジェクトを返す
	 * @return PDOクラス
	 */
	public function getPdo(){
		return $this->pdo;
	}
	/**
	 * DBタイプを返す
	 * @return DB種別文字列
	 */
	public function getDbType(){
		return $this->dbType;
	}
	/**
	 * destructマジックメソッド
	 * PDO変数にnullを代入してデータベース接続を解除する
	 */
	public function __destruct(){
		$this->pdo = null;
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
	 * 設定ファイルからDSN情報を取得
	 * @param unknown $cfgName
	 * @throws KitazDaoException
	 * @return PDO設定情報(dsn,username,passwd,options(array)):
	 */
	private function getConfig($cfgName){
		// 戻り値
		$ret = array();
		
		// 設定ファイルを読み込む
		$iniArr = parse_ini_file(substr(__DIR__, 0, strrpos(__DIR__, DIRECTORY_SEPARATOR)) . DIRECTORY_SEPARATOR . $cfgName, true);
		if ($iniArr === false){
			throw new KitazDaoException(1);
		}
		
		// 設定ファイルからDSN文字列作成
		if (!array_key_exists("DBSetting", $iniArr)){
			throw new KitazDaoException(2, "NO [DBsetting] SECTION.");
		}
		$cfgmsg = array();
		if (!array_key_exists("dsn", $iniArr["DBSetting"])){
			$cfgmsg[] = "\"dsn\"";
		}
		if (!array_key_exists("user", $iniArr["DBSetting"])){
			$cfgmsg[] = "\"user\"";
		}
		if (!array_key_exists("password", $iniArr["DBSetting"])){
			$cfgmsg[] = "\"password\"";
		}
		if (count($cfgmsg) > 0){
			throw new KitazDaoException(2, "NO PROPERTY: ". implode(",", $cfgmsg));
		}
		$ret["dsn"] = $iniArr["DBSetting"]["dsn"];
		$ret["username"] = $iniArr["DBSetting"]["user"];
		$ret["passwd"] = $iniArr["DBSetting"]["password"];
		
		// PDO接続オプションの配列作成
		$options = array();
		if (array_key_exists("option", $iniArr["DBSetting"])){
			$opStr = $iniArr["DBSetting"]["option"];
			$opArr = explode(",", $opStr);
			try {
				foreach ($opArr as $a){
					$opElm = explode("=>", $a);
					eval("\$options[". trim($opElm[0]) ."] = " . trim($opElm[1]) .";");
				}
			}catch (Exception $e){
				throw new KitazDaoException(2, "IRRIGAL OPTION ARRAY. ", $e);
			}
		}
		$ret["options"] = $options;
		return $ret;
	}
	
	/**
	 * DB接続処理
	 * @param array $dsnArr 設定ファイルから取得したDSN情報
	 * @return DB接続成否
	 */
	private function connect($dsmArr){
		try {
			$this->pdo = new PDO($dsmArr["dsn"], $dsmArr["username"], $dsmArr["passwd"], $dsmArr["options"]);
		} catch (PDOException $e){
			return false;
		}
		return true;
	}
}
?>