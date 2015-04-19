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
//  		$this->load->model('Areasmodel');
 	}
 	
 	
 	/**
 	 * 用户首页
 	 */
 	function index(){
 		$data = $this->Usersmodel->users_detail();
//  		 		print_r($data);exit();
 		$this->mypage->loadview('users/index',$data);
 	}
 	
 
 	/**
 	 * 保存会员
 	 */
 	function users_save(){ 	
 		try{
 			$main = $this->input->post('main');
 				$data = array('main'=>$main,); 
 			$this->form_validation->set_rules('main[us_mail]', '邮箱', 'trim|callback_email_check');
 			if($this->form_validation->run()==true){
 				$this->mydb->save($data,$this->Usersmodel->save_config());
 				echo '<script>alert("提交成功！"); location.replace("/index.php/users/userinfo");</script>';
//  				$this->mypage->jsRedirect("提交成功",site_url("users/userinfo"));
 			}else{ 				
 				$this->mypage->loadview("users/edit",$data);
 			}
 			 			
 		}catch(Exception $e){
 			show_error($e->getMessage());
 		}	
 		
 	}
 	/**
 	 * 保存渠道会员
 	 */
 	function channels_save(){
 		try{
 			$main = $this->input->post('main');
 			$data = array('main'=>$main,);
 			$this->form_validation->set_rules('main[us_mail]', '邮箱', 'trim|callback_email_check');
 			if($this->form_validation->run()==true){
 				$this->mydb->save($data,$this->Usersmodel->save_config());
 				echo '<script>alert("提交成功！"); location.replace("/index.php/users/muserinfo");</script>';
 				//  				$this->mypage->jsRedirect("提交成功",site_url("users/userinfo"));
 			}else{
 				$this->mypage->loadview("users/edit",$data);
 			}
 	
 		}catch(Exception $e){
 			show_error($e->getMessage());
 		}
 			
 	}
 	function email_check($str)
 	{
 		$email=$this->Usersmodel->users_detail2();
 		if($str==$email['us_mail']){
 			return TRUE;
 		}else{
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
 	}
 	
 	
 	/**
 	 * 用户信息
 	 */
 	function userinfo(){
//  		print_r($site_info);exit();
 		$data = array(
 				'main'=>$this->Usersmodel->users_detail(),
 				'jt'=>$this->Usersmodel->User_jinbi(),
 				'zt'=>$this->Usersmodel->User_yesterday_jinbi(),
 				'ysy'=>$this->Usersmodel->sum_expenditure(),
 				);
//  		$jinbi = array(
// 'jt' => 'My Title',
// 'zt' => 'My Heading'
// );

 		
//  		$jt = array('main'=>$this->Usersmodel->User_jinbi());
//  		$zt = array('main'=>$this->Usersmodel->User_yesterday_jinbi());
//  		print_r($data);exit();
 		$this->mypage->loadview('minclude_top',$data);
 		$this->mypage->loadview('minclude_left');
 		$this->mypage->loadview('users/edit');
 	}
 
 	/**
 	 * 渠道用户信息
 	 */
 	function muserinfo(){
 		$data = array('main'=>$this->Usersmodel->users_detail());
 		//  		print_r($data);exit();
 		$this->mypage->loadview('users/medit',$data);
 	}
 	
 }
?>
