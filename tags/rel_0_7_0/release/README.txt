* KitazDaoについて
[開発の経緯]
Oracle11gでS2Dao.php5を用いてLOB型を取りにいけなかったため自分でDaoを作ることにしました。
そのためDaoやEntityはS2Dao.php5を意識して作成しています。
基本的に他のO/RマッパーのようにPDOベースで作成しております。
もちろん、永続化などといった概念的な部分は一切考えずにS2Daoのようにかけるものを目指して作っただけです。

[動作環境]
PHP5.5.x(5.3以降）
各種PDO
Oracle11g/12c, mysql5.6, Postgresql 8.4.21, SQL Server 2014, ODBC(MSAccess)

[動作テストを行ったDB]
Oracle12.0.1(windows7 AMD64)
mysql5.6.19(FreeBSD10.2-RELEASE-p5 AMD64)
mysql5.7.9(windows7 AMD64)
Postgresql 9.4.1(windows7 AMD64)
SQL Server 2014(windows7 AMD64)
Access 2007(mdb形式)(windows7 AMD64)

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


[概念]
基本的にS2Daoと同じ概念が通用します。

|---------------|   |-----|   |--------|     |-----|  |-----------|
| PHPプログラム |---| Dao |---| Entity |-----| PDO |--| 各種RDBMS |
|---------------|   |-----|   |--------|     |-----|  |-----------|
                       |
                |-------------|
                | SQLファイル |
                |-------------|

Daoが実際のデータベースの処理を行うのですが、その受け渡し役としてEntityがあるという概念で事済みます。
S2Dao同様にDaoからSQLファイルの読み込みができます。



[Entityの作り方]
Entityには４つの項目を作成します。
S2Daoと異なり、データベースの特性をEntityに記述することで
サーバ側に問い合わせをせずに直接処理を行います。


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
Entity内にプライマリキーに値が入っている場合は、
更新対象の条件としてプライマリキーが用いられます。
KitazDaoでは記述側の都合で、データベースを参照しないため、
プライマリキーの判別を行っていないのでここで指定することになります。

補足事項
SQLファイルで複数のテーブルから項目を出力する場合は他のテーブルの出力項目をEntityに設定する必要があります。
Select文ではEntityの定数やメソッドなどを用いて出力を行っているためです。



[Daoの作り方]
S2Dao.php5ではInterfaceですが、KitazDaoでは普通のクラスになっています。
そのためメソッドの予測機能がメソッド名を列挙してくれません。

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
		$ret["where"] = "WHERE SECNAME LIKE ? ORDER BY SEC DESC";
		$ret["columns"] = "SECID, SECNAME AS SectionName";
		return $ret;
	}

	public function getMaxId(){
		$ret = array();
		$ret["columns"] = "MAX(ID) AS MAXID";
		return $ret;
	}
}

１　INSERT文
パラメータにテーブルに該当するEntityを渡します。
Entityにセットした項目をINSERTします。
セットしていなければデータベースのデフォルト値になり、
デフォルトがない場合はINSERTに失敗します。
メソッド名を「insert/add/create」で始める必要があります。

２　DELETE文
パラメータにテーブルに該当するEntityを渡します。
Entityにセットされた項目を条件として削除を行います。
何もセットしていない場合は全削除になります。
メソッド名を「delete/remove」で始める必要があります。

３　UPDATE文
テーブルに該当するEntityを渡します。
Entityで指定したPRIMARY_KEYの項目がセットされていれば
更新条件としてUPDATE文が発行されます。
メソッド名を「update/modify/store」で始める必要があります。

また、第２パラメータ以降を設定している場合はこれらが更新条件に置き換わります。
更新内容はEntityにセットされたものすべてが更新されます。
プライマリキーの判別は無視されます。
第２パラメータ以降の変数名は、テーブルの項目名と同じ変数にします。
Reflectionで変数名を取得して条件式を作成しているためです。

