<div class="mytheme1" align="left" ><span>市场专员管理</span><a href="<?php echo site_url("users/market_add/");?>" style="float: right;">添加市场专员</a></div>
<table class="mytable">
	<tr>
		<th>登陆名</th>
		<th>联系人</th>
		<th>状态</th>
		<th>创建时间</th>
		<th>操作</th>
	</tr>
	<?php foreach($list as $v):?>
	<tr class="tr_center">
		<td><?php echo $v['us_mail']; ?></td>
		<td><?php echo $v['names']; ?></td>
		<td><?php if($v['flag']==0) echo "正常"; 
			else echo "锁定";
		?></td>
		<td><?php echo $v['rtime']; ?></td>
		<td>
			<?php 
			$attrs  = array(
				'class'=>'link_mod',
				'title' => '修改',
			);
			echo anchor_popup('users/users_edit/'.$v['id'].'/m','&nbsp;',$attrs); ?>
			<a href="<?php echo site_url("users/markets_delete/".$v['id']."");?>" onclick="return confirm('确认删除?');" class="link_del" title="删除">&nbsp;</a>
			
		</td>
	
	</tr>
	<?php endforeach;?>
</table>
<div id="pagination">
<ul>
<?php echo $page_link;?>
</ul>
</div>