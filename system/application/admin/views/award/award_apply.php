<?php
$attr  = array('method'=>'post');
echo form_open("award/apply",$attr);?>
<table  align="center" class="table_search" >
<tr>
	<td>
	奖品名称：
	</td>
	<td>
	<input type="text" name="product_real_name" value="<?php echo set_value(null,$_POST['product_real_name']); ?>"  />
	</td>
	<td>
	申请日期：
	</td>
	<td>
	<input type="text" name="insert_date"  id="dd" onfocus="WdatePicker()"   value="<?php echo set_value(null,$_POST['insert_date']); ?>">
	</td>
	<td>
		<?php echo form_submit("submit","查询"); ?>
	</td>
</tr>
</table>
<?php echo  form_close();?>
<div class="mytheme1" align="left" ><span>兑奖申请</span></div>

<table class="mytable">
	<tr>
		<th>申请日期</th>
		<th>用户id</th>
		<th>奖品id</th>
		<th>所需金币</th>
		<th>状态</th>
		<th>处理日期</th>
		<th>操作</th>
	</tr>
	<?php foreach($list as  $k=>$v):?>
	<tr class="tr_center">
		<td><?php echo $v['itime'];?></td>
		<td><?php echo $v['user_id'];?></td>
		<td><?php echo $v['award_id'];?></td>
		<td><?php echo $v['expenditure'];?></td>
		<td><?php if($v['status']=='0') echo "兑换中";else echo "已兑换"?></td>	
		<td><?php echo $v['utime'];?></td>
		<td>
		
			<?php 
			$attrs = array(
				'class'=>'link_view',
			);
			echo anchor_popup("award/apply_view/".$v['id'],"&nbsp;",$attrs);
		?>
		<?php if($v['status']=='0')
		{?>
		<a href="<?php echo site_url("award/apply_edit/".$v['id']); ?>" onclick="return confirm('确定要兑换此奖品吗?');" class="link_mod">
			&nbsp;
		</a>
		<?php 
		}
		?>
		
		<a href="<?php echo site_url("award/apply_delete/".$v['id']); ?>" onclick="return confirm('确定删除?');" class="link_del">
			&nbsp;
		</a>
		
		
		</td>
	</tr>	
	<?php endforeach;?>
</table>
<div id="pagination">
<ul>
<?php echo $main['page_link'];?>
</ul>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('#dd').datebox({
	    formatter: function(date){ return date.getFullYear()+'-'+(date.getMonth()+1)+'-'+date.getDate();},
	    parser: function(date){ return new Date(Date.parse(date.replace(/-/g,"/")));}
	})
})
</script>