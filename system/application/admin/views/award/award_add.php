
<link href="<?php echo base_url();?>js/swf/default.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>js/swfup/swfupload/swfupload.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/swfup/js/swfupload.queue.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/swfup/js/fileprogress.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/swfup/js/handlers.js"></script>
<script type="text/javascript">
		var swfu;
		window.onload = function() {
			var settings = {
				flash_url : "<?php echo base_url();?>js/swfup/swfupload/swfupload.swf",
				upload_url: "<?php echo base_url();?>index.php/award/upLoadPhoto",	// Relative to the SWF file
				post_params: {"PHPSESSID" : "<?php echo session_id(); ?>"},
				file_size_limit : "2 MB",
				file_types : "*.jpg;*.gif;*.jpg;*.png;*.jpeg;*.bmp",    //allow file types
				file_types_description : "All Files",
				file_upload_limit : 10,
				file_queue_limit : 0,
				custom_settings : {
					progressTarget : "fsUploadProgress",
					cancelButtonId : "btnCancel",
					img:'imgurl'
				},
				debug: false,

				// Button settings
				button_image_url: "<?php echo base_url();?>js/swf/TestImageNoText_65x29.png",	// Relative to the Flash file
				button_width: "65",
				button_height: "29",
				button_placeholder_id: "spanButtonPlaceHolder",
				button_text: '<span class="theFont">文件选择</span>',
				button_text_style: ".theFont { font-size: 12; }",
				button_text_left_padding: 12,
				button_text_top_padding: 3,

				// The event handler functions are defined in handlers.js
				file_queued_handler : fileQueued,
				file_queue_error_handler : fileQueueError,
				file_dialog_complete_handler : fileDialogComplete,
				upload_start_handler : uploadStart,
				upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : uploadSuccess,
				upload_complete_handler : uploadComplete,
				queue_complete_handler : queueComplete	
			};

			swfu = new SWFUpload(settings);
	     };
	</script>
<?php
	echo form_fieldset("添加奖品");
	echo form_open("award/award_save",array("id"=>"form1","enctype"=>"multipart/form-data"));
?>
<table>
<tr>
	<td class="right">奖品名称：</td>
	<td class="left"><input type="text" name="main[award_name]"  value="<?php echo set_value('main[award_name]',$main['award_name']);?>" />
	
		<?php echo form_error("main[award_name]",'<div id="error_span" class="red_font">', '</div>');	?>	
	
	
	</td>
</tr>

<tr>
	<td class="right">奖品说明：</td>
	<td class="left"><textarea name="main[award_title]"></textarea></td>
</tr>
<tr>
	<td class="right">奖品图片：</td>
	<td class="left">
		<p>&nbsp;</p>
<div class="fieldset flash" id="fsUploadProgress">
			<span class="legend">文件上传</span>
		</div>
		<div id="divStatus">0 个文件已上传</div>
		<div id="divMovieContainer">
			<span id="spanButtonPlaceHolder"></span>
		<input id="btnCancel" type="button" value="取消所有上传" onclick="swfu.cancelQueue();" disabled="disabled" style="margin-left: 2px; font-size: 8pt; height: 29px;" />
		<input type="hidden" name="main[award_thumbnail]" id="imgurl" />
		</div>
	</td>
</tr>
<tr>
	<td class="right">奖品所需金币：</td>
	<td class="left"><input type="text" name="main[award_price]"  value="<?php echo set_value('main[award_price]',$main['award_price']);?>"></td>
</tr>
<tr>
	<td class="right">标签：</td>
	<td class="left"><input type="text" name="main[award_tab]"  value="<?php echo set_value('main[award_tab]',$main['award_tab']);?>"></td>
</tr>
<tr>
	<td class="right">奖品介绍：</td>
	<td class="left"><textarea id="main[award_descrption]" name="main[award_descrption]" style="display:none;"></textarea><?php echo $this->ckeditor->replace("main[award_descrption]");?></td>
</tr>
</table>
<center>
<?php	
	echo form_hidden("main[id]",$main['id']);
	echo form_submit("submit","提交");
	echo form_close();
	echo form_fieldset_close();
?>
</center>