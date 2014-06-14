<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "KitazDao_CreateQuery.class.php";

/**
 * KitazDao
 * @name KitazDao_CreateQuery_sqlsrv
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

class KitazDao_CreateQuery_sqlsrv extends KitazDao_CreateQuery {
	
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
				if ($this->pdoDataType[$i] != parent::KD_PARAM_SQLSRV_BINARY && $this->pdoDataType[$i] != parent::KD_PARAM_SQLSRV_TEXT){
					$stmt->bindParam($this->sqlPHArray[$i], $this->bindValues[$i], $this->pdoDataType[$i]);
				}else if ($this->pdoDataType[$i] == parent::KD_PARAM_SQLSRV_BINARY){
					$stmt->bindParam($this->sqlPHArray[$i], $this->bindValues[$i], parent::KD_PARAM_LOB, 0, PDO::SQLSRV_ENCODING_BINARY);
				}else {
					$stmt->bindParam($this->sqlPHArray[$i], $this->bindValues[$i], parent::KD_PARAM_LOB, 0, PDO::SQLSRV_ENCODING_UTF8);
				}
			}
		}
		return $stmt;
	}
}