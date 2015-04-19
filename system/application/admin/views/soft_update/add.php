
<script type="text/javascript" src="<?php echo base_url();?>js/ajaxfileupload.js"></script>
<style>
a.fl {position:relative;overflow:hidden;padding: 0 4px;display:inline-block;color:#005197;text-decoration:underline;vertical-align:bottom;*vertical-align:auto}
a.fl input {position:absolute;right:0;top:0;height:100px;opacity:0;filter:alpha(opacity=0);cursor:pointer;cursor:hand}
a.fl:hover {color:#f65100}
</style>
<img id="loading" src="<?php echo base_url();?>js/loading.gif" style="display:none;">
<?php
	echo form_fieldset("软件更新");
	echo $error;
	echo form_open("system_manage/file_save",array("id"=>"form1","enctype"=>"multipart/form-data"));
?>
<table>
<tr>
	<td class="right">版本号：</td>
	<td class="left"><input type="text" name="version"  value="<?php echo $list[0];?>" />
	*
		<?php echo form_error("version",'<div id="error_span" class="red_font">', '</div>');	?>	
	</td>
</tr>
<tr>
	<td class="right">渠道名：</td>
	<td class="left"><input type="text" name="channels"  value="<?php echo $list[1];?>" />
	*
		<?php echo form_error("channels",'<div id="error_span" class="red_font">', '</div>');	?>	
	</td>
</tr>
<tr>
	<td class="right">驱动文件下载：</td>
	<td class="left">
	<input style="width:400px;" type="text" name="drives1"  id="drives1" value="<?php echo $list[2];?>">
	<a class="fl">选择文件
	<input type="file" name="drives"  id="drives"></a>
	*
	<a style="cursor:pointer;color:#005197" id="qd" onclick="return ajaxFileUpload();">上传</a>
	*
	<a href="<?php echo $list[1];?>">下载</a>
	</td>
</tr>
<tr>
	<td class="right">逻辑文件下载：</td>
	<td class="left">
	<input style="width:400px;" type="text" name="file_logic1"  id="file_logic1" value="<?php echo $list[3];?>">
	<a class="fl">选择文件
	<input type="file" name="file_logic"  id="file_logic">
	</a>
	*
	<a id="lj" onclick="return ajaxFileUpload2();">上传</a>
	*
	<a href="<?php echo $list[2];?>">下载</a>
	</td>
</tr>
<tr>
	<td class="right">额外策略文件：</td>
	<td class="left">
	<input style="width:400px;" type="text" name="file_other1"  id="file_other1" value="<?php echo $list[4];?>">
	<a class="fl">选择文件
	<input type="file" name="file_other"  id="file_other">
	</a>
	*
	<a style="cursor:pointer;color:#005197" id="ey" onclick="return ajaxFileUpload3();">上传</a>
	*
	<a href="<?php echo $list[3];?>">下载</a>
	</td>
</tr>
</table>
	<script type="text/javascript">
	function ajaxFileUpload()
	{
		//$aa=$('#'+name).val();
		//alert($aa);
		$("#loading")
		.ajaxStart(function(){
			$(this).show();
		})
		.ajaxComplete(function(){
			$(this).hide();
		});

		$.ajaxFileUpload
		(
			{
				url:'do_upload',
				secureuri:false,
				fileElementId:'drives',
				dataType: 'json',
				data:{'drives' : $('#drives').val()},
				success: function (data, status)
				{
					//$("#drives1").val() = data.data;
					$('#drives1').attr("value",data.data);
		            alert(data.msg);
				},
				error: function (data, status, e)
				{
					alert(e);
				}
			}
		)
		
		return false;

	}
	</script>
	
	<script type="text/javascript">
	function ajaxFileUpload2()
	{
		//$aa=$('#'+name).val();
		//alert($aa);
		$("#loading")
		.ajaxStart(function(){
			$(this).show();
		})
		.ajaxComplete(function(){
			$(this).hide();
		});

		$.ajaxFileUpload
		(
			{
				url:'do_upload',
				secureuri:false,
				fileElementId:'file_logic',
				dataType: 'json',
				data:{'file_logic' : $('#file_logic').val()},
				success: function (data, status)
				{
					$('#file_logic1').attr("value",data.data);
		            alert(data.msg);
				},
				error: function (data, status, e)
				{
					alert(e);
				}
			}
		)
		
		return false;

	}
	</script>
	
	<script type="text/javascript">
	function ajaxFileUpload3()
	{
		$("#loading")
		.ajaxStart(function(){
			$(this).show();
		})
		.ajaxComplete(function(){
			$(this).hide();
		});

		$.ajaxFileUpload
		(
			{
				url:'do_upload',
				secureuri:false,
				fileElementId:'file_other',
				dataType: 'json',
				data:{'file_other' : $('#file_other').val()},
				success: function (data, status)
				{
					$('#file_other1').attr("value",data.data);
		            alert(data.msg);
				},
				error: function (data, status, e)
				{
					alert(e);
				}
			}
		)
		return false;
	}
	</script>
<center>
<!--  	echo form_hidden("main[id]",$main['id']); -->
<!-- 	echo form_submit("submit","提交"); -->
<input type="submit" value="保存" />
<?php 
	echo form_close();
	echo form_fieldset_close();
?>
</center>
</form>