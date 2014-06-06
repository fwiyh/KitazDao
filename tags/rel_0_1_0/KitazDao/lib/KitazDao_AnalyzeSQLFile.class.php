<?php

require_once __DIR__ .'/KitazDaoBase.class.php';

/**
 * KitazDao
 * @name KitazDao_AnalyzeSQLFile
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

class KitazDao_AnalyzeSQLFile extends KitazDao_CreateQuery {
	
	private $paramArray = array();

	private $aqlTypeParam;
	
	public function __construct(){
		
	}
	
	/**
	 * SQLパラメータ・SQLファイルの解釈を行う
	 * @param array $params メソッドのパラメータ名配列
	 * @param array $arguments 渡された引数の配列
	 * @param array $typeParam データ型パラメータ
	 * @param string $sql 対象のSQL文
	 * @param array $sqlPHArray プレースホルダー
	 * @param array $bindValues プレースホルダーに格納する変数
	 * @param array $pdoDataType PDOのデータ型
	 */
	public function analyze($params, $arguments, $typeParam, &$sql, &$sqlPHArray, &$bindValues, &$pdoDataType){
		$sqlPHArray = array();
		$bindValues = array();
		$pdoDataType = array();
		$this->aqlTypeParam = $typeParam;
		
		// 評価外コメントを除去する
		$sql = $this->removeNoEvaluationComment($sql);
		// 渡された変数すべてをプレースホルダーに置き換える
		$sql = $this->replaceParameterValue($params, $arguments, $sql, $sqlPHArray, $bindValues, $pdoDataType);
		// 分岐処理の処理を行う
		$sql = $this->evaluationSQLFile($params, $arguments, $sql, $sqlPHArray, $bindValues, $pdoDataType);
	}
	
	/**
	 * 評価外コメントを除去する
	 * @param String $sql ファイルのSQL文
	 * @return 除去済みSQL文
	 */
	private function removeNoEvaluationComment($sql){
		$ret = preg_replace("/(\/\*)\s{1,}\S{0,}(\*\/)/i", "", $sql);
		$ret = preg_replace("/\-\-.{0,}\n/i", "\n", $ret);
		return $ret;
	}
	/**
	 * 渡された変数をすべてプレースホルダーに置き換える
	 * @param array $params メソッドのパラメータ名配列
	 * @param array $arguments 渡された引数の配列
	 * @param string $sql 対象のSQL文
	 * @param array $sqlPHArray プレースホルダー配列
	 * @param array $bindValues 設定値配列
	 * @param array $pdoDataType PDOデータ型配列
	 * @return String プレースホルダーに置き換えたSQL文字列
	 */
	private function replaceParameterValue($params, $arguments, $sql, &$sqlPHArray, &$bindValues, &$pdoDataType){
		// パラメータ毎にプレースホルダーを置き換える
		for ($i = 0,$max = count($params); $i < $max; $i++){
			$p = $params[$i];
			$v = $arguments[$i];
			// クラス名がある（entity）の場合はセットされた項目すべてをバインドする
			if (@get_class($v) && $v != null){
				$this->setPlaceHolderForEntity($p->getName(), $v, $sql, $sqlPHArray, $bindValues, $pdoDataType);
			// 引数が配列の場合はINステートメントで置換
			}else if (is_array($v)){
				$this->setPlaceHolderForArray($p->getName(), $v, $sql, $sqlPHArray, $bindValues, $pdoDataType);
			// 変数の場合は単純置換
			}else {
				$this->setPlaceHolderForVariant($p->getName(), $v, $sql, $sqlPHArray, $bindValues, $pdoDataType);
			}
		}
		return $sql;
	}
	
	// クラス名がある（entity）の場合はセットされた項目すべてをバインドする
	// 置換対象コメント：「$entity.[$methodName]"*"」 or 「$entity.[$methodName]'*'」 or 「$entity.[$methodName]*」
	// プレースホルダー：「:$entity_[$methodName]"」 or 「:$entity_[$methodName]_IN_X」
	// バインドする値：「$entity->get[$methodName]」
	// データ型：「$entity::strtoupper([$methodName])_TYPE」
	/**
	 * entityをすべてプレースホルダーに置き換える
	 * @param String $methodName メソッド名
	 * @param Object $entity エンティティ
	 * @param String $sql 対象のSQL文
	 * @param array $sqlPHArray プレースホルダー配列
	 * @param array $bindValues 設定値配列
	 * @param array $pdoDataType PDOデータ型配列
	 */
	private function setPlaceHolderForEntity($methodName, $entity, &$sql, &$sqlPHArray, &$bindValues, &$pdoDataType){
		$ret = array();
		// メソッドパラメータから条件式を作成する
		foreach (get_class_methods($entity) as $m){
			if (substr($m, 0, 3) == "get"){
				$column = lcfirst(substr($m, 3));
				// getterから値を取得する
				$value = $entity->$m();
				// SQLファイル内パラメータの取得
				$param = lcfirst($methodName) .".". $column;
				// 配列の場合はINステートメントに置換
				$dataType = array();
				if (is_array($value)){
					$this->setPlaceHolderForArray($param, $value, $sql, $sqlPHArray, $bindValues, $dataType, get_class($entity), strtoupper($column));
				// 変数の場合は単純置換
				}else {
					$this->setPlaceHolderForVariant($param, $value, $sql, $sqlPHArray, $bindValues, $dataType, get_class($entity), strtoupper($column));
				}
				// データ型を格納
				if (count($dataType) > 0){
					$pdoDataType[] = $dataType[0];
					// paramArrayに追加
					$this->setParamsArray($param, $value, $dataType[0]);
				}
			}
		}
	}
	/**
	 * 変数をプレースホルダーに置き換える
	 * @param String $paramName 変数名
	 * @param variant $value 変数の値
	 * @param string $sql 対象のSQL文
	 * @param array $sqlPHArray プレースホルダー配列
	 * @param array $bindValues 設定値配列
	 * @param array $pdoDataType PDOデータ型配列
	 */
	private function setPlaceHolderForVariant($paramName, $value, &$sql, &$sqlPHArray, &$bindValues, &$pdoDataType, $entity = null, $propName = null){
		// エンティティの場合はコロンを「_E_」に置き換えてプレースホルダーを作成する
		$pattern1 = "/(\/\*)". $paramName ."(\*\/)([\"]\S{0,}[\"]|[\']\S{0,}[\']|([0-9a-zA-Z\.\_\-]){1,})/i";
		// プレースホルダーになる部分を配列に分解して結合し直す
		$sqlArr = preg_split($pattern1, $sql);
		$str = "";
		$dataType = null;
		$targetPropName = "";
		$max = count($sqlArr);
		if ($max > 0){
			$str = $sqlArr[0];
			for ($i=1; $i<$max; $i++){
				$pNum = $i-1;
				$str .= ":". str_replace(".", "_E_", $paramName) ."_$pNum ". $sqlArr[$i];
				$sqlPHArray[] = ":". str_replace(".", "_E_", $paramName) ."_$pNum";
				$bindValues[] = $value;
				if ($propName == null){
					$targetPropName = $paramName;
				}else {
					$targetPropName = $propName;
				}
				$dataType = parent::getPDODataType($entity, $targetPropName, $value, $this->aqlTypeParam, isset($entity));
				$pdoDataType[] = $dataType;
			}
			// paramArrayに追加
			$this->setParamsArray($paramName, $value, $dataType);
		}
		// 置換結果を返す
		$sql = $str;
	}
	// 置換対象コメント：「$paramName"*"」 or 「$paramName'*'」 or 「$paramName*」
	// プレースホルダー：「:$paramName_IN_X」
	// バインドする値：「$entity->get[$methodName]」
	/**
	 * 配列をINステートメントとしてプレースホルダーに置き換える
	 * @param String $paramName 変数名
	 * @param variant $value 変数の値
	 * @param string $sql 対象のSQL文
	 * @param array $sqlPHArray プレースホルダー配列
	 * @param array $bindValues 設定値配列
	 * @param array $pdoDataType PDOデータ型配列
	 */
	private function setPlaceHolderForArray($paramName, $values, &$sql, &$sqlPHArray, &$bindValues, &$pdoDataType, $entity = null, $propName = null){
		// エンティティの場合はコロンを「_E_」に置き換えてプレースホルダーを作成する
		$pattern1 = "/(\/\*)". $paramName ."(\*\/)(\(){1}([0-9a-zA-Z,\.\-\"\'\_]{1,})(\)){1}/i";
		// プレースホルダーになる部分を配列に分解して結合し直す
		$sqlArr = preg_split($pattern1, $sql);
		$str = "";
		$dataType = null;
		$targetPropName = "";
		$max = count($sqlArr) - 1;
		if ($max > 0){
			$str = $sqlArr[0];
			$inStr = array();
			$varCount = 0;
			for ($i=0; $i<$max; $i++){
				for ($j=0,$vmax=count($values);$j<$vmax;$j++){
					$value = $values[$j];
					$inStr[] = ":". str_replace(".", "_E_", $paramName) ."_IN_$varCount";
					$sqlPHArray[] = ":". str_replace(".", "_E_", $paramName) ."_IN_$varCount";
					$bindValues[] = $value;
					if ($propName == null){
						$targetPropName = $paramName;
					}else {
						$targetPropName = $propName;
					}
					$dataType = parent::getPDODataType($entity, $targetPropName, $value, $this->aqlTypeParam, isset($entity));
					$pdoDataType[] = $dataType;
					$varCount++;
				}
				$str .= "(". implode(",", $inStr) .") ". $sqlArr[$i+1];
			}
			// paramArrayに追加（SQLファイルのIFコメントで配列は無効）
			$this->setParamsArray($paramName, null, parent::KD_PARAM_NULL);
		}else {
			// max0:$sqlArrが１要素の場合＝分割要素がないのでそのまま渡す
			$str = $sqlArr[0];
		}
		// 置換結果を返す
		$sql = $str;
	}
	
	/**
	 * IFコメントで利用する配列に変数の値をセットする
	 * @param String $paramName
	 * @param String $value
	 * @param String $dataType
	 */
	private function setParamsArray($paramName, $value, $dataType){
		$this->paramArray[] = array("p"=>$paramName, "v"=>$value, "t"=>$dataType);
	}
	
	/**
	 * １文字ずつSQL文字列を解釈する
	 * @param array $params 変数名の配列
	 * @param array $arguments 変数値の配列
	 * @param string $sql 対象のSQL文
	 * @param array $sqlPHArray プレースホルダー配列
	 * @param array $bindValues 設定値配列
	 * @param array $pdoDataType PDOデータ型配列
	 */
	private function evaluationSQLFile($params, $arguments, $sql, &$sqlPHArray, &$bindValues, &$pdoDataType){
		// 戻り値のSQL文字列
		$ret = "";
		// 評価式変数
		$evalStr = "";
		// ネストNo
		$nest = 0;
		// 各ネストのSQL文が有効な場合はtrue
		$isUse[$nest] = true;
		// 評価式の中にいる場合はtrue
		$isEval = false;
		// 元のSQL文の長さを取得
		$max = strlen($sql);
		// ７文字先まで検索対象にするために７文字追加する
		$sql = $sql .str_repeat(" ", 7);
		// BEGIN句処理のフラグ
		$isExistElse = false;
		$isTrueComment = false;
		
		for ($i = 0; $i < $max; $i++){
			// IF文開始
			if ($isUse[$nest] && !$isEval && preg_match("/\/\*IF\s/i", $sql[$i].$sql[$i+1].$sql[$i+2].$sql[$i+3].$sql[$i+4])){
				$i += 4;
				$isEval = true;
			// IF文終了
			}else if ($isUse[$nest] && $isEval && preg_match("/\*\//i",$sql[$i].$sql[$i+1])){
				$i += 1;
				$isEval = false;
				$nest++;
				$isUse[$nest] = $this->evaluateFormula($evalStr);
				if ($isUse[$nest]){
					$isTrueComment = true;
				}
				$evalStr = "";
			// END文処理（ネスト０はBEGIN句のため）
			}else if ($nest > 0 && preg_match("/\/\*END\*\//i", $sql[$i].$sql[$i+1].$sql[$i+2].$sql[$i+3].$sql[$i+4].$sql[$i+5].$sql[$i+6])){
				$i += 6;
				$nest--;
			// ELSE文開始
			}else if (preg_match("/\/\*ELSE\*\//i", $sql[$i].$sql[$i+1].$sql[$i+2].$sql[$i+3].$sql[$i+4].$sql[$i+5].$sql[$i+6].$sql[$i+7])){
				$isExistElse = true;
				$i += 7;
				$isUse[$nest] = !$isUse[$nest];
			// 評価式の中
			}else if ($isUse[$nest] && $isEval){
				$evalStr .= $sql[$i];
			// 普通のSQL文字列
			}else if ($isUse[$nest] && !$isEval){
				$ret .= $sql[$i];
			}
		}
		// BEGIN句の処理（ELSE句が存在せず、すべてFALSEの場合）
		if (!$isExistElse && !$isTrueComment){
			$ret = preg_replace("/\/\*BEGIN\*\/(\s|\S){0,}\/\*END\*\//i", " ", $ret);
		}
		// whereと演算子が隣接している場合に演算子を削除する
		$ret = preg_replace("/(WHERE)(\s){1,}(AND|OR|NOT)\s/i", "WHERE ", $ret);
		return $ret;
	}
	/**
	 * 評価式を評価する
	 * @param String $evalStr 評価式
	 * @return boolean 評価式の結果
	 */
	private function evaluateFormula($evalStr){
		$ret = false;
		// 全パターンの演算子以外を取り出す
		$pattern = "/[^\"\'\s]{1,}[^(IF\s|=|\!|\+|\-|\*|\/|NULL\s|\||\&|AND\s|OR\s|XOR\s|\~|\^)]{1,}[^\"\'\s]{1,}/i";
		if (preg_match_all($pattern, $evalStr, $matches)){
			foreach ($matches[0] as $v){
				// パラメータと一致したら置き換える
				foreach($this->paramArray as $a){
					if (strtoupper($a["p"]) == strtoupper($v)){
						$evalStr = str_replace($v, $this->addQuoatSlashedValue($a), $evalStr);
					}
				}
			}
			
		}
		eval("if(". $evalStr ."){\$ret = true;}else{\$ret = false;};");
		return $ret;
	}
	/**
	 * シングルクォートとダブルクォートの処理を追加
	 * @param array $a $this->paramArray()の該当値
	 * @return string 代入値
	 */
	private function addQuoatSlashedValue($a){
		$ret = addslashes($a["v"]);
		if ($ret == null){
			$ret = "null";
		}
		if ($a["t"] == parent::KD_PARAM_STR){
			$ret = "'". $a["v"] ."'";
		}
		return $ret;
	}
}