<?

/*
	需要参数
	$bill_date
		
*/
//	数据目标表
if( !isset($tong_days) ){
	$tong_days = "tong_dayinfo";
	//	$hour_table = "tong_dayip";
}
//	开始处理数据
$data_sear = "select `u_id`,`activation` from ".$tong_days." where `dates`='$bill_date'";
print_r($data_sear);
//	access channels price
$cid_price = GetKey("select `id`,`price` from users where `type`='channels'");
//	access member price
$bill_price_arr = GetArray("select `id`,`name`,`belongs_channels`,`price` from users where `type`='member'");
$us_price = array();
for($p=0;$p<count($bill_price_arr);$p++){
	$temp_v = $bill_price_arr[$p];
	$us_price[$temp_v['name']] = $temp_v['price']>0?$temp_v['price']:$cid_price[$temp_v['belongs_channels']];	
}
//	access installs
$install_arr = GetKey("SELECT `u_id`,count( `u_id` ) FROM tong_mac WHERE `idate` = '$bill_date' group by `u_id`");
print_r($install_arr);

$data_lise = GetArray($data_sear);
if( count($data_lise)>0 ){
	for($i=0;$i<count($data_lise);$i++){
		$temp = $data_lise[$i];
		$day_u_id = $temp['u_id'];
		$day_u_id = $temp['u_id'];
		$day_install_num = $install_arr[$day_u_id]?$install_arr[$day_u_id]:0;
		
		$shouyis = $us_price[$day_u_id]*$temp['activation'];
		$sql = "update ".$tong_days." set `income`='$shouyis',`install_num`='$day_install_num' where `dates`='$yesterday' and `u_id`='$day_u_id'";
		#echo $us_price[$day_u_id]."*".$day_activation.">>>".$sql."\n";
		
		mysql_query($sql);
		$bill_text.= $day_u_id."数据处理完成!\n\t";
	}
}else{
	$bill_text.= "没有数据!\n\t";	
}
?>