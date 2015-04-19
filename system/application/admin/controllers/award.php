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
//  		$this->myauth->execute_auth();	//验证是否登陆
 		$this->load->model('Awardmodel');
 		//加载类库ckeditor
 		$this->load->library('ckeditor');
 		//加载类库ckfinder
 		$this->load->library('ckfinder');
 	}
 	
 	/**
 	 * 添加奖品
 	 */
 	function award_add(){
 		$this->myauth->execute_auth();	//验证是否登陆
 		$data = null;
 		$this->ckeditor = new CKEditor();
 		//配置路径
 		$this->ckeditor->basePath = base_url() . 'public/ckeditor/';
 		$this->ckeditor->returnOutput = true;
 		CKFinder::SetupCKEditor($this->ckeditor,'/public/ckfinder/');
 		
//  		$data = null;
  		$main_id = $this->uri->segment(3);
  		if($main_id>0){
  			$data = $this->Awardmodel->award_detail($main_id);
  			
  			$this->mypage->loadview('award/award_edit',$data);
  		}else{
  			$data = array(
 				'main'=>array('insert_date'=>'','remarks'=>'','main_id'=>''),
  					//'ck'=>$this->ckeditor->editor('text'),
  					);
  			$this->mypage->loadview('award/award_add',$data);
 	 	}	
	 	//print_r($data);exit();
 		
 	}
 	
 	/**
 	 * 保存奖品
 	 */
 	function award_save(){
 		$this->myauth->execute_auth();	//验证是否登陆
 		try{
 			$main_id = $this->uri->segment(3);
	 		$main = $this->input->post('main');	
	 		$form_info = array('main'=>$main);
	 		//若缩略图为空，就Unset
	 		if($form_info['main']['award_thumbnail'] != "")
	 		$form_info['main']['award_thumbnail']=base_url().str_replace("|", "", $form_info['main']['award_thumbnail']);
			else 
				$this->array_remove_value($form_info, $form_info['main']['award_thumbnail']);
// 			print_r($form_info);exit();
	 		$form_info['main']['udate']=date("Y-m-d h:i:s");
	 		if($main_id){
	 			$this->form_validation->set_rules('main[award_name]', '奖品名称', 'trim');
	 		}
	 		else{
	 		$this->form_validation->set_rules('main[award_name]', '奖品名称', 'trim|callback_username_check');
	 		}
	 		if($this->form_validation->run()==false){		 			
	 			$this->mypage->loadview('award/award_add',$form_info);
	 		}else{	 		
	 			$this->mydb->save($form_info,$this->Awardmodel->saveConfig());
// 	 			$this->session->unset_userdata('s_image');
	 			$this->mypage->jsRedirect("提交成功",site_url("award/award_list"));
	 		}
	 			
 		}catch(Exception $e){
 			show_error($e->getMessage());
 		}	
 		
 		
 	}
 	
 	//删除数组中的一个元素
 	function array_remove_value(&$arr, $var){
 		foreach ($arr as $key => $value) {
 			if (is_array($value)) {
 				$this->array_remove_value($arr[$key], $var);
 			} else {
 				$value = trim($value);
 				if ($value == $var) {
 					unset($arr[$key]);
 				} else {
 					$arr[$key] = $value;
 				}
 			}
 		}
 	}
 	function username_check($str)
 	{
 		if($this->Awardmodel->name($str))
 		{
 			$this->form_validation->set_message('username_check', '该名称已存在');
 			return FALSE;
 		}
 		else
 		{
 			return TRUE;
 		}
 	}
 	//上传图片
 	function upLoadPhoto(){
		$updir="public/swfupload/";//上传目录
		$dirtype="2";//目录保存方式1：年/月/日;2:年/月;默认:年
		$renamed="1";//是否重命名1表示重命名0表示用原来的文件名
		$overwrite="1";//是否覆盖1表示覆盖0表示不覆盖
		$type=array('jpg','bmp','gif','png','jpeg');//允许上传文件类型
		$file_size='2024';//默认2M
		if (isset($_FILES["Filedata"]) && is_uploaded_file($_FILES["Filedata"]["tmp_name"]) && $_FILES["Filedata"]["error"] == 0) 
		{
			//上传文件赋值给$upload_file
			$upload_file=$_FILES["Filedata"];
			//获取文件类型
			$file_info=pathinfo($upload_file["name"]);
			//获取文件扩展名
			$file_ext=strtolower($file_info["extension"]);
			if (!(in_array($file_ext,$type) && ($_FILES['Filedata']['size']/1024) <=$file_size)) {
				
				$this->HandleError('StatusCode =-220');
				//echo '大小超出限制';
				exit(0);
			}
			//获取文件大小

			//获取客户端名字
			//$file_name=$_FILES['Filedata']['name'];		
			//$file='大小'.$file_size.'</n>'.'名字'.$file_name.'类型'.$file_info;
			//$fp=fopen("./uploadfile/2008/12/message.txt",'w');
			//fwrite($fp,$file);
        	//fclose($fp);
			
			//设置路径方式
			
			switch($dirtype){
				case '1':
					$m_dir=date('Y')."/".date('m')."/".date('d')."/";
					break;
				case '2':
					$m_dir=date('Y')."/".date('m')."/";
					break;
				default:
					$m_dir=date('Y')."/";
					break;
			}
			//设置上传的路径
			$upload_path=$updir.$m_dir;
			//建立文件夹
			$this->create($upload_path);
			//需要重命名的
			if($renamed){
				list($usec, $sec) = explode(" ",microtime());
				$upload_file['name']=substr($usec,2).'.'.$file_ext;
				unset($usec);
				unset($sec);
			}
			
			
			//设置默认服务端文件名
			$upload_file['filename']=$upload_path.$upload_file['name'];
			//检查文件是否存在
			if(file_exists($upload_file['filename'])){
				if($overwrite){
					@unlink($upload_file['filename']);
				}else{
					$j=0;
					do{
						$j++;
						$temp_file=str_replace('.'.$file_ext,'('.$j.').'.$file_ext,$upload_file['filename']);
					}while (file_exists($temp_file));
					$upload_file['filename']=$temp_file;
					unset($temp_file);
					unset($j);
				}
			}
			if(move_uploaded_file($upload_file["tmp_name"],$upload_file["filename"])){
				//下面插入一段把路径保存到数据库中的代码;
// 				$data = array(
// 						'award_thumbnail' => $upload_file["filename"] ,
// 				);
// 				$this->db->insert('award', $data);
				
				// Create a pretend file id, this might have come from a database.
				//产生一个上传文件id,这可能来自数据库;
				//这里必需echo内容可以是文件id或许数据库中的id，不然程序会出现错误，没有内容传回到index.php表单中的hidFileID中
// 				if($this->db->insert_id())
// 				echo $this->db->insert_id();
				echo $upload_file["filename"];
// 				$image=$upload_file["filename"];
// 				echo $image;
// 				echo '-';
// 				$image=$upload_file["filename"];
// 				echo $image;
// 				setcookie("s_image", $upload_file["filename"], time()+3600);
// 				$this->session->set_userdata('s_image',$upload_file["filename"]);
// 				echo $_COOKIE["s_image"];
			}else{
				echo '';
			}
// 		session_start();
// 		$this->session->set_userdata('s_image',$upload_file["filename"]);
// 		echo $this->session->userdata("s_image");
		} else {
			echo ' '; // I have to return something or SWFUpload won't fire uploadSuccess
		}
		

	}
