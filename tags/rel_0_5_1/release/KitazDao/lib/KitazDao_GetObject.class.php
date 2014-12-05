<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "KitazDaoBase.class.php";

/**
 * KitazDao
 * @name KitazDao_GetObject
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

class KitazDao_GetObject extends KitazDaoBase {
	
	/**
	 * Dao名からDaoクラスを返す
	 * @param String $className Daoクラス名
	 * @return variant 取得失敗:false 取得成功：Daoクラス
	 */
	public static function getDaoClass($className){
		try {
			require_once KD_DAO_PATH . DIRECTORY_SEPARATOR . $className .".class.php";
			return new $className();
		}catch (Exception $e) {
			return false;
		}
	}
	
	/**
	 * Daoに定義されているBEANからEntity名を取得する
	 * @param Object $daoClass
	 * @return variant 取得失敗:false 取得成功：String Entity名
	 */
	public static function getEntityNameByDao($daoClass){
		try {
			return $daoClass::BEAN;
		} catch(Exception $e){
			return false;
		}
	}
	
	/**
	 * Entity名からEntityクラスを返す
	 * @param String $entityName
	 * @return variant 取得失敗:false 取得成功：Dtoクラス
	 */
	public static function getEntityClass($entityName){
		try {
			require_once KD_ENTITY_PATH . DIRECTORY_SEPARATOR . $entityName .".class.php";
			return new $entityName();
		}catch (Exception $e) {
			return false;
		}
	}
}