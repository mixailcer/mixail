<?php
// Version
define('VERSION', '2.3.0.2');
    set_time_limit(0);
// проверка кодировки символов



$tt=file_get_contents ("uob.csv");
$ts='';
$fl=0;

for ($i=0; $i < strlen($tt); $i++) { 
  switch (ord($tt[$i])) {
    case '9':
    case '10':
    case '13':
    case '167':
    case '185':          
      $fl=0;    
      break;  
    default:
  // 1-кирилица  2- латиница
      if (ord($tt[$i])>191 || ord($tt[$i])==168 || ord($tt[$i])==184) {
        if ($fl==2)  {
          $sti=''; for($j=-50; $j<1; $j++) $sti.=$tt[$i+$j]; 
          $sti.="---- {$tt[$i]} ----"; 
          for($j=1; $j<50; $j++) $sti.=$tt[$i+$j];
          echo iconv( "WINDOWS-1251","UTF-8",$sti)."<br><br>";  
        } 
        $fl=1;
      } 
      elseif ((ord($tt[$i])>64 && ord($tt[$i])<91) || (ord($tt[$i])>96 && ord($tt[$i])<123)) {
          if ($fl==1) {
            $sti=''; for($j=-50; $j<1; $j++) $sti.=$tt[$i+$j]; 
            $sti.="---- {$tt[$i]} ----"; 
            for($j=1; $j<50; $j++) $sti.=$tt[$i+$j];
            echo iconv( "WINDOWS-1251","UTF-8",$sti."<br><br>");  
//          echo $sti."<br><br>";
          }
          $fl=2;     
      }
      else {
        $fl=0;
        if (ord($tt[$i])<32 || (ord($tt[$i])>126 && ord($tt[$i])<192 && ord($tt[$i])!=168 && ord($tt[$i])!=184)) {
            $sti=''; for($j=-50; $j<1; $j++) $sti.=$tt[$i+$j]; 
            $sti.="---- ".ord($tt[$i])." ----"; 
            for($j=1; $j<50; $j++) $sti.=$tt[$i+$j];
            echo "СИМВОЛ ".iconv( "WINDOWS-1251","UTF-8",$sti."<br><br>"); 
        } 
      }
      break;
  }
}
$ar_s=count_chars ($tt,"1");
foreach ($ar_s as $key => $value) {
  $ar_s[$key]=array($value,chr ($key));
}
echo "<pre>"; print_r($ar_s);


//$tt= mb_substr ($tt,50,200); echo $tt;
//echo mb_detect_encoding($tt, "auto");
exit("tttttt");

// Функция подключения базы
function fun_conn_data() {
  @$db=new mysqli("mark.setbook.ru","admin_mark","6hST5T6DvE","admin_mark");
  if (mysqli_connect_errno()) {
    echo 'ОШИБКА ПОДКЛЮЧЕНИЯ К БАЗЕ';
    exit(); 
  }; 
  $db->query('SET NAMES utf8'); // установка нужной кодировки
  return $db;
}
function fun_conn_dataR() {
  @$dbR=new mysqli("localhost","mark","111","mark");
  if (mysqli_connect_errno()) {
    echo 'ОШИБКА ПОДКЛЮЧЕНИЯ К БАЗЕ местной';
    exit(); 
  }; 
  $dbR->query('SET NAMES utf8'); // установка нужной кодировки
  return $dbR;
}

/* Разрешаем PHP автоматически добавлять SID в формы */
ini_set("session.use_trans_sid",true); 
/* Разрешаем сценарию работать с сессиями  */
session_start();
header('Content-Type: text/html; charset=utf-8'); // charset=windows-1251
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
         "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>

