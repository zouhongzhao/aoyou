<?php
/*
 * Created on 2010-4-16
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 class Awardmodel extends CI_Model{
 	function __construct(){
 		parent::__construct();
 	}
 	
 	
 	/**
 	 * 设置验证规则
 	 */
 	
 	function setConfigRules($info){ 			
 		return  array(
 			array(
 			'field'=>'main[award_name]',
 			'label'=>'奖品名称',
 			'rules'=>'max_length[200]', 
 		   ) 	   	
 		
 		);
 		
 		
 	}
 	
 	/**
 	 * 存储参数配置
 	 */
 	function saveConfig(){ 		
 	return array(
			'main'=>array(
				'table_name'=>'award',
				'primary_key'=>'id',			
			)
		);
 	}
 	
 	
 	
 	
 	/**
 	 * 重新处理
 	 */
 	function reDefine($detail){ 		
 	 		foreach($detail as $k=>&$v){
 	 			unset($v['product_name'],$v['product_real_name']); 	 			
 	 		}	 	 	
 		return $detail;
 	}
 	
 	function award_detail($id){
 		$this->db->where('id',$id);
 		$this->db->select('*',false);
 		$this->db->from('award');
 		$db_temp = $this->db->get()->result_array();
 		$data = array('main'=>$db_temp[0]);
 		return $data;
 	}
 	function apply_detail($id){
 		$this->db->where('id',$id);
 		$this->db->select('*',false);
 		$this->db->from('award_user');
 		$db_temp = $this->db->get()->result_array();
 		$data = $db_temp[0];
 		return $data;
 	}
 	function name($name){
 		$db_temp =  $this->db->select('*',false)->from('award')->where('award_name',$name)->get()->result_array();
 		return $db_temp[0];
 	}
 }
?>
