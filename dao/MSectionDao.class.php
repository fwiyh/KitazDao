<?php

class MSectionDao {
	
	const BEAN = "MSectionDto";
	
	public function insertSection($dto){
		$ret = array();
		return $ret;
	}

	public function deleteSection($dto){
		$ret = array();
		return $ret;
	}
	
	public function updateSection($dto){
		$ret = array();
		return $ret;
	}
	
	public function modifyPkSection($dto, $secid){
		$ret = array();
		return $ret;
	}
	
	public function selectSection($secid){
		$ret = array();
		$ret["where"] = "";
		$ret["orderby"] = "";
		$ret["sql"] = "";
		return $ret;
	}
	
	public function selectWhereTest($t){
		$ret = array();
		$ret["where"] = " tel = ? order by dir desc";
		$ret["orderby"] = "";
		return $ret;
	}
	
	public function selectOrderByTest(){
		$ret = array();
		$ret["orderby"] = "order by dir";
		return $ret;
	}
	
}

?>