echo <<< 'EOT'
</head>
<body>
Заполнение таблиц<br>
EOT;
<?php
$db=fun_conn_data(); // подключаемся к базе УДАЛЕННОЙ
$dbR=fun_conn_dataR(); // подключаемся к базе Местной
set_time_limit(0);
echo '<br>'.date('H:i:s').'<br>';
ob_flush();
flush();
set_time_limit(0);
$k=0; // Количество циклов обмена
for ($i=0; $i>=0; ) { 
  $y=$i;
  $pole=array();
  $resR=$dbR->query("SELECT * FROM `oc_customer` WHERE `customer_id`>$i LIMIT 700");
  if ($resR->num_rows<1){echo "<br> в ответе мало записей. Последняя скопированная строка- ".$i."<br>"; exit();}
  while ($pole[]=$resR->fetch_assoc()) {}

  $strbaz='';
  $pr=1;
  foreach ($pole as $kk=>$slv) {
    if (!empty($slv)) {
      $y=$i; 
      $i=$slv['customer_id'];
      if ($pr==1) $pr=0; else $strbaz.=',';
      $strbaz.='(';
      $pr1=1;
      foreach ($slv as $kk0=>$slv0) {
        if (!empty($kk0)) $strbaz.=(($pr1==1)?"'":",'").addslashes($slv0)."'";      
        $pr1=0;
      }
      $strbaz.=')';
    }
  }
  $strbaz= "INSERT INTO `oc_customer` VALUES ".$strbaz;
  $res=$db->query($strbaz);

  $k++;
  if ($k % 100 == 0) {echo '<br'.$k."-----".$i; ob_flush(); flush(); }
  if ($i <= $y )  {
    echo $i." ошибка ".$y;
    ob_flush();
    flush();
    exit();
  }
}  

echo "<br>Таблица заполнена<br>".date('H:i:s')."<br></body></html>";
exit(); 





//	$f=fopen ("fbaz.txt","wb");
/*
    $ar_sim=array();
for ($i=0,$l=3000; $i <500000; $i=$i+3000,$l=$l+3000) {
 	gc_collect_cycles();
	$connection = curl_init();
	//Устанавливаем адрес для подключения, по умолчанию методом GET
	$z="setbook.ru/qweasd.php?a=".$i.",".$l;
	curl_setopt($connection, CURLOPT_URL,$z);
		//Говорим, что нам необходим результат
	curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);
	//Выполняем запрос с сохранением результата в переменную
	$rezult=curl_exec($connection);
	curl_close($connection);
	$rezult=str_replace (chr(152),' ',$rezult);
	$str_rez= iconv( "WINDOWS-1251","UTF-8",$rezult);
	$kk=$i;
	$f=fopen ("fbaz.txt$kk","wb");
	fwrite ($f,$str_rez);
	fclose ($f);
	unset($str_rez);	
	unset($rezult);
	echo $i." --- ";
}
exit("ok");



// Функция подключения к базе
function fun_conn_data() {
	@$db=new mysqli(localhost,"mark","111","mark");
	if (mysqli_connect_errno()) {
		echo 'ОШИБКА ПОДКЛЮЧЕНИЯ К БАЗЕ';
		exit();	
	}; 
*/
/*	$db->query('SET NAMES utf8'); // установка нужной кодировки
	return $db;
}
// c805f1111d89d4802c1b6001759abd7b:65
*/
$db=fun_conn_data();
$sql="INSERT INTO `oc_customer`(`customer_id`, `customer_group_id`, `store_id`, `language_id`, `firstname`, `lastname`, `email`, `telephone`,
 `fax`, `password`, `salt`, `cart`, `wishlist`, `newsletter`, `address_id`, `custom_field`, `ip`, `status`, `approved`, `safe`, `token`, `code`,
   `date_added`, `sum`)  
   SELECT 
