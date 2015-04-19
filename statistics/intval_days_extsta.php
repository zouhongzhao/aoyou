<?
set_time_limit(0);
@ini_set('memory_limit','128M');
header("Content-Type:text/html;charset=UTF-8");
include($_SERVER['DOCUMENT_ROOT']."/statistics/common.inc.php");			
include($_SERVER['DOCUMENT_ROOT']."/PageArray.php");
include($_SERVER['DOCUMENT_ROOT']."/admin_fun.php");

// 基本参数
	$today = date("Y-m-d");	
	$yesterday = date("Y-m-d",time()-3600*24);	//yesterday
	$twoday = date("Y-m-d",mktime()-(3600*24*2));	//	二天
	$Threeday = date("Y-m-d",mktime()-(3600*24*3));	//	三天
	$cq_date = date("Y-m-d",time()-3600*24*7);		//	一周
	
//	准备日志
	$log_day_path = $_Site_Log."/Day_".$today."_extsta.txt";
	$log_text = $today."---------Day Extsta Interval--------------\n\t";
	error_log($log_text,3,$log_day_path);

//	删除数据
	
	//	删除 二天前的日期中转表
	$browse_hour_del="delete from extsta_hour where `dates`='$twoday'";
	mysql_query($browse_hour_del);
	$log_text = "DELETE extsta_hour TWO DAY \n\t";
	error_log($log_text,3,$log_day_path);

//	将小时表中的数据转入总表中	tong_browse	browse_hour
	
	$hour_extsta_sql = "select `u_id`,`soft_id`,`soft_para`,sum(`soft_numer`) as soft_numers,`dates` from extsta_hour where `dates`='$yesterday' group by `soft_id`,`soft_para`";
	//$hour_extsta_arr = $db->GetArray($hour_extsta_sql);
	
	$add_line = "insert into tong_extsta(`u_id`,`soft_id`,`soft_para`,`soft_numer`,`dates`) select `u_id`,`soft_id`,`soft_para`,sum(`soft_numer`),`dates` from extsta_hour where `dates`='$yesterday' group by `soft_id`,`soft_para`";
	/*
	for($i=0;$i<count($hour_extsta_arr);$i++){
		$temp_arr = $hour_extsta_arr[$i];		
		$add_line.="('".$temp_arr['u_id']."','".$temp_arr['soft_id']."','".$temp_arr['soft_para']."','".$temp_arr['soft_numers']."','".$yesterday."'),";
	}
	$add_line = ereg_replace(",$","",$add_line);
	*/
	mysql_query($add_line);

	error_log("完成了每天例行扩展数据记录于".date("Y-m-d")."\n",3,$log_day_path);
	
?>