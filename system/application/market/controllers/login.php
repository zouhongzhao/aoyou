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
		  		
		  		if($this->session->userdata('m_type')=='1')
		  		$this->mypage->loadview("center");
		  		elseif($this->session->userdata('m_type')=='2')
// 		  		echo $this->session->userdata('m_name');
		  		$this->mypage->loadview("center2");
		  		
		
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

// 		$query = $this->db->query("select * from users as u left join admins as a where (a.admin_type='2' and a.admin_user='$str') or (u.type='market' and u.email='$str')");
// 		$db_temp =$query->result_array();
// 		print_r($db_temp);exit();
		$condition="us_mail ='$str' AND us_type='market'";
		$db_temp = $this->db->select('count(1) as user_flag',false)->from('users')->where($condition)->get()->result_array();
		$user_flag = $db_temp[0]['user_flag'];		
		if ($user_flag==0)
		{
			$condition2="admin_user ='$str' AND admin_type='2'";
			$db_temp2 = $this->db->select('count(1) as user_flag',false)->from('admins')->where($condition2)->get()->result_array();
			if($db_temp2[0]['user_flag']==0)
			{
			$this->form_validation->set_message('user_name_check', ' %s 输入错误');
			return FALSE;
			}
			else
			
				return TRUE;
			}
		else
			return TRUE;
	}
 
 
	//验证密码
	function user_pass_check($str)
	{
		$db_temp = $this->db->select('us_name,us_pass',false)->from('users')->where('us_mail',$this->input->post('user_name'))->get()->result_array();
		
		$admin_pass = $db_temp[0]['us_pass'];
		$mname = $db_temp[0]['us_name'];
// 		if(empty($admin_pass)) {
// 			$this->form_validation->set_message('user_pass_check','');
// 			return false;
// 		}
		
		$str1 = md5($str);	
		if ($str1 != $admin_pass)
		{
			$db_temp2 = $this->db->select('admin_pass',false)->from('admins')->where('admin_user',$this->input->post('user_name'))->get()->result_array();
			$admin_pass2 = $db_temp2[0]['admin_pass'];
			if ($str1 != $admin_pass2){
			$this->form_validation->set_message('user_pass_check',' %s 输入错误');
			return FALSE;
			}
			else 
			{
				$this->session->set_userdata('m_type', '1');
				return TRUE;
			}
				
		}
		else
		{
			$this->session->set_userdata('m_name',$mname);
			$this->session->set_userdata('m_type', '2');
			return TRUE;
		}
	}
 
 
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */