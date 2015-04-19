<?
set_time_limit(0);
header("Content-Type:text/html;charset=UTF-8");
include($_SERVER['DOCUMENT_ROOT']."/statistics/common.inc.php");			
include($_SERVER['DOCUMENT_ROOT']."/PageArray.php");
include($_SERVER['DOCUMENT_ROOT']."/admin_fun.php");
ini_set('memory_limit','256m');
// 基本参数
	$today = date("Y-m-d");	
	$yesterday = date("Y-m-d",time()-3600*24);	//yesterday
	$twoday = date("Y-m-d",time()-(3600*24*2));	//	二天
	$Threeday = date("Y-m-d",time()-(3600*24*3));	//	三天
	$cq_date = date("Y-m-d",time()-3600*24*7);		//	一周
	$month_date = date("Y-m-d",time()-3600*24*15);		//	十五天
	

//	准备日志
	$log_day_path = $_Site_Log."/Day_".$today.".txt";
	$log_text = $today."---------Day Interval--------------\n\t";
	error_log($log_text,3,$log_day_path);

//	templater file
	$temp_daymac_data = _SITE_TEMPS."intval_to_daymac_data.txt";	
	$temp_daymac_data = str_replace("\\","\\\\",$temp_daymac_data);
	$temp_mac_data = _SITE_TEMPS."intval_to_mac_data.txt";
	$temp_mac_data = str_replace("\\","\\\\",$temp_mac_data);
	
//	删除 前 天前[小时]中转数据库的数据	$pre_date=date("Y-m-d",$now_time-3600);
	$tong_houring_del = "delete from tong_hour where `dates`='$cq_date'";
	mysql_query($tong_houring_del);
	$log_text = "DELETE Tong_hour week ok\n\t";
	error_log($log_text,3,$log_day_path);

//	删除 二天前的日期中转表
	$tong_daying_del="delete from tong_daying where `dates`='$twoday'";
	mysql_query($tong_daying_del);
	$log_text = "DELETE tong_daying TWO DAY \n\t";
	error_log($log_text,3,$log_day_path);

//	删除七天前的MAC地址列表
	$tong_mac_sql = "delete from tong_daymac where `dates`='$cq_date'";
	mysql_query($tong_mac_sql);
	$log_text = "DELETE Tong_daymac THREEDAY ok\n\t";
	error_log($log_text,3,$log_day_path);

//	删除15天前的houx数据
	$tong_hourx_sql = "delete from tong_hourx where `dates`<='$month_date'";
	mysql_query($tong_hourx_sql);
	$log_text = "DELETE Tong_hourx THREEDAY ok\n\t";
	error_log($log_text,3,$log_day_path);

	
//	开始处理数据
	//	u_id	mac	ips install	version	dates	times
	$hour_data = "select `u_id`,count(distinct `mac`) as macs,count(distinct `ips`) ipss,sum(`install`) as installs,sum(`starts`) as startss from tong_hourx where `dates`='$yesterday' group by `u_id` order by `u_id`";
	$hour_data_list = GetAll($hour_data);
// 	print_r($hour_data_list);exit();
	if( count($hour_data_list)>0 ){
		//	用于获取渠道id的数组
		$channels_id = GetKey("select `name`,`belongs_channels` from users");
	
		//	构建SQL
		$sql_day = "insert into tong_daying(`u_id`,`c_id`,`mac_num`,`ip_num`,`install_num`,`starts_num`,`dates`) values";
		for($i=0;$i<count($hour_data_list);$i++){
			$ado = $hour_data_list[$i];
			$tonging_macs = $ado['macs'];
			$tonging_u_id = $ado['u_id'];
			$tonging_ips = $ado['ipss'];
			$tonging_install = $ado['installs'];
			$tonging_starts = $ado['startss'];
			//$tonging_activation = $ado['activations'];
			if( empty($tonging_u_id) )	$tonging_u_id = "unknow";
			$channels_ids = (empty($tonging_u_id) || !$channels_id[$tonging_u_id])?"0":$channels_id[$tonging_u_id];
			$sql_day.="('".$tonging_u_id."','".$channels_ids."','".$tonging_macs."','".$tonging_ips."','".$tonging_install."','".$tonging_starts."','".$yesterday."'),";
		}
		$sql_day = preg_replace("/,$/","",$sql_day);
		mysql_query($sql_day);
		unset($sql_day);
		$log_text = "insert tong_daying ok!\n\t";
		error_log($log_text,3,$log_day_path);
	}else{
		echo "小时数据表中没有内容!";
		$log_text = "Not Data \n";
		error_log($log_text,3,$log_day_path);
		exit();
	}

