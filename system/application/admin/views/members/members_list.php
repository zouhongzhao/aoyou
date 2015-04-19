<div class="mytheme1" align="left" >会员管理</div>
<table class="mytable">
	<tr>
		<th>姓名</th>
		<th>性别</th>
		<th>手机</th>
		<th>QQ</th>
		<th>备注</th>
		<th>操作</th>
	</tr>
	<?php foreach($list as $v):?>
	<tr class="tr_center">
		<td><?php echo $v['member_name']; ?></td>
		<td><?php echo $v['sex_str']; ?></td>
		<td><?php echo $v['mobile']; ?></td>
		<td><?php echo $v['qq']; ?></td>
		<td><?php echo $v['remarks']; ?></td>
		<td>
			<?php 
			$attrs  = array(
				'class'=>'link_mod',
			);
			echo anchor('members/member_add/'.$v['member_id'],'&nbsp;',$attrs); ?>
			<a href="<?php echo site_url("members/member_delete/".$v['member_id']."");?>" onclick="return confirm('确认删除?');" class="link_del">&nbsp;</a>
			
		</td>
	
	</tr>
	<?php endforeach;?>
</table>
<div class="margin_25 center">
	<?php echo $page_link;?>
</div>