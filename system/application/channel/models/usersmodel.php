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
	 * 修改密码用
	 */
	function users_detail2(){
		$db_temp =  $this->db->select('id,us_name,us_mail',false)->from('users')->where('us_mail',$this->session->userdata('user_name'))->get()->result_array();
		return $db_temp[0];
	}
	/**
	 * 用户资料用
	 */
	function users_detail(){
		$db_temp =  $this->db->select('*',false)->from('users')->where('us_mail',$this->session->userdata('user_name'))->get()->result_array();
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
	//用户所有金币
	function User_jinbi(){
		$name=$this->session->userdata('u_name');
		$access_jinbi_sql = $this->db->select('sum(`activation`) as acs',false)->from('tong_day')->where('u_id',$name)->group_by('u_id')->get()->result_array();
// 		print_r($abc);exit();
		$access_jinbi = intval($access_jinbi_sql[0]['acs']);
		return $access_jinbi*100;
	}
	//用户昨天获取的金币
	function User_yesterday_jinbi(){
		$name=$this->session->userdata('u_name');
		$today = date("Y-m-d");
		$yesterday = date("Y-m-d",time()-3600*24);	//yesterday
		$access_jinbi_sql = $this->db->select('activation',false)->from('tong_day')->where('u_id',$name)->group_by('u_id')->get()->result_array();
// 		print_r($access_jinbi_sql);exit();
		$access_jinbi = intval($access_jinbi_sql[0]['activation']);
		return $access_jinbi*100;
	}
	
	//		用户已经消费金币
	function sum_expenditure(){
		$name=$this->session->userdata('u_name');
		$access_jinbi_sql = $this->db->select('sum(`expenditure`) as exp',false)->from('award_user')->where('user_id',$name)->group_by('itime')->get()->result_array();
		$access_jinbi = intval($access_jinbi_sql[0]['exp']);
		return $access_jinbi;
	}
	//		用户兑换中的金币
	function dhz_jinbi(){
		$name=$this->session->userdata('u_name');
		$access_jinbi_sql = $this->db->select('count(*) as count',false)->from('award_user')->where('user_id',$name)->where('status','0')->get()->result_array();
		$access_jinbi = intval($access_jinbi_sql[0]['count']);
		return $access_jinbi;
	}
}

?>