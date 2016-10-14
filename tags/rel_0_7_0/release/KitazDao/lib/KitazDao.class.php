<?php
require_once __DIR__ . DIRECTORY_SEPARATOR ."KitazDaoCore.class.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . "KitazDaoBase.class.php";

/**
 * KitazDao
 * @name KitazDao
 * @author keikitazawa
 */
class KitazDao extends KitazDaoBase {
	
	/**
	 * PDOオブジェクト
	 * @var PDO
	 */
	private $pdo;
	/**
	 * DB種別
	 * @var string
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
		$dsnArr = $this->getConfig($cfgName);
		
		$eo = null;
		if (!$this->connect($dsnArr, $eo)){
			// @TODO 例外握りつぶしていた
			echo $eo->getMessage();
			throw new KitazDaoException(3);
		}
		
		// DSN文字列からデータベース種別を判別
		$this->dbType = substr($dsnArr["dsn"], 0, strpos($dsnArr["dsn"], ":"));
	}
	/**
	 * Daoを取得する
	 * @param String $className
	 * @param dao $dao Eclipseコード補完機能対策でdaoの参照渡しを行う
	 * @return KitazDao
	 */
	public function getDao($className, &$dao = null){
		if (isset($dao)){
			$dao = new KitazDaoCore($className, $this->pdo, $this->dbType);
		}else {
			return new KitazDaoCore($className, $this->pdo, $this->dbType);
		}
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
		
		// @since 0.6.0 ディレクトリセパレートがある場合はそのままのパスを渡す
		$dsnstr = $cfgName;
		if (strpos($dsnstr, DIRECTORY_SEPARATOR) === false){
			// KitazDaoディレクトリ直下を参照する
			$dsnstr = substr(__DIR__, 0, strrpos(__DIR__, DIRECTORY_SEPARATOR)) . DIRECTORY_SEPARATOR . $dsnstr;
		}
		
		// 設定ファイルを読み込む
		$iniArr = parse_ini_file($dsnstr, true);
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
	private function connect($dsnArr, &$eo){
		try {
			$this->pdo = new PDO($dsnArr["dsn"], $dsnArr["username"], $dsnArr["passwd"], $dsnArr["options"]);
		} catch (PDOException $e){
			$eo = $e;
			return false;
		}
		return true;
	}
}
?>