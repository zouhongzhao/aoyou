<?php
	echo form_fieldset("修改直属渠道数据");
 	echo form_open("tong_market/market_save");
?>
<table>
<tr>
	<td class="right">经销商名称：</td>
	<td class="left"><input type="text" name="main[u_id]"  value="<?php echo set_value('main[u_id]',$main['u_id']);?>" />
		<?php echo form_error("main[u_id]",'<div id="error_span" class="red_font">', '</div>');	?>	
	</td>
</tr>
<tr>
	<td class="right">所属渠道：</td>
	<td class="left"><input type="text" name="main[c_id]"  value="<?php echo set_value('main[c_id]',$main['c_id']);?>">
	</td>
</tr>

<tr>
	<td class="right">IP数：</td>
	<td class="left"><input type="text" name="main[ip_num]"  value="<?php echo set_value('main[ip_num]',$main['ip_num']);?>"></td>
</tr>
<tr>
	<td class="right">安装数：</td>
	<td class="left"><input type="text" name="main[install_num]"  value="<?php echo set_value('main[install_num]',$main['install_num']);?>"></td>
</tr>
<tr>
	<td class="right">启动次数：</td>
	<td class="left"><input type="text" name="main[starts_num]"  value="<?php echo set_value('main[starts_num]',$main['starts_num']);?>"></td>
</tr>
<tr>
	<td class="right">激活数：</td>
	<td class="left"><input type="text" name="main[activation]"  value="<?php echo set_value("main[activation]",$main['activation']);?>" size="20"></td>
</tr>
<tr>
	<td class="right">金额：</td>
	<td class="left"><input type="text" name="main[shouyis]"  value="<?php echo set_value("main[shouyis]",$main['shouyis']);?>" size="20"></td>
	
</tr>
<tr>
	<td class="right">日期：</td>
	<td class="left"><input type="text" name="main[dates]"  value="<?php echo set_value('main[dates]',$main['dates']);?>" size="20" maxlength="30"></td>
</tr>
</table>
<center>
<?php	
	echo form_hidden("main[id]",$main['id']);
	echo form_submit("submit","提交");
	echo form_close();
	echo form_fieldset_close();
?>
</center>
</form>