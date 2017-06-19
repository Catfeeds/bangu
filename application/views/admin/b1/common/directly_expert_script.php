<!--Page Related Scripts-->
<script src="/assets/js/jQuery-plugin/paging/jquery-paging.js"></script>
<link href="/assets/js/jQuery-plugin/paging/css/jquery.paging.css" rel="stylesheet" />
<script type="text/javascript">
jQuery(document).ready(function(){
	/*申请中*/
	var page=null;
	// 查询
	jQuery("#btnSearch").click(function(){
		page.load({"status":"1"});
	});
	var data = '<?php echo $pageData; ?>';
	page=new jQuery.paging({renderTo:'#list',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/directly_expert/indexData",form : '#listForm',// 绑定一个查询表单的ID
		columns : [

			{field : 'realname',title : '管家姓名',width : '100',align : 'center',position : 'relative'},
			{field : 'mobile',title : '手机号',width : '100',align : 'center'},
			{ field : 'email',title:'邮箱号',width : '80',align : 'center'},
			{field : 'idcard',title : '身份证',width : '80',align : 'center'},
			{field : '',title : '所在地',align : 'center',sortable : true,width : '80',
				formatter : function(value,	rowData, rowIndex){
					return rowData.country+rowData.province+rowData.city;
				}
			},
			{field : 'addtime',title : '申请时间',align : 'center', width : '80'},
			{field : '',title : '操作',align : 'center',width : '80',
				formatter : function(value,	rowData, rowIndex){
					return '<a href="##" name="look" onclick="look_div('+rowData.expert_id+')" data="'+rowData.expert_id+'" >查看</a>';					
				}
			}
		]
	});

	jQuery('#tab1').click(function(){
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#home1').addClass('active');
		jQuery(this).parent().addClass('active');
		page.load({"status":"1"});
	});
	/*合作中*/
	var page1=null;
	function initTab1(){
	// 查询
	 jQuery("#btnSearch1").click(function(){
		page1.load({"status":"2"});
	});
	var data = '<?php echo $pageData; ?>';
	page1=new jQuery.paging({renderTo:'#list1',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/directly_expert/indexData",form : '#listForm1',// 绑定一个查询表单的ID
		columns : [

				{field : 'realname',title : '管家姓名',width : '100',align : 'center',position : 'relative'},
				{field : 'mobile',title : '手机号',width : '100',align : 'center'},
				{ field : 'email',title:'邮箱号',width : '80',align : 'center'},
				{field : 'idcard',title : '身份证',width : '80',align : 'center'},
				{field : '',title : '所在地',align : 'center',sortable : true,width : '80',
					formatter : function(value,	rowData, rowIndex){
						return rowData.country+rowData.province+rowData.city;
					}
				},
				{field : 'addtime',title : '申请时间',align : 'center', width : '80'},
				{field : '',title : '操作',align : 'center',width : '100',
					formatter : function(value,	rowData, rowIndex){
						return '<a href="##" onclick="look_div('+rowData.expert_id+')" >查看</a>&nbsp;&nbsp;&nbsp;<a href="##" onclick="stop_cooperation('+rowData.expert_id+')" >终止合作</a>';			
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
		page1.load({"status":"2"});
	});
	/*已拒绝*/
	var page2=null;
	function initTab2(){
	// 查询
	 jQuery("#btnSearch2").click(function(){
		page2.load({"status":"3"});
	});
	var data = '<?php echo $pageData; ?>';
	page2=new jQuery.paging({renderTo:'#list2',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/directly_expert/indexData",form : '#listForm2',// 绑定一个查询表单的ID
		columns : [

				{field : 'realname',title : '管家姓名',width : '100',align : 'center',position : 'relative'},
				{field : 'mobile',title : '手机号',width : '100',align : 'center'},
				{field : 'email',title:'邮箱号',width : '80',align : 'center'},
				{field : 'idcard',title : '身份证',width : '80',align : 'center'},
				{field : '',title : '所在地',align : 'center',sortable : true,width : '80',
					formatter : function(value,rowData, rowIndex){
						return rowData.country+rowData.province+rowData.city;
					}
				},
				{field : 'addtime',title : '申请时间',align : 'center', width : '80'},
				{field : '',title : '操作',align : 'center',width : '100',
					formatter : function(value,rowData, rowIndex){
						return '<a href="##" name="look" onclick="look_div('+rowData.expert_id+')" data="'+rowData.expert_id+'" >查看</a>';					
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
		page2.load({"status":"3"});
	});

	/*解除*/
	var page3=null;
	function initTab3(){
	// 查询
	 jQuery("#btnSearch3").click(function(){
		page3.load({"status":"-1"});
	});
	var data = '<?php echo $pageData; ?>';
	page3=new jQuery.paging({renderTo:'#list3',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/directly_expert/indexData",form : '#listForm3',// 绑定一个查询表单的ID
		columns : [

				{field : 'realname',title : '管家姓名',width : '100',align : 'center',position : 'relative'},
				{field : 'mobile',title : '手机号',width : '100',align : 'center'},
				{ field : 'email',title:'邮箱号',width : '80',align : 'center'},
				{field : 'idcard',title : '身份证',width : '80',align : 'center'},
				{field : '',title : '所在地',align : 'center',sortable : true,width : '80',
					formatter : function(value,	rowData, rowIndex){
						return rowData.country+rowData.province+rowData.city;
					}
				},
				{field : 'addtime',title : '申请时间',align : 'center', width : '80'},
			/*	{field : '',title : '操作',align : 'center',width : '100',
					formatter : function(value,	rowData, rowIndex){
						return '<a href="##" name="look" onclick="look_div('+rowData.expert_id+')" data="'+rowData.expert_id+'" >查看</a>';							
					}
				}*/
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
		page3.load({"status":"-1"});
	});
});
</script>



