<?php
class Usersmodel extends CI_Model{
	function __construct(){
		parent::__construct();	
	}	
	
	/**
	 * 配置参数
	 */
	function save_config(){	
		return array('main'=>array(
			'table_name'=>'users',
			'primary_key'=>'id',
		));
	}
	function setConfigRules1(){
		$config = array(
				array(
						'label'=>'旧密码',
						'field'=>'main[old_password]',
						'rules'=>'required|callback_old_password_check2',
				),
				array(
						'label'=>'新密码',
						'field'=>'main[new_password]',
						'rules'=>'required',
				),
				array(
						'label'=>'确认密码',
						'field'=>'main[confirm_password]',
						'rules'=>'required|callback_confirm_password_check',
				),
		);
		return $config;
	}
	/**
	 * 验证器
	 */
	function setConfigRules(){
		return  array(
			array(
				"label"=>"姓名",
				"field"=>"main[member_name]",
				"rules"=>"required",
			),
			array(
				"label"=>"性别",
				"field"=>"main[sex]",
				"rules"=>"required",
			),
		
			array(
				"label"=>"手机",
				"field"=>"main[mobile]",
				"rules"=>"max_length[50]",
			),
		
			array(
				"label"=>"电话",
				"field"=>"main[phone]",
				"rules"=>"max_length[50]",
			),
		
			array(
				"label"=>"qq",
				"field"=>"main[qq]",
				"rules"=>"max_length[50]",
			),
		
			array(
				"label"=>"地址",
				"field"=>"main[mobile]",
				"rules"=>"max_length[50]",
			),
		
			array(
				"label"=>"备注",
				"field"=>"main[remarks]",
				"rules"=>"max_length[250]",
			),
		
		
		);	
		
	}
	
	/**
	 * 会员明细
	 */
	function users_detail($main_id){
		$db_temp =  $this->db->select('*',false)->from('users')->where('id',$main_id)->get()->result_array();
		return $db_temp[0];
	} 
	/**
	 * 修改密码用
	 */
	function users_detail2(){
		$db_temp =  $this->db->select('id,us_name',false)->from('users')->where('us_mail',$this->session->userdata('user_name'))->get()->result_array();
		return $db_temp[0];
	}
	/**
	 * 验证email
	 */
	function email($name){
		$db_temp =  $this->db->select('*',false)->from('users')->where('us_mail',$name)->get()->result_array();
		return $db_temp[0];
	}
	/**
	 * 验证用户名
	 */
	function name($name){
		$db_temp =  $this->db->select('*',false)->from('users')->where('us_name',$name)->get()->result_array();
		return $db_temp[0];
	}
	
	/**
	 * 市场专员
	 */
	function market_name(){
		$db_temp =  $this->db->select('us_name',false)->from('users')->where('us_type','market')->get()->result_array();
// 		print_r($db_temp);exit();
		return $db_temp;
	}
}

?>