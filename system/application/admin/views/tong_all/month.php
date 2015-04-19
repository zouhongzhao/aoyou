<div class="mytheme1" align="left" >每月数据汇总</div>
<table class="mytable">
	<tr>
		<th>日期</th>
		<th>活跃台数</th>
		<th>安装总数</th>
		<th>激活总数</th>
		<th>激活/安装比例</th>
	</tr>
	<?php foreach($list as  $k=>$v):?>
	<tr class="tr_center">
		<td><?php echo $v['df'];?></td>
		<td><?php echo $v['starts_nums'];?></td>
		<td><?php echo $v['install_nums'];?></td>
		<td><?php echo $v['activations'];?></td>
		<td><?php echo number_format($v['activations']/$v['install_nums'], 2, '.', '');?></td>		
		
	</tr>	
	<?php endforeach;?>
</table>
<div class="center margin_25">
	<?php echo $page_link;?>
</div>