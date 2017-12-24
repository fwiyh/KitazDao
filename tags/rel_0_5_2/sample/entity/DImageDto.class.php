<?php
class DImageDto {
	
	const TABLE = "D_IMAGE";
	
	private $updt;
	private $attr;
	private $odt;
	private $cdt;
	private $iid;
	private $secid;
	private $filedata;
	private $mime;
	private $alt;
	private $height;
	private $width;
	private $filesize;
	
	const UPDT_TYPE = KitazDao::KD_PARAM_STR;
	const ATTR_TYPE = KitazDao::KD_PARAM_INT;
	const ODT_TYPE = KitazDao::KD_PARAM_STR;
	const CDT_TYPE = KitazDao::KD_PARAM_STR;
	const IID_TYPE = KitazDao::KD_PARAM_INT;
	const SECID_TYPE = KitazDao::KD_PARAM_INT;
	const FILEDATA_TYPE = KitazDao::KD_PARAM_LOB;
	const MIME_TYPE = KitazDao::KD_PARAM_STR;
	const ALT_TYPE = KitazDao::KD_PARAM_STR;
	const HEIGHT_TYPE = KitazDao::KD_PARAM_INT;
	const WIDTH_TYPE = KitazDao::KD_PARAM_INT;
	const FILESIZE_TYPE = KitazDao::KD_PARAM_INT;
	
	const PRIMARY_KEY = "IID";
	
	/**
	* $updtのgetter/setter
	**/
	public function getUpdt() {
		return $this->updt;
	}
	public function setUpdt($param) {
		$this->updt = $param;
	}
	
	/**
	* $attrのgetter/setter
	**/
	public function getAttr() {
		return $this->attr;
	}
	public function setAttr($param) {
		$this->attr = $param;
	}
	
	/**
	* $odtのgetter/setter
	**/
	public function getOdt() {
		return $this->odt;
	}
	public function setOdt($param) {
		$this->odt = $param;
	}
	
	/**
	* $cdtのgetter/setter
	**/
	public function getCdt() {
		return $this->cdt;
	}
	public function setCdt($param) {
		$this->cdt = $param;
	}
	
	/**
	* $iidのgetter/setter
	**/
	public function getIid() {
		return $this->iid;
	}
	public function setIid($param) {
		$this->iid = $param;
	}
	
	/**
	* $secidのgetter/setter
	**/
	public function getSecid() {
		return $this->secid;
	}
	public function setSecid($param) {
		$this->secid = $param;
	}
	
	/**
	* $filedata(Filedata)のgetter/setter
	**/
	public function getFiledata() {
		return $this->filedata;
	}
	public function setFiledata($filedata) {
		$this->filedata = $filedata;
	}
	
	/**
	* $mime(Mime)のgetter/setter
	**/
	public function getMime() {
		return $this->mime;
	}
	public function setMime($mime) {
		$this->mime = $mime;
	}
	
	/**
	* $altのgetter/setter
	**/
	public function getAlt() {
		return $this->alt;
	}
	public function setAlt($param) {
		$this->alt = $param;
	}
	
	/**
	* $Height(Height)のgetter/setter
	**/
	public function getHeight() {
		return $this->height;
	}
	public function setHeight($height) {
		$this->height = $height;
	}
	/**
	* $width(Width)のgetter/setter
	**/
	public function getWidth() {
		return $this->width;
	}
	public function setWidth($width) {
		$this->width = $width;
	}
	/**
	* $filesie(Filesize)のgetter/setter
	**/
	public function getFilesize() {
		return $this->filesie;
	}
	public function setFilesize($filesie) {
		$this->filesie = $filesie;
	}
}

?>