<center>奖品查看</center>
<table>
<tr>
	<td class="right">奖品名称：</td>
	<td class="left"><input type="text" name="main[award_name]"  value="<?php echo $award_name;?>" />
	</td>
</tr>
<tr>
	<td class="right">奖品图片：</td>
	<td class="left"><img src="<?php echo $award_thumbnail;?>"/>
	</td>
</tr>
<tr>
	<td class="right">奖品所需金币：</td>
	<td class="left"><input type="text" name="main[award_price]"  value="<?php echo $award_price;?>"></td>
</tr>
<tr>
	<td class="right">申请者ID：</td>
	<td class="left"><input type="text" name="main[user_id]"  value="<?php echo $user_id;?>"></td>
</tr>
<tr>
	<td class="right">状态：</td>
	<td class="left"><input type="text" name="main[status]"  value="<?php if($status=='0') echo "兑换中";else echo "已兑换";?>"></td>
</tr>
</table>
</table>
<div class="margin_25 center">
	<a href="javascript:window.close();">[关闭]</a>
</div>

