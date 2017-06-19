<!--Page Related Scripts-->
<script src="/assets/js/jQuery-plugin/paging/jquery-paging.js"></script>
<link href="/assets/js/jQuery-plugin/paging/css/jquery.paging.css" rel="stylesheet" />
<script type="text/javascript">
jQuery(document).ready(function(){
	/*未结算 */
	var page=null;

	// 查询
	jQuery("#searchBtn").click(function(){
		page.load();
	});
	var data = '<?php echo $pageData; ?>';
	page=new jQuery.paging({renderTo:'#list',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/travel_notes/indexData",form : '#listForm',// 绑定一个查询表单的ID
		columns : [{
				title : '',
				width : '30',
				align : 'center',
				formatter : function(value,rowData, rowIndex) {
					return rowIndex+1;
				}},
			{field : 'addtime',title : '发布时间',width : '140',align : 'center'},
			{field : 'title',title : '游记标题',align : 'left'},
			{ field : 'num',title:'参团人数',width : '80',align : 'center'},
			{field : 'name',title : '会员名称',width : '100',align : 'center'},
			{field : 'usedate',title : '出团日期',align : 'center',sortable : true,width : '80'},
			{field : 'moaddtime',title : '下单时间',align : 'center', width : '140'},
			{field : 'opera',title : '操作',align : 'center',width : '100',
				formatter : function(value,	rowData, rowIndex){
					if(rowData.opera=='可申诉'){
					   return '<a data="'+rowData.id+'" href="#" name="replay_data" member="'+rowData.memberid+'" >可申诉</a> ';
					}else{
						return rowData.opera;
					}
				} 
			}
		]
	});
	
	jQuery('#tab0').click(function(){
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#tab_content0').addClass('active');
		jQuery(this).parent().addClass('active');
		page.load();
	}); 



	/*已结算 */
	var page1=null;
	function initTab1(){
	// 查询
		/* jQuery("#searchBtn1").click(function(){
			page1.load({"status":"1"});
		});  */
		var data1 = '<?php echo $pageData1; ?>';
		page1=new jQuery.paging({renderTo:'#list1',record:jQuery.parseJSON(data1),url : "<?php echo base_url()?>admin/b1/travel_notes/indexData1",form : '#list1Form',// 绑定一个查询表单的ID
			columns : [{
				title : '',
				width : '30',
				align : 'center',
				formatter : function(value,rowData, rowIndex) {
					return rowIndex+1;
				}},
			{field : 'addtime',title : '发布时间',width : '140',align : 'center'},
			{field : 'title',title : '游记标题',align : 'center'},
			{ field : 'num',title:'参团人数',width : '80',align : 'center'},
			{field : 'name',title : '会员名称',width : '100',align : 'center'},
			{field : 'usedate',title : '出团日期',align : 'center',sortable : true,width : '80'},
			{field : 'moaddtime',title : '下单时间',align : 'center', width : '140'}
			/* {field : 'opera',title : '操作',align : 'center',width : '100',

			} */
		]
		});
	}
	
	jQuery("#searchBtn1").click(function(){
			page1.load();
		});
	
	 jQuery('#tab1').click(function(){
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#tab_content1').addClass('active');
		jQuery(this).parent().addClass('active');
		if(null==page1){
			initTab1();
		}
		page1.load();
	}); 

		
}); 
</script>	
	

