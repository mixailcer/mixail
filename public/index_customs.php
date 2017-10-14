<?php
// Version
define('VERSION', '2.3.0.2');
    set_time_limit(0);
//	$f=fopen ("fbaz.txt","wb");
    $ar_sim=array();
for ($i=0,$l=3000; $i <600000; $i=$i+3000,$l=$l+3000) {
 	gc_collect_cycles();
	$connection = curl_init();
	//Устанавливаем адрес для подключения, по умолчанию методом GET
	$z="setbook.net/qweasd.php?c=".$i.",".$l;
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




// Функция подключения к базе
function fun_conn_data() {
	@$db=new mysqli(localhost,"mark","111","mark");
	if (mysqli_connect_errno()) {
		echo 'ОШИБКА ПОДКЛЮЧЕНИЯ К БАЗЕ';
		exit();	
	}; 

	$db->query('SET NAMES utf8'); // установка нужной кодировки
	return $db;
}

	$db=fun_conn_data(); // подключаемся к базе
	// создаем таблицу
	$sql="CREATE TABLE `my_customers_net` (
                    `customers_id` INT,
					`customers_type` VARCHAR(32),
					`ustomers_gender` CHAR,
					`customers_firstname`	VARCHAR(32),
 					`customers_lastname` VARCHAR(32),
					`customers_email_address` varchar(96),
					`customers_email_address_confirmed` smallint(6),
					`customers_is_dummy_account` smallint(6),
					`customers_default_address_id` int(11),
					`customers_telephone` varchar(128),
					`customers_fax` varchar(32),
					`customers_password` varchar(40),
 					`customers_newsletter` char(1),
 					`partners_cards_id` int(11),
					`customers_home_domain` varchar(64),
					`customers_discount` decimal(5,2),
					`customers_discount_type` VARCHAR(32),
 					`customers_status` smallint(6),
					`shops_id` int(11),
					PRIMARY KEY (`customers_id`)
					)";
 

	$db->query($sql);
//echo "<pre>"; print_r($db); echo "</pre>"; exit();

	$ar_r=array(); 
	$ar_v=array();
	$ar_kol=array();
	$nakop=0;
for ($i=0,$l=3000; $i <600000; $i=$i+3000,$l=$l+3000) {
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
		preg_match("/customers_id\s*?=>(.+?)<br>    			#1
			customers_type\s*?=>(.+?)<br>			 			#2
			customers_gender\s*?=>(.+?)<br>			 			#3
			customers_firstname\s*?=>(.+?)<br>					#4
			customers_lastname\s*?=>(.+?)<br>			 		#5		
			customers_dob\s*?=>(.+?)<br> 						#6
			customers_email_address\s*?=>(.+?)<br>	 			#7
			customers_email_address_confirmed\s*?=>(.+?)<br>	#8
			customers_is_dummy_account\s*?=>(.+?)<br>	 		#9
			customers_default_address_id\s*?=>(.+?)<br>		 	#10
			customers_telephone\s*?=>(.+?)<br>		 			#11
			customers_fax\s*?=>(.+?)<br>		 				#12
			customers_password\s*?=>(.+?)<br>		 			#13
			customers_newsletter\s*?=>(.+?)<br>		 			#14
			partners_cards_id\s*?\s*?=>(.+?)<br>		 		#15
			partners_cards_date_added\s*?=>(.+?)<br>			#16
			customers_home_domain\s*?=>(.+?)<br>			    #17
			customers_discount\s*?=>(.+?)<br>		 			#18
			customers_discount_type\s*?=>(.+?)<br>		 		#19
			customers_status\s*?=>(.+?)<br>						#20
			shops_id\s*?=>(.+?)<br>								#21
			/six", $value,$ar_v);
		$str_upd_s.=$pref."('".trim($ar_v[1])."','".addslashes ($ar_v[2])."','".addslashes ($ar_v[3])."','".addslashes ($ar_v[4]).
		            "','".addslashes ($ar_v[5])."','".addslashes ($ar_v[7])."','".$ar_v[8]."','".$ar_v[9]."','".addslashes ($ar_v[10]).
		            "','".addslashes ($ar_v[11])."','".$ar_v[12]."','".$ar_v[13]."','".$ar_v[14]."','".$ar_v[15]."','".$ar_v[17]."','".
		            $ar_v[18]."','".trim($ar_v[19])."','".$ar_v[20]."','".$ar_v[21]."')";
		$pref=',';	
		unset($ar_v);		
	}
	$nakop+=$fk;
	$ar_kol[$i]="$fk---$nakop";


//	echo "<pre>"; print_r($str_upd_s); echo "</pre>"; exit();	
//	$str_upd_s=iconv("Windows-1251", "UTF-8", $str_upd_s);
	$db->query("INSERT LOW_PRIORITY IGNORE  INTO `my_customers_net` VALUES ". $str_upd_s );
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

start('catalog');