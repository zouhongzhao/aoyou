<?php
header("Content-Type:text/html;charset=UTF-8");
include($_SERVER['DOCUMENT_ROOT']."/statistics/common.inc.php");			
include($_SERVER['DOCUMENT_ROOT']."/PageArray.php");
include($_SERVER['DOCUMENT_ROOT']."/admin_fun.php");
$file_data = $_Site_Temp."/to_data.txt";
$file_data = str_replace("\\","\\\\",$file_data);

$sql = "load data infile '".$file_data."' into table test(`mac`,`mac_age`)";

mysql_query($sql);
	
echo "ok";

exit;
$fiel_date = 
print "Hello World!"

?>