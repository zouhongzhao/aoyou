<?
set_time_limit(0);
header("Content-Type:text/html;charset=UTF-8");
include($_SERVER['DOCUMENT_ROOT']."/statistics/common.inc.php");			
include($_SERVER['DOCUMENT_ROOT']."/PageArray.php");
include($_SERVER['DOCUMENT_ROOT']."/admin_fun.php");

// 基本参数
	$today = date("Y-m-d");	
	$yesterday = date("Y-m-d",time()-3600*24);	//yesterday
	$twoday = date("Y-m-d",time()-(3600*24*2));	//	二天
	$Threeday = date("Y-m-d",time()-(3600*24*3));	//	三天
	$cq_date = date("Y-m-d",time()-3600*24*7);		//	一周
	
//	准备日志
	$log_day_path = $_Site_Log."/Day_".$today."_browse.txt";
	$log_text = $today."---------Day Browse Interval--------------\n\t";
	error_log($log_text,3,$log_day_path);


//	删除数据
	
	//	删除 二天前的日期中转表
	$browse_hour_del="delete from browse_hour where `dates`='$twoday'";
	mysql_query($browse_hour_del);
	$log_text = "DELETE browse_hour TWO DAY \n\t";
	error_log($log_text,3,$log_day_path);
	
//	将小时表中的数据转入总表中	tong_browse	browse_hour
	
	$hour_browse_sql = "select `u_id`,`url_host`,`url_address`,sum(`url_number`) as url_numbers,`dates` from browse_hour where `dates`='$yesterday' group by `u_id`,`url_address`";	
	$hour_browse_arr = GetArray($hour_browse_sql);
// 	print_r($hour_browse_arr);exit();
	$browse_sql = "select `url_host`,`url_number` from tong_browse";
	$browse_arr = GetKey($browse_sql);
	
	$add_line = "insert into tong_browse(`u_id`,`url_host`,`url_address`,`url_number`,`u_date`) values";
	
	for($i=0;$i<count($hour_browse_arr);$i++){
		$temp_arr = $hour_browse_arr[$i];
		
		$add_line.="('".$temp_arr['u_id']."','".$temp_arr['url_host']."','".$temp_arr['url_address']."','".$temp_arr['url_numbers']."','".$yesterday."'),"; 
		/*
		if( !array_key_exists($temp_arr['url_host'],$browse_arr) ){
			$add_line = "insert into tong_browse(`u_id`,`url_host`,`url_address`,`url_number`,`u_date`) values('".$temp_arr['u_id']."','".$temp_arr['url_host']."','".$temp_arr['url_address']."','".$temp_arr['url_numbers']."','".$temp_arr['']."','".date("Y-m-d H:i:s")."')";
			$db->Excut_sql($add_line);
		}else{
			$url_numbers = $browse_arr[$temp_arr['url_host']]+$temp_arr['url_numbers'];
			$up_line = "update tong_browse set `url_number`=url_numbers ";
		}
		*/
	}
	$add_line = preg_replace("/,$/","",$add_line);
	mysql_query($add_line);

	error_log("完成了每天例行浏览网址记录于".date("Y-m-d")."\n",3,$log_day_path);
	
?>