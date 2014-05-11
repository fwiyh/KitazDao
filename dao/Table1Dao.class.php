<?php
class Table1Dao {
	
	const BEAN = "Table1Dto";
	
	public function getMaxTid(){
		$ret = array();
		$ret["sql"] = "select max(TID) as mtid from TABLE1";
		return $ret;
	}
	
	public function seletTable($tid){
		$ret = array();
		return $ret;
	}
	
	public function insertTable(Table1Dto $dto){
		$ret = array();
		return $ret;
	}
	public function updateTable(Table1Dto $dto){
		$ret = array();
		return $ret;
	}
	
	public function deleteTable(Table1Dto $dto){
		$ret = array();
		return $ret;
	}
	
	
}