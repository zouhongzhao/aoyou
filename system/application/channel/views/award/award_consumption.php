<div class="view_con_right">
		<div class="vcr_title">奖品列表</div>
   <div class="vcr_con">
    		<div class="vcr_ctab">
        		<a href="/index.php/award/dollar_ch">奖品列表</a>
        		<a class="hover" href="javascript:;">金币花费</a>
        </div>
        <div class="vcr_ctab_bottom"></div>
        <br/>
       	<table width="98%" border="0" cellpadding="0" cellspacing="0" class="award_table">
           <tr>
                <td>已消费：<?=$count-$dhz?></td>
                <td>兑换中：<?=empty($dhz)? '0' : $dhz?></td>
                <td>总计：<?=empty($count)? '0' : $count?></td>
           </tr>
      		 <tr>
                <td>总金币：<?=$jt?></td>
                <td>可用金币：<?=$jt-$ysy?></td>
                <td></td>
           </tr>

        </table>
    		<div id="nr_cs"><table class="mytable">
	<tr>
		<th>兑换日期</th>
		<th>奖品名称</th>
		<th>状态</th>
		<th>花费</th>
	</tr>
	<?php foreach((array)$list as  $k=>$v):?>
	<tr class="tr_center">
		<td><?php echo $v['itime'];?></td>
		<td><?php echo $v['award_name'];?></td>
		<td><?php if($v['status']=='0') echo "兑换中";else echo "已兑换"?></td>
		<td><?php echo $v['expenditure'];?></td>		
	</tr>	
	<?php endforeach;?>
</table>
<div id="pagination">
<ul>
<?php echo $page_link;?>
</ul>
</div></div>
   </div>
	</div>
  <br clear="all" />
</div>