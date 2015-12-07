<?php
class MNewsPaperDao{
	
	const BEAN = "MNewsPaperDto";
	
	/**
	 * -where -orderby -columns sql type -noparam
	 */
	
	/**
	 * 普通のテスト
	 * @param unknown $nid
	 * @return multitype:
	 */
	public function getPaper($pid){
		$ret = array();
		return $ret;
	}
	
	public function getMaxId(){
		$ret = array();
		$ret["columns"] = "MAX(PID) AS MAXID";
		return $ret;
	}
	
	public function insertPaper($dto){
		$ret = array();
		return $ret;
	}
	public function updatePaper($dto){
		$ret = array();
		return $ret;
	}
	public function deletePaper($dto){
		$ret = array();
		return $ret;
	}
}