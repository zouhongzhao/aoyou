<?
set_time_limit(0);
header("Content-Type:text/html;charset=UTF-8");
include($_SERVER['DOCUMENT_ROOT']."/statistics/common.inc.php");		
include($_SERVER['DOCUMENT_ROOT']."/PageArray.php");
include($_SERVER['DOCUMENT_ROOT']."/admin_fun.php");
// 基本参数
	$now_time=time();
	$date=date("Y-m-d");
	//$pre_date=date("Y-m-d",$now_time-3600);		//pre date
	$pre_date='2012-05-13';
	$pre_time=date("H",$now_time-3600);			//pre hour
	$now_time_hour = date("H");
	
//	日志路径
	$log_time_path = $_Site_Log."/Time_".substr($pre_date,0,7)."_browse.txt";
	
	$log_text = date("Y-m-d H:i:s")."开始记录的".$pre_date." ".$pre_time."内容开始\n\t";
	error_log($log_text,3,$log_time_path);
	
//	浏览信息
	$in_browse_path = $_Site_Path."/_SITE_LOG/_DTM_".substr($pre_date,0,7)."/_DTD_".substr($pre_date,8,10)."/".$pre_time."_browse.txt";
	$to_browse_path = $_Site_Path."/site_data/".$pre_date."_browse.txt";
	
//	初始化环境
	$GS_class = new PageArray;
//	开始浏览次数的处理	to_browse_path
	
	if( !file_exists($to_browse_path) ){
		file_put_contents($to_browse_path,iconv('GBK','UTF-8',"1:U_ID\t2:HOST\t3:URL\t4:URL_NUM\t5:DATE\t6:TIME\n"));
	}
//	source	1:U_ID\t2:URL_ADDRESS\t3:URL_NUMBER\t4:DATES\t5:TIMES
//	1:渠道号\t2:主机\t3:浏览地址\t4:次数\t5:日期\t6:时间
if( file_exists($in_browse_path) ){
	$temp_browse_array = $GS_class->Str_To_Array($in_browse_path,"\n","\t","del","ok");
	$browse_sum_group = $GS_class->Group_Sum($temp_browse_array,"1,3","4",0,'false');
	sort($browse_sum_group);
	
	$insert_hour = "insert into browse_hour(`u_id`,`url_host`,`url_address`,`url_number`,`dates`,`times`) values";
	//	数据数据写入	
	for($i=0;$i<count($browse_sum_group);$i++){
		$temp_arr = $browse_sum_group[$i];
		$to_browse_line.= $temp_arr[1]."\t".substr($temp_arr[2],0,35)."\t".$temp_arr[3]."\t".$temp_arr[4]."\t".$temp_arr[5]."\t".$temp_arr[6]."\n";
		$insert_hour.="('".$temp_arr[1]."','".substr($temp_arr[2],0,35)."','".$temp_arr[3]."','".$temp_arr[4]."','".$pre_date."','".$pre_time."'),";
	}
	//	写入文件
	error_log($to_browse_line,3,$to_browse_path);
	//	数据库
	$insert_hour = preg_replace("/,$/","",$insert_hour);
// 	print_r($insert_hour);exit();
	echo mysql_query($insert_hour);
	$result=mysql_query($insert_hour) or die(mysql_error());
	error_log("完成浏览数据的小时记录!\n",3,$log_time_path);		
}else{
	echo $in_browse_path."没有浏览次的数据";
	error_log("没有找到浏览次数的文件数据!\n",3,$log_time_path);
}
?>