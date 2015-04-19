<?
//	行CSS
function trcss(){
	static $css;
	if($css=="tr_f"){
		$css="tr_c";
	}else{
		$css="tr_f";
	}
	return $css;
}
//	数组排序
function Data_Px($Array,$Px,$Sort){
	$_GET['px'] = $Px;
	if( count($Array)<1 )	return '';
	function cmp($a,$b){
		if ($a[$_GET['px']] == $b[$_GET['px']]) return 0;
		return ($a[$_GET['px']] > $b[$_GET['px']]) ? -1 : 1;
		// return strcmp($a[$_GET['px']], $b[$_GET['px']]);
	}
	function rcmp($a,$b){
		if ($a[$_GET['px']] == $b[$_GET['px']]) return 0;
		return ($b[$_GET['px']] > $a[$_GET['px']]) ? -1 : 1;
		//return strcmp($b[$_GET['px']], $a[$_GET['px']]);
	}
	if( $Sort=='desc' )	usort($Array,'cmp');
	else usort($Array,'rcmp');
	return $Array;
}
//	
function response_second($second){
	if( $second>3600*24 )	return floor($second/(3600*24))."天前";
	if( $second>3600 )	return floor($second/3600)."小时前";
	if( $second>60 ) return floor($second/60)."分钟前";
	return "刚刚";
}
//	时间差
function time_difference($time,$model='minute'){
	$now_time = time();
	if( strstr($time,"-") ){
		if( strstr($time,":") ){
			$temp_date_time = explode(" ",$time);
			$temp_date = explode("-",$temp_date_time[0]);
			$temp_time = explode(":",$temp_date_time[1]);
		}
		else{
			$temp_date = explode("-",$time);
			$temp_time = array(0,0,0);	
		}
		$history_time = mktime($temp_time[0],$temp_time[1],$temp_time[2],$temp_date[1],$temp_date[2],$temp_date[0]);
	}
	else $history_time = $time;
	$time_difference = $now_time - $history_time;
	if( $time_difference>3600*24*7 )	return date("Y-m-d",$history_time);
	return response_second($time_difference);
}

//	类别处理
function replace(&$val){
	$val=ereg_replace("[\n\r]","",$val);
	return $val;
}	
function smarray($str){
	if( strstr($str,"\n") || strstr($str,",") ){
		if( strstr($str,"\n") ) $sm_array=explode("\n",$str); 
		else $sm_array=explode(",",$str);
		//return array_walk_recursive($sm_array,'replace');
		array_walk($sm_array,'replace');
		return $sm_array;
	}
	else	return array($str);
}
//	提交地址
function formurl(){
	$ur = htmlentities($_SERVER['REQUEST_URI']);
	$ur = str_replace ("/","",strrchr($ur,"/"));
	if( strstr($ur,"?") )	return $ur."&xg=yes";
	else if( strstr($ur,"add") && strstr($ur,"?") ) return $ur."&news=add";
	else return $ur."?news=add";
}
//	目录函数
function file_path($fm){
	if( !strstr($fm,"/") ){
		return $fm;
		echo $fm;
	}else{
		$fms=explode("/",$fm);
		if( strstr($fm,"..") && count($fms)>2 ){
			array_pop($fms);
			$fmf=$fms[0];
			for($i=1;$i<count($fms);$i++){
				if( !strstr($fms[$i],".") ){
					$fmf.="/".$fms[$i];
					if( !file_exists($fmf) ) mkdir($fmf,0755);
				}
			}
			$fmf = ereg_replace("/$","",$fmf).strrchr($fm,"/");
		}elseif( count($fms)>2 ){
			$fmf='';
			for($i=0;$i<count($fms);$i++){
				if( !strstr($fms[$i],".") ){
					$fmf.=$fms[$i]."/";
					if( !file_exists($fmf) )	mkdir($fmf,0755);
				}
			}
		}else{
			$fmf=$fms[0]."/";
			if( !file_exists($fmf) ) mkdir($fmf,0755);
			$fmf = ereg_replace("/$","",$fmf).strrchr($fm,"/");
		}	
	}
	return $fmf;
}
//	HTTP目录
function path_cl($pathing,$fs="files",$ml=""){
	$path=str_replace("\\","/",$_SERVER['SCRIPT_FILENAME']);
	$php_selfs=str_replace("\\","/",$_SERVER['PHP_SELF']);
	if( $fs=="files" ) $dq_path=str_replace(strrchr($path,"/"),"",$path);
	else $dq_path=str_replace(strrchr($php_selfs,"/"),"","http://".$_SERVER['HTTP_HOST'].$php_selfs);
	$dq_paths=explode("/",$dq_path);
	$count_path=count($dq_paths);
	$file_sl=substr_count($pathing,"/");
	$path_name=str_replace("../","",$pathing);
	if( strstr($pathing,"../") ){
		$file_fl=substr_count($pathing,"../");
		if( strstr($path_name,".") )	$lj_end = str_replace(strrchr($path_name,"/"),"",$path_name)."/";
		$lj = "";
		for($i=0;$i<$count_path-$file_fl;$i++){
			$lj.=$dq_paths[$i]."/";
		}
		if( $ml=="contents" )	return $lj.$lj_end;
		else return $lj.$path_name;
	}else{
		if( $ml=="contents" )	return $dq_path;
		else return $dq_path."/".$pathing;
	}
}

