* KitazDaoについて
[開発の経緯]
Oracle11gでS2Dao.php5を用いてLOB型を取りにいけなかったため自分でDaoを作ることにしました。
そのためDaoやEntityはS2Dao.php5を意識して作成しています。
基本的に他のO/RマッパーのようにPDOベースで作成しております。

[動作環境]
PHP5.3+
各種PDO
Oracle11g, mysql5.x

[インストール]
KitazDaoフォルダをプログラムが読み取り可能な場所に格納してください。
データベースへの接続はPDOを用いており、PDOの設定は
このフォルダにある「KitazDao.config」に記述します。
KitazDaoクラスは同じフォルダの当該ファイルを参照します。


[実行方法]
KitazDaoを実行する前に以下を宣言してください。
require_once './[KitazDaoのパス]/kitazDao.class.php';
define("KD_DAO_PATH", "[daoのパス]");
define("KD_ENTITY_PATH", "[entityのパス]");

require_onceには、KitazDaoの「kitazDao.class.php」のパスを通します。
「KD_DAO_PATH」と「KD_ENTITY_PATH」には、PHPで用いるDaoとEntity(BEAN)のパスを通します。
Dao・Dtoのクラスが宣言されるときに、常にこのパスからDaoクラス・Dtoクラスを探しに行きます。
探しに行くファイル名は「[クラス名].class.php」に統一しているため、
「MSectionDao」というクラスは「MSectionDao.class.php」というファイル名にしなければなりません。


[Entityの作り方]
Entityには４つの項目を作成します。


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

１　CONST TABLE
「const TABLE = "M_SECTION";」のようにEntityに関連するテーブル名を１つだけ記述します。
２　getter/setter
テーブル項目、もしくはSELECT文の結果として返してくるカラム名（エイリアス名）のgetter/setterを作成します。
大文字小文字の判別は特に行っていません。
PDOで作成するSQL文字列やプレースホルダーはすべて大文字に変換していますので、
get/setで始まるメソッドは小文字で記述していれば機能します。
Eclipseのテンプレートに以下を登録しておくと若干捗ると思われます。

/**
* $$${variable}(${name})のgetter/setter
**/
public function get${name}() {
	return $$this->${variable};
}
public function set${name}($$${variable}) {
	$$this->${variable} = $$${variable};
}

３　PDOデータ型
const [変数名（すべて大文字）]_TYPE を指定します。
「const SNAME = KitazDao::KD_PARAM_INT」のように、
KitazDaoにある「KD_PARAM」で始まる定数を割り当てます。
基本的にPDOのものをそのまま渡しているだけです。
定数は以下のものがあります。

const KD_PARAM_STR = PDO::PARAM_STR;
const KD_PARAM_INT = PDO::PARAM_INT;
const KD_PARAM_BOOL = PDO::PARAM_BOOL;
const KD_PARAM_NULL = PDO::PARAM_NULL;
const KD_PARAM_LOB = PDO::PARAM_LOB;

PDOでは基本的に文字列での受け渡しになるそうで、
日付や時間もデータベースにそって文字列で渡す模様です。

４　PRIMARY_KEY
UPDATE文で用いる定数です。
基本的にUPDATE文ではEntityに代入されている項目を更新しますが、
同じENTITY内にプライマリキーに値が入っている場合は、
ENTITY内のプライマリキーを条件式として更新します。
KitazDaoでは記述側の都合で、データベースを参照しないため、
プライマリキーの判別を行っていないのでここで指定することになります。


[Daoの作り方]
S2Dao.php5ではInterfaceですが、アノテーションを扱いきれなかったために、普通のクラスで宣言します。

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
		return $ret;
	}

}

１　INSERT文
パラメータにテーブルに該当するENTITYを渡します。
ENTITYにセットした項目をINSERTします。
セットしていなければデータベースのデフォルト値になり、
デフォルトがない場合はINSERTに失敗します。

２　DELETE文
パラメータにテーブルに該当するENTITYを渡します。
ENTITYにセットされた項目を条件として削除を行います。
何もセットしていない場合は全削除になります。

３　UPDATE文
テーブルに該当するENTITYを渡します。
ENTITYで指定したPRIMARY_KEYの項目がセットされていれば
更新条件としてUPDATE文が発行されます。

また、第２パラメータ以降を設定している場合はこれらが更新条件に置き換わります。
更新内容はENTITYにセットされたものすべてが更新されます。
プライマリキーの判別は無視されます。
第２パラメータ以降の変数名は、テーブルの項目名と同じ変数にします。
Reflectionで変数名を取得して条件式を作成しているためです。



