<?php

require_once __DIR__ .'/KitazDaoBase.class.php';

/**
 * KitazDao
 * @name KitazDao_OutputSelectQuery
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

class KitazDao_OutputSelectQuery extends KitazDaoBase {
	
	/*
	 * oracle11gにてBLOBをPDO::PARAM_LOBで返すと値が取得できないため、
	 * ストリームオブジェクトのみをそのまま引き渡すために
	 * まず全件取得してから、INTを数値に置き換える処理に変更
	 */
	/**
	 * SELECTの結果を連想配列で返す
	 * @param Object $stmt execute済みStatementオブジェクト
	 * @param Object $entity Entity（データ型取得のために利用する）
	 * @return multitype:
	 */
	public function getArray($stmt, $entity){
		$ret = array();
		$pdoTypeArray = array();
		
		// Eintityから数値型の配列を取得する
		$refClass = new ReflectionClass($entity);
		$constants = $refClass->getConstants();
		foreach($constants as $key => $val){
			// 定数の最後が「_TYPE」のものを取得する
			if ((strpos($key,"_TYPE") >= strlen($key) -5) && substr($key, 0, -5) != ""){
				// 定数の値からPDOのデータ型を取得する
				$columnU = strtoupper(substr($key, 0, -5));
				$columnL = strtolower(substr($key, 0, -5));
				$pdoTypeArray[$columnU] = $val;
				$pdoTypeArray[$columnL] = $val;
			}
		}
		
		// 全件取得する
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			// 各行でPDOのINTになっているものだけfloat変換して置き換える
			foreach($row as $key => $v){
				// 整数型扱いのものはピリオドの有無で整数・浮動小数に変更
				switch ($pdoTypeArray[$key]){
					case parent::KD_PARAM_INT:
						if (!strpos($v, ".")){
							$row[$key] = intval($v);
						}else {
							$row[$key] = floatval($v);
						}
						break;
					// ブール型はキャストで変更
					case KitazDao::KD_PARAM_BOOL :
						$row[$key] = (bool)$v;
						break;
					// null型はnullを入れておく
					case KitazDao::KD_PARAM_NULL :
						$row[$key] = null;
						break;
				}
			}
			$ret[] = $row;
		}
		return $ret;
	}
	
}