<?php
	echo form_fieldset("添加会员");
	echo form_open("members/member_save");
?>

<table>
<tr>
	<td class="right">姓名：</td>
	<td class="left"><input type="text" name="main[member_name]"  value="<?php echo set_value('main[member_name]',$main['member_name']);?>" />
	
		<?php echo form_error("main[member_name]",'<div id="error_span" class="red_font">', '</div>');	?>	
	
	
	</td>
</tr>
<tr>
	<td class="right">性别：</td>
	<td class="left">
		男<input type="radio" name="main[sex]" value="1" <?php echo set_radio('main[sex]','1',$sex_select["1"]);?>>
		女<input type="radio" name="main[sex]" value="2" <?php echo set_radio('main[sex]','2',$sex_select["2"]);?>>
	</td>
</tr>
<tr>
	<td class="right">手机：</td>
	<td class="left"><input type="text" name="main[mobile]"  value="<?php echo set_value('main[mobile]',$main['mobile']);?>"></td>
</tr>
<tr>
	<td class="right">电话：</td>
	<td class="left"><input type="text" name="main[phone]"  value="<?php echo set_value('main[phone]',$main['phone']);?>"></td>
</tr>
<tr>
	<td class="right">QQ：</td>
	<td class="left"><input type="text" name="main[qq]"  value="<?php echo set_value("main[qq]",$main['qq']);?>"></td>
</tr>
<tr>
	<td class="right">地址：</td>
	<td class="left"><input type="text" name="main[address]"  value="<?php echo set_value('main[address]',$main['address']);?>"></td>
</tr>
<tr>
	<td class="right">备注：</td>
	<td class="left"><textarea name="main[remarks]" rows="3" cols="55"><?php echo set_value('main[remarks]',$main['remarks']);?></textarea></td>
</tr>
</table>
<center>
<?php	
	echo form_hidden("main[member_id]",$main['member_id']);
	echo form_submit("submit","提交");
	echo form_close();
	echo form_fieldset_close();
?>
</center>