//	处理MAC天数
	//	$mac_age_sear_sql = "select `mac`,'mac_age' from tong_daymac where `dates`='$yesterday'";
	//	$mac_age_arr = $db->GetKey($mac_age_sear_sql);
	####  缓存的mac 地址信息
	#include($_CACHE_data_tong_mac);	//	response $mac_mac_number
	#$mac_age_arr = $mac_mac_number;
	
	//$insert_tong_dac_may_sql = "insert into tong_daymac(`u_id`,`mac`,`mac_age`,`ip`,`install`,`starts`,`dates`,`activation`) values";
	
	$day_yesterday_mac_sql = "select `u_id`,`mac`,`ips`,sum(`install`) as installs,sum(`starts`) as startss,sum(`activation`) as activations,`version`,`remark` from tong_hourx where `dates`='$yesterday' group by `mac`";
	$day_yesterday_mac = GetArray($day_yesterday_mac_sql);
	
	$a = 0;
	//	UPDATE MAC Day_Number
	$ui =0;
	//	Insert New Mac to tong_may
	$ii = 0;
	//	Update mac day number sql
	$update_mac_sql = "update tong_mac set `mac_number`=(`mac_number`+1),`udate`='$today' where `id` in(";
	//	 获取激活的mac地址数量
	$us_name_active_arr = array();
	for($i=0;$i<count($day_yesterday_mac);$i++){
		$temp_line = $day_yesterday_mac[$i];
		
		$mac_address = $temp_line['mac'];
		if( empty($temp_line['mac']) ) continue;
		if( empty($temp_line['u_id']) )	$temp_line['u_id'] = 'unknow';
		
		//		search mac age info		use data
		$mac_age_arr = GetOne("select `mac`,`mac_number`,`id` from tong_mac where `mac`='".$temp_line['mac']."'");
		
		if( is_array($mac_age_arr) && count($mac_age_arr)>0 ){
				$update_mac_sql.=$mac_age_arr['id'].",";
				$mac_ages = intval($mac_age_arr['mac_number'])+1;			//		tong_day_mac	
				//		当mac地址已经存在三天的时候开始计入激活
				if( intval($mac_age_arr['mac_number'])==3 ){
							$us_name_active_arr[$temp_line['u_id']]+=1;
				}
				$ui++;
		}else{
				$mac_ages = 0;
				$new_mac_line.=$temp_line['u_id']."\t".$mac_address."\t1\t".$yesterday."\t".$today."\n";
				$ii++;
		}
		/*
		if( array_key_exists($temp_line['mac'],$mac_age_arr) ){
			$update_mac_sql.=$mac_age_arr[$temp_line['mac']][1].",";
			$mac_ages = $mac_age_arr[$temp_line['mac']][0]+1;
			//		当mac地址已经存在三天的时候开始计入激活
			//		数据量大的时候使用数据库查询
			if( $mac_age_arr[$temp_line['mac']][0] == 3 ){
					$us_name_active_arr[$temp_line['u_id']]+=1;
			}
			$ui++;
		}else{
			$mac_ages = 0;
			$new_mac_line.=$temp_line['u_id']."\t".$mac_address."\t1\t".$yesterday."\t".$today."\n";
			$ii++;
		}
		*/
		$insert_tong_day_mac_line.=$temp_line['u_id']."\t".$temp_line['mac']."\t".$mac_ages."\t".$temp_line['ips']."\t".$temp_line['installs']."\t".$temp_line['startss']."\t".$yesterday."\t".$temp_line['version']."\t".$temp_line['remark']."\n";
		$a++;
	}
	
	if( $a>0 ){
		//		
// 		print_r($insert_tong_day_mac_line);exit();
		file_put_contents($temp_daymac_data,$insert_tong_day_mac_line,LOCK_EX);
		unset($insert_tong_day_mac_line);
		
		$insert_tong_day_mac_sql = "load data local infile '".$temp_daymac_data."'into table tong_daymac(`u_id`,`mac`,`mac_age`,`ip`,`install`,`starts`,`dates`,`version`,`remark`)";
// 		print_r($insert_tong_day_mac_sql);exit();
		mysql_query($insert_tong_day_mac_sql) or die (mysql_error());
	}
	$log_text = "Handled ".$a." MAC record;\n";
	error_log($log_text,3,$log_day_path);
