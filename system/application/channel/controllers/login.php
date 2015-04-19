<?php

class Login extends CI_Controller {

	function __construct()
	{
		parent::__construct();	
		
		
	}
	
	function index()
	{
		$this->load->helper('form');			
		$this->mypage->loadview("welcome,login,publisher");
		
		
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
		  		if($this->session->userdata('c_type')=='1')
		  			$this->mypage->loadview("center");
		  		elseif($this->session->userdata('c_type')=='2')
// 		  		$this->mypage->loadview("center2");
		  		redirect('users/userinfo');
// 		  		$this->mypage->loadview("welcome,login,publisher");
		  		
		
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
		$db_temp = $this->db->select('count(1) as user_flag',false)->from('users')->where('us_mail',$str)->get()->result_array();
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
		$db_temp = $this->db->select('us_pass,us_type,id,us_name',false)->from('users')->where('us_mail',$this->input->post('user_name'))->get()->result_array();
	
		$admin_pass = $db_temp[0]['us_pass'];
		$cid = $db_temp[0]['id'];
		$uname = $db_temp[0]['us_name'];
		if(empty($admin_pass)) {
			$this->form_validation->set_message('user_pass_check','密码不能为空');
			return false;
		}
		$str1 = md5($str);
		if ($str1 != $admin_pass)
		{
			$this->form_validation->set_message('user_pass_check',' %s 输入错误');
			return FALSE;
		}
		else
		{
			if($db_temp[0]['us_type']=="channels")
			{
			$this->session->set_userdata('c_id',$cid);
			$this->session->set_userdata('c_type', '1');
			}
			elseif($db_temp[0]['us_type']=="member")
			{
			$this->session->set_userdata('u_name',$uname);
			$this->session->set_userdata('c_type', '2');
			}
			return TRUE;
		}
	}
 
 
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */