<?php
/*
 * Created on 2010-4-11
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 class Award extends CI_Controller{
 	function __construct(){
 		parent::__construct();
 		$this->myauth->execute_auth();	//验证是否登陆
 		$this->load->model('Awardmodel');
 		$this->load->model('Usersmodel');
 		$this->load->model('Tong_daymodel');
 		$jinbi = array(
 				'jt'=>$this->Usersmodel->User_jinbi(),
 				'zt'=>$this->Usersmodel->User_yesterday_jinbi(),
 				'ysy'=>$this->Usersmodel->sum_expenditure(),
 		);
 		$this->mypage->loadview('minclude_top');
 		$this->mypage->loadview('minclude_left',$jinbi);
 	}
 	
 	
 	/**
 	 * 金币兑换列表
 	 */
 	function dollar_ch(){
 		$data = null;
 		$this->db->select('*')
 		->from('award') 
 		->order_by('udate');
 		$data  =  $this->mydb->getList(); 	
 		$this->mypage->loadview('award/award_list',$data);
 	}
 	
 	/**
 	 * 金币兑换详情
 	 */
 	function user_award_info(){
 		$aid = $this->uri->segment(3);
 		$data = array(
 				'main'=>$this->Awardmodel->award_detail($aid),
 				'user'=>$this->Usersmodel->users_detail(),
 				'aid'=>$aid,
 		);
 		$this->mypage->loadview('award/award_info',$data);
 	}
 	
 	
 	/**
 	 * 金币花费详情
 	 */
 	function user_award_consumption(){
 		$jt= $this->Usersmodel->User_jinbi();
 		$ysy = $this->Usersmodel->sum_expenditure();
//  		$xu_sql = "select au.id as id,au.award_id as award_id,au.itime as itime,au.status as status,au.expenditure as expenditure,a.award_name as award_name from award_user as au left join award as a on(au.award_id=a.id) where au.user_id=".$_SESSION['sess_uid'];
 		$this->db->select('*',false);
 		$this->db->from("award_user");
 		$this->db->where("user_id",$this->session->userdata('u_name'));
 		$this->db->order_by('itime','desc');
 		$data = $this->mydb->getList();
//  		print_r($data);exit();
 		if($data[count]=='0'){
 		$data2['jt'] = $this->Usersmodel->User_jinbi();
 		$data2['ysy'] = $this->Usersmodel->sum_expenditure();
//  		print_r(22);exit();
 		$this->mypage->loadview('award/award_consumption',$data1);
 		}else
 		{
//  			print_r(33);exit();
 		$data['jt'] = $this->Usersmodel->User_jinbi();
 		$data['ysy'] = $this->Usersmodel->sum_expenditure();
 		$data['dhz'] = $this->Usersmodel->dhz_jinbi();
 		$this->mypage->loadview('award/award_consumption',$data);
 		}
 	}
 	/**
 	 * 我的金币
 	 */
 	function mydollar(){ 	
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
 		if($this->session->userdata('insert_date')) $this->db->like('dates',$this->session->userdata('insert_date'));
 		$this->db->select('id,u_id,dates,sum(activation) as activations,sum(shouyis) as shouyiss',false);
 		$this->db->from("tong_day");
 		$this->db->where("u_id",$this->session->userdata('u_name'));
 		$this->db->group_by('dates,c_id');
 		$this->db->order_by('dates','desc');
 		$data = $this->mydb->getList();
 		//print_r($data);exit();
 		
 		$this->mypage->loadview('award/day',$data);
 	}
 	/**
 	 * 处理兑换申请
 	 */
 	function apply_exp(){
 		try{
//  	         print_r($jinbi);exit();

 	         //		验证金币是否足够兑换
 			$jt=$this->Usersmodel->User_jinbi();
 			$ysy=$this->Usersmodel->sum_expenditure();
//  			echo ($jt-$ysy);exit;
 	         if(($jt-$ysy) < $this->input->post('expenditure')){
 	         	echo '<script>alert("您的金币还不够兑换此奖品！"); history.go(-1)</script>';
//  	         	echo "<script type=\"text/javascript\">alert('您的金币还不够兑换此奖品');history.go(-1)</script>";
 	         	exit;
 	         }
 			$data = array(
 					'award_id' =>$this->input->post('award_id') ,
 					'award_name' =>$this->input->post('award_name') ,
 					'user_id' => $this->input->post('user_id') ,
 					'expenditure' => $this->input->post('expenditure'),
 					'status' => '0' ,
 					'itime' => date("Y-m-d H:i:s"),
//  					'utime' => date("Y-m-d H:i:s"),
 			);
//  			print_r($data);exit();
 			$this->db->insert('award_user', $data);
 			$message_title = $this->input->post('message_title');
 			$message_content = $this->input->post('message_content');
 			$message_content.="\n 附:用户兑换时可用金币为:".($jt-$ysy)."; 奖品所需金币:".$this->input->post('expenditure');
 			$message = "兑奖人:".$message_title."  奖品兑换"."电话:".$this->input->post('message_call')."  地址:".$this->input->post('message_content');
 			echo "<script>alert('申请对换成功!".$message."');location='/index.php/award/user_award_consumption';</script>";
 			//	邮件提醒
 			//发往email
			$this->load->library('email');
			$this->email->from('zouhongzhao@126.com');
// 			$this->email->to($this->session->userdata('user_name'));		
			$this->email->to('529894459@qq.com');
			$this->email->subject("16610奖品兑换".$message_title);
			$this->email->message($message_content);
			$this->email->send();			
			$this->email->clear();
 			
 			exit;
 		}catch(Exception $e){
 			show_error($e->getMessage());
 		}
 			
 	}

 	
 	
 
 }
 
?>