４　SELECT文
SELECT文ではパラメータに変数を与えることで「WHERE ... AND...」条件式のSQLを作成します。
変数はテーブルのカラムと同じ名前にする必要があり、Entityの定数からPDOのデータ型を取得して実行されます。
また、結果データは「array[0]["columnName"]」のような二次元配列で返されます。
この中身もEntityにある定数からデータ型を取得します。
メソッド名はINSERT/UPDATE/DELETE文で指定された文字以外で始まっているものであればSELECT文を作成します。

また、メソッド内にメソッドパラメータを記述することにより、SELECT文のカスタマイズが可能になります・
メソッドパラメータには「where」「orderby」「columns」「sql」「type」のパラメータがあります。

５　SQLファイルによるSQL文の処理
Daoと同じフォルダに「[クラス名]_[メソッド名].sql（例：MSectionDao_selectSection.sql）」
という命名ルールにもとづいてSQL文ファイルを作成した場合は、
SQLファイルを読み込んで実行されます。
メソッド名に関してはSELECT文であるかを判断し、SELECT文の場合は２次元配列で結果を返すようになります。
詳細はSQL文ファイルの記述方法にて記載します。


メソッドに与える値について
Daoのメソッドに渡す変数は原則配列以外になりますが、
UPDATE文のプライマリキー部分や第２パラメータ以降～SELECT文パラメータ全てにおいて、
配列を設定した場合は、xxx IN ("yyy","zzz") のようなINステートメントに置き換わります。
基本的にデータ型はEntityの定数を利用します。



[メソッドパラメータ]
Daoメソッドに設定するメソッド以外の配列パラメータを指します。
typeパラメータ以外はSELECT文のみ機能します。

１　whereメソッドパラメータ
where～order by句を記述します。
SQLの自動生成で作成されるWHERE文はすべてこれに置き換えられます。
また、orderbyメソッドパラメータがあった場合もこれを無視して優先されます。
したがって２件以上の結果を期待している場合はwhereメソッドパラメータに
「ORDER BY」句を記述する必要があるでしょう。

このメソッドパラメータに変数を設定する場合はバインド変数を設定できます。
例
$ret["where"] = "secid = ? and secname like ? order by dir asc";

PDOのバインド変数と同様の機能を持っており、バインド変数の登場順番どおりにメソッドの引数を割り当てます。
（内部では、プレースホルダーに置き換えています。変数の型はtypeメソッドパラメータか変数で自動判定しています）

２　orderbyメソッドパラメータ
order by句を記述します。
これは非常に弱いメソッドパラメータで、whereメソッドパラメータがあると無視されます。
したがってsqlメソッドパラメータ・SQLファイルがあるとこれは無視されます。
SQLの自動生成において複数の結果が期待できるときに設定することで、出力順を制御できます。

３　columnsメソッドパラメータ
SELECT文の「SELECT xxx FROM yyy」でいうxxxを指定するパラメータです。
これが設定されているSQL文では最優先されます。
基本的にSELECT文は全カラム出力（*句）にしているため、
結果の出力を抑えたり、別名を割り当てたいとき（count(*)句を利用するときなど）に利用します。

４　sqlメソッドパラメータ
DaoにSQL文そのものを記述することも可能です。
SQL文の自動生成より優先されます。
最優先されるものはSQLファイルのため、SQLファイルが有る場合は無視されます。
SQLファイルと同じコメントパラメータを記述することができます。
コメントパラメータに関してはSQLファイルにて説明します。

５　typeメソッドパラメータ
SQL実行時に渡す引数のデータ型を最優先に設定します。Entityのデータ型よりも優先されます。
他のメソッドパラメータと異なりこれは配列で設定します。

$type = array();
$type["SECNAME"] = KitazDao::KD_TYPE_STR;
$type["SECID"] = KitazDao::KD_TYPE_INT;
$ret["type"] = $type;

連想配列の配列名に指定したい項目名を記述し、値にデータ型定数を指定します。
Select文を実行するメソッドの引数はEntityにないものを記述できますが、
これらの引数のデータ型を明示するときに用います。

