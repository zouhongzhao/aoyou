// JavaScript Document
function getCity(pid,url)
{
	$.post(url+"?area/index",{type:"city",id:pid},
		function(data){
			$("#scity").html(data);	
//			$("#sarea").html('<select name="area" id="area"><option value="0" selected="selected">请选择区县</option></select>');	
			});
}
//function getArea(cid,url)
//{
//	$.post(url+"?area/index",{type:"area",id:cid},
//		function(data){
//			$("#sarea").html(data);			
//			});	
//}