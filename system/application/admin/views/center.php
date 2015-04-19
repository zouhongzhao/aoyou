<!-- <script type="text/javascript"> -->
<!-- if($.browser.msie) { -->
<!-- 	document.execCommand("BackgroundImageCache", false, true); -->
<!-- } -->
<!-- </script> -->

<body class="easyui-layout" style="width:100%;height:100%;margin:0;padding:0;">

	<div region="west" split="true" title="菜单" style="width:165px;">
			<div class="easyui-panel"   animated="easeslide"   fit="false" border="false">
					<p style="padding: 0 1px;font-weight: bold;">账户管理&nbsp;</p>
					<p><?php  echo anchor('admins/admins_list', '管理员账户', array('title' => '管理员账户','target'=>'__myframe','class'=>'admin'));?>&nbsp;</p>
					<p><?php  echo anchor('users/channels_list', '直属渠道账户管理', array('title' => '直属渠道账户管理','target'=>'__myframe','class'=>'admin'));?>&nbsp;</p>
					
					<p style="padding: 0 1px;font-weight: bold;">统计数据汇总&nbsp;</p>
					<p><?php  echo anchor('tong_all/day', '每天数据汇总', array('title' => '每天数据汇总','target'=>'__myframe','class'=>'admin'));?>&nbsp;</p>
					<p><?php  echo anchor('tong_all/month', '每月数据汇总', array('title' => '每月数据汇总','target'=>'__myframe','class'=>'admin'));?>&nbsp;</p>
					<p><?php  echo anchor('tong_all/history', '历史数据汇总', array('title' => '历史数据汇总','target'=>'__myframe','class'=>'admin'));?>&nbsp;</p>
					
					<p style="padding: 0 1px;font-weight: bold;">直属渠道统计数据&nbsp;</p>
					<p><?php  echo anchor('tong_channels/day/2', '按日统计', array('title' => '按日统计','target'=>'__myframe','class'=>'admin'));?>&nbsp;</p>
					<p><?php  echo anchor('tong_channels/month/2', '按月统计', array('title' => '按月统计','target'=>'__myframe','class'=>'admin'));?>&nbsp;</p>
					<p><?php  echo anchor('tong_channels/history/2', '历史统计', array('title' => '历史统计','target'=>'__myframe','class'=>'admin'));?>&nbsp;</p>
	
					<p style="padding: 0 1px;font-weight: bold;">市场部统计数据&nbsp;</p>
					<p><?php  echo anchor('tong_market/day', '按日统计', array('title' => '按日统计','target'=>'__myframe','class'=>'admin'));?>&nbsp;</p>
					<p><?php  echo anchor('tong_market/month', '按月统计', array('title' => '按月统计','target'=>'__myframe','class'=>'admin'));?>&nbsp;</p>
					<p><?php  echo anchor('tong_market/history/2', '历史统计', array('title' => '历史统计','target'=>'__myframe','class'=>'admin'));?>&nbsp;</p>
			
					
					<p style="padding: 0 1px;font-weight: bold;">备注统计数据&nbsp;</p>
					<p><?php  echo anchor('tong_remark/day/2', '按日统计', array('title' => '按日统计','target'=>'__myframe','class'=>'admin'));?>&nbsp;</p>
						
				<p style="padding: 0 1px;font-weight: bold;">版本查看数据&nbsp;</p>
					<p><?php  echo anchor('tong_version/day/2', '按日统计', array('title' => '按日统计','target'=>'__myframe','class'=>'admin'));?>&nbsp;</p>
					
				<p style="padding: 0 1px;font-weight: bold;">访问记录&nbsp;</p>
					<p><?php  echo anchor('tong_browse/all/2', '浏览记录报表', array('title' => '浏览记录列表','target'=>'__myframe','class'=>'admin'));?>&nbsp;</p>

				<p style="padding: 0 1px;font-weight: bold;">奖品管理&nbsp;</p>
					<p><?php  echo anchor('award/award_list/2', '奖品添加管理', array('title' => '奖品管理','target'=>'__myframe','class'=>'admin'));?>&nbsp;</p>
					<p><?php  echo anchor('award/award_apply', '兑换申请', array('title' => '兑换申请','target'=>'__myframe','class'=>'admin'));?>&nbsp;</p>

				<p style="padding: 0 1px;font-weight: bold;">系统设置</p>
					<p><?php  echo anchor('system_manage/soft_passwd', '软件更新', array('title' => '软件更新','target'=>'__myframe','class'=>'admin'));?>&nbsp;</p>
					<p><?php  echo anchor('system_manage/db_backup', '备份数据库', array('title' => '备份数据库','target'=>'__myframe','class'=>'admin','onclick'=>"return confirm('确认要备份数据库吗?');"));?>&nbsp;</p>
					<p><?php  echo anchor('system_manage/change_password', '修改密码', array('title' => '修改密码','target'=>'__myframe','class'=>'admin'));?>&nbsp;</p>
					<p><?php  echo anchor('system_manage/exit_system', '退出系统', array('title' => '退出系统','target'=>'_parent','class'=>'admin'));?>&nbsp;</p>

			</div>
		</div>
		<div region="center"    title="主窗口" style="background:#ffffff;" border="false" >
				<iframe src="<?php echo site_url("admins/admins_list");?>" name="__myframe" width="100%" height="100%" frameborder="0" scrolling="auto"></iframe>
		
		</div>

</body>