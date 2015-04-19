<?

/*
	需要参数
	$bill_date
		
*/
//	数据收集表
if( !isset($hour_table) )	$hour_table= "tong_hourx";

//	数据目标表
if( !isset($tong_days) ){
	$tong_days = "tong_daying";
	//	$hour_table = "tong_dayip";
}

//	开始处理数据
$data_sear = "select `u_id`,count(distinct `mac`) as macs,count(distinct `ips`) as ipss,sum(`activation`) as activations from ".$hour_table." where `dates`='$bill_date' group by `u_id`";
//	access channels price
$cid_price = $db->GetKey("select `id`,`price` from users where `us_type`='channels'");
//	access member price
$bill_price_arr = $db->GetArray("select `id`,`us_name`,`belongs_channels`,`price` from users where `us_type`='member'");
$us_price = array();
for($p=0;$p<count($bill_price_arr);$p++){
	$temp_v = $bill_price_arr[$p];
	$us_price[$temp_v['us_name']] = $temp_v['price']>0?$temp_v['price']:$cid_price[$temp_v['belongs_channels']];	
}
//	access installs
$install_arr = $db->GetKey("SELECT `u_id`,count( `u_id` ) FROM tong_mac WHERE `idate` = '$bill_date' group by `u_id`");

$data_lise = $db->GetArray($data_sear);
if( count($data_lise)>0 ){
	for($i=0;$i<count($data_lise);$i++){
		$temp = $data_lise[$i];
		
		$day_u_id = !empty($temp['u_id'])?$temp['u_id']:"unknow";
		$day_mac_num = $temp['macs'];
		$day_ip_num = $temp['ipss'];
		$day_dates = $bill_date;
		$day_activation = $temp['activations'];
		
		$day_install_num = $install_arr[$day_u_id]?$install_arr[$day_u_id]:0;
		
		$shouyis = $us_price[$day_u_id]*$day_activation;
		//	u_id	mac_num	ip_num	install_num	dates	shouyis
		if( $calcultion=="manual" )	$sql = "insert into tong_day(`u_id`,`mac_num`,`ip_num`,`install_num`,`dates`,`shouyis`,`activation`) values('$day_u_id','$day_mac_num','$day_ip_num','$day_install_num','$day_dates',`$shouyis`,'$day_activation')";
		else	$sql = "update ".$tong_days." set `mac_num`='$day_mac_num',`ip_num`='$day_ip_num',`install_num`='$day_install_num',`activation`='$day_activation',`shouyis`='$shouyis' where `dates`='$day_dates' and `u_id`='$day_u_id'";
		#echo $us_price[$day_u_id]."*".$day_activation.">>>".$sql."\n";
		$db->Excut_sql($sql);
			
		$bill_text.= $day_u_id."数据处理完成!\n\t";
	}
}else{
	$bill_text.= "没有数据!\n\t";	
}
?>