<link rel="stylesheet" type="text/css" href="/css/member/style.css"/>

		<div style="text-align:center;padding:20px 0;line-height:20px;">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td width="5%">&nbsp;</td>
					<td align="center"><img src="/image/lock_welcome.jpg" /></td>
					<td align="left">
					当前时间: <?=date("Y-m-d H:i:s")?>
					<br />
					<strong><?=$_SESSION['sess_member']?></strong>
					
					<br />
					欢迎进入数据查看中心!
					</td>
					<td width="5%">&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td colspan="2" align="right" style="height:25px;background-image:url(/image/tr_bg.jpg);padding-right:24px;font-weight:bold;font-size:14px;color:#fff;line-height:23px;">您的相关信息</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td colspan="2">
					<div style="line-height:20px;margin-left:40px;">
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td width="80" align="right">登录账号：</td>
								<td align="left" class="purple"><?=$us_mail?></td>
								</tr>
							<tr>
								<td align="right">联系人：</td>
								<td align="left" class="purple"><?=$names?></td>
								</tr>
							<tr>
								<td align="right">联系电话： </td>
								<td align="left" class="purple"><?=$us_tel?></td>
							</tr>
							<tr>
								<td align="right">QQ：</td>
								<td align="left" class="purple"><?=$us_qq?></td>
							</tr>
							<tr>
								<td align="right"> 
添加时间：</td>
								<td align="left" class="purple"><?=$rtime?></td>
								</tr>
						</table>
					</div>
					</td>
					<td>&nbsp;</td>
				</tr>
			</table>

		</div>