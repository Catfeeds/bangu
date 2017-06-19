<style type="text/css">
	.col-lg-4 { float: left;}
	.form-horizontal .control-label{ padding-top: 0px; line-height: 34px;}
</style>
<!-- Page Breadcrumb -->
<div class="page-breadcrumbs">
	<ul class="breadcrumb">
		<li><i class="fa fa-home"></i> <a
			href="/admin/b1/view">首页</a></li>
		<li class="active">供应商后台</li>
		<li class="active">B端结算管理</li>
	</ul>
</div>
<!-- /Page Breadcrumb -->
<div class="widget flat radius-bordered">
	<div class="widget-body">
		<div class="widget-main ">
			<div class="tabbable">
				<ul id="myTab11" class="nav nav-tabs tabs-flat">
					<li class="active" name="tabs">
						<a href="#home11" data-toggle="tab" id="tab0"> 申请中</a></li>
					<li class="" name="tabs">
						<a href="#profile11" data-toggle="tab" id="tab1"> 已结算 </a></li>
					<li class="" name="tabs">
						<a href="#profile12" data-toggle="tab" id="tab2"> 已拒绝 </a></li>
				</ul>
				<div class="tab-content tabs-flat">
					<!-- 未结算 -->
					<div class="tab-pane active" id="tab_content0">
						<div class="widget-body">
							<div id="registration-form">
								<form
									data-bv-feedbackicons-validating="glyphicon glyphicon-refresh"
									data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
									data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
									data-bv-message="This value is not valid"
									class="form-horizontal bv-form" method="post" id="listForm"
									novalidate="novalidate">
									<div class="form-group has-feedback">
										<label class="col-lg-4 control-label" style="width:auto">结算日期：</label>
										<div class="col-lg-4" style="width:20%;">
										 	<div class="input-group">
												<span class="input-group-addon"> <i class="fa fa-calendar">
												</i>
												</span> <input type="text"  placeholder="结算日期" class="form-control"
													id="reservation" name="line_time">
											</div> 
										</div>

										<label class="col-lg-4 control-label" style="width: 2%;">&nbsp;</label>
										<div class="col-lg-4" style="width: 5%;">
											<input type="button" value="搜索" id="searchBtn" class="btn btn-palegreen">
										</div>
									</div>
								</form>
								<div style="margin-bottom: 10px;">   <a target="_blank" 
                                     href="<?php echo base_url();?>admin/b1/b_account/account_list/show_supplier_add_order"><input type="button" value="新建结算单" id="searchBtn" class="btn btn-palegreen"></a></div>		
								<div id="list"></div>
							</div>
						</div>
					</div>

					<!-- 已结算 -->
					<div class="tab-pane" id="tab_content1">
						<div class="widget-body">
							<div id="registration-form">
								<form
									data-bv-feedbackicons-validating="glyphicon glyphicon-refresh"
									data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
									data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
									data-bv-message="This value is not valid"
									class="form-horizontal bv-form" method="post" id="list1Form"
									novalidate="novalidate">
									<div class="form-group has-feedback">
										<label class="col-lg-4 control-label" style="width:auto">结算日期：</label>
										<div class="col-lg-4" style="width:18%">
											<div class="input-group">
												<span class="input-group-addon"> <i class="fa fa-calendar">
												</i>
												</span> <input type="text"  placeholder="结算日期" class="form-control"
													id="reservation2" name="line_time">
											</div>
										</div>

										<label class="col-lg-4 control-label" style="width: 2%;">&nbsp;</label>
										<div class="col-lg-4" style="width: 5%;">
											<input type="button" value="搜索" class="btn btn-palegreen " id="searchBtn1">
										</div>
									</div>
								</form>

								<div id="list1"></div>
							</div>
						</div>
					</div>
					<!-- 已拒绝 -->
					<div class="tab-pane" id="tab_content2">
						<div class="widget-body">
							<div id="registration-form">
								<form
									data-bv-feedbackicons-validating="glyphicon glyphicon-refresh"
									data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
									data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
									data-bv-message="This value is not valid"
									class="form-horizontal bv-form" method="post" id="list2Form"
									novalidate="novalidate">
									<div class="form-group has-feedback">
										<label class="col-lg-4 control-label" style="width:auto">结算日期：</label>
										<div class="col-lg-4" style="width:18%">
											<div class="input-group">
												<span class="input-group-addon"> <i class="fa fa-calendar">
												</i>
												</span> <input type="text"  placeholder="结算日期" class="form-control"
													id="reservation2" name="line_time">
											</div>
										</div>

										<label class="col-lg-4 control-label" style="width: 2%;">&nbsp;</label>
										<div class="col-lg-4" style="width: 5%;">
											<input type="button" value="搜索" class="btn btn-palegreen " id="searchBtn2">
										</div>
									</div>
								</form>

								<div id="list2"></div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
