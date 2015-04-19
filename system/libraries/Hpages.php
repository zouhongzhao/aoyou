<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * FILE_NAME : Hpages.php
 *
 *
 * @package		haohailuo
 * @author		By Laurence.xu <haohailuo@163.com>
 * @copyright	Copyright (c) 2010, Haohailuo, Inc.
 * @link		http://www.haohailuo.com
 * @since		Version 1.0 $Id$
 * @version		Wed Dec 08 12:21:17 CST 2010
 * @filesource
*/
class CI_Hpages {

	var $base_url			= '';	//基本链接地址
	var $total_rows  		= '';	//数据总数
	var $per_page	 		= 10;	//每页条数
	var $num_links			=  2;	//要显示的左右链接的个数
	var $cur_page	 		=  1;	//当前页数
	var $first_link   		= '&lsaquo; First';	//首页字符
	var $next_link			= '&gt;';			//下一页的字符
	var $prev_link			= '&lt;';			//上一页的字符
	var $last_link			= 'Last &rsaquo;';	//末页的字符
	var $uri_segment		= 3;		//分页数所在的uri片段位置
	var $full_tag_open		= '';		//分页区域开始的html标签
	var $full_tag_close		= '';		//分页区域结束的后html标签
	var $first_tag_open		= '';		//首页开始的html标签
	var $first_tag_close	= '&nbsp;';	//首页结束的html标签
	var $last_tag_open		= '&nbsp;';	//末页开始的html标签
	var $last_tag_close		= '';		//末页结束的html标签
	var $cur_tag_open		= '&nbsp;<b>';//当前页开始的...
	var $cur_tag_close		= '</b>';	//当前页结束的...
	var $next_tag_open		= '&nbsp;';	//下一页开始的.....
	var $next_tag_close		= '&nbsp;';	//下一页结束的.....
	var $prev_tag_open		= '&nbsp;';	//上一页开始的.....
	var $prev_tag_close		= '';		//上一页结束的.....
	var $num_tag_open		= '&nbsp;';	//“数字”链接的打开标签。
	var $num_tag_close		= '';		//“数字”链接的结束标签。
	var $page_query_string	= FALSE;
	var $query_string_segment = 'per_page';
	
	var $page_mode			= 'default';	//default for add page at the end? if include {page}, will replace it for current page.
	var $underline_uri_seg	= -1;			//存在下划线时,页码所在数组下标位置
	var $custom_cur_page	= 0;			//自定义当前页码，存在此值是，系统将不自动判断当前页数，默认不启用
	
	function __construct() {
		$this->Hpages();
	}
	/**
	 * Constructor
	 *
	 * @access	public
	 */
	function Hpages() {
// 		print_r($config);exit();
// 		echo BASEPATH;exit();
 		
			if(is_array($config)){
			foreach ($config as $key=>$val) {
				$this->{$key} = $val;
			}
		}
		log_message('debug', "Hpages Class Initialized");
	}
	
	/**
	 * 初始化参数
	 *
	 * @see		init()
	 * @author	Laurence.xu <haohailuo@163.com>
	 * @version	Wed Dec 08 12:26:07 CST 2010
	 * @param	<array> $params 待初始化的参数
	*/
	function init($params = array()) {
// 		print_r($params);exit();
		if (count($params) > 0) {
			foreach ($params as $key => $val) {
				if (isset($this->$key)) {
					$this->$key = $val;
				}
			}		
		}
	}
	