public function getSectionBetween($min, $max){
	$ret = array();
	$ret["where"] = "SORDER BETWEEN ? AND ? ORDER BY SORDER ASC";
	$type = array();
	$type["MIN"] = KitazDao::KD_TYPE_INT;
	$type["MAX"] = KitazDao::KD_TYPE_INT;
	$ret["type"] = $type;
	return $ret;
}

この例では、whereメソッドパラメータでバインド定数を指定していますが、
$min,$maxのデータ型をINTとして明示するために利用しています。
また、パラメータにNULLを入れたい場合にKitazDao::KD_TYPE_NULLをtypeメソッドパラメータで指定できます。

６　noparamメソッドパラメータ
SELECT文のメソッドは変数名で検索対象となる項目名が指定されますが、noparamメソッドパラメータに指定されている変数名は
SELECT文の対象外になります。

public function selectPeriod($id, $topnum){
	$ret = array();
	$ret["sql"] = "SELECT TOP $topnum * FROM PERIOD_TABLE WHERE pid=/*id*/'1'";
	$ret["noparam"] = "topnum";
	return $ret;
}
この例では、普通にSQLファイルに/**/によるプレースホルダーを入れるとPDOで正しく処理されません。
topnumをSQL文に代入させたい場合は、noparamを指定することでプレースホルダーの対象外にできます。

public function getTargetData($order, $date){
	$ret = array();
	if ($order == 1){
		$ret["order"] = "ID ASC";
	}else {
		$ret["order"] = "ID DESC";
	}
	$ret["noparam"] = "order,date";
	return $ret;
}
このようにメソッド内で分岐をつくることもできます。
複数の変数を指定する場合はカンマで区切ります。

ただし、純粋に値を渡すためSQLインジェクションの危険性があることを留意すべきです。
SQL文に直接代入する場合は特に注意が必要です。

７　nullParamメソッドパラメータ
SQLファイル、SQLメソッドパラメータ以外で「WHERE DATE IS NULL」のように明示的にnullを指定したい場合に用います。
このメソッドパラメータで指定するものは変数名です。
テーブルに「DATE」というカラムが存在するときに、Daoに$dateを指定します。
後にメソッドパラメータでnullparamでdateを記述することで「DATE IS NULL」を実現できます。
複数の変数を指定する場合はカンマで区切ります。


[SQLファイル]
sqlメソッドパラメータやSQLファイルにはSQL文を記述し、コメントパラメータを設定することで動的なSQL文を作成できます。

例
SELECT
	S.SID,
	S.SNAME,
	E.SECID,
	E.SECNAME
FROM
	M_STAFF S
LEFT JOIN
	M_SECTION E
ON
	S.SECID = E.SECID
/*BEGIN*/
WHERE
-- param of section name
/*IF dto.secName != ""*/
	E.SECNAME LIKE /*dto.secName*/'%Account%'
/*END*/
/*IF dir != ""*/
	E.DIR = /*dir*/'kaikei'
/*END*/
/*IF sortOrder !== null*/
	E.SORTORDER BETWEEN /*sortOrder*/10 AND /*sortOrder*/20
/*END*/
/*END*/

１　コメントとしてそのまま評価されないもの
「--」形式のコメントや「/**/」形式でも「/* comment*/」のように「*」と文字の間に半角スペースのあるコメントは
すべて評価しないコメントとしてSQL文から削除されます。

２　コメントパラメータ
「/**/」形式で評価されるものはメソッドの引数の値が設定されます。
例のように「/*dir*/'kaikei'」のようにコメントパラメータの後ろに隣接している文字列を引数に置き換えます。
また、/*dto.secName*/のようにドット区切りで指定する変数は引数にEntityを設定した場合に有効になります。
この例では引数名「$dto」にEntityを設定し、「getSecName」メソッドにより値を取得して置き換えます。

注意点として、コメントパラメータはPDOで利用するプレースホルダーに置き換えることです。
以下のSQL文ではエラーになります。

