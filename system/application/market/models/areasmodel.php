<?php
class Areasmodel extends CI_Model{
	function __construct(){
		parent::__construct();	
	}	
	/**
	 *取得所有省份
	 *用法：getProvince()
	 */
	function getProvince()
	{
		$query = $this->db->get('province');
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}
	/**
	 *取得所有城市
	 *用法：getCity()
	 */
	function getCity()
	{
		$query = $this->db->get('city');
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}
	/**
	 *取得所有地区
	 *用法：getArea()
	 */
	function getArea()
	{
		$query = $this->db->get('area');
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}
	/**
	 *按省取城市
	 *用法：getCityById()
	 */
	function getCityById($pid)
	{
		$this->db->where('provincecode',$pid);
		$query = $this->db->get('city');
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}
	/**
	 *按城市取区县
	 *用法：getAreaById()
	 */
	function getAreaById($cid)
	{
		$this->db->where('citycode ',$cid);
		$query = $this->db->get('area');
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}
	
}

?>