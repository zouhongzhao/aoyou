<?
set_time_limit(0);
header("Content-Type:text/html;charset=UTF-8");
include($_SERVER['DOCUMENT_ROOT']."/statistics/common.inc.php");			
include($_SERVER['DOCUMENT_ROOT']."/PageArray.php");
include($_SERVER['DOCUMENT_ROOT']."/admin_fun.php");
//ini_set('memory_limit','128M');
$pre_date = date('Y-m-d',time()-3600*24);
$log_time_path = $_Site_Log."/Time_".substr($pre_date,0,7).".txt";
//	$_CACHE_data_tong_mac	//INTO OUTFILE '$file_data
//	$_CACHE_data_tong_mac = str_replace("\\","\\\\",$_CACHE_data_tong_mac);
	@unlink($_CACHE_data_tong_mac);
//	memory mac list
	$mac_age_sear_sql = "select `mac`,`mac_number`,`id` from tong_mac";		// INTO OUTFILE '".$_CACHE_data_tong_mac."'";
	$mac_age_arr = GetArray($mac_age_sear_sql);
	$content = "<?\n".
				"\n\t\$mac_mac_number=array(";
	error_log($content,3,$_CACHE_data_tong_mac);
	for($i=0;$i<count($mac_age_arr);$i++){
		error_log("\n\t'".$mac_age_arr[$i]['mac']."'=>array(".$mac_age_arr[$i]['mac_number'].",".$mac_age_arr[$i]['id']."),",3,$_CACHE_data_tong_mac);
	}
	error_log("\n\t);\n?>",3,$_CACHE_data_tong_mac);
	error_log(date('Y-m-d H:i:s')."mac mac_number update success!\n",3,$log_time_path);
?>