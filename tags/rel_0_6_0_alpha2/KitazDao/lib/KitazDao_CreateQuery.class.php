<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "KitazDaoBase.class.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . "KitazDao_GetDataType.class.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . "KitazDao_AnalyzeSQLFile.class.php";

/**
 * KitazDao
 * @name KitazDao_CreateQuery
 * @author keikitazawa
 */
class KitazDao_CreateQuery extends KitazDaoBase {
	
	/**
	 * DB接続済みPDOオブジェクト
	 * @var Object 
	 */
	protected $pdo;
	/**
	 * クエリ作成元Daoクラス
	 * @var Object
	 */
	protected $dao;
	/**
	 * クエリ作成元Entity
	 * @var Object
	 */
	protected $entity;
	
	/**
	 * sqlパラメータ
	 * @var String
	 */
	protected $sqlParam;
	/**
	 * whereパラメータ
	 * @var String
	 */
	protected $whereParam;
	/**
	 * orderbyパラメータ
	 * @var String
	 */
	protected $orderbyParam;
	/**
	 * カラム名パラメータ
	 * @var String
	 */
	protected $columnsParam;
	/**
	 * データ型パラメータ
	 * @var array
	 */
	protected $typeParam;
    /**
     * null扱いパラメータ
     * @var string
     * @since 0.5.0
     */
    protected $nullParam;
    /**
     * 条件式で扱わないパラメータ
     * @var string
     * @since 0.5.0
     */
    protected $noparam;


    /**
	 * SQL文のカラム部分
	 * @var array
	 */
	protected $sqlColumnArray;
	/**
	 * SQL文のwhere句部分
	 * @var array
	 */
	protected $sqlConditionArray;
	/**
	 * Update文のSET句部分
	 * @var unknown
	 */
	protected $sqlSetArray;
	/**
	 * プレーホルダー変数
	 * @var array
	 */
	protected $sqlPHArray;
	/**
	 * バインド変数に入る値
	 * @var array
	 */
	protected $bindValues;
	/**
	 * PDOのデータ型変数
	 * @var array
	 */
	protected $pdoDataType;
	
	/**
	 * コンストラクタ
	 * @param Object $pdo DB接続済みPDOオブジェクト
	 * @param Object $dao 処理対象Dao
	 * @param Object $entity 対象となるEntity
	 */
	public function __construct($pdo, $dao, $entity){
		// クラスの取得
		$this->pdo = $pdo;
		$this->dao = $dao;
		$this->entity = $entity;
		
		// パラメータ変数の初期化
		$this->sqlParam = "";
		$this->whereParam = "";
		$this->orderbyParam = "";
		$this->columnsParam = "";
		$this->typeParam = array();
        $this->nullParam = "";
        $this->noparam = "";
		
		$this->sqlColumnArray = array();
		$this->sqlConditionArray = array();
		$this->sqlSetArray = array();
		$this->sqlPHArray = array();
		$this->bindValues = array();
		$this->pdoDataType = array();
	}
	
	/**
	 * SQL文を作成してステートメントオブジェクトを返す
	 * @param integer $queryType クエリータイプ by KitazDaoBase
	 * @param String $methodName メソッド名
	 * @param array $arguments パラメータ配列
	 * @return Object PDOのステートメントオブジェクト
	 */
	public function buildStatement($queryType, $methodName, $arguments){
		// パラメータを取得する
		$this->getMethodParams($methodName, $arguments);
		// ファイルが有ればファイルからSQL文を取得
		$this->getSQLFromFile($methodName);
		
		$sql = "";
		$stmt = null;
		
		// SQLファイルかSQLパラメータがある場合はSQLファイル解析でstmtを作成する
		if (strlen($this->sqlParam) > 0){
			$sql = $this->createSQLStatementFromFile($methodName, $arguments);
		// ない場合はクエリタイプ毎にパラメータ解析を行う
		}else {
			switch ($queryType){
				case parent::KD_STMT_SELECT:
					$sql = $this->createSelectStatement($methodName, $arguments);
					break;
				case parent::KD_STMT_INSERT:
					$sql = $this->createInsertStatement($methodName, $arguments);
					break;
				case parent::KD_STMT_UPDATE:
					$sql = $this->createUpdateStatement($methodName, $arguments);
					break;
				case parent::KD_STMT_DELETE:
					$sql = $this->createDeleteStatement($methodName, $arguments);
					break;
				// 判別不能な場合はSELECT文扱い
				default:
					$sql = $this->createSelectStatement($methodName, $arguments);
					break;
			}
		}
		// prepare
		$stmt = $this->prepare($sql);
		//bind処理
		$stmt = $this->bind($stmt, $sql);
		return $stmt;
	}
	
