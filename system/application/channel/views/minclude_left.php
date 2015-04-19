	<div class="view_content">
	<div class="view_con_min_height"></div>
	<div class="view_con_left">	 
		<div class="user_info">
        <dl>
          <dt><img src="/image/member_bg_icon_jinbi.gif" width="26" height="17" /><strong>用户信息</strong></dt>
          <dd>
             欢迎您: <?=$this->session->userdata('user_name')?> 
             <a class="out" href="/index.php/system_manage/exit_system">退出</a>
          </dd>
          <dd> 金币: <?=($jt-$ysy)?></dd>
          <dd> 昨日获得:  <?=$zt?></dd>
          <dd> <a href="/index.php/award/user_award_info/1" class="yello">金币可以换iphone手机</a></dd>
        </dl>
		</div>
		<div class="user_menu">
		 <ul>
				<li class="<?=strstr($_SERVER['REQUEST_URI'],"user_award")?"hover":''?>"> <span class="icon_transaction"></span> <a href="/index.php/award/dollar_ch">金币兑换</a> </li>
				<li class="<?=strstr($_SERVER['REQUEST_URI'],"user_data")?"hover":''?>"> <span class="icon_money"></span> <a href="/index.php/award/mydollar/2">我的金币</a> </li>
				<li class="<?=strstr($_SERVER['REQUEST_URI'],"user_info")?"hover":''?>"> <span class="icon_info"></span> <a href="/index.php/users/userinfo">个人信息</a> </li>
			</ul>
    </div>
    </div>