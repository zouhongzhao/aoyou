<?php
$attr  = array('method'=>'post');
echo form_open("tong_channels/day",$attr);?>
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
<div class="mytheme1" align="left" >按日统计</div>
<table class="mytable">
	<tr>
		<th>ID</th>
		<th>渠道名</th>
		<th>日期</th>
		<th>激活数</th>
		<th>安装数</th>
		
		<th>启动总数</th>
		<th>IP数</th>
		<th>激活/安装比例</th>
		<th>收益</th>
		<th>操作</th>
	</tr>
	<?php foreach($list as  $k=>$v):?>
	<tr class="tr_center">
		<td><?php echo $v['c_id'];?></td>
		<td><?php echo $v['us_name'];?></td>
		<td><?php echo $v['dates'];?></td>
		<td><?php echo $v['activations'];?></td>
		<td><?php echo $v['install_nums'];?></td>
		<td><?php echo $v['starts_nums'];?></td>
		<td><?php echo $v['ip_nums'];?></td>
		<td><?php if($v['install_nums']=='0') echo 0;else echo number_format($v['activations']/$v['install_nums'], 2, '.', '');?></td>
		<td><?php echo $v['shouyiss'];?></td>		
		<td>
			<?php 
			$attrs  = array(
				'class'=>'link_mod',
			);
			echo anchor_popup('tong_channels/channels_edit/'.$v['id'],'&nbsp;',$attrs); ?>
			<a href="<?php echo site_url("tong_channels/channels_delete/".$v['id']."");?>" onclick="return confirm('确认删除?');" class="link_del">&nbsp;</a>
			
		</td>
	</tr>	
	<?php endforeach;?>
</table>
<div id="pagination">
<ul>
<?php echo $page_link;?>
</ul>
</div>
	