//建立文件夹
	function create($dir){
		if (!is_dir($dir)){
			$temp = explode('/',$dir);
			$cur_dir = '';
			for($i=0;$i<count($temp);$i++){
				$cur_dir .= $temp[$i].'/';
				if (!is_dir($cur_dir)){
					@mkdir($cur_dir,0777);
					@fopen("$cur_dir/index.htm","a");
				}
			}
		}
	}
 	/**
 	 * 兑换申请
 	 */
 	function award_apply(){
 		$this->myauth->execute_auth();	//验证是否登陆
		$this->db->select('*')
 		->from('award_user') 
 		->order_by('itime');
 		$data  =  $this->mydb->getList(); 	
//  		print_r($data);exit();
 		$this->mypage->loadview('award/award_apply',$data);
 			
 			
 	}
 	/**
 	 * 奖品列表
 	 */
 	function award_list(){ 	
//  		echo $_COOKIE["s_image"];
 		$this->myauth->execute_auth();	//验证是否登陆
 		$insert_date=$this->input->post('insert_date');
 		$product_real_name=$this->input->post('product_real_name');
 		if($this->uri->segment(3)=='2')
 		{
 			$this->session->unset_userdata('insert_date');
 			$this->session->unset_userdata('product_real_name');
 		}
 		if(!empty($insert_date))
 		{
 			$this->session->set_userdata('insert_date',$insert_date);
 			if($this->session->userdata('insert_date')!=$insert_date) $this->session->unset_userdata('insert_date');
 		}
 		if(!empty($product_real_name))
 		{
 			$this->session->set_userdata('product_real_name',$product_real_name);
 			if($this->session->userdata('product_real_name')!=$product_real_name) $this->session->unset_userdata('product_real_name');
 		}
 		if($this->session->userdata('insert_date')) $this->db->where('udate',$this->session->userdata('insert_date'));
 		if($this->session->userdata('product_real_name')) $this->db->like('award_name',$this->session->userdata('product_real_name'));
 		$data = null;
 		if($this->input->get('udate'))	$this->db->where('sale_main.insert_date',$this->input->get('insert_date'));
 		$this->db->like('award_name',$this->input->get('product_real_name'));
 		$this->db->select('*')
 		->from('award') 
 		->order_by('udate');
 		$data  =  $this->mydb->getList(); 	
 		$this->mypage->loadview('award/award_list',$data);
 	}
 	
 	/**
 	 * 查看兑换的奖品
 	 */
 	function apply_view(){
//  		echo base_url();exit();
 		$this->myauth->execute_auth();	//验证是否登陆
 		$data = null;
 		$id=$this->uri->segment(3);
 		$this->db->select('a.award_name,a.award_thumbnail,a.award_price,u.user_id,u.status',false);
 		$this->db->from("award_user as u");
 		$this->db->join("award as a","a.id=u.award_id","inner");
 		$this->db->where('u.id',$id);
 		$data = $this->db->get()->result_array();
//  		print_r($data[0]);exit();
 		$this->mypage->loadview('award/apply_view',$data[0]);
 	}
 	
 	/**
 	 * 查看奖品
 	 */
 	function award_view(){
 		//  		echo base_url();exit();
 		$this->myauth->execute_auth();	//验证是否登陆
 		$data = null;
 		$data = $this->Awardmodel->award_detail($this->uri->segment(3));
 		//  		print_r($data);exit();
 		$this->mypage->loadview('award/award_view',$data);
 	}
 	
 	/**
 	 * 处理兑换申请
 	 */
 	function apply_edit(){
 		try{
 			$this->myauth->execute_auth();	//验证是否登陆
 			$data = null;
 			$data = $this->Awardmodel->apply_detail($this->uri->segment(3));
 			$data['status']='1';
 			$data['utime']=date("Y-m-d H:i:s");
//  			print_r($data);exit();
 			$this->db->where('id', $this->uri->segment(3));
 			$this->db->update('award_user', $data);
 			$this->mypage->jsRedirect("兑换成功",site_url("award/award_apply"));
 		}catch(Exception $e){
 			show_error($e->getMessage());
 		}
 	
 	}
 	/**
 	 * 删除奖品
 	 */
 	function award_delete(){
 		try{
 			$id = $this->uri->segment(3);
 			$this->mydb->delete($id,$this->Awardmodel->saveConfig());
 			$this->mypage->jsRedirect("删除成功",site_url("award/award_list"));
 		}catch(Exception $e){
 			show_error($e->getMessage());
 		}	
 	}	
 	
 	
 
 }
 
?>
