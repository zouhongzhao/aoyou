<?php
	class Assist extends CI_Controller{
		function __construct(){
			parent::__construct();
		}
		
		function calendar(){			
			$this->mypage->loadview("assist/calendar");
		}
		
		
	}
?>