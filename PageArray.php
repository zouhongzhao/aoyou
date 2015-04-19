<?php 
//	显示数据函数	数组时
class PageArray{
	private $TotalRowsNum=0;
	private $NowPageNum=1;
	public  $TotalPageNum=1;
	private $UrlString;
	private $PageLeng=5;
	private $IndexBar='';
	private $PageInfo='';
	private $PageRowsNum=20;
	private $Star_Number = 1;	//开始的条数
	private $Zd;			//要搜索的字段
	
	private $site_cache= "";	//	cache patch "fileds/"
	private $site_cache_time;
	private $site_temps= "";	//	site temp file path
	private $site_temps_time;
	
	private $File_Change;
	
	public	$Js_Fun ="seehtml";			// 显示时使用的JS函数的名称
	public	$Array = array();		//处理的数组
	public	$Array_Where = array();
	public	$Sql;

	private $FirstButton="|<";
	private $PreButton="<";
	private $NextButton=">";
	private $EndButton=">|";
	private $NowPageStyle="nowpage";
	//private $tb_field=array('a'=>0,'b'=>1,'c'=>2,'d'=>3,'e'=>4,'f'=>5,'g'=>6,'j'=>7,'i'=>8,'j'=>9,'k'=>10,'l'=>11,'m'=>12,'n'=>13,'o'=>14,'p'=>15,'q'=>16,'r'=>17,'s'=>18,'t'=>19,'u'=>20);
	private $tb_field=array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20);
	private $Search_Key;
	/*
		文件分析类
		接收参数形式
		第一个为 数组 以主键区分
		类型1.文件地址;2.数组;3.SQL
		1: 即为文件的地址 包括为三个参数;A文件地址 B数组分隔 C 数组分解 D 是否删除第一行(默认为是) E 是否为让数组获得一个自动递增的主键
		2: 为数组时 则直接调用数据 不会对数据采取增加主键 和 删除第一行的操作
		3: 详细SQL 包括
			WHERE 功能:
				格式:　[模式]:[字段]:[对比][搜索内容]
				[模式]:为|时为AND(相当于SQL中的组合条件),为-时为OR(相当于组合中的复合查询)
				例1:		|:field:>100,|:field2:*ab => 相当于　and field>100 and field2 like 'ab'
				例2:		|:field:100,-:field2:*ab => 相当于 and field=100 or field2 like 'ab'
			group 功能:	使用处理过的数组(每个数组)的下标做为GROUP 的对象 如 group = 2,3,4 则会对第个数组的 第三/四/五个元素进行分组
			sums  功能: 同 GROUP 相同 方法为 sums = 3,4,5
		
		
		array("_FILE"=>array($sum_file_name,"\n","\t"),
						"_SQL"=>"where=|:1:>".$date_a.",|:1:<".$date_b);
		###	使用方法	###
		$maxnum = 10;		//	显示行
		$pxfs = "desc";		//	排列顺序
		$commeng_path  =  '文件路径';
		$change_arr		= '修改的内容'
		$_Site_Cache 缓存文件
		$_Site_Tempe 临时文件
		
		$xu_sql = array("_FILE"=>array($commeng_path,$_Split_Line,$_Split),"_Change"=>$change_arr);
		$Page=new PageArray($xu_sql,$maxnum,$pxfs,$_Site_Cache,$_Site_Tempe);
		$rows = $Page->Response();
	*/

	public function itest_sums(&$item1, $key, $key_sums){
		foreach($item1[$key_sums] as $sk=>$sv)	$item1[$sk] = $sv;
	}
	
	public function Group_Sum($this_array,$group,$sums,$upc=432000,$memory='true'){
		
		//	检查缓存是否可用	$upc更新時間
		if( !empty($_GET['sou']) )	$sou = "s";
		
// 		$Sum_Group_Memory = $this->site_cache."_Data_".$_GET['db']."_".urlencode($sums.$group."_".$sou).".txt";
		$Sum_Group_Memory = $this->site_cache."_Data_"."_".urlencode($sums.$group."_").".txt";
		
		if( file_exists($Sum_Group_Memory) ) $file_updatetimes =filemtime($Sum_Group_Memory);
		
		//	echo "现在时间".time()." FileTime:".$file_updatetimes."|";
		if( !file_exists($Sum_Group_Memory) || (time()-$file_updatetimes)>$this->site_cache_time || !empty($_GET['sou']) || $memory=='false' ){
			//	echo "<!-- no memory -->";
			//	Group
				$group = explode(",",$group);
				//	Group Arr
				
				$groups_cycle_path = $_SERVER['DOCUMENT_ROOT']."/site_temp/_GS_".".php";
				$group_cycle_path = $_SERVER['DOCUMENT_ROOT']."/_G_".".php";
				
				$groups_cycle_content = $group_cycle_content = "<?\n";
				
				$group_cycle_center = "\$Sum_Group[";
				if( !file_exists($group_cycle_center) ){
					file_path($group_cycle_center);
				}
				for($ii=0;$ii<count($group);$ii++){
					$group_key = $group[$ii];
					$group_cycle_center.="\$temp_item[".$group_key."].\"_\".";
					//	$group_cycle_center.=" \$Sum_Group[".$group_key."][\$temp_item[".$group_key."]] "
				}
				
				$group_cycle_center=preg_replace('/\.$/','',$group_cycle_center).']';
				
				$groups_cycle_content.= "if( !".$group_cycle_center." )\t".$group_cycle_center."=\$temp_item;\n".$group_cycle_center."[\$key_sums][\$sum_key]+=\$temp_item[\$sum_key];\n";
				/*	$groups_cycle_content.= "if( ".$group_cycle_center." ) ".$group_cycle_center."[\$sum_key]+=\$temp_item[\$sum_key];\nelse ".$group_cycle_center."=\$temp_item;\n";$groups_cycle_content.=$group_cycle_center."[count(\$temp_item)][\$sum_key][]=\$i.\":\".\$temp_item[\$sum_key];\n";*/				
				$group_cycle_content.=$group_cycle_center."=\$temp_item;\n".$group_cycle_center."['_counts']++;\n";
				
				if( (time()-$file_updatetimes)>$upc )	file_put_contents($groups_cycle_path,$groups_cycle_content."\n?>");
				if( (time()-$file_updatetimes)>$upc )	file_put_contents($group_cycle_path,$group_cycle_content."\n?>");
			//	GROUP 文件写入完成
			if( !empty($sums) && !empty($group) ){
				$key_sums = count($this_array[0]);
				$sumss = explode(",",$sums.",".($key_sums-1));
				//echo "快键:".$key_sums;
				for($i=0;$i<count($this_array);$i++){
					$temp_item = $this_array[$i];
					for($iii=0;$iii<count($sumss);$iii++){
						$sum_key = $sumss[$iii];
						include($groups_cycle_path);
						/*
						if( $Sum_Group[$group_key][$temp_item[$group_key]] ) $Sum_Group[$group_key][$temp_item[$group_key]][$sum_key]+=$temp_item[$sum_key];
						else $Sum_Group[$group_key][$temp_item[$group_key]]= $temp_item;
						$Sum_Group[$group_key][$temp_item[$group_key]][13][$sum_key].=$i.":".$temp_item[$sum_key]."+";*/
					}					
				}
				//	print_r($Sum_Group);
			}elseif( empty($sums) ){
				$group = explode(",",$group);
				for($i=0;$i<count($this_array);$i++){
					$temp_item = $this_array[$i];
					include($group_cycle_path);
					/*
					for($ii=0;$ii<count($group);$ii++){
						$group_temp = $group[$ii];
						$Sum_Group[$group_temp][$temp_item[$group_temp]]= $temp_item;
					}*/
				}
				//	检查缓存是否可用
			}
			if( is_array($Sum_Group) ){
				if( !empty($sums) ){
					/*
					function class_test_sums(&$item1, $key, $key_sums){
						foreach($item1[$key_sums] as $sk=>$sv)	$item1[$sk] = $sv;
					}*/
					//array_walk($Sum_Group,'class_test_sums',$key_sums);
					array_walk($Sum_Group,array($this,'itest_sums'),$key_sums);
					//	echo "共计:".count($Sum_Group)."条记录!";
				}				
				$X_Sum_Group = $Sum_Group;
				unset($Sum_Group);
				/*
				$X_Sum_Group = array();
				$X_Group_I = 'x';
				$X_Group_S = count($group);
				//	取出较长的数组
				foreach($Sum_Group as $SGV){
					if( !is_array($SGV."_".$X_Group_I) )	$X_Sum_Group[$GVV[0]]=$GVV;
					else{
						
					}
				}
				
				//for($ii=0;$ii<count($group);$ii++){}*/
			}
			else	$X_Sum_Group = $this_array;
				//echo "写入缓存".$Sum_Group_Memory."gs".$groups_cycle_path;
			if( $memory=='true' )	file_put_contents($Sum_Group_Memory,serialize($X_Sum_Group),LOCK_EX);
		}else{
			//echo "<!-- have memory -->";
				//echo "使用了缓存".$Sum_Group_Memory;
			$X_Sum_Group = unserialize(file_get_contents($Sum_Group_Memory));
		}
// 		print_r($X_Sum_Group);exit();
		unset($Sum_Group,$SGV);
		return $X_Sum_Group;
		//unset($Sum_Group,$SGV,$X_Sum_Group);
	}
		//	2.2解析文件	
	public function Str_To_Array($file_path,$splita='',$splitb='',$one="del",$key='ok'){
		if( !file_exists($file_path) ){
			echo "数据文件不存在<!-- ".$file_path." -->";	
			exit;
		}else{
			$string = file_get_contents($file_path);
			//echo "<!-- FILE:".$file_path.";	 -->";	
		}		
		
		$string_array = array();
		if( !empty($string) ){
			if( !empty($splita) && !empty($splitb)){
				$string_arr = explode($splita,$string);
				
				if( $string_arr[count($string_arr)-1]=="" ) array_pop($string_arr);
				//	ARRAY'S LENGTH IN ARRAY IS ONE ITEM
				
				$bug_num = count(explode($splitb,$string_arr[0]));
				//	echo "初始化bug_num的值:".$bug_num.";\n";
				for($i=0;$i<count($string_arr);$i++){
					$sv = $string_arr[$i];
					$svv = explode($splitb,$sv);
					if( empty($sv) || $bug_num>count($svv) )	continue;//{echo $i.":COUNT:".count($svv)."=BUG:".$bug_num."-\n";}
					$svv = ($key=='ok')?$i.$splitb.$sv.$splitb."1":$sv;
					//echo $sv.$key;
					$string_array[$i]=explode($splitb,$svv);
					$string_array_copy[$i]=$sv;
				}
// 				print_r($string_array);exit();
				//echo "-".count($string_array)."-";
				unset($string_arr);
			}
			elseif( empty($splitb) )	$string_array = explode($splita,$string);
			else	$string_array = $string;
		}

		//	change file
		if( is_array($this->File_Change) ){
			$xid = $this->File_Change['id'];
			$setinfo = $this->File_Change['data'];
			
			if( !empty($splita) && !empty($splitb) && is_array($setinfo) && count($setinfo)>0 ){
				if( $string_array_copy[$xid] )	$temp_string_arr = explode($splitb,$string_array_copy[$_GET['xid']]);
				foreach($setinfo as $k=>$v){
					if( intval($k)>0 ){
						$temp_string_arr[$k-1] = $v;
						$string_array_copy[$_GET['xid']] = implode($splitb,$temp_string_arr);
					}
				}
				$array_string = implode($splita,$string_array_copy).$splita;
				unset($string_array);
				for($i=0;$i<count($string_array_copy);$i++){
					$sv = $string_array_copy[$i];
					$svv = ($key=='ok')?$i.$splitb.$sv.$splitb."1":$sv;
					$string_array[$i]=explode($splitb,$svv);
				}
			}elseif( !empty($splita) && empty($setinfo) && is_string($setinfo) ){
				$string_array_copy[$xid]= $setinfo;
				$array_string = implode($splita,$string_array_copy);
			}else{
				continue;
			}
			//print_r($array_string);
			file_put_contents($file_path,$array_string,LOCK_EX);
			unset($string_array_copy,$array_string);
		}/*
		if( $_GET['xid'] && is_numeric($_GET['xid']) && $string_array[$_GET['xid']] ){
			parse_str($_SERVER['QUERY_STRING']);
			//	从GET获取数据到数组
			if( !empty($splita) && !empty($splitb) && count($setinfo)>0 ){
				if( $string_array_copy[$_GET['xid']] )	$temp_string_arr = explode($splitb,$string_array_copy[$_GET['xid']]);
				foreach($setinfo as $k=>$v){
					if( intval($k)>0 ){
						$temp_string_arr[$k-1] = $v;
						$string_array_copy[$_GET['xid']] = implode($splitb,$temp_string_arr);
					}
				}
				$array_string = implode($splita,$string_array_copy).$splita;
				unset($string_array);
				for($i=0;$i<count($string_array_copy);$i++){
					$sv = $string_array_copy[$i];
					$svv = ($key=='ok')?$i.$splitb.$sv.$splitb."1":$sv;
					$string_array[$i]=explode($splitb,$svv);
				}
			}elseif( !empty($splita) && empty($setinfo) ){
				$string_array_copy[$_GET['xid']]= $setinfo;
				$array_string = implode($splita,$string_array_copy);
			}else{
				continue;
			}
			//print_r($array_string);
			if( isset($setinfo) )	file_put_contents($file_path,$array_string,LOCK_EX);
			unset($string_array_copy,$array_string);
		}*/
		
		if( $one!="save" )	array_shift($string_array);
// 		print_r($string_array);exit();
		return $string_array;
	}
	
}
?>