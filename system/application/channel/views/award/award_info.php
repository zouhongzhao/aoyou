<div class="view_con_right">
		<div class="vcr_title">奖品兑换</div>
   		<div class="vcr_con">
    			<table width="99%" border="0" cellpadding="0" cellspacing="0" class="award_table">
             <tr>
              <td class="yello" width="100" align="center">奖品图片</td>
              <td align="center">&nbsp;</td>
             </tr>
             <tr>
              <td colspan="2" align="center" valign="middle">
              		<img src="<?=$main['award_thumbnail']?>" />
                  <br>
                  <strong><?=$main['award_name']?></strong>
              </td>
             </tr>
             <tr>
              <td align="center" class="yello">所需金币</td>
              <td><span class="purple">
               <?=$main['award_price']?>
              </span></td>
             </tr>
             <tr>
              <td align="center" class="yello">奖品说明</td>
              <td>&nbsp;</td>
             </tr>
             <tr>
              <td colspan="2"><?=$main['award_descrption']?></td>
             </tr>
         </table>
<br>
         <?
         if(($jt-$ysy)<$main['award_price']){
							echo "<span class='red'>您的金币还不够兑换此奖品</div>"; 
				 }
				 ?>
         <form action="<?=site_url()?>?award/apply_exp" method="post" onsubmit="return Validator(this)" name="FrontPage_Form1" id="awfrm">
         		<table width="99%" border="0">
                 <tr>
                  <td width="100" align="right">
										 <?
                     //	id,award_id,user_id,status,expenditure,itime,uptime
                     ?>
                  	 奖品收件人:
                  </td>
                  <td><input name="message_title" id="message_title" type="text" size="13" value="<?=$user['names']?>" /> 
                   *
                   <?php echo form_error("message_title",'<div id="error_span" class="red_font">', '</div>');	?>
                   </td>
                 </tr>
                 <tr>
                  <td align="right">联系电话:</td>
                  <td><label for="textfield"></label>
                  <input name="message_call" id="message_call" type="text" size="18" value="<?=$user['us_tel']?>" /> 
                  *
                   <?php echo form_error("message_call",'<div id="error_span" class="red_font">', '</div>');	?>
                  </td>
                 </tr>
                 <tr>
                  <td align="right">奖品收货地址:</td>
                  <td><label for="textarea"></label>
                  <textarea name="message_content" id="message_content" cols="50" rows="6"><?=$user['us_province'].$user['us_city'].$user['us_address']?></textarea>
                  *
                   <?php echo form_error("message_content",'<div id="error_span" class="red_font">', '</div>');	?>
                  </td>
                 </tr>
                 <tr>
                  <td colspan="2" align="right" height='5'>
                  		<input type="hidden" name="award_id" value="<?=$aid?>" />
                  		<input type="hidden" name="award_name" value="<?=$main['award_name']?>" />
                      <input type="hidden" name="user_id" value="<?=$this->session->userdata('u_name')?>" />
                      <input type="hidden" name="expenditure" id="expenditure" value="<?=$main['award_price']?>" />
                  </td>
                 </tr>
                 <tr>
                  <td>&nbsp;</td>
                  <td align="center"><input type="submit" name="submit1" id="submit1" value="提交兑换申请" /></td>
                 </tr>
            </table>
         </form>
   		</div>
	</div>
  <br clear="all" />
</div>
<script type="text/javascript">
function Validator(theForm)
{
	//var flag = false;//默认值为false
	 var title=document.getElementById("message_title");
	 var call=document.getElementById("message_call");
	 var content=document.getElementById("message_content");
	 if(title.value.length==0)
	 {
	 alert("奖品收件人不能为空!");
	 //flag = false;
		return false;
	 }
	 if(call.value.length<6 || call.value.length>12)
	 {
	 alert("联系电话长度必须在6~12之间!");
	 //flag = false;
	return false;
	 }
	 if(content.value.length<6 || content.value.length>255)
	 {
	 alert("收货地址必须在6~255之间!");
	 //flag = false;
	return false;
	 }
	 return true;
  //$('#awfrm').submit();
}
</script>