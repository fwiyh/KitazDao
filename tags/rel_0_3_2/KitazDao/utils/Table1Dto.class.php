<?php
class Table1Dto {

	const TABLE = "TABLE1";

	private $updatedt;
	private $attribute;
	private $tid;
	private $tname;
	private $tcomment;
	private $timage;

	const UPDATEDT_TYPE = KitazDao::KD_PARAM_STR;
	const ATTRIBUTE_TYPE = KitazDao::KD_PARAM_INT;
	const TID_TYPE = KitazDao::KD_PARAM_INT;
	const TNAME_TYPE = KitazDao::KD_PARAM_STR;
	const TCOMMENT_TYPE = KitazDao::KD_PARAM_OCI_CLOB;
	const TIMAGE_TYPE = KitazDao::KD_PARAM_OCI_BLOB;

	const PRIMARY_KEY = "TID";

	/**
	 * getter/setter of updatedt
	**/
	public function getUpdatedt() {
		return $this->updatedt;
	}
	public function setUpdatedt($updatedt) {
		$this->updatedt = $updatedt;
	}
	/**
	 * getter/setter of attribute
	**/
	public function getAttribute() {
		return $this->attribute;
	}
	public function setAttribute($attribute) {
		$this->attribute = $attribute;
	}
	/**
	 * getter/setter of tid
	**/
	public function getTid() {
		return $this->tid;
	}
	public function setTid($tid) {
		$this->tid = $tid;
	}
	/**
	 * getter/setter of tname
	**/
	public function getTname() {
		return $this->tname;
	}
	public function setTname($tname) {
		$this->tname = $tname;
	}
	/**
	 * getter/setter of tcomment
	**/
	public function getTcomment() {
		return $this->tcomment;
	}
	public function setTcomment($tcomment) {
		$this->tcomment = $tcomment;
	}
	/**
	 * getter/setter of timage
	**/
	public function getTimage() {
		return $this->timage;
	}
	public function setTimage($timage) {
		$this->timage = $timage;
	}
}