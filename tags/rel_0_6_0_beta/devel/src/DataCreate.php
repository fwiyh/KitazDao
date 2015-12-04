<?php

require_once "./env.php";
//define("KD_DEBUG_SQL_OUTPUT_PATH", "F:\\My Documents\\Projects\\src\\KitazDao\\devel\\src\\1.php.txt");

define("KD_DAO_PATH", "../dao");
define("KD_ENTITY_PATH", "../dto");

$kd = new KitazDao(SQLITE3_CONFIG);



$mtarr = explode(" ", microtime());
$now = Date("Y-m-d H:i:s", $mtarr[1]) .".". explode(".", $mtarr[0])[1];
echo $now;

/**
 * Create M_NEWSPAPER
 */
$dao = $kd->getDao("MNewsPaperDao");
$dto = new MNewsPaperDto();

// delete all
$dao->deletePaper($dto);

// new data
$dto->setUpdt(Date("Y-m-d H:i:s"));
$dto->setPid(1);
$dto->setPapername("テスト新聞");
$dao->insertPaper($dto);

$dto->setUpdt(Date("Y-m-d H:i:s"));
$dto->setPid(2);
$dto->setPapername("テスト日報");
$dao->insertPaper($dto);

$dto->setUpdt(Date("Y-m-d H:i:s"));
$dto->setPid(3);
$dto->setPapername("実験速報");
$dao->insertPaper($dto);

/**
 * Create D_NEWS
 */
$dao = $kd->getDao("DNewsDao");
$dto = new DNewsDto();

// delete all
$dao->deleteNews($dto);

// new data
$dto->setUpdt(Date("Y-m-d H:i:s"));
$dto->setNid(1);
$dto->setTitle("テストニュース１");
$dto->setPubdt(Date("Y-m-d 00:00:00"));
$dto->setPid(2);
$dto->setIsmorning(1);
$dto->setPages("14");
$dto->setAuthor("XXXX0000");
$dao->insertNews($dto);

$dto->setUpdt(Date("Y-m-d H:i:s"));
$dto->setNid(2);
$dto->setTitle("○○ニュース");
$dto->setPubdt(Date("Y-m-d 00:00:00"));
$dto->setPid(1);
$dto->setIsmorning(0);
$dto->setPages("2");
$dto->setAuthor("WWWW8888");
$dao->insertNews($dto);

$dto->setUpdt(Date("Y-m-d H:i:s"));
$dto->setNid(3);
$dto->setTitle("(´・ω・`)そんなー");
$dto->setPubdt(null);
$dto->setPid(1);
$dto->setIsmorning(0);
$dto->setPages("2");
$dto->setAuthor("WWWW8888");
$dao->insertNews($dto);