`customers_id`,  
'1',
'0',
'2',
`customers_firstname`,       
`customers_lastname`,
`customers_email_address`,    
`customers_telephone`,  
`customers_fax`,    
SUBSTRING_INDEX(`customers_password`,':',1),     
SUBSTRING_INDEX(`customers_password`,':',-1),    
NULL,
NULL,
IF(`customers_newsletter`=1,1,0),     
`oc_address`.`address_id`,
'',
IFNULL(IF(INSTR(`customers_ip`,'.')>0,`customers_ip`,'127.0.0.1'),'127.0.0.1'),
IF(`customers_status`=1,1,0),
'1',
'0',
'',
'',
IFNULL(`date_purchased`,'2017-06-17 21:14:12'),
CASE WHEN `customers_discount`=15 THEN 6010 WHEN `customers_discount`=12 THEN 5900 WHEN `customers_discount`=10 THEN 3400
     WHEN `customers_discount`=9 THEN 1900 WHEN `customers_discount`=8 THEN 1400  WHEN `customers_discount`=7 THEN 1100
     WHEN `customers_discount`=6 THEN 800 WHEN `customers_discount`=5 THEN 500 WHEN `customers_discount`=3 THEN 400
     ELSE 290 END
FROM `my_tabl`JOIN `oc_address` ON `my_tabl`.`customers_id`=`oc_address`.`customer_id` ";

if (!$db->query($sql))
    { printf("Err: %s\n", $db->error);};
exit("ok");







$sql="INSERT INTO `oc_address`(`address_id`, `customer_id`, `firstname`, `lastname`, `company`, `address_1`, `address_2`, `city`, `postcode`, `country_id`, `zone_id`, `custom_field`) 
  SELECT NULL, `customers_id`, IFNULL(`entry_firstname`,`customers_firstname`), IFNULL(`entry_lastname`,`customers_lastname`),
          IFNULL(`entry_company`,'  '),IFNULL(`entry_street_address`,IFNULL(`delivery_street_address`,'  ')),' ',
          IFNULL(`entry_city`,IFNULL(`delivery_city`,' ')),IFNULL(`entry_postcode`,IFNULL(`delivery_postcode`,' ')),
          IFNULL(`entry_country_id`,0),IFNULL(`entry_zone_id`,0),'  ' 
  FROM `my_tabl`";

if (!$db->query($sql))
    { printf("Err: %s\n", $db->error);};
exit("ok");





$sql="INSERT INTO `oc_customer`(`customer_id`, `customer_group_id`, `store_id`, `language_id`, `firstname`, `lastname`, `email`, `telephone`,
 `fax`, `password`, `salt`, `cart`, `wishlist`, `newsletter`, `address_id`, `custom_field`, `ip`, `status`, `approved`, `safe`, `token`, `code`,
   `date_added`, `sum`)  
   SELECT 
`customers_id`,  
'1',
'0',
'2',
`customers_firstname`,       
`customers_lastname`,
`customers_email_address`,    
`customers_telephone`,  
`customers_fax`,    
SUBSTRING_INDEX(`customers_password`,':',1),     
SUBSTRING_INDEX(`customers_password`,':',-1),    
NULL,
NULL,
IF(`customers_newsletter`=1,1,0),     
'0',
'',
IFNULL(IF(INSTR(`customers_ip`,'.')>0,`customers_ip`,'127.0.0.1'),'127.0.0.1'),
IF(`customers_status`=1,1,0),
'1',
'0',
'',
'',
IFNULL(`date_purchased`,'2017-06-17 21:14:12'),
`customers_discount`
FROM `my_tabl`";

if (!$db->query($sql))
    { printf("Err: %s\n", $db->error);};
exit("ok");













$sql="INSERT INTO `oc_address`(`address_id`, `customer_id`, `firstname`, `lastname`, `company`, `address_1`, `address_2`, `city`, `postcode`, `country_id`, `zone_id`, `custom_field`) 
  SELECT NULL, `customers_id`, `entry_firstname`, `entry_lastname`, `entry_company`, `entry_street_address`, '',
                `entry_city`, `entry_postcode`, `entry_country_id`, `entry_zone_id`, '' 
  FROM `my_tabl` WHERE `customers_default_address_id`>0 ";

