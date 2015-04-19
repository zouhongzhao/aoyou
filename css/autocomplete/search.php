<?php
define('IN_ECS', true);
require('../../includes/init.php');
$q = '';
if (isset($_GET['q'])) {
    $q = strtolower($_GET['q']);
}
$type = $_GET['type'];

if (!$q || !$type) {
    return;
}

/**
 * 查询供应商
 */
function search_suppliers(){
	global $db,$q;	
	$sql="SELECT suppliers_id, concat(suppliers_name,'<',suppliers_id,'>') as suppliers_name
	            FROM ecs_suppliers where concat(lcase(suppliers_name),suppliers_id) like '".$q."%'  ";
	$query=$db->query($sql);
	while($row = $db->fetch_array($query,MYSQL_NUM)){
		echo "$row[1]|$row[0]\n";
		
	}  
}

/**
 * 查询分类
 */
function search_cat(){
	global $db,$q;	
	if(empty($q)) return;
	$sql="SELECT cat_id, cat_name
	            FROM ecs_category where concat(lcase(cat_name),cat_id) like '".$q."%'  ";
	$query=$db->query($sql);
	while($row = $db->fetch_array($query,MYSQL_NUM)){
		echo "$row[1]|$row[0]\n";
		
	}  
}

call_user_func("search_".$type);