<?php
/*
 * Created on 2010-4-22
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 class Myauth{
 	function __construct(){
		$this->ci = &get_instance();
 	}
 	
 	/**
 	 * 验证是否登陆
 	 */
 	function execute_auth(){
 		$uesr_name = $this->ci->session->userdata('user_name');
 		if(empty($uesr_name)){
 			redirect(".");
 		}
 	}	
 	
 	/**
 	 * 处理登陆
 	 */
 	function process_in($session_data){
 		$this->ci->session->set_userdata($session_data);
 	} 	
 	
 	/**
 	 * 处理登出
 	 */
 	function process_out($session_data){ 		
 		$this->ci->session->unset_userdata($session_data);
 		redirect(".");
 	}
 	
 	
 }
?>
