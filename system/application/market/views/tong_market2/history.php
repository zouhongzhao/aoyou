<?php
$attr  = array('method'=>'get');
echo form_open("tong_channels/history",$attr);?>
<table  align="center" class="table_search" >
<tr>
	<td>
	渠道名：
	</td>
	<td>
	<input type="text" name="channel_name"  id="dd" value="<?php echo set_value(null,$_POST['channel_name']); ?>">
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
<div class="mytheme1" align="left" >每天数据汇总</div>
<table class="mytable">
	<tr>

		<th>日期</th>
		<th>激活数</th>
		<th>安装数</th>
		<th>激活/安装比例</th>
	</tr>
	<?php foreach($list as  $k=>$v):?>
	<tr class="tr_center">
		
		<td><?php echo $v['dates'];?></td>
		<td><?php echo $v['activations'];?></td>
		<td><?php echo $v['installs'];?></td>
		<td><?php if($v['installs']=='0') echo 0;else echo number_format($v['activations']/$v['install_nums'], 2, '.', '');?></td>
		
	</tr>	
	<?php endforeach;?>
</table>
<div class="center margin_25">
	<?php echo $page_link;?>
</div>