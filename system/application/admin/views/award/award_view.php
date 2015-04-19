<center>奖品查看</center>
<table>
<tr>
	<td class="right">奖品名称：</td>
	<td class="left"><input type="text" name="main[award_name]"  value="<?php echo $main['award_name'];?>" />
	</td>
</tr>

<tr>
	<td class="right">奖品说明：</td>
	<td class="left"><textarea name="main[award_title]"><?php echo $main['award_title'];?></textarea></td>
</tr>
<tr>
	<td class="right">奖品图片：</td>
	<td class="left"><img src="<?php echo $main['award_thumbnail'];?>"/>
	</td>
</tr>
<tr>
	<td class="right">奖品所需金币：</td>
	<td class="left"><input type="text" name="main[award_price]"  value="<?php echo $main['award_price'];?>"></td>
</tr>
<tr>
	<td class="right">标签：</td>
	<td class="left"><input type="text" name="main[award_tab]"  value="<?php echo $main['award_tab'];?>"></td>
</tr>
<tr>
	<td class="right">奖品介绍：</td>
	<td class="left"><?php echo $main['award_descrption'];?></td>
</tr>
</table>
</table>
<div class="margin_25 center">
	<a href="javascript:window.close();">[关闭]</a>
</div>

