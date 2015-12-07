<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "KitazDaoBase.class.php";

/**
 * KitazDao
 * @name KitazDao_GetObject
 * @author keikitazawa
 */
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