SELECT /*COL*/ FROM TABLE1

/*COL*/コメントパラメータはプレースホルダーに置き換えられるため、
PDOの処理で数値かクォート付きの文字列に置き換えられるためです。
出力対象を動的に変えたい場合はIF分岐処理を用います。

SELECT /*IF p == "TID"*/TID/*ELSE*/TNAME/*END*/ FROM TABLE1

３　分岐処理「IF」
/*IF xxxxxx*/yyy=zzz/*END*/と記述している場合は、IF文分岐処理が真の場合にIF～ENDの間を有効にします。
IF文の処理はevalで処理し、引数はバックスラッシュで処理して置き換えます。
したがって「==」と「===」とでは挙動が変わることに注意が必要です。
コメントパラメータはPDOのプレースホルダーに置き変えますが、
IF分岐文ではバックスラッシュのエンコードで評価式を処理します。
IF文は3文字以上にする必要があります。

「ELSE」分岐も記述可能です。
IF分岐処理とENDの間に「/*ELSE*/」を記述でき、
IF分岐処理が偽の場合に「/*ELSE*/」から「/*END*/」も間を有効にします。

４　特殊処理「BEGIN」
IF分岐処理がすべて偽で、かつELSEが１つも登場していない場合は「BEGIN」から「END」までの記述を無効にできます。
主な用途として「WHERE」句を削除するときに用いることができます。

５　配列をパラメータで渡す場合
SQLファイルに「SID IN /*sids*/(1,10,100)」と記述して変数を渡すこともできます。
SQLファイルの条件式の中にNULLを判定させる場合は「nullParam」を用いずに、
配列内に１要素のみでnullを入れます。
$sids = array(null);



[PHPからの呼び出し]
PHPから呼び出す際には、Daoのインスタンス作成を行い後にメソッドを実行する必要があります。

１　オブジェクト作成
newでインスタンスを作成する際に、Daoのクラス名をパラメータとして渡します。
この際に用いるdsnの設定ファイルは、KitazDao/KitazDao.configになります。
0.2.0より、インスタンス作成時の第２パラメータに設定ファイル名を指定できるようになりました。
KitazDaoディレクトリ直下にあるファイルを指定することができます。
これにより、使用するDBなどを切り替えることができます。
指定しない場合のデフォルト値は「KitazDao.config」になっています。

オブジェクト作成する際に、DaoとEntityのパスを自動的に読み込みます。
従ってDao・Entityともにrequire_onceがなされた状態になっています。
Insert・Update・Delete文で用いるEntityのパスを通さずにすぐにインスタンスが作成できます。

２　Daoオブジェクトのメソッドを実行
マジックメソッドによるSQL文の実行を行っているため、Eclipse等ではメソッド名が自動補完されません。
Daoに記載されているようにメソッドを実行し、パラメータを適切に渡す必要があります。

３　Insert,Update,Delete処理について
PDOがベースになっているため、これらの処理を行う場合はtransaction内で実行する必要があります。
トランザクションを開始メソッドは「begintrans」、コミットは「commit」、」ロールバックは「rollback」を用意しています。
インスタンス作成後（PDOのインスタンスができたとき）に宣言してください。



[デバッグ関連]
１　ログ出力機能
SQLがどのように生成されているかをログで出力できます。
> define("KD_DEBUG_SQL_OUTPUT_PATH", $path);
のように「KD_DEBUG_SQL_OUTPUT_PATH」定数に出力パスを設定するとこのファイルに書き込みします。
基本的にPDOによるパラメータ付与になるため、「:」で始まる変数がパラメータになります。
SQLファイルで正常に処理が行われているか判定するときにも使えます。


* データベース固有の実装

[Oracle(oci)]
BLOBとCLOB型はINSERT・UPDATE文では特殊な記述が必要になります。
ただし、PDOで指定するデータ型に関しては振る舞いが違います。
バイナリであるBLOB型はLOBのままでよいのですが、
テキスト型であるCLOBやNCLOBはPDOでいう文字型として扱わなければなりません。

