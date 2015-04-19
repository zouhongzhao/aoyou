<?php
class Adminsmodel extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	/**
	 * 管理员明细
	 */
	function admins_detail1($admin_id){
		$db_temp  = $this->db->select('*')->from('admins')->where('admin_id',1)->get()->result_array();
		return $db_temp[0];
	}
	function admins_detail($admin_id){
		$db_temp  = $this->db->select('*')->from('admins')->where('admin_id',$admin_id)->get()->result_array();
		return $db_temp[0];
	}
	/**
	 * 配置验证规则
	 */
	function setConfigRules1(){
		$config = array(
			array(
				'label'=>'旧密码',
				'field'=>'main[old_password]',
				'rules'=>'required|callback_old_password_check',
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
						"field"=>"main[admin_user]",
						"rules"=>"required",
				),
				array(
						"label"=>"密码",
						"field"=>"main[admin_pass]",
						"rules"=>"required",
				),
	
				array(
						"label"=>"电话",
						"field"=>"main[admin_tel]",
						"rules"=>"max_length[50]",
				),
	
				array(
						"label"=>"联系人",
						"field"=>"main[admin_contact]",
						"rules"=>"required",
				),
	
				array(
						"label"=>"备注",
						"field"=>"main[admin_remark]",
						"rules"=>"max_length[250]",
				),
	
	
		);
	
	}
	
	/**
	 * 保存管理员参数
	 */
	 function save_config(){
	 	return array(
	 		'main'=>array(
	 			'table_name'=>'admins',
	 			'primary_key'=>'admin_id',	 			
	 		),
	 	);
	 }
	
	 function email($name){
	 	$db_temp =  $this->db->select('*',false)->from('admins')->where('admin_email',$name)->get()->result_array();
	 	return $db_temp[0];
	 }
	 function name($name){
	 	$db_temp =  $this->db->select('*',false)->from('admins')->where('admin_user',$name)->get()->result_array();
	 	return $db_temp[0];
	 }
	
}
?>