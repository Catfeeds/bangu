<script src="/assets/js/jQuery-plugin/paging/jquery-paging.js"></script>
<link href="/assets/js/jQuery-plugin/paging/css/jquery.paging.css" rel="stylesheet" />
<script type="text/javascript">
jQuery(document).ready(function(){
	/*已保存 */
	var page=null;
	// 查询
	jQuery("#searchBtn0").click(function(){
		page.load({"status":"0"});
	});
	var data = '<?php echo $pageData; ?>';
	page=new jQuery.paging({renderTo:'#list',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/opportunity/indexData",form : '#searchForm0',// 绑定一个查询表单的ID
		columns : [
					{field : 'id',title : '订单编号',width : '80',align : 'center'},
					{field : 'title',title : '主题',width : '100',align : 'left'},
					
					{field : 'address',title : '地点',width : '150',align : 'center'},
					{field : 'begintime',title : '报名开始时间',align : 'center',sortable : true,width : '100'},
					{field : 'endtime',title : '报名截止时间',align : 'center', width : '100'},
					{field : 'sponsor',title : '主办方',align : 'center', width : '100'},
					{field : 'people',title : '容纳人数',align : 'center', width : '80'},
					{field : '',title : '操作',align : 'center',width : '100',
						formatter : function(value,	rowData, rowIndex){
							
							return '<a href="javascript:void(0);" onclick="details('+rowData.id+' ,1)" >查看</a>&nbsp;&nbsp;<a href="javascript:void(0);"  onclick="show_details('+rowData.id+')">编辑</a>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="details('+rowData.id+' ,2)">发布</a>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="details('+rowData.id+' ,3)">删除</a>';
							
						}
					}
		]
	});
	
 	jQuery('#tab0').click(function(){
 		 $('input[name="tab"]').val('tab0');
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#home0').addClass('active');
		jQuery(this).parent().addClass('active');
		page.load({"status":"0"});
	}); 




	/*已发布 */
	var page1=null;
	function initTab1(){
	// 查询
	 jQuery("#searchBtn1").click(function(){
		page1.load({"status":"1"});
	});
	var data = '<?php echo $pageData; ?>';
	page1=new jQuery.paging({renderTo:'#list1',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/opportunity/indexData",form : '#searchForm1',// 绑定一个查询表单的ID
		columns : [
						{field : 'id',title : '订单编号',width : '80',align : 'center'},
						{field : 'title',title : '主题',width : '100',align : 'left'},
						
						{field : 'address',title : '地点',width : '150',align : 'center'},
						{field : 'begintime',title : '报名开始时间',align : 'center',sortable : true,width : '100'},
						{field : 'endtime',title : '报名截止时间',align : 'center', width : '100'},
						{field : 'sponsor',title : '主办方',align : 'center', width : '100'},
						{field : 'people',title : '容纳人数',align : 'center', width : '80'},
						{field : '',title : '操作',align : 'center',width : '100',
							formatter : function(value,	rowData, rowIndex){
								
									return '<a href="javascript:void(0);" onclick="details('+rowData.id+' ,1)" >查看</a>&nbsp;&nbsp;<a href="javascript:void(0);"  onclick="show_details('+rowData.id+')" >编辑</a>&nbsp;&nbsp;<a  href="javascript:void(0);" onclick="details('+rowData.id+' ,4)" >取消发布</a>';
								
							}
						}
				]
		});
	}
 
	 jQuery('#tab1').click(function(){
		 $('input[name="tab"]').val('tab1');
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#home1').addClass('active');
		jQuery(this).parent().addClass('active');
		if(null==page1){
			initTab1();
		}
		page1.load({"status":"1"});
	}); 
	

	/*已取消 */
	var page2=null;
	function initTab2(){
	// 查询
		 jQuery("#searchBtn2").click(function(){
			page2.load({"status":"2"});
		});
		var data = '<?php echo $pageData; ?>';
		page2=new jQuery.paging({renderTo:'#list2',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/opportunity/indexData",form : '#searchForm2',// 绑定一个查询表单的ID
			columns : [
						{field : 'id',title : '订单编号',width : '80',align : 'center'},
						{field : 'title',title : '主题',width : '100',align : 'left'},
						
						{field : 'address',title : '地点',width : '150',align : 'center'},
						{field : 'begintime',title : '报名开始时间',align : 'center',sortable : true,width : '100'},
						{field : 'endtime',title : '报名截止时间',align : 'center', width : '100'},
						{field : 'sponsor',title : '主办方',align : 'center', width : '100'},
						{field : 'people',title : '容纳人数',align : 'center', width : '80'},
						{field : '',title : '操作',align : 'center',width : '100',
							formatter : function(value,	rowData, rowIndex){
								
								return '<a  href="javascript:void(0);" onclick="details('+rowData.id+' ,1)">查看</a>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="details('+rowData.id+' ,3)">删除</a>';
								
							}
						}
					]
		});
	}

	 jQuery('#tab2').click(function(){
	     $('input[name="tab"]').val('tab2');
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#home2').addClass('active');
		jQuery(this).parent().addClass('active');
		if(null==page2){
			initTab2();
		}
		page2.load({"status":"2"});
	}); 
		

}); 

</script>



