<?php
class MNewsPaperDto {

	const TABLE = "M_NEWSPAPER";

	private $updt;
	private $pid;
	private $papername;
	private $maxid;

	const UPDT_TYPE = KitazDao::KD_PARAM_STR;
	const PID_TYPE = KitazDao::KD_PARAM_INT;
	const PAPERNAME_TYPE = KitazDao::KD_PARAM_STR;
	const MAXID_TYPE = KitazDao::KD_PARAM_INT;

	const PRIMARY_KEY = "PID";

	/**
	 * getter/setter of updt
	**/
	public function getUpdt() {
		return $this->updt;
	}
	public function setUpdt($updt) {
		$this->updt = $updt;
	}
	/**
	 * getter/setter of pid
	**/
	public function getPid() {
		return $this->pid;
	}
	public function setPid($pid) {
		$this->pid = $pid;
	}
	/**
	 * getter/setter of papername
	**/
	public function getPapername() {
		return $this->papername;
	}
	public function setPapername($papername) {
		$this->papername = $papername;
	}
	/**
	 * getter/setter of maxid
	**/
	public function getMaxid() {
		return $this->maxid;
	}
	public function setMaxid($maxid) {
		$this->maxid = $maxid;
	}
}