/*
//	mac list		ＦＩＥＬＤ：	mac_number mac  idate
	$history_mac = $db->GetKey("select `mac`,`id` from tong_mac");
	
	//$new_mac_sql =  "insert into tong_mac(`u_id`,`mac`,`mac_number`,`idate`,`udate`) values";
	$update_mac_sql = "update tong_mac set `mac_number`=(`mac_number`+1),`udate`='$today' where `id` in(";
	$ui =0;
	$ii = 0;

	for($i=0;$i<count($day_yesterday_mac);$i++){
		$temp_line = $day_yesterday_mac[$i];
		$mac_address = $temp_line['mac'];
		if( empty($mac_address) ) continue;
		if( empty($temp_line['u_id']) )	$temp_line['u_id'] = 'unknow';
		if( array_key_exists($mac_address,$history_mac) ){
			$update_mac_sql.=$history_mac[$mac_address].",";
			$ui++;
		}else{
			//$new_mac_sql.="('".$temp_line['u_id']."','".$mac_address."',1,'".$yesterday."','".$today."'),";
			$new_mac_line.=$temp_line['u_id']."\t".$mac_address."\t1\t".$yesterday."\t".$today."\n";
			$ii++;
		}
	}*/
	$update_mac_sql = substr($update_mac_sql,0,-1).")";

	$log_text = '';
	if( $ui>0 ){		
		mysql_query($update_mac_sql);
		unset($update_mac_sql);
		$log_text = "\tUpdate ".$ui." of Mac record;\n";
	}
	if(	$ii>0 ){
		file_put_contents($temp_mac_data,$new_mac_line,LOCK_EX);
		unset($new_mac_line);
// 		print_r($temp_mac_data);exit();
		$new_mac_sql = "load data local infile '".$temp_mac_data."' into table tong_mac(`u_id`,`mac`,`mac_number`,`idate`,`udate`)";
		mysql_query($new_mac_sql);
		
	}
	$log_text.= "\tTotal added ".$ii." more Mac record;\n";
	error_log($log_text,3,$log_day_path);
	
	//		更新激活数字
	if( count($us_name_active_arr)>0 ){
			foreach($us_name_active_arr as $u_id=>$active){
					$active = intval($active);
					$update_active = "update `tong_daying` set `activation`=$active where `u_id`='$u_id'";
					mysql_query($update_active);
			}
			$log_text = "\tUpdated ".count($us_name_active_arr)." of the activation of user data(".$update_active.");\n";
			error_log($log_text,3,$log_day_path);
	}
	//		做一份备注报表
	$remark_sql = "insert into tong_day_remark(`u_id`,`remark`,`remark_num`,`install`,`starts`,`activation`,`dates`) SELECT `u_id` , `remark` , count(`mac`),sum(`install`),sum(`starts`),sum(`activation`),`dates` from tong_daymac where `dates`='$yesterday' GROUP BY `u_id`,`remark`";
// 	print_r($remark_sql);exit();
	mysql_query($remark_sql);
	//		做一份版本报表
	$version_sql = "insert into tong_day_version(`u_id`,`install`,`starts`,`activation`,`version`,`dates`) SELECT `u_id` ,sum(`install`),sum(`starts`),sum(`activation`),`version`,`dates` from tong_daymac where `dates`='$yesterday' GROUP BY `u_id`,`version`";
// 	print_r($remark_sql);exit();
	mysql_query($version_sql);
	$log_text = "\tHandle versioning statements complete;\n";
	error_log($log_text,3,$log_day_path);
	
?>