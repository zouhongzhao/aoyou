<?php
/*
 * Created on 2012-4-6
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 class Users extends CI_Controller{
 	function __construct(){
 		parent::__construct();
 		$this->myauth->execute_auth();	//验证是否登陆
 		$this->load->model('Usersmodel');
 		$this->load->model('Areasmodel');
 	}
 	
 	/**
 	 * 会员编辑
 	 */
 	function users_edit(){
 		$main_id = $this->uri->segment(3);
 		if($main_id){
 			$m_id = $this->uri->segment(4);
 			$main  = $this->Usersmodel->users_detail($main_id);
//  			print_r($main);exit();
 		$data = array("main"=>$main, 'sex_select'=>array(1=>$main['us_sex']==1?true:false,2=>$main['us_sex']==2?true:false),
 					'province'=>$this->Areasmodel->getProvince(),
 					'city'=>$this->Areasmodel->getCity(),
 					'market'=>$this->Usersmodel->market_name(),
 					'm_id'=>$m_id,
 					);
 		}else{
 			$data = array('main'=>array(
								'us_name'=>'',
					  			
				 		),
 					'province'=>$this->Areasmodel->getProvince(),
 					'city'=>$this->Areasmodel->getCity(),
 					'market'=>$this->Usersmodel->market_name(),
 			); 	 			
 		}
 		
 		$this->mypage->loadview("users/users_edit",$data);
 	}
 	
 	
 	
 	/**
 	 * 保存
 	 */
 	function users_save(){
 		try{
 			$main_id = $this->uri->segment(3);
 			$main = $this->input->post('main');
 			$data = array('main'=>$main,);
 			if(!empty($main['us_pass']))
 			$data['main']['us_pass']=md5($main['us_pass']);
 	
 			$data['main']['rtime']=date("y-m-d h:m:s");
 			if($main_id){
 				$this->form_validation->set_rules('main[us_mail]', '邮箱', 'trim');
 			}
 			else{
 			$this->form_validation->set_rules('main[us_name]', '渠道名', 'trim|callback_username_check');
 			$this->form_validation->set_rules('main[us_mail]', '邮箱', 'trim|callback_email_check');
 			}
 			if($this->form_validation->run()==true){
 				$this->mydb->save($data,$this->Usersmodel->save_config());
 				switch ($main_id){
 					case m:
 						$this->mypage->jsRedirect("提交成功",site_url("users/markets_list"));
//  						redirect('users/markets_list');
 						break;
 					case c:
 						$this->mypage->jsRedirect("提交成功",site_url("users/channels_list"));
//  						redirect('users/channels_list');
 						break;
 					case u:
 						$this->mypage->jsRedirect("提交成功",site_url("users/member_list"));
//  						redirect('users/member_list');
 						break;
 					default:
 						$this->mypage->jsRedirect("提交成功",site_url("users/markets_list"));
//  						redirect('users/markets_list');
 						break;
 				}
 				
 			}else{
 				if(!$main_id)
 				$this->mypage->loadview("users/markets_add",$data);
 			}
 	
 		}catch(Exception $e){
 			show_error($e->getMessage());
 		}
 			
 	}
 	
 	/**
 	 * 添加市场专员
 	 */
 	function market_add(){
 			$data = array("main"=>$main, 'sex_select'=>array(1=>$main['sex']==1?true:false,2=>$main['sex']==2?true:false),
 					'province'=>$this->Areasmodel->getProvince(),
 					'city'=>$this->Areasmodel->getCity(),
 			);
 		//  		print_r($data);exit();
 		$this->mypage->loadview("users/market_add",$data);
 	}
 	/**
 	 * 市场管理员添加渠道会员
 	 */
 	function mchannels_add(){
 		$main_id = $this->uri->segment(3);
 		if($main_id){
 			$main  = $this->Usersmodel->users_detail($main_id);
 			$data = array("main"=>$main, 'sex_select'=>array(1=>$main['sex']==1?true:false,2=>$main['sex']==2?true:false),
 					'province'=>$this->Areasmodel->getProvince(),
 					'city'=>$this->Areasmodel->getCity(),
 					'us_name'=>$this->Usersmodel->users_detail2(),
 					'market'=>$this->Usersmodel->market_name(),
 					'mid'=>$main_id,
 					);
 		}else{
 			$data = array('main'=>array(
 					'us_name'=>'',
 	
 			),
 	
 					'sex_select'=>array(1=>false,2=>true),
 					'province'=>$this->Areasmodel->getProvince(),
 					'city'=>$this->Areasmodel->getCity(),
 					'us_name'=>$this->Usersmodel->users_detail2(),
 					'market'=>$this->Usersmodel->market_name(),
 			);
 		}
//  		print_r($data);exit();
 		$this->mypage->loadview("users/mchannels_add",$data);
 	}
 	
 	/**
 	 * 保存渠道会员
 	 */
 	function channels_save(){ 	
 		try{
 			$main_id = $this->uri->segment(3);
 			$main = $this->input->post('main');
 				$data = array('main'=>$main,); 
 				
			if(!empty($main['us_pass']))
			$data['main']['us_pass']=md5($main['us_pass']);
			$data['main']['rtime']=date("y-m-d h:m:s");
			if($main_id){
				$this->form_validation->set_rules('main[us_mail]', '邮箱', 'trim');
			}
			else{
 			$this->form_validation->set_rules('main[us_name]', '渠道名', 'trim|callback_username_check');
 			$this->form_validation->set_rules('main[us_mail]', '邮箱', 'trim|callback_email_check');
			}
 			if($this->form_validation->run()==true){
 				$this->mydb->save($data,$this->Usersmodel->save_config());
 				$this->mypage->jsRedirect("提交成功",site_url("users/channels_list"));
//  				redirect('users/channels_list');
 			}else{ 				
 				$this->mypage->loadview("users/mchannels_add",$data);
 			}
 			 			
 		}catch(Exception $e){
 			show_error($e->getMessage());
 		}	
 		
 	}
 	
 	function username_check($str)
 	{
 		if($this->Usersmodel->name($str))
 		{
 			$this->form_validation->set_message('username_check', '该渠道名已存在');
 			return FALSE;
 		}
 		else
 		{
 			return TRUE;
 		}
 	}
 	function email_check($str)
 	{
 		if($this->Usersmodel->email($str))
 		{
 			$this->form_validation->set_message('email_check', '该邮箱已存在');
 			return FALSE;
 		}
 		else
 		{
 			return TRUE;
 		}
 	}
 	
 	
 	/**
 	 * 市场专员列表
 	 */
 	function markets_list(){
 		$this->db->select('*',false);
 		$this->db->from('users');
 		$this->db->where('us_type','market');
 		$data = $this->mydb->getList();
//  		$this->output->cache(2);
 		$this->mypage->loadview('users/markets_list',$data);
 		
 	}
 	/**
 	 * 渠道会员列表
 	 */
 	function channels_list(){
 		$this->db->select('*,if(us_sex=1,\'男\',\'女\') as sex_str',false);
 		$this->db->from('users');
 		$this->db->where('us_type','channels');
 		$this->db->where('under','0');
 		$data = $this->mydb->getList();
 		$this->mypage->loadview('users/channels_list',$data);	
 	}
 	
 	
 	/**
 	 * 市场专员下的渠道会员列表
 	 */
 	function mchannels_list(){
 		$market=$this->Usersmodel->users_detail2();
 		$this->db->select('*',false);
 		$this->db->from('users');
 		$this->db->where('us_type','channels');
 		$this->db->where('under','0');
 		$this->db->where('belongs_market',$market['us_name']);
 		$data = $this->mydb->getList();
//  		print_r($market);exit();
 		$this->mypage->loadview('users/mchannels_list',$data);
 	}
 	/**
 	 * 用户会员列表
 	 */
 	function member_list(){
 		$this->db->select('*,if(us_sex=1,\'男\',\'女\') as sex_str',false);
 		$this->db->from('users');
 		$this->db->where('us_type','member');
 		$data = $this->mydb->getList();
 		$this->mypage->loadview('users/member_list',$data);
 	}
 	
 	/**
 	 * 删除用户
 	 */
 	function member_delete(){
 		try{
 			$this->mydb->delete($this->uri->segment(3),$this->Usersmodel->save_config());
 			$this->mypage->jsRedirect("删除成功",site_url("users/member_list"));
//  			redirect("users/member_list");
 		}catch(Exception $e){
 			show_error($e->getMessage());
 		}	
 		
 	}
 	/**
 	 * 删除渠道会员
 	 */
 	function channels_delete(){
 		try{
 			$this->mydb->delete($this->uri->segment(3),$this->Usersmodel->save_config());
 			$this->mypage->jsRedirect("删除成功",site_url("users/channels_list"));
//  			redirect("users/channels_list");
 		}catch(Exception $e){
 			show_error($e->getMessage());
 		}
 			
 	}
 	
 	/**
 	 * 市场专员删除其渠道会员
 	 */
 	function mchannels_delete(){
 		try{
 			$this->mydb->delete($this->uri->segment(3),$this->Usersmodel->save_config());
 			$this->mypage->jsRedirect("删除成功",site_url("users/mchannels_list"));
//  			redirect("users/mchannels_list");
 		}catch(Exception $e){
 			show_error($e->getMessage());
 		}
 	
 	}
 	/**
 	 * 删除市场专员
 	 */
 	function markets_delete(){
 		try{
 			$this->mydb->delete($this->uri->segment(3),$this->Usersmodel->save_config());
 			$this->mypage->jsRedirect("删除成功",site_url("users/markets_list"));
//  			redirect("users/markets_list");
 		}catch(Exception $e){
 			show_error($e->getMessage());
 		}
 			
 	}
 	
 	//搜索自动提示框
 	function search_auto(){
 		parse_str($_SERVER['QUERY_STRING'], $_GET);
 		$q = strtolower($_GET["term"]); //获取用户输入的内容 
//  		echo $q;exit();
 		if (!$q) return;
$sql="select * from users where id like '$q%' and us_type='channels' limit 0,10"; 
$result2 = $this->db->query($sql)->result_array();
foreach($result2 as $k=>$v) {
	$result[] = array(
			'id' => $v['id'],
			'name' => $v['us_name'],
			'names' => empty($v['names'])? '' : $v['names'],
			'pro' => empty($v['us_province'])? '' : $v['us_province'],
			'city' => empty($v['us_city'])? '' : $v['us_city']
	);		
// 	$id = $v['id'];
// 	$name = $v['us_name'];
// 	$names = $v['names'];
// 	$pro = $v['us_province'];
// 	$city = $v['us_city'];
// 	echo $v['id']."-".$v['us_name']."-".$v['names']."-".$v['us_province']."-".$v['us_city']."\n";
// 	echo $cname."/n";   
// 	echo  $cname."\n";		
// 	echo json_encode($result);
}
// print_r($result);
// exit();
echo json_encode($result);  //输出JSON数据 
 	}	
 
 }
 
?>
