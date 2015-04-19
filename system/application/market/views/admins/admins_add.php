<?php
	echo form_fieldset("添加/修改管理员");
	echo form_open("admins/admins_save");
?>

<table>
<tr>
	<td class="right">姓名：</td>
	<td class="left"><input type="text" name="main[admin_user]"  value="<?php echo set_value('main[admin_user]',$main['admin_user']);?>" />
	
		<?php echo form_error("main[admin_user]",'<div id="error_span" class="red_font">', '</div>');	?>	
	
	
	</td>
</tr>
<tr>
	<td class="right">密码：</td>
	<td class="left"><input type="text" name="main[admin_pass]"  value="<?php echo set_value('main[admin_pass]',$main['admin_pass']);?>"></td>
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
		男<input type="radio" name="main[admin_sex]" value="1" <?php echo set_radio('main[admin_sex]','1',$sex_select["1"]);?>>
		女<input type="radio" name="main[admin_sex]" value="2" <?php echo set_radio('main[admin_sex]','2',$sex_select["2"]);?>>
	</td>
</tr>

<tr>
	<td class="right">备注：</td>
	<td class="left"><textarea name="main[admin_remark]" rows="3" cols="55"><?php echo set_value('main[admin_remark]',$main['admin_remark']);?></textarea></td>
</tr>
</table>
<center>
<?php	
	echo form_hidden("main[admin_id]",$main['admin_id']);
	echo form_submit("submit","提交");
	echo form_close();
	echo form_fieldset_close();
?>
</center>