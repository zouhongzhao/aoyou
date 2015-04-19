






<?php 

echo form_fieldset('登陆');



echo form_open('login/chklogin'); ?>

<table width="400" align="center">
<tr>
	<td width="108" align="right">用户名：</td>
	<td width="280" align="left">
	
	<?php	
	
		$data = array(
              'name'        => 'user_name',
              'id'          => 'user_name',
              'value'       => set_value("user_name"),
              'maxlength'   => '100',
              'size'        => '50',
              'style'       => 'width:50%',
            );

			echo form_input($data);		
			echo form_error("user_name","<div id='error_span'>","</div>");
	?>
	</td>
</tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr >
	<td align="right">密&nbsp;&nbsp;码：</td>
	<td align="left">
	
		<?php	
	
		$data = array(
              'name'        => 'user_pass',
              'id'          => 'user_pass',
              'value'       => set_value("user_pass"),
              'maxlength'   => '100',
              'size'        => '50',
              'style'       => 'width:50%',
            );

			echo form_password($data);		
			echo form_error("user_pass","<div id='error_span'>","</div>");
		
	?>
	
	</td>
</tr>
<tr>
<td colspan="2" align="center"><?php echo form_submit('', '提交'); ?></td>

</tr>
</table>
<p>演示账户:
	渠道用户:用户名:597937529@qq.com,密码:123456
	普通用户:用户名:yueliancao@yahoo.cn,密码:123456</p>


<?php 
echo form_close(); 
echo form_fieldset_close(); 
?>


