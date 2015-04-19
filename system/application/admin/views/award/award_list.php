<?php
$attr  = array('method'=>'post');
echo form_open("award/award_list",$attr);?>
<table  align="center" class="table_search" >
<tr>
	<td>
	奖品名称：
	</td>
	<td>
	<input type="text" name="product_real_name" value="<?php echo set_value(null,$_POST['product_real_name']); ?>"  />
	</td>
	<td>
	日期：
	</td>
	<td>
	<input type="text" name="insert_date"  id="dd" onfocus="WdatePicker()" value="<?php echo set_value(null,$_POST['insert_date']); ?>">
	</td>
	<td>
		<?php echo form_submit("submit","查询"); ?>
	</td>
</tr>
</table>
<?php echo  form_close();?>
<div class="mytheme1" align="left" ><span>奖品管理</span><a href="<?php echo site_url("award/award_add/");?>" style="float: right;">添加奖品</a></div>

<table class="mytable">
	<tr>
		<th>日期</th>
		<th>奖品名称</th>
		<th>所需金币</th>
		<th>标签</th>
		<th>操作</th>
	</tr>
	<?php foreach($list as  $k=>$v):?>
	<tr class="tr_center">
		<td><?php echo $v['udate'];?></td>
		<td><?php echo $v['award_name'];?></td>
		<td><?php echo $v['award_price'];?></td>
		<td><?php echo $v['award_tab'];?></td>	
		<td>
		
			<?php 
			$attrs = array(
				'class'=>'link_view',
			);
			echo anchor_popup("award/award_view/".$v['id'],"&nbsp;",$attrs);
			
			$attrs = array(
				'class'=>'link_mod',
			);
			echo anchor_popup("award/award_add/".$v['id'],"&nbsp;",$attrs);
		?>
		<a href="<?php echo site_url("award/award_delete/".$v['id']); ?>" onclick="return confirm('确定删除?');" class="link_del">
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