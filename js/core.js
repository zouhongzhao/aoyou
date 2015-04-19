
//统一复制
function core_copy(obj,clearobj,extend_fn){	
	var parents = $(obj).parents("tr:first");	
	var object_new = $(parents).clone().insertAfter($(parents));	
	$(object_new).find('#delete_link').show();		
	$(object_new).find(clearobj).val('');	
	autocomplete_load($(object_new).find('#product_name')); //autocomplete
	var size = parseInt($('#total_detail').val());	
	size++;
	$('#total_detail').val(size);				
	$(object_new).find("[name^='detail']").each(function(){		
		var name  = $(this).attr("name");	
		var new_name = name.replace(/\[\d.*?\]/,'['+size+']');			
		$(this).attr("name",new_name) ;
		
	})	
	
	if(typeof(extend_fn!="undefined")&&typeof(eval(extend_fn))=="function"){
		eval(extend_fn+"(obj)");
	}

}

//统一删除
function core_drop(obj,extend_fn){
	$(obj).parents("tr").remove();		
	if(typeof(extend_fn!="undefined")&&typeof(eval(extend_fn))=="function"){
		eval(extend_fn+"(obj)");
	}
	
}


/**
 * auto complete
 */		
function autocomplete_load_org(obj){
		$(obj).next(".combobox").remove();
		$(obj).combobox({
			url:$('#sys_base_url').html()+'js/cache/product.json',
			valueField:'product_id',
			textField:'product_name',
			cache:"false"
		});	
	
}


		
		
function autocomplete_load(obj){
		jQuery(obj).autocomplete({		
			url: $('#sys_base_url').html()+'/index.php/product/product_search?1=1&product_name='+obj.val(),
			
			sortFunction: function(a, b, filter) {			
				var f = filter.toLowerCase();
				var fl = f.length;
				var a1 = a.value.toLowerCase().substring(0, fl) == f ? '0' : '1';
				var a1 = a1 + String(a.data[0]).toLowerCase();
				var b1 = b.value.toLowerCase().substring(0, fl) == f ? '0' : '1';
				var b1 = b1 + String(b.data[0]).toLowerCase();
				if (a1 > b1) {
					return 1;
				}
				if (a1 < b1) {
					return -1;
				}
				return 0;
			},
			showResult: function(value, data) {
				return '<span style="color:red">' + value + '</span>';
			},
			onItemSelect: function(item) {		
				obj.prev("input").val(item.data).trigger('change');
			},
			onNoMatch:function(){
				obj.prev("input").val('').trigger("change");
				obj.val('');
			},
			
			
			
			maxItemsToShow: 50
	  });
		
}



/**
 * 跳转
 */
function redirect(url,target){	
	if(target=='self'){
		setTimeout(function(){self.location.href=url},3000);
	}else{
		setTimeout(function(){parent.location.href=url},3000);
	}

}

$(document).ready(function(){

	$("[id='error_span']").each(function(){		
		var newp = $(this).prev().offset();
		var width = $(this).prev().width()-20;
		var new_left = newp.left;
		var new_top = newp.top;
		new_left = new_left+parseInt(width/2);
		new_top = new_top+10;
		var inner_html  = $(this).html();
		$(this).html('');		
		$(this).css({"line-height":"150%", "width":"120px","z_index":"100","position":"absolute","left":new_left+"px","top":new_top+"px" });
		var error_html = '<div><div style="width:100%;height:14px;"><img  src="/images/error_msg_top.gif"></div>';
			 error_html += '<div  style="width:100%;float:left;font-size:12px;	color:red;	padding:5px;	border:1px solid #FF7C06;background:#FDFCEB;	z-index:-1;"><div style="float:left">'+inner_html+'</div>';
			 error_html += '<div style="float:right;margin-top:-3px;margin-right:-2px;font-size:12px;"><a href="javascript:void(0);"  style="color:#FF8D00"><b>×<b></a></div></div></div>';
			 
		$(this).html(error_html); 
		$(this).bind('click',function(){
			$(this).hide();
			
		})
		
		setTimeout(function(){		
			$("[id='error_span']").hide();
		},2000);
	})


})


$(function(){
			//$(".mytable tr:odd").addClass("tr_hover");  //隔行换色处			
			//鼠标经过样式变化处
			$(".mytable tr").hover( 
                function () { 
                    $(this).addClass("tr_over");   //鼠标经过时增加样式
                }, 
                function () { 
                    $(this).removeClass("tr_over"); //鼠标离开时移除样式
                }
            )
			
		
})


$(function() {
			$(".datepicker").datepicker({
				pickerClass:"my-picker",
				autoSize:"false",
				
				dateFormat:"yy-mm-dd",monthNames:['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月']
			,
			dayNamesMin:['日', '一', '二', '三', '四', '五', '六']
			
			});
	});

	
	
//提示信息
function show_msg(msg){				
	$.messager.show({
			title:'提示信息',
			msg:msg,
			timeout:3000,
			showType:'slide'
		});
		
}
