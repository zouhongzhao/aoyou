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

//	日期参数
	$date = date("Y-m-d");
	$time = date("H");							//access time -> $time
	
	$urls = parse_url($_SERVER['REQUEST_URI']);
	parse_str($urls[query]);					//access softs -> $softid
	
	$now_time=mktime();
	
//	获取主机
	function access_host($urls){
		$host = '';
		if( strstr($urls,"http:") ){
			$urls = substr($urls,7);
			if( strstr($urls,"/") )	$host = str_replace(strstr($urls,"/"),"",$urls);	
			else	$host = $urls;
		}else{
			if( strstr($urls,"/") )	$host = str_replace(strstr($urls,"/"),"",$urls);	
			else	$host = $urls;
		}
		return $host;
	}

//	开始处理次数	
//	?ch=渠道号&ad1=地址1&n1=浏览次数&ad2=地址2&n2=浏览次数&adn=地址n&nn=浏览次数
	if( empty($ch) || $ch=='0' )	$ch = "default";
	$browse_line = "";
	for($i=1;$i<6;$i++){
		$temp_get_url_key = "ad".$i;
		$temp_get_num_key = "n".$i;
		if( $_GET[$temp_get_url_key] ){
			$browse_line.= iconv('GBK','UTF-8',$ch)."\t".access_host($_GET[$temp_get_url_key])."\t".substr($_GET[$temp_get_url_key],0,253)."\t".$_GET[$temp_get_num_key]."\t".$date."\t".$time."\n";
			
		}
	}
	
/*
if( in_array($hosting,$web_list) && in_array($softid,$us_list) && $_GET['pvs']!=0 && !empty($adws) ){
*/

	//	新的文本记录方式
	$_path_text_date = $_SERVER['DOCUMENT_ROOT']."/_SITE_LOG/_DTM_".substr($date,0,7)."/_DTD_".substr($date,8,10)."/";
	if( !file_exists($_path_text_date) )  file_path($_path_text_date);
	$_path_hour_log = $_path_text_date.$time."_browse.txt";
	
	//	内容
	if( !file_exists($_path_hour_log) )	file_put_contents($_path_hour_log,iconv('GBK','UTF-8',"1:U_ID\t2:URL-HOST\t3:URL_ADDRESS\t4:URL_NUMBER\t5:DATES\t6:TIMES\n"),LOCK_EX);
	error_log($browse_line,3,$_path_hour_log);
	
/*	
}elseif($_GET['pvs']==0){
	echo "没记录";
	error_log(date("Y-m-d H:m:s")." Error (".$adws."-".$onlineip.") \n \t [URL]: ".$_SERVER['HTTP_REFERER']."; \n\t [ Last_url ]: ".$use."; \n \t [ Host ]:".$hosting." [soft_id] ".$softid." PV 為0; \n",3,"temp/_pvs.txt");
}
*/
?>