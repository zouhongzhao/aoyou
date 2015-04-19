<?php
	echo form_fieldset("修改密码");
	echo form_open("system_manage/save_pass");
?>
<table class="center" width="80%">
<tr><td class="right">用户名：</td><td class="left"><?php echo $main['admin_user'];?>
<?php echo form_hidden("main[admin_user]",$main['admin_user']); ?>

</td></tr>
<tr><td class="right">旧密码：</td><td class="left"><input type="password" name="main[old_password]">
<?php echo form_error("main[old_password]","<div id='error_span' class='red_font'>","</div>");?>

</td></tr>
<tr><td class="right">新密码：</td><td class="left"><input type="password" name="main[new_password]">
<?php echo form_error("main[new_password]","<div id='error_span' class='red_font'>","</div>");?>
</td></tr>
<tr><td class="right">密码确认：</td><td class="left"><input type="password" name="main[confirm_password]">
<?php echo form_error("main[confirm_password]","<div id='error_span' class='red_font'>","</div>");?>
</td></tr>
</table>
<center>
<?php
	echo form_hidden("main[admin_id]",$main['admin_id']);
	echo form_submit("submit","提交");
	echo form_close();
	echo form_fieldset_close();
?>
</center>