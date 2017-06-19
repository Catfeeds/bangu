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
	page=new jQuery.paging({renderTo:'#account_list',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/account/orderDate",form : '#listForm',// 绑定一个查询表单的ID
		columns : [{
				title : '<input type="checkbox" id="checkAll" style="left:0px;opacity: 1;top:-1px;margin:0;width:15px;height:15px;vertical-align: middle;"/>',
				width : '30',
				align : 'center',
				formatter : function(value,rowData, rowIndex) {
/* 				   var orderIds= $('input[name="orderIds"]').val();
					var orderArr=new Array();
					var html='';
					if(orderIds !=''){
						orderArr=orderIds.split(",");
				       if($.inArray(rowData.order_id,orderArr) ==-1){
				    	   html=' '; 
					    } else{
					    	 html='checked="checked" '; 
					    }             
			           return '<input name="order[]" type="checkbox" '+html+' style="left:5px;opacity: 1;" value="'+rowData.order_id+'" />';
					}else{
						return '<input name="order[]" type="checkbox" '+html+' style="left:5px;opacity: 1;" value="'+rowData.order_id+'" />';
					} */
					return '<input name="order[]" type="checkbox" style="left:5px;opacity: 1;" value="'+rowData.order_id+'" />';
				}
		      },
			{field : 'ordersn',title : '订单编号',width : '100',align : 'center',},
			{field : 'truename',title : '预定人',width : '100',align : 'center'},
			{ field : 'productname',title:'账产品标题',width : '150',align : 'center'},
			{field : 'people_num',title : '参团人数',width : '80',align : 'center'},
			{field : 'order_amount',title : '订单金额',align : 'center',sortable : true,width : '100'},
			{field : 'agent_fee',title : '管家佣金',align : 'center',sortable : true,width : '100',
				formatter : function(value,rowData, rowIndex){
					if(rowData.status>3){
						return rowData.agent_fee;
				    }else{
				    	return 0;
					}
				}
			},
			{field : 'a_rate',title : '平台使用费',align : 'center',sortable : true,width : '100',
				formatter : function(value,	rowData, rowIndex){
					if(rowData.status>3){
						return rowData.agent_rate;
				    }else{
				    	return 0;
					}
				}
			},
			{field : 'real_pay',title : '实付金额',align : 'center',sortable : true,width : '100',
				formatter : function(value,	rowData, rowIndex){
					if(rowData.status>3){
						return rowData.real_pay;
				    }else{
				    	return (rowData.real_pay-rowData.total_amount).toFixed(2);
					}
				}
			},
			{field : 'usedate',title : '出团日期',align : 'center', width : '100'},
			{field : 'addtime',title : '下单日期',align : 'center', width : '100'}
		
		]
	});
	
/* 	jQuery('#tab0').click(function(){
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#tab_content0').addClass('active');
		jQuery(this).parent().addClass('active');
		page.load({"status":"0"});
	});  */

	 $(function() {
         $("#checkAll").click(function() {
              $('input[name="order[]"]').attr("checked",this.checked); 
          });

      });

		
}); 
</script>	
	


