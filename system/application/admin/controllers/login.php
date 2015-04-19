<?php

class Login extends CI_Controller {

	function __construct()
	{
		parent::__construct();	
		
		
	}
	
	function index()
	{
// 		$start=microtime(true);
		$this->load->helper('form');	
		
		$this->mypage->loadview("welcome,login,publisher");
// 		$elapsed=microtime(true)-$start;
// 		echo "that took $elapsed seconds.\n";
		
	}	
	
	
	function chklogin(){			
		  $this->load->helper(array('form', 'url'));		  
		  $this->load->library('form_validation');
		  $this->load->library('encrypt');		
		  $this->form_validation->set_rules('user_name', '用户名', 'required|callback_user_name_check');
		  $this->form_validation->set_rules('user_pass', '密码', 'required|callback_user_pass_check');
		  
		  
		  if ($this->form_validation->run() == FALSE)
		  {
		 		$this->mypage->loadview("welcome,login,publisher");
		  }
		  else
		  {		 
		  		$this->myauth->process_in(array("user_name"=>$this->input->post("user_name")));
		  		$this->mypage->loadview("center");
		  		
		
		  }
		 
	}
	
	/**
	 * 中心
	 */
	function center(){	
			$this->myauth->execute_auth();	
			$this->mypage->loadview("center");
	}
	
	//验证用户名
	function user_name_check($str)
	{
		$condition="admin_user ='$str' AND admin_type='1'";
		$db_temp = $this->db->select('count(1) as user_flag',false)->from('admins')->where($condition)->get()->result_array();
		$user_flag = $db_temp[0]['user_flag'];		
		if ($user_flag==0)
		{
			$this->form_validation->set_message('user_name_check', ' %s 输入错误');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
 
 
	//验证密码
	function user_pass_check($str)
	{
		$db_temp = $this->db->select('admin_pass',false)->from('admins')->where('admin_user',$this->input->post('user_name'))->get()->result_array();
		$admin_pass = $db_temp[0]['admin_pass'];
		
		if(empty($admin_pass)) {
			$this->form_validation->set_message('user_pass_check','');
			return false;
		}
		$de_str = md5($str);	
		if ($admin_pass != $de_str)
		{
			$this->form_validation->set_message('user_pass_check',' %s 输入错误');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
 
 
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */