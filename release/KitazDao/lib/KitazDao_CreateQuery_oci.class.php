<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "KitazDao_CreateQuery.class.php";

/**
 * KitazDao
 * @name KitazDao_CreateQuery_oci
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

class KitazDao_CreateQuery_oci extends KitazDao_CreateQuery {
	
	/**
	 * Insert文の文字列を組み立てる
	 * @param String テーブル名
	 * @return String Insert文
	 */
	public function buildInsertSQLString($tableName){
		
		$isLob = false;
		$lobColumns = array();
		$lobPH = array();
		$sqlValueArray = array();
		// VALUES (?, ?, EMPTY_BLOB()) RETURNING imagedata INTO ?
		
		for ($i=0,$max=count($this->pdoDataType); $i < $max; $i++){
			// value句に入る項目を設定
			$sqlValueArray[$i] = $this->sqlPHArray[$i];
			// BLOB
			if ($this->pdoDataType[$i] == parent::KD_PARAM_OCI_BLOB){
				$this->pdoDataType[$i] = parent::KD_PARAM_LOB;
				// lob型に変換
				$isLob = true;
				$lobColumns[] = $this->sqlColumnArray[$i];
				$lobPH[] = $this->sqlPHArray[$i];
				$sqlValueArray[$i] = "EMPTY_BLOB()";
			}
			// CLOB
			if ($this->pdoDataType[$i] == parent::KD_PARAM_OCI_CLOB){
				$this->pdoDataType[$i] = parent::KD_PARAM_STR;
			}
		}
		
		// SQL文字列作成
		$sql = "INSERT INTO $tableName(". implode(",", $this->sqlColumnArray) .") VALUES(". implode(",", $sqlValueArray) .")";
		if ($isLob){
			$sql .= " RETURNING ". implode(",", $lobColumns) . " INTO ". implode(",", $lobPH);
		}
		return $sql;
	}
	
	/**
	 * Update文を組み立てる
	 * @param String $tableName テーブル名
	 * @return String Update文
	 */
	public function buildUpdateSQLString($tableName){
		
		$isLob = false;
		$lobColumns = array();
		$lobPH = array();
		
		for ($i=0,$max=count($this->pdoDataType); $i < $max; $i++){
			// BLOB
			if ($this->pdoDataType[$i] == parent::KD_PARAM_OCI_BLOB){
				$this->pdoDataType[$i] = parent::KD_PARAM_LOB;
				// lob型に変換
				$isLob = true;
				$lobColumns[] = str_replace(":", "", $this->sqlPHArray[$i]);
				$lobPH[] = $this->sqlPHArray[$i];
				for ($j=0, $smax=count($this->sqlSetArray); $j < $smax; $j++){
					$this->sqlSetArray[$j] = str_replace($this->sqlPHArray[$i], "EMPTY_BLOB()", $this->sqlSetArray[$j]);
				}
			}
			// CLOB
			if ($this->pdoDataType[$i] == parent::KD_PARAM_OCI_CLOB){
				$this->pdoDataType[$i] = parent::KD_PARAM_STR;
			}
		}
		
		// SQL文字列作成
		$sql = "UPDATE $tableName SET ". implode(",", $this->sqlSetArray);
		if (count($this->sqlConditionArray) > 0){
			$sql .= " WHERE ". implode(",", $this->sqlConditionArray);
		}
		if ($isLob){
			$sql .= " RETURNING ". implode(",", $lobColumns) . " INTO ". implode(",", $lobPH);
		}
		return $sql;
	}
}