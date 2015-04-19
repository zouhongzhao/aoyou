<?php
//ini_set('display_errors','Off');
ini_set('display_errors','On');
//全局变量处理
	if($HTTP_POST_VARS){
		$_POST    = $HTTP_POST_VARS;
		$_GET     = $HTTP_GET_VARS;
		$_COOKIE  = $HTTP_COOKIE_VARS;
		$_SERVER  = $HTTP_SERVER_VARS;
		$_FILES   = $HTTP_POST_FILES;
		$_SESSION = $HTTP_SESSION_VARS;
	}

//	数据库载入
define('CFG_DB_HOST','localhost');				
define('CFG_DB_USER','root');        			
define('CFG_DB_PASSWORD','');  			
define('CFG_DB_ADAPTER','mysql');    			
define('CFG_DB_NAME','guo_logstics');
	
	$connect = mysql_connect(CFG_DB_HOST,CFG_DB_USER,CFG_DB_PASSWORD);
	mysql_select_db(CFG_DB_NAME);
	mysql_query("set names 'utf8' ");
//	设置COOKIE的共享
	ini_set('session.cookie_path','/');
	ini_set('session.cookie_domain',substr(strstr($_SERVER['HTTP_HOST'],"."),1));
	
//	默认路径
	$_Split = "{xxross}";					//	分隔段
	$_Split_Line = "{ssorxxxxross}";		//	分隔行
	$_Site_Path = $_SERVER['DOCUMENT_ROOT'];//站点路径
	//	临时文件和其过期时间
	$_Site_Temp = array(_SITE_TEMPS,7200);	//	用户的行内容显示超时时间
	//	缓存文件和其过期时间
	$_Site_Cache = array(_SITE_CACHE,7200);//	缓存文件(生成的字段文件或是临时表)
	//	网站信息
	$_Site_Info = array("NAME"=>"AOYOUW","HOST"=>"aoyouw.com");
	//	分类的缓存文件
	$_Site_Nlx_Cache = _SITE_CACHE."_nlx_";
	//	缓存的用户权限前缀
	$_Deparment_Competence = _SITE_CACHE."_Deparment_Competence_";
	//	敏感词的路径
	$_sensitive_text_path = _SITE_CACHE."/sensitive_words.txt";

//	数据库错误提示
	//$db->debug=true;

//	Cache tong_mac
	$_CACHE_data_tong_mac = _SITE_CACHE.'cache_data_tong_mac.inc.php';
	
//	数据日志路径
	$_Site_Log = $_Site_Path."/site_log";
//echo $_Site_Log;exit();
//		配置文件

$version_update_info = $_Site_Path."/site_data/version.inc.txt";

//	备用
	$_Site_X_Nlb = $_Site_Path."/site_data/memory/x_nlb.php";	//分类的缓存文件
	$_memory_page_paths = "../site_data/memory/page_";	// 缓存文件的前部分
	
//	激活与金币比例
#		_ACTIVE_JINBI
define("_ACTIVE_JINBI",	100);

//		自动注册时使用的尾部邮箱

$reg_host_mail = "@aoyouw.com";

?>