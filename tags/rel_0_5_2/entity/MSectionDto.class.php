<?php
class MSectionDto {
	
	const TABLE = "M_SECTION";
	
	private $updt;
	private $secid;
	private $gname;
	private $sname;
	private $tel;
	private $fax;
	private $email;
	private $dir;
	
	const UPDT_TYPE = KitazDao::KD_PARAM_STR;
	const SECID_TYPE = KitazDao::KD_PARAM_INT;
	const GNAME_TYPE = KitazDao::KD_PARAM_STR;
	const SNAME_TYPE = KitazDao::KD_PARAM_STR;
	const TEL_TYPE = KitazDao::KD_PARAM_STR;
	const FAX_TYPE = KitazDao::KD_PARAM_STR;
	const EMAIL_TYPE = KitazDao::KD_PARAM_STR;
	const DIR_TYPE = KitazDao::KD_PARAM_STR;
	
	const PRIMARY_KEY = "SECID";
	
	/**
	* $updt(Updt)のgetter/setter
	**/
	public function getUpdt() {
		return $this->updt;
	}
	public function setUpdt($updt) {
		$this->updt = $updt;
	}
	
	/**
	* $secid(Secid)のgetter/setter
	**/
	public function getSecid() {
		return $this->secid;
	}
	public function setSecid($secid) {
		$this->secid = $secid;
	}
	
	/**
	* $gname(Gname)のgetter/setter
	**/
	public function getGname() {
		return $this->gname;
	}
	public function setGname($gname) {
		$this->gname = $gname;
	}
	
	/**
	* $sname(Sname)のgetter/setter
	**/
	public function getSname() {
		return $this->sname;
	}
	public function setSname($sname) {
		$this->sname = $sname;
	}
	
	/**
	* $tel(Tel)のgetter/setter
	**/
	public function getTel() {
		return $this->tel;
	}
	public function setTel($tel) {
		$this->tel = $tel;
	}
	
	/**
	* $fax(Fax)のgetter/setter
	**/
	public function getFax() {
		return $this->fax;
	}
	public function setFax($fax) {
		$this->fax = $fax;
	}
	
	/**
	* $email(Email)のgetter/setter
	**/
	public function getEmail() {
		return $this->email;
	}
	public function setEmail($email) {
		$this->email = $email;
	}
	
	/**
	* $dir(Dir)のgetter/setter
	**/
	public function getDir() {
		return $this->dir;
	}
	public function setDir($dir) {
		$this->dir = $dir;
	}
	
}

?>