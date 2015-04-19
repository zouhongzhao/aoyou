<?php
set_time_limit(0);
header("Content-Type:text/html;charset=UTF-8");
include($_SERVER['DOCUMENT_ROOT']."/statistics/common.inc.php");			
include($_SERVER['DOCUMENT_ROOT']."/PageArray.php");
include($_SERVER['DOCUMENT_ROOT']."/admin_fun.php");
echo mysql_query("load data local infile '_SITE_TEMPSintval_to_daymac_data.txt' into table `tong_daymac` (`u_id`,`mac`,`mac_days`,`ip`,`install`,`starts`,`dates`,`remark`)");

?>