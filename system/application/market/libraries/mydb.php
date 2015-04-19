<?php
if (!defined('BASEPATH')) show_error('No direct script access allowed'); 

/*
 * Created on 2010-4-13
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 class Mydb {
 	
 	function __construct(){
 		
 		$ci = & get_instance();	
 		$this->db = $ci->db;	
 		$this->uri = $ci->uri;	 		
 		$this->myform  = &get_myform();	 
 		$this->mypage  = &get_mypage();	 		
 		$this->config  = $ci->config;
 		$this->pagination  = $ci->pagination;	
 		
 	}
 	 	
 	function save($save_info,$save_config){
 		if(empty($save_config)) throw new Exception('系统异常，没有配置保存参数!');
		$info  = $this->main_save($save_info,$save_config); //保存主表信息
		isset($save_config['detail']) && $this->detail_save($info,$save_config); //保存明细表信息
		return $info['main'];
 		
 	}
 	
 	/**
 	 * 保存主表信息
 	 */
 	function main_save($info,$save_config){ 		
 		extract($save_config['main']);	 		
	 	if(empty($info['main'][$primary_key])){ 			
	 		$info['main'][$primary_key] = $this->db->insert($table_name,$info['main']);
	 		$info['sys_db_type'] = 'inesrt';
	 		$this->db->close();
	 	}else{
	 		$this->db->where($primary_key,$info['main'][$primary_key]);
	 		$this->db->update($table_name,$info['main']);
	 		$info['sys_db_type'] = 'update';
	 	}		
	 	return $info;
 	}
 	
 	/**
 	 * 保存明细表信息
 	 */
 	function detail_save($info,$save_config){ 	
 		extract($save_config['detail']); 		
 		$detail = $info['detail']; 	 
 		if($info['sys_db_type']=='update'){					
			$this->detail_left_delete($info,$save_config);
		}
 		foreach($detail as &$v){ 			
 			if($v[$primary_key]){
 				$this->db->where($primary_key,$v[$primary_key]);
 				$this->db->update($table_name,$v);				
 				
 			}else{
 				$v[$save_config['main']['primary_key']] = $info['main'][$save_config['main']['primary_key']];
 				$this->db->insert($table_name,$v);
 				$this->db->close();
 			
 			}
 		} 
		
	
 	} 	
 	
 	/**
 	 * 删除多余明细信息
 	 */
 	
 	function detail_left_delete($info,$save_config){ 
 		//表单提交过来的detail_id 
 		$key_form = $this->myform->indexArrayByKey($info['detail'],$save_config['detail']['primary_key'],$save_config['detail']['primary_key']);
 		//数据库中的detail_id 	 		
 		$this->db->select($save_config['detail']['primary_key']);
 		$this->db->from($save_config['detail']['table_name']);
 		$this->db->where($save_config['main']['primary_key'],$info['main'][$save_config['main']['primary_key']]);
 		$key_db_temp = $this->db->get()->result_array();
 		$key_db = $this->myform->indexArrayByKey($key_db_temp,'detail_id','detail_id'); 
 		$diff_key = array_diff($key_db,$key_form);	
 		if(!empty($diff_key)){
 			$diff_ids = $this->myform->arrayToStr($diff_key);
 			$this->db->where_in($save_config['detail']['primary_key'],$diff_ids);
 			$this->db->delete($save_config['detail']['table_name']); 
 		}
 	}
 	
 	
 	/**
 	 * 删除信息
 	 */
 	function delete($id,$save_config){ 	 	
 		if(empty($save_config)) throw new Exception('系统异常，没有配置删除参数');	
 		$main = $this->main_delete($id,$save_config);
 		isset($save_config['detail']) && $this->detail_delete($id,$save_config);
 		return $main; 		
 	}
 	
 	
 	/**
 	 * 删除主表信息
 	 */
 	
 	function main_delete($id,$save_config){ 		
 		$this->db->where($save_config['main']['primary_key'],$id);
 		$this->db->delete($save_config['main']['table_name']);
 		
 	}
 	
 	/**
 	 * 删除明细信息 
 	 */
 	function detail_delete($id,$save_config){ 		
 		$this->db->where($save_config['main']['primary_key'],$id);
 		$this->db->delete($save_config['detail']['table_name']); 		
 	}
 	
 	/**
 	 * 查询列表
 	 */
 	function getList(){	
 		parse_str($_SERVER['QUERY_STRING'], $_GET);
 		$limit_from = $_GET['per_page']; 		
 		$link_str = $this->mypage->arrayToUrl($_GET);		
 		$params = array( 		
 			'limit_to'=>$this->config->item('per_page'),
 			'limit_from'=>$limit_from,
 		); 	 		
 		$config['base_url'] = current_url().$link_str;
 		//echo $config['base_url'];
 		if(!isset($params['limit_from'])) $params['limit_from'] = 0;					
 			$sql_count =  $this->db->_compile_select();
 			
			$this->db->limit($params['limit_to'],$params['limit_from']);
			$sql = $this->db->_compile_select();			
			//echo $sql;exit();
			$data = array(
				'count' => $this->db->count_all("($sql_count)as t "),
				'list' => $this->db->query($sql)->result_array(),
		);		
			//$config['use_page_numbers'] = TRUE;
		$config['page_query_string'] = TRUE;
 		$config['per_page'] = $this->config->item('per_page'); 			
 		$config['total_rows'] = $data['count'];
 		$config['full_tag_open'] = '<p>';
 		$config['full_tag_close'] = '</p>';
 		$config['first_link'] = '首页';
 		$config['first_tag_open'] = '<li>';//“第一页”链接的打开标签。
 		$config['first_tag_close'] = '</li>';//“第一页”链接的关闭标签。
 		$config['last_link'] = '尾页';//你希望在分页的右边显示“最后一页”链接的名字。
 		$config['last_tag_open'] = '<li>';//“最后一页”链接的打开标签。
 		$config['last_tag_close'] = '</li>';//“最后一页”链接的关闭标签。
 		$config['next_link'] = '下一页';//你希望在分页中显示“下一页”链接的名字。
 		$config['next_tag_open'] = '<li>';//“下一页”链接的打开标签。
 		$config['next_tag_close'] = '</li>';//“下一页”链接的关闭标签。
 		$config['prev_link'] = '上一页';//你希望在分页中显示“上一页”链接的名字。
 		$config['prev_tag_open'] = '<li>';//“上一页”链接的打开标签。
 		$config['prev_tag_close'] = '</li>';//“上一页”链接的关闭标签。
 		$config['cur_tag_open'] = '<li class="current">';//“当前页”链接的打开标签。
 		$config['cur_tag_close'] = '</li>';//“当前页”链接的关闭标签。
 		$config['num_tag_open'] = '<li>';//“数字”链接的打开标签。
 		$config['num_tag_close'] = '</li>';
 		$this->pagination->initialize($config); 
 		$data['page_link'] = $this->pagination->create_links(); 
 		return $data; 		
 		
 	}
 	
 	/**
 	 * 生成json缓存文件
 	 */
 	function createComboxCache($config){ 
 		if(empty($config)){ 			
 			show_error("参数配置不正确");
 		}	 		
 		extract($config);	 		
 		$dd = $this->db->from($table_name)
 		->select($fields)->get()->result_array(); 		
 		$handle = fopen(BASEPATH.'../'.$path,'w');
 		if(!$handle){
 			show_error("不能打开文件，路径".$path);
 		}
 		$cache_str = '';
 		$split_str = ''; 		
 		if(!fwrite($handle,"".json_encode($dd)."")){
 			show_error("无法写入文件，路径".$path);
 		}	
 		
 	}
 	
 	
 	
 	/**
 	 * 生成缓存文件
 	 */
 	function createCache($config){ 
 		if(empty($config)){ 			
 			show_error("参数配置不正确");
 		}	 		
 		extract($config);	 		
 		$dd_temp = $this->db->from($table_name)
 		->select($fields)->get()->result_array(); 	
 		if($dd_temp){
 			foreach($dd_temp as $v){
 				$dd[$v[$config['primary_key']]] = $v;
 			}
 		}else{
 			$dd = null;
 		}	
 		$handle = fopen(BASEPATH.'../'.$path,'w');
 		if(!$handle){
 			show_error("不能打开文件，路径".$path);
 		}
 		$cache_str = '';
 		$split_str = ''; 		
 		if(!fwrite($handle,"<?php return ".var_export($dd,true).";?>")){
 			show_error("无法写入文件，路径".$path);
 		}	
 		
 	}
 	
 	
 	/**
 	 * 取字典
 	 */
 	function getCache($name){
 		$file = BASEPATH.'../cache/'.$name.'.php';
 		return  require($file);
 	}
 	
 
 } 
 
?>