//	单选生成函数
function select($name,$text,$default=0,$auth_length=4){
	/*
		$name	生成的NAME
		$text	生成的说明文字
		$default 单选中哪个设为选中状态
	*/
	$select = "<li>\n[$text]: ";
	$auth_name = array("无","读取","写入","修改","全部");
	for($i=0;$i<=$auth_length;$i++){
		if( $i==$default )	$select.="<input name='_$name' type='radio'checked='checked' value='$i' />".$auth_name[$i];
		else $select.="<input name='_$name' type='radio' value='$i' />".$auth_name[$i];		
	}
	$select.="</li>\n";
	return $select;
}
//	分析 X_LB 以得到数组
function sm_to_array($lb_type){
	global $db;
	$response_arr = array();
	if( is_array($lb_type) ){
		$sql_lb_list="select `sm` from x_lb where `mc`='{$lb_type[0]}' and `ur`='{$lb_type[1]}'";
		$lb_sm = $db->GetOne($sql_lb_list);
		$list_array = smarray($lb_sm);
		foreach($list_array as $lv){
			if( strstr($lv,":") ){
				$temp_val = explode(":",$lv);
				$response_arr[$temp_val[0]] = $temp_val[1];
			}
			else $response_arr[$lv] = $lv;
		}
	}else{
		$sql_lb_list = "select `mc`,`ur`,`lb` from x_lb where `mc`='$lb_type' order by `ur`";
		$lb_list = $db->GetArray($sql_lb_list);
		foreach($lb_list as $lv)	$response_arr[$lv['ur']]=$lv['lb'];
	}
	return $response_arr;
}