<!-- 未结算弹出框 -->
<div style="display: none;" class="tbtsd">
	<div class="closetd" style="opacity: 0.2; padding:0 0 0 8px;font-size: 20px; font-weight: 800;">×</div>
	<div align="center" style="height:100%;">
		<div class="widget-body" style="height:100%;">
			<div id="registration-form" class="messages_show" style="height:90%;overflow-y:auto;overflow-x:hidden;margin-top:35px; ">
				<table class="table table-bordered table-hover money_table">
						<thead>
							<tr>
								<th class="account_money_width">订单号</th>
								<th class="account_money_width">产品标题</th>
								<th class="account_money_width">参团人数</th>
								<th class="account_money_width">订单金额</th>
								<th class="account_money_width">订单成本</th>
								<th class="account_money_width">已结算</th>
								<th class="account_money_width">出团日期</th>
								<th class="account_money_width">下单时间</th>
							</tr>
						</thead>
						<tbody id="account_detail">
						    <tr> 
						    </tr>
						</tbody>
					</table>
			</div>
		</div>
	</div>
</div>
<div class="bgsd" style="display: none;"></div>
<!-- 未结算弹出框结束 -->
<?php echo $this->load->view('admin/b1/common/time_script'); ?>

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
	page=new jQuery.paging({renderTo:'#list',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/b_account/account_list/indexData",form : '#listForm',// 绑定一个查询表单的ID
		columns : [
			{field : 'month_account_id',title : '结算单号',width : '80',align : 'center'},
			{field : 'addtime',title : '出账时间',width : '100',align : 'center'},
			{field : 'amount_money',title : '申请总额',align : 'center',sortable : true,width : '80'},
			{field : 'union_name',title : '旅行社名称',align : 'center', width : '80'},
			{field : 'remark',title : '说明',align : 'center', width : '100'},
			{field : '',title : '操作',align : 'center',width : '100',
				formatter : function(value,rowData, rowIndex){
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
		$.post("<?php echo base_url()?>admin/b1/b_account/account_list/ajax_detail", { data:data} , function(result) {
			html='';
			var result=eval("("+result+")");
		 	if(result.status==1){
		 		 $.each(result.data,function(n,value) {
		 			html=html+'<tr>';
		 			html=html+'<td>'+value.ordersn+'</td>';
		 			html=html+'<td>'+value.productname+'</td>';	
		 			html=html+'<td>'+value.joinnum+'</td>';
		 			html=html+'<td>'+value.total_price+'</td>';
					html=html+'<td>'+value.supplier_cost+'</td>';
					if(value.balance_money==null){
						html=html+'<td>'+value.balance_money+'</td>';
					}else{
						html=html+'<td>0</td>';	
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
		var data1 = '<?php echo $pageData1; ?>';
		page1=new jQuery.paging({renderTo:'#list1',record:jQuery.parseJSON(data1),url : "<?php echo base_url()?>admin/b1/b_account/account_list/indexData",form : '#list1Form',// 绑定一个查询表单的ID
			columns : [

				{field : 'month_account_id',title : '结算单号',width : '80',align : 'center'},
				{field : 'addtime',title : '出账时间',width : '100',align : 'center'},
				{field : 'amount_money',title : '申请总额',align : 'center',sortable : true,width : '80'},
				{field : 'real_amount',title : '实际总额',align : 'center',sortable : true,width : '80'},
				{field : 'union_name',title : '旅行社名称',align : 'center', width : '80'},
				{field : 'real_amount',title : '旅行社审核人',align : 'center', width : '80'},
				{field : 'admin_name',title : '平台审核人',align : 'center', width : '80'},
				{field : 'remark',title : '说明',align : 'center', width : '100'},
				{field : '',title : '操作',align : 'center',width : '100',
					formatter : function(value,	rowData, rowIndex){
						return '<a href="#" data="'+rowData.month_account_id+'" name="tbtd" >查看明细</a> ';
					}
				}
			]
		});
	}
	
	jQuery("#searchBtn1").click(function(){
		page1.load({"status":"3"});
	});
	
	 jQuery('#tab1').click(function(){
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#tab_content1').addClass('active');
		jQuery(this).parent().addClass('active');
		if(null==page1){
			initTab1();
		}
		page1.load({"status":"3"});
	}); 
	/*明细的弹窗*/
	 jQuery('#list1').on("click", 'a[name="tbtd"]',function(){
	 	$('#account_detail').html('');
		var data=jQuery(this).attr('data');
		$(".bgsd,.tbtsd").show();
		$(".closetd").click(function(e) {
		        $(".bgsd,.tbtsd").hide();
		});
		$.post("<?php echo base_url()?>admin/b1/b_account/account_list/ajax_detail", { data:data} , function(result) {	
			html='';
			var result=eval("("+result+")");
			if(result.status==1){
		 		 $.each(result.data,function(n,value) {
			 		html=html+'<tr>';
		 			html=html+'<td>'+value.ordersn+'</td>';
		 			html=html+'<td>'+value.productname+'</td>';	
		 			html=html+'<td>'+value.joinnum+'</td>';
		 			html=html+'<td>'+value.total_price+'</td>';
					html=html+'<td>'+value.supplier_cost+'</td>';
					if(value.balance_money==null){
						html=html+'<td>'+value.balance_money+'</td>';
					}else{
						html=html+'<td>0</td>';	
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
	/*已拒绝*/
	var page2=null;
	function initTab2(){
		// 查询
		page2=new jQuery.paging({renderTo:'#list2',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/b_account/account_list/indexData",form : '#list2Form',// 绑定一个查询表单的ID
			columns : [

				{field : 'month_account_id',title : '结算单号',width : '80',align : 'center'},
				{field : 'addtime',title : '出账时间',width : '100',align : 'center'},
				{field : 'amount_money',title : '申请总额',align : 'center',sortable : true,width : '80'},
				{field : 'real_amount',title : '实际总额',align : 'center',sortable : true,width : '80'},
				{field : 'union_name',title : '旅行社名称',align : 'center', width : '80'},
			/*	{field : 'real_amount',title : '旅行社审核人',align : 'center', width : '80'},
				{field : 'admin_name',title : '平台审核人',align : 'center', width : '80'},*/
				{field : 'remark',title : '说明',align : 'center', width : '100'},
				{field : '',title : '操作',align : 'center',width : '100',
					formatter : function(value,	rowData, rowIndex){
						return '<a href="#" data="'+rowData.month_account_id+'" name="tbtd" >查看明细</a> ';
					}
				}
			]
		});
	}
	
	jQuery("#searchBtn2").click(function(){
		page2.load({"status":"2"});
	});
	
	 jQuery('#tab2').click(function(){
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#tab_content2').addClass('active');
		jQuery(this).parent().addClass('active');
		if(null==page2){
			initTab2();
		}
		page2.load({"status":"2"});
	}); 
	/*明细的弹窗*/
	 jQuery('#list2').on("click", 'a[name="tbtd"]',function(){
	 	$('#account_detail').html('');
		var data=jQuery(this).attr('data');
		$(".bgsd,.tbtsd").show();
		$(".closetd").click(function(e) {
		        $(".bgsd,.tbtsd").hide();
		});
		$.post("<?php echo base_url()?>admin/b1/b_account/account_list/ajax_detail", { data:data} , function(result) {	
			html='';
			var result=eval("("+result+")");
			if(result.status==1){
		 		 $.each(result.data,function(n,value) {
			 		html=html+'<tr>';
		 			html=html+'<td>'+value.ordersn+'</td>';
		 			html=html+'<td>'+value.productname+'</td>';	
		 			html=html+'<td>'+value.joinnum+'</td>';
		 			html=html+'<td>'+value.total_price+'</td>';
					html=html+'<td>'+value.supplier_cost+'</td>';
					if(value.balance_money==null){
						html=html+'<td>0</td>';
					}else{
						html=html+'<td>'+value.balance_money+'</td>';	
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