Entityでデータ型を指定する際は、以下の定数を割り当てる必要があります。

KD_PARAM_OCI_BLOB　BLOB型
KD_PARAM_OCI_CLOB　CLOB型

INSERT・UPDATE文を組み立てるときに切り分けを行うために特別に定義する必要があります。


[SQL Server(sqlsrv)]
LOB型である、varbinary(max)型・image型・text型をバインドする際に、データ型を指定する必要があります。
bindステートメントにてこれだけBindParamを使用しています。
この際にデータ型を指定するPDO定数もsqlsrv用に存在しているため、バインド時の扱いが特殊になっています。

Entityでデータ型を指定する際は、以下の定数を割り当てる必要があります。

KD_PARAM_SQLSRV_BINARY　varbinary(max)型・image型
KD_PARAM_SQLSRV_TEXT　　text型

varchar(max)型は通常通り「KitazDao::KD_PARAM_STR」で利用できます。

[ODBCによるMSAccess接続]
これはwindows上でPHPを動かす際の注意事項になります。
ODBC経由とはいえ処理を行うのはAccessのmdbやaccdbファイルです。
従ってマルチバイトが入るであろうEntity・SQLファイルをSJIS(SJIS-WIN)に変換する必要があります。
マルチバイト文字ではない英数字記号であっても文字列であればすべてを
mb_convert_encoding関数を用いてSJIS(SJIS-WIN)に変換しなければなりません。
UNIX ODBCに関しては未検証です。



* S2Daoとの違い
S2Daoのような感覚で記述することを目的に作成していますが、S2Daoとの相違点を列挙します。


[実装面]
・サーバを参照してデータ型を自動判別せずにEntityやメソッドパラメータの情報を利用する。
・Select文は配列でしか返さない。メソッド名の末尾で形式を判定していない。
・Insert,Upadte,Delete処理はトランザクションを適宜宣言する必要がある。

[Dao]
・DaoがInterfaceではない。
・Interfaceで設定するアノテーションがすべてメソッドパラメータに置き換えられている。
・orderbyメソッドパラメータが存在する。
・Updateメソッドに第２パラメータ移行が存在し第１パラメータのEntityそのものが更新内容にできる。
・N:1マッピングが実装されていない。SQLファイルで記述してください。

[SQLファイル]
・IF分岐処理をevalで処理している。
・「--ELSE」コメントの代わりに「/*ELSE*/」になっている（intramartの仕様？）。

[Entity]
・各プロパティのデータ型をPDOのデータ型としてすべて定義しなければならない。
・プライマリキーを指定しなければならない。



* 付属ユーティリティ
[utils/egen.php]
PHPのCLIを用いて、CSVファイルに記述されている情報を元にEntityを作成するプログラムです。
コマンドラインでの実行方法は以下になります。

php egen.php Table1Dto.csv TABLE1

第１パラメータにCSVファイルのパスか名前、第２パラメータはEntityに結び付けられるテーブル名です。
生成されるファイルは、CSVファイル名から拡張子を取り除いた文字列でファイル名とクラス名が作成されます。
上の例では「Table1Dto」なので「Table1Dto.class.php」というファイルが作成され、
ファイル内には「Table1Dto」クラスが記述されます。

CSVのフォーマットは、以下になります。

updatedt,STR,0
attribute,INT,0
tid,INT,1
tname,STR,0
tcomment,OCI_CLOB,0
timage,OCI_BLOB,0

１列３項目で構成され、１項目目は「$のない変数名」、
２項目目は「データ型文字列 （KitazDao::KD_PARAM_ の後に続く文字列」）、
３項目目はPrimaryKeyの項目に１を記述し、それ以外は０を記述します。
CVSに記述された文字列をpropertyにそのまま使うために、
アクセッサメソッドに用いる場合は先頭文字を大文字にし、
それ以外のものは大文字小文字を変換せずそのまま反映されます。