	/**
	 * 呼ばれたメソッドを実行してメソッドパラメータを取得する
	 * @param String $methodName
	 * @param String $arguments
	 */
	public function getMethodParams($methodName, $arguments){
		// メソッドを実行してパラメータを取得する
		$daoParam = call_user_func_array(array($this->dao, $methodName), $arguments);
		// パラメータの取得
		if (isset($daoParam["where"])){
			$this->whereParam = $daoParam["where"];
		}
		if (isset($daoParam["sql"])){
			$this->sqlParam = $daoParam["sql"];
		}
		if (isset($daoParam["orderby"])){
			$this->orderbyParam = $daoParam["orderby"];
		}
		if (isset($daoParam["columns"])){
			$this->columnsParam = $daoParam["columns"];
		}
		if (isset($daoParam["type"])){
			$this->typeParam = $daoParam["type"];
		}
        if (isset($daoParam["null"])){
            $this->nullParam = $daoParam["null"];
        }
        if (isset($daoParam["noparam"])){
            $this->noparam = $daoParam["noparam"];
        }
 	}
	/**
	 * SQLファイルが有ればここからSQL文を取得する
	 * @param String $methodName 呼び出されたメソッドのメソッド名
	 */
	public function getSQLFromFile($methodName){
		$filepath = realpath(KD_DAO_PATH) . DIRECTORY_SEPARATOR . get_class($this->dao) ."_". $methodName .".sql";
		if (file_exists($filepath)){
			// SQLファイルからSQL文を取得
			$this->sqlParam = file_get_contents($filepath);
		}
	}
	
	/**
	 * SQLファイルからSQL文の処理を行う
	 * @param unknown $methodName
	 * @param unknown $arguments
	 */
	public function createSQLStatementFromFile($methodName, $arguments){
		// メソッドのパラメータ名を取得する
		$ref = new ReflectionMethod(get_class($this->dao), $methodName);
		$params = $ref->getParameters();
		// SQL文の分析解釈を行う
		$analyzeSQLFile = new KitazDao_AnalyzeSQLFile();
		$analyzeSQLFile->analyze($params, $arguments, $this->typeParam, $this->sqlParam, $this->sqlPHArray, $this->bindValues, $this->pdoDataType);
		unset($analyzeSQLFile);
		return $this->sqlParam;
	}
	
