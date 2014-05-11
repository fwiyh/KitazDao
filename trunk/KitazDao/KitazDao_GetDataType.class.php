<?php

require_once dirname(__FILE__) .'/KitazDaoBase.class.php';

/**
 * KitazDao
 * @name KitazDao_GetDataType
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

class KitazDao_GetDataType extends KitazDaoBase {
	
	/**
	 * メソッド名からクエリ種別を取得
	 * @param String $methodName メソッド文字列
	 * @return String クエリータイプ Select/Insert/Update/Delete/SQLFile
	 */
	public static function getQueryType($className, $methodName){
		
		// Insert文字列検索
		if(preg_match("/^(insert|add|create)/i", $methodName)){
			return parent::KD_STMT_INSERT;
		}
		// Update文字列検索
		if(preg_match("/^(update|modify|store)/i", $methodName)){
			return parent::KD_STMT_UPDATE;
		}
		// delete文字列検索
		if(preg_match("/^(delete|remove)/i", $methodName)){
			return parent::KD_STMT_DELETE;
		}
		// これ以外はselect文検索文字列
		return parent::KD_STMT_SELECT;
	}
	

	/**
	 * 変数からPDOデータ型を取得する
	 * @param 変数 $value
	 * @return string PDOデータ型（KD_）定数を返す
	 */
	public static function getDataType($value){
		$type = gettype($value);
		if ($type == "string"){
			return parent::KD_PARAM_STR;
		}
		if ($type == "integer" || $type == "double"){
			return parent::KD_PARAM_INT;
		}
		if ($type == "boolean"){
			return parent::KD_PARAM_BOOL;
		}
		if ($type == "NULL"){
			return parent::KD_PARAM_NULL;
		}
		// 未確定情報
		if ($type == "array" || $type == "object" || $type =="resource"){
			return parent::KD_PARAM_LOB;
		}
		// 何も該当しないものはLOB
		return parent::KD_PARAM_LOB;
	}
}