<?php
class DSpeechDto {

	const TABLE = "D_SPEECH";

	private $updt;
	private $sid;
	private $title;
	private $media;
	private $maxid;

	const UPDT_TYPE = KitazDao::KD_PARAM_STR;
	const SID_TYPE = KitazDao::KD_PARAM_INT;
	const TITLE_TYPE = KitazDao::KD_PARAM_STR;
	const MEDIA_TYPE = KitazDao::KD_PARAM_OCI_BLOB;
	const MAXID_TYPE = KitazDao::KD_PARAM_INT;

	const PRIMARY_KEY = "SID";

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
	 * getter/setter of sid
	**/
	public function getSid() {
		return $this->sid;
	}
	public function setSid($sid) {
		$this->sid = $sid;
	}
	/**
	 * getter/setter of title
	**/
	public function getTitle() {
		return $this->title;
	}
	public function setTitle($title) {
		$this->title = $title;
	}
	/**
	 * getter/setter of media
	**/
	public function getMedia() {
		return $this->media;
	}
	public function setMedia($media) {
		$this->media = $media;
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