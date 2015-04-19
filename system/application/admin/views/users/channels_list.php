<div class="mytheme1" align="left" ><span>直属渠道账户管理</span><a href="<?php echo site_url("users/users_add/");?>" style="float: right;">添加直属渠道账户</a></div>
<table class="mytable">
	<tr>
		<th>渠道名</th>
		<th>单价</th>
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
		<td><?php echo $v['us_name']; ?></td>
		<td><?php echo $v['price']; ?></td>
		<td><?php echo $v['us_mail']; ?></td>
		<td><?php echo $v['us_tel']; ?></td>
		<td><?php echo $v['us_province']; ?></td>
		<td><?php echo $v['us_city']; ?></td>
		<td>直属渠道</td>
		<td><?php if($v['flag']=="0") echo "正常";else echo "锁定" ?></td>
		<td><?php echo $v['rtime']; ?></td>
		<td>
			<?php 
			$attrs  = array(
				'class'=>'link_mod',
			);
			echo anchor_popup('users/users_add/'.$v['id'],'&nbsp;',$attrs); ?>
			<a href="<?php echo site_url("users/users_delete/".$v['id']."");?>" onclick="return confirm('确认删除?');" class="link_del">&nbsp;</a>
			
		</td>
	
	</tr>
	<?php endforeach;?>
</table>
<div class="margin_25 center">
	<?php echo $page_link;?>
</div>