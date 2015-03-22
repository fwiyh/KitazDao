<?php
class DNwesDao{
	
	const BEAN = "DNewsDto";
	
	/**
	 * 「where」「orderby」「columns」「sql」「type」「noparam」
	 */
	
	/**
	 * 普通のテスト
	 * @param unknown $nid
	 * @return multitype:
	 */
	public function getNews($nid){
		$ret = array();
		return $ret;
	}
	
	/**
	 * where,columnsテスト
	 * @param unknown $ismorning
	 * @return multitype:string
	 */
	public function selectEveningNews($ismorning){
		$ret = array();
		$ret["columns"] = "TITLE, PUBDT, PAGES, AUTHOR";
		$ret["where"] = "ISMORNING = ? ORDER BY PUBDT DESC";
		return $ret;
	}
	
	/**
	 * orderbyテスト
	 * @param unknown $pid
	 * @return multitype:string
	 */
	public function selectPaperNews($pid){
		$ret = array();
		$ret["orderby"] = "PUBDT DESC, ISMORNING DESC";
		return $ret;
	}
	
	/**
	 * noparamテスト
	 * @param unknown $isasc
	 * @param unknown $isfirstmorning
	 * @return multitype:string
	 */
	public function selectPaperNewsOrder($isasc, $isfirstmorning){
		$ret = array();
		$orderbyString = "";
		if ($isasc == 1){
			$orderbyString .= "PUBDT ASC";
		}else {
			$orderbyString .= "PUBDT ASC";
		}
		if ($isfirstmorning == 1){
			$orderbyString .= ", ISMORNING ASC";
		}else {
			$orderbyString .= ", ISMORNING DESC";
		}
		$ret["orderby"] = $orderbyString;
		$ret["noparam"] = "$isasc, $isfirstmorning";
		return $ret;
	}
	
	public function insertNews($dto){
		$ret = array();
		return $ret;
	}
	public function updateNews($dto){
		$ret = array();
		return $ret;
	}
	public function deleteNews($dto){
		$ret = array();
		return $ret;
	}
}