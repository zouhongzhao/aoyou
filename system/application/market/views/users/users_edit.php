<style>
#search{font-size:14px;}
#search .k{padding:2px 1px; width:320px;}
#search_auto{border:1px solid #817FB2; position:absolute; display:none;}
#search_auto li{background:#FFF; text-align:left;}
#search_auto li.cls{text-align:right;}
#search_auto li a{display:block; padding:5px 6px; cursor:pointer; color:#666;}
#search_auto li a:hover{background:#D8D8D8; text-decoration:none; color:#000;}
</style>
<?php
	echo form_fieldset("修改");
// 	echo form_open("users/users_save");
?>
<form method="post" action="<?=site_url()?>?users/users_save/<?=$m_id?>" name="uadd" id="uadd">
<script type="text/javascript" defer="defer" src="<?=base_url()?>js/area.js"></script>
<table>
<tr>
<?php if($m_id=="m"){?>
    	<td class="right">市场专员：</td>
    	<?php 
	} elseif($m_id=="c"){
	?>
		<td class="right">渠道号：</td>
		 <?php 
	} else{
	?>
	<td class="right">用户名：</td>
	<?php 
	}?>
	
	<td class="left"><input type="text" name="main[us_name]"  value="<?php echo set_value('main[us_name]',$main['us_name']);?>" readonly="readonly"/>
	*
		<?php echo form_error("main[us_name]",'<div id="error_span" class="red_font">', '</div>');	?>	
	
	
	</td>
</tr>
<tr>
	<td class="right">密码：</td>
	<td class="left"><input type="text" name="main[us_pass]"  id="pass" value="">
	*(不修改密码时别填)
	</td>
</tr>
<tr>
	<td class="right">邮箱：</td>
	<td class="left"><input type="text" name="main[us_mail]"  value="<?php echo set_value('main[us_mail]',$main['us_mail']);?>">
	*
	(将使用此项做为登录)
	</td>
</tr>
<tr>
	<td class="right">用户QQ：</td>
	<td class="left"><input type="text" name="main[us_qq]"  value="<?php echo set_value('main[us_qq]',$main['us_qq']);?>"></td>
</tr>
<tr>
	<td class="right">联系电话：</td>
	<td class="left"><input type="text" name="main[us_tel]"  value="<?php echo set_value('main[us_tel]',$main['us_tel']);?>"></td>
</tr>
<tr>
	<td class="right">价格：</td>
	<td class="left"><input type="text" name="main[price]"  value="<?php echo set_value('main[price]',$main['price']);?>"></td>
</tr>
<tr>
	<td class="right">联系人：</td>
	<td class="left"><input type="text" name="main[names]"  value="<?php echo set_value("main[names]",$main['names']);?>" size="20"></td>
</tr>
<tr>
	<td class="right">锁定状态：</td>
	<td class="left">
	<select name="main[flag]">
     <option value="0">正常</option>
     <option value="1">锁定</option>
	</select></td>
</tr>
<tr>
	<td class="right">证件名称：</td>
	<td class="left"><input type="text" name="main[us_document]"  value="<?php echo set_value('main[us_document]',$main['us_document']);?>" size="20" maxlength="30"></td>
</tr>
<tr>
	<td class="right">证件号码：</td>
	<td class="left"><input type="text" name="main[us_document_num]"  value="<?php echo set_value('main[us_document_num]',$main['us_document_num']);?>"></td>
</tr>
<tr>
	<td class="right">所在省：</td>
	<td class="left">
    <select name="main[us_province]" id="province" onchange="getCity(this.value,'<?=site_url()?>')">
    	<?php if($main[us_province]!="0"){?>
    	<option value="<?php echo $main[us_province];?>" selected="selected"><?php echo $main[us_province];?></option>
    	<?php 
	} else{
	?>
		<option value="0" selected="selected">请选择省</option>
		 <?php 
	}?>
    	<?php foreach ($province as $row) :?>
        <option value="<?=$row->code?>"><?=$row->name?></option>
        <?php endforeach ?>
    </select>
   
    </td>
    <td>市
    <span id="scity">
    <select name="main[us_city]" id="city" >
    <?php if($main[us_city]!="0"){?>
    	<option value="<?php echo $main[us_city];?>" selected="selected"><?php echo $main[us_city];?></option>
    	<?php 
	} else{
	?>
    <option value="0" selected="selected">请选择城市</option>
   <?php 
	}?>
    </select>

    </span>
    </td>
