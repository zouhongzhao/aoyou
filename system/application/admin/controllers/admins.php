<?php
/*
 * Created on 2012-4-6
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 class Admins extends CI_Controller{
 	function __construct(){
 		parent::__construct();
 		$this->myauth->execute_auth();	//验证是否登陆
 		$this->load->model('Adminsmodel'); 	
 	}
 	
 	/**
 	 * 管理员添加
 	 */
 	function admins_add(){
 		$main_id = $this->uri->segment(3);
 		if($main_id){
 			$main  = $this->Adminsmodel->admins_detail($main_id);
//  			print_r($main);exit();
 			$data = array("main"=>$main, 
 						  "id"=>$main_id,
 					);
//  			print_r($data);exit();
 		}else{
 			$data = array('main'=>array(
								'admin_user'=>'',
								'admin_pass'=>'',								
								'admin_email'=>'',
								'admin_tel'=>'',
								'admin_contact'=>'', 		
								'admin_sex'=>'', 
 								'admin_remark'=>'',
								'admin_id'=>'', 
					  			
				 		),
				 	
				 	 'sex_select'=>array(1=>false,2=>true),
 					'admin_type'=>array(1=>false,2=>true),
 			); 	 			
 		}
 		
 		$this->mypage->loadview("admins/admins_add",$data);
 	}
 	
 	/**
 	 * 保存管理员
 	 */
 	function admins_save(){ 	
 		try{
//  			print_r($_POST);exit();
 			$main_id = $this->uri->segment(3);
 			$main = $this->input->post('main');
 			$data = array('main'=>$main, 
				'sex_select'=>array("1"=>$main['sex']==1?true:false,"2"=>$main['sex']==2?true:false),	
//  				'admin_type'=>array("1"=>$main['admin_type']==1?true:false,"2"=>$main['admin_type']==2?true:false),
 				); 
 			if(!empty($main['admin_pass']))
 			$data['main']['admin_pass']=md5($main['admin_pass']);
 			$data['main']['admin_ctime']=mktime();
// 			$this->form_validation->set_rules($this->Adminsmodel->setConfigRules());
 			if($main_id){
 				$this->form_validation->set_rules('main[us_mail]', '邮箱', 'trim');
 			}
 			else{
 			$this->form_validation->set_rules('main[admin_user]', '渠道名', 'trim|callback_username_check');
 			$this->form_validation->set_rules('main[admin_email]', '邮箱', 'trim|callback_email_check');
 			}
 			if($this->form_validation->run()==true){
 				$this->mydb->save($data,$this->Adminsmodel->save_config());
 				redirect('admins/admins_list');
 			}else{ 				
 				$this->mypage->loadview("admins/admins_add",$data);
 			}
 			 			
 		}catch(Exception $e){
 			show_error($e->getMessage());
 		}	
 		
 	}
 	
 	
 	function username_check($str)
 	{
 		if($this->Adminsmodel->name($str))
 		{
 			$this->form_validation->set_message('username_check', '该用户名已存在');
 			return FALSE;
 		}
 		else
 		{
 			return TRUE;
 		}
 	}
 	function email_check($str)
 	{
 		if($this->Adminsmodel->email($str))
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
 	 * 管理员列表
 	 */
 	function admins_list(){
 		$this->db->select('*',false);
 		$this->db->from('admins');
 		$data = $this->mydb->getList();
 		$this->mypage->loadview('admins/admins_list',$data);	
//  		$this->output->enable_profiler(TRUE);
 			
 	}
 	
 	
 	/**
 	 * 删除管理员
 	 */
 	function admins_delete(){
 		try{
 			$this->mydb->delete($this->uri->segment(3),$this->Adminsmodel->save_config());
 			redirect("admins/admins_list");
 		}catch(Exception $e){
 			show_error($e->getMessage());
 		}	
 		
 	}
 	
 }
?>
