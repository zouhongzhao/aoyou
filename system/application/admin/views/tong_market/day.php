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
<div id="mysearch"></div>
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
	   	colNames:['ID','渠道名', '日期', '激活数','安装数','活跃台数','IP数','激活/安装比例','收益','所属专员'],
	   	colModel:[
	   		{name:'c_id',index:'c_id',search:false, width:55,align:"center"},
	   		{name:'us_name',index:'us_name', width:90,search:false,align:"center"},
	   		{name:'dates',index:'dates', width:100,align:"center"},
	   		{name:'activations',index:'activations', width:100, search:false,align:"center"},
	   		{name:'install_nums',index:'install_nums', width:100, search:false,align:"center"},		
	   		{name:'starts_nums',index:'starts_nums', width:100,search:false,align:"center"},
	   		{name:'ip_nums',index:'ip_nums',search:false, width:100,align:"center"},
	   		{name:'amount',index:'amount', width:100,search:false,sortable:false,align:"center"},
	   		{name:'shouyiss',index:'shouyiss', width:100,search:false,align:"center"},
	   		{name:'belongs_market',index:'belongs_market', width:100, align:"center"}	
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
	   	colNames:['经销商','日期', '激活数', '安装数','mac地址数','启动次数','IP数','收益'],
	   	colModel:[
	   		{name:'main[u_id]',index:'u_id', width:55,editable:true,align:"center"},
	   		{name:'main[dates]',index:'dates',search:false, width:100,align:"center",editable:true,editrules:{date:true}},
	   		{name:'main[activation]',index:'activation',search:false, width:100,editable:true, editrules:{number:true},align:"center"},
	   		{name:'main[install_num]',index:'install_num',search:false, width:100, editable:true,editrules:{number:true},align:"center"},	
	   		{name:'main[mac_num]',index:'mac_num',search:false, editable:true,editrules:{number:true},width:100,align:"center"},
	   		{name:'main[starts_num]',index:'starts_num',search:false, editable:true,editrules:{number:true},width:100,align:"center"},
	   		{name:'main[ip_num]',index:'ip_num',search:false, width:100,editable:true, editrules:{number:true},align:"center"},	
	   		{name:'main[shouyis]',index:'shouyis',search:false, width:100,editable:true,editrules:{number:true}, align:"center"}
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
	jQuery("#list10_d").jqGrid('navGrid','#pager10_d',{add:false,edit:true,del:true});
	jQuery("#ms1").click( function() {
		var s;
		s = jQuery("#list10_d").jqGrid('getGridParam','selarrrow');
		alert(s);
	});
        
</script>