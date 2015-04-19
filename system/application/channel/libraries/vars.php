    <?php
    if (!defined('BASEPATH')) exit('No direct script access allowed');
    error_reporting(0);
    class vars{
    	function __construct(){
    		$this->ci = &get_instance();
    	}
    var $CI;
    function vars(){
    $this->CI = & get_instance();
    $this->CI->load->database();  // load database library, if need
		$name=$this->session->userdata('u_name');
		$today = date("Y-m-d");
		$yesterday = date("Y-m-d",time()-3600*24);	//yesterday
		$access_jinbi_sql1 = $this->db->select('sum(`activation`) as acs',false)->from('tong_day')->where('u_id',$name)->group_by('u_id')->get()->result_array();
// 		print_r($abc);exit();
		$access_jinbi_sql2 = $this->db->select('activation',false)->from('tong_day')->where('u_id',$name)->where('dates',$yesterday)->get()->result_array();
		// 		print_r($access_jinbi_sql);exit();
		$access_jinbi_sql3 = $this->db->select('sum(`expenditure`) as exp',false)->from('award_user')->where('user_id',$name)->group_by('itime')->get()->result_array();
		
		$site_info['access_jinbi'] = intval($access_jinbi_sql1[0]['acs']);
		$site_info['access_jinbi'] = intval($access_jinbi_sql2[0]['activation']);
		$site_info['access_jinbi'] = intval($access_jinbi_sql3[0]['exp']);
    $this->CI->load->vars($site_info);
    }
    //
    }//见注释2
