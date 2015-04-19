<?
set_time_limit(0);

header("Content-Type:text/html;charset=UTF-8");
include($_SERVER['DOCUMENT_ROOT']."/statistics/common.inc.php");			
include($_SERVER['DOCUMENT_ROOT']."/PageArray.php");
include($_SERVER['DOCUMENT_ROOT']."/admin_fun.php");
// 基本参数
	$now_time = time();
	$today = date("Y-m-d");	
	$yesterday = date("Y-m-d",$now_time-3600*24);	//yesterday
	
//	准备参数
	$bill_date = $yesterday;
	$hour_table = "tong_hourx";

//	准备日志
	$log_bill = $_Site_Path."/site_log/Bill_".substr($bill_date,0,7).".txt";
	
//	处理数据开始
	$bill_text = "BILL DATA ".$bill_date." ->-->--->\n\t";
	error_log($bill_text,3,$log_bill);
	
	$bill_text =  '';
	
	//	调用计算文件
	include("bill_2012.php");

//	转移数据
//	`u_id`,`mac_num`,`ip_num`,`install_num`,`dates`
	$tong_day = "insert into tong_day(`u_id`,`c_id`,`mac_num`,`ip_num`,`install_num`,`starts_num`,`dates`,`income`,`activation`) select * from tong_daying where `dates`='$bill_date'";
	mysql_query($tong_day);
	$bill_text.="处理数据完成!\n";
	error_log($bill_text,3,$log_bill);
//		处理收益
	$sql_income = "insert into users_income(`u_id`,`dates`,`income`) select `u_id`,`dates`,`income` from tong_daying where `dates`='$yesterday'";	
	mysql_query($sql_income);
	$bill_text="处理收益完成!\n";
	$bill_text.="结束!\n";
	error_log($bill_text,3,$log_bill);
	
?>