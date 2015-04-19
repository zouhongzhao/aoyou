<?php
$attr  = array('method'=>'post');
echo form_open("tong_channels/month",$attr);?>
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
	<input type="text" name="insert_date"  id="dd1" onfocus="WdatePicker({skin:'whyGreen',dateFmt: 'yyyy-MM' })" value="<?php echo set_value(null,$_POST['insert_date']); ?>">
	</td>
	<td>
		<?php echo form_submit("submit","查询"); ?>
	</td>
</tr>
</table>
<?php echo  form_close();?>
<div class="mytheme1" align="left" >按月统计</div>
<table class="mytable">
	<tr>
		<th>ID</th>
		<th>渠道名</th>
		<th>日期</th>
		<th>激活数</th>
		<th>安装数</th>
		<th>激活/安装比例</th>
		<th>收益</th>
	</tr>
	<?php foreach($list as  $k=>$v):?>
	<tr class="tr_center">
		<td><?php echo $v['c_id'];?></td>
		<td><?php echo $v['us_name'];?></td>
		<td><?php echo $v['dates'];?></td>
		<td><?php echo $v['activations'];?></td>
		<td><?php echo $v['install_nums'];?></td>
		<td><?php if($v['install_nums']=='0') echo 0;else echo number_format($v['activations']/$v['install_nums'], 2, '.', '');?></td>
		<td><?php echo $v['shouyiss'];?></td>		
		
	</tr>	
	<?php endforeach;?>
</table>
<div id="pagination">
<ul>
<?php echo $page_link;?>
</ul>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('#dd').datebox({
	    formatter: function(date){ return date.getFullYear()+'-'+(date.getMonth()+1);},
	    parser: function(date){ return new Date(Date.parse(date.replace(/-/g,"/")));}
	})
})
</script>