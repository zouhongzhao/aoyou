<?php
header("Content-type:text/html; charset=utf-8");
//	基础文件
include("/admin_fun.php");

if(getenv('HTTP_CLIENT_IP')) {
	$onlineip = getenv('HTTP_CLIENT_IP');
}elseif(getenv('HTTP_X_FORWARDED_FOR')){
	$onlineip = getenv('HTTP_X_FORWARDED_FOR');
}elseif(getenv('REMOTE_ADDR')) {
	$onlineip = getenv('REMOTE_ADDR');
}else{
	$onlineip = $HTTP_SERVER_VARS['REMOTE_ADDR'];
}

// print_r($_SERVER['DOCUMENT_ROOT']);exit();

//	日期参数
	$date = date("Y-m-d");
	$times = date("H");							//access time -> $times

/*
	参数示例
	install.php?
	MachineID=535b1fbf6eaa3c68787c
	Version=20111216
	ChannelID=8888
	UserId=00001
	remark=xp%20v288
	State=0
	Auth=47fd0eb5905410b449e5d04b9f4198ee
	-------------------------------------------------------
	参数说明：
	MachineID: 机器码(mac)；
	Version:版本；
	ChannelID:渠道id；
	Remark:经销商(普通用户)；
	State:状态 为0时为安装，为1时为启动
	auth:	验证尚未做
*/

	$urls = parse_url($_SERVER['REQUEST_URI']);
	
	parse_str($urls["query"]);					//access softs -> $softid
	//	特别处理安装
	$Install = 0;
	if( intval($State)<1 )	$Install =1;

	$now_time=time();

/*
if( in_array($hosting,$web_list) && in_array($softid,$us_list) && $_GET['pvs']!=0 && !empty($adws) ){
*/
	//	新的文本记录方式
	$_path_text_date = $_SERVER['DOCUMENT_ROOT']."/_SITE_LOG/_DTM_".substr($date,0,7)."/_DTD_".substr($date,8,10)."/";


		//		验证mac 地址
	//if( empty($MachineID) || md5(substr($MachineID,-2)."aoyouw")!=$Auth ){
	//		$_path_days_error_log = $_path_text_date."error.txt";
	//		error_log("\n".$_SERVER['REQUEST_URI'],3,$_path_days_error_log);
	//		exit;
	//}
	
	if( empty($MachineID)){
			$_path_days_error_log = $_path_text_date."error.txt";
			error_log("\n".$_SERVER['REQUEST_URI'],3,$_path_days_error_log);
			exit;
	}
	//		准备目录
	if( !file_exists($_path_text_date) )  file_path($_path_text_date);
	$_path_hour_log = $_path_text_date.$times.".txt";			//		time  log path
	$_path_days_log = $_path_text_date."days.txt";					//		days log path
	

	//	内容
	if( empty($channel2) || $channel2=='0' ){
		$channel2 = empty($channel)?"default":$channel."_0";
	}
	$_log_style = $Version."\t".$UserId."\t".$onlineip."\t".$MachineID."\t".$Install."\t1\t".$date."\t".$times."\t".$ChannelID."\t".$Remark."\n";
	if( !file_exists($_path_hour_log) )	file_put_contents($_path_hour_log,iconv('GBK','UTF-8',"1:VERSION\t2:Remark\t3:IpAdd\t4:Mac\t5:Install\t6:Start\t7:Date\t8:Time\t9:ChannelID\t10:Remark\n"),LOCK_EX);
	error_log($_log_style,3,$_path_hour_log);


//	直接写入日志

	if( !file_exists($_path_days_log) )	file_put_contents($_path_days_log,iconv('GBK','UTF-8',"1:VERSION\t2:Remark\t3:IpAdd\t4:Mac\t5:Install\t6:Start\t7:Date\t8:Time\t9:ChannelID\t10:Remark\n"),LOCK_EX);
	error_log($_log_style,3,$_path_days_log);
/*	
}elseif($_GET['pvs']==0){
	echo "没记录";
	error_log(date("Y-m-d H:m:s")." Error (".$adws."-".$onlineip.") \n \t [URL]: ".$_SERVER['HTTP_REFERER']."; \n\t [ Last_url ]: ".$use."; \n \t [ Host ]:".$hosting." [soft_id] ".$softid." PV 為0; \n",3,"temp/_pvs.txt");
}
*/
?>