//	分析数据表生成 下拉函数
function option_list($lb_type,$use=""){
	$list_array = sm_to_array($lb_type);
	foreach($list_array as $lk=>$lv){
		if( !empty($use) )	if( $lv==$use || $lk==$use || strstr($lv,$use) )	 $selected_index=" selected='selected'";
		else	$selected_index = "";
		$option_html.= "<option value=\"".$lk."\"".$selected_index.">".$lv."</option>\n";
	}
	return $option_html;
}
//	分析数组生成下拉
function option_array($list_arr,$active=""){
	if( is_array($list_arr) && count($list_arr)>0 ){
		$out_temp = '';
		foreach($list_arr as $vl=>$text){
			if( $active==$vl )	$out_temp.="<option value=\"".$vl."\" selected='selected'>".$text."</option>\n";
			else $out_temp.="<option value=\"".$vl."\">".$text."</option>\n";
		}
		return $out_temp;
	}
}
//	输出模块所生成的内容
function model_id_response($id){
	global $db;
	$model_info = $db->GetOne("SELECT * FROM `page_label` WHERE id=".$id);
	if( $model_info['cl_fs']=="mysql" ){
		include($_SERVER['DOCUMENT_ROOT']."/admin/cl_center/".$model_info['cl_module']."_".$model_info['id'].".php");
	}else{
		$content = stripslashes($model_info['nr']);
	}
	return $content;
}
//	中文长度
function cn_strlen($str){
	return mb_strlen($str,"UTF8");
}
function utf_substr($sourcestr,$cutlength,$end=""){
	$returnstr='';
	$i=0;
	$n=0;
	$str_length=mb_strlen($sourcestr,"UTF8");//字符串的字节数
	$str_len = strlen($sourcestr);
	while (($n<$cutlength) and ($i<=$str_len))
	{
		$temp_str=substr($sourcestr,$i,1);
		$ascnum=Ord($temp_str);//得到字符串中第$i位字符的ascii码
		if ($ascnum>=224)    //如果ASCII位高与224，
		{
			$returnstr=$returnstr.substr($sourcestr,$i,3); //根据UTF-8编码规范，将3个连续的字符计为单个字符         
			$i=$i+3;            //实际Byte计为3
			$n++;            //字串长度计1
		}
		elseif ($ascnum>=192) //如果ASCII位高与192，
		{
			$returnstr=$returnstr.substr($sourcestr,$i,2); //根据UTF-8编码规范，将2个连续的字符计为单个字符
			$i=$i+2;            //实际Byte计为2
			$n++;            //字串长度计1
		}
		elseif ($ascnum>=65 && $ascnum<=90) //如果是大写字母，
		{
		 	$returnstr=$returnstr.substr($sourcestr,$i,1);
		 	$i=$i+1;            //实际的Byte数仍计1		
		 	$n++;            //但考虑整体美观，大写字母计成一个高位字符
		}
		else                //其他情况下，包括小写字母和半角标点符号，
		{
			$returnstr=$returnstr.substr($sourcestr,$i,1);
			$i=$i+1;            //实际的Byte数计1个
			if( is_numeric($returnstr) ) $n=$n+0.5;
			$n++;        //小写字母和半角标点等与半个高位字符宽...
		}
	}
	if ($str_length>$cutlength){
		$returnstr = $returnstr.$end;//超过长度时在尾处加上省略号
	}
	return $returnstr;
}
function post_fckedit($str){
	$str = trim($str);
	/*
	if( substr($str,0,5)=="<div>" ){
		$str = ereg_replace("^<div>","",$str);
		if( strstr($str,"<div>") )	$str=ereg_replace("</div></div>$","</div>",$str);
		else $str = ereg_replace("</div>$","",$str);
	}*/
	return $str;
}
function response_img($img_info){
	if( empty($img_info) )	return '';
	if( strstr($img_info,"#") )	return "<img src='".str_replace("#","' alt='",$img_info)."' />";
	else return "<img src='".$img_info."' />";
}

	function GetKey($sql){
		$ResultArray = array();
		//$query_result=mysql_query($sql,$this->cn) or die($this->msg("SQL 语句有错误,请检查 [ ".htmlspecialchars($sql)." ]") );
		$query_result = mysql_query($sql);
		while( $row= mysql_fetch_array($query_result) )
		{
			$ResultArray[$row[0]] = $row[1];
		}
		return $ResultArray;
	}

	function GetOne($sql){
		//	$query = mysql_query($sql,$this->cn) or die($this->msg("SQL 语句有错误,请检查 [ ".htmlspecialchars($sql)." ]") );
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		if( $row[1] ) return $row;
		else return $row[0];
	}

	function GetAll($sql){
		$ResultArray = array();
		$query_result = mysql_query($sql);
		while( $row=mysql_fetch_array($query_result) )
		{
			$ResultArray[]=$row;
		}
		return $ResultArray;
	}

	function GetArray($sql,$num=0){
		$ResultArray = array();
		if( $num>0 ){
			if( !strstr($sql,"limit") && !strstr($sql,"LIMIT") ){
				$sql.=" limit 0,".$num;
			}
		}
		$query_result = mysql_query($sql);
		$i=0;
		while( $row=mysql_fetch_array($query_result) ){
			$ResultArray[$i]=$row;
			$i++;
		}
		return $ResultArray;
	}
?>