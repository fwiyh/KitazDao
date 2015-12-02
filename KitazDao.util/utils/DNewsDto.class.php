<?php
class DNewsDto {

	const TABLE = "D_NEWS";

	private $updt;
	private $nid;
	private $title;
	private $pubdt;
	private $pid;
	private $ismorning;
	private $pages;
	private $author;

	const UPDT_TYPE = KitazDao::KD_PARAM_STR;
	const NID_TYPE = KitazDao::KD_PARAM_INT;
	const TITLE_TYPE = KitazDao::KD_PARAM_STR;
	const PUBDT_TYPE = KitazDao::KD_PARAM_STR;
	const PID_TYPE = KitazDao::KD_PARAM_INT;
	const ISMORNING_TYPE = KitazDao::KD_PARAM_INT;
	const PAGES_TYPE = KitazDao::KD_PARAM_STR;
	const AUTHOR_TYPE = KitazDao::KD_PARAM_STR;

	const PRIMARY_KEY = "NID";

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
	 * getter/setter of nid
	**/
	public function getNid() {
		return $this->nid;
	}
	public function setNid($nid) {
		$this->nid = $nid;
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
	 * getter/setter of pubdt
	**/
	public function getPubdt() {
		return $this->pubdt;
	}
	public function setPubdt($pubdt) {
		$this->pubdt = $pubdt;
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
	 * getter/setter of ismorning
	**/
	public function getIsmorning() {
		return $this->ismorning;
	}
	public function setIsmorning($ismorning) {
		$this->ismorning = $ismorning;
	}
	/**
	 * getter/setter of pages
	**/
	public function getPages() {
		return $this->pages;
	}
	public function setPages($pages) {
		$this->pages = $pages;
	}
	/**
	 * getter/setter of author
	**/
	public function getAuthor() {
		return $this->author;
	}
	public function setAuthor($author) {
		$this->author = $author;
	}
}