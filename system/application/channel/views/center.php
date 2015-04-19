<body class="easyui-layout" style="width:100%;height:768px;margin:0;padding:0;">



	<div region="west" split="true" title="菜单" style="width:150px;">
					<div title="账户管理"  icon="icon-uesrs" style="padding:10px;">
					<p><?php  echo anchor('users/index', '首页', array('title' => '首页','target'=>'__myframe',));?>&nbsp;</p>
					<p><?php  echo anchor('tong_channel/day', '数据统计', array('title' => '数据统计','target'=>'__myframe',));?>&nbsp;</p>
					<p><?php  echo anchor('users/muserinfo', '用户资料', array('title' => '用户资料','target'=>'__myframe',));?>&nbsp;</p>
					<p><?php  echo anchor('system_manage/change_password', '密码设定', array('title' => '密码设定','target'=>'__myframe',));?>&nbsp;</p>
					<p><?php  echo anchor('system_manage/change_password', '消息记录', array('title' => '消息记录','target'=>'__myframe',));?>&nbsp;</p>
					<p><?php  echo anchor('system_manage/exit_system', '退出', array('title' => '退出','target'=>'_parent',));?>&nbsp;</p>
			
				</div>
	</div>
		<div region="center"    title="主窗口" style="background:#ffffff;" border="false" >
				<iframe src="<?php echo site_url("tong_channel/day");?>" name="__myframe" width="100%" height="100%" frameborder="0" scrolling="auto"></iframe>
		
		</div>

</body>