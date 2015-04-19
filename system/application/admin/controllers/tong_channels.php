<?php
/*
 * Created on 2012-5-14
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 class Tong_channels extends CI_Controller{
 	function __construct(){
 		parent::__construct();
 		$this->myauth->execute_auth();	//验证是否登陆
 		$this->load->model('Usersmodel');
 		$this->load->model('Tong_daymodel');
 	}
 	
 	/**
 	 * 每天数据统计
 	 */
 	function day(){
 		$data = null;
 		$channel_name=$this->input->post('channel_name');
 		$insert_date=$this->input->post('insert_date');
 		if($this->uri->segment(3)=='2')
 		{
 			$this->session->unset_userdata('channel_name');
 			$this->session->unset_userdata('insert_date');
 		}
 		if(!empty($channel_name))
 		{
 			$this->session->set_userdata('channel_name',$channel_name);
 			if($this->session->userdata('channel_name')!=$channel_name) $this->session->unset_userdata('channel_name');
 		}
 		if(!empty($insert_date))
 		{
 			$this->session->set_userdata('insert_date',$insert_date);
 			if($this->session->userdata('insert_date')!=$insert_date) $this->session->unset_userdata('insert_date');
 		}
 		if($this->session->userdata('channel_name')) $this->db->like('u.us_name',$this->session->userdata('channel_name'));
 		if($this->session->userdata('insert_date')) $this->db->where('t.dates',$this->session->userdata('insert_date'));
		//$channels_id = $this->db->select("id,us_name")->from('users')->where('us_type','channels')->where('under','1')->get()->result_array();
 		//print_r($channels_id);exit();
 		//foreach($channels_id as $k=>$v){
 			//$xu_sql = "select `c_id`,`dates`,sum(`activation`) as activations,sum(`mac_num`) as mac_nums,sum(`ip_num`) as ip_nums,sum(`install_num`) as install_nums,sum(`starts_num`) as starts_nums,sum(`shouyis`) as shouyiss from tong_day where `c_id`='$channels_id' group by `dates`";
 		//	$channels_day[] = $this->db->select("c_id,dates,sum(`activation`) as activations,sum(`mac_num`) as mac_nums,sum(`ip_num`) as ip_nums,sum(`install_num`) as install_nums,sum(`starts_num`) as starts_nums,sum(`shouyis`) as shouyiss")->from('tong_day')->where('c_id',$v[id])->group_by('dates')->get()->result_array();	
 			
 		//}
 		$this->db->select('t.id,t.c_id,u.us_name,t.dates,sum(t.activation) as activations,sum(t.mac_num) as mac_nums,sum(t.ip_num) as ip_nums,sum(t.install_num) as install_nums,sum(t.starts_num) as starts_nums,sum(t.shouyis) as shouyiss',false);
 		$this->db->from("tong_day as t");
 		$this->db->join("users as u","u.id=t.c_id","inner");
 		$this->db->where("u.us_type",'channels');
 		$this->db->where("u.under",'1');
 		$this->db->group_by('t.dates,t.c_id');
 		$this->db->order_by('t.dates','desc');
 		$data = $this->mydb->getList();
 		//print_r($data);exit();
 		$this->mypage->loadview('tong_channels/day',$data);
 	}
 	
 	/**
 	 * 每月数据统计
 	 */
 	function month(){ 	
 		$data = null;
 		$channel_name=$this->input->post('channel_name');
 		$insert_date=$this->input->post('insert_date');
 		if($this->uri->segment(3)=='2')
 		{
 			$this->session->unset_userdata('channel_name');
 			$this->session->unset_userdata('insert_date');
 		}
 		if(!empty($channel_name))
 		{
 			$this->session->set_userdata('channel_name',$channel_name);
 			if($this->session->userdata('channel_name')!=$channel_name) $this->session->unset_userdata('channel_name');
 		}
 		if(!empty($insert_date))
 		{
 			$this->session->set_userdata('insert_date',$insert_date);
 			if($this->session->userdata('insert_date')!=$insert_date) $this->session->unset_userdata('insert_date');
 		}
 		if($this->session->userdata('insert_date')) $this->db->where('concat(year(t.dates),\'-\',month(t.dates))',$this->session->userdata('insert_date'));
 		if($this->session->userdata('channel_name')) $this->db->like('u.us_name',$this->session->userdata('channel_name'));
 		$this->db->select('t.c_id,u.us_name,concat(year(t.dates),\'-\',month(t.dates)) as dates,sum(t.activation) as activations,sum(t.mac_num) as mac_nums,sum(t.ip_num) as ip_nums,sum(t.install_num) as install_nums,sum(t.starts_num) as starts_nums,sum(t.shouyis) as shouyiss',false);
 		$this->db->from("tong_day as t");
 		$this->db->join("users as u","u.id=t.c_id","inner");
 		$this->db->where("u.us_type",'channels');
 		$this->db->where("u.under",'1');
 		$this->db->group_by('concat(year(t.dates),\'-\',month(t.dates)),t.c_id');
 		$this->db->order_by('concat(year(t.dates),\'-\',month(t.dates))','desc');
 		$data = $this->mydb->getList();
 		//print_r($data);exit();
 		$this->mypage->loadview('tong_channels/month',$data);
 }
 
 /**
  * 历史数据统计
  */
 function history(){
 	$data = null;
 		$channel_name=$this->input->post('channel_name');
 		$insert_date=$this->input->post('insert_date');
 		if($this->uri->segment(3)=='2')
 		{
 			$this->session->unset_userdata('channel_name');
 			$this->session->unset_userdata('insert_date');
 		}
 		if(!empty($channel_name))
 		{
 			$this->session->set_userdata('channel_name',$channel_name);
 			if($this->session->userdata('channel_name')!=$channel_name) $this->session->unset_userdata('channel_name');
 		}
 		if(!empty($insert_date))
 		{
 			$this->session->set_userdata('insert_date',$insert_date);
 			if($this->session->userdata('insert_date')!=$insert_date) $this->session->unset_userdata('insert_date');
 		}
 		if($this->session->userdata('insert_date')) $this->db->where('t.dates',$this->session->userdata('insert_date'));
 			
 		if($this->session->userdata('channel_name')) $this->db->like('u.us_name',$this->session->userdata('channel_name'));
		//$channels_id = $this->db->select("id,us_name")->from('users')->where('us_type','channels')->where('under','1')->get()->result_array();
 		//print_r($channels_id);exit();
 		//foreach($channels_id as $k=>$v){
 			//$xu_sql = "select `c_id`,`dates`,sum(`activation`) as activations,sum(`mac_num`) as mac_nums,sum(`ip_num`) as ip_nums,sum(`install_num`) as install_nums,sum(`starts_num`) as starts_nums,sum(`shouyis`) as shouyiss from tong_day where `c_id`='$channels_id' group by `dates`";
 		//	$channels_day[] = $this->db->select("c_id,dates,sum(`activation`) as activations,sum(`mac_num`) as mac_nums,sum(`ip_num`) as ip_nums,sum(`install_num`) as install_nums,sum(`starts_num`) as starts_nums,sum(`shouyis`) as shouyiss")->from('tong_day')->where('c_id',$v[id])->group_by('dates')->get()->result_array();	
 			
 		//}
 		$this->db->select('t.id,t.c_id,u.us_name,t.dates,t.activation as activations,t.mac_num as mac_nums,t.ip_num as ip_nums,t.install_num as install_nums,t.starts_num as starts_nums,t.shouyis as shouyiss',false);
 		$this->db->from("tong_day as t");
 		$this->db->join("users as u","u.id=t.c_id","inner");
 		$this->db->where("u.us_type",'channels');
 		$this->db->where("u.under",'1');
 		$this->db->order_by('t.dates','desc');
 		$data = $this->mydb->getList();
 	//print_r($data);exit();
 	$this->mypage->loadview('tong_channels/history',$data);
 }
 
 /**
  * 渠道修改
  */
 function channels_edit(){
 	$main_id = $this->uri->segment(3);
 	if($main_id){
 		$main  = $this->Tong_daymodel->channels_detail($main_id);
 		$data = array("main"=>$main);
 	}else{
 		$data = array('main'=>array(
 				'member_name'=>'',
 				'mobile'=>'',
 				'qq'=>'',
 				'phone'=>'',
 				'address'=>'',
 				'remarks'=>'',
 				'member_id'=>'',
 					
 
 		),
 		);
 	}
 		
 	$this->mypage->loadview("tong_channels/edit",$data);
 }
 
 /**
  * 保存渠道
  */
 function channels_save(){
 	try{
 
 		$main = $this->input->post('main');
 		$data = array('main'=>$main,
 		// 				'sex_select'=>array("1"=>$main['sex']==1?true:false,"2"=>$main['sex']==2?true:false),
 		// 					'rtime'=>date(),
 		);
 		$this->form_validation->set_rules('main[u_id]', '经销商', 'trim');
 		$this->form_validation->set_rules('main[dates]', '日期', 'trim');
 
 		if($this->form_validation->run()==true){
 			$this->mydb->save($data,$this->Tong_daymodel->save_config());
 			redirect('tong_channels/day');
 		}else{
 			$this->mypage->loadview("tong_channels/edit");
 		}
 
 	}catch(Exception $e){
 		show_error($e->getMessage());
 	}
 		
 }
 
 /**
  * 删除渠道
  */
 function channels_delete(){
 	try{
 		$this->mydb->delete($this->uri->segment(3),$this->Tong_daymodel->save_config());
 		redirect("tong_channels/day");
 	}catch(Exception $e){
 		show_error($e->getMessage());
 	}
 		
 }
 }
?>
