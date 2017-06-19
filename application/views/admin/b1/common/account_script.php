<!--Page Related Scripts-->
<script src="/assets/js/jQuery-plugin/paging/jquery-paging.js"></script>
<link href="/assets/js/jQuery-plugin/paging/css/jquery.paging.css" rel="stylesheet" />
<script type="text/javascript">
jQuery(document).ready(function(){
	/*未结算 */
	var page=null;

	// 查询
	jQuery("#searchBtn").click(function(){
		page.load({"status":"0"});
	});
	var data = '<?php echo $pageData; ?>';
	page=new jQuery.paging({renderTo:'#list',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/account/indexData",form : '#listForm',// 绑定一个查询表单的ID
		columns : [
			{field : 'month_account_id',title : '结算单号',width : '80',align : 'center'},
			{field : 'startdatetime',title : '账单期结算日期',width : '200',align : 'center',
				formatter : function(value,	rowData, rowIndex){
					return rowData.startdatetime+'至'+rowData.enddatetime;
				}
			},
			{field : 'addtime',title : '出账时间',width : '150',align : 'center'},
			{field : 'account_mode',title : '结算方式',align : 'center',sortable : true,width : '80'},
			{field : 'amount',title : '应付金额',align : 'center', width : '80'},
			{field : 'real_amount',title : '实付金额',align : 'center', width : '80'},
			{field : 'beizhu',title : '说明',align : 'center', width : '100'},
			{field : '',title : '操作',align : 'center',width : '100',
				formatter : function(value,	rowData, rowIndex){
					return '<a href="#" data="'+rowData.month_account_id+'" name="tbtd" >查看明细</a> ';
				}
			}
		]
	});
	
	jQuery('#tab0').click(function(){
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#tab_content0').addClass('active');
		jQuery(this).parent().addClass('active');
		page.load({"status":"0"});
	}); 

	/*明细的弹窗*/
	 jQuery('#list').on("click", 'a[name="tbtd"]',function(){
	 	$('#account_detail').html('');
		var data=jQuery(this).attr('data');
		$(".bgsd,.tbtsd").show();
		$(".closetd").click(function(e) {
		        $(".bgsd,.tbtsd").hide();
		});
		$.post("<?php echo base_url()?>admin/b1/account/ajax_detail", { data:data} , function(result) {
			html='';
			var result=eval("("+result+")");
		 	if(result.status==1){
		 		 $.each(result.data,function(n,value) {
		 			html=html+'<tr>';
		 			html=html+'<td>'+value.ordersn+'</td>';

		 			if(value.truename==null){  //预定人
		 				html=html+'<td></td>';
			 		}else{
			 			html=html+'<td>'+value.truename+'</td>';
				 	}
		 			html=html+'<td>'+value.productname+'</td>';	
		 			html=html+'<td>'+value.joinnum+'</td>';
		 			html=html+'<td>'+value.total_price+'</td>';
		 			if(value.status>3){
			 			if(value.agent_fee!=null){
				 			html=html+'<td>'+value.agent_fee+'</td>';
				 		}else{
				 			html=html+'<td>0</td>';
					 	}
			 		}else{
			 			html=html+'<td>0</td>';
				 	}
				 	if(value.status>3){
					 	if(value.a_rate!=null){
					 		html=html+'<td>'+value.a_rate+'</td>';
						}else{
						 	html=html+'<td>0</td>';
						}
					 }else{
						html=html+'<td>0</td>';
					 }
		 			 if(value.status>3){
		 				html=html+'<td>'+(value.real_free)+'</td>';
			 		}else{
			 			html=html+'<td>'+(value.real_free-value.total_amount).toFixed(2)+'</td>';
				 	}
		 			html=html+'<td>'+value.usedate+'</td>';
		 			html=html+'<td>'+value.addtime+'</td>';
		 			html=html+'</tr>';
			 	 });
			 	$('#account_detail').append(html);
			}else{
				alert('暂无通告！');		
			} 
		  
		});
			
	}); 

	/*已结算 */
	var page1=null;
	function initTab1(){
	// 查询
		/* jQuery("#searchBtn1").click(function(){
			page1.load({"status":"1"});
		});  */
		var data1 = '<?php echo $pageData1; ?>';
		page1=new jQuery.paging({renderTo:'#list1',record:jQuery.parseJSON(data1),url : "<?php echo base_url()?>admin/b1/account/indexData1",form : '#list1Form',// 绑定一个查询表单的ID
			columns : [
				{field : 'month_account_id',title : '结算单号',width : '80',align : 'center'},
				{field : 'ordersn',title : '流水号',width : '150',align : 'center'},
				{field : 'startdatetime',title : '账单期结算日期开始',width : '150',align : 'center'},
				{ field : 'enddatetime',title:'账单期结算日期结束',width : '150',align : 'center'},
				{field : 'addtime',title : '出账时间',width : '150',align : 'center'},
				{field : 'account_mode',title : '结算方式',align : 'center',sortable : true,width : '50'},
				{field : 'amount',title : '应付金额',align : 'center', width : '50'},
				{field : 'real_amount',title : '实付金额',align : 'center', width : '50'},
				{field : 'beizhu',title : '说明',align : 'center', width : '50'},
				{field : '',title : '操作',align : 'center',width : '100',
					formatter : function(value,	rowData, rowIndex){
						return '<a href="#" data="'+rowData.month_account_id+'" name="tbtd" >查看明细</a> ';
					}
				}
			]
		});
	}
	
	jQuery("#searchBtn1").click(function(){
		page1.load({"status":"1"});
	});
	
	 jQuery('#tab1').click(function(){
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#tab_content1').addClass('active');
		jQuery(this).parent().addClass('active');
		if(null==page1){
			initTab1();
		}
		page1.load({"status":"1"});
	}); 
	/*明细的弹窗*/
	 jQuery('#list1').on("click", 'a[name="tbtd"]',function(){
	 	$('#account_detail').html('');
		var data=jQuery(this).attr('data');
		$(".bgsd,.tbtsd").show();
		$(".closetd").click(function(e) {
		        $(".bgsd,.tbtsd").hide();
		});
		$.post("<?php echo base_url()?>admin/b1/account/ajax_detail", { data:data} , function(result) {	
			html='';
			var result=eval("("+result+")");
			if(result.status==1){
		 		 $.each(result.data,function(n,value) {
			 		if(value.agent_fee==null){
			 			value.agent_fee='';
				 	}
				 	if(value.real_free==null){
				 		value.real_free='';
					 }
		 			html=html+'<tr>';
		 			html=html+'<td>'+value.ordersn+'</td>';	
		 			//html=html+'<td>'+value.truename+'</td>';
		 			if(value.truename==null){  //预定人
		 				html=html+'<td></td>';
			 		}else{
			 			html=html+'<td>'+value.truename+'</td>';
				 	}
		 			html=html+'<td>'+value.productname+'</td>';	
		 			html=html+'<td>'+value.joinnum+'</td>';
		 			html=html+'<td>'+value.total_price+'</td>';
		 		//	html=html+'<td>'+value.agent_fee+'</td>';
		 		//	html=html+'<td>'+value.a_rate+'</td>';
		 		//	html=html+'<td>'+value.real_free+'</td>';
		 			if(value.status>3){
			 			if(value.agent_fee!=null){
				 			html=html+'<td>'+value.agent_fee+'</td>';
				 		}else{
				 			html=html+'<td>0</td>';
					 	}
			 		}else{
			 			html=html+'<td>0</td>';
				 	}
				 	if(value.status>3){
					 	if(value.a_rate!=null){
					 		html=html+'<td>'+value.a_rate+'</td>';
						}else{
						 	html=html+'<td>0</td>';
						}
					 }else{
						html=html+'<td>0</td>';
					 }
		 			 if(value.status>3){
		 				html=html+'<td>'+(value.real_free)+'</td>';
			 		}else{
			 			html=html+'<td>'+(value.real_free-value.f_amount).toFixed(2)+'</td>';
				 	}
					 	
		 			html=html+'<td>'+value.usedate+'</td>';
		 			html=html+'<td>'+value.addtime+'</td>';
		 			html=html+'</tr>';
			 	 });
			 	$('#account_detail').append(html);
			}else{
				alert('暂无通告！');		
			} 
		  
		});	
	});
		
}); 
</script>	
	

