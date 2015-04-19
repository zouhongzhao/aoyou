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
 		$this->load->library('encrypt');
 	}
 	
 	/**
 	 * 会员添加
 	 */
 	function users_add(){
 		$main_id = $this->uri->segment(3);
 		if($main_id){
 			$main  = $this->Usersmodel->users_detail($main_id);
 			$data = array("main"=>$main, 'sex_select'=>array(1=>$main['us_sex']==1?true:false,2=>$main['us_sex']==2?true:false),
 					'province'=>$this->Areasmodel->getProvince(),
 					'city'=>$this->Areasmodel->getCity(),
 					);
 			$this->mypage->loadview("users/users_edit",$data);
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
				 	
				 	 'sex_select'=>array(1=>false,2=>true),
 					'province'=>$this->Areasmodel->getProvince(),
 					'city'=>$this->Areasmodel->getCity(),
//  					'types'=>array(
// 								'channels'=>'直属渠道会员',													
// 					  			),
//  					'lock'=>array(
// 								'0'=>'正常',
// 								'1'=>'锁定',														
// 					  			),
 			); 	 		
 			$this->mypage->loadview("users/users_add",$data);
 		}
 		
 		
 	}
 	
 	/**
 	 * 保存会员
 	 */
 	function users_save(){ 	
 		try{
 			$main_id = $this->uri->segment(3);
 			//print_r($main_id);exit();
 			$main = $this->input->post('main');
 			
 			$data = array('main'=>$main, 
// 				'sex_select'=>array("1"=>$main['sex']==1?true:false,"2"=>$main['sex']==2?true:false),	
// 					'rtime'=>date(), 
 					); 
//  			print_r($data);exit();
 			if(!empty($main['us_pass']))
			$data['main']['us_pass']=md5($main['us_pass']);
			$data['main']['rtime']=date("y-m-d h:m:s");
			//print_r($data);exit();
// 			echo $data['main']['rtime'];exit();
// 			$this->form_validation->set_rules($this->Usersmodel->setConfigRules());
//  			$this->form_validation->set_rules('main[password]', 'Password', 'md5');
			if($main_id){
 			$this->form_validation->set_rules('main[us_mail]', '邮箱', 'trim');
			}
			else{
				$this->form_validation->set_rules('main[us_name]', '渠道名', 'trim|callback_username_check');
				$this->form_validation->set_rules('main[us_mail]', '邮箱', 'trim|callback_email_check');
			}
 			if($this->form_validation->run()==true){
 				$this->mydb->save($data,$this->Usersmodel->save_config());
 				redirect('users/channels_list');
 			}else{ 				
 				$this->mypage->loadview("users/users_add");
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
 	 * 渠道会员列表
 	 */
 	function channels_list(){
 		$this->db->select('*,if(us_sex=1,\'男\',\'女\') as sex_str',false);
 		$this->db->from('users');
 		$this->db->where('us_type','channels');
 		$this->db->where('under','1');
 		$data = $this->mydb->getList();
 		$this->mypage->loadview('users/channels_list',$data);	
 	}
 	/**
 	 * 用户会员列表
 	 */
 	function member_list(){
 		$this->db->select('*,if(sex=1,\'男\',\'女\') as sex_str',false);
 		$this->db->from('users');
 		$this->db->where('type','member');
 		$data = $this->mydb->getList();
 		$this->mypage->loadview('users/member_list',$data);
 	}
 	
 	/**
 	 * 删除会员
 	 */
 	function users_delete(){
 		try{
 			$this->mydb->delete($this->uri->segment(3),$this->Usersmodel->save_config());
 			redirect("users/channels_list");
 		}catch(Exception $e){
 			show_error($e->getMessage());
 		}	
 		
 	}
 	
 }
?>
