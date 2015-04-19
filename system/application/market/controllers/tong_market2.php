<?php
/*
 * Created on 2010-4-11
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 class Tong_market2 extends CI_Controller{
 	function __construct(){
 		parent::__construct();
 		$this->myauth->execute_auth();	//验证是否登陆
 		$this->load->model('Usersmodel');
 		$this->load->model('Tong_daymodel');
 	}
 	
 	/**
 	 * 每天数据统计
 	 */
 	function day(){
 		$this->mypage->loadview('tong_market2/day');
 	}
 	
 	/**
 	 * 每天数据统计
 	 */
 	function m_day(){
 		   		parse_str($_SERVER['QUERY_STRING'],$_GET);
//  		   		print_r($_GET);
 		   		$examp = $_REQUEST["q"]; //query number
 		   		
 		   		$page = $_REQUEST['page']; // get the requested page
 		   		$limit = $_REQUEST['rows']; // get how many rows we want to have into the grid
 		   		$sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
 		   		$sord = $_REQUEST['sord']; // get the direction
 		   		if(!$sidx) $sidx =1;
 		   		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows']: false;
 		   		if($totalrows) {
 		   			$limit = $totalrows;
 		   		}
 		   		$m_name=$this->session->userdata('m_name');
 		   		// search options
 		   		// IMPORTANT NOTE!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 		   		// this type of constructing is not recommendet
 		   		// it is only for demonstration
 		   		//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 		   		$wh = "";
 		   		$searchOn = $this->Strip($_REQUEST['_search']);
 		   		if($searchOn=='true') {
 		   			$fld = $this->Strip($_REQUEST['searchField']);
 		   			if( $fld=='c_id' || $fld =='dates' || $fld =='belongs_market') {
 		   				$fldata = $this->Strip($_REQUEST['searchString']);
 		   				$foper = $this->Strip($_REQUEST['searchOper']);
 		   				// costruct where
 		   				$wh .= " AND ".$fld;
 		   				switch ($foper) {
 		   					case "bw":
 		   						$fldata .= "%";
 		   						$wh .= " LIKE '".$fldata."'";
 		   						break;
 		   					case "eq":
 		   						if(is_numeric($fldata)) {
 		   							$wh .= " = ".$fldata;
 		   						} else {
 		   							$wh .= " = '".$fldata."'";
 		   						}
 		   						break;
 		   					case "ne":
 		   						if(is_numeric($fldata)) {
 		   							$wh .= " <> ".$fldata;
 		   						} else {
 		   							$wh .= " <> '".$fldata."'";
 		   						}
 		   						break;
 		   					case "lt":
 		   						if(is_numeric($fldata)) {
 		   							$wh .= " < ".$fldata;
 		   						} else {
 		   							$wh .= " < '".$fldata."'";
 		   						}
 		   						break;
 		   					case "le":
 		   						if(is_numeric($fldata)) {
 		   							$wh .= " <= ".$fldata;
 		   						} else {
 		   							$wh .= " <= '".$fldata."'";
 		   						}
 		   						break;
 		   					case "gt":
 		   						if(is_numeric($fldata)) {
 		   							$wh .= " > ".$fldata;
 		   						} else {
 		   							$wh .= " > '".$fldata."'";
 		   						}
 		   						break;
 		   					case "ge":
 		   						if(is_numeric($fldata)) {
 		   							$wh .= " >= ".$fldata;
 		   						} else {
 		   							$wh .= " >= '".$fldata."'";
 		   						}
 		   						break;
 		   					case "ew":
 		   						$wh .= " LIKE '%".$fldata."'";
 		   						break;
 		   					case "ew":
 		   						$wh .= " LIKE '%".$fldata."%'";
 		   						break;
 		   					default :
 		   						$wh = "";
 		   				}
 		   			}
 		   		}
 		   		
 		   	switch ($examp) {
 		   	case 1:
 		   		if(empty($_REQUEST['id']))
 		   		{
 		   		$sql1 = "SELECT t.id FROM tong_day as t left join users as u on u.id=t.c_id WHERE u.us_type='channels' and u.under='0' and u.belongs_market='$m_name'".$wh."GROUP BY t.dates,t.c_id";
 		   		}
 		   		else
 		   		{
 		   		$b=explode("@",$_REQUEST['id']);
 		   		$c_id=$b[1];
 		   		$date=$b[0];
//  		   		echo $date;exit();
//  		   		$result = $this->db->query("SELECT COUNT(*) AS count FROM tong_day as t left join users as u on u.id=t.c_id WHERE u.us_type='channels' and u.under='0'".$wh)->result_array();
 		   		$sql1="SELECT t.id FROM tong_day as t left join users as u on u.id=t.c_id WHERE u.us_type='channels' and u.under='0' and concat(year(t.dates),'-',month(t.dates))='$date' and t.c_id='$b[1]' and u.belongs_market='$m_name'".$wh." GROUP BY t.dates,t.c_id";
 		   		}
 		   		// 				$SQL = "SELECT u.belongs_market,t.id,t.c_id,u.us_name,t.dates,sum(t.activation) as activations,sum(t.mac_num) as mac_nums,sum(t.ip_num) as ip_nums,sum(t.install_num) as install_nums,sum(t.starts_num) as starts_nums,sum(t.shouyis) as shouyiss FROM tong_day as t left join users as u on u.id=t.c_id WHERE u.us_type='channels' and u.under='0'".$wh." GROUP BY t.dates,t.c_id ORDER BY ".$sidx." ".$sord. " LIMIT ".$start." , ".$limit;
// 				$result = $this->db->query($sql1)->result_array();
//  		   		$result = $this->db->count_all("($sql1)as t ");
//  		   		print_r($result);exit();
 		   		$count = $this->db->count_all("($sql1)as t ");
 		   		
 		   		if( $count >0 ) {
 		   			$total_pages = ceil($count/$limit);
 		   		} else {
 		   			$total_pages = 0;
 		   		}
 		   		if ($page > $total_pages) $page=$total_pages;
 		   		$start = $limit*$page - $limit; // do not put $limit*($page - 1)
 		   		if ($start<0) $start = 0;
 		   		if(empty($_REQUEST['id']))
 		   		{
 		   		$SQL = "SELECT u.belongs_market,t.id,t.c_id,u.us_name,t.dates,sum(t.activation) as activations,sum(t.mac_num) as mac_nums,sum(t.ip_num) as ip_nums,sum(t.install_num) as install_nums,sum(t.starts_num) as starts_nums,sum(t.shouyis) as shouyiss FROM tong_day as t left join users as u on u.id=t.c_id WHERE u.us_type='channels' and u.under='0' and u.belongs_market='$m_name'".$wh." GROUP BY t.dates,t.c_id ORDER BY ".$sidx." ".$sord. " LIMIT ".$start." , ".$limit;
 		   		}
 		   		else
 		   		{
 		   			$b=explode("@",$_REQUEST['id']);
 		   			$c_id=$b[1];
 		   			$date=$b[0];
 		   			//  		   		$result = $this->db->query("SELECT COUNT(*) AS count FROM tong_day as t left join users as u on u.id=t.c_id WHERE u.us_type='channels' and u.under='0'".$wh)->result_array();
 		   		$SQL = "SELECT u.belongs_market,t.id,t.c_id,u.us_name,t.dates,sum(t.activation) as activations,sum(t.mac_num) as mac_nums,sum(t.ip_num) as ip_nums,sum(t.install_num) as install_nums,sum(t.starts_num) as starts_nums,sum(t.shouyis) as shouyiss FROM tong_day as t left join users as u on u.id=t.c_id WHERE u.us_type='channels' and u.under='0' and concat(year(t.dates),'-',month(t.dates))='$date' and t.c_id='$b[1]' and u.belongs_market='$m_name'".$wh." GROUP BY t.dates,t.c_id ORDER BY ".$sidx." ".$sord. " LIMIT ".$start." , ".$limit;
 		   		}
 		   		$result2 = $this->db->query( $SQL )->result_array();
//  		   		print_r($result2);exit();
 		   		$responce->page = $page;
 		   		$responce->total = $total_pages;
 		   		$responce->records = $count;
//  		   		$i=0; $amttot=0; $taxtot=0; $total=0;
 		   		foreach($result2 as $k=>$v) {
//  		   			$amttot += $row[amount];
//  		   			$taxtot += $row[tax];
//  		   			$total += $row[total];
 		   			if($v['install_nums']=='0')
 		   				$amount=0;
 		   			else $amount=number_format($v['activations']/$v['install_nums'], 2, '.', '');
 		   			$responce->rows[$k]['id']=$v[dates]."@".$v[c_id];
 		   			$responce->rows[$k]['cell']=array($v[us_name],$v[dates],$v[activations],$v[install_nums],$amount,$v[shouyiss],$v[belongs_market]);
//  		   			$i++;
 		   		}
 		   		echo json_encode($responce);
 		   		break;
 		  case 2:
 		  	// 		$this->db->select('t.c_id,u.us_name,concat(year(t.dates),\'-\',month(t.dates)) as dates,sum(t.activation) as activations,sum(t.mac_num) as mac_nums,sum(t.ip_num) as ip_nums,sum(t.install_num) as install_nums,sum(t.starts_num) as starts_nums,sum(t.shouyis) as shouyiss',false);
 		  	//  		$this->db->from("tong_day as t");
 		  	//  		$this->db->join("users as u","u.id=t.c_id","inner");
 		  	//  		$this->db->where("u.us_type",'channels');
 		  	//  		$this->db->where("u.under",'0');
 		  	//  		if($this->session->userdata('insert_date')) $this->db->where('concat(year(t.dates),\'-\',month(t.dates))',$this->session->userdata('insert_date'));
 		  	//  		if($this->session->userdata('market_ch')) $this->db->where('u.belongs_market',$this->session->userdata('market_ch'));
 		  	//  		$this->db->group_by('concat(year(t.dates),\'-\',month(t.dates)),t.c_id');
 		  	//  		$this->db->order_by('concat(year(t.dates),\'-\',month(t.dates))','desc');
 		  	$sql1 = "SELECT t.id FROM tong_day as t left join users as u on u.id=t.c_id WHERE u.us_type='channels' and u.under='0' and u.belongs_market='$m_name'".$wh."group by concat(year(t.dates),'-',month(t.dates)),t.c_id";
 		  	//  		   		print_r($result);exit();
 		  	$count = $this->db->count_all("($sql1)as t ");
 		  	
 		  	if( $count >0 ) {
 		  		$total_pages = ceil($count/$limit);
 		  	} else {
 		  		$total_pages = 0;
 		  	}
 		  	if ($page > $total_pages) $page=$total_pages;
 		  	$start = $limit*$page - $limit; // do not put $limit*($page - 1)
 		  	if ($start<0) $start = 0;
 		  	$SQL = "SELECT u.belongs_market,t.id,t.c_id,u.us_name,concat(year(t.dates),'-',month(t.dates)) as dates,sum(t.activation) as activations,sum(t.mac_num) as mac_nums,sum(t.ip_num) as ip_nums,sum(t.install_num) as install_nums,sum(t.starts_num) as starts_nums,sum(t.shouyis) as shouyiss FROM tong_day as t left join users as u on u.id=t.c_id WHERE u.us_type='channels' and u.under='0' and u.belongs_market='$m_name'".$wh." GROUP BY concat(year(t.dates),'-',month(t.dates)),t.c_id ORDER BY ".$sidx." ".$sord. " LIMIT ".$start." , ".$limit;
 		  	$result2 = $this->db->query( $SQL )->result_array();
 		  	//  		   		print_r($result2);exit();
 		  	$responce->page = $page;
 		  	$responce->total = $total_pages;
 		  	$responce->records = $count;
 		  	//  		   		$i=0; $amttot=0; $taxtot=0; $total=0;
 		  	foreach($result2 as $k=>$v) {
 		  		//  		   			$amttot += $row[amount];
 		  		//  		   			$taxtot += $row[tax];
 		  		//  		   			$total += $row[total];
 		  		if($v['install_nums']=='0')
 		  			$amount=0;
 		  		else $amount=number_format($v['activations']/$v['install_nums'], 2, '.', '');
 		  		$responce->rows[$k]['id']=$v[dates]."@".$v[c_id];
 		  		$responce->rows[$k]['cell']=array($v[us_name],$v[dates],$v[activations],$v[install_nums],$amount,$v[shouyiss],$v[belongs_market]);
 		  		//  		   			$i++;
 		  	}
 		  	echo json_encode($responce);
 		  	break;
 		   	}
 	}
 	/**
 	 * 每天数据详情统计
 	 */
 	function s_day(){
 		parse_str($_SERVER['QUERY_STRING'],$_GET);
//  		   		print_r($_GET);
 		   		$examp = $_REQUEST["q"]; //query number
 		   		
 		   		$page = $_REQUEST['page']; // get the requested page
 		   		$limit = $_REQUEST['rows']; // get how many rows we want to have into the grid
 		   		$sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
 		   		$sord = $_REQUEST['sord']; // get the direction
 		   		$b=explode("@",$_REQUEST['id']);
 		   		$c_id=$b[1];
 		   		$date=$b[0];
				//$m_name=$this->session->userdata('m_name');
 		   		if(!$sidx) $sidx =1;
 		   		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows']: false;
 		   		if($totalrows) {
 		   			$limit = $totalrows;
 		   		}
 		   		
 		   		// search options
 		   		// IMPORTANT NOTE!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 		   		// this type of constructing is not recommendet
 		   		// it is only for demonstration
 		   		//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 		   		$wh = "";
 		   		$searchOn = $this->Strip($_REQUEST['_search']);
 		   		if($searchOn=='true') {
 		   			$fld = $this->Strip($_REQUEST['searchField']);
 		   			if( $fld=='u_id' ) {
 		   				$fldata = $this->Strip($_REQUEST['searchString']);
 		   				$foper = $this->Strip($_REQUEST['searchOper']);
 		   				// costruct where
 		   				$wh .= " AND ".$fld;
 		   				switch ($foper) {
 		   					case "bw":
 		   						$fldata .= "%";
 		   						$wh .= " LIKE '".$fldata."'";
 		   						break;
 		   					case "eq":
 		   						if(is_numeric($fldata)) {
 		   							$wh .= " = ".$fldata;
 		   						} else {
 		   							$wh .= " = '".$fldata."'";
 		   						}
 		   						break;
 		   					case "ne":
 		   						if(is_numeric($fldata)) {
 		   							$wh .= " <> ".$fldata;
 		   						} else {
 		   							$wh .= " <> '".$fldata."'";
 		   						}
 		   						break;
 		   					case "lt":
 		   						if(is_numeric($fldata)) {
 		   							$wh .= " < ".$fldata;
 		   						} else {
 		   							$wh .= " < '".$fldata."'";
 		   						}
 		   						break;
 		   					case "le":
 		   						if(is_numeric($fldata)) {
 		   							$wh .= " <= ".$fldata;
 		   						} else {
 		   							$wh .= " <= '".$fldata."'";
 		   						}
 		   						break;
 		   					case "gt":
 		   						if(is_numeric($fldata)) {
 		   							$wh .= " > ".$fldata;
 		   						} else {
 		   							$wh .= " > '".$fldata."'";
 		   						}
 		   						break;
 		   					case "ge":
 		   						if(is_numeric($fldata)) {
 		   							$wh .= " >= ".$fldata;
 		   						} else {
 		   							$wh .= " >= '".$fldata."'";
 		   						}
 		   						break;
 		   					case "ew":
 		   						$wh .= " LIKE '%".$fldata."'";
 		   						break;
 		   					case "ew":
 		   						$wh .= " LIKE '%".$fldata."%'";
 		   						break;
 		   					default :
 		   						$wh = "";
 		   				}
 		   			}
 		   		}
//  		   		echo $fld." : ".$wh;
//  		   		exit();
//  		   		$xu_sql = "select * from tong_day where `c_id`='$channels_id' and `dates`='{$_GET['dates']}'";
 		   		$result = $this->db->query("SELECT COUNT(*) AS count FROM tong_day where `c_id`='$b[1]' and `dates`='$b[0]'".$wh)->result_array();
//  		   		print_r($result);exit();
 		   		$count = $result[0]['count'];
 		   		
 		   		if( $count >0 ) {
 		   			$total_pages = ceil($count/$limit);
 		   		} else {
 		   			$total_pages = 0;
 		   		}
 		   		if ($page > $total_pages) $page=$total_pages;
 		   		$start = $limit*$page - $limit; // do not put $limit*($page - 1)
 		   		if ($start<0) $start = 0;
 		   		$SQL = "SELECT * FROM tong_day where `c_id`='$b[1]' and `dates`='$b[0]'".$wh." ORDER BY dates ".$sord. " LIMIT ".$start." , ".$limit;
 		   		$result2 = $this->db->query( $SQL )->result_array();
//  		   		print_r($result);exit();
 		   		$responce->page = $page;
 		   		$responce->total = $total_pages;
 		   		$responce->records = $count;
 		   		$i=0; $amttot=0; $taxtot=0; $total=0;
 		   		foreach($result2 as $k=>$v) {
//  		   			$amttot += $row[amount];
//  		   			$taxtot += $row[tax];
//  		   			$total += $row[total];
 		   			$responce->rows[$k]['id']=$v[id];
 		   			$responce->rows[$k]['cell']=array($v[u_id],$v[dates],$v[activation],$v[install_num],$v[mac_num],$v[shouyis],$v[id]);
//  		   			$i++;
 		   		}

 		   		echo json_encode($responce);
 	}
 	
 	function Strip($value)
 	{
 		if(get_magic_quotes_gpc() != 0)
 		{
 			if(is_array($value))
 				if ( $this->array_is_associative($value) )
 				{
 					foreach( $value as $k=>$v)
 						$tmp_val[$k] = stripslashes($v);
 					$value = $tmp_val;
 				}
 				else
 					for($j = 0; $j < sizeof($value); $j++)
 					$value[$j] = stripslashes($value[$j]);
 					else
 						$value = stripslashes($value);
 		}
 		return $value;
 	}
 	
 	function array_is_associative ($array)
 	{
 	if ( is_array($array) && ! empty($array) )
 	{
 	for ( $iterator = count($array) - 1; $iterator; $iterator-- )
 	{
 	if ( ! array_key_exists($iterator, $array) ) {
 	return true;
 	}
 	}
 	return ! array_key_exists(0, $array);
 	}
 	return false;
 	}
 	/**
 	 * 每月数据统计
 	 */
 	function month(){
 		$this->mypage->loadview('tong_market2/month');
 }
 
 /**
  * 历史数据统计
  */
 function history(){
 	$data = null;
 		$channel_name=$this->input->post('channel_name');
 		$insert_date=$this->input->post('insert_date');
 		if($this->uri->segment(3)=='2')
 		{
 			$this->session->unset_userdata('channel_name');
 			$this->session->unset_userdata('insert_date');
 		}
 		if(!empty($channel_name))
 		{
 			$this->session->set_userdata('channel_name',$channel_name);
 			if($this->session->userdata('channel_name')!=$channel_name) $this->session->unset_userdata('channel_name');
 		}
 		if(!empty($insert_date))
 		{
 			$this->session->set_userdata('insert_date',$insert_date);
 			if($this->session->userdata('insert_date')!=$insert_date) $this->session->unset_userdata('insert_date');
 		}
 		if($this->session->userdata('insert_date')) $this->db->where('t.dates',$this->session->userdata('insert_date'));
 		if($this->session->userdata('channel_name')) $this->db->like('u.us_name',$this->session->userdata('channel_name'));
 		$this->db->select('t.id,t.c_id,u.us_name,t.dates,t.activation as activations,t.mac_num as mac_nums,t.ip_num as ip_nums,t.install_num as install_nums,t.starts_num as starts_nums,t.shouyis as shouyiss',false);
 		$this->db->from("tong_day as t");
 		$this->db->join("users as u","u.id=t.c_id","inner");
 		$this->db->where("u.us_type",'channels');
 		$this->db->where("u.under",'0');
 		$this->db->where("u.belongs_market",$this->session->userdata('m_name'));
 		$this->db->order_by('t.dates','desc');
 		$data = $this->mydb->getList();
 	//print_r($data);exit();
 	$this->mypage->loadview('tong_market/history',$data);
 }
 
 /**
  * 渠道修改
  */
 function market_edit(){
 	$main_id = $this->uri->segment(3);
 	if($main_id){
 		$main  = $this->Tong_daymodel->channels_detail($main_id);
 		$data = array("main"=>$main);
 	}else{
 		$data = array('main'=>array(
 				'member_name'=>'',
 				'mobile'=>'',
 				'qq'=>'',
 				'phone'=>'',
 				'address'=>'',
 				'remarks'=>'',
 				'member_id'=>'',
 
 
 		),
 		);
 	}
 		
 	$this->mypage->loadview("tong_market/edit",$data);
 }
 
 /**
  * 保存渠道
  */
 function market_save(){
 	try{
 		$main = $this->input->post('main');
 		$data = array('main'=>$main,
 				// 				'sex_select'=>array("1"=>$main['sex']==1?true:false,"2"=>$main['sex']==2?true:false),
 				// 					'rtime'=>date(),
 		);
 		$this->form_validation->set_rules('main[u_id]', '经销商', 'trim');
 		$this->form_validation->set_rules('main[dates]', '日期', 'trim');
 		if($this->form_validation->run()==true){
 			$this->mydb->save($data,$this->Tong_daymodel->save_config());
 			redirect('tong_market/day');
 		}else{
 			$this->mypage->loadview("tong_market/edit");
 		}
 
 	}catch(Exception $e){
 		show_error($e->getMessage());
 	}
 		
 }
 /**
  * 保存/删除渠道(post)
  */
 function day_save(){
 	try{
 
 		if($this->input->post("oper")=="edit")
 		{
 		$main=$this->input->post("main");
		$this->db->where('id', $this->input->post("id"));
		$this->db->update('tong_day', $main); 
		echo "ok";
 		}
 		elseif ($this->input->post("oper")=="del")
 		$this->mydb->delete($this->input->post('id'),$this->Tong_daymodel->save_config());
 	}catch(Exception $e){
 		show_error($e->getMessage());
 	}

 }
 /**
  * 删除渠道(post)
  */
 function day_del(){
 	try{
 		$this->mydb->delete($this->uri->segment(3),$this->Tong_daymodel->save_config());
 		redirect("tong_market/day");

 	}catch(Exception $e){
 		show_error($e->getMessage());
 	}
 		
 }
 }
 ?>
