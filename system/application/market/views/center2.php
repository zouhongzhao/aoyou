<body class="easyui-layout" style="width:100%;height:768px;margin:0;padding:0;">



	<div region="west" split="true" title="菜单" style="width:150px;">
			<div class="easyui-accordion"   animated="easeslide"   fit="false" border="false">
				<div title="渠道管理"  icon="icon-uesrs" selected="true" style="padding:10px;">
					<p><?php  echo anchor('users/mchannels_list', '渠道列表', array('title' => '渠道列表','target'=>'__myframe',));?>&nbsp;</p>
				</div>
					<div title="数据统计"  icon="icon-uesrs" selected="true" style="padding:10px;">
					<p><?php  echo anchor('tong_market2/day', '按日统计', array('title' => '按日统计','target'=>'__myframe',));?>&nbsp;</p>
					<p><?php  echo anchor('tong_market2/month', '按月统计', array('title' => '按月统计','target'=>'__myframe',));?>&nbsp;</p>
					<p><?php  echo anchor('tong_market2/history/2', '历史统计', array('title' => '历史统计','target'=>'__myframe',));?>&nbsp;</p>
				</div>

				<div title="系统设置"  icon="icon-system" selected="true" style="padding:10px;">
					<p><?php  echo anchor('system_manage/change_password', '修改密码', array('title' => '修改密码','target'=>'__myframe',));?>&nbsp;</p>
					<p><?php  echo anchor('system_manage/exit_system', '退出系统', array('title' => '退出系统','target'=>'_parent'));?>&nbsp;</p>
				</div>	
			</div>
		</div>
		<div region="center"    title="主窗口" style="background:#ffffff;" border="false" >
				<iframe src="<?php echo site_url("users/mchannels_list");?>" name="__myframe" width="100%" height="100%" frameborder="0" scrolling="auto"></iframe>
		
		</div>

</body>