</tr>
<tr>
	<td class="right">用户身份：</td>
	<td class="left">
	<select name="main[us_type]">
	<?php if($m_id=="m"){?>
    	<option value='market' selected>市场专员</option>
    	<?php 
	} elseif($m_id=="c"){
	?>
		<option value='channels' selected>渠道会员</option>
		 <?php 
	} else{
	?>
	<option value='member' selected>用户会员</option>
	<?php 
	}?>
		
		</select></td>
</tr>
<?php if($m_id=="u"){?>
<tr>
	<td class="right" style="color:red;">所属渠道：</td>
	<td class="left">
<input type="text" name="main[belongs_channels]" id="key" value="<?php echo set_value('main[belongs_channels]',$main['belongs_channels']);?>"/>&nbsp;
</td>
</tr>
<tr>
	<td class="right">所属专员：</td>
	<td class="left">
	 <select name="main[belongs_market]" id="market">
    	<?php if($main[belongs_market]!="0"){?>
    	<option value="<?php echo $main[belongs_market];?>" selected="selected"><?php echo $main[belongs_market];?></option>
    	<?php 
	} else{
	?>
		<option value="0" selected="selected">请选择专员</option>
		 <?php 
	}?>
    	<?php foreach ($market as $k=>$value) :?>
        <option value="<?=$value['us_name']?>"><?=$value['us_name']?></option>
        <?php endforeach ?>
    </select>
</td>
</tr>
<?php 
}
?>
<?php if($m_id=="c"){?>
<tr>
	<td class="right">所属专员：</td>
	<td class="left">
	 <select name="main[belongs_market]" id="market">
    	<?php if($main[belongs_market]!="0"){?>
    	<option value="<?php echo $main[belongs_market];?>" selected="selected"><?php echo $main[belongs_market];?></option>
    	<?php 
	} else{
	?>
		<option value="0" selected="selected">请选择专员</option>
		 <?php 
	}?>
    	<?php foreach ($market as $k=>$value) :?>
        <option value="<?=$value['us_name']?>"><?=$value['us_name']?></option>
        <?php endforeach ?>
    </select>
    </td>
</tr>
<?php 
}
?>
<tr>
	<td class="right">用户地址：</td>
	<td class="left"><input type="text" name="main[us_address]"  value="<?php echo set_value('main[us_address]',$main['us_address']);?>"></td>
</tr>
<tr>
	<td class="right">银行信息：</td>
	<td class="left">
	<textarea type="text" name="main[bank]" ><?php echo set_value('main[bank]',$main['bank']);?></textarea>
	</td>
</tr>
<tr>
	<td class="right">用户备注信息：</td>
	<td class="left"><textarea name="main[note]" rows="3" cols="55"><?php echo set_value('main[note]',$main['note']);?></textarea></td>
</tr>
</table>
<input type="hidden" name="main[id]" value="<?php echo $main['id'];?>" size="50" />
<script type="text/javascript">
$().ready(function() {
	 $("#key").autocomplete({
				minLength: 1,
				source: "/index.php/users/search_auto",
				focus: function( event, ui ) {
					$( "#key" ).val( ui.item.id );
					return false;
				},
				select: function( event, ui ) {
					$( "#key" ).val( ui.item.id );
					return false;
				}
			})
			.data( "autocomplete" )._renderItem = function( ul, item ) {
				return $( "<li></li>" )
					.data( "item.autocomplete", item )
					.append( "<a>" + item.id + "|" + item.name +"|" + item.names +"|" + item.name +"|" + item.city + "</a>" )
					.appendTo( ul );
			};
});
</script>
<script type="text/javascript">
 function class_show(){
	 var obj=document.getElementById('province');
	 var obj1=document.getElementById('city');
	 var index=obj.selectedIndex;
	 var index1=obj1.selectedIndex;
	 var textval = $("#pass").val();
	 if(obj.options[index].value!="0")
	 obj.options[index].value = obj.options[index].text;
	 if(obj1.options[index1].value!="0")
	 obj1.options[index1].value= obj1.options[index1].text;
	 if(textval == "") $("#pass").attr("disabled",true);
	document.getElementById("uadd").submit();
}
</script>

<center>
<!--  	echo form_hidden("main[id]",$main['id']); -->
<!-- 	echo form_submit("submit","提交"); -->
<input type="button" value="提交" onClick="class_show();"/>
<?php 
	echo form_close();
	echo form_fieldset_close();
?>
</center>
</form>