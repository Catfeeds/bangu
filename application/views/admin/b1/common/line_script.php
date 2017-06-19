<!--Page Related Scripts-->
<script src="/assets/js/jQuery-plugin/paging/jquery-paging.js"></script>
<link href="/assets/js/jQuery-plugin/paging/css/jquery.paging.css" rel="stylesheet" />
<script type="text/javascript">
jQuery(document).ready(function(){
	var page=null;
	// 查询
	jQuery(".btn-palegreen").click(function(){
		page.load();
	});
	var data = '<?php echo $pageData; ?>';
	page=new jQuery.paging({renderTo:'#user_line',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/user_line/indexData",form : '#registrationForm',// 绑定一个查询表单的ID
		columns : [
		  //                {
				// title : '',
				// width : '30',
				// align : 'center',
		 	// 	formatter : function(value,rowData, rowIndex) {
		 	// 		return rowIndex+1;
				// }},

			{field : 'truename',title : '投诉人',width : '80',align : 'center'},
			{field : 'addtime',title : '投诉时间',width : '150',align : 'center'},
			{field : 'reason',title : '投诉内容',width : '200',align : 'left',
				formatter : function(value,rowData, rowIndex) {
					  return '<span title="'+rowData.reason+'">'+rowData.reason.substring(0,25)+'...</span>';
					}
				},
			{field : 'productname',title : '产品名称',align : 'left',sortable : true,width : '200',
					formatter : function(value,	rowData, rowIndex){
						   var url='<?php echo base_url()?>';
						   var cityArr=rowData.overcity.split(",");
						   var res=$.inArray("1", cityArr); 
						   if(res==-1){
                                                       // 将gn改为line,cj改为line,添加后缀.html
							       // url="/gn/"+rowData.lid;
                                                               url="/line/"+rowData.lid+".html";
							}else{
								   url="/line/"+rowData.lid+".html";
							} 
							return '<a href="'+url+'" target="_blank">'+rowData.productname+'</a>';
					}
			},
			{field : 'expert_name',title : '专家',align : 'center', width : '100'},
			{field : 'status',title : '状态',align : 'center', width : '80'},
			{field : 'mobile',title : '联系电话',align : 'center', width : '150'},
			{field : 'attachment',title : '附件',align : 'center', width : '150',
				formatter : function(value,rowData, rowIndex) {
					if(rowData.attachment!=''){
						return '<a href="'+rowData.attachment+'" >下载</a>'
					 }else{
						 return '无附件下载';
					  }
				}
			},
			{field : 'remark',title : '处理意见',align : 'left', width : '200',
				formatter : function(value,rowData, rowIndex) {
					  return '<span title="'+rowData.remark+'">'+rowData.remark.substring(0,25)+'...</span>';
				}
			},
			{field : 'supplier_reply',title : '供应商的回复',align : 'center', width : '150',
				formatter : function(value,rowData, rowIndex) {
				  return '<span title="'+rowData.supplier_reply+'">'+rowData.supplier_reply.substring(0,25)+'...</span>';
				}
			},
		 	{field : '',title : '操作',align : 'center', width : '60',
				formatter : function(value,rowData, rowIndex) { 
					return '<a href="#" data="'+rowData.id+'" name="reply" >回复</a>';
				}
			}

		]
	});


});


</script>

