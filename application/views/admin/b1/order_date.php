<link href="/assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />
<style type="text/css">
	.col-lg-4 { float: left;}
	.form-horizontal .control-label{ padding-top: 0px; line-height: 34px;}
	.registered_btn a{ padding:8px 4px; background: #2dc3e8;color: #fff; border-radius: 3px;  text-decoration: none}
	#myTab11{ margin-top: 20px;}
	#registration-form { padding-top:15px;}
	.pagination { padding-bottom:20px;}
</style>
<!-- Page Breadcrumb -->
<div class="page-breadcrumbs">
	<ul class="breadcrumb">
		<li><i class="fa fa-home"></i> <a
			href="/admin/b1/view">首页</a></li>
		<li class="active">供应商后台</li>
		<li class="active">订单转团</li>
	</ul>
</div>
<!-- /Page Breadcrumb -->

<div class="widget flat radius-bordered search_box">
	<div class="widget-body">
		<div class="widget-main ">
			<div class="tabbable">
			<!--  <span class="registered_btn"><a href="/admin/b1/app_line/registered_expert">注册直属管家</a></span> -->
				<ul id="myTab11" class="nav nav-tabs tabs-flat">
					<li class="active" name="tabs"><a href="#home11" data-toggle="tab" id="tab0"> 申请中 </a></li>
					<li class="" name="tabs"><a href="#home12" data-toggle="tab" id="tab1"> 已通过 </a></li>
					<li class="" name="tabs"><a href="#home13" data-toggle="tab" id="tab2"> 已拒绝 </a></li>
				</ul>
				<div class="tab-content tabs-flat">
					<!-- 申请中 -->
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
										<div class="fg_div" ><label class="col-lg-4 control-label" >线路编号</label>
										<div class="col-lg-4" style="width: 160px;">
											<input type="text" name="linecode"
												class="form-control user_name_b1">
										</div></div>
										<div class="fg_div" ><label class="col-lg-4 control-label" >线路名称：</label>
										<div class="col-lg-4" style="width: 160px;">
											<input type="text" name="linename"
												class="form-control user_name_b1">
										</div></div>
										<div class="fg_div" >
										<label class="col-lg-4 control-label"  style="width: 85px;padding-right:0px;">订单编号：</label></div>
										<div class="col-lg-4" style="width:auto;padding-left:2px;">
									       <input class="form-control user_name_b1" type="text" name="ordersn" >
										</div>	

										<div class="col-lg-4" style="width: 5%;padding-left:2px;">
											<input type="button" value="搜索" class="btn btn-palegreen" id="btnSearch">
										</div>					
									</div>
									

								</form>

								<div id="list"></div>
							</div>
						</div>
					</div>
					<!-- 已通过 -->
					<div class="tab-pane " id="tab_content1">
						<div class="widget-body">
							<div id="registration-form">
								<form
									data-bv-feedbackicons-validating="glyphicon glyphicon-refresh"
									data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
									data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
									data-bv-message="This value is not valid"
									class="form-horizontal bv-form" method="post" id="listForm1"
									novalidate="novalidate">
									<div class="form-group has-feedback">
									<div class="fg_div" ><label class="col-lg-4 control-label" >线路编号</label>
										<div class="col-lg-4" style="width: 160px;">
											<input type="text" name="linecode"
												class="form-control user_name_b1">
										</div></div>
									<div class="fg_div" ><label class="col-lg-4 control-label" >线路名称：</label>
									<div class="col-lg-4" style="width: 160px;">
										<input type="text" name="linename"
											class="form-control user_name_b1">
									</div></div>
									<div class="fg_div" >
									<label class="col-lg-4 control-label"  style="width: 85px;padding-right:0px;">订单编号：</label>
									<div class="col-lg-4" style="width:auto;padding-left:2px;">
									       <input class="form-control user_name_b1" type="text" name="ordersn" >
									</div>	</div>

										<div class="col-lg-4" style="width: 5%;padding-left:2px;">
											<input type="button" value="搜索" class="btn btn-palegreen" id="btnSearch1">
										</div>					
									</div>

								</form>

								<div id="list1"></div>
							</div>
						</div>
					</div>
					<!-- 已拒绝 -->
					<div class="tab-pane " id="tab_content2">
						<div class="widget-body">
							<div id="registration-form">
								<form
									data-bv-feedbackicons-validating="glyphicon glyphicon-refresh"
									data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
									data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
									data-bv-message="This value is not valid"
									class="form-horizontal bv-form" method="post" id="listForm2"
									novalidate="novalidate">
									<div class="form-group has-feedback " >
									<div class="fg_div" ><label class="col-lg-4 control-label" >线路编号</label>
										<div class="col-lg-4" style="width: 160px;">
											<input type="text" name="linecode"
												class="form-control user_name_b1">
										</div></div>
									<div class="fg_div" ><label class="col-lg-4 control-label" >线路名称：</label>
									<div class="col-lg-4" style="width: 160px;">
										<input type="text" name="linename"
											class="form-control user_name_b1">
									</div></div>
									<div class="fg_div" >
									<label class="col-lg-4 control-label"  style="width: 85px;padding-right:0px;">订单编号：</label>
									<div class="col-lg-4" style="width:auto;padding-left:2px;">
								       <input class="form-control user_name_b1" type="text" name="ordersn" >
									</div>	</div>

										<div class="col-lg-4" style="width: 5%;padding-left:2px;">
											<input type="button" value="搜索" class="btn btn-palegreen" id="btnSearch2">
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




<script src="/assets/js/jQuery-plugin/paging/jquery-paging.js"></script>
<link href="/assets/js/jQuery-plugin/paging/css/jquery.paging.css" rel="stylesheet" />
<!--线路详情-->
<?php echo $this->load->view('admin/common/line_detail_script'); ?>
<script type="text/javascript">

jQuery(document).ready(function(){
	/*申请中*/
	var page=null;
	// 查询
	jQuery("#btnSearch").click(function(){
		page.load({"status":"0"});
	});
	var data = '<?php echo $pageData; ?>';
	page=new jQuery.paging({renderTo:'#list',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/order_date/indexData",form : '#listForm',// 绑定一个查询表单的ID
		columns : [
		   	{title : '',width : '30',align : 'center',
				formatter : function(value,rowData, rowIndex) {
					return rowIndex+1;
				}
			},
			{field : 'ordersn',title : '订单编号',width : '80',align : 'center',position : 'relative'},
			{field : 'realname',title : '管家昵称',width : '80',align : 'center'},
			{ field : 'linename',title:'产品标题',width : '150',align : 'center',
				formatter : function(value,	rowData, rowIndex){

					return '<a href="javascript:void(0)" onclick="show_line_detail('+rowData.lid+',1)" data="'+rowData.lid+'">'+rowData.linename+'</a>';
				}
   
			},
			{field : 'usedate',title : '出团日期',width : '80',align : 'center'},
			{field : 'usedate1',title : '转团后出团日期',width : '80',align : 'center'  },
			{field : 'total_price0',title : '转团前的价格',align : 'center', width : '80'},
			//{field : 'order_price',title : '没有优惠价格',align : 'center', width : '80'},
			{field : 'return_price',title : '转团后价格',align : 'center', width : '80',
                         			 formatter : function(value,	rowData, rowIndex){
			                        if(rowData.diff_price==0){
			                          	return rowData.return_price;
			                          }else{
			                       		return rowData.return_price;	
			                          }				
				}

			},

			{field : '',title : '操作',align : 'center',width : '80',
				formatter : function(value,	rowData, rowIndex){
					return '<a href="##" name="look" onclick="return_order('+rowData.id+')">确认</a>&nbsp;&nbsp;<a href="##" name="look" onclick="dis_order('+rowData.diffid+','+rowData.id+')">拒绝</a>'; 					
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

	/*已通过 */
	var page1=null;
	function initTab1(){
	// 查询
	 jQuery("#btnSearch1").click(function(){
		page1.load({"status":"1"});
	});
	var data = '<?php echo $pageData; ?>';
	page1=new jQuery.paging({renderTo:'#list1',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/order_date/indexData",form : '#listForm1',// 绑定一个查询表单的ID
		columns : [
		   	{title : '',width : '30',align : 'center',
				formatter : function(value,rowData, rowIndex) {
					return rowIndex+1;
				}
			},
			{field : 'ordersn',title : '订单编号',width : '80',align : 'center',position : 'relative'},
			{field : 'realname',title : '管家昵称',width : '80',align : 'center'},
			{ field : 'linename',title:'产品标题',width : '150',align : 'center',
				formatter : function(value,	rowData, rowIndex){

					return '<a href="javascript:void(0)" onclick="show_line_detail('+rowData.lid+',1)" data="'+rowData.lid+'">'+rowData.linename+'</a>';
				}
   
			},
			{field : 'usedate',title : '出团日期',width : '80',align : 'center'},
			{field : 'old_price',title : '转团前的价格',align : 'center', width : '80'},
			{field : 'total_price',title : '转团后价格',align : 'center', width : '80'}

		]
		});
	}
 
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
	

	/*已取消 */
	var page2=null;
	function initTab2(){
	// 查询
		 jQuery("#btnSearch2").click(function(){
			page2.load({"status":"2"});
		});
		var data = '<?php echo $pageData; ?>';
		page2=new jQuery.paging({renderTo:'#list2',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/order_date/indexData",form : '#listForm2',// 绑定一个查询表单的ID
			columns : [
		   	{title : '',width : '30',align : 'center',
				formatter : function(value,rowData, rowIndex) {
					return rowIndex+1;
				}
			},
			{field : 'ordersn',title : '订单编号',width : '80',align : 'center',position : 'relative'},
			{field : 'realname',title : '管家昵称',width : '80',align : 'center'},
			{field : 'linename',title:'产品标题',width : '150',align : 'center',
				formatter : function(value,	rowData, rowIndex){
	
					return '<a href="javascript:void(0)"onclick="show_line_detail('+rowData.lid+',1)" data="'+rowData.lid+'">'+rowData.linename+'</a>';
				}
   
			},

			{field : 'usedate',title : '出团日期',width : '80',align : 'center'},
			{field : 'old_price',title : '转团前的价格',align : 'center', width : '80'},
			{field : 'total_price',title : '转团后价格',align : 'center', width : '80'}

		        ]
		});
	}

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
		

});
 //确认订单
 function return_order(id){
 	if (id>0) {
	         	$.post("<?php echo base_url()?>admin/b1/order_date/return_order_date", { id:id} , function(data) {
			if(data){		
			       data = eval('('+data+')');
			       if(data.status==1){
	                                       alert(data.msg);
	                                         location.reload();
			       }else{
	                                          alert(data.msg);
			       }			
			} 
		});
 	}else{
 	          alert('操作失败!');	
 	}
}
//拒绝订单转团
function  dis_order(id,orderid){
	if (id>0) {
	         	$.post("<?php echo base_url()?>admin/b1/order_date/dis_order_date", { id:id,orderid:orderid} , function(data) {
			if(data){		
			       data = eval('('+data+')');
			       if(data.status==1){
	                                       alert(data.msg);
	                                         location.reload();
			       }else{
	                                          alert(data.msg);
			       }			
			} 
		});
 	}else{
 	          alert('操作失败!');	
 	}
}

</script>