	/**
	 * Select文の作成
	 * @param String $methodName メソッド名
	 * @param array $arguments メソッドパラメータの配列
	 * @return String SQL文
	 */
	public function createSelectStatement($methodName, $arguments){
		// カラムパラメータがなければ「*」にする
		if (strlen($this->columnsParam) == 0){
			$this->columnsParam = "*";
		}
		// メソッドパラメータから条件式を作成する
		$ref = new ReflectionMethod(get_class($this->dao), $methodName);
		$params = $ref->getParameters();
		for ($i = 0, $max = count($params); $i < $max; $i++){
			// @mod 0.5.0
			$column = $params[$i]->getName();
			$value = $arguments[$i];
			// @since 0.5.0 noparam
			if (stripos($this->noparam, $column) !== false){
				continue;
			}
			// @since 0.5.0 nullParam
			if (stripos($this->nullParam, $column) !== false){
				$value = null;
			}
			// クエリパラメータがある場合はプレースホルダー処理を行う
			if (strlen($this->whereParam) > 0){
				$this->setConditionBindValStatement($value, $column);
			}else {
				// 配列の場合はINで複数条件を割り当てる
				if (is_array($value)){
					$this->setConditionInStatement($value, $column);
				}else {
					$this->setConditionEqualStatement($value, $column);
				}
			}
		}
		// SELECT文を作成する
		$sql = $this->buildSelectSQLString();
		return $sql;
	}
	/**
	 * Select文の文字列を組み立てる
	 * @return string Select文
	 */
	public function buildSelectSQLString(){
		// Entityから対象テーブルを取得する
		$entity = $this->entity;
		$tableName = $entity::TABLE;
		// SQL文字列作成
		$sql = "SELECT ". $this->columnsParam ." FROM $tableName";
		// whereメソッドパラメータを優先する
		if (strlen($this->whereParam) > 0 && preg_match("/^\s{0,}(where)\s{1,}/i", $this->whereParam) == 0){
			$sql .= " WHERE ". $this->whereParam;
		}else if (strlen($this->whereParam) > 0){
			$sql .= " ". $this->whereParam;
		// whereメソッドパラメータがない場合のみENTITYからの条件式作成を行う
		}else if (count($this->sqlConditionArray) > 0){
			$sql .= " WHERE ". implode(" AND ", $this->sqlConditionArray);
		}
		// orderbyパラメータの処理
		if (strlen($this->whereParam) == 0 && strlen($this->orderbyParam) > 0){
			$buf = " ";
			if (preg_match("/^\s{0,}(order)\s{1,}(by)\s{1,}/i", $this->orderbyParam) == 0){
				$buf = " ORDER BY ";
			}
			$sql .= $buf . $this->orderbyParam;
		}
		return $sql;
	}
	
	/**
	 * Insert文の作成
	 * @param String $methodName メソッド名
	 * @param array $arguments メソッドパラメータの配列
	 * @return String SQL文
	 */
	public function createInsertStatement($methodName, $arguments){
		// パラメータのEntityのメソッドごとにSQL文字列とプレースホルダーを生成する
		foreach (get_class_methods($arguments[0]) as $m){
			// getメソッドからパラメータ取得を行う
			if (substr($m, 0, 3) == "get"){
				$column = strtoupper(substr($m, 3));
				// @since 0.5.0 noparam
				if (stripos($this->noparam, $column) !== false){
					continue;
				}
				// getterから値を取得する
				$val = call_user_func_array(array($arguments[0], $m), array());
				// @since 0.5.0 nullParam
				$issetnull = false;
				if (stripos($this->nullParam, $column) !== false){
					$issetnull = true;
					$val = null;
				}
				// 変数がセットされている時にSQL文を作成する
				if (isset($val) || $issetnull){
					$this->sqlColumnArray[] = $column;
					$this->sqlPHArray[] = ":". $column;
					$this->bindValues[] = $val;
					// Entityの定数からPDOのデータ型を取得する
					$this->pdoDataType[] = KitazDao_GetDataType::getPDODataType(get_class($arguments[0]), $column, $val, $this->typeParam);
				}
			}
		}
		// Entityから対象テーブルを取得する
		$tableName = $arguments[0]::TABLE;
		// SQL文を組み立てる
		$sql = $this->buildInsertSQLString($tableName);
		return $sql;
	}
	/**
	 * Insert文の文字列を組み立てる
	 * @param String テーブル名	
	 * @return String Insert文
	 */
	public function buildInsertSQLString($tableName){
		// SQL文字列作成
		$sql = "INSERT INTO $tableName(". implode(",", $this->sqlColumnArray) .") VALUES(". implode(",", $this->sqlPHArray) .")";
		return $sql;
	}
	
