<?
set_time_limit(0);
header("Content-Type:text/html;charset=UTF-8");
include($_SERVER['DOCUMENT_ROOT']."/statistics/common.inc.php");			
include($_SERVER['DOCUMENT_ROOT']."/PageArray.php");
include($_SERVER['DOCUMENT_ROOT']."/admin_fun.php");

// 基本参数
	$now_time=mktime();
	$date=date("Y-m-d");
	$pre_date=date("Y-m-d",$now_time-3600);		//pre date
	$pre_time=date("H",$now_time-3600);			//pre hour
	$now_time_hour = date("H");
	
//	日志路径
	$log_time_path = $_Site_Log."/Time_".substr($pre_date,0,7)."_extsta.txt";
	
	$log_text = date("Y-m-d H:i:s")."开始记录的".$pre_date." ".$pre_time."内容开始\n\t";
	error_log($log_text,3,$log_time_path);
	
//	数据信息
	$in_extsta_path = $_Site_Path."/statistics/temp/_DTM_".substr($pre_date,0,7)."/_DTD_".substr($pre_date,8,10)."/".$pre_time."_extsta.txt";
	$to_extsta_path = $_Site_Path."/site_data/".$pre_date."_extsta.txt";

//	初始化环境
	$GS_class = new PageArray;

//	开始浏览次数的处理	to_extsta_path
	
	if( !file_exists($to_extsta_path) ){
		file_put_contents($to_extsta_path,iconv('GBK','UTF-8',"1:U_ID\t2:SOFT_ID\t3:SOFT_PARA\t4:SOFT_NUMER\t5:DATES\t6:TIMES\n"));
	}

//	开始处理信息
//	1:U_ID\t2:SOFT_ID\t3:SOFT_PARA\t4:SOFT_NUMER\t5:DATES\t6:TIMES
	
if( file_exists($in_extsta_path) ){
	$temp_extsta_array = $GS_class->Str_To_Array($in_extsta_path,"\n","\t","del","ok");
	$extsta_sum_group = $GS_class->Group_Sum($temp_extsta_array,"1,2,3","4",0,'false');
	sort($extsta_sum_group);
	
	$insert_hour = "insert into extsta_hour(`u_id`,`soft_id`,`soft_para`,`soft_numer`,`dates`,`times`) values";
	//	数据数据写入	
	for($i=0;$i<count($extsta_sum_group);$i++){
		$temp_arr = $extsta_sum_group[$i];
		$to_extsta_line.= $temp_arr[1]."\t".$temp_arr[2]."\t".$temp_arr[3]."\t".$temp_arr[4]."\t".$temp_arr[5]."\t".$temp_arr[6]."\n";
		$insert_hour.="('".$temp_arr[1]."','".$temp_arr[2]."','".$temp_arr[3]."','".$temp_arr[4]."','".$pre_date."','".$pre_time."'),";
	}
	//	写入文件
	error_log($to_extsta_line,3,$to_extsta_path);
	//	数据库
	$insert_hour = preg_replace("/,$/","",$insert_hour);
	mysql_query($insert_hour);
	error_log("完成扩展数据的小时记录!\n",3,log_time_path);		
}else{
	echo $in_extsta_path."没有数据";
	error_log("没有找到扩展文件数据!\n",3,$log_time_path);
}
?>