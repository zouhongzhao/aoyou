<?php
/*
 * Created on 2012-5-14
 *
 *系统管理文档
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
class System_manage extends CI_Controller{
	function __construct(){		
		parent::__construct();
		$this->myauth->execute_auth();	//验证是否登陆
		$this->load->model('Adminsmodel');
		
// 		$this->load->library('encrypt');	
	}
	
	
	/**
	 * 修改密码
	 */
	function change_password(){
		$data = array('main'=>$this->Adminsmodel->admins_detail(1));
		$this->mypage->loadview('admins/change_password',$data);
	}
	
	
	/**
	 *退出系统
	 */
	function exit_system(){		
		$this->session->sess_destroy();
		$this->myauth->process_out(array("user_name"=>""));		
	}
	
	
	/**
	 * 修改密码
	 */
	function save_pass(){		
// 		print_r($_POST);exit();
		$rules = $this->Adminsmodel->setConfigRules1();
		$this->form_validation->set_rules($rules);
		$data = array('main'=>$this->input->post('main'));
		if($this->form_validation->run()==false){			
			$this->mypage->loadview('admins/change_password',$data);
		}else{
			$save_data = array('main'=>array(
				'admin_pass'=>md5($data['main']['new_password']),
				'admin_id'=>$data['main']['admin_id'],
			));			
			$this->mydb->save($save_data,$this->Adminsmodel->save_config());
			$this->mypage->redirectWithInfo('system_manage/exit_system','修改成功，需要重新登陆系统');
		}
	}
	
	
	/**
 	 *检查密码是否一致 
 	 */
 	function confirm_password_check($str){
 		$main  = $this->input->post('main');
 		if($main['confirm_password']!=$main['new_password']){
 			$this->form_validation->set_message("confirm_password_check","两次输入的密码不一致！");
 			return false;
 		}else{
 			return true;
 		}
 	}
 	
 	
 	/**
 	 *检查旧密码输入是否正确 
 	 */
 	function old_password_check($str){
 		$main_form  = $this->input->post('main');
 		$main_db = $this->Adminsmodel->admins_detail1($main_form['admin_id']);
 		
 		$db_pass = $main_db['admin_pass'];
 		$old_password=md5($main_form['old_password']);
//  		print_r($db_pass);exit();
 		if($db_pass != $old_password){
 			$this->form_validation->set_message("old_password_check","旧密码输入不正确!");
 			return false;
 		}else{
 			return true;
 		}
 	}
 	
 	
 	/**
 	 * 备份数据库
 	 */
 	function db_backup(){
 		try{
 			$this->load->dbutil();
 			$backup = $this->dbutil->backup();
 			$this->load->helper('file');
 			$file_name = 'ci_app_db'.date("Y-m-d-H-i-s").'.gz';
//  			echo BASEPATH.'../backup/'.$file_name;exit();
			write_file(BASEPATH.'backup/'.$file_name, $backup); 	
			//发往email
			$this->load->library('email');
			$this->email->from('zouhongzhao@126.com');		
			$this->email->to('zouhongzhao@gmail.com,zouhongzhao@126.com');		
			$this->email->subject("数据备份".$file_name);
			$this->email->message("数据备份".$file_name);
			$this->email->attach(BASEPATH.'backup/'.$file_name);
			$this->email->send();			
			$this->email->clear();
			$this->mypage->jsRedirect("备份成功，已将文件发往邮箱",site_url("tong_all/day"));
			//直接下载
 			//$this->load->helper('download');
			//force_download($file_name, $backup); 
 		}catch(Exception $e){
 			show_error($e->getMessage());
 		}	
 		
 	}	
 	
 	/**
 	 * 软件更新
 	 */
 	function soft_update(){
 		try{
 			$version_update_info = "site_data/version.inc.txt";
//  			echo $version_update_info;exit();
 			if( is_file($version_update_info) ){
 				
//  				echo 222;
 				$data['list'] = explode("\n",file_get_contents($version_update_info));
//  				print_r($data);exit();
 			}else{
//  				echo 33;
//  				$message = "更新配置文件不存在,请填写版本内容!";
 				echo "<script>alert('更新配置文件不存在,请填写版本内容!');location='soft_update';</script>";
 			}
 			$this->mypage->loadview("soft_update/add",$data);
 			//直接下载
 			//$this->load->helper('download');
 			//force_download($file_name, $backup);
 		}catch(Exception $e){
 			show_error($e->getMessage());
 		}
 			
 	}
 	
 	
 	
 	/**
 	 * 保存上传的文件
 	 */
 	function file_save(){
 		$version_update_info = "site_data/version.inc.txt";
 	if(!empty($_POST)){	
//  		print_r($_POST);exit();
		//		获取最新上传的文件
		if( strstr($_POST['drives1'],",") )	$_POST['drives1'] = substr(strstr($_POST['drives1'],","),1); 
		if( strstr($_POST['file_logic1'],",") )	$_POST['file_logic1'] = substr(strstr($_POST['file_logic1'],","),1); 
		if( strstr($_POST['file_other1'],",") )	$_POST['file_other1'] = substr(strstr($_POST['file_other1'],","),1); 

		$contents = trim($_POST['version'])."\n".trim($_POST['channels'])."\n".$_POST['drives1']."\n".$_POST['file_logic1']."\n".$_POST['file_other1'];
// 		$person = "John Smith\n";
// Write the contents to the file, 
// using the FILE_APPEND flag to append the content to the end of the file
// and the LOCK_EX flag to prevent anyone else writing to the file at the same time
// file_put_contents($version_update_info, $person, FILE_APPEND | LOCK_EX);
// 		$file = fopen($version_update_info,"w");
// 		fwrite($file,$contents);
		file_put_contents($version_update_info,$contents,LOCK_EX);
		header("Content-type:text/html;charset=UTF-8");
		echo "<script>alert('设置成功');location='soft_update';</script>";
		exit;
	}
 	}
 	
 	
 	/*驱动文件上传*/
 	function do_upload()
 	{
//  		$config['upload_path'] = 'public/softupload/';
 	$error = "";
	$msg = "";
	if(!empty($_POST['drives'])){
		$file_element_name = 'drives';
	}
 	if(!empty($_POST['file_logic'])){
		$file_element_name = 'file_logic';
	}
	if(!empty($_POST['file_other'])){
		$file_element_name = 'file_other';
	}
	
// 	if (empty($_POST['drives']))
//    {
//       $status = "error";
//       $msg = "Please enter a title";
//    }
 
   if ($status != "error")
   {
      $config['upload_path'] = 'public/softupload/';
      $config['allowed_types'] = 'dll|sys|ini|exe';
      $config['max_size']  = 1024 * 8;
//       $config['encrypt_name'] = TRUE;
 
      $this->load->library('upload', $config);
 
      if (!$this->upload->do_upload($file_element_name))
      {
         $status = 'error';
         $msg = $this->upload->display_errors('', '');
      }
      else
      {
         $data = $this->upload->data();
//          $file_id = $this->files_model->insert_file($data['file_name'], $_POST['title']);
//          if($file_id)
//          {
            $status = "success";
            $msg = "文件上传成功";
            $data = base_url()."public/softupload/".$data['file_name'];
//          }
//          else
//          {
//             unlink($data['full_path']);
//             $status = "error";
//             $msg = "Something went wrong when saving the file, please try again.";
//          }
      }
      @unlink($_FILES[$file_element_name]);
   }
   echo json_encode(array('status' => $status, 'msg' => $msg,'data'=>$data));
 	}
 	
 	
 	/**
 	 * 软件更新密码验证
 	 */
 	function soft_passwd(){
 		$main_id = $this->uri->segment(3);
 		if($main_id){
 			$this->load->library('form_validation');
 			$this->form_validation->set_rules('update_pw', '密码', 'required|callback_update_pw_check');
 			if ($this->form_validation->run() == FALSE)
 			{
 				$this->mypage->loadview("soft_update/login");
 			}
 			else
 			{
			redirect('system_manage/soft_update');
 			}
 		}else{
 			$this->mypage->loadview('soft_update/login');
 		}
 	}

 	
 	//验证密码
 	function update_pw_check($str)
 	{
 		$db_temp = $this->db->select('update_pw',false)->from('admins')->where('admin_user',$this->session->userdata('user_name'))->get()->result_array();
 		$admin_pass = $db_temp[0]['update_pw'];
 	
 		if(empty($admin_pass)) {
 			$this->form_validation->set_message('update_pw_check','');
 			return false;
 		}
 		$de_str = md5($str);
 		if ($admin_pass != $de_str)
 		{
 			$this->form_validation->set_message('update_pw_check',' %s 输入错误');
 			return FALSE;
 		}
 		else
 		{
 			return TRUE;
 		}
 	}
}
 
?>