	/**
	 * Update文の作成
	 * @param String $methodName メソッド名
	 * @param array $arguments メソッドパラメータの配列
	 * @return String SQL文
	 */
	public function createUpdateStatement($methodName, $arguments){
		//
		// パラメータがEntityのみの場合はEntityのPRIMARY_KEYを条件式に設定する
		// 第２パラメータ以降がある場合は条件式はすべてパラメータのもののみにする
		//
		// パラメータの数を取得する
		$paramNum = count($arguments);
		// PRIMARY_KEYの値を配列として取得する
		$pkeyColumn = strtoupper($arguments[0]::PRIMARY_KEY);
		foreach (get_class_methods($arguments[0]) as $m){
			// getメソッドからパラメータ取得を行う
			if (substr($m, 0, 3) == "get"){
				$column = strtoupper(substr($m, 3));
				// @since 0.5.0 noparam
				if (stripos($this->noparam, $column) !== false){
					continue;
				}
				// getterから値を取得する
				$val = call_user_func_array(array($arguments[0], $m), array());
				// @since 0.5.0 nullParam
				$issetnull = false;
				if (stripos($this->nullParam, $column) !== false){
					$issetnull = true;
					$val = null;
				}
				if (isset($val) || $issetnull){
					// pkey指定かつパラメータがEntityのみの場合に条件式とする
					if (stripos($pkeyColumn, $column) !== false && $paramNum == 1){
						$this->setConditionEqualStatement($val, $column);
					} else {
						$this->setUpdateSetStatement($val, $column, $arguments[0]);
					}
				}
			}
		}
		// パラメータが２つ以上の場合はこれらが条件式になる
		if ($paramNum > 1){
			// メソッドパラメータから条件式を作成する
			$ref = new ReflectionMethod(get_class($this->dao), $methodName);
			$params = $ref->getParameters();
			for ($i = 1, $max = count($params); $i < $max; $i++){
				// @since 0.5.0 
				$column = strtoupper($params[$i]->getName());
				// @since 0.5.0 noparam
				if (stripos($this->noparam, $column) !== false){
					continue;
				}
				$val = $arguments[$i];
				if (isset($val)){
					// クエリパラメータがある場合はプレースホルダー処理を行う
					if (strlen($this->whereParam) > 0){
						$this->setConditionBindValStatement($val, $column);
					}else {
						// 配列の場合はINで複数条件を割り当てる
						if (is_array($val)){
							$this->setConditionInStatement($val, $column, "C_");
						}else {
							$this->setConditionEqualStatement($val, $column, "C_");
						}
					}
				}
			}
		}
		// Entityから対象テーブルを取得する
		$tableName = $arguments[0]::TABLE;
		// SQL文字列作成
		$sql = $this->buildUpdateSQLString($tableName);
		return $sql;
	}
	/**
	 * Update文を組み立てる
	 * @param String $tableName テーブル名
	 * @return String Update文
	 */
	public function buildUpdateSQLString($tableName){
		// SQL文字列作成
		$sql = "UPDATE $tableName SET ". implode(",", $this->sqlSetArray);
		// whereメソッドパラメータを優先する
		if (strlen($this->whereParam) > 0 && preg_match("/^\s{0,}(where)\s{1,}/i", $this->whereParam) == 0){
			$sql .= " WHERE ". $this->whereParam;
		}else if (strlen($this->whereParam) > 0){
			$sql .= " ". $this->whereParam;
			// whereメソッドパラメータがない場合のみENTITYからの条件式作成を行う
		}else if (count($this->sqlConditionArray) > 0){
			$sql .= " WHERE ". implode(" AND ", $this->sqlConditionArray);
		}
		return $sql;
	}
	
	/**
	 * Delete文の作成
	 * @param String $methodName メソッド名
	 * @param array $arguments メソッドに渡されたパラメータ
	 * @return boolean
	 */
	public function createDeleteStatement($methodName, $arguments){
		// パラメータのEntityのメソッドごとにSQL文字列とプレースホルダーを生成する
		foreach (get_class_methods($arguments[0]) as $m){
			// getメソッドからパラメータ取得を行う
			if (substr($m, 0, 3) == "get"){
				$column = strtoupper(substr($m, 3));
				// @since 0.5.0 noparam
				if (stripos($this->noparam, $column) !== false){
					continue;
				}
				// getterから値を取得する
				$val = call_user_func_array(array($arguments[0], $m), array());
				// @since 0.5.0 nullParam
				$issetnull = false;
				if (stripos($this->nullParam, $column) !== false){
					$issetnull = true;
					$val = null;
				}
				// @since 0.5.0 nullParam
				if (isset($val) || $issetnull){
					$this->setConditionEqualStatement($val, $column);
				}
			}
		}
		// Entityから対象テーブルを取得する
		$tableName = $arguments[0]::TABLE;
		// SQL文を組み立てる
		$sql = $this->buildDeleteSQLString($tableName);
		return $sql;
	}
	/**
	 * Delete文を組み立てる
	 * @param String $tableName テーブル名
	 * @return String Delete文
	 */
	public function buildDeleteSQLString($tableName){
		// SQL文字列作成
		$sql = "DELETE FROM $tableName";
			// whereメソッドパラメータを優先する
		if (strlen($this->whereParam) > 0 && preg_match("/^\s{0,}(where)\s{1,}/i", $this->whereParam) == 0){
			$sql .= " WHERE ". $this->whereParam;
		}else if (strlen($this->whereParam) > 0){
			$sql .= " ". $this->whereParam;
			// whereメソッドパラメータがない場合のみENTITYからの条件式作成を行う
		}else if (count($this->sqlConditionArray) > 0){
			$sql .= " WHERE ". implode(" AND ", $this->sqlConditionArray);
		}
		return $sql;
	}
	
	
	/**
	 * Update文のSET COLUMN = DATA ステートメントの作成
	 * @param variant $value 設定値
	 * @param String $column カラム名
	 */
	public function setUpdateSetStatement($value, $column, $arguments){
		$this->sqlSetArray[] =  $column ."=". ":". $column;
		$this->sqlPHArray[] = ":". $column;
		$this->bindValues[] = $value;
		$this->pdoDataType[] =  KitazDao_GetDataType::getPDODataType(get_class($arguments), $column, $value, $this->typeParam);
	}
	
