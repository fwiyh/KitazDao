<?php
class Table1Dto {
	
	const TABLE = "TABLE1";
	
	private $updatedt;
	private $attribute;
	private $tid;
	private $tname;
	private $tcomment;
	private $timage;
	
	private $mtid;
	
	const UPDATEDT_TYPE = KitazDao::KD_PARAM_STR;
	const ATTRIBUTE_TYPE = KitazDao::KD_PARAM_INT;
	const TID_TYPE = KitazDao::KD_PARAM_INT;
	const TNAME_TYPE = KitazDao::KD_PARAM_STR;
	const TCOMMENT_TYPE = KitazDao::KD_PARAM_LOB;
	const TIMAGE_TYPE = KitazDao::KD_PARAM_LOB;
	
	const MTID_TYPE = KitazDao::KD_PARAM_INT;
	
	const PRIMARY_KEY = "TID";
	
	/**
	* $updatedt(Updatedt)のgetter/setter
	**/
	public function getUpdatedt() {
		return $this->updatedt;
	}
	public function setUpdatedt($updatedt) {
		$this->updatedt = $updatedt;
	}
	/**
	* $attribute(Attribute)のgetter/setter
	**/
	public function getAttribute() {
		return $this->attribute;
	}
	public function setAttribute($attribute) {
		$this->attribute = $attribute;
	}
	/**
	* $tid(Tid)のgetter/setter
	**/
	public function getTid() {
		return $this->tid;
	}
	public function setTid($tid) {
		$this->tid = $tid;
	}
	/**
	* $tname(Tname)のgetter/setter
	**/
	public function getTname() {
		return $this->tname;
	}
	public function setTname($tname) {
		$this->tname = $tname;
	}
	/**
	* $comment(Tcomment)のgetter/setter
	**/
	public function getTcomment() {
		return $this->tcomment;
	}
	public function setTcomment($tcomment) {
		$this->tcomment = $tcomment;
	}
	/**
	* $timage(Timage)のgetter/setter
	**/
	public function getTimage() {
		return $this->timage;
	}
	public function setTimage($timage) {
		$this->timage = $timage;
	}
}