	/**
	 * 创建分页链接
	 *
	 * @see		create_links()
	 * @author	Laurence.xu <haohailuo@163.com>
	 * @version	Wed Dec 08 15:02:27 CST 2010
	 * @param	<boolean> $show_info 是否显示总条数等信息
	 * @return	<string> $output
	*/
	function create_links($show_info = false, $top_info = false) {
		//如果没有记录或者每页条数为0,则返回空
		if ($this->total_rows == 0 || $this->per_page == 0) {
			return '';
		}

		//计算总页数
		$num_pages = ceil($this->total_rows / $this->per_page);

		//只有一页,返回空
		if ($num_pages == 1 && !$show_info) {
			return '';
		}
		
		$CI =& get_instance();

		//获取当前页编号
		if ($CI->config->item('enable_query_strings') === TRUE || $this->page_query_string === TRUE) {
			if ($CI->input->get($this->query_string_segment) != 0) {
				$this->cur_page = $CI->input->get($this->query_string_segment);

				// Prep the current page - no funny business!
				$this->cur_page = (int) $this->cur_page;
			}
		} else {
			if (intval($this->custom_cur_page) > 0) {
				$this->cur_page = (int) $this->custom_cur_page;
			}else{
				$uri_segment = $CI->uri->segment($this->uri_segment, 0);
				if ( !empty($uri_segment) ) {
					$this->cur_page = $uri_segment;
					//如果有下划线
					if ($this->underline_uri_seg >= 0) {
						if (strpos($this->cur_page, '-') !== false) {
							$arr = explode('-', $this->cur_page);
						}else {
							$arr = explode('_', $this->cur_page);
						}
						$this->cur_page = $arr[$this->underline_uri_seg];
						unset($arr);
					}
					// Prep the current page - no funny business!
					$this->cur_page = (int) $this->cur_page;
				}
			}
		}
		//echo $this->cur_page;exit;
		//左右显示的页码个数
		$this->num_links = (int)$this->num_links;

		if ($this->num_links < 1) {
			show_error('Your number of links must be a positive number.');
		}

		if ( ! is_numeric($this->cur_page) || $this->cur_page < 1) {
			$this->cur_page = 1;
		}
		
		//如果当前页数大于总页数,则赋值给当前页数最大值
		if ($this->cur_page > $num_pages) {
			$this->cur_page = $num_pages;
		}

		$uri_page_number = $this->cur_page;

		if ($CI->config->item('enable_query_strings') === TRUE || $this->page_query_string === TRUE) {
			$this->base_url = rtrim($this->base_url).'&'.$this->query_string_segment.'=';
		} else {
			$this->base_url = rtrim($this->base_url, '/') .'/';
		}
		
		if (strpos($this->base_url, "{page}") !== false) {
			$this->page_mode = 'replace';
		}
		
		$output = $top_output = '';
		//数据总量信息
		if ($show_info) {
			$output = " 共<b>".$this->total_rows ."</b>条记录 <span style='color:#ff0000;font-weight:bold'>{$this->cur_page}</span>/<b>".$num_pages."</b>页 每页<b>{$this->per_page}</b>条 ";
		}
		//数据信息，显示在上面，以供提醒
		if ($top_info) {
			$top_output = " 共 <b>".$this->total_rows ."</b> 条记录 第<span style='color:#ff0000;font-weight:bold'>{$this->cur_page}</span>页/共<b>".$num_pages."</b>页 ";
		}
		//判断是否要显示首页
		if  ($this->cur_page > $this->num_links+1) {
			$output .= $this->first_tag_open.'<a href="'.$this->makelink().'">'.$this->first_link.'</a>'.$this->first_tag_close;
		}
		
		//显示上一页
		if  ($this->cur_page != 1) {
			$j = $this->cur_page - 1;
			if ($j == 0) $j = '';
			$output .= $this->prev_tag_open.'<a href="'.$this->makelink($j).'">'.$this->prev_link.'</a>'.$this->prev_tag_close;
		}
		
		//显示中间页
		for ($i=1; $i <= $num_pages; $i++){
			if ($i < $this->cur_page-$this->num_links || $i > $this->cur_page+$this->num_links) {
				continue;
			}
			
			//显示中间页数
			if($this->cur_page == $i){
				$output .= $this->cur_tag_open.$i.$this->cur_tag_close; //当前页
			}else {
				$output .= $this->num_tag_open.'<a href="'.$this->makelink($i).'">'.$i.'</a>'.$this->num_tag_close;
			}
		}
		
		//显示下一页
		if  ($this->cur_page < $num_pages) {
			$k = $this->cur_page + 1;
// 			echo $this->makelink($k);exit();
			$output .= $this->next_tag_open.'<a href="'.$this->makelink($k).'">'.$this->next_link.'</a>'.$this->next_tag_close;
		}
		
		//显示尾页
		if (($this->cur_page + $this->num_links) < $num_pages) {
			$output .= $this->last_tag_open.'<a href="'.$this->makelink($num_pages).'">'.$this->last_link.'</a>'.$this->last_tag_close;
		}

		$output = preg_replace("#([^:])//+#", "\\1/", $output);

		// Add the wrapper HTML if exists
		$output = $this->full_tag_open.$output.$this->full_tag_close;

		if ($top_info) {
			return array($output, $top_output);
		}else {
			return $output;
		}
	}
	
	/**
	 * 创建链接url地址
	 *
	 * @param <string> $str
	 * @return <string>
	 */
	function makelink($str = '') {
// 		echo $this->base_url.$str;exit();
		if($this->page_mode == 'default') {
// 			echo $this->_forsearch($this->base_url.$str);exit();
			return $this->_forsearch($this->base_url.$str);
		} else {
			$url = $this->base_url;
			if ($str == 1) {
				$url = str_replace('/{page}', '', $this->base_url);
			}
			$url = str_replace("{page}", $str, $url);
// 			echo $url;exit();
			return $this->_forsearch($url);
		}
	}
	
	/**
	 * 处理url地址
	 *
	 * @see		_forsearch()
	 * @author	Laurence.xu <haohailuo@163.com>
	 * @version	Wed Dec 08 14:33:58 CST 2010
	 * @param	<string> $string pInfo
	 * @return	<string>
	*/
	function _forsearch($string) {
		$length = strlen($string) - 1;
		if($string{$length} == '/') {
			$string = rtrim($string, '/');
		}
// 		echo $string;exit();
// 		return site_url($string);
		return $string;
	}
}

// END Pagination Class

/* End of file Hpages.php */
/* Location: ./system/libraries/Hpages.php */