	/**
	 * COLUMN = CONDITION ステートメント作成
	 * @param array $value 条件値
	 * @param String $columnName カラム名
	 */
	public function setConditionEqualStatement($value, $column, $prefix = ""){
		$this->sqlConditionArray[] = $column ."=".":". $prefix . $column;
		$this->sqlPHArray[] = ":". $prefix . $column;
		$this->bindValues[] = $value;
		$this->pdoDataType[] =  KitazDao_GetDataType::getPDODataType(get_class($this->entity), $column, $value, $this->typeParam);
	}
	/**
	 * COLUMN IN (CONDITIONS) ステートメント作成
	 * @param array $valArray 配列で渡されている値
	 * @param String $columnName カラム名
	 * @param String $prefix = "" プレースホルダーのプレフィックス
	 */
	public function setConditionInStatement($valArray, $column, $prefix = ""){
		$conditionArray = array();
		// 配列数を取得
		$num = count($valArray);
		
		// 変数の配列を取得する
		for ($i = 0; $i < $num; $i++){
			// プレースホルダーに「_IN_X」を付与
			$conditionArray[] = ":". $prefix . $column . "_IN_". $i;
			$this->sqlPHArray[] = ":". $prefix . $column . "_IN_". $i;
			$this->bindValues[] = $valArray[$i];
			$this->pdoDataType[] =  KitazDao_GetDataType::getPDODataType(get_class($this->entity), $column, $valArray[$i], $this->typeParam);
		}
		if ($num > 0){
			$this->sqlConditionArray[] = $column ." IN (". implode(",", $conditionArray) .")";
		}
	}
	/**
	 * バインド定数をプレースホルダーに置き換える
	 * @param variable $value パラメータの値
	 * @param array $sqlPHArray プレースホルダー配列
	 * @param array $bindValues 設定値配列
	 * @param array $pdoDataType PDOデータ型配列
	 */
	public function setConditionBindValStatement($value, $paramName){
		$pos = strpos($this->whereParam, "?");
		$this->whereParam = substr($this->whereParam, 0, $pos) . ":$paramName ". substr($this->whereParam, $pos+1);
		$this->sqlPHArray[] = ":$paramName";
		$this->bindValues[] = $value;
		$this->pdoDataType[] =  KitazDao_GetDataType::getPDODataType(get_class($this->entity), $paramName, $value, $this->typeParam);
	}

	/**
	 * プリペア
	 * @param String $sql プレースホルダー付SQL文字列
	 * @return ステートメントオブジェクト
	 */
	public function prepare($sql){
		$stmt = $this->pdo->prepare($sql);
		if (!$stmt){
			throw new KitazDaoException(9);
		}
		return $stmt;
	}
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
				$stmt->bindValue($this->sqlPHArray[$i], $this->bindValues[$i], $this->pdoDataType[$i]);
			}
		}
		return $stmt;
	}

}