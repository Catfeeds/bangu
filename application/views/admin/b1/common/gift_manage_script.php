<!--Page Related Scripts-->
<link href="/assets/js/jQuery-plugin/paging/css/jquery.paging.css" rel="stylesheet" />
<script src="/assets/js/jquery-1.11.1.min.js"></script>
<script src="/assets/js/jQuery-plugin/paging/jquery-paging.js"></script>

		
<script type="text/javascript">
jQuery(document).ready(function(){
	/*未结算 */
	var page=null;

	// 查询
	jQuery("#searchfrom").click(function(){
		page.load({"status":"1"});
	});
	var data = '<?php echo $pageData; ?>';
	page=new jQuery.paging({renderTo:'#list',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/gift_manage/indexData",form : '#registrationForm',// 绑定一个查询表单的ID
		columns : [{
				title : '',
				width : '30',
				align : 'center',
				formatter : function(value,rowData, rowIndex) {
					return rowIndex+1;
				}
			},
			{field : 'gift_name',title : '礼品名称',width : '120',align : 'center'},
			{field : '',title : '图片',width : '150',align : 'center',
				formatter : function(value,	rowData, rowIndex){
					return '<span><img style="max-width:40px;"  src="'+rowData.logo+'" /></span>';
				}
			},
			{ field : 'worth',title:'价值',width : '80',align : 'center'},	
			{field : 'account',title : '数量',width : '80',align : 'center'},
			{field : 'starttime',title : '开始日期',align : 'center',sortable : true,width : '140'},
			{field : 'endtime',title : '结束日期',align : 'center',sortable : true,width : '140'},
			{field : '',title : '状态',align : 'center', width : '70',
				formatter : function(value,	rowData, rowIndex){
					if(rowData.status==0){
						return '上架';
					}else if(rowData.status==1){
						return '下架';				
					}else if(rowData.status==2){
						return '已过期';
					}
				}
			},
			{field : 'opera',title : '操作',align : 'center',width : '150',
				formatter : function(value,	rowData, rowIndex){
					if(rowData.status==1){
						var str= '上架';
						var strid=0;
					}else{
						var str= '下架';
						var strid=1;				
					}
					 var html='<a href="###" onclick="edit_gift(this)" data="'+rowData.id+'">编辑</a>';
					 html=html+'<a onclick="up_gift(this)" data="'+rowData.id+'" status="'+strid+'">'+str+'</a>';
					if(rowData.status==2){
						return '<a href="###" onclick="look_gift(this)" data="'+rowData.id+'" >查看</a><a onclick="del_gift(this,0);" data="'+rowData.id+'">删除</a>';
					 }else{
						return '<a href="###" onclick="look_gift(this)" data="'+rowData.id+'" >查看</a>'+html+'<a onclick="del_gift(this,0);" data="'+rowData.id+'">删除</a>';	
					 }
					
				} 
			}
		]
	});
	
	jQuery('#tab0').click(function(){
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#tab_content0').addClass('active');
		jQuery('#home').addClass('active');
		page.load({"status":"1"});
	}); 



	/*已发放 */
	var page1=null;
	function initTab1(){
	// 查询
		 jQuery("#searchfrom0").click(function(){
			page1.load({"status":"0"});
		});  
		var data1 = '';
		page1=new jQuery.paging({renderTo:'#list1',record:jQuery.parseJSON(data1),url : "<?php echo base_url()?>admin/b1/gift_manage/indexData0",form : '#registrationForm0',// 绑定一个查询表单的ID
			columns : [{
						title : '',
						width : '30',
						align : 'center',
						formatter : function(value,rowData, rowIndex) {
							return rowIndex+1;
						}
					},
					{field : 'linename',title : '线路名称',align : 'center',
						formatter : function(value,	rowData, rowIndex){
	
							//return '<a href="javascript:void(0)" class="line_detail" data="'+rowData.lineid+'"  >'+rowData.linename+'</a>';
							return '<a href="javascript:void(0)" onclick="show_line_detail('+rowData.lineid+',1)" data="'+rowData.lineid+'">'+rowData.linename+'</a>';
						}
							
					},
					{field : 'gift_name',title : '礼品名称',width : '120',align : 'center'},
					{field : '',title : '图片',width : '120',align : 'center',
						formatter : function(value,	rowData, rowIndex){
							return '<span><img style="max-width:40px;"  src="'+rowData.logo+'" /></span>';
						}
					},
					{ field : 'worth',title:'价值',width : '80',align : 'center'},	
					{field : 'gift_num',title : '剩余数量',align : 'center',sortable : true,width : '80'},
					{field : 'starttime',title : '开始日期',align : 'center',sortable : true,width : '140'},
					{field : 'endtime',title : '结束日期',align : 'center',sortable : true,width : '140'},
					{field : '',title : '状态',align : 'center', width : '70',
						formatter : function(value,	rowData, rowIndex){
							if(rowData.status==0){
								return '上架';
							}else if(rowData.status==1){
								return '下架';				
							}else if(rowData.status==2){
								return '已过期';
							}
						}
					},
					{field : 'opera',title : '操作',align : 'center',width : '90',
						formatter : function(value,	rowData, rowIndex){
							//<a href="###" onclick="look_line_gift(this)" data="'+rowData.id+'" >查看</a>&nbsp;&nbsp;
							return '<a href="###" onclick="look_line_gift(this)" data="'+rowData.gift_id+'" line="'+rowData.lineid+'" >查看</a><a onclick="del_line_gift(this,1);" data="'+rowData.id+'" >删除</a>';
						} 
					}
			]
		});
	}
	
	jQuery("#searchBtn1").click(function(){
			page1.load({"status":"0"});
		});
	
	 jQuery('#tab1').click(function(){
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#tab_content1').addClass('active');
		jQuery('#home0').addClass('active');
		if(null==page1){
			initTab1();
		}
		page1.load({"status":"0"});
	}); 

		
}); 
</script>	
	