if (!$db->query($sql))
    { printf("Err: %s\n", $db->error);};
exit("ok");












  $db->query("DROP TABLE IF EXISTS `my_tabl`"); 
  $sql="CREATE TABLE `my_tabl` (
    `kkk` INT NOT NULL AUTO_INCREMENT, PRIMARY KEY (`kkk`)
      )
     SELECT 
      c.*,
      p.`orders_id`,
      p.`customers_ip`,
      p.`delivery_street_address`,
      p.`delivery_suburb`,
      p.`delivery_city`,
      p.`delivery_postcode`,
      p.`delivery_state`,
      p.`delivery_country`,
      p.`date_purchased`
     FROM `my_perenos_i` c LEFT JOIN `my_order_i` p   ON c.`customers_id`=p.`customers_id` ";
if (!$db->query($sql))
    { printf("Err: %s\n", $db->error);};
exit("ok");










  $db->query("DROP TABLE IF EXISTS `my_orders_i`"); 
  $sql="CREATE TABLE `my_order_i` (
    `kd_i` INT NOT NULL AUTO_INCREMENT, PRIMARY KEY (`kd_i`)
      )
     SELECT 
      c.`orders_id`,
      c.`customers_id`,
      c.`customers_ip`,
      c.`delivery_street_address`,
      c.`delivery_suburb`,
      c.`delivery_city`,
      c.`delivery_postcode`,
      c.`delivery_state`,
      c.`delivery_country`,
      c.`date_purchased`
     FROM `my_orders` c JOIN `my_orders_p` p   ON (c.`customers_id`=p.`customers_id`  AND c.`orders_id`=p.`mp`) ";
if (!$db->query($sql))
    { printf("Err: %s\n", $db->error);};
exit("ok");





  $db->query("DROP TABLE IF EXISTS `my_orders_p`"); 

  $sql="CREATE TABLE `my_orders_p` (
    `kd` INT NOT NULL AUTO_INCREMENT, PRIMARY KEY (`kd`)
      )
     SELECT `customers_id`,MAX(`orders_id`) AS mp
 FROM `my_orders` GROUP BY `customers_id` ";
if (!$db->query($sql))
    { printf("Err: %s\n", $db->error);};
exit("ok");










  $db->query("DROP TABLE IF EXISTS `my_perenos_i`"); 
  $sql="CREATE TABLE `my_perenos_i` (
    `kd_i` INT NOT NULL AUTO_INCREMENT, PRIMARY KEY (`kd_i`)
      )
     SELECT c.* FROM `my_perenos` c JOIN `my_perenos_p` p   ON (c.`customers_id`=p.`customers_id`  AND c.`address_book_id`=p.`mp`) OR
      (c.`customers_id`=p.`customers_id`  AND  p.`mp` IS NULL )
     ";
if (!$db->query($sql))
    { printf("Err: %s\n", $db->error);};
exit("ok");





  $db->query("DROP TABLE IF EXISTS `my_perenos_p`"); 

  $sql="CREATE TABLE `my_perenos_p` (
    `kd` INT NOT NULL AUTO_INCREMENT, PRIMARY KEY (`kd`)
      )
     SELECT `customers_id`,MAX(`address_book_id`) AS mp
 FROM `my_perenos` GROUP BY `customers_id` ";
if (!$db->query($sql))
    { printf("Err: %s\n", $db->error);};
exit("ok");






  $db->query("DROP TABLE IF EXISTS `my_perenos`"); 
  $sql="CREATE TABLE `my_perenos` (
    `kd` INT NOT NULL AUTO_INCREMENT, PRIMARY KEY (`kd`)
      )
     SELECT c.*,a.`address_book_id`,
