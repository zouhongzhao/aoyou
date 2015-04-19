<?php
/*
 * Created on 2010-4-11
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 class Tong_browse extends CI_Controller{
 	function __construct(){
 		parent::__construct();
 		$this->myauth->execute_auth();	//验证是否登陆
 		$this->load->model('Browsemodel');
 	}
 	
/**
  * 浏览数据统计
  */
 function all(){
 	$data = null;
 		$insert_date=$this->input->post('insert_date');
 		if($this->uri->segment(3)=='2')
 		{
 			$this->session->unset_userdata('insert_date');
 		}
 		if(!empty($insert_date))
 		{
 			$this->session->set_userdata('insert_date',$insert_date);
 			if($this->session->userdata('insert_date')!=$insert_date) $this->session->unset_userdata('insert_date');
 		}
 		if($this->session->userdata('insert_date')) $this->db->where('u_date',$this->session->userdata('insert_date'));
 	$this->db->select('*',false);
 	$this->db->from("tong_browse");
 	$this->db->order_by('u_date');
 	$this->db->order_by('url_number','desc');
 	$data = $this->mydb->getList();
//  	print_r($data);exit();
 	$this->mypage->loadview('tong_browse/all',$data);
 }

 }
 
?>
