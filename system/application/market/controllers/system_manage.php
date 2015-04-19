<?php
/*
 * Created on 2010-4-15
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
class System_manage extends CI_Controller{
	function __construct(){		
		parent::__construct();
		$this->myauth->execute_auth();	//验证是否登陆
		$this->load->model('Adminsmodel');
		$this->load->model('Usersmodel');
// 		$this->load->library('encrypt');	
	}
	
	/**
	 * 修改密码
	 */
	function change_password(){
		if($this->session->userdata('m_type')=='1'){
// 		echo $this->session->userdata('user_name');
		$data = array('main'=>$this->Adminsmodel->admins_detail2());
// 		print_r($data);exit();
		$this->mypage->loadview('admins/change_password',$data);
		}elseif($this->session->userdata('m_type')=='2'){
			$data = array('main'=>$this->Usersmodel->users_detail2());
// 			print_r($data);exit();
			$this->mypage->loadview('users/change_password',$data);
		}
	}
	
	/**
	 *退出系统
	 */
	function exit_system(){		
		$this->session->sess_destroy();
		$this->myauth->process_out(array("user_name"=>""));		
	}
	
	
	/**
	 * 修改市场管理员密码
	 */
	function save_pass(){		
// 		print_r($_POST);exit();
		$rules = $this->Adminsmodel->setConfigRules1();
		$this->form_validation->set_rules($rules);
		$data = array('main'=>$this->input->post('main'));
		if($this->form_validation->run()==false){			
			$this->mypage->loadview('admins/change_password',$data);
		}else{
			$save_data = array('main'=>array(
				'admin_pass'=>md5($data['main']['new_password']),
				'admin_id'=>$data['main']['admin_id'],
			));			
			$this->mydb->save($save_data,$this->Adminsmodel->save_config());
			$this->mypage->redirectWithInfo('system_manage/exit_system','修改成功，需要重新登陆系统');
		}
	}
	

	/**
	 * 修改市场专员密码
	 */
	function save_pass2(){
// 				print_r($_POST);exit();
		$rules = $this->Usersmodel->setConfigRules1();
		$this->form_validation->set_rules($rules);
		$data = array('main'=>$this->input->post('main'));
		if($this->form_validation->run()==false){
			$this->mypage->loadview('Users/change_password',$data);
		}else{
			$save_data = array('main'=>array(
					'us_pass'=>md5($data['main']['new_password']),
					'id'=>$data['main']['id'],
			));
			$this->mydb->save($save_data,$this->Usersmodel->save_config());
			$this->mypage->redirectWithInfo('system_manage/exit_system','修改成功，需要重新登陆系统');
		}
	}
	/**
 	 *检查密码是否一致 
 	 */
 	function confirm_password_check($str){
 		$main  = $this->input->post('main');
 		if($main['confirm_password']!=$main['new_password']){
 			$this->form_validation->set_message("confirm_password_check","两次输入的密码不一致！");
 			return false;
 		}else{
 			return true;
 		}
 	}
 	
 	/**
 	 *检查旧密码输入是否正确 
 	 */
 	function old_password_check($str){
 		$main_form  = $this->input->post('main');
 		$main_db = $this->Adminsmodel->admins_detail($main_form['admin_id']);
 		
 		$db_pass = $main_db['admin_pass'];
 		$old_password=md5($main_form['old_password']);
//  		print_r($db_pass);exit();
 		if($db_pass != $old_password){
 			$this->form_validation->set_message("old_password_check","旧密码输入不正确!");
 			return false;
 		}else{
 			return true;
 		}
 	}
 	
 	function old_password_check2($str){
 		$main_form  = $this->input->post('main');
 		$main_db = $this->Usersmodel->users_detail($main_form['id']);
 			
 		$db_pass = $main_db['us_pass'];
 		$old_password=md5($main_form['old_password']);
 		//  		print_r($db_pass);exit();
 		if($db_pass != $old_password){
 			$this->form_validation->set_message("old_password_check","旧密码输入不正确!");
 			return false;
 		}else{
 			return true;
 		}
 	}
 	
 	
 	

	
}
 
?>
