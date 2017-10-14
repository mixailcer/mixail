<?php
// Version
define('VERSION', '2.3.0.2');
    set_time_limit(0);
//	$f=fopen ("fbaz.txt","wb");

    $ar_sim=array();
for ($i=0,$l=3000; $i <1000000; $i=$i+3000,$l=$l+3000) {
 	gc_collect_cycles();
	$connection = curl_init();
	//Устанавливаем адрес для подключения, по умолчанию методом GET
	$z="setbook.ru/qweasd.php?o=".$i.",".$l;
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
//exit("ok");

// archive_orders
// [companies] => Array



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
	$db->query("DROP TABLE IF EXISTS `my_orders_ru`");

 
	// создаем таблицу
	$sql="CREATE TABLE `my_orders_ru` (
                    `orders_id` int(11),
                    `orders_code`varchar(128),
                    `customers_id` int(11),
                    `customers_name` varchar(64),
                    `customers_company` varchar(255),
                    `customers_company_full_name` varchar(255),
                    `customers_company_name` varchar(255),
                    `customers_company_inn` varchar(16),
                    `customers_company_kpp` varchar(16),
                    `customers_company_ogrn` varchar(32),
                    `customers_company_okpo` varchar(32),
                    `customers_company_okogu` varchar(32),
                    `customers_company_okato` varchar(32),
  					`customers_company_okved` varchar(128),
                    `customers_company_okfs` varchar(32),
                    `customers_company_okopf` varchar(32),
                    `customers_company_address_corporate` varchar(255),
                    `customers_company_address_post` varchar(255),
                    `customers_company_telephone` varchar(128),
                    `customers_company_fax` varchar(128),
                    `customers_company_bank` varchar(255),
                    `customers_company_rs` varchar(32),
                    `customers_company_ks` varchar(32),
                    `customers_company_bik` varchar(16),
                    `customers_company_general` varchar(128),
                    `customers_company_financial` varchar(128),
                    `customers_street_address` varchar(255),
                    `customers_suburb` varchar(32),
                    `customers_city` varchar(32),
                    `customers_postcode` varchar(10),
                    `customers_state` varchar(32),
                    `customers_country` varchar(32),
                    `customers_telephone` varchar(32),
                    `customers_email_address` varchar(96),
                    `customers_address_format_id` int(5),
                    `customers_ip` varchar(16),
                    `delivery_name` varchar(64),
                    `delivery_company` varchar(32),
                    `delivery_street_address` varchar(255),
                    `delivery_suburb` varchar(32),
                    `delivery_city` varchar(32),
                    `delivery_postcode` varchar(10),
                    `delivery_state` varchar(32),
                    `delivery_country` varchar(32),
                    `delivery_telephone` varchar(32),
                    `delivery_address_format_id` int(5),
                    `delivery_self_address_id` int(11),
                    `delivery_self_address` varchar(255),
                    `delivery_date` date,
                    `delivery_time` varchar(128),
                    `delivery_method` varchar(128),
                    `delivery_method_class` varchar(64),
                    `billing_name` varchar(64),
                    `billing_company` varchar(32),
                    `billing_street_address` varchar(255),
                    `billing_suburb` varchar(32),
                    `billing_city` varchar(32),
                    `billing_postcode` varchar(10),
                    `billing_state` varchar(32),
                    `billing_country` varchar(32),
                    `billing_telephone` varchar(32),
                    `billing_address_format_id` int(5),
                    `payment_method` varchar(128),
                    `payment_method_class` varchar(64),
                    `cc_type` varchar(20),
                    `cc_owner` varchar(64),
                    `cc_number` varchar(32),
                    `cc_expires` varchar(10),
                    `check_account_type` varchar(16),
                    `check_bank_name` varchar(128),
                    `check_routing_number` varchar(16),
                    `check_account_number` varchar(32),
                    `last_modified` datetime,
                    `date_purchased` datetime,
                    `orders_status` int(5),
                    `orders_total` decimal(15,4),
                    `orders_date_finished` datetime,
                    `orders_is_paid` smallint(6),
                    `currency` char(3),
                    `currency_value` decimal(14,6),
                    `partners_cards_id` int(11),
                    `partners_id` int(11),
                    `partners_comission` decimal(3,3),
                    `orders_domain` varchar(64),
                    `delivery_transfer` date,
                    `delivery_transfer_city` date,
                    `orders_ssl_enabled` smallint(6),
                    `shops_id` int(11),
					KEY (`customers_id`)
					)";
 

	$db->query($sql);
