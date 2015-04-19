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
<div class="mytheme1" align="left" >按月统计</div>
<table id="list10"></table> 
<div id="pager10" style="margin-left: 1%;margin-right: 1%;"></div> <br /> 
<table id="list10_d"></table> 
<div id="pager10_d" style="margin-left: 1%;margin-right: 1%;"></div>
<!--  <a href="javascript:void(0)" id="ms1">Get Selected id's</a> -->
<script type="text/javascript">
 jQuery("#list10").jqGrid({
	   	url:'m_day?q=2',
		datatype: "json",
		height: 'auto',
	   	colNames:['渠道名', '日期', '激活数','安装数','激活/安装比例','收益','所属专员'],
	   	colModel:[
	   		{name:'us_name',index:'us_name', width:90,search:false,align:"center"},
	   		{name:'dates',index:'dates', width:150,align:"center"},
	   		{name:'activations',index:'activations', width:150, search:false,align:"center"},
	   		{name:'install_nums',index:'install_nums', width:150, search:false,align:"center"},
	   		{name:'amount',index:'amount', width:150,search:false,sortable:false,align:"center"},
	   		{name:'shouyiss',index:'shouyiss', width:150,search:false,align:"center"},
	   		{name:'belongs_market',index:'belongs_market', width:150, align:"center"}	
	   	],
	   	rowNum:15,
	   	rowList:[15,30,45],
	   	pager: '#pager10',
	   	sortname: 'id',
	    viewrecords: true,
	    sortorder: "desc",
		multiselect: false,
		caption: "当月统计",
		onSelectRow: function(ids) {
			if(ids == null) {
				ids=0;
				if(jQuery("#list10_d").jqGrid('getGridParam','records') >0 )
				{
					jQuery("#list10_d").jqGrid('setGridParam',{url:'m_day?q=1&id='+ids,page:1});
					jQuery("#list10_d").jqGrid('setCaption',"当日详情: "+ids)
					.trigger('reloadGrid');
				}
			} else {
				jQuery("#list10_d").jqGrid('setGridParam',{url:'m_day?q=1&id='+ids,page:1});
				jQuery("#list10_d").jqGrid('setCaption',"当日详情: "+ids)
				.trigger('reloadGrid');			
			}
		}
	});
	jQuery("#list10").jqGrid('navGrid','#pager10',{add:false,edit:false,del:false});
	jQuery("#list10_d").jqGrid({
		//height: 100,
	   	url:'s_day?q=1&id=0',
		datatype: "json",
		height: 'auto',
	   	colNames:['渠道名', '日期', '激活数','安装数','激活/安装比例','收益','所属专员'],
	   	colModel:[
	   		{name:'us_name',index:'us_name', width:90,search:false,align:"center"},
	   		{name:'dates',index:'dates', width:100,align:"center"},
	   		{name:'activations',index:'activations', width:100, search:false,align:"center"},
	   		{name:'install_nums',index:'install_nums', width:100, search:false,align:"center"},
	   		{name:'amount',index:'amount', width:100,search:false,sortable:false,align:"center"},
	   		{name:'shouyiss',index:'shouyiss', width:100,search:false,align:"center"},
	   		{name:'belongs_market',index:'belongs_market', width:100, align:"center"}	
	   	],
	   	rowNum:10,
	   	rowList:[10,20,30],
	   	pager: '#pager10_d',
	   	sortname: 'id',
	    viewrecords: true,
	    sortorder: "asc",
		multiselect: true,
		caption:"当月详情"
	})
	jQuery("#list10_d").jqGrid('navGrid','#pager10_d',{add:false,edit:false,del:false,search:false});
	jQuery("#ms1").click( function() {
		var s;
		s = jQuery("#list10_d").jqGrid('getGridParam','selarrrow');
		alert(s);
	});
        
</script>