<?php
class Common extends CI_Controller{
	
	function __construct(){
		parent::__construct();
		$this->myauth->execute_auth();	//验证是否登陆
	}
	
	/**
 	 * ajax取产品信息
 	 */
 	function ajax_product(){  	
 		$product_id = $this->uri->segment(3);	 	
 		if(empty($product_id)||$product_id==0) return false;
 		$cache_product = $this->mydb->getCache('product'); 		 
 		echo json_encode($cache_product[$product_id]);
 	}
 	
}
?>