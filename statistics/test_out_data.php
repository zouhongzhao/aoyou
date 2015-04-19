<?php
header("Content-Type:text/html;charset=UTF-8");
include($_SERVER['DOCUMENT_ROOT']."/statistics/common.inc.php");			
include($_SERVER['DOCUMENT_ROOT']."/PageArray.php");
include($_SERVER['DOCUMENT_ROOT']."/admin_fun.php");
$file_data = $_Site_Temp."/to_data.txt";
$file_data = str_replace("\\","\\\\",$file_data);

//$sql = "select `mac`,`mac_number` from tong_mac INTO OUTFILE '$file_data'";
$out_data_sql = "select `mac`,`mac_number` from tong_mac";
$array = GetArray($out_data_sql);
for($i=0;$i<count($array);$i++){
	$line.=$array[$i]['mac']."\t".$array[$i]['mac_number']."\n";
}
file_put_contents($file_data,$line,LOCK_EX);
$in_data_sql = "load data infile '".$file_data."' into table test(`mac`,`mac_age`)";
mysql_query($in_data_sql);

echo "ok";

exit;
print "Hello World!"

?>