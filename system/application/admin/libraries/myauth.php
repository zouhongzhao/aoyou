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
 	
 }
?>
