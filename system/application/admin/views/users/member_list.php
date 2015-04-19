<div class="mytheme1" align="left" ><span>用户账户管理</span><a href="<?php echo site_url("users/users_add/");?>" style="float: right;">添加用户账户</a></div>
<table class="mytable">
	<tr>
		<th>经销商名</th>
		<th>所属渠道</th>
		<th>邮箱</th>
		<th>电话</th>
		<th>省</th>
		<th>城市/区</th>
		<th>身份</th>
		<th>状态</th>
		<th>创建时间</th>
		<th>操作</th>
	</tr>
	<?php foreach($list as $v):?>
	<tr class="tr_center">
		<td><?php echo $v['name']; ?></td>
		<td><?php echo $v['price']; ?></td>
		<td><?php echo $v['email']; ?></td>
		<td><?php echo $v['tel']; ?></td>
		<td><?php echo $v['province']; ?></td>
		<td><?php echo $v['city']; ?></td>
		<td><?php echo $v['type']; ?></td>
		<td><?php echo $v['lock']; ?></td>
		<td><?php echo $v['rtime']; ?></td>
		<td>
			<?php 
			$attrs  = array(
				'class'=>'link_mod',
			);
			echo anchor('users/users_add/'.$v['id'],'&nbsp;',$attrs); ?>
			<a href="<?php echo site_url("users/users_delete/".$v['id']."");?>" onclick="return confirm('确认删除?');" class="link_del">&nbsp;</a>
			
		</td>
	
	</tr>
	<?php endforeach;?>
</table>
<div class="margin_25 center">
	<?php echo $page_link;?>
</div>