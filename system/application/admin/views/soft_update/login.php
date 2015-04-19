






<?php 

echo form_fieldset('请输入查看密码');



echo form_open('system_manage/soft_passwd/u'); ?>

<table width="400" align="center">
<tr><td colspan="2">&nbsp;</td></tr>
<tr >
	<td width="20%" align="right">密&nbsp;&nbsp;码：</td>
	<td width="80%" align="left">
	
		<?php	
	
		$data = array(
              'name'        => 'update_pw',
              'id'          => 'update_pw',
              'value'       => set_value("update_pw"),
              'maxlength'   => '100',
              'size'        => '50',
              'style'       => 'width:50%',
            );

			echo form_password($data);		
			echo form_error("update_pw","<div id='error_span'>","</div>");
		
	?>
	
	</td>
</tr>
<tr>
<td colspan="2" align="center"><?php echo form_submit('', '提交'); ?></td>

</tr>
</table>
<p>演示账户:
	密码:123456</p>


<?php 
echo form_close(); 
echo form_fieldset_close(); 
?>


