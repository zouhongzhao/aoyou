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
	
	/**
	 * 验证器
	 */
	function setConfigRules(){
		return  array(
			array(
				"label"=>"姓名",
				"field"=>"main[name]",
				"rules"=>"required|callback_username_check",
			),
			array(
               'field'   => 'main[password]', 
               'label'   => '密码', 
               'rules'   => 'trim|required|md5',
                  ), 
            array(
               'field'   => 'main[email]', 
               'label'   => 'Email', 
               'rules'   => 'trim|required|valid_email',
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
				"label"=>"创建时间",
		    	"field"=>"main[rtime]",
				"rules"=>"date",
				),
			array(
				"label"=>"地址",
				"field"=>"main[mobile]",
				"rules"=>"max_length[50]",
			)
		
		
		);	
		
	}
	
	/**
	 * 会员明细
	 */
	function users_detail($main_id){
		$db_temp =  $this->db->select('*',false)->from('users')->where('id',$main_id)->get()->result_array();
		return $db_temp[0];
	} 
	
	function email($name){
		$db_temp =  $this->db->select('*',false)->from('users')->where('us_mail',$name)->get()->result_array();
		return $db_temp[0];
	}
	function name($name){
		$db_temp =  $this->db->select('*',false)->from('users')->where('us_name',$name)->get()->result_array();
		return $db_temp[0];
	}
	//获取市场专员id
	function getmarket(){
		$db_temp =  $this->db->select('id,us_name',false)->from('users')->where('us_type','market')->get()->result_array();
		return $db_temp;
	}

}

?>