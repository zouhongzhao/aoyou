<div class="mytheme1" align="left" >管理员账户</div>
<table class="mytable">
	<tr>
		<th>姓名</th>
		<th>邮箱</th>
		<th>电话</th>
		<th>联系人</th>
		<th>创建时间</th>
		<th>操作</th>
	</tr>
	<?php foreach($list as $v):?>
	<tr class="tr_center">
		<td><?php echo $v['admin_user']; ?></td>
		<td><?php echo $v['admin_email']; ?></td>
		<td><?php echo $v['admin_tel']; ?></td>
		<td><?php echo $v['admin_contact']; ?></td>
		<td><?php echo $v['admin_ctime']; ?></td>
		<td>
		<?php 
			$attrs  = array(
				'class'=>'link_add',
				'title' => '添加',
			);
			echo anchor('admins/admins_add','&nbsp;',$attrs); ?>
			<?php 
			$attrs  = array(
				'class'=>'link_mod',
				'title' => '修改',
			);
			echo anchor('admins/admins_add/'.$v['admin_id'],'&nbsp;',$attrs); ?>
			<a href="<?php echo site_url("admins/admins_delete/".$v['admin_id']."");?>" onclick="return confirm('确认删除?');" class="link_del" title="删除">&nbsp;</a>
			
		</td>
	
	</tr>
	<?php endforeach;?>
</table>
<div class="margin_25 center">
	<?php echo $page_link;?>
</div>