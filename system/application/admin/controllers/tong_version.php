<?php
/*
 * Created on 2010-4-11
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 class Tong_version extends CI_Controller{
 	function __construct(){
 		parent::__construct();
 		$this->myauth->execute_auth();	//验证是否登陆
 		$this->load->model('Usersmodel');
 		$this->load->model('Tong_remarkmodel');
 	}
 	
 	/**
 	 * 每天数据统计
 	 */
 	function day(){
$data = null;
 		$version=$this->input->post('version');
 		$insert_date=$this->input->post('insert_date');
 		if($this->uri->segment(3)=='2')
 		{
 			$this->session->unset_userdata('version');
 			$this->session->unset_userdata('insert_date');
 		}
 		if(!empty($version))
 		{
 			$this->session->set_userdata('version',$version);
 			if($this->session->userdata('version')!=$version) $this->session->unset_userdata('version');
 		}
 		if(!empty($insert_date))
 		{
 			$this->session->set_userdata('insert_date',$insert_date);
 			if($this->session->userdata('insert_date')!=$insert_date) $this->session->unset_userdata('insert_date');
 		}
 		if($this->session->userdata('version')) $this->db->like('version',$this->session->userdata('version'));
 		if($this->session->userdata('insert_date')) $this->db->where('dates',$this->session->userdata('insert_date'));
		//$channels_id = $this->db->select("id,us_name")->from('users')->where('us_type','channels')->where('under','1')->get()->result_array();
 		//print_r($channels_id);exit();
 		//foreach($channels_id as $k=>$v){
 			//$xu_sql = "select `c_id`,`dates`,sum(`activation`) as activations,sum(`mac_num`) as mac_nums,sum(`ip_num`) as ip_nums,sum(`install_num`) as install_nums,sum(`starts_num`) as starts_nums,sum(`shouyis`) as shouyiss from tong_day where `c_id`='$channels_id' group by `dates`";
 		//	$channels_day[] = $this->db->select("c_id,dates,sum(`activation`) as activations,sum(`mac_num`) as mac_nums,sum(`ip_num`) as ip_nums,sum(`install_num`) as install_nums,sum(`starts_num`) as starts_nums,sum(`shouyis`) as shouyiss")->from('tong_day')->where('c_id',$v[id])->group_by('dates')->get()->result_array();	
 			
 		//}
 		$this->db->select('*',false);
 		$this->db->from("tong_day_version");
 		$this->db->order_by('dates','desc');
 		$data = $this->mydb->getList();
 		$this->mypage->loadview('tong_version/day',$data);
 
 		//$data=$this->db->query($sql)->result_array();
 		
 		//$this->mypage->loadview('tong_market/day',$data);
 	}
 	
 	
 
 }
?>
