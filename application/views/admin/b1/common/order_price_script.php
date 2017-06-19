<!--Page Related Scripts-->
<script src="/assets/js/jQuery-plugin/paging/jquery-paging.js"></script>
<link href="/assets/js/jQuery-plugin/paging/css/jquery.paging.css" rel="stylesheet" />
<script type="text/javascript">
jQuery(document).ready(function(){
	/*申请中*/
	var page=null;
	// 查询
	jQuery("#btnSearch").click(function(){
		page.load({"status":"0"});
	});
	var data = '<?php echo $pageData; ?>';
	page=new jQuery.paging({renderTo:'#list',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/order_price/indexData",form : '#listForm',// 绑定一个查询表单的ID
		columns : [
		   	{title : '',width : '30',align : 'center',
				formatter : function(value,rowData, rowIndex) {
					return rowIndex+1;
				}
			},
			{field : 'ordersn',title : '订单编号',width : '80',align : 'center',position : 'relative'},
			{field : 'nickname',title : '管家昵称',width : '80',align : 'center'},
			{ field : 'productname',title:'产品标题',width : '240',align : 'left',
				formatter : function(value,	rowData, rowIndex){

					return '<a href="javascript:void(0)" onclick="show_line_detail('+rowData.line_id+',1)" data="'+rowData.line_id+'" >'+rowData.productname+'</a>';
				}
   
			},
			{field : 'usedate',title : '出团日期',width : '80',align : 'center'},
			{field : 'before_price',title : '订单修改前价格',align : 'center', width : '80'},
			{field : 'after_price',title : '修改后价格',align : 'center', width : '80'},
			{field : 'expert_reason',title : '管家理由',align : 'center', width : '80'},
			{field : 'addtime',title : '申请时间',align : 'center', width : '80'},
			{field : '',title : '操作',align : 'center',width : '80',
				formatter : function(value,	rowData, rowIndex){
					return '<a href="##" name="look" onclick="look_div('+rowData.opid+')">通过</a>&nbsp;&nbsp;&nbsp;<a href="##" onclick="refuse_div('+rowData.opid+')" >拒绝</a>';					
				}
			}
		]
	});

	jQuery('#tab1').click(function(){
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#home1').addClass('active');
		jQuery(this).parent().addClass('active');
		page.load({"status":"0"});
	});
	/*合作中*/
	var page1=null;
	function initTab1(){
	// 查询
	 jQuery("#btnSearch1").click(function(){
		page1.load({"status":"1"});
	});
	var data = '<?php echo $pageData; ?>';
	page1=new jQuery.paging({renderTo:'#list1',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/order_price/indexData",form : '#listForm1',// 绑定一个查询表单的ID
		columns : [
				   	{title : '',width : '30',align : 'center',
						formatter : function(value,rowData, rowIndex) {
							return rowIndex+1;
						}
					},
					{field : 'ordersn',title : '订单编号',width : '80',align : 'center',position : 'relative'},
					{field : 'nickname',title : '管家昵称',width : '80',align : 'center'},
					{ field : 'productname',title:'产品标题',width : '150',align : 'center',
						formatter : function(value,	rowData, rowIndex){
							return '<a href="javascript:void(0)" onclick="show_line_detail('+rowData.line_id+',1)"  data="'+rowData.line_id+'" >'+rowData.productname+'</a>';
						}
					},
					{field : 'usedate',title : '出团日期',width : '80',align : 'center'},
					{field : 'before_price',title : '订单修改前价格',align : 'center', width : '80'},
					{field : 'after_price',title : '修改后价格',align : 'center', width : '80'},
					{field : 'expert_reason',title : '管家理由',align : 'center', width : '80'},
					{field : 'addtime',title : '申请时间',align : 'center', width : '80'},
					{field : 'supplier_reason',title : '供应商理由',align : 'center', width : '80'}
				]
		});
	}
	jQuery('#tab2').click(function(){
	
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#home2').addClass('active');
		jQuery(this).parent().addClass('active');
		if(null==page1){
			initTab1();
		}
		page1.load({"status":"1"});
	});
	/*已拒绝*/
	var page2=null;
	function initTab2(){
	// 查询
	 jQuery("#btnSearch2").click(function(){
		page2.load({"status":"2"});
	});
	var data = '<?php echo $pageData; ?>';
	page2=new jQuery.paging({renderTo:'#list2',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/order_price/indexData",form : '#listForm2',// 绑定一个查询表单的ID
		columns : [
				   	{title : '',width : '30',align : 'center',
						formatter : function(value,rowData, rowIndex) {
							return rowIndex+1;
						}
					},
					{field : 'ordersn',title : '订单编号',width : '80',align : 'center',position : 'relative'},
					{field : 'nickname',title : '管家昵称',width : '80',align : 'center'},
					{ field : 'productname',title:'产品标题',width : '150',align : 'center',
						formatter : function(value,	rowData, rowIndex){

							return '<a href="javascript:void(0)" onclick="show_line_detail('+rowData.line_id+',1)"  data="'+rowData.line_id+'" >'+rowData.productname+'</a>';
						}  
					},
					{field : 'usedate',title : '出团日期',width : '80',align : 'center'},
					{field : 'before_price',title : '订单修改前价格',align : 'center', width : '80'},
					{field : 'after_price',title : '修改后价格',align : 'center', width : '80'},
					{field : 'expert_reason',title : '管家理由',align : 'center', width : '80'},
					{field : 'addtime',title : '申请时间',align : 'center', width : '80'},
					{field : 'supplier_reason',title : '供应商理由',align : 'center', width : '80'}
				]
		});
	}
	jQuery('#tab3').click(function(){
	
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#home3').addClass('active');
		jQuery(this).parent().addClass('active');
		if(null==page2){
			initTab2();
		}
		page2.load({"status":"2"});
	});

});
</script>




