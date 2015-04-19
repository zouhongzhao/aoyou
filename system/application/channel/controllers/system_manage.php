<?php
/*
 * Created on 2012-5-3
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
class System_manage extends CI_Controller{
	function __construct(){		
		parent::__construct();
		$this->myauth->execute_auth();	//验证是否登陆
		$this->load->model('Usersmodel');
// 		$this->load->library('encrypt');	
	}
	
	/**
	 * 修改密码
	 */
	function change_password(){
			$data = array('main'=>$this->Usersmodel->users_detail2());
// 			print_r($data);exit();
			$this->mypage->loadview('users/change_password',$data);
	}
	
	/**
	 *退出系统
	 */
	function exit_system(){		
		$this->session->sess_destroy();
		$this->myauth->process_out(array("user_name"=>"","u_name"=>"","c_type"=>"","c_id"=>""));	
		
	}
	
	

	/**
	 * 修改密码
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
