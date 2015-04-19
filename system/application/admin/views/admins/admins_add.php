<?php
	echo form_fieldset("添加/修改管理员");
?>
<form method="post" action="<?=site_url()?>?admins/admins_save/<?=id?>" name="uadd" id="uadd">
<table>
<tr>
	<td class="right">姓名：</td>
	<td class="left"><input type="text" name="main[admin_user]"  value="<?php echo set_value('main[admin_user]',$main['admin_user']);?>" />
	
		<?php echo form_error("main[admin_user]",'<div id="error_span" class="red_font">', '</div>');	?>	
	
	
	</td>
</tr>

<tr>
	<td class="right">密码：</td>
	<td class="left"><input type="text" name="main[admin_pass]"  id="pass" value=""></td>
</tr>
<tr>
	<td class="right">邮箱：</td>
	<td class="left"><input type="text" name="main[admin_email]"  value="<?php echo set_value('main[admin_email]',$main['admin_email']);?>"></td>
</tr>
<tr>
	<td class="right">电话：</td>
	<td class="left"><input type="text" name="main[admin_tel]"  value="<?php echo set_value('main[admin_tel]',$main['admin_tel']);?>"></td>
</tr>
<tr>
	<td class="right">联系人：</td>
	<td class="left"><input type="text" name="main[admin_contact]"  value="<?php echo set_value('main[admin_contact]',$main['admin_contact']);?>"></td>
</tr>
<tr>
	<td class="right">性别：</td>
	<td class="left">
		男<input type="radio" name="main[admin_sex]" value="1" <?php if($main[admin_sex]=="1" ) echo" checked='1'";?>>
		女<input type="radio" name="main[admin_sex]" value="2" <?php if($main[admin_sex]=="2" ) echo" checked='1'";?>>
	</td>
</tr>
<tr>
	<td class="right">管理员类型：</td>
	<td class="left">
		超级管理员<input type="radio" name="main[admin_type]" value="1" <?php if($main[admin_type]=="1" ) echo" checked='1'";?>>
		市场部管理员<input type="radio" name="main[admin_type]" value="2" <?php if($main[admin_type]=="2" ) echo" checked='1'";?>>
	</td>
</tr>
<tr>
	<td class="right">备注：</td>
	<td class="left"><textarea name="main[admin_remark]" rows="3" cols="55"><?php echo set_value('main[admin_remark]',$main['admin_remark']);?></textarea></td>
</tr>
</table>
<input type="hidden" name="main[admin_id]" value="<?php echo $main['admin_id'];?>" size="50" />
<center>
<script type="text/javascript">
 function class_show(){
	 var textval = $("#pass").val();
	 if(textval == "") $("#pass").attr("disabled",true);;
	document.getElementById("uadd").submit();
}
</script>
<input type="button" value="提交" onClick="class_show();"/>
<?php	
	echo form_close();
	echo form_fieldset_close();
?>
</center>