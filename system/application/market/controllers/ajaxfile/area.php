<?php
class Area extends Controller {

		function __construct(){
 		parent::__construct();
 		$this->myauth->execute_auth();	//验证是否登陆
		$this->load->model('Areasmodel');	
 	}
	
	function index()
	{
		extract($_REQUEST);
		if($type=="city")
		{
			$result = $this->Areasmodel->getCityById($id);
			$str = "<select name='main[city]' id='city' onchange=getArea(this.value,'".site_url()."')>
			<option value='0' selected='selected'>请选择城市</option>";
			foreach ($result as $row)
			{
				$str .= ' <option value="'.$row->code.'">'.$row->name.'</option>';
			}
			$str .= '</select>';
			echo $str;
		}
		if($type=="area")
		{
			$result = $this->Areasmodel->getAreaById($id);
			$str = '<select name="main[area]" id="area">
			<option value="0" selected="selected">请选择区县</option>';
			foreach ($result as $row)
			{
				$str .= ' <option value="'.$row->code.'">'.$row->name.'</option>';
			}
			$str .= '</select>';
			echo $str;
		}
	}
}
?>