		<link rel="stylesheet" type="text/css" href="/css/member/style.css"/>
		<div class="user_info">
        <dl>
          <dt><img src="../image/member_bg_icon_jinbi.gif" width="26" height="17" /><strong>用户信息</strong></dt>
          <dd>
             欢迎您: <?=$_SESSION['sess_member']?> 
             <a class="out" href="../logout.php">退出</a>
          </dd>
          <dd> 金币: <?=$user_jinbi-$user_user_jinbi?></dd>
          <dd> 昨日获得:  <?=$user_yesterday_jinbi?></dd>
          <dd> <a href="user_award_info.php?aid=1" class="yello">金币可以换iphone手机</a></dd>
        </dl>
		</div>
		<div class="user_menu">
		 <ul>
				<li class="<?=strstr($_SERVER['REQUEST_URI'],"user_award")?"hover":''?>"> <span class="icon_transaction"></span> <a href="user_award_list.php">金币兑换</a> </li>
				<li class="<?=strstr($_SERVER['REQUEST_URI'],"user_data")?"hover":''?>"> <span class="icon_money"></span> <a href="user_data.php">我的金币</a> </li>
				<li class="<?=strstr($_SERVER['REQUEST_URI'],"user_info")?"hover":''?>"> <span class="icon_info"></span> <a href="user_info.php">个人信息</a> </li>
			</ul>
    </div>