a.`entry_gender`,
a.`entry_company`,
a.`entry_firstname`,
a.`entry_lastname`, 
a.`entry_street_address`,
a.`entry_suburb`,
a.`entry_postcode`, 
a.`entry_city`,
a.`entry_state`,
a.`entry_country_id`,
a.`entry_zone_id`,
a.`entry_telephone`,
a.`entry_fax`
 FROM `my_customers_net` c LEFT JOIN `my_adress_ru` a   ON c.`customers_id`=a.`customers_id` ";
if (!$db->query($sql))
    { printf("Err: %s\n", $db->error);};
exit("ok");

/*
,
`orders_id`, 
`customers_street_address`,
`customers_suburb`,
`customers_city`, 
`customers_postcode`, 
`customers_state`, 
`customers_country`, 
`customers_ip`,
`delivery_street_address`,
`delivery_suburb`,
`delivery_city`,
`delivery_postcode`,
`delivery_state`, 
`delivery_country`,
`date_purchased`

*/



	$db->query("DROP TABLE IF EXISTS `my_adress_ru`");

 
	// создаем таблицу
	$sql="CREATE TABLE `my_adress_ru` (
          `address_book_id` int(11),
          `customers_id` int(11),
          `entry_gender` varchar(10),
          `entry_company` varchar(64),
          `entry_firstname` varchar(64),
          `entry_lastname` varchar(64),
          `entry_street_address` varchar(256),
          `entry_suburb` varchar(64),
          `entry_postcode` varchar(20),
          `entry_city` varchar(64),
          `entry_state` varchar(64),
          `entry_country_id` int(11),
          `entry_zone_id` int(11),
          `entry_telephone` varchar(130),
          `entry_fax` varchar(130)
					)";
 

	$db->query($sql);
//echo "<pre>"; print_r($db); echo "</pre>"; exit();

	$ar_r=array(); 
	$ar_v=array();
	$ar_kol=array();
	$nakop=0;
