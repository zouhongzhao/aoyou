<?php
/*
 * Created on 2010-4-11
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 class Tong_all extends CI_Controller{
 	function __construct(){
 		parent::__construct();
 		$this->myauth->execute_auth();	//验证是否登陆
 		$this->load->model('Tong_daymodel');
 	}
 	

 	/**
 	 * 每天数据统计
 	 */
 	function day(){
//  		echo $this->uri->segment(4);
// echo $this->input->get('per_page',true);
 		
//  		print_r($_GET);exit();
 		//$data = null;
 		if($this->input->get('insert_date'))	$this->db->where('dates',$this->input->get('insert_date'));
//  		$this->db->like('product.product_name',$this->input->get('product_name'));
//  		$this->db->like('product.product_real_name',$this->input->get('product_real_name'));
//  		$xu_sql  = "select sum(`install_num`) as install_nums,sum(`starts_num`) as starts_nums,`dates`,sum(`mac_num`) as mac_nums,sum(`activation`) as activations from tong_day group by `dates`";
 		
 		$this->db->select('sum(`install_num`) as install_nums,sum(`starts_num`) as starts_nums,`dates`,sum(`mac_num`) as mac_nums,sum(`activation`) as activations')
 		->from('tong_day')
 		->group_by('dates');
//  		$data  =  $this->mydb->getList("tong_all/day");
 		$data  =  $this->mydb->getList();
//  		echo "<pre>";
//  		print_r($data);
//  		echo "</pre>";
//  		exit(); 	
 		$this->mypage->loadview('tong_all/day',$data);
 	}
 	
 	/**
 	 * 每月数据统计
 	 */
 	function month(){ 		
	if($this->input->get('insert_date'))	$this->db->where('dates',$this->input->get('insert_date'));
//  		$this->db->like('product.product_name',$this->input->get('product_name'));
//  		$this->db->like('product.product_real_name',$this->input->get('product_real_name'));
//  		$xu_sql  = "select sum(`install_num`) as install_nums,sum(`starts_num`) as starts_nums,`dates`,sum(`mac_num`) as mac_nums,sum(`activation`) as activations from tong_day group by `dates`";
 		
 		$this->db->select('sum(`install_num`) as install_nums,sum(`starts_num`) as starts_nums,
 				DATE_FORMAT(dates,\'%Y-%m\') as df,sum(`mac_num`) as mac_nums,sum(`activation`) as activations',false)
 		->from('tong_day')
 		->group_by('DATE_FORMAT(dates,\'%Y-%m\')')
 		->order_by("DATE_FORMAT(dates,'%Y-%m')","desc");
 		$data = $this->mydb->getList();
 		$this->mypage->loadview('tong_all/month',$data);
 	}
 	/**
 	 * 历史数据统计
 	 */
 	function history(){
if($this->input->get('insert_date'))	$this->db->where('dates',$this->input->get('insert_date'));
//  		$this->db->like('product.product_name',$this->input->get('product_name'));
//  		$this->db->like('product.product_real_name',$this->input->get('product_real_name'));
//  		$xu_sql  = "select sum(`install_num`) as install_nums,sum(`starts_num`) as starts_nums,`dates`,sum(`mac_num`) as mac_nums,sum(`activation`) as activations from tong_day group by `dates`";
 		
 		$this->db->select('install_num as install_nums,starts_num as starts_nums,`dates`,mac_num as mac_nums,activation as activations')
 		->from('tong_day')
 		->order_by('dates');
//  		$data  =  $this->mydb->getList("tong_all/day");
 		$data  =  $this->mydb->getList();
 		$this->mypage->loadview('tong_all/history',$data);
 	}
 }
 
?>
