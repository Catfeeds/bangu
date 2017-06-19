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
	page=new jQuery.paging({renderTo:'#list',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/expert_upgrade/indexData",form : '#listForm',// 绑定一个查询表单的ID
		columns : [

		       		{field : 'line_title',title : '线路标题',width : '140',align : 'left',
		       			formatter : function(value,	rowData, rowIndex){
						return '<a href="javascript:void(0)" onclick="show_line_detail('+rowData.lid+',1)" data="'+rowData.lid+'">'+rowData.line_title+'</a>';
					}
		       		},
				{field : 'cityname',title : '出发地',width : '100',align : 'center'},
				{ field : 'agent_rate',title:'管家佣金',width : '70',align : 'center',
					formatter : function(value,	rowData, rowIndex){
						return rowData.agent_rate+'元';
					}
				},
				{field : 'expert_name',title : '管家名称',width : '70',align : 'center'},
				{field : 'apply_remark',title : '申请理由',align : 'center',sortable : true,width : '100'},
				{field : 'grade_before',title : '申请前级别',align : 'center', width : '80',
					formatter : function(value,	rowData, rowIndex){
						if(rowData.grade_before==1){
							return '管家';	
						}else if(rowData.grade_before==2){
							return '初级专家';	
						}else if(rowData.grade_before==3){
							return '中级专家';	
						}else if(rowData.grade_before==4){
							return '高级专家';
						}else  if(rowData.grade_before==5){
							return '明星专家';
						}else{
							return '管家';
						}
					}
				},
				{field : 'grade_after',title : '申请级别',align : 'center', width : '80',
					formatter : function(value,	rowData, rowIndex){
						if(rowData.grade_after==1){
							return '管家';	
						}else if(rowData.grade_after==2){
							return '初级专家';	
						}else if(rowData.grade_after==3){
							return '中级专家';	
						}else if(rowData.grade_after==4){
							return '高级专家';
						}else  if(rowData.grade_after==5){
							return '明星专家';
						}else{
							return '管家';
						}
					}
				},
				{field : '',title : '操作',align : 'center',width : '80',
					formatter : function(value,	rowData, rowIndex){
						return '<a href="##" onclick="look_div('+rowData.upgrade_id+')" >通过</a><a href="##" onclick="re_expert('+rowData.upgrade_id+')" >拒绝</a>';			
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
	page1=new jQuery.paging({renderTo:'#list1',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/expert_upgrade/indexData",form : '#listForm1',// 绑定一个查询表单的ID
		columns : [

		           	{field : 'line_title',title : '线路标题',width : '140',align : 'left',
		           		formatter : function(value,	rowData, rowIndex){
						return '<a href="javascript:void(0)" onclick="show_line_detail('+rowData.lid+',1)" data="'+rowData.lid+'">'+rowData.line_title+'</a>';
					}
		           	},
				{field : 'cityname',title : '出发地',width : '100',align : 'center'},
				{ field : 'agent_rate',title:'管家佣金',width : '70',align : 'center',
					formatter : function(value,	rowData, rowIndex){
						return rowData.agent_rate+'元';
					}
				},
				{field : 'expert_name',title : '管家名称',width : '70',align : 'center'},
				{field : 'apply_remark',title : '申请理由',align : 'center',sortable : true,width : '100'},
				{field : 'grade_before',title : '申请前级别',align : 'center', width : '80',
					formatter : function(value,	rowData, rowIndex){
						if(rowData.grade_before==1){
							return '管家';	
						}else if(rowData.grade_before==2){
							return '初级专家';	
						}else if(rowData.grade_before==3){
							return '中级专家';	
						}else if(rowData.grade_before==4){
							return '高级专家';
						}else  if(rowData.grade_before==5){
							return '明星专家';
						}else{
							return '管家';
						}
					}
				},
				{field : 'grade_after',title : '申请级别',align : 'center', width : '80',
					formatter : function(value,	rowData, rowIndex){
						if(rowData.grade_after==1){
							return '管家';	
						}else if(rowData.grade_after==2){
							return '初级专家';	
						}else if(rowData.grade_after==3){
							return '中级专家';	
						}else if(rowData.grade_after==4){
							return '高级专家';
						}else  if(rowData.grade_after==5){
							return '明星专家';
						}else{
							return '管家';
						}
					}
				}
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
	page2=new jQuery.paging({renderTo:'#list2',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/expert_upgrade/indexData",form : '#listForm2',// 绑定一个查询表单的ID
		columns : [
		       		{field : 'line_title',title : '线路标题',width : '140',align : 'left',
		       			formatter : function(value,	rowData, rowIndex){
						return '<a href="javascript:void(0)" onclick="show_line_detail('+rowData.lid+',1)" data="'+rowData.lid+'">'+rowData.line_title+'</a>';
					}
		       		},
				{field : 'cityname',title : '出发地',width : '100',align : 'center'},
				{ field : 'agent_rate',title:'管家佣金',width : '70',align : 'center',
					formatter : function(value,	rowData, rowIndex){
						return rowData.agent_rate+'元';
					}
				},
				{field : 'expert_name',title : '管家名称',width : '70',align : 'center'},
				{field : 'apply_remark',title : '申请理由',align : 'center',sortable : true,width : '100'},
				{field : 'grade_before',title : '申请前级别',align : 'center', width : '80',
					formatter : function(value,	rowData, rowIndex){
						if(rowData.grade_before==1){
							return '管家';	
						}else if(rowData.grade_before==2){
							return '初级专家';	
						}else if(rowData.grade_before==3){
							return '中级专家';	
						}else if(rowData.grade_before==4){
							return '高级专家';
						}else  if(rowData.grade_before==5){
							return '明星专家';
						}else{
							return '管家';
						}
					}
				},
				{field : 'grade_after',title : '申请级别',align : 'center', width : '80',
					formatter : function(value,	rowData, rowIndex){
						if(rowData.grade_after==1){
							return '管家';	
						}else if(rowData.grade_after==2){
							return '初级专家';	
						}else if(rowData.grade_after==3){
							return '中级专家';	
						}else if(rowData.grade_after==4){
							return '高级专家';
						}else  if(rowData.grade_after==5){
							return '明星专家';
						}else{
							return '管家';
						}
					}
				}
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

	/*解除*/
	var page3=null;
	function initTab3(){
	// 查询
	 jQuery("#btnSearch3").click(function(){
		page3.load({"status":"-2"});
	});
	var data = '<?php echo $pageData; ?>';
	page3=new jQuery.paging({renderTo:'#list3',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/expert_upgrade/indexData",form : '#listForm3',// 绑定一个查询表单的ID
		columns : [

		       		{field : 'line_title',title : '线路标题',width : '140',align : 'left',
		       			formatter : function(value,	rowData, rowIndex){
						return '<a href="javascript:void(0)" onclick="show_line_detail('+rowData.lid+',1)" data="'+rowData.lid+'">'+rowData.line_title+'</a>';
					}
		       		},
				{field : 'cityname',title : '出发地',width : '100',align : 'center'},
				{ field : 'agent_rate',title:'管家佣金',width : '70',align : 'center',
					formatter : function(value,	rowData, rowIndex){
						return rowData.agent_rate+'元';
					}
				},
				{field : 'expert_name',title : '管家名称',width : '70',align : 'center'},
				{field : 'supplier_reason',title : '拒绝理由',align : 'center',sortable : true,width : '100',
					formatter : function(value,	rowData, rowIndex){
						if(rowData.refuse_remark==''){
                                                                           return rowData.supplier_reason;
						}else{
							return rowData.refuse_remark;
						}
					}

				},
				{field : 'grade_before',title : '申请前级别',align : 'center', width : '80',
					formatter : function(value,	rowData, rowIndex){
						if(rowData.grade_before==1){
							return '管家';	
						}else if(rowData.grade_before==2){
							return '初级专家';	
						}else if(rowData.grade_before==3){
							return '中级专家';	
						}else if(rowData.grade_before==4){
							return '高级专家';
						}else  if(rowData.grade_before==5){
							return '明星专家';
						}else{
							return '管家';
						}
					}
				},
				{field : 'grade_after',title : '申请级别',align : 'center', width : '80',
					formatter : function(value,	rowData, rowIndex){
						if(rowData.grade_after==1){
							return '管家';	
						}else if(rowData.grade_after==2){
							return '初级专家';	
						}else if(rowData.grade_after==3){
							return '中级专家';	
						}else if(rowData.grade_after==4){
							return '高级专家';
						}else  if(rowData.grade_after==5){
							return '明星专家';
						}else{
							return '管家';
						}
					}
				}
			]
		});
	}
	jQuery('#tab4').click(function(){
	
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#home4').addClass('active');
		jQuery(this).parent().addClass('active');
		if(null==page3){
			initTab3();
		}
		page3.load({"status":"-2"});
	});
});
</script>



