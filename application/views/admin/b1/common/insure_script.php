<!--Page Related Scripts-->
<script src="/assets/js/jQuery-plugin/paging/jquery-paging.js"></script>
<link href="/assets/js/jQuery-plugin/paging/css/jquery.paging.css" rel="stylesheet" />
<script type="text/javascript">
jQuery(document).ready(function(){
	/*未结算 */
	var page=null;
	// 查询
	jQuery("#btnSearch").click(function(){
		page.load({"status":"2"});
	});
	var data = '<?php echo $pageData; ?>';
	page=new jQuery.paging({renderTo:'#list',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/app_line/indexData",form : '#listForm',// 绑定一个查询表单的ID
		columns : [

			{field : 'id',title : '序号',width : '50',align : 'center'},
			{field : 'insurance_name',title : '保险名称',width : '100',align : 'center'},
			{ field : 'insurance_company',title:'保险公司',width : '100',align : 'center'},
			{field : 'insurance_date',title : '保险期限',width : '80',align : 'center'},
			{field : 'insurance_price',title : '售价',align : 'center',sortable : true,width : '80'},
			{field : '',title : '说明',align : 'center', width : '100',
				formatter : function(value,	rowData, rowIndex){	
					return rowData.description+'...';
					}
				},
			{field : '',title : '',align : 'center', width : '1',
				formatter : function(value,	rowData, rowIndex){	
					if(rowData.description!=''){					
						return '<div class="hide_info1 hide_info" style="position:relative;width:1px;display:none;"><div style="position:absolute;width:300px;min-height:40px;left:-60px;z-index:999;top:25px;background:#fff;border:2px solid #ccc;border-radius:4px;padding:10px;text-indent:0.5em;text-align:left;">'+rowData.description1+'</div></div>';
					}else{
						return '';
					}
				}
			},
			{field : 'simple_explain',title : '简要介绍',align : 'center', width : '100',
				formatter : function(value,	rowData, rowIndex){	
					return rowData.simple_explain+'...';
					}
			},
			{field : '',title : '',align : 'center', width : '1',
				formatter : function(value,	rowData, rowIndex){	
					if(rowData.simple_explain!=''){				
					   return '<div class="hide_info2 hide_info" style="position:relative;width:1px;display:none;"><div style="position:absolute;width:300px;min-height:40px;left:-60px;z-index:999;top:25px;background:#fff;border:2px solid #ccc;border-radius:4px;padding:10px;text-indent:0.5em;text-align:left;">'+rowData.simple_explain1+'</div></div>';
					}else{
						return '';
					}
				}
			},
			{field : 'insurance_clause',title : '保险条款',align : 'center', width : '100',
				formatter : function(value,	rowData, rowIndex){	
					return rowData.insurance_clause+'...';
					}
			},
			{field : '',title : '',align : 'center', width : '1',
				formatter : function(value,	rowData, rowIndex){	
					if(rowData.insurance_clause!=''){					
						return '<div class="hide_info3 hide_info" style="position:relative;width:1px;display:none;"><div style="position:absolute;width:300px;min-height:40px;left:-100px;z-index:999;top:25px;background:#fff;border:2px solid #ccc;border-radius:4px;padding:10px;text-indent:0.5em;text-align:left;">'+rowData.insurance_clause1+'</div></div>';
					}else{
						return '';
					}
				}
			},
			{field : '',title : '操作',align : 'center',width : '100',
				formatter : function(value,	rowData, rowIndex){					
					return '<a href="##" onclick="edit_insure('+rowData.id+');">修改</a> &nbsp;&nbsp;&nbsp;<a href="##" onclick="del_insure('+rowData.id+');">删除</a>';
				}
			}
		]
	});
	
}); 


 $(document).ready(function(){
	$(".hide_info1").parent().parent().prev().addClass("description_txt");
	$(".hide_info2").parent().parent().prev().addClass("simple_explain_txt");
	$(".hide_info3").parent().parent().prev().addClass("insurance_clause_txt");
/* 	$(".description_txt,.simple_explain_txt,.insurance_clause_txt").hover(function(){
		$(this).next().find(".hide_info").show();
	},function(){
		$(this).next().find(".hide_info").hide();
	}); */
	$('.x-grid-cell-inner').parent().hover(function(){
		$(this).next().find(".hide_info").show();
	},function(){
		$(this).next().find(".hide_info").hide();
	});
}); 


</script>	
	


