<?php
$attr  = array('method'=>'post');
echo form_open("tong_browse/all",$attr);?>
<table  align="center" class="table_search" >
<tr>
	<td>
	日期：
	</td>
	<td>
	<input type="text" name="insert_date"  onfocus="WdatePicker()"  value="<?php echo set_value(null,$_POST['insert_date']); ?>">
	</td>
	<td>
		<?php echo form_submit("submit","查询"); ?>
	</td>
</tr>
</table>
<?php echo  form_close();?>
<div class="mytheme1" align="left" >浏览记录报表</div>
<table class="mytable">
	<tr>

		<th>日期</th>
		<th>URL地址</th>
		<th>次数</th>
	</tr>
	<?php foreach($list as  $k=>$v):?>
	<tr class="tr_center">
		
		<td><?php echo $v['u_date'];?></td>
		<td><?php echo $v['url_address'];?></td>
		<td><?php echo $v['url_number'];?></td>
		
	</tr>	
	<?php endforeach;?>
</table>
<div id="pagination">
<ul>
<?php echo $page_link;?>
</ul>
</div>