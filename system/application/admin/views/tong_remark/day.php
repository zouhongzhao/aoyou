<?php
$attr  = array('method'=>'post');
echo form_open("tong_remark/day",$attr);?>
<table  align="center" class="table_search" >
<tr>
	<td>
	备注号：
	</td>
	<td>
	<input type="text" name="remark"  id="dd" value="<?php echo set_value(null,$_POST['remark']); ?>">
	</td>
		<td>
	日期：
	</td>
	<td>
	<input type="text" name="insert_date"  id="dd1" onfocus="WdatePicker()" value="<?php echo set_value(null,$_POST['insert_date']); ?>">
	</td>
	<td>
		<?php echo form_submit("submit","查询"); ?>
	</td>
</tr>
</table>
<?php echo  form_close();?>
<div class="mytheme1" align="left" >备注统计数据</div>
<table class="mytable">
	<tr>
		<th>备注号</th>
		<th>ID</th>
		<th>日期</th>
		<th>激活数</th>
		<th>安装数</th>
		<th>活跃数</th>
	</tr>
	<?php foreach($list as  $k=>$v):?>
	<tr class="tr_center">
		<td><?php echo $v['remark'];?></td>
		<td><?php echo $v['u_id'];?></td>
		<td><?php echo $v['dates'];?></td>
		<td><?php echo $v['activation'];?></td>
		<td><?php echo $v['install'];?></td>
		<td><?php echo $v['starts'];?></td>
	</tr>	
	<?php endforeach;?>
</table>
<div id="pagination">
<ul>
<?php echo $page_link;?>
</ul>
</div>
	