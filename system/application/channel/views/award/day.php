<div class="view_con_right">
		<div class="vcr_title">
					<a href="javascript:;">我的金币</a>
		</div>
<?php
$attr  = array('method'=>'post');
echo form_open("award/mydollar",$attr);?>
<table  align="center" class="table_search" >
<tr>
	<td>
	日期：
	</td>
	<td>
	<input type="text" name="insert_date"  onfocus="WdatePicker({skin:'whyGreen',dateFmt: 'yyyy-MM' })"  value="<?php echo set_value(null,$_POST['insert_date']); ?>">
	</td>
	<td>
		<?php echo form_submit("submit","查询"); ?>
	</td>
</tr>
</table>
<?php echo  form_close();?>
<div class="mytheme1" align="left" >数据查看</div>
<table class="mytable">
	<tr>
		<th>日期</th>
		<th>经销商号</th>
		<th>激活量</th>
		<th>金币</th>
	</tr>
	<?php foreach($list as  $k=>$v):?>
	<tr class="tr_center">
		<td><?php echo $v['dates'];?></td>
		<td><?php echo $v['u_id'];?></td>
		<td><?php echo $v['activations'];?></td>
		<td><?php echo $v['shouyiss'];?></td>		
	</tr>	
	<?php endforeach;?>
</table>
<div id="pagination">
<ul>
<?php echo $page_link;?>
</ul>
</div>
</div>