//echo "<pre>"; print_r($db); echo "</pre>"; exit();

	$ar_r=array(); 
	$ar_v=array();
	$ar_kol=array();
	$nakop=0;
for ($i=0,$l=3000; $i <1000000; $i=$i+3000,$l=$l+3000) {
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
                    orders_id\s*?=>(.+?)<br>    						#1
                    orders_code\s*?=>(.+?)<br>    						#2
                    customers_id\s*?=>(.+?)<br>    						#3
                    customers_name\s*?=>(.+?)<br>    					#4
                    customers_company\s*?=>(.+?)<br>    				#5
                    customers_company_full_name\s*?=>(.+?)<br>    		#6
                    customers_company_name\s*?=>(.+?)<br>    			#7
                    customers_company_inn\s*?=>(.+?)<br>    			#8
                    customers_company_kpp\s*?=>(.+?)<br>    			#9
                    customers_company_ogrn\s*?=>(.+?)<br>    			#10
                    customers_company_okpo\s*?=>(.+?)<br>    			#11
                    customers_company_okogu\s*?=>(.+?)<br>    			#12
                    customers_company_okato\s*?=>(.+?)<br>    			#13
  					customers_company_okved\s*?=>(.+?)<br>    			#14
                    customers_company_okfs\s*?=>(.+?)<br>    			#15
                    customers_company_okopf\s*?=>(.+?)<br>    			#16
                    customers_company_address_corporate\s*?=>(.+?)<br>  #17
                    customers_company_address_post\s*?=>(.+?)<br>    	#18
                    customers_company_telephone\s*?=>(.+?)<br>    		#19
                    customers_company_fax\s*?=>(.+?)<br>    			#20
                    customers_company_bank\s*?=>(.+?)<br>    			#21
                    customers_company_rs\s*?=>(.+?)<br>    				#22
                    customers_company_ks\s*?=>(.+?)<br>    				#23
                    customers_company_bik\s*?=>(.+?)<br>    			#24
                    customers_company_general\s*?=>(.+?)<br>    		#25
                    customers_company_financial\s*?=>(.+?)<br>    		#26
                    customers_street_address\s*?=>(.+?)<br>    			#27
                    customers_suburb\s*?=>(.+?)<br>    					#28
                    customers_city\s*?=>(.+?)<br>    					#29
                    customers_postcode\s*?=>(.+?)<br>    				#30
                    customers_state\s*?=>(.+?)<br>    					#31
                    customers_country\s*?=>(.+?)<br>    				#32
                    customers_telephone\s*?=>(.+?)<br>    				#33
                    customers_email_address\s*?=>(.+?)<br>    			#34
                    customers_address_format_id\s*?=>(.+?)<br>    		#35
                    customers_ip\s*?=>(.+?)<br>    						#36
                    delivery_name\s*?=>(.+?)<br>    					#37
                    delivery_company\s*?=>(.+?)<br>    					#38
                    delivery_street_address\s*?=>(.+?)<br>    			#39
                    delivery_suburb\s*?=>(.+?)<br>    					#40
                    delivery_city\s*?=>(.+?)<br>    					#41
                    delivery_postcode\s*?=>(.+?)<br>    				#42
                    delivery_state\s*?=>(.+?)<br>    					#43
                    delivery_country\s*?=>(.+?)<br>    					#44
                    delivery_telephone\s*?=>(.+?)<br>    				#45
                    delivery_address_format_id\s*?=>(.+?)<br>    		#46
                    delivery_self_address_id\s*?=>(.+?)<br>    			#47
                    delivery_self_address\s*?=>(.+?)<br>    			#48
                    delivery_date\s*?=>(.+?)<br>    					#49
                    delivery_time\s*?=>(.+?)<br>    					#50
                    delivery_method\s*?=>(.+?)<br>    					#51
                    delivery_method_class\s*?=>(.+?)<br>    			#52
                    billing_name\s*?=>(.+?)<br>    						#53
                    billing_company\s*?=>(.+?)<br>    					#54
                    billing_street_address\s*?=>(.+?)<br>    			#55
                    billing_suburb\s*?=>(.+?)<br>    					#56
                    billing_city\s*?=>(.+?)<br>    						#57
                    billing_postcode\s*?=>(.+?)<br>    					#58
                    billing_state\s*?=>(.+?)<br>    					#59
                    billing_country\s*?=>(.+?)<br>    					#60
                    billing_telephone\s*?=>(.+?)<br>    				#61
                    billing_address_format_id\s*?=>(.+?)<br>    		#62
                    payment_method\s*?=>(.+?)<br>    					#63
                    payment_method_class\s*?=>(.+?)<br>    				#64
                    cc_type\s*?=>(.+?)<br>    							#65
                    cc_owner\s*?=>(.+?)<br>    							#66
                    cc_number\s*?=>(.+?)<br>    						#67
                    cc_expires\s*?=>(.+?)<br>    						#68
                    check_account_type\s*?=>(.+?)<br>    				#69
                    check_bank_name\s*?=>(.+?)<br>    					#70
                    check_routing_number\s*?=>(.+?)<br>    				#71
                    check_account_number\s*?=>(.+?)<br>    				#72
                    last_modified\s*?=>(.+?)<br>    					#73
                    date_purchased\s*?=>(.+?)<br>    					#74
                    orders_status\s*?=>(.+?)<br>    					#75
                    orders_total\s*?=>(.+?)<br>    						#76
                    orders_date_finished\s*?=>(.+?)<br>    				#77
                    orders_is_paid\s*?=>(.+?)<br>    					#78
                    currency\s*?=>(.+?)<br>    							#79
                    currency_value\s*?=>(.+?)<br>    					#80
                    partners_cards_id\s*?=>(.+?)<br>    				#81
                    partners_id\s*?=>(.+?)<br>    						#82
                    partners_comission\s*?=>(.+?)<br>    				#83
                    orders_domain\s*?=>(.+?)<br>    					#84
                    delivery_transfer\s*?=>(.+?)<br>    				#85
                    delivery_transfer_city\s*?=>(.+?)<br>    			#86
                    orders_ssl_enabled\s*?=>(.+?)<br>    				#87
                    shops_id\s*?=>(.+?)<br>    							#88
			/six", $value,$ar_v);
		$str_upd_s.=$pref."('".addslashes (trim($ar_v[1]))."'";
		for($jc=2; $jc<89; $jc++) { 
			$ar_v[$jc]=trim($ar_v[$jc]);
			if (($jc==49 || $jc==85 || $jc==86) && !mb_ereg_match ("\d\d\d\d-\d\d-\d\d \d\d:\d\d:\d\d", $ar_v[$jc])) $ar_v[$jc]="1999-01-01 01:01:01";
			if (($jc==73 || $jc==74 || $jc==77 ) && !mb_ereg_match ("\d\d\d\d-\d\d-\d\d", $ar_v[$jc])) $ar_v[$jc]="1999-01-01";
			if ($jc==79 && mb_strlen ($ar_v[$jc])>3) { echo $ar_v[$jc]; $ar_v[$jc]=trim($ar_v[$jc]);}
			if ($jc==82 && empty($ar_v[$jc])) $ar_v[$jc]=0;
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
	if (!$db->query("INSERT LOW_PRIORITY   INTO `my_orders_ru` VALUES ". $str_upd_s )) 
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
