<?
header("Content-type:text/html; charset=utf-8");
//	基础文件
include("/admin_fun.php");

//	日期参数
	$date = date("Y-m-d");
	$time = date("H");							//access time -> $time

/*

extsta.php?channel=0&channel2=0&id1={01443AEC-0FD1-40FD-9C87-E93D1494C233}&name1=ThunderAtOnce%20Class&id2={3049C3E9-B461-4BC5-8870-4C09146192CA}&name2=RealPlayer%20Download%20and%20Record%20Plugin%20for%20Internet%20Explorer&id3={56CBB761-DA41-4E31-B270-B13B4B0A61D0}&name3=IEPwdBankBHO%20Class&id4={88CEB03E-00CB-4CE1-BA7E-37C0B90898EA}&name4=搜索栏(&T)&id5={CFCDAA03-8BE4-11CF-B84B-0020AFBBCCFA}&name5=RealPlayer%20G2%20Control&id6={D27CDB6E-AE6D-11CF-96B8-444553540000}&name6=Shockwave%20Flash%20Object&id7={E05BC2A3-9A46-4A32-80C9-023A473F5B23}&name7=PlayerCtrl%20Class

011-02-26 04:17:24 W3SVC548012013 118.144.246.186 GET /extsta.php channel=广州&channel2=宏星&id1={14631F4A-A1DA-484E-BB72-03598F8B96F9}&name1=DydLink%20Class&id2={162AF25B-5A2A-448E-A842-194653EF3E05}&name2=KuGoo3Down%20Control&id3={1A3440C6-F123-4CAB-84EE-C814E1AE0D8F}&name3=PIPI%20Link%20Helper&id4={1DABF8D5-8430-4985-9B7F-A30E53D709B3}&name4=InstallHelper%20Class&id5={72267F6A-A6F9-11D0-BC94-00C04FB67863}&name5=Active%20Desktop%20Mover&id6={87515F61-A66C-4319-A0E0-D416CB8059E3}&name6=360SafeLive&id7={88CEB03E-00CB-4CE1-BA7E-37C0B90898EA}&name7=搜索栏(&T)&id8={E05BC2A3-9A46-4a32-80C9-023A473F5B23}&name8=PlayerCtrl%20Class

*/

	$urls = parse_url($_SERVER['REQUEST_URI']);
	parse_str($urls[query]);					//access softs -> $softid
	
	$now_time=mktime();


//	开始扩展参数
	if( empty($channel2) || $channel2=='0' )	$channel2 = "default";
	$extsta_line = "";
	for($i=1;$i<8;$i++){
		$temp_get_id_key = "id".$i;
		$temp_get_name_key = "name".$i;
		if( $_GET[$temp_get_id_key] ){
			$extsta_line.=$channel2."\t".substr($_GET[$temp_get_id_key],0,253)."\t".substr($_GET[$temp_get_name_key],0,253)."\t1\t".$date."\t".$time."\n";			
		}
	}
	
//	新的文本记录方式

	//	路径
	$_path_text_date = $_SERVER['DOCUMENT_ROOT']."/_SITE_LOG/_DTM_".substr($date,0,7)."/_DTD_".substr($date,8,10)."/";
	if( !file_exists($_path_text_date) )  file_path($_path_text_date);
	$_path_hour_log = $_path_text_date.$time."_extsta.txt";
	
	//	内容
	if( !file_exists($_path_hour_log) )	file_put_contents($_path_hour_log,iconv('GBK','UTF-8',"1:U_ID\t2:SOFT_ID\t3:SOFT_PARA\t4:SOFT_NUMER\t5:DATES\t6:TIMES\n"));
	error_log($extsta_line,3,$_path_hour_log);
	echo "write ok!";
?>