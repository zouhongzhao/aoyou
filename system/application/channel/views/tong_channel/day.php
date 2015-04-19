<link rel="stylesheet" type="text/css" media="screen" href="/jqgrid/themes/redmond/jquery-ui-1.8.2.custom.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/jqgrid/themes/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/jqgrid/themes/ui.multiselect.css" />
<!-- <script src="jqgrid/js/jquery.js" type="text/javascript"></script> -->
<script src="/jqgrid/js/jquery-ui-1.8.2.custom.min.js" type="text/javascript"></script>
<script src="/jqgrid/js/jquery.layout.js" type="text/javascript"></script>
<script src="/jqgrid/js/i18n/grid.locale-cn.js" type="text/javascript"></script>
<script type="text/javascript">
	$.jgrid.no_legacy_api = true;
	$.jgrid.useJSON = true;
</script>
<script src="/jqgrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>
<script src="/jqgrid/js/jquery.tablednd.js" type="text/javascript"></script>
<script src="/jqgrid/js/jquery.contextmenu.js" type="text/javascript"></script>
<script src="/jqgrid/js/ui.multiselect.js" type="text/javascript"></script>
<div class="mytheme1" align="left" >按日统计</div>
<table id="list10"></table> 
<div id="pager10" style="margin-left: 1%;margin-right: 1%;"></div> <br /> 
<table id="list10_d"></table> 
<div id="pager10_d" style="margin-left: 1%;margin-right: 1%;"></div>
<!--  <a href="javascript:void(0)" id="ms1">Get Selected id's</a> -->
<script type="text/javascript">
 jQuery("#list10").jqGrid({
	   	url:'m_day?q=1',
		datatype: "json",
		height: 'auto',
	   	colNames:['日期','激活数','收益'],
	   	colModel:[
	   		{name:'dates',index:'dates', width:250,align:"center"},
	   		{name:'activation',index:'activation', width:250, search:false,align:"center"},
	   		{name:'shouyis',index:'shouyis', width:250,search:false,align:"center"}	
	   	],
	   	rowNum:15,
	   	rowList:[15,30,45],
	   	pager: '#pager10',
	   	sortname: 'id',
	    viewrecords: true,
	    sortorder: "desc",
		multiselect: false,
		caption: "当日统计",
		onSelectRow: function(ids) {
			if(ids == null) {
				ids=0;
				if(jQuery("#list10_d").jqGrid('getGridParam','records') >0 )
				{
					jQuery("#list10_d").jqGrid('setGridParam',{url:'s_day?id='+ids,page:1});
					jQuery("#list10_d").jqGrid('setCaption',"当日详情: "+ids)
					.trigger('reloadGrid');
				}
			} else {
				jQuery("#list10_d").jqGrid('setGridParam',{url:'s_day?id='+ids,page:1});
				jQuery("#list10_d").jqGrid('setCaption',"当日详情: "+ids)
				.trigger('reloadGrid');			
			}
		}
	});
	jQuery("#list10").jqGrid('navGrid','#pager10',{add:false,edit:false,del:false});
	jQuery("#list10_d").jqGrid({
		height: 100,
	   	url:'s_day?q=1&id=0',
		datatype: "json",
	   	colNames:['下线','日期', '激活数','收益'],
	   	colModel:[
	   		{name:'main[u_id]',index:'u_id', width:100,align:"center"},
	   		{name:'main[dates]',index:'dates',search:false, width:150,align:"center"},
	   		{name:'main[activation]',index:'activation',search:false, width:150,align:"center"},
	   		{name:'main[shouyis]',index:'shouyis',search:false, width:150, align:"center"}
	   	],
	   	rowNum:5,
	   	rowList:[5,10,20],
	   	pager: '#pager10_d',
	   	sortname: 'item',
	    viewrecords: true,
	    sortorder: "asc",
		multiselect: true,
		editurl: 'day_save', // this is dummy existing url
		deleteurl: 'day_del', // this is dummy existing url
		caption:"当日详情"
	})
	jQuery("#list10_d").jqGrid('navGrid','#pager10_d',{add:false,edit:false,del:false});
	jQuery("#ms1").click( function() {
		var s;
		s = jQuery("#list10_d").jqGrid('getGridParam','selarrrow');
		alert(s);
	});
        
</script>