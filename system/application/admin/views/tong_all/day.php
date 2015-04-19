<div class="mytheme1" align="left" >每天数据汇总   =>退出</div>
<table class="mytable">
	<tr>
		<th>日期</th>
		<th>活跃台数</th>
		<th>安装总数</th>
		<th>激活总数</th>
		<th>激活/安装比例</th>
	</tr>
	<?php foreach($list as  $k=>$v):?>
	<tr class="tr_center">
		<td><?php echo $v['dates'];?></td>
		<td><?php echo $v['starts_nums'];?></td>
		<td><?php echo $v['install_nums'];?></td>
		<td><?php echo $v['activations'];?></td>
		<td><?php if($v['install_nums']=='0') echo 0;else echo number_format($v['activations']/$v['install_nums'], 2, '.', '');?></td>		
		
	</tr>	
	<?php endforeach;?>
</table>
<div id="pagination">
<ul>
<?php echo $page_link;?>
</ul>
</div>
<script>
		$(function(){
			$('#cc').combogrid({
				panelWidth:450,
				value:'006',

				idField:'code',
				textField:'name',
				url:'datagrid_data.json',
				columns:[[
					{field:'code',title:'Code',width:60},
					{field:'name',title:'Name',width:100},
					{field:'addr',title:'Address',width:120},
					{field:'col4',title:'Col41',width:100}
				]]
			});
		});
		function reload(){
			$('#cc').combogrid('grid').datagrid('reload');
		}
		function setValue(){
			$('#cc').combogrid('setValue', '002');
		}
		function getValue(){
			var val = $('#cc').combogrid('getValue');
			alert(val);
		}
		function disable(){
			$('#cc').combogrid('disable');
		}
		function enable(){
			$('#cc').combogrid('enable');
		}
	</script>
	