for ($i=0,$l=3000; $i <500000; $i=$i+3000,$l=$l+3000) {
 	gc_collect_cycles();
	$f=fopen ("fbaz.txt$i","rb");
	$rezult=fread ($f,5999999);
	$ar_r=array();   
	preg_match_all("#=====1234543210-----(.+?)--=-=-9988776655--#si", $rezult,$ar_r);
	fclose ($f);
	$pref='';	
	$str_upd_s='';
	$fk=0;	
	foreach ($ar_r[1] as $key => $value) {
		$fk++;
		preg_match("/
               address_book_id\s*?=>(.+?)<br>                              #1
               customers_id\s*?=>(.+?)<br>                                 #2
               entry_gender\s*?=>(.+?)<br>                                 #3
               entry_company\s*?=>(.+?)<br>                                #4
               entry_firstname\s*?=>(.+?)<br>                              #5
               entry_lastname\s*?=>(.+?)<br>                               #6
               entry_street_address\s*?=>(.+?)<br>                         #7
               entry_suburb\s*?=>(.+?)<br>                                 #8
               entry_postcode\s*?=>(.+?)<br>                               #9
               entry_city\s*?=>(.+?)<br>                                   #10
               entry_state\s*?=>(.+?)<br>                                  #11
               entry_country_id\s*?=>(.+?)<br>                             #12
               entry_zone_id\s*?=>(.+?)<br>                                #13
               entry_telephone\s*?=>(.+?)<br>                              #14
               entry_fax\s*?=>(.+?)<br>                                    #15
			/six", $value,$ar_v);
		$str_upd_s.=$pref."('".addslashes (trim($ar_v[1]))."'";
		for($jc=2; $jc<16; $jc++) { 
			$ar_v[$jc]=trim($ar_v[$jc]);
			$str_upd_s.=",'".addslashes ($ar_v[$jc])."'";
		}
		$str_upd_s.=")";
		$pref=',';	
		unset($ar_v);		
	}
	$nakop+=$fk;
	$ar_kol[$i]="$fk---$nakop";
//echo "<pre>"; print_r($str_upd_s); echo "</pre>"; exit();	

//	echo "<pre>"; print_r($str_upd_s); echo "</pre>"; exit();	
//	$str_upd_s=iconv("Windows-1251", "UTF-8", $str_upd_s);
	if (!$db->query("INSERT LOW_PRIORITY   INTO `my_adress_ru` VALUES ". $str_upd_s )) 
		{ printf("Err: %s\n", $db->error);  echo "строка- $i"; exit();};


//echo "<pre>"; print_r($db); echo "</pre>"; exit();	
	unset($ar_r);	
	unset($rezult);
	echo $i." --- ";
}
//echo "<pre>"; print_r($ar_kol); echo "</pre>"; exit();
exit("ok");




// Configuration
if (is_file('config.php')) {
	require_once('config.php');
}

// Install
if (!defined('DIR_APPLICATION')) {
	header('Location: install/index.php');
	exit;
}

// Startup
require_once(DIR_SYSTEM . 'startup.php');

/*
start('catalog');


                    `orders_id int(11)
                    `orders_code varchar(128)
                    `customers_id int(11)
                    `customers_name varchar(64)
                    `customers_company varchar(255)
                    `customers_company_full_name varchar(255)
                    `customers_company_name varchar(255)
                    `customers_company_inn varchar(16)
                    `customers_company_kpp varchar(16)
                    `customers_company_ogrn varchar(32)
                    `customers_company_okpo varchar(32)
                    `customers_company_okogu varchar(32)
                    `customers_company_okato varchar(32)
  					`customers_company_okved varchar(128)
                    `customers_company_okfs` varchar(32)
                    `customers_company_okopf` varchar(32)
                    `customers_company_address_corporate` varchar(255)
                    `customers_company_address_post` varchar(255)
                    `customers_company_telephone` varchar(128)
                    `customers_company_fax` varchar(128)
                    `customers_company_bank` varchar(255)
                    `customers_company_rs` varchar(32)
                    `customers_company_ks` varchar(32)
                    `customers_company_bik` varchar(16)
                    `customers_company_general` varchar(128)
                    `customers_company_financial` varchar(128)
                    `customers_street_address` varchar(255)
                    `customers_suburb` varchar(32)
                    `customers_city` varchar(32)
                    `customers_postcode` varchar(10)
                    `customers_state` varchar(32)
                    `customers_country` varchar(32)
                    `customers_telephone` varchar(32)
                    `customers_email_address` varchar(96)
                    `customers_address_format_id` int(5)
                    `customers_ip` varchar(16)
                    `delivery_name` varchar(64)
                    `delivery_company` varchar(32)
                    `delivery_street_address` varchar(255)
                    `delivery_suburb` varchar(32)
                    `delivery_city` varchar(32)
                    `delivery_postcode` varchar(10)
                    `delivery_state` varchar(32)
                    `delivery_country` varchar(32)
                    `delivery_telephone` varchar(32)
                    `delivery_address_format_id` int(5)
                    `delivery_self_address_id` int(11)
                    `delivery_self_address` varchar(255)
                    `delivery_date date`
                    `delivery_time` varchar(128)
                    `delivery_method` varchar(128)
                    `delivery_method_class` varchar(64)
                    `billing_name` varchar(64)
                    `billing_company` varchar(32)
                    `billing_street_address` varchar(255)
                    `billing_suburb` varchar(32)
                    `billing_city` varchar(32)
                    `billing_postcode` varchar(10)
                    `billing_state` varchar(32)
                    `billing_country` varchar(32)
                    `billing_telephone` varchar(32)
                    `billing_address_format_id` int(5)
                    `payment_method` varchar(128)
                    `payment_method_class` varchar(64)
                    `cc_type` varchar(20)
                    `cc_owner` varchar(64)
                    `cc_number` varchar(32)
                    `cc_expires` varchar(10)
                    `check_account_type` varchar(16)
                    `check_bank_name` varchar(128)
                    `check_routing_number` varchar(16)
                    `check_account_number` varchar(32)
                    `last_modified` datetime
                    `date_purchased` datetime
                    `orders_status` int(5)
                    `orders_total` decimal(15,4)
                    `orders_date_finished` datetime
                    `orders_is_paid` smallint(6)
                    `currency` char(3)
                    `currency_value` decimal(14,6)
                    `partners_cards_id` int(11)
                    `partners_id` int(11)
                    `partners_comission` decimal(3,3)
                    `orders_domain` varchar(64)
                    `delivery_transfer` date
                    `delivery_transfer_city` date
                    `orders_ssl_enabled` smallint(6)
                    `shops_id int(11)



                    orders_id int(11)
                    orders_code varchar(128)
                    customers_id int(11)
                   customers_name varchar(64)
                  customers_company varchar(255)
                  customers_company_full_name varchar(255)
                   customers_company_name varchar(255)
                   customers_company_inn varchar(16)
                    customers_company_kpp varchar(16)
                    customers_company_ogrn varchar(32)
                   customers_company_okpo varchar(32)
 
                    customers_company_okogu varchar(32)
 
                    customers_company_okato varchar(32)
  customers_company_okved varchar(128)

                    customers_company_okfs varchar(32)
                     customers_company_okopf varchar(32)
                    customers_company_address_corporate varchar(255)
                    customers_company_address_post varchar(255)
                    customers_company_telephone varchar(128)
                    customers_company_fax varchar(128)
                     customers_company_bank varchar(255)
                    customers_company_rs varchar(32)
                    customers_company_ks varchar(32)
                    customers_company_bik varchar(16)
                     customers_company_general varchar(128)
                    customers_company_financial varchar(128)
                   customers_street_address varchar(255)
                    customers_suburb varchar(32)
                     customers_city varchar(32)
                    customers_postcode varchar(10)
                    customers_state varchar(32)
                    customers_country varchar(32)
                     customers_telephone varchar(32)
                    customers_email_address varchar(96)
                    customers_address_format_id int(5)
                    customers_ip varchar(16)
                    delivery_name varchar(64)
                    delivery_company varchar(32)
                    delivery_street_address varchar(255)
                    delivery_suburb varchar(32)
                    delivery_city varchar(32)
                    delivery_postcode varchar(10)
                    delivery_state varchar(32)
                   delivery_country varchar(32)
                    delivery_telephone varchar(32)
                    delivery_address_format_id int(5)
                     delivery_self_address_id int(11)
                    delivery_self_address varchar(255)
                    delivery_date date
                    delivery_time varchar(128)
                    delivery_method varchar(128)
                     delivery_method_class varchar(64)
                     billing_name varchar(64)
                    billing_company varchar(32)
                    billing_street_address varchar(255)
                    billing_suburb varchar(32)
                    billing_city varchar(32)
                    billing_postcode varchar(10)
                    billing_state varchar(32)
                    billing_country varchar(32)
                    billing_telephone varchar(32)
                     billing_address_format_id int(5)
                     payment_method varchar(128)
                    payment_method_class varchar(64)
                    cc_type varchar(20)
                    cc_owner varchar(64)
                     cc_number varchar(32)
                    cc_expires varchar(10)
                    check_account_type varchar(16)
                    check_bank_name varchar(128)
                    check_routing_number varchar(16)
                    check_account_number varchar(32)
                    last_modified datetime
                     date_purchased datetime
                    orders_status int(5)
                   orders_total decimal(15,4)
                     orders_date_finished datetime
                    orders_is_paid smallint(6)
                    currency char(3)
                    currency_value decimal(14,6)
                    partners_cards_id int(11)
                    partners_id int(11)
                     partners_comission decimal(3,3)
                     orders_domain varchar(64)
                     delivery_transfer date
                    delivery_transfer_city date
                    orders_ssl_enabled smallint(6)
                    shops_id int(11)
*/
