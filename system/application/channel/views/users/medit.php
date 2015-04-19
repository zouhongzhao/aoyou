<?php
	echo form_fieldset("修改资料");
	echo form_open("users/channels_save");
?>
<script type="text/javascript" defer="defer" src="<?=base_url()?>js/area.js"></script>
<table>
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
	<td class="right">联系人：</td>
	<td class="left"><input type="text" name="main[names]"  value="<?php echo set_value("main[names]",$main['names']);?>" size="20"></td>
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
	<td class="right">用户地址：</td>
	<td class="left"><input type="text" name="main[us_address]"  value="<?php echo set_value('main[us_address]',$main['us_address']);?>"></td>
</tr>
<tr>
	<td class="right">银行信息：</td>
	<td class="left">
	<textarea type="text" name="main[bank]"  value="<?php echo set_value('main[bank]',$main['bank']);?>"></textarea>
	</td>
</tr>
<tr>
	<td class="right">用户备注信息：</td>
	<td class="left"><textarea name="main[note]" rows="3" cols="55"><?php echo set_value('main[note]',$main['note']);?></textarea></td>
</tr>
</table>
<input type="hidden" name="main[id]" value="<?php echo $main['id'];?>" size="50" />
<center>
<!--  	echo form_hidden("main[id]",$main['id']); -->
<!-- 	echo form_submit("submit","提交"); -->
<?php 
	echo form_submit("submit","提交");
	echo form_close();
	echo form_fieldset_close();
?>
</center>
</form>