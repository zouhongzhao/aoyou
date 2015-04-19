<?php
 if (!defined('BASEPATH')) show_error('No direct script access allowed'); 
class Mypage{	
	private static $instance;

	public function __construct()
	{
		self::$instance =& $this;
		$this->header_html=array('js'=>null,'css'=>null);
		$config = &get_config();	
		$this->getHeaderJs($config['default_js']);
		$this->getHeaderCss($config['default_css']);
		$this->config = $config;
		
	}


	
	function loadview($tpl,$data=null){	
			$CI = & get_instance();					
			$data['header_html'] = $this->header_html;		
			$CI->load->view('top.php',$data);				
			$tpl_arr = explode(',',$tpl);
			if(is_array($tpl_arr)){
				foreach($tpl_arr as $v){
					$CI->load->view($v,$data);
				}
			}else{
				$CI->load->view($tpl,$data);
				
			}
			$CI->load->view('foot.php',$data);	
	}	
	
	
	/**
	 * 加载js
	 */
	function getHeaderJs($js){									
			if(empty($js)) return '';
			if(is_array($js)){	
				foreach($js as $value){				
							
					$this->header_html['js']  .= '<script language="JavaScript" type="text/javascript" src="' 
					. base_url() . 'js/'.$value.'.js"></script>'.chr(13);
													
				}		
			}else{
				
					$this->header_html['js']  .= '<script language="JavaScript" type="text/javascript" src="' 
					. base_url() . 'js/'.$js.'.js"></script>'.chr(13);
			}			
		
	}
	
	/**
	 * 加载样式
	 */
	function getHeaderCss($css){		
		if(empty($css)) return '';
		if(is_array($css)){
			foreach($css as $value){
				$this->header_html['css'] .= "<link href=\"".base_url()."css/".$value.".css\" rel=stylesheet > ".chr(13);
			}
		}else{
			$this->header_html['css'] .= "<link href=\"".base_url()."css/".$css.".css\" rel=stylesheet > ".chr(13);
		}		
		
	}
	
	
	
	 	
	 function myEncrypt($string,$operation = 'DECODE') { 
	 	if(empty($string)) throw Exception('未传值');
	 	if(empty($operation)) throw Exception('加密类型未设置');
	 	$key  = $this->config['encryption_key'];	 	
		
		// 动态密匙长度，相同的明文会生成不同密文就是依靠动态密匙  
	    $ckey_length = 4;  
	      
	    // 密匙  
	    $key = md5($key ? $key : $GLOBALS['discuz_auth_key']);  
	      
	    // 密匙a会参与加解密  
	    $keya = md5(substr($key, 0, 16));  
	    // 密匙b会用来做数据完整性验证  
	    $keyb = md5(substr($key, 16, 16));  
	    // 密匙c用于变化生成的密文  
	    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';  
	    // 参与运算的密匙  
	    $cryptkey = $keya.md5($keya.$keyc);  
	    $key_length = strlen($cryptkey);  
	    // 明文，前10位用来保存时间戳，解密时验证数据有效性，10到26位用来保存$keyb(密匙b)，解密时会通过这个密匙验证数据完整性  
	    // 如果是解码的话，会从第$ckey_length位开始，因为密文前$ckey_length位保存 动态密匙，以保证解密正确  
	    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;  
	    $string_length = strlen($string);  
	    $result = '';  
	    $box = range(0, 255);  
	    $rndkey = array();  
	    // 产生密匙簿  
	    for($i = 0; $i <= 255; $i++) {  
	        $rndkey[$i] = ord($cryptkey[$i % $key_length]);  
	    }  
	    // 用固定的算法，打乱密匙簿，增加随机性，好像很复杂，实际上对并不会增加密文的强度  
	    for($j = $i = 0; $i < 256; $i++) {  
	        $j = ($j + $box[$i] + $rndkey[$i]) % 256;  
	        $tmp = $box[$i];  
	        $box[$i] = $box[$j];  
	        $box[$j] = $tmp;  
	    }  
	    // 核心加解密部分  
	    for($a = $j = $i = 0; $i < $string_length; $i++) {  
	        $a = ($a + 1) % 256;  
	        $j = ($j + $box[$a]) % 256;  
	        $tmp = $box[$a];  
	        $box[$a] = $box[$j];  
	        $box[$j] = $tmp;  
	        // 从密匙簿得出密匙进行异或，再转成字符  
	        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));  
	    }  
	    if($operation == 'DECODE') {  
	        // substr($result, 0, 10) == 0 验证数据有效性  
	        // substr($result, 0, 10) - time() > 0 验证数据有效性  
	        // substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16) 验证数据完整性  
	        // 验证数据有效性，请看未加密明文的格式  
	        if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {  
	            return substr($result, 26);  
	        } else {  
	            return '';  
	        }  
	    } else {  
	        // 把动态密匙保存在密文里，这也是为什么同样的明文，生产不同密文后能解密的原因  
	        // 因为加密后的密文可能是一些特殊字符，复制过程可能会丢失，所以用base64编码  
	        return $keyc.str_replace('=', '', base64_encode($result));  
	    }  
			
		
		
	 		
	}
		
		
		
	public static function &get_mypage()
	{
		return self::$instance;
	}	
	
	/**
	 * 跳转
	 */
	function redirectWithInfo($url,$msg,$target='parent'){		
		$data = array('url'=>$url,'msg'=>$msg,'target'=>$target);
		$this->loadview('mypage/redirect_info',$data);			
	}
	
	/**
	 * js跳转 
	 */
	function jsRedirect($msg,$url){
		echo "<script language='javascript'>parent.show_msg('$msg');location.replace('$url');</script>";
		exit();
	}
	
	
	/**
	 * 数组转成url
	 */
	function arrayToUrl($array){			
		$link='?1=1';
		$split ='&';
		if(empty($array)) return '?1=1';				
		foreach($array as $k=>$v){
			if(in_array($k,array('1','per_page'))) continue;
			$link .= $split.$k.'='.$v;				
		}
		return $link;
	}
	
}




function &get_mypage()
{
	return Mypage::get_mypage();
}





