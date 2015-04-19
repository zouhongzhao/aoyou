<div class="view_con_right">
		<div class="vcr_title">金币兑换</div>
   <div class="vcr_con">
    		<div class="vcr_ctab">
        		<a class="hover" href="javascript:">奖品列表</a>
        		<a href="/index.php/award/user_award_consumption">金币花费</a>
        </div>
        <div class="vcr_ctab_bottom"></div>
    		<ul class="award">
			<?php foreach($list as  $k=>$v):?>
        		<li>
            			<a title="<?=$v['award_title'];?>" href="/index.php/award/user_award_info/<?=$v['id'];?>">
                  		<img src="<?=$v['award_thumbnail'];?>" />
                  		<div class='conversion'>
                      		<div class="award_name"><?=$v['award_name'];?></div>
                          <span class="menu11"></span>
                          <span class="money"><?=$v['award_price'];?></span>
                          金币
                      </div>                  
                  </a>
            </li>
		<?php endforeach;?>
        </ul>
  <div id="pagination">
<ul>
<?php echo $main['page_link'];?>
</ul>
</div>
   </div>
	</div>
  <br clear="all" />
</div>