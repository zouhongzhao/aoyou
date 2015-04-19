<?
set_time_limit(0);
header("Content-Type:text/html;charset=UTF-8");
include($_SERVER['DOCUMENT_ROOT']."/statistics/common.inc.php");			
include($_SERVER['DOCUMENT_ROOT']."/PageArray.php");
include($_SERVER['DOCUMENT_ROOT']."/admin_fun.php");

// 基本参数
	$now_time=time();
	$date=date("Y-m-d");
	$pre_date=date("Y-m-d",$now_time-3600);		//pre date
	
	$pre_time=date("H",$now_time-3600);			//pre hour
	//echo $pre_date;exit();
	$now_time_hour = date("H");

//	日志路径
	$log_time_path = $_Site_Log."/Time_".substr($pre_date,0,7).".txt";
if( !file_exists($log_time_path) )  file_path($log_time_path);
//	日志内容
	$log_text = "AUTO SetIntval Time [".date("Y-m-d H:i:s")."]:\n\t";
	
	error_log($log_text,3,$log_time_path);
	
//	########	文本记录	######
	//	安装信息
	$in_data_path = $_Site_Path."/_SITE_LOG/_DTM_".substr($pre_date,0,7)."/_DTD_".substr($pre_date,8,10)."/".$pre_time.".txt";
	$to_data_path = $_Site_Path."/site_data/".$pre_date.".txt";
	//	浏览信息
	$in_browse_path = $_Site_Path."/_SITE_LOG/_DTM_".substr($pre_date,0,7)."/_DTD_".substr($pre_date,8,10)."/".$pre_time."_browse.txt";
	$to_browse_path = $_Site_Path."/site_data/".$pre_date."_browse.txt";
	
	if( !file_exists($to_data_path) ){
		file_path($to_data_path);
		file_put_contents($to_data_path,iconv('GBK','UTF-8',"1:U_ID\t2:Mac\t3:IpAddress\t4:Install\t5:Star\t6:VERSION\t7:Date\t8:Times\t9:ChannelID\t10:Remark\n"));
	}
	
//	初始化环境
	$GS_class = new PageArray;
	//	处理客户端的安装信息
	if( file_exists($in_data_path) ){
				//	in	1:版本号\t	2:经销号\t	3:IpAdd\t	4:Mac\t	5:Install\t	6:Starts\t	7:Date\t	8:Time
				//	in  1:VERSION\t2:Remark\t3:IpAdd\t4:Mac\t5:Install\t6:Start\t7:Date\t8:Time\n
				echo "--机器参数处理开始...--\n";
				//	Str_To_Array[ $file_path,$splita:'',$splitb:'',$one:del,$key:ok ]
				$temp_mac_array = $GS_class->Str_To_Array($in_data_path,"\n","\t","del","ok");
// 				print_r($temp_mac_array);exit();
				//	Group_Sum	($this_array,$group,$sums,$upc=432000)
				$sum_mac_group = $GS_class->Group_Sum($temp_mac_array,"4","5,6",0);
// 				
				sort($sum_mac_group);
// 				print_r($sum_mac_group);exit();
				//	初始化SQL		
				$hourx_sql = "insert into tong_hourx(`u_id`,`mac`,`ips`,`install`,`starts`,`version`,`dates`,`times`,`remark`) values";
				
				//	OUT	1:渠道号\t2:Mac\t3:IpAddress\t4:Install\t5:Starts\t6:版本号\t7:Date\t8:Times ### \9:ChannelID\10:Remark
				for($i=0;$i<count($sum_mac_group);$i++){
					$temp_arr = $sum_mac_group[$i];
					$hourx_sql.="('".$temp_arr[10]."','".$temp_arr[4]."','".$temp_arr[3]."','".$temp_arr[5]."','".$temp_arr[6]."','".$temp_arr[1]."','".$temp_arr[7]."','".$temp_arr[8]."','".$temp_arr[10]."'),";
					$day_log.= $temp_arr[10]."\t".$temp_arr[4]."\t".$temp_arr[3]."\t".$temp_arr[5]."\t".$temp_arr[6]."\t".$temp_arr[1]."\t".$temp_arr[7]."\t".$temp_arr[8]."\t".$temp_arr[9]."\t".$temp_arr[10]."\n";			
					//		准备记录用户的id 以方便自动给用户注册
					$auto_uid_reg[$temp_arr[9]] = $temp_arr[10];
				}
				//	写入到备份文件
				error_log($day_log,3,$to_data_path);
// 				print_r($auto_uid_reg);exit();
				unset($sum_mac_group);
				$hourx_sql = preg_replace("/,$/","",$hourx_sql);
				
				mysql_query($hourx_sql);
				
				error_log("\t完成了机器台数的小时处理;\n",3,$log_time_path);
	}else{
				echo $in_data_path."没有数据内容";
				error_log("\t".$in_data_path." 文件没有数据内容!\n",3,$log_time_path);
				exit;	
	}
	
	//	导入中转库
	$tong_houring_insert="insert into tong_hour(`u_id`,`mac`,`ips`,`install`,`starts`,`version`,`dates`,`times`) select `u_id`,`mac`,`ips`,`install`,`starts`,`version`,`dates`,`times` from tong_hourx where `dates`='$pre_date' and `times`='$pre_time'";
	mysql_query($tong_houring_insert);
	
	error_log("\t成功导入到[tong_hour]表!\n",3,$log_time_path);

	//		自动注册新的用户名
	//		准备渠道 的 id 数组
	$Usname_to_Id =GetKey("select `us_name`,`id` from users where `us_type`='channels'");
//  	print_r($auto_uid_reg);exit();
	$default_channel_id = 2;
	$log_text = '';
	foreach($auto_uid_reg as $us=>$channel){
		
				$auth_user = GetOne("select `id` from user_auto_reg where `us_name`='$us'");
// 				print_r(intval($auth_user));exit();
				if( intval($auth_user)<1 ){
							$reg_time = $pre_date." ".date("H:i:s");
							if( empty($channel) ) $channel = substr($channel,0,4);
							
							$value_belongs_channels = $Usname_to_Id[$channel]?$Usname_to_Id[$channel]:$default_channel_id;
							
							$value_us_mail = $us.$reg_host_mail;
							$value_us_pass = md5("123456");
							$insert_users_sql =  "insert into users(`us_mail`,`us_name`,`belongs_channels`,`us_pass`,`us_type`,`rtime`) values('".$value_us_mail."','".$us."','".$value_belongs_channels."','".$value_us_pass."','member','".$reg_time."')";
							$insert_auto_uid_reg = "insert into user_auto_reg(`us_name`,`belongs_channels`,`reg_date`,`reg_time`) values('".$us."','".$value_belongs_channels."','".$pre_date."','".$pre_time."')";
							/*
							$log_text.="\t".$insert_users_sql."\n";
							$log_text.="\t".$insert_auto_uid_reg."\n";
							*/
							mysql_query($insert_users_sql);
							$log_text="\tAutomatic registered users:".$us." to complete list!\n";
							
							mysql_query($insert_auto_uid_reg);
							$log_text.="\tTo automatically register to user_auto_reg table completed\n";
				}
	}	
	//	清除上小时的
	//$hourx_del="delete from tong_hourx where `dates`='$pre_date' and `times`='$pre_time' ";
	$log_text.= "\t".$pre_time."时的数据处理完成,时间".date("Y-m-d H:i:s")."时!\n";
	error_log($log_text,3,$log_time_path);


?>