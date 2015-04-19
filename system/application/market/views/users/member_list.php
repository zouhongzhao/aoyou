<div class="mytheme1" align="left" ><span>用户账户管理</span></div>
<table class="mytable">
	<tr>
		<th>归属渠道</th>
		<th>用户ID</th>
		<th>单价</th>
		<th>登陆名</th>
		<th>联系人</th>
		<th>省</th>
		<th>市</th>
		<th>状态</th>
		<th>操作</th>
	</tr>
	<?php foreach($list as $v):?>
	<tr class="tr_center">
		<td><?php echo $v['belongs_channels']; ?></td>
		<td><?php echo $v['us_name']; ?></td>
		<td><?php echo $v['price']; ?></td>
		<td><?php echo $v['us_mail']; ?></td>
		<td><?php echo $v['names']; ?></td>
		<td><?php echo $v['us_province']; ?></td>
		<td><?php echo $v['us_city']; ?></td>
		<td><?php if($v['flag']==0) echo "正常"; 
			else echo "锁定";
		?></td>
		<td>
			<?php 
			$attrs  = array(
				'class'=>'link_mod',
				'title' => '修改',
			);
			echo anchor_popup('users/users_edit/'.$v['id'].'/u','&nbsp;',$attrs); ?>
			<a href="<?php echo site_url("users/member_delete/".$v['id']."");?>" onclick="return confirm('确认删除?');" class="link_del" title="删除">&nbsp;</a>
			
		</td>
	
	</tr>
	<?php endforeach;?>
</table>
<div id="pagination">
<ul>
<?php echo $page_link;?>
</ul>
</div>